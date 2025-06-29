<?php include("../connect.php"); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang phối cảnh</title>
    <style>
    body { text-align:center}
    </style>
    <link href="../foldercss/style.css" rel="stylesheet"/>
    <link href="../foldercss/phoicanh.css" rel="stylesheet"/>
    <script src="../jquery-3.7.1.js"></script>
</head>
<body>
    <div id="container">

    <!-- Gọi header đúng chuẩn -->
    <div id="include-header"></div>
    <script>
    $(function () {
        $("#include-header").load("header.html");
    });
    </script>

    <!-- Banner dưới header -->
    <section class="banner">
        <img src="../img/thietke_thamkhao.png" alt="Thiết kế tham khảo">
    </section>
    
    <!-- Nội dung 4 mục của trang phối cảnh -->
    <section class="category-links">
        <div class="category-item">
            <a href="phongkhach_phongngu.php">
                <img src="../img/placeholder1.jpg" alt="Phối cảnh phòng khách & phòng ngủ">
                <h3>Phối cảnh phòng khách & phòng ngủ</h3>
            </a>
        </div>
        <div class="category-item">
            <a href="phongbep.php">
                <img src="../img/placeholder2.jpg" alt="Phối cảnh phòng bếp">
                <h3>Phối cảnh phòng bếp</h3>
            </a>
        </div>
        <div class="category-item">
            <a href="phongvesinh.php">
                <img src="../img/placeholder3.jpg" alt="Phối cảnh phòng vệ sinh">
                <h3>Phối cảnh phòng vệ sinh</h3>
            </a>
        </div>
        <div class="category-item">
            <a href="sanvuon.php">
                <img src="../img/placeholder4.jpg" alt="Phối cảnh sân vườn">
                <h3>Phối cảnh sân vườn</h3>
            </a>
        </div>
    </section>
    <!-- Kết thúc nội dung 4 mục của trang phối cảnh -->
    </div>
   
    <!-- Gọi footer chuẩn -->
    <div id="include-footer"></div>
    <script>
    $(function () {
        $("#include-footer").load("footer.html");
    });
    </script>

</body>
</html>