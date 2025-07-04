-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3307
-- Thời gian đã tạo: Th7 04, 2025 lúc 05:08 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `showroom_gach`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remembertoken` varchar(100) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `address` text NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `role` enum('Admin','Staff') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `card_id` bigint(20) UNSIGNED NOT NULL,
  `sp_id` int(11) NOT NULL,
  `qty` int(10) UNSIGNED NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chungloai_sanpham`
--

CREATE TABLE `chungloai_sanpham` (
  `chungloai_id` int(11) NOT NULL,
  `kichthuoc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chungloai_sanpham`
--

INSERT INTO `chungloai_sanpham` (`chungloai_id`, `kichthuoc`) VALUES
(1, '30×30'),
(2, '60×60'),
(3, '80×80');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `duan`
--

CREATE TABLE `duan` (
  `id_duan` int(11) NOT NULL,
  `id_loaiduan` int(11) NOT NULL,
  `mota_duan` varchar(255) NOT NULL,
  `dc_duan` varchar(255) NOT NULL,
  `ten_duan` varchar(255) NOT NULL,
  `imgduan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `duan`
--

INSERT INTO `duan` (`id_duan`, `id_loaiduan`, `mota_duan`, `dc_duan`, `ten_duan`, `imgduan`) VALUES
(1, 1, '', 'Linh Đàm, Thanh Xuân, Hà Nội, Việt Nam', 'Chung cư A1 CT2', 'kdc1.jpeg'),
(2, 1, '', '36 Phạm Hùng, Hanoi, Cầu Giấy, Vietnam', 'Chung cư FLC – 36 Phạm Hùng', 'kdc2.jpeg'),
(3, 1, '', '117 Trung Kính, quận Cầu Giấy, Thành phố Hà Nội', 'Home City - Văn Phú Invest', 'kdc3.jpeg'),
(4, 1, '', 'Nguyễn Xiển, Đại Kim, quận Hoàng Mai, Hà Nội, Vietnam', 'GodSilk', 'kdc4.jpeg'),
(5, 1, '', 'Láng Hòa Lạc, quận Nam Từ Liêm, Thành phố Hà Nội', 'Chung cư Mỹ Đình Pearl', 'duan1.jpeg'),
(6, 1, '', 'Đại Kim, Hanoi, Hoàng Mai, Hà Nội, Vietnam', 'Nhà ở xã hội Đồng Mô – Hà nội', 'duan2.jpeg'),
(16, 2, '', '02 - 04 Nguyễn Thiện Thuật - Nha Trang', 'Khách sạn ISE Nha Trang', 'ktm1.jpeg'),
(17, 2, '', '72A Nguyễn Trãi, phường Thượng Đình, Thành phố Hà Nội', 'Trung tâm thương mại Royal City', 'ktm2.jpeg'),
(18, 2, '', 'Đường Trần Hưng Đạo, Tổ 3, Ấp Đường Bào, Phú Quốc, tỉnh Kiên Giang', 'Khách sạn Mường Thanh Luxury Phú Quốc', 'ktm3.jpeg'),
(19, 2, '', '11 Sư Vạn Hạnh, Phường 12, Quận 10, Thành phố Hồ Chí Minh, Vietnam', 'Trung tâm thương mại Vạn Hạnh', 'ktm4.jpeg'),
(23, 2, '', '', '', 'duan3.webp'),
(24, 2, '', '', '', 'duan4.webp'),
(25, 3, 'Biệt thự sang trọng với diện tích rộng lớn, được thiết kế theo phong cách hiện đại.', '', '', 'no1.png'),
(26, 3, '', '', '', 'no2.png'),
(29, 3, '', '', '', 'duan5.jpeg'),
(30, 3, '', '', '', 'duan6.png'),
(33, 4, '', '', '', 'duan7.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loai_duan`
--

CREATE TABLE `loai_duan` (
  `id_loaiduan` int(11) NOT NULL,
  `name_loaiduan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `loai_duan`
--

INSERT INTO `loai_duan` (`id_loaiduan`, `name_loaiduan`) VALUES
(1, 'Khu dân cư'),
(2, 'Khu thương mại'),
(3, 'Nhà ở'),
(4, 'Công trình công cộng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loai_sanpham`
--

CREATE TABLE `loai_sanpham` (
  `loai_id` int(11) NOT NULL,
  `loai_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `loai_sanpham`
--

INSERT INTO `loai_sanpham` (`loai_id`, `loai_name`) VALUES
(1, 'GẠCH LÁT NỀN'),
(2, 'GẠCH ỐP TƯỜNG'),
(3, 'GẠCH LÁT SÂN');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_code` varchar(50) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `delivery_method` enum('Giao hàng tận nhà','Nhận hàng tại cửa hàng') NOT NULL,
  `payment_method` enum('Thanh toán khi nhận hàng','Chuyển khoản ngân hàng','Thẻ tín dụng/Ghi nợ') NOT NULL,
  `order_note` text NOT NULL,
  `status` enum('Đang chờ','Đang xử lý','Đã vận chuyển','Đã giao hàng','Đã huỷ') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount_price` decimal(10,2) NOT NULL,
  `size` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phoicanh`
--

CREATE TABLE `phoicanh` (
  `id_phoicanh` int(11) NOT NULL,
  `hinhanh` varchar(255) DEFAULT NULL,
  `mota` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `phoicanh`
--

INSERT INTO `phoicanh` (`id_phoicanh`, `hinhanh`, `mota`) VALUES
(1, 'phoicanh1.jpg', 'Nhà hàng trở nên sang trọng, gần gũi và ấm cúng hơn khi sử dụng mẫu gạch 60×60 vân gỗ Prime lát sàn nhà'),
(2, 'phoicanh2.jpg', 'Gạch Prime porcelain vân đá màu ghi xám lát sàn nhà chung cư'),
(3, 'phoicanh3.jpg', 'Gạch vân đá màu kem thích hợp sử dụng cho nhiều không gian như phòng khách, phòng ngủ, nhà bếp…'),
(4, 'phoicanh4.jpg', 'Lựa chọn gạch vân đá màu xám lát nền, gia chủ có thể thoải mái kết hợp với đồ nội thất mà không lo lệch tông'),
(5, 'phoicanh5.jpg', 'Tone sur tone với mẫu gạch xám vân đá kết hợp với nội thất cùng màu'),
(6, 'phoicanh6.jpg', 'Gạch vân gỗ màu nâu là sự lựa chọn hoàn hảo cho nhà hàng lựa chọn nâu vàng là tone chủ đạo'),
(7, 'phoicanh7.jpg', 'Không gian ấn tượng hơn với mẫu gạch lát màu ghi vân đá nổi bật'),
(8, 'phoicanh8.jpg', 'Mẫu gạch lát nền thích hợp cho gia chủ mệnh Mộc và mệnh Thuỷ'),
(9, 'phoicanh9.jpg', 'Gạch vân đá màu xám, men bóng là sự lựa chọn hoàn hảo cho không gian phòng khách'),
(10, 'phoicanh10.jpg', 'Gạch Prime 60×60 vân đá màu xám xanh cũng là gợi ý hay cho các gia chủ'),
(11, 'phoicanh11.jpg', 'Phòng bếp lát gạch vân gỗ men bóng kích thước 60×60 của Prime');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `sanpham_id` int(11) NOT NULL,
  `ten_sanpham` varchar(255) NOT NULL,
  `ma_sp` varchar(50) NOT NULL,
  `bemat` varchar(100) NOT NULL,
  `chatlieu` varchar(100) NOT NULL,
  `congnang` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL,
  `gia` int(11) DEFAULT NULL,
  `loai_id` int(11) NOT NULL,
  `chungloai_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`sanpham_id`, `ten_sanpham`, `ma_sp`, `bemat`, `chatlieu`, `congnang`, `image`, `gia`, `loai_id`, `chungloai_id`) VALUES
(1, 'Gạch Porcelain PP6601', 'PN6601', 'Phẳng', 'Xương Porcelain, men Matt', 'Gạch lát nền', 'PP6601.jpeg', NULL, 1, 2),
(2, 'Gạch Porcelain PP6602', 'PN6602', 'Phẳng', 'Xương Porcelain, men Matt', 'Gạch lát nền', 'PP6602.jpeg', NULL, 1, 2),
(3, 'Gạch Porcelain PP6603', 'PN6603', 'Phẳng', 'Xương Porcelain, men Matt', 'Gạch lát nền', 'PP6603.jpeg', NULL, 1, 2),
(4, 'Gạch Porcelain PP6604', 'PN6604', 'Phẳng', 'Xương Porcelain, men Matt', 'Gạch lát nền', 'PP6604.jpeg', NULL, 1, 2),
(5, 'Gạch Porcelain PP6605', 'PN6605', 'Phẳng', 'Xương Porcelain, men Matt', 'Gạch lát nền', 'PP6605.jpeg', NULL, 1, 2),
(6, 'Gạch Porcelain PP6606', 'PN6606', 'Phẳng', 'Xương Porcelain, men Matt', 'Gạch lát nền', 'PP6606.jpeg', NULL, 1, 2),
(7, 'Gạch Porcelain PP6607', 'PN6607', 'Phẳng', 'Xương Porcelain, men Matt', 'Gạch lát nền', 'PP6607.jpeg', NULL, 1, 2),
(8, 'Gạch Porcelain PP6608', 'PN6608', 'Phẳng', 'Xương Porcelain, men Matt', 'Gạch lát nền', 'PP6608.jpeg', NULL, 1, 2),
(9, 'Gạch Porcelain PP6609', 'PN6609', 'Phẳng', 'Xương Porcelain, men Matt', 'Gạch lát nền', 'PP6609.jpeg', NULL, 1, 2),
(10, 'Gạch Porcelain PP6610', 'PN6610', 'Phẳng', 'Xương Porcelain, men Matt', 'Gạch lát nền', 'PP6610.jpeg', NULL, 1, 2),
(11, 'Gạch Taicera G38521', 'G38521', 'Nhám/mờ', 'Granite', 'Gạch lát nền', 'G38521.jpg', NULL, 1, 1),
(12, 'Gạch Taicera G39034', 'G39034', 'Vân đá', 'Men matt', 'Gạch lát nền', 'G39034.jpg', NULL, 1, 1),
(13, 'Gạch Taicera G38225', 'G38225', 'Nhám', 'Granite', 'Gạch lát nền', 'G38225.jpg', NULL, 1, 1),
(14, 'Gạch Taicera G38248', 'G38248', 'Nhám', 'Granite', 'Gạch lát nền', 'G38248.jpg', NULL, 1, 1),
(15, 'Gạch Taicera G38229', 'G38229', 'Nhám, chống trơn', 'Xương gạch granite (đồng chất)', 'Gạch lát nền', 'G38229.jpg', NULL, 1, 1),
(16, 'Gạch Taicera G38731ND', 'G38731ND', 'Nhám, phủ men matt (men mờ)', 'Granite (thạch anh), thuộc dòng Fiumi Series.', 'Gạch lát nền', 'G38731ND.jpg', NULL, 1, 1),
(17, 'Gạch Taicera G38B14', 'G38B14', 'Nhám', 'Granite', 'Gạch lát nền', 'G38B14.jpg', NULL, 1, 1),
(18, 'Gạch Taicera G38A19', 'G38A19', 'Nhám, họa tiết vân đá', 'Granite', 'Gạch lát nền', 'G38A19.jpg', NULL, 1, 1),
(19, 'Prime 80×80 20785', '20785', 'Nhẵn bóng', 'Porcelain', 'Gạch lát nền', 'P20785.webp', 460000, 1, 3),
(20, 'Prime 80×80 20786', '20786', 'Nhẵn bóng', 'Porcelain', 'Gạch lát nền', 'P20786.webp', 450000, 1, 3),
(21, 'Prime 80×80 20787\r\n', '20787', 'Nhẵn bóng', 'Porcelain', 'Gạch lát nền', 'P20787.webp', 445000, 1, 3),
(22, 'Prime 80×80 27575', '27575', 'Nhẵn bóng', 'Porcelain', 'Gạch lát nền', 'P27575.webp', 400000, 1, 3),
(23, 'Prime 80×80 8774\r\n', '8774', 'Nhẵn bóng', 'Porcelain', 'Gạch lát nền', 'P8774.webp', 450000, 1, 3),
(24, 'Prime 80×80 8628', '8628', 'Nhẵn bóng', 'Porcelain', 'Gạch lát nền', 'P8628.webp', 440000, 1, 3),
(25, 'Prime 80×80 8629', '8629', 'Nhẵn bóng', 'Porcelain', 'Gạch lát nền', 'P8629.webp', 429000, 1, 3),
(26, 'Prime 80×80 8795', '8795', 'Nhẵn bóng', 'Porcelain', 'Gạch lát nền', 'P8795.webp', 445000, 1, 3),
(27, 'Prime 80×80 8797', '8797', 'Nhẵn bóng', 'Porcelain', 'Gạch lát nền', 'P8797.webp', 430000, 1, 3),
(28, 'Prime 80×80 8514', '8514', 'Nhẵn bóng', 'Porcelain', 'Gạch lát nền', 'P8514.webp', 420000, 1, 3),
(29, 'Prime 80×80 8515', '8515', 'Nhẵn bóng', 'Porcelain', 'Gạch lát nền', 'P8515.webp', 415000, 1, 3),
(30, 'Prime 80×80 17867', '17867', 'Nhẵn bóng', 'Porcelain', 'Gạch lát nền', 'P17867.webp', 375000, 1, 3),
(31, 'Prime 80×80 8685\r\n', '8685', 'Nhẵn bóng', 'Porcelain', 'Gạch lát nền', 'P8685.webp', 440000, 1, 3),
(32, 'Prime 80×80 8516', '8516', 'Nhẵn bóng', 'Porcelain', 'Gạch lát nền', 'P8516.webp', 400000, 1, 3),
(33, 'Prime 80×80 8752\r\n', '8752', 'Nhẵn bóng', 'Porcelain', 'Gạch lát nền', 'P8752.webp', 315000, 1, 3),
(34, 'Prime 80×80 8739', '8739', 'Nhẵn bóng', 'Porcelain', 'Gạch lát nền', 'P8739.webp', 325000, 1, 3),
(35, 'Prime 80×80 8502', '8502', 'Nhẵn bóng', 'Porcelain', 'Gạch lát nền', 'P8502.webp', 400000, 1, 3),
(36, 'Prime 80×80 8504', '8504', 'Nhẵn bóng', 'Porcelain', 'Gạch lát nền', 'P8504.webp', 325000, 1, 3),
(37, 'Prime 80×80 8855', '8855', 'Nhẵn bóng', 'Porcelain', 'Gạch lát nền', 'P8855.webp', 300000, 1, 3),
(38, 'Prime 80×80 8505', '8505', 'Nhẵn bóng', 'Porcelain', 'Gạch lát nền', 'P8505.webp', 305000, 1, 3),
(39, 'Prime 30×30 9149', '9149', 'Nhám', 'Ceramic', 'Gạch lát nền', 'P9149.webp', 195000, 1, 1),
(40, 'Prime 30×30 9338', '9338', 'Nhám', 'Ceramic', 'Gạch lát nền', 'P9338.webp', 199000, 1, 1),
(41, 'Prime 30×30 9339\r\n', '9339', 'Nhám', 'Ceramic', 'Gạch lát nền', 'P8685.webp', 199000, 1, 1),
(42, 'Prime 30×30 20018', '20018', 'Nhám', 'Ceramic', 'Gạch lát nền', 'P20018.webp', 150000, 1, 1),
(43, 'Prime 30×30 20017\r\n', '20017', 'Nhám', 'Ceramic', 'Gạch lát nền', 'P20017.webp', 150000, 1, 1),
(44, 'Prime 30×30 20012', '20012', 'Sần và kháng khuẩn', 'Ceramic', 'Gạch lát nền', 'P20012.webp', 150000, 1, 1),
(45, 'Prime 30×30 9123', '9123', 'Sần', 'Ceramic', 'Gạch lát nền', 'P9123.webp', 165000, 1, 1),
(46, 'Prime 30×30 9124', '9124', 'Sần', 'Ceramic', 'Gạch lát nền', 'P9124.webp', 165000, 1, 1),
(47, 'Prime 30×30 8541', '8541', 'Nhám', 'Ceramic', 'Gạch lát nền', 'P8541.webp', 130000, 1, 1),
(48, 'Prime 30×30 8528', '8528', 'Nhám', 'Ceramic', 'Gạch lát nền', 'P8528.webp', 165000, 1, 1),
(49, 'Prime 30×30 7366', '7366', 'Nhám', 'Ceramic', 'Gạch lát nền', 'P7366.webp', 165000, 1, 1),
(50, 'Prime 30×30 9147', '9147', 'Bóng và định hình', 'Ceramic', 'Gạch lát nền', 'P9147.webp', 130000, 1, 1),
(51, 'Prime 60×60 8951', '8951', 'Nhẵn bóng', 'Porcelain', 'Gạch lát nền', 'P8951.webp', 300000, 1, 2),
(52, 'Prime 60×60 9111', '9111', 'Nhẵn bóng', 'Porcelain', 'Gạch lát nền', 'P9111.webp', 240000, 1, 2),
(53, 'Prime 60×60 21611\r\n', '21611', 'Sần', 'Porcelain', 'Gạch lát nền', 'P21611.webp', 275000, 1, 2),
(54, 'Prime 60×60 39011', '39011', 'Nhẵn bóng', 'Porcelain', 'Gạch lát nền', 'P39011.webp', 255000, 1, 2),
(55, 'Prime 60×60 9143\r\n', '9143', 'Sần', 'Porcelain', 'Gạch lát nền', 'P9143.webp', 300000, 1, 2),
(56, 'Ý Mỹ 60×60 N65002H', 'N65002H', 'Nhám', 'Porcelain', 'Gạch lát nền', 'N65002H.webp', 350000, 1, 2),
(57, 'Ý Mỹ 60×60 EP69001R\r\n', 'EP69001R', 'Bóng kiếng', 'Granite', 'Gạch lát nền', 'EP69001R.webp', 375000, 1, 2),
(58, 'Ý Mỹ 60×60 P68102\r\n', 'P68102', 'Nhẵn bóng', 'Granite', 'Gạch lát nền', 'P68102.webp', 380000, 1, 2),
(59, 'Ý Mỹ 60×60 P65073R\r\n', 'P65073R', 'Matt', 'Granite', 'Gạch lát nền', 'P65073R.webp', 400000, 1, 2),
(60, 'Ý Mỹ 60×60 F68001', 'F68001', 'Nhẵn bóng', 'Granite', 'Gạch lát nền', 'F68001.webp', 360000, 1, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `phone` varchar(30) NOT NULL,
  `address` text NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `role` enum('User') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `uudai`
--

CREATE TABLE `uudai` (
  `id_uudai` int(11) NOT NULL,
  `sanpham_id` int(11) NOT NULL,
  `phamtram_uudai` decimal(10,0) NOT NULL,
  `giasau_uudai` decimal(10,0) NOT NULL,
  `ngaybd_uudai` date NOT NULL,
  `ngaykt_uudai` date NOT NULL,
  `mota_uudai` text NOT NULL,
  `trangthai_uudai` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `uudai`
--

INSERT INTO `uudai` (`id_uudai`, `sanpham_id`, `phamtram_uudai`, `giasau_uudai`, `ngaybd_uudai`, `ngaykt_uudai`, `mota_uudai`, `trangthai_uudai`) VALUES
(1, 51, 7, 0, '2025-07-03', '2025-08-31', '', 0),
(2, 52, 15, 0, '2025-07-03', '2025-08-31', '', 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cart_user` (`user_id`);

--
-- Chỉ mục cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_items_cart` (`card_id`),
  ADD KEY `fk_items_sp` (`sp_id`);

--
-- Chỉ mục cho bảng `chungloai_sanpham`
--
ALTER TABLE `chungloai_sanpham`
  ADD PRIMARY KEY (`chungloai_id`);

--
-- Chỉ mục cho bảng `duan`
--
ALTER TABLE `duan`
  ADD PRIMARY KEY (`id_duan`),
  ADD KEY `fk_loai_duan` (`id_loaiduan`);

--
-- Chỉ mục cho bảng `loai_duan`
--
ALTER TABLE `loai_duan`
  ADD PRIMARY KEY (`id_loaiduan`);

--
-- Chỉ mục cho bảng `loai_sanpham`
--
ALTER TABLE `loai_sanpham`
  ADD PRIMARY KEY (`loai_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orders_users` (`user_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_items_orders1` (`order_id`),
  ADD KEY `fk_items_sanpham` (`product_id`);

--
-- Chỉ mục cho bảng `phoicanh`
--
ALTER TABLE `phoicanh`
  ADD PRIMARY KEY (`id_phoicanh`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`sanpham_id`),
  ADD KEY `fk_loai_sanpham` (`loai_id`),
  ADD KEY `fk_chungloai_sanpham` (`chungloai_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `uudai`
--
ALTER TABLE `uudai`
  ADD PRIMARY KEY (`id_uudai`),
  ADD KEY `fk_uudai` (`sanpham_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `chungloai_sanpham`
--
ALTER TABLE `chungloai_sanpham`
  MODIFY `chungloai_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `duan`
--
ALTER TABLE `duan`
  MODIFY `id_duan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT cho bảng `loai_duan`
--
ALTER TABLE `loai_duan`
  MODIFY `id_loaiduan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `loai_sanpham`
--
ALTER TABLE `loai_sanpham`
  MODIFY `loai_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `phoicanh`
--
ALTER TABLE `phoicanh`
  MODIFY `id_phoicanh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `sanpham_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `uudai`
--
ALTER TABLE `uudai`
  MODIFY `id_uudai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `fk_items_cart` FOREIGN KEY (`card_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_items_sp` FOREIGN KEY (`sp_id`) REFERENCES `sanpham` (`sanpham_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `duan`
--
ALTER TABLE `duan`
  ADD CONSTRAINT `fk_loai_duan` FOREIGN KEY (`id_loaiduan`) REFERENCES `loai_duan` (`id_loaiduan`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_items_orders1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_items_sanpham` FOREIGN KEY (`product_id`) REFERENCES `sanpham` (`sanpham_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `fk_chungloai_sanpham` FOREIGN KEY (`chungloai_id`) REFERENCES `chungloai_sanpham` (`chungloai_id`),
  ADD CONSTRAINT `fk_loai_sanpham` FOREIGN KEY (`loai_id`) REFERENCES `loai_sanpham` (`loai_id`);

--
-- Các ràng buộc cho bảng `uudai`
--
ALTER TABLE `uudai`
  ADD CONSTRAINT `fk_uudai` FOREIGN KEY (`sanpham_id`) REFERENCES `sanpham` (`sanpham_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
