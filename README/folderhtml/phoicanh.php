<?php include("../connect.php"); 
$category = isset($_GET['category']) ? $_GET['category'] : '';
?>
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
    <script src="../js/phoicanh.js"></script>

</head>
<body>
    <div id="container">

    <!-- Gọi header đúng chuẩn -->
    <div id="include-header"></div>
    <script>
    $(function () {
        $("#include-header").load("header.php");
    });
    </script>

    <!-- Banner dưới header -->
    <section class="banner">
        <img src="../img/thietke_thamkhao.png" alt="Thiết kế tham khảo">
    </section>

    <section class="hero-slider">
        <div class="slides">
            <img src="../img/anh_muc_phongkhach_phongngu.jpg" class="slide active" alt="Ảnh 1">
            <img src="../img/anh_muc_phong_bep.jpg" class="slide" alt="Ảnh 2">
            <img src="../img/anh_muc_phong_tam.jpg" class="slide" alt="Ảnh 3">
            <img src="../img/anh_muc_san_vuon.jpg" class="slide" alt="Ảnh 4">
        </div>
        <button class="prev">&#10094;</button>
        <button class="next">&#10095;</button>
        <div class="slider-dots">
            <span class="dot active"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>  
    </section>

    <!-- Main content wrapper -->
    <div class="main-content <?php echo $category ? 'detail-mode' : ''; ?>">
        
        <?php if (!$category): ?>
        <!-- Nội dung 4 mục của trang phối cảnh khi chưa chọn category -->
        <section class="category-links">
            <div class="category-item" data-category="phongkhach_phongngu">
                <a href="phoicanh.php?category=phongkhach_phongngu" class="category-link">
                    <img src="../img/anh_muc_phongkhach_phongngu.jpg" alt="Phối cảnh phòng khách & phòng ngủ">
                    <h3>Phối cảnh phòng khách & phòng ngủ</h3>
                </a>
            </div>
            <div class="category-item" data-category="phongbep">
                <a href="phoicanh.php?category=phongbep" class="category-link">
                    <img src="../img/anh_muc_phong_bep.jpg" alt="Phối cảnh phòng bếp">
                    <h3>Phối cảnh phòng bếp</h3>
                </a>
            </div>
            <div class="category-item" data-category="phongvesinh">
                <a href="phoicanh.php?category=phongvesinh" class="category-link">
                    <img src="../img/anh_muc_phong_tam.jpg" alt="Phối cảnh phòng vệ sinh">
                    <h3>Phối cảnh phòng vệ sinh</h3>
                </a>
            </div>
            <div class="category-item" data-category="sanvuon">
                <a href="phoicanh.php?category=sanvuon" class="category-link">
                    <img src="../img/anh_muc_san_vuon.jpg" alt="Phối cảnh sân vườn">
                    <h3>Phối cảnh sân vườn</h3>
                </a>
            </div>
        </section>
        <?php else: ?>
        <!-- Layout khi đã chọn category - sidebar bên phải -->
        <div class="detail-layout">
            <div class="content-area">
                <div class="back-button">
                    <a href="phoicanh.php" class="back-btn">← Quay lại</a>
                </div>
                <div class="category-title">
                    <h2><?php echo getCategoryTitle($category); ?></h2>
                </div>
                <div class="phoicanh-gallery" id="phoicanh-gallery">
                    <?php
                    // Lấy dữ liệu phối cảnh từ database
                    $phoicanhData = getPhoicanhByCategory($category, $conn);
                    foreach ($phoicanhData as $item) {
                        echo '<div class="phoicanh-item" data-id="' . $item['id_phoicanh'] . '">';
                        echo '<img src="../img/imgphoicanh/' . $item['hinhanh'] . '" alt="Phối cảnh ' . $item['id_phoicanh'] . '">';
                        echo '<div class="info">';
                        echo '<h4>Phối cảnh ' . $item['id_phoicanh'] . '</h4>';
                        echo '<p>' . $item['mota'] . '</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
            
            <div class="sidebar">
                <h3>Danh mục khác</h3>
                <div class="category-sidebar">
                    <div class="sidebar-item <?php echo $category == 'phongkhach_phongngu' ? 'active' : ''; ?>">
                        <a href="phoicanh.php?category=phongkhach_phongngu">
                            <img src="../img/anh_muc_phongkhach_phongngu.jpg" alt="Phối cảnh phòng khách & phòng ngủ">
                            <h4>Phối cảnh phòng khách & phòng ngủ</h4>
                        </a>
                    </div>
                    <div class="sidebar-item <?php echo $category == 'phongbep' ? 'active' : ''; ?>">
                        <a href="phoicanh.php?category=phongbep">
                            <img src="../img/anh_muc_phong_bep.jpg" alt="Phối cảnh phòng bếp">
                            <h4>Phối cảnh phòng bếp</h4>
                        </a>
                    </div>
                    <div class="sidebar-item <?php echo $category == 'phongvesinh' ? 'active' : ''; ?>">
                        <a href="phoicanh.php?category=phongvesinh">
                            <img src="../img/anh_muc_phong_tam.jpg" alt="Phối cảnh phòng vệ sinh">
                            <h4>Phối cảnh phòng vệ sinh</h4>
                        </a>
                    </div>
                    <div class="sidebar-item <?php echo $category == 'sanvuon' ? 'active' : ''; ?>">
                        <a href="phoicanh.php?category=sanvuon">
                            <img src="../img/anh_muc_san_vuon.jpg" alt="Phối cảnh sân vườn">
                            <h4>Phối cảnh sân vườn</h4>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Modal hiển thị chi tiết sản phẩm -->
    <div class="modal" id="product-modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="product-detail">
                <!-- Chi tiết sản phẩm sẽ được load từ AJAX -->
            </div>
        </div>
    </div>
    <!-- Kết thúc nội dung 4 mục của trang phối cảnh -->
    </div>
   
    <!-- Gọi footer chuẩn -->
    <div id="include-footer"></div>
    <script>
    $(function () {
        $("#include-footer").load("footer.php");
    });
    </script>

</body>
</html>

<?php
function getCategoryTitle($category) {
    switch($category) {
        case 'phongkhach_phongngu':
            return 'Phối cảnh phòng khách & phòng ngủ';
        case 'phongbep':
            return 'Phối cảnh phòng bếp';
        case 'phongvesinh':
            return 'Phối cảnh phòng vệ sinh';
        case 'sanvuon':
            return 'Phối cảnh sân vườn';
        default:
            return 'Phối cảnh';
    }
}

function getPhoicanhByCategory($category, $conn) {
    switch($category) {
        case 'phongkhach_phongngu':
            $sql = "SELECT * FROM phoicanh WHERE id_phoicanh BETWEEN 1 AND 4 ORDER BY id_phoicanh";
            break;
        case 'phongbep':
            $sql = "SELECT * FROM phoicanh WHERE id_phoicanh BETWEEN 5 AND 8 ORDER BY id_phoicanh";
            break;
        case 'phongvesinh':
            $sql = "SELECT * FROM phoicanh WHERE id_phoicanh BETWEEN 9 AND 11 ORDER BY id_phoicanh";
            break;
        case 'sanvuon':
            $sql = "SELECT * FROM phoicanh ORDER BY id_phoicanh";
            break;
        default:
            $sql = "SELECT * FROM phoicanh ORDER BY id_phoicanh";
    }
    
    $result = mysqli_query($conn, $sql);
    $data = [];
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }
    
    return $data;
}
?>
