<?php
session_start();

$conn = new mysqli("localhost", "root", "", "showroom_gach");
if ($conn->connect_error) {
    $_SESSION['success'] = "Kết nối cơ sở dữ liệu thất bại!";
    header("Location: ../orders.php");
    exit();
}

// Kiểm tra dữ liệu gửi từ form
if (!isset($_POST['order_id']) || !isset($_POST['status'])) {
    $_SESSION['success'] = "Thiếu thông tin cần thiết!";
    header("Location: ../orders.php");
    exit();
}

$order_id = intval($_POST['order_id']);
$status = $_POST['status'];

// Danh sách trạng thái hợp lệ
$valid_statuses = ['đang chờ','đang xử lý','đã vận chuyển','đã giao hàng','đã huỷ'];
if (!in_array($status, $valid_statuses)) {
    $_SESSION['success'] = "Trạng thái không hợp lệ!";
    header("Location: ../orders.php");
    exit();
}

// Cập nhật trạng thái trong bảng orders (không cập nhật updated_at)
$stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
$stmt->bind_param("si", $status, $order_id);

if ($stmt->execute()) {
    $_SESSION['success'] = "Cập nhật trạng thái thành công!";
} else {
    $_SESSION['success'] = "Lỗi khi cập nhật trạng thái!";
}

$stmt->close();
$conn->close();

header("Location: ../orders.php");
exit();
?>