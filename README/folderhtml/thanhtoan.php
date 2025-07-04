<?php
require 'connect.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['customer_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $delivery = $_POST['delivery_method'];
    $payment = $_POST['payment_method'];
    $note = $_POST['order_note'];
    $product = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price']; // giá từ input ẩn
    $total = $price * $quantity + 30000; // + phí ship

    $sql = "INSERT INTO orders 
            (customer_name, email, phone, address, delivery_method, payment_method, order_note, product_name, quantity, total_price)
            VALUES 
            ('$name', '$email', '$phone', '$address', '$delivery', '$payment', '$note', '$product', $quantity, $total)";

    $message = mysqli_query($conn, $sql) ? "✅ Đặt hàng thành công!" : "❌ Lỗi: " . mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Thanh toán</title>
  <link rel="stylesheet" href="foldercss/style.css" type="text/css" />
  <link rel="stylesheet" href="foldercss/thanhtoan.css" type="text/css" />
  <link rel="stylesheet" href="foldercss/header-footer.css" type="text/css" />
  <script src="jquery-3.7.1.js"></script>
</head>

<body>

<div class="container">
    <form class="checkout-form" method="POST">
        <h2>Thông tin giao hàng</h2>
        <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>

        <label>Họ và tên:</label>
        <input type="text" name="customer_name" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Số điện thoại:</label>
        <input type="text" name="phone" required>

        <label>Địa chỉ:</label>
        <textarea name="address" required></textarea>

        <label>Chọn phương thức giao hàng:</label>
        <div class="radio-group">
            <label><input type="radio" name="delivery_method" value="Giao hàng tận nơi" required> Giao hàng tận nơi</label>
            <label><input type="radio" name="delivery_method" value="Nhận tại cửa hàng"> Nhận tại cửa hàng</label>
        </div>

        <label>Chọn phương thanh toán:</label>
        <div class="radio-group">
            <label><input type="radio" name="payment_method" value="Thanh toán khi nhận hàng" required> Thanh toán khi nhận hàng (COD)</label>
            <label><input type="radio" name="payment_method" value="Chuyển khoản ngân hàng"> Chuyển khoản ngân hàng</label>
            <label><input type="radio" name="payment_method" value="Thẻ tín dụng/Ghi nợ"> Thẻ tín dụng/Ghi nợ</label>
            <label><input type="radio" name="payment_method" value="Tiền mặt"> Tiền mặt</label>
        </div>

        <label>Ghi chú đơn hàng:</label>
        <textarea name="order_note" placeholder="Nhập ghi chú cho đơn hàng của bạn..."></textarea>

        <div class="button-group">
            <button type="button" onclick="window.history.back()">🛒 Giỏ hàng</button>
            <button type="submit">✅ Hoàn tất thanh toán</button>
        </div>

        <!-- Ẩn thông tin sản phẩm (demo) -->
        <input type="hidden" name="product_name" value="Gạch men cao cấp 60x60">
        <input type="hidden" name="quantity" value="1">
        <input type="hidden" name="price" value="200000">
    </form>

    <div class="order-summary">
        <h3>🧱 Gạch men cao cấp</h3>
        <img src="images/gach.jpg" alt="Sản phẩm" width="100">
        <p>Số lượng: 1</p>
        <p>Giá: 200.000đ</p>
        <hr>
        <p>Tạm tính: <strong>200.000đ</strong></p>
        <p>Phí vận chuyển: <strong>30.000đ</strong></p>
        <p><strong>Tổng cộng: 230.000đ</strong></p>
    </div>
</div>

</body>
</html>
