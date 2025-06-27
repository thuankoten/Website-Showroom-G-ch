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
