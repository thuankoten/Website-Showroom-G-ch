<?php
require 'connect.php';

if (!isset($_GET['code'])) {
    echo "❌ Không tìm thấy mã đơn hàng!";
    exit;
}

$order_code = mysqli_real_escape_string($conn, $_GET['code']);
$sql = "SELECT * FROM donhang WHERE order_code = '$order_code'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "❌ Không tìm thấy đơn hàng!";
    exit;
}

// Lấy thông tin người đặt từ dòng đầu
$row = mysqli_fetch_assoc($result);
$name = $row['full_name'];
$email = $row['email'];
$phone = $row['phone'];
$address = $row['address'];
$delivery = $row['delivery_method'];
$payment = $row['payment_method'];

mysqli_data_seek($result, 0); // Reset để duyệt sản phẩm
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>✅ Xác nhận đơn hàng</title>
    <link rel="stylesheet" href="css/xacnhan.css">
    <style>
        body {
            font-family: Arial;
            background: #f9f9f9;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 25px;
            border-radius: 10px;
            max-width: 800px;
            margin: auto;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        h2, h3 {
            color: #28a745;
        }
        .section {
            margin-top: 20px;
        }
        .product-list {
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
        .product-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .product-item img {
            width: 80px;
            margin-right: 15px;
        }
        .total {
            font-weight: bold;
            color: red;
            text-align: right;
            margin-top: 10px;
        }
        .btn-home {
            margin-top: 20px;
            display: inline-block;
            background: #28a745;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>🎉 Đặt hàng thành công!</h2>
    <p>Mã đơn hàng: <str
