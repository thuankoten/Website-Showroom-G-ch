<?php 
session_start();
include("../connect.php"); 
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang sản phẩm</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- jQuery -->
    <script src="../jquery-3.7.1.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="../foldercss/style.css">
    <link rel="stylesheet" href="../foldercss/sanpham.css">
    <style>
        
    </style>
</head>
<body>
<div id="container">
    <!-- Header -->
    <div id="include-header"></div>
    <script>
        $(function () {
            $("#include-header").load("header.php");
        });
    </script>

    <!-- Main content -->
    <main>
        <!-- Filter section -->
        <div class="filter-section">
            <h3>Lọc sản phẩm theo loại</h3>
            <div class="filter-options">
                <a href="sanpham.php" class="filter-btn <?php echo !isset($_GET['loai']) ? 'active' : ''; ?>">Tất cả</a>
                <?php
                // Lấy danh sách loại sản phẩm
                $sql_loai = "SELECT DISTINCT ls.loai_id, ls.loai_name FROM loai_sanpham ls 
                            INNER JOIN sanpham sp ON ls.loai_id = sp.loai_id 
                            ORDER BY ls.loai_name";
                $result_loai = mysqli_query($conn, $sql_loai);
                
                if ($result_loai && mysqli_num_rows($result_loai) > 0) {
                    while ($row_loai = mysqli_fetch_assoc($result_loai)) {
                        $active = (isset($_GET['loai']) && $_GET['loai'] == $row_loai['loai_id']) ? 'active' : '';
                        echo '<a href="sanpham.php?loai=' . $row_loai['loai_id'] . '" class="filter-btn ' . $active . '">' . $row_loai['loai_name'] . '</a>';
                    }
                }
                ?>
            </div>
        </div>

        <!-- Products grid -->
        <div class="product-grid">
            <?php
            // Xây dựng câu query
            $sql = "SELECT sp.*, ls.loai_name, cls.kichthuoc 
                    FROM sanpham sp 
                    LEFT JOIN loai_sanpham ls ON sp.loai_id = ls.loai_id 
                    LEFT JOIN chungloai_sanpham cls ON sp.chungloai_id = cls.chungloai_id";
            
            if (isset($_GET['loai']) && $_GET['loai'] != '') {
                $loai_id = intval($_GET['loai']);
                $sql .= " WHERE sp.loai_id = $loai_id";
            }
            
            $sql .= " ORDER BY sp.sanpham_id DESC";
            
            $result = mysqli_query($conn, $sql);
            
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $price = $row['gia'] ? number_format($row['gia'], 0, ',', '.') . ' VNĐ' : 'Liên hệ';
                    $imagePath = getImagePath($row['chungloai_id']);
                    ?>
                    <div class="product-card">
                        <img src="../foldercss/Anhsp/<?php echo $imagePath; ?>/<?php echo $row['image']; ?>" 
                             alt="<?php echo htmlspecialchars($row['ten_sanpham']); ?>" 
                             class="product-image">
                        <div class="product-info">
                            <div class="product-title"><?php echo htmlspecialchars($row['ten_sanpham']); ?></div>
                            <div class="product-code">Mã: <?php echo htmlspecialchars($row['ma_sp']); ?></div>
                            <div class="product-price"><?php echo $price; ?></div>
                            <div class="product-actions">
                                <?php if ($row['gia'] > 0): ?>
                                <button class="btn btn-primary" onclick="addToCart(<?php echo $row['sanpham_id']; ?>)">
                                    <i class="fas fa-shopping-cart"></i> Thêm vào giỏ
                                </button>
                                <?php endif; ?>
                                <a href="sanpham_detail.php?id=<?php echo $row['sanpham_id']; ?>" class="btn btn-secondary">
                                    <i class="fas fa-eye"></i> Chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                if (!$result) {
                    echo '<div style="text-align: center; grid-column: 1/-1; padding: 40px;">Lỗi truy vấn: ' . mysqli_error($conn) . '</div>';
                } else {
                    echo '<div style="text-align: center; grid-column: 1/-1; padding: 40px;">Không có sản phẩm nào</div>';
                }
            }
            
            // Function to get image path
            function getImagePath($chungloaiId) {
                switch(intval($chungloaiId)) {
                    case 1:
                        return 'cloai3030/Latnen';
                    case 2:
                        return 'cloai6060/Latnen';
                    case 3:
                        return 'cloai8080/Latnen';
                    default:
                        return 'cloai6060/Latnen';
                }
            }
            ?>
        </div>
    </main>

    <!-- Footer -->
    <div id="include-footer"></div>
    <script>
        $(function () {
            $("#include-footer").load("footer.php");
        });
    </script>
</div>

<script>
// Function to add product to cart
function addToCart(sanphamId) {
    $.ajax({
        url: 'cart_api.php',
        method: 'POST',
        data: {
            action: 'add_to_cart',
            sanpham_id: sanphamId,
            quantity: 1
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert('Đã thêm sản phẩm vào giỏ hàng!');
                // Update cart count in header
                if (typeof updateCartCount === 'function') {
                    updateCartCount();
                }
            } else {
                alert(response.message || 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng');
            }
        },
        error: function() {
            alert('Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng');
        }
    });
}
</script>
</body>
</html>
