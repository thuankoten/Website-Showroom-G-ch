-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 27, 2025 lúc 06:57 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

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
(2, '60×60');

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
(2, 'GẠCH ỐP TƯỜNG');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phoicanh`
--

CREATE TABLE `phoicanh` (
  `id` int(11) NOT NULL,
  `hinhanh` varchar(255) DEFAULT NULL,
  `mota` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(18, 'Gạch Taicera G38A19', 'G38A19', 'Nhám, họa tiết vân đá', 'Granite', 'Gạch lát nền', 'G38A19.jpg', NULL, 1, 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chungloai_sanpham`
--
ALTER TABLE `chungloai_sanpham`
  ADD PRIMARY KEY (`chungloai_id`);

--
-- Chỉ mục cho bảng `loai_sanpham`
--
ALTER TABLE `loai_sanpham`
  ADD PRIMARY KEY (`loai_id`);

--
-- Chỉ mục cho bảng `phoicanh`
--
ALTER TABLE `phoicanh`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`sanpham_id`),
  ADD KEY `fk_loai_sanpham` (`loai_id`),
  ADD KEY `fk_chungloai_sanpham` (`chungloai_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `chungloai_sanpham`
--
ALTER TABLE `chungloai_sanpham`
  MODIFY `chungloai_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `loai_sanpham`
--
ALTER TABLE `loai_sanpham`
  MODIFY `loai_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `phoicanh`
--
ALTER TABLE `phoicanh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `sanpham_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `fk_chungloai_sanpham` FOREIGN KEY (`chungloai_id`) REFERENCES `chungloai_sanpham` (`chungloai_id`),
  ADD CONSTRAINT `fk_loai_sanpham` FOREIGN KEY (`loai_id`) REFERENCES `loai_sanpham` (`loai_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
