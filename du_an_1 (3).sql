-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 04, 2025 lúc 04:57 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.1.25

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
(3, 11, 3, 'được', '2025-06-02 07:37:25');

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
(4, 'Ốp lưng1', NULL),
(5, 'Điện Thoại', NULL),
(9, 'LapTop', NULL),
(11, 'Phụ Kiện', NULL);

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
  `TongTien` decimal(15,2) NOT NULL,
  `TenKhachHang` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `donhang`
--

INSERT INTO `donhang` (`MaDonHang`, `MaNguoiDung`, `NgayDatHang`, `TrangThai`, `PhuongThucThanhToan`, `TongTien`, `TenKhachHang`) VALUES
(1, 2, '2025-05-19 21:06:20', 'da_xac_nhan', 'COD', 15000000.00, 'Khách hàng 1'),
(2, 3, '2025-05-19 21:06:20', 'cho_xac_nhan', 'COD', 600000.00, 'Khách hàng 2');

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
      `HoTen` varchar(255) DEFAULT NULL,         -- THÊM DÒNG NÀY
      `SoDienThoai` varchar(20) DEFAULT NULL,   -- THÊM DÒNG NÀY
      `DiaChi` TEXT DEFAULT NULL,               -- THÊM DÒNG NÀY
      `NgayTao` datetime DEFAULT current_timestamp()
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoidung`
--

INSERT INTO `nguoidung` (`MaNguoiDung`, `TenDangNhap`, `Email`, `MatKhau`, `VaiTro`, `NgayTao`) VALUES
(1, 'admin1', 'admin1@example.com', '$2y$10$VbUd9GiUuOcxzDq7Ht2CqOOjh8QzqjpDhEG1xVhMxYaTXfOvwL9xO', 'admin', '2025-05-19 21:06:20'),
(2, 'user1', 'user1@example.com', '$2y$10$wRpsZsnPYYeflx0A1i3n4uRY9WfKZ2MLx3JYZ7k0OiNRDukFe/0Kq', 'khachhang', '2025-05-19 21:06:20'),
(3, 'user2', 'user2@example.com', '$2y$10$cxQyx.WmdH60VS6UJcqHyeVFAnEhUUnNn4qmFbeimEw1lHAJvJKbm', 'khachhang', '2025-05-19 21:06:20'),
(4, 'admin3@gmail.com', 'admin3@gmail.com', '$2y$10$axL5ayyzmAWW2IFFGehz5.Bi8XVVVErfW9SiuxBuHYRdSFnYJk7WW', 'admin', '2025-05-21 23:55:37'),
(6, 'user8', 'user8@gmail.com', '$2y$10$DTcSVmK/hKp8yflgM6SF..VHxdOWSB7ZVd4OqcurqXjhtUIhoetSC', 'khachhang', '2025-05-22 19:50:20'),
(8, 'user9', 'user9@gmail.com', '$2y$10$rz3nzL7Z7YrO3W9HG7niO.7No2qxw805yEiO6QSNcSaT0cCpq5wKu', 'khachhang', '2025-05-22 20:04:33'),
(10, 'admin9', 'admin9@gmail.com', '$2y$10$n//nh6hg/mF13k6.EAP1f.Liv.Q4oCAliUMcOFZAFbIyD7ICHo0R.', 'admin', '2025-05-26 04:56:30'),
(11, 'liemthepham1', 'liemthepham1@gmail.com', '$2y$10$nCuou55xsQJgTjAZ0chq0.tOrcAPZS4DQZlPSbNvg2j.DN6T954vC', 'khachhang', '2025-05-26 07:20:31'),
(12, 'liemthepham2', 'liemliem070804@gmail.com', '$2y$10$kHb12jBV2xA6CzdxNR8YEeXc9GgcC8rvO790ASdXocLuJuhjAtZvq', 'khachhang', '2025-05-27 23:47:56'),
(13, 'liemthepham3', 'liemlim@gmail.com', '$2y$10$EIiWi1.f.wrEcUFJ8KfhMuiUXK1o4vd67PrWv1TXSWgjWpYDhBYJq', 'khachhang', '2025-05-27 23:51:58'),
(14, 'liemhadong1', 'liemhadong1@gmail.com', '$2y$10$JBSG.T8PYeBC6Cmv8xP8DuK4XtjUyIrpyT5jeOX6z5QzO7Mchg7Pm', 'khachhang', '2025-05-28 18:10:13'),
(15, 'liemhadong2', 'liemhadong2@gmail.com', '$2y$10$wcTalLjKRSQo6n6Q9I8EiuDxoeGOPc5IXViBQa9NSKCXoTwTQOW5W', 'khachhang', '2025-05-28 18:11:31'),
(16, 'admintech', 'admintech@gmail.com', '$2y$10$RI0RpaRwGJKMr1naTzA94u6vQMnngYCA9RBPeEh3WALM40FDZPmeS', 'admin', '2025-05-30 07:31:54'),
(17, 'liemhadong3', 'liemhadong3@gmail.com', '$2y$10$dzuHZ8hzBKS74cnRscXvhu7qj/a6mZrK95hZAl3VHO0QXPWPyaH4q', 'admin', '2025-06-03 19:29:10'),
(18, 'liemlinh', 'liemlinh2200@gmail.com', '$2y$10$ACnR2gvUCX9k/1kT3kVeN.8Oa1PvjN6EjaM4ylGixXXb7NBcuRbX2', 'khachhang', '2025-06-04 02:37:26'),
(19, 'admin4@gmail.com', 'admin4@gmail.com', '$2y$10$0GsZEy7VF/murc0QM2wOnevur5j3S4/ZzZboiIP5/b0h/kByk6IXi', 'admin', '2025-06-04 05:03:48'),
(20, 'admin7@gmail.com', 'admin7@gmail.com', '$2y$10$yURppgbKbMeJlruF4plwa.UJvNX3G.gIVKw9NRTazJFv5endUKXQy', 'admin', '2025-06-04 05:06:07'),
(21, 'admin8@gmail.com', 'admin8@gmail.com', '$2y$10$mQKcy1/HuYtt5WaW.OysEOaIkdFYOgfT.CyctwSb9sS1WblEsJoAu', 'admin', '2025-06-04 05:24:20');

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
(3, 4, 'Ốp lưng iPhone ', 'Ốp lưng bảo vệ cho iPhone 13', 30000.00, 100, 'prd_683da19259abe.jpeg', '2025-05-19 21:06:20'),
(5, 5, 'điện thoại samsung galaxy 3', 'đẹp mê li', 1000000.00, 100, 'prd_682efdcdaa25a.jpg', '2025-05-22 17:34:53'),
(21, 5, 'điện thoại iphone 11', 'tuyệt', 2000000.00, 100, 'prd_6835adf0da1fd.jpg', '2025-05-27 19:20:00'),
(22, 5, 'Điện Thoại Iphone 6', 'nhỏ gọn tiện lợi', 3700000.00, 100, 'prd_6835af5fa7c5d.jpg', '2025-05-27 19:22:01'),
(23, 5, 'Điện Thoại Iphone 7', 'nhỏ gọn tiện lợi', 5000000.00, 200, 'prd_6835af396553e.jpg', '2025-05-27 19:22:33'),
(24, 5, 'Điện thoại iphone 8', 'Nhỏ gọn tiện lợi', 6000000.00, 400, 'prd_6835af21b4943.jpg', '2025-05-27 19:23:00'),
(25, 5, 'Điện thoại iphone XSM', 'Nhỏ Gọn,Tiện Lợi', 7000000.00, 250, 'prd_6835aefb6e0ec.webp', '2025-05-27 19:23:31'),
(26, 4, 'ốp lưng iphone 12', 'màu hồng', 100000.00, 10000, 'prd_6835b063886c9.webp', '2025-05-27 19:30:27'),
(27, 4, 'Ốp Lưng Cao su', 'Tinh Tế', 30000.00, 2000, 'prd_6835b0af63167.jpg', '2025-05-27 19:31:43'),
(28, 4, 'Ốp Lưng Italy', 'tuyệt', 45000.00, 3000, 'prd_6835b0fbebe52.jpeg', '2025-05-27 19:32:59'),
(29, 9, 'Macbock', 'Đẹp', 40000000.00, 2000, 'prd_6835c55201733.jpg', '2025-05-27 19:34:54'),
(30, 9, 'Laptop lenovo', 'Tiện Lợi', 29000000.00, 400, 'prd_6835b19cb55ae.png', '2025-05-27 19:35:40'),
(31, 9, 'LapTop Acer', 'Acer 2024', 32000000.00, 350, 'prd_6835b1c1ee554.jpg', '2025-05-27 19:36:17');

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
  MODIFY `MaBinhLuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  MODIFY `MaChiTiet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `danhmuc`
--
ALTER TABLE `danhmuc`
  MODIFY `MaDanhMuc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  MODIFY `MaNguoiDung` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `MaSanPham` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

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
