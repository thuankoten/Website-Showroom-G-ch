<?php include("../connect.php"); ?> 
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Phối Cảnh Gạch</title>
    <link rel="stylesheet" href="../foldercss/phoicanh.css">
</head>
<body>
    <header>
        <h1>Showroom Gạch - Phối Cảnh</h1>
        <nav>
            <a href="index.php">Trang chủ</a>
            <a href="gioithieu.html">Giới thiệu</a>
            <a href="sanpham.html">Sản phẩm</a>
            <a href="phoicanh.php" class="active">Phối cảnh</a>
            <a href="duan.html">Dự án & Ưu đãi</a>
        </nav>
    </header>
    <!-- Thêm hình ngay dưới header -->
    <section class="banner">
        <img src="../img/thietke_thamkhao.png" alt="Thiết kế tham khảo">
    </section>

    <section class="gallery">
        <?php
        $sql = "SELECT * FROM phoicanh";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='gallery-item'>";
                echo "<img src='../" . $row["hinhanh"] . "' alt='Phối cảnh'>";
                echo "<p>" . $row["mota"] . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>Hiện chưa có dữ liệu phối cảnh.</p>";
        }
        ?>
    </section>

    <footer>
        <p>© 2025 Showroom Gạch</p>
    </footer>
</body>
</html>
