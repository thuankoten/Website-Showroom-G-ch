<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Khuyến mãi sản phẩm</title>
  <link href="../foldercss/style.css" rel="stylesheet"/>
  <link href="../foldercss/khuyenmai.css" rel="stylesheet"/>
  <script src="../jquery-3.7.1.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style> body { text-align: center } </style>
</head>
<body>
  <div id="container">
    <div id="include-header"></div>
    <script>
      $(function () {
        $("#include-header").load("header.php");
      });
    </script>

    <main>
  <div class="container">
    <h2>Các sản phẩm đang khuyến mãi của hệ thống showroom HX trên toàn quốc</h2>
    <div class="products">
      <?php
      $link = mysqli_connect("localhost", "root", "", "showroom_gach");
      mysqli_set_charset($link, "utf8");

      $sql = "SELECT sp.sanpham_id, sp.ten_sanpham, sp.image, sp.gia, uu.phamtram_uudai
              FROM sanpham sp
              JOIN uudai uu ON sp.sanpham_id = uu.sanpham_id
              WHERE uu.trangthai_uudai = 0";
      $result = mysqli_query($link, $sql);

      while ($sp = mysqli_fetch_assoc($result)) {
          $gia = (float)$sp['gia'];
          $phantram = (float)$sp['phamtram_uudai'];
          $gia_sau_uudai = $gia - ($gia * $phantram / 100);
          $gia_goc = $gia > 0 ? number_format($gia) . " đ" : "Liên hệ";
          $gia_km = $gia > 0 ? number_format($gia_sau_uudai) . " đ" : "Liên hệ";
      ?>
      <div class="product">
        <div class="discount-badge">-<?php echo $phantram; ?>%</div>
        <a href="chitiet.php?id=<?php echo $sp['sanpham_id']; ?>">
          <img src="data:image/jpeg;base64,<?php echo base64_encode($sp['image']); ?>" alt="<?php echo $sp['ten_sanpham']; ?>">
        </a>
        <div class="product-info">
          <h4><?php echo $sp['ten_sanpham']; ?></h4>
          <div>
            <span class="price"><?php echo $gia_goc; ?></span>
            <span class="new-price"><?php echo $gia_km; ?></span>
          </div>
        </div>
      </div>
      <?php } mysqli_close($link); ?>
    </div>
  </div>
</main>

</div>

    <div id="include-footer">
    <script>
      $(function () {
        $("#include-footer").load("footer.php");
      });
    </script>
  </div>
</body>
</html>
