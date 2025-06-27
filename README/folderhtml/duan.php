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
        $("#include-header").load("header.html");
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
                <button>Thêm</button>
            </div>
        </div>
        
        </div>

        <div class="button">
             <button class="prev"><i class="fa-solid fa-arrow-left"></i></button>
             <button class="next"><i class="fa-solid fa-arrow-right"></i></button>
        </div>
        </div>
        
        <br>
        <!-- Các nút lọc -->
        <div class="filter-buttons">
            <button class="filter-btn active">Tất cả dự án</button>
            <button class="filter-btn">Khu dân cư</button>
            <button class="filter-btn">Khu thương mại</button>
            <button class="filter-btn">Nhà ở</button>
            <button class="filter-btn">Công trình công cộng</button>
        </div>
        <script src="../js/duan.js"></script>
    </main>
    

    <!-- Hiển thị footer -->
    <div id="include-footer"></div>
    <script>
    $(function () {
        $("#include-footer").load("footer.html");
    });
    </script>
</div>
</body>
</html>