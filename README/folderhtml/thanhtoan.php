<?php
session_start();
require 'connect.php';
$message = "";

session_start();
require '../connect.php'; // Sửa lại đường dẫn cho đúng vị trí thật

if (!$conn) {
    die("Không kết nối được CSDL.");
}

// Tạo mã đơn hàng ngẫu nhiên
function generateOrderCode() {
    return 'ODR' . rand(100000, 999999);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra điều kiện hợp lệ
    if (!preg_match("/^0\d{9}$/", $_POST['phone'])) {
        $message = "❌ Số điện thoại phải có đúng 10 chữ số và bắt đầu bằng 0.";
    } elseif (!preg_match("/@gmail\.com$/", $_POST['email'])) {
        $message = "❌ Email phải là địa chỉ Gmail.";
    } else {
        $order_code = generateOrderCode();
        $name = $_POST['full_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $delivery = $_POST['delivery_method'];

        $raw_payment = $_POST['payment_method'];
        $payment = ($raw_payment === 'Tiền mặt') ? 'Thanh toán khi nhận hàng' : $raw_payment;

        $note = $_POST['order_note'];
        $product = $_POST['product_name'];
        $quantity = (int) $_POST['quantity'];
        $price = (int) $_POST['price'];
        $total = $price * $quantity + 30000;

        // ✅ Câu lệnh SQL thêm đơn hàng
        $sql = "INSERT INTO orders 
                (order_code, full_name, email, phone, address, delivery_method, payment_method, order_note, product_name, quantity, total_price)
                VALUES 
                ('$order_code', '$name', '$email', '$phone', '$address', '$delivery', '$payment', '$note', '$product', $quantity, $total)";

        if (mysqli_query($conn, $sql)) {
            unset($_SESSION['cart']); // Xóa giỏ hàng nếu có
            header("Location: xacnhan.php?code=$order_code");
            exit;
        } else {
            $message = "❌ Lỗi: " . mysqli_error($conn);
        }
    }
}
?>


<!DOCTYPE html>
<html lang="vi">
<head>
  <!-- Cấu hình chung -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Trang Thanh Toán</title>

  <!-- Liên kết CSS -->
  <link rel="stylesheet" href="../foldercss/style.css" type="text/css" />
  <link rel="stylesheet" href="../foldercss/thanhtoan.css" type="text/css" />
  <link rel="stylesheet" href="../foldercss/header-footer.css" type="text/css" />

  <!-- Thư viện JavaScript -->
  <script src="../jquery-3.7.1.js"></script>

  <!-- Script xử lý hiển thị QR khi chọn phương thức chuyển khoản -->
  <script>
    function toggleBankInfo() {
      const selected = document.querySelector('input[name="payment_method"]:checked');
      const bankInfo = document.getElementById('bank-info');
      if (selected && selected.value === 'Chuyển khoản ngân hàng') {
        bankInfo.style.display = 'block';
      } else {
        bankInfo.style.display = 'none';
      }
    }
  </script>
</head>
<body>

<div class="container">
    <form class="checkout-form" method="POST">
        <h2>Thông tin giao hàng</h2>

        <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>

        <label>Họ và tên:</label>
        <input type="text" name="full_name" required>

        <label>Email:</label>
        <input type="email" name="email" pattern=".+@gmail\.com" required>

        <label>Số điện thoại:</label>
        <input type="text" name="phone" pattern="^0\d{9}$" required>

        <label>Địa chỉ:</label>
        <textarea name="address" required></textarea>

        <label>Phương thức giao hàng:</label>
        <div class="radio-group">
            <label><input type="radio" name="delivery_method" value="Giao hàng tận nơi" required> Giao hàng tận nơi</label>
            <label><input type="radio" name="delivery_method" value="Nhận tại cửa hàng"> Nhận tại cửa hàng</label>
        </div>

        <label>Phương thức thanh toán:</label>
        <div class="radio-group" onchange="toggleBankInfo()">
            <label><input type="radio" name="payment_method" value="Thanh toán khi nhận hàng" required> Thanh toán khi nhận hàng</label>
            <label><input type="radio" name="payment_method" value="Chuyển khoản ngân hàng"> Chuyển khoản ngân hàng</label>
            <label><input type="radio" name="payment_method" value="Thẻ tín dụng/Ghi nợ"> Thẻ tín dụng/Ghi nợ</label>
            
        </div>


        <div id="bank-info" style="display: none; margin-top: 10px;">
            <p>💳 Chủ tài khoản: Nguyễn Tấn Thuận</p>
            <p>🔢 Số tài khoản: 123456789</p>
            <p>🏦 Ngân hàng: Vietcombank</p>
            <p>📌 Nội dung: Thanh toán đơn hàng</p>
            <img src="images/qr_thanhtoan_demo.png" alt="QR Code" width="200">
        </div>

        <label>Ghi chú đơn hàng:</label>
        <textarea name="order_note" placeholder="Nhập ghi chú nếu cần..."></textarea>

        <div class="button-group">
            <button type="button" onclick="window.history.back()">← Giỏ hàng</button>
            <button type="submit">✅ Đặt hàng</button>
        </div>

        <!-- Ẩn thông tin sản phẩm (demo) -->
        <input type="hidden" name="product_name" value="Gạch men cao cấp 60x60">
        <input type="hidden" name="quantity" value="1">
        <input type="hidden" name="price" value="200000">
    </form>

    <div class="order-summary">
        <h3>🧱 Showroom Gạch </h3>
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