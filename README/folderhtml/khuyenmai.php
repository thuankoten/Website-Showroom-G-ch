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
    <h2 class="promo-title" style="text-align:center; padding: 20px 0; color: #e60000;">CÁC SẢN PHẨM KHUYẾN MÃI</h2>

    <div class="filter-bar">
      <?php
      $link = mysqli_connect("localhost", "root", "", "showroom_gach");
      mysqli_set_charset($link, "utf8");

      $loai_id = isset($_GET['loai_id']) ? (int)$_GET['loai_id'] : 0;

      $res_loai = mysqli_query($link, "SELECT * FROM loai_sanpham");
      echo "<a href='khuyenmai.php' class='" . ($loai_id == 0 ? "active" : "") . "'>Tất cả</a>";
      while ($loai = mysqli_fetch_assoc($res_loai)) {
          $active = ($loai_id == $loai['loai_id']) ? "active" : "";
          echo "<a href='khuyenmai.php?loai_id={$loai['loai_id']}' class='$active'>{$loai['loai_name']}</a>";
      }
      ?>
    </div>

    <div class="products">
      <?php
      $limit = 20;
      $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
      $start = ($page - 1) * $limit;

      $where = "uu.trangthai_uudai = 1";
      if ($loai_id > 0) {
        $where .= " AND sp.loai_id = $loai_id";
      }

      $count_sql = "SELECT COUNT(*) as total FROM uudai uu JOIN sanpham sp ON sp.sanpham_id = uu.sanpham_id WHERE $where";
      $count_result = mysqli_query($link, $count_sql);
      $total_row = mysqli_fetch_assoc($count_result)['total'];
      $total_pages = ceil($total_row / $limit);

      $sql = "SELECT sp.sanpham_id, sp.ten_sanpham, sp.image, sp.gia, 
                     uu.phamtram_uudai, uu.giasau_uudai, uu.ngaybd_uudai, uu.ngaykt_uudai, uu.mota_uudai
              FROM sanpham sp
              JOIN uudai uu ON sp.sanpham_id = uu.sanpham_id
              WHERE $where
              LIMIT $start, $limit";

      $result = mysqli_query($link, $sql);

      if (!$result) {
          echo "<p style='color:red;'>Lỗi truy vấn: " . mysqli_error($link) . "</p>";
      } elseif (mysqli_num_rows($result) == 0) {
          echo "<p style='color:orange;'>Không có sản phẩm khuyến mãi nào.</p>";
      } else {
          while ($sp = mysqli_fetch_assoc($result)) {
              $gia = (float)$sp['gia'];
              $phantram = (float)$sp['phamtram_uudai'];
              $gia_sau = (float)$sp['giasau_uudai'];
              $gia_goc = ($gia > 0) ? number_format($gia) . " đ" : "Liên hệ";

              if ($gia > 0) {
                  if ($gia_sau > 0) {
                      $gia_km = number_format($gia_sau) . " đ";
                  } elseif ($phantram > 0) {
                      $gia_km = number_format($gia - ($gia * $phantram / 100)) . " đ";
                  } else {
                      $gia_km = number_format($gia) . " đ";
                  }
              } else {
                  $gia_km = "Liên hệ";
              }

              $img = base64_encode($sp['image']);
      ?>
      <div class="product">
        <div class="discount-badge">-<?php echo $phantram; ?>%</div>
        <a href="chitiet.php?id=<?php echo $sp['sanpham_id']; ?>">
          <img src="data:image/jpeg;base64,<?php echo $img; ?>" alt="<?php echo $sp['ten_sanpham']; ?>">
        </a>
        <div class="product-info">
          <h4><?php echo $sp['ten_sanpham']; ?></h4>
          <div>
            <span class="price"><?php echo $gia_goc; ?></span>
            <span class="new-price"><?php echo $gia_km; ?></span>
          </div>
          <div class="promo-detail">
            <?php if (!empty($sp['ngaybd_uudai']) && !empty($sp['ngaykt_uudai'])): ?>
              <p><small><strong>Thời gian:</strong> <?php echo $sp['ngaybd_uudai']; ?> đến <?php echo $sp['ngaykt_uudai']; ?></small></p>
            <?php endif; ?>
            <?php if (!empty($sp['mota_uudai'])): ?>
              <p><small><strong>Mô tả:</strong> <?php echo nl2br($sp['mota_uudai']); ?></small></p>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php }} mysqli_close($link); ?>
    </div>

    <?php if ($total_pages > 1): ?>
    <div class="pagination">
      <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?php echo $i; ?><?php if($loai_id > 0) echo '&loai_id=' . $loai_id; ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>"> <?php echo $i; ?> </a>
      <?php endfor; ?>
    </div>
    <?php endif; ?>
  </div>
</main>


  </div>

  <div id="include-footer"></div>
  <script>
    $(function () {
      $("#include-footer").load("footer.php");
    });
  </script>
</body>
</html>
