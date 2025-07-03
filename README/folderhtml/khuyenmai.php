<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng kí và Ưu đãi</title>
    <style>
    body { text-align:center}
    </style>
    <link href="../foldercss/style.css" rel="stylesheet"/>
    <link href="../foldercss/khuyenmai.css" rel="stylesheet"/>
    <script src="../jquery-3.7.1.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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

    <!-- Nội dung phần ưu đãi -->
    <main> 
        <h1>Bảng đăng kí cho khách hàng + hiển thị 1 số ưu đãi</h1>
    </main>

    <!-- Hiển thị footer -->
    <div id="include-footer"></div>
    <script>
    $(function () {
        $("#include-footer").load("footer.php");
    });
    </script>
    </div>
</body>
</html>
