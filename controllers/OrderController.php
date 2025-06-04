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

    /**
     * Cập nhật trạng thái đơn hàng sang "Hoàn thành" (Client)
     */
    public function completeOrder() {
        // Bắt đầu session nếu chưa có
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Kiểm tra người dùng đã đăng nhập chưa
        if (!isset($_SESSION['user']['MaNguoiDung'])) {
            $_SESSION['error_msg'] = "Vui lòng đăng nhập để cập nhật trạng thái đơn hàng!";
            header('Location: index.php?act=login');
            exit;
        }

        // Kiểm tra phương thức request là POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
             $_SESSION['error_msg'] = "Phương thức yêu cầu không hợp lệ!";
             header('Location: index.php?act=orders'); // Chuyển hướng về danh sách đơn hàng user
             exit;
        }

        // Lấy mã đơn hàng từ POST
        $maDonHang = $_POST['ma_don_hang'] ?? 0;

        // Kiểm tra dữ liệu
        if ($maDonHang <= 0) {
            $_SESSION['error_msg'] = "Mã đơn hàng không hợp lệ!";
            header('Location: index.php?act=orders');
            exit;
        }

        $userId = $_SESSION['user']['MaNguoiDung'];

        try {
            // Kiểm tra đơn hàng có tồn tại và thuộc về user hiện tại không, và trạng thái hiện tại cho phép chuyển sang hoàn thành (ví dụ: đang giao)
            $stmt = $this->pdo->prepare("SELECT MaDonHang, TrangThai FROM donhang WHERE MaDonHang = ? AND MaNguoiDung = ? AND TrangThai = 'dang_giao'");
            $stmt->execute([$maDonHang, $userId]);
            $order = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$order) {
                $_SESSION['error_msg'] = "Không thể hoàn thành đơn hàng này (có thể không tồn tại, không thuộc về bạn hoặc chưa ở trạng thái 'Đang giao').";
                header('Location: index.php?act=order-detail&id=' . $maDonHang);
                exit;
            }

            // Cập nhật trạng thái sang "hoan_thanh"
            // LƯU Ý: Đảm bảo cột TrangThai trong bảng donhang có enum 'hoan_thanh'
            $stmt = $this->pdo->prepare("UPDATE donhang SET TrangThai = 'hoan_thanh' WHERE MaDonHang = ?");
            $stmt->execute([$maDonHang]);

            $_SESSION['success_msg'] = "Đã xác nhận hoàn thành đơn hàng #" . $maDonHang . "!";
            header('Location: index.php?act=order-detail&id=' . $maDonHang); // Chuyển về trang chi tiết đơn hàng
            exit;

        } catch (PDOException $e) {
            $_SESSION['error_msg'] = "Lỗi cập nhật trạng thái đơn hàng: " . $e->getMessage();
            header('Location: index.php?act=order-detail&id=' . $maDonHang);
            exit;
        }
    }
} 