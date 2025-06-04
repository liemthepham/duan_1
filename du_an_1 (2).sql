-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 20, 2025 lúc 02:41 PM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `du_an_1`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `binhluan`
--

CREATE TABLE `binhluan` (
  `MaBinhLuan` int(11) NOT NULL,
  `MaNguoiDung` int(11) NOT NULL,
  `MaSanPham` int(11) NOT NULL,
  `NoiDung` text NOT NULL,
  `NgayBinhLuan` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `binhluan`
--

INSERT INTO `binhluan` (`MaBinhLuan`, `MaNguoiDung`, `MaSanPham`, `NoiDung`, `NgayBinhLuan`) VALUES
(1, 2, 1, 'Sản phẩm rất tốt, mình rất thích!', '2025-05-19 21:06:20'),
(2, 3, 2, 'Laptop chạy nhanh, đáng đồng tiền.', '2025-05-19 21:06:20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietdonhang`
--

CREATE TABLE `chitietdonhang` (
  `MaChiTiet` int(11) NOT NULL,
  `MaDonHang` int(11) NOT NULL,
  `MaSanPham` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `GiaBan` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietdonhang`
--

INSERT INTO `chitietdonhang` (`MaChiTiet`, `MaDonHang`, `MaSanPham`, `SoLuong`, `GiaBan`) VALUES
(1, 1, 1, 1, 15000000.00),
(2, 2, 3, 2, 300000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhmuc`
--

CREATE TABLE `danhmuc` (
  `MaDanhMuc` int(11) NOT NULL,
  `TenDanhMuc` varchar(100) NOT NULL,
  `MaDanhMucCha` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `danhmuc`
--

INSERT INTO `danhmuc` (`MaDanhMuc`, `TenDanhMuc`, `MaDanhMucCha`) VALUES
(1, 'Điện thoại', NULL),
(2, 'Laptop', NULL),
(3, 'Phụ kiện', NULL),
(4, 'Ốp lưng', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhang`
--

CREATE TABLE `donhang` (
  `MaDonHang` int(11) NOT NULL,
  `MaNguoiDung` int(11) NOT NULL,
  `NgayDatHang` datetime DEFAULT current_timestamp(),
  `TrangThai` enum('cho_xac_nhan','da_xac_nhan','dang_giao','da_giao','da_huy') NOT NULL DEFAULT 'cho_xac_nhan',
  `PhuongThucThanhToan` enum('COD') NOT NULL DEFAULT 'COD',
  `TongTien` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `donhang`
--

INSERT INTO `donhang` (`MaDonHang`, `MaNguoiDung`, `NgayDatHang`, `TrangThai`, `PhuongThucThanhToan`, `TongTien`) VALUES
(1, 2, '2025-05-19 21:06:20', 'da_xac_nhan', 'COD', 15000000.00),
(2, 3, '2025-05-19 21:06:20', 'cho_xac_nhan', 'COD', 600000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giohang`
--

CREATE TABLE `giohang` (
  `MaGioHang` int(11) NOT NULL,
  `MaNguoiDung` int(11) NOT NULL,
  `MaSanPham` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `giohang`
--

INSERT INTO `giohang` (`MaGioHang`, `MaNguoiDung`, `MaSanPham`, `SoLuong`) VALUES
(1, 2, 1, 1),
(2, 3, 3, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoidung`
--

CREATE TABLE `nguoidung` (
  `MaNguoiDung` int(11) NOT NULL,
  `TenDangNhap` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `MatKhau` varchar(255) NOT NULL,
  `VaiTro` enum('admin','khachhang') NOT NULL DEFAULT 'khachhang',
  `NgayTao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoidung`
--

INSERT INTO `nguoidung` (`MaNguoiDung`, `TenDangNhap`, `Email`, `MatKhau`, `VaiTro`, `NgayTao`) VALUES
(1, 'admin1', 'admin1@example.com', '$2y$10$VbUd9GiUuOcxzDq7Ht2CqOOjh8QzqjpDhEG1xVhMxYaTXfOvwL9xO', 'admin', '2025-05-19 21:06:20'),
(2, 'user1', 'user1@example.com', '$2y$10$wRpsZsnPYYeflx0A1i3n4uRY9WfKZ2MLx3JYZ7k0OiNRDukFe/0Kq', 'khachhang', '2025-05-19 21:06:20'),
(3, 'user2', 'user2@example.com', '$2y$10$wRpsZsnPYYeflx0A1i3n4uRY9WfKZ2MLx3JYZ7k0OiNRDukFe/0Kq', 'khachhang', '2025-05-19 21:06:20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `MaSanPham` int(11) NOT NULL,
  `MaDanhMuc` int(11) NOT NULL,
  `TenSanPham` varchar(150) NOT NULL,
  `MoTa` text DEFAULT NULL,
  `Gia` decimal(15,2) NOT NULL,
  `SoLuongTon` int(11) NOT NULL DEFAULT 0,
  `AnhDaiDien` varchar(255) DEFAULT NULL,
  `NgayTao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`MaSanPham`, `MaDanhMuc`, `TenSanPham`, `MoTa`, `Gia`, `SoLuongTon`, `AnhDaiDien`, `NgayTao`) VALUES
(1, 1, 'Samsung Galaxy S21', 'Điện thoại Samsung S21 mới nhất', 15000000.00, 50, 'galaxy_s21.jpg', '2025-05-19 21:06:20'),
(2, 2, 'MacBook Pro 16 inch', 'Laptop MacBook Pro 16 inch 2023', 45000000.00, 20, 'macbook_pro_16.jpg', '2025-05-19 21:06:20'),
(3, 4, 'Ốp lưng iPhone 13', 'Ốp lưng bảo vệ cho iPhone 13', 300000.00, 100, 'oplung_iphone13.jpg', '2025-05-19 21:06:20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trangthaisanpham`
--

CREATE TABLE `trangthaisanpham` (
  `MaTrangThai` int(11) NOT NULL,
  `MaSanPham` int(11) NOT NULL,
  `LoaiTrangThai` enum('ban_chay','goi_y') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `trangthaisanpham`
--

INSERT INTO `trangthaisanpham` (`MaTrangThai`, `MaSanPham`, `LoaiTrangThai`) VALUES
(1, 1, 'ban_chay'),
(2, 3, 'goi_y');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `binhluan`
--
ALTER TABLE `binhluan`
  ADD PRIMARY KEY (`MaBinhLuan`),
  ADD KEY `MaNguoiDung` (`MaNguoiDung`),
  ADD KEY `MaSanPham` (`MaSanPham`);

--
-- Chỉ mục cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD PRIMARY KEY (`MaChiTiet`),
  ADD KEY `MaDonHang` (`MaDonHang`),
  ADD KEY `MaSanPham` (`MaSanPham`);

--
-- Chỉ mục cho bảng `danhmuc`
--
ALTER TABLE `danhmuc`
  ADD PRIMARY KEY (`MaDanhMuc`),
  ADD KEY `MaDanhMucCha` (`MaDanhMucCha`);

--
-- Chỉ mục cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`MaDonHang`),
  ADD KEY `MaNguoiDung` (`MaNguoiDung`);

--
-- Chỉ mục cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`MaGioHang`),
  ADD UNIQUE KEY `unique_cart_item` (`MaNguoiDung`,`MaSanPham`),
  ADD KEY `MaSanPham` (`MaSanPham`);

--
-- Chỉ mục cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`MaNguoiDung`),
  ADD UNIQUE KEY `TenDangNhap` (`TenDangNhap`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`MaSanPham`),
  ADD KEY `MaDanhMuc` (`MaDanhMuc`);

--
-- Chỉ mục cho bảng `trangthaisanpham`
--
ALTER TABLE `trangthaisanpham`
  ADD PRIMARY KEY (`MaTrangThai`),
  ADD UNIQUE KEY `unique_product_status` (`MaSanPham`,`LoaiTrangThai`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `binhluan`
--
ALTER TABLE `binhluan`
  MODIFY `MaBinhLuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  MODIFY `MaChiTiet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `danhmuc`
--
ALTER TABLE `danhmuc`
  MODIFY `MaDanhMuc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `donhang`
--
ALTER TABLE `donhang`
  MODIFY `MaDonHang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `giohang`
--
ALTER TABLE `giohang`
  MODIFY `MaGioHang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `MaNguoiDung` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `MaSanPham` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `trangthaisanpham`
--
ALTER TABLE `trangthaisanpham`
  MODIFY `MaTrangThai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `binhluan`
--
ALTER TABLE `binhluan`
  ADD CONSTRAINT `binhluan_ibfk_1` FOREIGN KEY (`MaNguoiDung`) REFERENCES `nguoidung` (`MaNguoiDung`) ON DELETE CASCADE,
  ADD CONSTRAINT `binhluan_ibfk_2` FOREIGN KEY (`MaSanPham`) REFERENCES `sanpham` (`MaSanPham`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD CONSTRAINT `chitietdonhang_ibfk_1` FOREIGN KEY (`MaDonHang`) REFERENCES `donhang` (`MaDonHang`) ON DELETE CASCADE,
  ADD CONSTRAINT `chitietdonhang_ibfk_2` FOREIGN KEY (`MaSanPham`) REFERENCES `sanpham` (`MaSanPham`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `danhmuc`
--
ALTER TABLE `danhmuc`
  ADD CONSTRAINT `danhmuc_ibfk_1` FOREIGN KEY (`MaDanhMucCha`) REFERENCES `danhmuc` (`MaDanhMuc`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `donhang_ibfk_1` FOREIGN KEY (`MaNguoiDung`) REFERENCES `nguoidung` (`MaNguoiDung`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD CONSTRAINT `giohang_ibfk_1` FOREIGN KEY (`MaNguoiDung`) REFERENCES `nguoidung` (`MaNguoiDung`) ON DELETE CASCADE,
  ADD CONSTRAINT `giohang_ibfk_2` FOREIGN KEY (`MaSanPham`) REFERENCES `sanpham` (`MaSanPham`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`MaDanhMuc`) REFERENCES `danhmuc` (`MaDanhMuc`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `trangthaisanpham`
--
ALTER TABLE `trangthaisanpham`
  ADD CONSTRAINT `trangthaisanpham_ibfk_1` FOREIGN KEY (`MaSanPham`) REFERENCES `sanpham` (`MaSanPham`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
