<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../connect.php';
$message = "";

function generateOrderCode() {
    return 'ODR' . rand(100000, 999999);
}

if (!$conn) {
    $message = "❌ Lỗi kết nối được CSDL: " . mysqli_connect_error();
    error_log("Database Connection Error in thanhtoan.php: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['full_name'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $address = htmlspecialchars(trim($_POST['address'] ?? ''));
    $delivery = htmlspecialchars(trim($_POST['delivery_method'] ?? ''));
    $raw_payment = htmlspecialchars(trim($_POST['payment_method'] ?? ''));
    $payment = ($raw_payment === 'Tiền mặt') ? 'Thanh toán khi nhận hàng' : $raw_payment;
    $note = htmlspecialchars(trim($_POST['order_note'] ?? ''));

    // Giả định user_id là 1 (hoặc lấy từ session nếu đã đăng nhập)
    $user_id = 1; // Thay thế bằng $_SESSION['user_id'] nếu có hệ thống đăng nhập
    $status = 'Đang chờ'; // Trạng thái ban đầu của đơn hàng

    // Debug để kiểm tra giá trị
    error_log("Debug - Delivery Method: $delivery");
    error_log("Debug - Payment Method: $payment");

    if (!preg_match("/^0\d{9}$/", $phone)) {
        $message = "❌ Số điện thoại phải có đúng 10 chữ số và bắt đầu bằng 0.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match("/@gmail\.com$/", $email)) {
        $message = "❌ Email không hợp lệ hoặc không phải địa chỉ Gmail.";
    } elseif (empty($_SESSION['cart'])) {
        $message = "❌ Giỏ hàng rỗng. Không thể đặt hàng.";
    } else {
        if (!$conn) {
            $message = "❌ Lỗi kết nối CSDL trước khi chuẩn bị truy vấn.";
        } else {
            $insertSuccess = true;
            $order_code = generateOrderCode();
            
            $conn->begin_transaction(); // Bắt đầu giao dịch

            // 1. Chèn thông tin đơn hàng chung vào bảng 'orders'
            $stmt_order = $conn->prepare("INSERT INTO orders
                (order_code, user_id, full_name, email, phone, address, delivery_method, payment_method, order_note, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            if (!$stmt_order) {
                $message = "❌ Lỗi chuẩn bị truy vấn đơn hàng chính: " . $conn->error;
                error_log("Prepare Error for orders table in thanhtoan.php: " . $conn->error);
                $insertSuccess = false;
            } else {
                // Ràng buộc tham số cho bảng orders
                $stmt_order->bind_param("sissssssss", 
                    $order_code, $user_id, $name, $email, $phone, $address, $delivery, $payment, $note, $status);
                
                if (!$stmt_order->execute()) {
                    $insertSuccess = false;
                    $message = "❌ Lỗi khi thêm đơn hàng chính: " . $stmt_order->error;
                    error_log("SQL Error inserting into orders table: " . $stmt_order->error);
                } else {
                    $order_id = $conn->insert_id; // Lấy ID của đơn hàng vừa tạo

                    // 2. Chèn chi tiết từng sản phẩm vào bảng 'order_items'
                    $stmt_item = $conn->prepare("INSERT INTO order_items
                        (order_id, product_id, quantity, price, discount_price, size)
                        VALUES (?, ?, ?, ?, ?, ?)");

                    if (!$stmt_item) {
                        $message = "❌ Lỗi chuẩn bị truy vấn chi tiết sản phẩm: " . $conn->error;
                        error_log("Prepare Error for order_items table in thanhtoan.php: " . $conn->error);
                        $insertSuccess = false;
                    } else {
                        foreach ($_SESSION['cart'] as $item) {
                            if (!isset($item['id']) || !isset($item['name']) || !isset($item['quantity']) || !isset($item['price'])) {
                                $message = "❌ Dữ liệu giỏ hàng không hợp lệ: Thiếu thông tin sản phẩm (ID, Name, Quantity, Price).";
                                $insertSuccess = false;
                                error_log("Cart Error in thanhtoan.php: Missing item data - " . json_encode($item));
                                break;
                            }
                            
                            $product_id = (int)$item['id'];
                            $quantity = (int)$item['quantity'];
                            $price_per_item = (int)$item['price'];
                            $discount_price = (int)($item['discount_price'] ?? 0);
                            $size = htmlspecialchars($item['size'] ?? '');

                            if ($quantity <= 0 || $price_per_item <= 0) {
                                $message = "❌ Số lượng hoặc giá sản phẩm {$item['name']} không hợp lệ.";
                                $insertSuccess = false;
                                error_log("Cart Error in thanhtoan.php: Invalid quantity ($quantity) or price ($price_per_item) for {$item['name']}");
                                break;
                            }

                            $stmt_item->bind_param("iiiiis", 
                                $order_id, $product_id, $quantity, $price_per_item, $discount_price, $size);

                            if (!$stmt_item->execute()) {
                                $insertSuccess = false;
                                $message = "❌ Lỗi khi thêm chi tiết sản phẩm {$item['name']}: " . $stmt_item->error;
                                error_log("SQL Error inserting into order_items table: " . $stmt_item->error . " | Product: {$item['name']}");
                                break;
                            }
                        }
                        $stmt_item->close();
                    }
                }
                $stmt_order->close();
            }

            if ($insertSuccess) {
                $conn->commit();
                unset($_SESSION['cart']);
                header("Location: xacnhan.php?code=" . urlencode($order_code));
                exit;
            } else {
                $conn->rollback();
            }
        }
    }
    
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Trang Thanh Toán</title>
    <link rel="stylesheet" href="../foldercss/style.css" type="text/css" />
    <link rel="stylesheet" href="../foldercss/thanhtoan.css" type="text/css" />
    <link rel="stylesheet" href="../foldercss/header-footer.css" type="text/css" />
    <script src="../jquery-3.7.1.js"></script>
    
    <script>
        function toggleBankInfo() {
            const bankInfo = document.getElementById('bank-info');
            const selected = document.querySelector('input[name="payment_method"]:checked');
            bankInfo.style.display = (selected && selected.value === 'Chuyển khoản ngân hàng') ? 'block' : 'none';
        }
        document.addEventListener('DOMContentLoaded', toggleBankInfo);
    </script>
</head>
<body>
<div class="container">
    <form class="checkout-form" method="POST">
        <h2>Thông tin giao hàng</h2>
        <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>

        <label for="full_name">Họ và tên:</label>
        <input type="text" id="full_name" name="full_name" value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" pattern=".+@gmail\.com" required>

        <label for="phone">Số điện thoại:</label>
        <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" pattern="^0\d{9}$" required>

        <label for="address">Địa chỉ:</label>
        <textarea id="address" name="address" required><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>

        <label>Phương thức giao hàng:</label>
        <div class="radio-group">
            <label><input type="radio" name="delivery_method" value="Giao hàng tận nơi" <?= (($_POST['delivery_method'] ?? '') === 'Giao hàng tận nơi' || empty($_POST['delivery_method'])) ? 'checked' : '' ?> required> Giao hàng tận nơi</label>
            <label><input type="radio" name="delivery_method" value="Nhận tại cửa hàng" <?= (($_POST['delivery_method'] ?? '') === 'Nhận tại cửa hàng') ? 'checked' : '' ?>> Nhận tại cửa hàng</label>
        </div>

        <label>Phương thức thanh toán:</label>
        <div class="radio-group" onchange="toggleBankInfo()">
            <label><input type="radio" name="payment_method" value="Thanh toán khi nhận hàng" <?= (($_POST['payment_method'] ?? '') === 'Thanh toán khi nhận hàng' || empty($_POST['payment_method'])) ? 'checked' : '' ?> required> Thanh toán khi nhận hàng</label>
            <label><input type="radio" name="payment_method" value="Chuyển khoản ngân hàng" <?= (($_POST['payment_method'] ?? '') === 'Chuyển khoản ngân hàng') ? 'checked' : '' ?>> Chuyển khoản ngân hàng</label>
            <label><input type="radio" name="payment_method" value="Thẻ tín dụng/Ghi nợ" <?= (($_POST['payment_method'] ?? '') === 'Thẻ tín dụng/Ghi nợ') ? 'checked' : '' ?>> Thẻ tín dụng/Ghi nợ</label>
        </div>

        <div id="bank-info" style="display: none; margin-top: 10px;">
            <p>💳 Chủ tài khoản: Nguyễn Tấn Thuận</p>
            <p>🔢 Số tài khoản: 123456789</p>
            <p>🏦 Ngân hàng: Vietcombank</p>
            <p>📌 Nội dung: Thanh toán đơn hàng</p>
            <img src="images/qr_thanhtoan_demo.png" alt="QR Code" width="200">
        </div>

        <label for="order_note">Ghi chú đơn hàng:</label>
        <textarea id="order_note" name="order_note" placeholder="Nhập ghi chú nếu cần..."><?= htmlspecialchars($_POST['order_note'] ?? '') ?></textarea>

        <div class="button-group">
            <button type="button" onclick="window.history.back()">← Quay lại giỏ hàng</button>
            <button type="submit">✅ Đặt hàng</button>
        </div>
    </form>

    <div class="order-summary">
        <h3>🧱 Tóm tắt đơn hàng</h3>
        <?php
        $tongTienHang = 0; // Tổng tiền chỉ của các sản phẩm
        $phivanchuyen_display = 30000; // Phí vận chuyển hiển thị, chỉ tính một lần

        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                // Đảm bảo các key tồn tại
                $ten = htmlspecialchars($item['name'] ?? 'Sản phẩm không xác định');
                $gia = (int)($item['price'] ?? 0);
                $sl = (int)($item['quantity'] ?? 0);
                $image = htmlspecialchars($item['image'] ?? ''); // Giả định 'image' là base64 trong session

                if ($sl > 0 && $gia > 0) { // Chỉ tính các sản phẩm có số lượng và giá hợp lệ
                    $tamtinh_item = $gia * $sl;
                    $tongTienHang += $tamtinh_item; // Cộng dồn vào tổng tiền hàng
                    echo "<div class='product-item'>";
                    // Hiển thị ảnh, sử dụng base64 nếu có, hoặc ảnh placeholder
                    echo "<img src='data:image/jpeg;base64,$image' alt='$ten' onerror=\"this.src='images/placeholder.jpg'\">";
                    echo "<div class='product-details'>";
                    echo "<strong>$ten</strong><br>";
                    echo "Số lượng: $sl<br>";
                    echo "Giá: " . number_format($gia) . "đ<br>";
                    echo "</div>";
                    echo "</div>";
                }
            }
            if ($tongTienHang == 0 && count($_SESSION['cart']) > 0) {
                echo "<p>Giỏ hàng có sản phẩm, nhưng giá trị tổng cộng là 0đ. Vui lòng kiểm tra lại.</p>";
            }
        } else {
            echo "<p>Giỏ hàng trống.</p>";
        }

        $tongCongDonHang = $tongTienHang + $phivanchuyen_display;
        ?>
        <hr>
        <div class="summary-total-lines">
            <p>Tạm tính hàng hóa: <strong><?= number_format($tongTienHang) ?>đ</strong></p>
            <p>Phí vận chuyển: <strong><?= number_format($phivanchuyen_display) ?>đ</strong></p>
            <p class="grand-total">Tổng cộng: <strong><?= number_format($tongCongDonHang) ?>đ</strong></p>
        </div>
    </div>
</div>
</body>
</html>