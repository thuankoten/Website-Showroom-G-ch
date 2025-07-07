<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../connect.php';

if (!isset($_GET['code']) || empty($_GET['code'])) {
    echo "Không tìm thấy mã đơn hàng!";
    exit;
}

$order_code = mysqli_real_escape_string($conn, $_GET['code']);

// Lấy thông tin đơn hàng chính từ bảng 'orders'
$sql_order_main = "SELECT * FROM orders WHERE order_code = '$order_code' LIMIT 1";
$result_order_main = mysqli_query($conn, $sql_order_main);

if (!$result_order_main) {
    echo "Lỗi truy vấn đơn hàng chính: " . mysqli_error($conn);
    exit;
}

$customer_info = mysqli_fetch_assoc($result_order_main);

if (empty($customer_info)) {
    echo "Đơn hàng không tồn tại hoặc đã bị xóa!";
    exit;
}

$order_id = $customer_info['id']; // Lấy ID của đơn hàng chính

// Lấy chi tiết các sản phẩm của đơn hàng từ bảng 'order_items'
// Lấy product_id, quantity, price, discount_price, size
$sql_order_items = "SELECT product_id, quantity, price, discount_price, size FROM order_items WHERE order_id = $order_id";
$result_order_items = mysqli_query($conn, $sql_order_items);

if (!$result_order_items) {
    echo "Lỗi truy vấn chi tiết sản phẩm đơn hàng: " . mysqli_error($conn);
    exit;
}

$order_items = [];
while ($row = mysqli_fetch_assoc($result_order_items)) {
    $order_items[] = $row;
}

// Lấy thông tin sản phẩm (tên, ảnh) từ bảng 'sanpham' dựa vào product_id
$product_details_map = []; // Map product_id to name and image
if (!empty($order_items)) {
    $product_ids = array_column($order_items, 'product_id');
    $unique_product_ids = array_unique($product_ids);
    
    if (!empty($unique_product_ids)) {
        $ids_string = implode(',', $unique_product_ids);

        // ĐÃ SỬA: Tên cột từ `id` thành `sanpham_id` và `tensanpham` thành `ten_sanpham`
        $sql_products = "SELECT sanpham_id, ten_sanpham, image FROM sanpham WHERE sanpham_id IN ($ids_string)";
        
        // Debug: In ra câu lệnh SQL để kiểm tra
        // echo '<pre>SQL Query for Products: ';
        // echo htmlspecialchars($sql_products);
        // echo '</pre>';

        $result_products = mysqli_query($conn, $sql_products);

        if (!$result_products) {
            echo "Lỗi truy vấn sản phẩm: " . mysqli_error($conn); // Hiển thị lỗi chi tiết từ MySQL
            // Có thể thêm exit; nếu bạn muốn dừng hẳn khi lỗi này xảy ra nghiêm trọng
            // exit; 
        } else {
            while ($row_product = mysqli_fetch_assoc($result_products)) {
                $image_data = 'images/placeholder.jpg';
                if ($row_product['image']) {
                    // Kiểm tra xem dữ liệu ảnh có phải là BLOB không
                    // Nếu là BLOB, base64_encode là đúng
                    // Nếu bạn lưu đường dẫn ảnh, thì $image_data = $row_product['image'];
                    $image_data = 'data:image/jpeg;base64,' . base64_encode($row_product['image']);
                }
                // ĐÃ SỬA: key của mảng là sanpham_id, và tên sản phẩm là ten_sanpham
                $product_details_map[$row_product['sanpham_id']] = [
                    'name' => htmlspecialchars($row_product['ten_sanpham']),
                    'image' => $image_data
                ];
            }
        }
    } else {
        // Trường hợp không có sản phẩm nào trong order_items có product_id hợp lệ
        error_log("No valid product IDs found in order_items for order code: " . $order_code);
    }
}


// Tính toán tổng tiền cho toàn bộ đơn hàng từ order_items
$total_amount_products = 0;
foreach ($order_items as $item) {
    $current_price = (int)$item['price']; 
    if (isset($item['discount_price']) && (int)$item['discount_price'] > 0) {
        $current_price = (int)$item['discount_price']; // Sử dụng giá khuyến mãi nếu có
    }
    $total_amount_products += ($current_price * (int)$item['quantity']);
}
$shipping_fee = 30000;
$grand_total = $total_amount_products + $shipping_fee;

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>✅ Xác nhận đơn hàng</title>
    <link rel="stylesheet" href="../foldercss/xacnhan.css">
