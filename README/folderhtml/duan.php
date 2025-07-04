<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dự án</title>
    <style>
    body { text-align:center}
    </style>
    <link href="../foldercss/style.css" rel="stylesheet"/>
    <link href="../foldercss/duan.css" rel="stylesheet"/>
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

    <!-- Nội dung phần dự án -->
    <>
        <div class="contentda">
        <div class="mainduan">
        <!-- slider dự án -->
        <div class="item" style="background-image: url(../img/imgduan/duan1.jpeg);">
            <div class="sliderda">
                <div class="name">Nội dung 1</div>
                <div class="des">Hình ảnh dự án </div>
                <button>Thêm</button>
            </div>
        </div>
        <div class="item" style="background-image: url(../img/imgduan/duan2.jpeg);">
            <div class="sliderda">
                <div class="name">Nội dung 2</div>
                <div class="des">Hình ảnh dự án </div>
                <button>Thêm</button>
            </div>
        </div>
        <div class="item" style="background-image: url(../img/imgduan/duan3.webp);">
            <div class="sliderda">
                <div class="name">Nội dung 3</div>
                <div class="des">Hình ảnh dự án </div>
                <button>Thêm</button>
            </div>
        </div>
        <div class="item" style="background-image: url(../img/imgduan/duan4.webp);">
            <div class="sliderda">
                <div class="name">Nội dung 4</div>
                <div class="des">Hình ảnh dự án </div>
                <button>Thêm</button>
            </div>
        </div>
        <div class="item" style="background-image: url(../img/imgduan/duan5.jpeg);">
            <div class="sliderda">
                <div class="name">Nội dung 5</div>
                <div class="des">Hình ảnh dự án </div>
                <button>Thêm</button>
            </div>
        </div>
        <div class="item" style="background-image: url(../img/imgduan/duan6.png);">
            <div class="sliderda">
                <div class="name">Nội dung 6</div>
                <div class="des">Hình ảnh dự án </div>
                <button>Thêm</button>
            </div>
        </div>
        <div class="item" style="background-image: url(../img/imgduan/duan7.jpg);">
            <div class="sliderda">
                <div class="name">Nội dung 7</div>
                <div class="des">Hình ảnh dự án </div>
            </div>
        </div>
        
        </div>

        <div class="button">
             <button class="prev"><i class="fa-solid fa-arrow-left"></i></button>
             <button class="next"><i class="fa-solid fa-arrow-right"></i></button>
        </div>
        </div>
        
        <br>
        <h1>Danh Mục <span>Dự án</span><br><hr></h1>
        <br>
        <!-- Các nút lọc -->
        <div class="filter-buttons">
    <button class="filter-btn <?php if (!isset($_GET['loai'])) echo 'active'; ?>" data-loai="0">Tất cả dự án</button>
    <button class="filter-btn <?php if (isset($_GET['loai']) && $_GET['loai'] == 1) echo 'active'; ?>" data-loai="1">Khu dân cư</button>
    <button class="filter-btn <?php if (isset($_GET['loai']) && $_GET['loai'] == 2) echo 'active'; ?>" data-loai="2">Khu thương mại</button>
    <button class="filter-btn <?php if (isset($_GET['loai']) && $_GET['loai'] == 3) echo 'active'; ?>" data-loai="3">Nhà ở</button>
    <button class="filter-btn <?php if (isset($_GET['loai']) && $_GET['loai'] == 4) echo 'active'; ?>" data-loai="4">Công trình công cộng</button>
</div>





        <?php 
$link = mysqli_connect("localhost", "root", "", "showroom_gach");
mysqli_set_charset($link, "utf8");

// Thiết lập số dòng mỗi trang
$sd = 12;
$loai = isset($_GET['loai']) ? intval($_GET['loai']) : 0;
$dk_loai = $loai > 0 ? "WHERE id_loaiduan = $loai" : "";

// Tổng số sản phẩm
$sql_total = "SELECT COUNT(*) AS total FROM duan $dk_loai";
$res_total = mysqli_query($link, $sql_total);
$tsp = mysqli_fetch_assoc($res_total)['total'];
$tst = ceil($tsp / $sd); // Tổng số trang

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$vt = ($page - 1) * $sd;

// Lấy dữ liệu theo trang
$sql = "SELECT * FROM duan $dk_loai ORDER BY id_loaiduan LIMIT $vt, $sd";
$kq2 = mysqli_query($link, $sql);
?>

<div id="duan-list" class="duan-grid">
  <?php while ($d2 = mysqli_fetch_assoc($kq2)) { ?>
    <div class="duan-item">
        <img src="../img/imgduan/<?php echo $d2['imgduan']; ?>" alt="Ảnh dự án">
        <div class="duan-title"><?php echo strtoupper($d2['ten_duan']); ?></div>
        <div class="duan-address"><i class="fa fa-location-dot"></i> <?php echo $d2['dc_duan']; ?></div>
    </div>
  <?php } ?>
</div>

<!-- PHÂN TRANG -->
<div class="pagination">
  <?php
    $url_prefix = $loai > 0 ? "?loai=$loai&" : "?";
    $anchor = "#duan-list";

    // Trang trước
    if ($page > 1) {
        $prev = $page - 1;
        echo "<a href='{$url_prefix}page=$prev$anchor' class='pag-btn'><i class='fa-solid fa-angle-left'></i></a>";
    } else {
        echo "<span class='pag-btn disabled'><i class='fa-solid fa-angle-left'></i></span>";
    }

    // Các số trang
    for ($i = 1; $i <= $tst; $i++) {
        if ($i == $page) {
            echo "<span class='pnow pag-btn'>$i</span>";
        } else {
            echo "<a href='{$url_prefix}page=$i$anchor' class='pag-btn'>$i</a>";
        }
    }

    // Trang sau
    if ($page < $tst) {
        $next = $page + 1;
        echo "<a href='{$url_prefix}page=$next$anchor' class='pag-btn'><i class='fa-solid fa-angle-right'></i></a>";
    } else {
        echo "<span class='pag-btn disabled'><i class='fa-solid fa-angle-right'></i></span>";
    }
  ?>
</div>

<?php mysqli_close($link); ?>

        <script src="../js/duan.js"></script>
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