<?php
class OrderController
{
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function detail() {
        $maDonHang = $_GET['id'] ?? 0;
        if ($maDonHang <= 0) {
            header('Location: index.php?act=orders');
            exit;
        }

        // Lấy thông tin đơn hàng
        $stmt = $this->pdo->prepare("SELECT d.*, u.TenDangNhap FROM donhang d LEFT JOIN nguoidung u ON d.MaNguoiDung = u.MaNguoiDung WHERE d.MaDonHang = ?");
        $stmt->execute([$maDonHang]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        // Lấy chi tiết sản phẩm trong đơn
        $stmt = $this->pdo->prepare("SELECT ct.*, sp.TenSanPham, sp.AnhDaiDien FROM chitietdonhang ct JOIN sanpham sp ON ct.MaSanPham = sp.MaSanPham WHERE ct.MaDonHang = ?");
        $stmt->execute([$maDonHang]);
        $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require 'views/order-detail.php';
    }

    public function listOrders() {
        if (!isset($_SESSION['user']['MaNguoiDung'])) {
            header('Location: index.php?act=login');
            exit;
        }
        $userId = $_SESSION['user']['MaNguoiDung'];
        $stmt = $this->pdo->prepare("SELECT * FROM donhang WHERE MaNguoiDung = ? ORDER BY NgayDatHang DESC");
        $stmt->execute([$userId]);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require 'views/order-list.php';
    }
} 