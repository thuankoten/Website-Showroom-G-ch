<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang sản phẩm</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- jQuery (dùng để load header/footer) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link href="foldercss/sanpham.css" rel="stylesheet" />

    <!-- JS -->
    <script src="js/script.js" defer></script>
</head>
<body>
<div id="container">
    <!-- Include header -->
    <div id="include-header"></div>
    <script>
        $(function () {
            $("#include-header").load("header.html");
        });
    </script>

    <!-- Main content -->
    <main>
        <h1 style="text-align:center; margin-top: 30px;">Sản phẩm nổi bật</h1>

        <ul id="sanpham">
            <li><a href="#">Tất cả</a></li>
            <li><a href="#">Gạch 30x30</a></li>
            <li><a href="#">Gạch 30x60</a></li>
            <li><a href="#">Gạch 60x60</a></li>
            <li><a href="#">Gạch 80x80</a></li>
            <li><a href="#">Gạch thẻ</a></li>
        </ul>

        <div id="sanphamhot">
            <div class="gach1">
                <img src="img/gach1.jpg" alt="Gạch 1">
                <div class="ten">Gạch 30x30</div>
                <div class="gia">Giá: 150.000đ/m²</div>
            </div>

            <div class="gach2">
                <img src="img/gach2.jpg" alt="Gạch 2">
                <div class="ten">Gạch 60x60</div>
                <div class="gia">Giá: 250.000đ/m²</div>
            </div>

            <div class="agach3">
                <img src="img/gahh3.jpg" alt="Gạch thẻ">
                <div class="ten">Gạch thẻ</div>
                <div class="gia">Giá: 180.000đ/m²</div>
            </div>

            <div class="gach4">
                <img src="img/gach4.jpg" alt="Gạch 80x80">
                <div class="ten">Gạch 80x80</div>
                <div class="gia">Giá: 320.000đ/m²</div>
            </div>
        </div>
    </main>

    <!-- Include footer -->
    <div id="include-footer"></div>
    <script>
        $(function () {
            $("#include-footer").load("footer.html");
        });
    </script>
</div>
</body>
</html>