</head>
<body>
    <div class="container">
        <h2>🎉 Đặt hàng thành công!</h2>
        <p>Mã đơn hàng của bạn là: <strong><?= htmlspecialchars($order_code) ?></strong></p>
        <p>Chúng tôi đã nhận được đơn hàng của bạn và sẽ xử lý sớm nhất có thể.</p>

        <div class="section">
            <h3>📦 Thông tin sản phẩm đã đặt</h3>
            <?php foreach ($order_items as $item): 
                // Lấy thông tin sản phẩm từ map dựa trên product_id
                $product_data = $product_details_map[$item['product_id']] ?? ['name' => 'Sản phẩm không rõ', 'image' => 'images/placeholder.jpg'];
                $product_name = $product_data['name'];
                $product_image = $product_data['image'];
                
                $displayed_price = (int)$item['price'];
                if (isset($item['discount_price']) && (int)$item['discount_price'] > 0) {
                    $displayed_price = (int)$item['discount_price'];
                }
                $subtotal_item = $displayed_price * (int)$item['quantity'];
            ?>
                <div class="product-info">
                    <img src="<?= $product_image ?>" alt="<?= $product_name ?>">
                    <div class="product-details">
                        <p><strong>Tên sản phẩm:</strong> <?= $product_name ?></p>
                        <p><strong>Số lượng:</strong> <?= (int)$item['quantity'] ?></p>
                        <p><strong>Giá mỗi sản phẩm:</strong> <?= number_format((int)$item['price']) ?> đ</p>
                        <?php if (isset($item['discount_price']) && (int)$item['discount_price'] > 0): ?>
                            <p><strong>Giá khuyến mãi:</strong> <?= number_format((int)$item['discount_price']) ?> đ</p>
                        <?php endif; ?>
                        <?php if (!empty($item['size'])): ?>
                            <p><strong>Kích thước:</strong> <?= htmlspecialchars($item['size']) ?></p>
                        <?php endif; ?>
                        <p><strong>Tổng phụ sản phẩm:</strong> <?= number_format($subtotal_item) ?> đ</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="section">
            <h3>👤 Thông tin khách hàng</h3>
            <p><strong>Họ tên:</strong> <?= htmlspecialchars($customer_info['full_name']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($customer_info['email']) ?></p>
            <p><strong>Điện thoại:</strong> <?= htmlspecialchars($customer_info['phone']) ?></p>
            <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($customer_info['address']) ?></p>
            <p><strong>Phương thức giao hàng:</strong> <?= htmlspecialchars($customer_info['delivery_method']) ?></p>
            <p><strong>Phương thức thanh toán:</strong> <?= htmlspecialchars($customer_info['payment_method']) ?></p>
            <p><strong>Ghi chú:</strong> <?= htmlspecialchars($customer_info['order_note']) ?: 'Không có' ?></p>
            <p><strong>Trạng thái:</strong> <?= htmlspecialchars($customer_info['status']) ?></p>
        </div>

        <div class="section summary-totals">
            <h3>💰 Tổng kết thanh toán</h3>
            <p>Tổng tiền hàng: <strong><?= number_format($total_amount_products) ?>đ</strong></p>
            <p>Phí vận chuyển: <strong><?= number_format($shipping_fee) ?>đ</strong></p>
            <p class="grand-total">Tổng cộng: <strong><?= number_format($grand_total) ?>đ</strong></p>
        </div>

        <p style="text-align: center; margin-top: 30px;">
            Cảm ơn bạn đã đặt hàng tại **Showroom Gạch**!
            <br>
            Chúng tôi sẽ liên hệ với bạn để xác nhận đơn hàng trong thời gian sớm nhất.
        </p>
    </div>
<div class="button-group-confirm">
            <a href="sanpham.php" class="btn btn-primary">🛍️ Mua thêm</a>
            <a href="index.php" class="btn btn-secondary">🏠 Về trang chủ</a>
        </div>
    </div> 
</body>
</html>