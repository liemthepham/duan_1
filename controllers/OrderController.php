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

        // Lấy mã đơn hàng từ GET (thay vì POST)
        $maDonHang = $_GET['id'] ?? 0;

        // Kiểm tra dữ liệu
        if ($maDonHang <= 0) {
            $_SESSION['error_msg'] = "Mã đơn hàng không hợp lệ!";
            header('Location: index.php?act=orders');
            exit;
        }

        $userId = $_SESSION['user']['MaNguoiDung'];

        try {
            // Kiểm tra đơn hàng có tồn tại và thuộc về user hiện tại không, và trạng thái hiện tại cho phép chuyển sang hoàn thành (ví dụ: đang giao hoặc đã giao)
            $stmt = $this->pdo->prepare("SELECT MaDonHang, TrangThai FROM donhang WHERE MaDonHang = ? AND MaNguoiDung = ? AND (TrangThai = 'dang_giao' OR TrangThai = 'da_giao')");
            $stmt->execute([$maDonHang, $userId]);
            $order = $stmt->fetch(PDO::FETCH_ASSOC);

            // Debug: Kiểm tra kết quả của câu lệnh SELECT
            echo "Debug Order Select Result: ";
            var_dump($order);
            // return; // Tạm dừng để xem kết quả debug

            if (!$order) {
                $_SESSION['error_msg'] = "Không thể hoàn thành đơn hàng này (có thể không tồn tại, không thuộc về bạn hoặc chưa ở trạng thái 'Đang giao').";
                header('Location: index.php?act=order-detail&id=' . $maDonHang);
                exit;
            }

            // Cập nhật trạng thái sang "da_nhan"
            $newStatus = 'da_nhan';
            echo "Debug: Attempting to update order ID " . $maDonHang . " to status: " . $newStatus; // Debug mới
            // return; // Tạm dừng để xem debug

            $sql = "UPDATE donhang SET TrangThai = ? WHERE MaDonHang = ?";
            $stmt = $this->pdo->prepare($sql);

            // Debug: Kiểm tra các tham số được bind
            echo "<br>Debug: Binding parameters: ";
            var_dump([$newStatus, $maDonHang]);
            // return; // Tạm dừng để xem debug

            $stmt->execute([$newStatus, $maDonHang]);

            // Debug: Kiểm tra số hàng bị ảnh hưởng bởi UPDATE
            $affectedRows = $stmt->rowCount();
            echo "<br>Debug: Rows affected by update: " . $affectedRows;
            // return; // Tạm dừng để xem kết quả debug

            $_SESSION['success_msg'] = "Đã xác nhận hoàn thành đơn hàng #" . $maDonHang . "!";
            header('Location: index.php?act=order-detail&id=' . $maDonHang); // Chuyển về trang chi tiết đơn hàng
            exit;

        } catch (PDOException $e) {
            $_SESSION['error_msg'] = "Lỗi cập nhật trạng thái đơn hàng: " . $e->getMessage();
            header('Location: index.php?act=order-detail&id=' . $maDonHang);
            exit;
        }
    }

    /**
     * Cập nhật trạng thái đơn hàng sang "Đã hủy" (Client)
     */
    public function cancelOrder() {
        // Bắt đầu session nếu chưa có
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Kiểm tra người dùng đã đăng nhập chưa
        if (!isset($_SESSION['user']['MaNguoiDung'])) {
            $_SESSION['error_msg'] = "Vui lòng đăng nhập để hủy đơn hàng!";
            header('Location: index.php?act=login');
            exit;
        }

        // Lấy mã đơn hàng từ GET
        $maDonHang = $_GET['id'] ?? 0;

        // Kiểm tra dữ liệu
        if ($maDonHang <= 0) {
            $_SESSION['error_msg'] = "Mã đơn hàng không hợp lệ!";
            header('Location: index.php?act=orders');
            exit;
        }

        $userId = $_SESSION['user']['MaNguoiDung'];

        try {
            // Kiểm tra đơn hàng có tồn tại, thuộc về user hiện tại và ở trạng thái có thể hủy được (ví dụ: 'cho_xac_nhan' hoặc 'da_xac_nhan')
            $stmt = $this->pdo->prepare("SELECT MaDonHang, TrangThai FROM donhang WHERE MaDonHang = ? AND MaNguoiDung = ? AND (TrangThai = 'cho_xac_nhan' OR TrangThai = 'da_xac_nhan')");
            $stmt->execute([$maDonHang, $userId]);
            $order = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$order) {
                $_SESSION['error_msg'] = "Không thể hủy đơn hàng này (có thể không tồn tại, không thuộc về bạn hoặc không ở trạng thái có thể hủy).!";
                header('Location: index.php?act=order-detail&id=' . $maDonHang); // Chuyển về trang chi tiết đơn hàng
                exit;
            }

            // Cập nhật trạng thái sang "da_huy"
            $stmt = $this->pdo->prepare("UPDATE donhang SET TrangThai = 'da_huy' WHERE MaDonHang = ?");
            $stmt->execute([$maDonHang]);

            $_SESSION['success_msg'] = "Đã hủy đơn hàng #" . $maDonHang . " thành công!";
            header('Location: index.php?act=order-list'); // Chuyển về trang danh sách đơn hàng
            exit;

        } catch (PDOException $e) {
            $_SESSION['error_msg'] = "Lỗi hủy đơn hàng: " . $e->getMessage();
            header('Location: index.php?act=order-list'); // Chuyển về trang danh sách đơn hàng
            exit;
        }
    }
} 