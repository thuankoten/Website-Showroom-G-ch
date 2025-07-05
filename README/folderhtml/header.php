<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEADER</title>
    <link href="../foldercss/style.css" rel="stylesheet" />
    <link href="../foldercss/header-footer.css" rel="stylesheet" />
    <script src="../jquery-3.7.1.js"></script>
    <script src="../javascript/index.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
</head>
<body>
    <div id="topbar">
        <div class="topbar-left">
            <a href="index.php">
                <img src="../img/logo.jpg" alt="Logo BLife" id="logo">
            </a>
            <a href="index.php" class="brand-link">
                <span class="brand">
                    <span class="brand-main">BLife</span>
                    <span class="brand-sub">.com</span>
                    <div class="brand-slogan">Nâng tầm phong cách sống</div>
                </span>
            </a>
            <span class="hours">
                <i class="fa-solid fa-clock"></i>
                <b>08:00 - 18:00</b>
            </span>
        </div>
        <div class="topbar-right">
            <a href="#">Liên Hệ</a>
            <span class="divider">|</span>
            <a href="gioithieu.php">Giới Thiệu</a>
            <span class="divider">|</span>
            <a href="#">Chính Sách Bán Hàng</a>
            <span class="divider">|</span>
            
            <!-- Giỏ hàng -->
            <a href="cart.php" class="cart-icon">
                <i class="fa-solid fa-shopping-cart"></i>
                <span class="cart-count" id="cart-count">0</span>
            </a>
            <span class="divider">|</span>
            
            <span class="icon user-icon">👤</span>
            <?php
            if (isset($_SESSION['user_name'])) {
                echo '<span class="top-bar__right__item">Hi, ' . htmlspecialchars($_SESSION['user_name']) . '</span><span class="pipe2">|</span>';
                echo '<a href="logout.php" class="top-bar__right__item">Đăng xuất</a>';
            } else {
                echo '<a href="register.php" class="top-bar__right__item">Đăng ký</a><span class="pipe2">|</span>';
                echo '<a href="login.php" class="top-bar__right__item">Đăng nhập</a>';
            }
            ?>
        </div>
    </div>

    <!-- Main bar -->
    <nav id="main-nav">
        <a href="index.php">TRANG CHỦ</a>
        <a href="gioithieu.php">GIỚI THIỆU</a>
        <a href="sanpham.php">SẢN PHẨM</a>
        <a href="phoicanh.php">THƯ VIỆN PHỐI CẢNH</a>
        <a href="duan.php">DỰ ÁN</a>
        <a href="tintuc.php">TIN TỨC</a>
        <a href="khuyenmai.php">ƯU ĐÃI</a>
    </nav>
    
    <script>
        // Load cart count when page loads
        $(document).ready(function() {
            updateCartCount();
        });
        
        // Function to update cart count
        function updateCartCount() {
            $.ajax({
                url: 'cart_api.php',
                method: 'POST',
                data: { action: 'get_cart_count' },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        const count = response.count;
                        const cartCountElement = $('#cart-count');
                        
                        if (count > 0) {
                            cartCountElement.text(count).removeClass('hidden');
                        } else {
                            cartCountElement.addClass('hidden');
                        }
                    }
                },
                error: function() {
                    console.error('Error loading cart count');
                }
            });
        }
        
        // Make updateCartCount available globally
        window.updateCartCount = updateCartCount;
    </script>
</body>
</html>
