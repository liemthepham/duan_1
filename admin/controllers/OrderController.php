<?php
require_once __DIR__ . '/../models/OrderModel.php';

class OrderController {
  private $model;
  private $pdo;

  public function __construct($pdo) {
    $this->pdo = $pdo;
    $this->model = new OrderModel();
  }

  /**
   * Hiển thị danh sách đơn hàng
   */
  public function index() {
    // gọi model để lấy dữ liệu
    $orders = $this->model->getAll();

    // include layout trên (sidebar, header)
    require_once __DIR__ . '/../views/layouts/layouts_top.php';

    // include view chính
    require_once __DIR__ . '/../views/order/index.php';

    // include layout dưới (footer, script)
    require_once __DIR__ . '/../views/layouts/layout_bottom.php';
  }

  public function detail() {
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

    require 'views/order-detail.php'; // View trong thư mục admin/views
  }
}
