<?php
require 'connect.php';

if (!isset($_GET['code'])) {
    echo "Không tìm thấy mã đơn hàng!";
    exit;
}

$order_code = $_GET['code'];
$sql = "SELECT * FROM donhang WHERE order_code = '$order_code'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $order = mysqli_fetch_assoc($result);
} else {
    echo "Đơn hàng không tồn tại!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>✅ Xác nhận đơn hàng</title>
    <link rel="stylesheet" href="css/xacnhan.css">
</head>
<body>
    <div class="container">
        <h2>🎉 Đặt hàng thành công!</h2>
        <p>Mã đơn hàng: <strong><?= $order['order_code'] ?></strong></p>

        <div class="section">
            <h3>📦 Thông tin sản phẩm</h3>
            <div class="product-info">
                <img src="images/gach.jpg" alt="Sản phẩm">
                <div class="product-details">
                    <p><strong>Tên sản phẩm:</strong> <?= $order['product_name'] ?></p>
                    <p><strong>Số lượng:</strong> <?= $order['quantity'] ?></p>
                    <p><strong>Giá tổng cộng:</strong> <?= number_format($order['total_price']) ?> đ</p>
                </div>
            </div>
        </div>

        <div class="section">
            <h3>👤 Thông tin khách hàng</h3>
            <p><strong>Họ tên:</strong> <?= $order['full_name'] ?></p>
            <p><strong>Email:</strong> <?= $order['email'] ?></p>
            <p><strong>Điện thoại:</strong> <?= $order['phone'] ?></p>
            <p><strong>Địa chỉ:</strong> <?= $order['address'] ?></p>
            <p><strong>Phương thức giao hàng:</strong> <?= $order['delivery_method'] ?></p>
            <p><strong>Phương thức thanh toán:</strong> <?= $order['payment_method'] ?></p>
        </div>
    </div>
</body>
</html>
