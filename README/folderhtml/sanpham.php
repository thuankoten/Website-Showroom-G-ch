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

    <!-- Nội dung phần dự án -->
    <main>
<?php
$link = mysqli_connect("localhost", "root", "", "showroom_gach");
mysqli_set_charset($link, "utf8");

$loai_id = isset($_GET['loai_id']) ? (int)$_GET['loai_id'] : 0;
$chungloai_id = isset($_GET['chungloai_id']) ? (int)$_GET['chungloai_id'] : 0;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = 20;
$start = ($page - 1) * $limit;

// 1. Danh mục sản phẩm
echo "<h2>Danh mục sản phẩm</h2><div style='margin-bottom:10px'>";
$res_loai = mysqli_query($link, "SELECT * FROM loai_sanpham");
while ($loai = mysqli_fetch_assoc($res_loai)) {
  $active = ($loai_id == $loai['loai_id']) ? "style='font-weight:bold;color:red'" : "";
  echo "<a href='?loai_id={$loai['loai_id']}' $active>{$loai['loai_name']}</a> | ";
}
echo "</div>";

// 2. Chủng loại theo loại
if ($loai_id > 0) {
  echo "<div style='margin-bottom:15px'><strong>Chủng loại:</strong> ";
  $sql_cl = "SELECT DISTINCT cls.chungloai_id, cls.kichthuoc 
             FROM chungloai_sanpham cls 
             JOIN sanpham sp ON cls.chungloai_id = sp.chungloai_id 
             WHERE sp.loai_id = $loai_id";
  $res_cl = mysqli_query($link, $sql_cl);
  while ($cl = mysqli_fetch_assoc($res_cl)) {
    $active = ($chungloai_id == $cl['chungloai_id']) ? "style='font-weight:bold;text-decoration:underline'" : "";
    echo "<a href='?loai_id=$loai_id&chungloai_id={$cl['chungloai_id']}' $active>{$cl['kichthuoc']}</a> ";
  }
  echo "</div>";
}

// 3. Lấy sản phẩm (JOIN với bảng ưu đãi)
$where = "1=1";
if ($loai_id > 0) $where .= " AND sp.loai_id = $loai_id";
if ($chungloai_id > 0) $where .= " AND sp.chungloai_id = $chungloai_id";

$count = mysqli_query($link, "SELECT COUNT(*) AS total 
  FROM sanpham sp 
  LEFT JOIN uudai ud ON sp.sanpham_id = ud.sanpham_id AND ud.trangthai_uudai = 0 
  WHERE $where");
$total = mysqli_fetch_assoc($count)['total'];
$total_pages = ceil($total / $limit);

$sql_sp = "SELECT sp.*, ud.phamtram_uudai 
           FROM sanpham sp 
           LEFT JOIN uudai ud ON sp.sanpham_id = ud.sanpham_id AND ud.trangthai_uudai = 0 
           WHERE $where 
           LIMIT $start, $limit";
$res_sp = mysqli_query($link, $sql_sp);

// 4. Hiển thị sản phẩm
if (mysqli_num_rows($res_sp) > 0) {
  echo "<div style='display: grid; grid-template-columns: repeat(5, 1fr); gap: 20px;'>";

  while ($sp = mysqli_fetch_assoc($res_sp)) {
    $img = base64_encode($sp['image']);
    $gia = $sp['gia'];
    $uudai = $sp['phamtram_uudai'];
    $gia_km = ($uudai > 0) ? $gia - ($gia * $uudai / 100) : $gia;
    $id = $sp['sanpham_id'];

    echo "<div style='position:relative; border:1px solid #ccc; padding:10px; border-radius:8px; text-align:center'>";

    // Badge ưu đãi nếu có
    if ($uudai > 0) {
      echo "<div style='position:absolute; top:8px; left:8px; background:red; color:#fff; padding:2px 5px; font-size:12px; border-radius:4px;'>-{$uudai}%</div>";
    }

    echo "<a href='chitiet.php?id=$id'>";
    echo "<img src='data:image/jpeg;base64,$img' style='width:100%; height:150px; object-fit:contain;'><br>";
    echo "<h4>{$sp['ten_sanpham']}</h4>";
    echo "</a>";
    echo "<p>Mã: {$sp['ma_sp']}</p>";

    if ($uudai > 0) {
      echo "<p><del>" . number_format($gia) . " đ</del></p>";
      echo "<p style='color:red'><strong>" . number_format($gia_km) . " đ</strong></p>";
    } else {
      echo "<p>Giá: " . ($gia > 0 ? number_format($gia) . " đ" : "Liên hệ") . "</p>";
    }

    echo "</div>";
  }

  echo "</div>";
} else {
  echo "<p>Không có sản phẩm nào phù hợp.</p>";
}

// 5. Phân trang
if ($total_pages > 1) {
  echo "<div style='margin-top:20px; text-align:center'>";
  for ($i = 1; $i <= $total_pages; $i++) {
    $active = ($i == $page) ? "style='font-weight:bold; color:red'" : "";
    echo "<a href='?loai_id=$loai_id&chungloai_id=$chungloai_id&page=$i' $active> $i </a>";
  }
  echo "</div>";
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
