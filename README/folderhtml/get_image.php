<?php
require '../connect.php'; // đúng đường dẫn đến connect.php

$id = $_GET['id'];
$sql = "SELECT hinhanh FROM sanpham WHERE id = $id";
$result = $conn->query($sql);

if ($row = $result->fetch_assoc()) {
    header("Content-type: image/png");
    echo $row['hinhanh'];
} else {
    echo "Không tìm thấy ảnh.";
}
?>
