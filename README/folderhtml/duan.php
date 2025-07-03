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
    <main>
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





        <!-- Danh sách hiện -->
         <?php 
    $link = mysqli_connect("127.0.0.1", "root", "", "showroom_gach", 3307);
    mysqli_set_charset($link, "utf8");
    $sd=12;
    $dk_loai = "";
        if (isset($_GET['loai']) && is_numeric($_GET['loai'])) {
            $loai = $_GET['loai'];
            $dk_loai = "WHERE id_loaiduan = $loai";
        }
    // lấy tất cả sản phẩm
    $sl="select * from duan $dk_loai ORDER BY id_loaiduan";
    $kq=mysqli_query($link,$sl);
    $tsp=mysqli_num_rows($kq);
    // Tổng số trang
    $tst=ceil($tsp/$sd);

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $vt = ($page - 1) * $sd;
    //Truy vẫn lấy sản phẩm theo vị trí
    $sl2="select * from duan $dk_loai ORDER BY id_loaiduan LIMIT $vt,$sd";
    $kq2=mysqli_query($link,$sl2);
    ?>
    <div id="duan-list" class="duan-grid">
<?php while ($d2 = mysqli_fetch_array($kq2)) { ?>
    <div class="duan-item">
        <img src="../img/imgduan/<?php echo $d2['imgduan']; ?>" alt="Ảnh dự án">
        <div class="duan-title"><?php echo strtoupper($d2['ten_duan']); ?></div>
        <div class="duan-address"><i class="fa fa-location-dot"></i> <?php echo $d2['dc_duan']; ?></div>
    </div>
<?php } ?>
</div>

    <div class="pagination">
<?php
    // Xác định biến loai (nếu có lọc)
    $loai = isset($_GET['loai']) ? intval($_GET['loai']) : 0;
    $url_prefix = $loai > 0 ? "?loai=$loai&" : "?";
    $anchor = "#duan-list";

    // Nút "Trang trước"
    if ($page > 1) {
        echo "<a href='{$url_prefix}page=" . ($page - 1) . "{$anchor}' class='pag-btn'><i class='fa-solid fa-angle-left'></i></a>";
    } else {
        echo "<span class='pag-btn disabled'><i class='fa-solid fa-angle-left'></i></span>";
    }

    // Số trang
    for ($i = 1; $i <= $tst; $i++) {
        if ($i == $page) {
            echo "<span class='pnow pag-btn'>$i</span>";
        } else {
            echo "<a href='{$url_prefix}page=$i{$anchor}' class='pag-btn'>$i</a>";
        }
    }

    // Nút "Trang sau"
    if ($page < $tst) {
        echo "<a href='{$url_prefix}page=" . ($page + 1) . "{$anchor}' class='pag-btn'><i class='fa-solid fa-angle-right'></i></a>";
    } else {
        echo "<span class='pag-btn disabled'><i class='fa-solid fa-angle-right'></i></span>";
    }
?>
</div>

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