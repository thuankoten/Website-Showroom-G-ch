<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang sản phẩm</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    body { text-align:center}
    </style>
    <link href="../foldercss/style.css" rel="stylesheet"/>
    <link href="../foldercss/sanpham.css" rel="stylesheet"/>
    <script src="../jquery-3.7.1.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<div id="container">
    <!-- Hiển thị topbar và header  -->
    <div id="include-header"></div>
    <script>
    $(function () {
        $("#include-header").load("header.php");
    });
    </script>
    <main>
<?php
$link = mysqli_connect("localhost", "root", "", "showroom_gach");
mysqli_set_charset($link, "utf8");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$sql = "SELECT sp.*, 
               l.loai_name, 
               cl.kichthuoc, 
               ud.phamtram_uudai, ud.giasau_uudai, 
               ud.ngaybd_uudai, ud.ngaykt_uudai, ud.mota_uudai
        FROM sanpham sp
        JOIN loai_sanpham l ON sp.loai_id = l.loai_id
        JOIN chungloai_sanpham cl ON sp.chungloai_id = cl.chungloai_id
        LEFT JOIN uudai ud ON sp.sanpham_id = ud.sanpham_id AND ud.trangthai_uudai = 1
        WHERE sp.sanpham_id = $id";

$result = mysqli_query($link, $sql);
if ($sp = mysqli_fetch_assoc($result)) {
    $gia = (float)$sp['gia'];
    $uudai = (float)$sp['phamtram_uudai'];
    $gia_sau_uudai = (float)$sp['giasau_uudai'];

    // Tính giá khuyến mãi nếu chưa có trong DB
    if ($gia > 0) {
        $gia_km = ($gia_sau_uudai > 0) ? $gia_sau_uudai : ($uudai > 0 ? $gia - ($gia * $uudai / 100) : 0);
    } else {
        $gia_km = 0;
    }

    $gia_format = $gia > 0 ? number_format($gia) . " đ" : "Liên hệ";
    $gia_km_format = $gia_km > 0 ? number_format($gia_km) . " đ" : "Liên hệ";
    $img = base64_encode($sp['image']);

    echo "<div style='display: flex; gap: 30px; align-items: flex-start; padding: 20px;'>";

    // Cột ảnh bên trái
    echo "<div style='flex: 1;'>";
    echo "<img src='data:image/jpeg;base64,$img' style='width:100%; max-width:400px; border-radius:8px;'>";
    echo "</div>";

    // Cột thông tin bên phải
    echo "<div style='flex: 2; text-align:left'>";
    echo "<h2>{$sp['ten_sanpham']}</h2>";
    echo "<p><strong>Mã sản phẩm:</strong> {$sp['ma_sp']}</p>";
    echo "<p><strong>Loại gạch:</strong> {$sp['loai_name']}</p>";
    echo "<p><strong>Kích thước:</strong> {$sp['kichthuoc']}</p>";
    echo "<p><strong>Chất liệu:</strong> {$sp['chatlieu']}</p>";
    echo "<p><strong>Bề mặt:</strong> {$sp['bemat']}</p>";

    // Hiển thị giá và ưu đãi nếu có
    if ($gia_km > 0 && $gia_km < $gia) {
        echo "<p><strong>Ưu đãi:</strong> -{$uudai}%</p>";
        echo "<p><del>Giá gốc: {$gia_format}</del></p>";
        echo "<p><strong>Giá khuyến mãi:</strong> <span style='color:red; font-size:18px;'>{$gia_km_format}</span></p>";

        if (!empty($sp['ngaybd_uudai']) && !empty($sp['ngaykt_uudai'])) {
            echo "<p><strong>Thời gian áp dụng:</strong> từ {$sp['ngaybd_uudai']} đến {$sp['ngaykt_uudai']}</p>";
        }
        if (!empty($sp['mota_uudai'])) {
            echo "<p><strong>Mô tả ưu đãi:</strong><br>" . nl2br($sp['mota_uudai']) . "</p>";
        }
    } else {
        echo "<p><strong>Giá bán:</strong> <span style='color:red; font-size:18px;'>{$gia_format}</span></p>";
    }

    // Mô tả sản phẩm chung
    if (!empty($sp['mota'])) {
        echo "<p><strong>Mô tả sản phẩm:</strong><br>" . nl2br($sp['mota']) . "</p>";
    }

    echo "</div></div>";
} else {
    echo "<p style='color:red;'>Không tìm thấy sản phẩm.</p>";
}

mysqli_close($link);
?>
</main>

</div>

 <!-- Hiển thị footer -->
    <div id="include-footer">
    <script>
        $(function () {
            $("#include-footer").load("footer.php");
        });
    </script>
    </div>
</body>
</html>
