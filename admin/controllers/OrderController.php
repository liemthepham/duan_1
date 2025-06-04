<?php
require_once __DIR__ . '/../models/OrderModel.php';

class OrderController
{
  private $model;
  private $pdo;

  public function __construct($pdo)
  {
    $this->pdo = $pdo;
    $this->model = new OrderModel();
  }

  /**
   * Hiển thị danh sách đơn hàng
   */
  public function index()
  {
    // gọi model để lấy dữ liệu
    $orders = $this->model->getAll();

    // include layout trên (sidebar, header)
    require_once __DIR__ . '/../views/layouts/layouts_top.php';

    // include view chính
    require_once __DIR__ . '/../views/order/index.php';

    // include layout dưới (footer, script)
    require_once __DIR__ . '/../views/layouts/layout_bottom.php';
  }

  public function detail()
  {
    $maDonHang = $_GET['id'] ?? 0;
    if ($maDonHang <= 0) {
      header('Location: admin/index.php?act=orders'); // Chuyển về trang danh sách đơn hàng admin
      exit;
    }

    // Lấy thông tin đơn hàng (kèm tên khách hàng nếu có)
    $stmt = $this->pdo->prepare("SELECT d.*, u.TenDangNhap FROM donhang d LEFT JOIN nguoidung u ON d.MaNguoiDung = u.MaNguoiDung WHERE d.MaDonHang = ?");
    $stmt->execute([$maDonHang]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    // Kiểm tra nếu không tìm thấy đơn hàng
    if (!$order) {
      $_SESSION['error_msg'] = "Không tìm thấy đơn hàng!";
      header('Location: admin/index.php?act=orders');
      exit;
    }

    // Lấy chi tiết sản phẩm trong đơn
    $stmt = $this->pdo->prepare("SELECT ct.*, sp.TenSanPham, sp.AnhDaiDien FROM chitietdonhang ct JOIN sanpham sp ON ct.MaSanPham = sp.MaSanPham WHERE ct.MaDonHang = ?");
    $stmt->execute([$maDonHang]);
    $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
    require_once __DIR__ . '/../views/layouts/layouts_top.php';


    require_once __DIR__ .'/../views/order-detail.php'; // View trong thư mục admin/views
    require_once __DIR__ . '/../views/layouts/layout_bottom.php';
  }

  /**
   * Cập nhật trạng thái đơn hàng (Admin)
   */
  public function updateStatus() {
    // Bắt đầu session nếu chưa có
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }

    // Kiểm tra nếu request không phải POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        // Chuyển hướng về trang danh sách đơn hàng admin hoặc trang chi tiết (tùy logic)
        $_SESSION['error_msg'] = "Phương thức yêu cầu không hợp lệ!";
        header('Location: /duan_1/admin/index.php?act=order-list');
        exit;
    }

    // Lấy dữ liệu từ POST
    $maDonHang = $_POST['ma_don_hang'] ?? 0;
    $trangThaiMoi = $_POST['trang_thai'] ?? '';

    // Kiểm tra dữ liệu
    if ($maDonHang <= 0 || empty($trangThaiMoi)) {
        $_SESSION['error_msg'] = "Dữ liệu cập nhật không hợp lệ!";
        header('Location: /duan_1/admin/index.php?act=order-list'); // Hoặc order-detail&id=$maDonHang
        exit;
    }

    // Kiểm tra trạng thái mới có hợp lệ không (tùy chọn, dựa trên enum trong DB)
    // Các trạng thái Admin có thể cập nhật: da_xac_nhan, dang_giao, da_giao
    $validStatuses = ['da_xac_nhan', 'dang_giao', 'da_giao'];
    if (!in_array($trangThaiMoi, $validStatuses)) {
         $_SESSION['error_msg'] = "Trạng thái đơn hàng không hợp lệ!";
         header('Location: /duan_1/admin/index.php?act=order-detail&id=' . $maDonHang);
         exit;
    }

    try {
        // Cập nhật trạng thái trong database
        $stmt = $this->pdo->prepare("UPDATE donhang SET TrangThai = ? WHERE MaDonHang = ?");
        $stmt->execute([$trangThaiMoi, $maDonHang]);

        $_SESSION['success_msg'] = "Cập nhật trạng thái đơn hàng #" . $maDonHang . " thành công!";
        header('Location: /duan_1/admin/index.php?act=order-list'); // Chuyển về trang danh sách đơn hàng admin
        exit;

    } catch (PDOException $e) {
        $_SESSION['error_msg'] = "Lỗi cập nhật trạng thái đơn hàng: " . $e->getMessage();
        header('Location: /duan_1/admin/index.php?act=order-detail&id=' . $maDonHang);
        exit;
    }
  }
}
