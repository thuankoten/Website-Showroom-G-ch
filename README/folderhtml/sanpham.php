<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang sản phẩm</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div id="container">
    <!-- Header -->
    <div id="include-header"></div>
    <script>
        $(function () {
            $("#include-header").load("header.html");
        });
    </script>

    <!-- Danh sách sản phẩm -->
    <main>
        <ul id="sanpham-menu">
            <li><a href="#">Tất cả</a></li>
            <li><a href="#">Gạch 30x30</a></li>
            <li><a href="#">Gạch 60x60</a></li>
            <li><a href="#">Gạch thẻ</a></li>
        </ul>

        <div id="sanphamhot">
            <h1>Sản phẩm hot</h1>

            <div class="anh1">
                <img src="img/gach1.jpg" alt="Gạch 1">
                <div class="ten">Gạch 30x30</div>
                <div class="gia">Giá: 150.000đ/m²</div>
            </div>

            <div class="anh1">
                <img src="img/gach2.jpg" alt="Gạch 2">
                <div class="ten">Gạch 60x60</div>
                <div class="gia">Giá: 250.000đ/m²</div>
            </div>

            <div class="anh1">
                <img src="img/gach3.jpg" alt="Gạch 3">
                <div class="ten">Gạch thẻ</div>
                <div class="gia">Giá: 180.000đ/m²</div>
            </div>

            <div class="anh1">
                <img src="img/gach4.jpg" alt="Gạch 4">
                <div class="ten">Gạch 80x80</div>
                <div class="gia">Giá: 320.000đ/m²</div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <div id="include-footer"></div>
    <script>
        $(function () {
            $("#include-footer").load("footer.html");
        });
    </script>
</div>
</body>
</html>
