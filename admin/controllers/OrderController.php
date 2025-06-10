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
    // Debug: Kiểm tra xem phương thức index có được gọi không
    // echo "Debug: Admin OrderController index method called!";
    // exit; // Tạm dừng để xem debug, xóa dòng này sau khi debug xong

    // gọi model để lấy dữ liệu
    $orders = $this->model->getAll();

    // include layout trên (sidebar, header)
    require_once __DIR__ . '/../views/layouts/layouts_top.php';

    // include view chính
    require_once __DIR__ . '/../views/order/index.php';

    // include layout dưới (footer, script)
    require_once __DIR__ . '/../views/layouts/layout_bottom.php';
  }

  /**
   * Trả về danh sách đơn hàng dưới dạng JSON cho AJAX requests.
   */
  public function getOrdersJson()
  {
    $orders = $this->model->getAll();
    header('Content-Type: application/json');
    echo json_encode($orders);
    exit;
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
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $maDonHang = $_POST['ma_don_hang'] ?? 0;
      $trangThai = $_POST['trang_thai'] ?? '';

      // Kiểm tra trạng thái hiện tại của đơn hàng
      $stmt = $this->pdo->prepare("SELECT TrangThai FROM donhang WHERE MaDonHang = ?");
      $stmt->execute([$maDonHang]);
      $currentStatus = $stmt->fetchColumn();

      // Nếu đơn hàng đã ở trạng thái da_giao thì không cho phép thay đổi
      if ($currentStatus === 'da_giao') {
        $_SESSION['error_msg'] = "Không thể thay đổi trạng thái của đơn hàng đã giao!";
        header('Location: index.php?act=order-detail&id=' . $maDonHang);
        exit;
      }

      // Kiểm tra trạng thái mới có hợp lệ không
      $validStatuses = ['cho_xac_nhan', 'da_xac_nhan', 'dang_giao', 'da_giao'];
      if (!in_array($trangThai, $validStatuses)) {
        $_SESSION['error_msg'] = "Trạng thái không hợp lệ!";
        header('Location: index.php?act=order-detail&id=' . $maDonHang);
        exit;
      }

      try {
        $stmt = $this->pdo->prepare("UPDATE donhang SET TrangThai = ? WHERE MaDonHang = ?");
        $stmt->execute([$trangThai, $maDonHang]);
        $_SESSION['success_msg'] = "Cập nhật trạng thái đơn hàng thành công!";
      } catch (PDOException $e) {
        $_SESSION['error_msg'] = "Lỗi cập nhật trạng thái: " . $e->getMessage();
      }
    }
    header('Location: index.php?act=order-detail&id=' . $maDonHang);
    exit;
  }

  public function updatePaymentStatus() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $maDonHang = $_POST['ma_don_hang'] ?? 0;
        $trangThaiThanhToan = $_POST['trang_thai_thanh_toan'] ?? '';

        // Validate input
        if ($maDonHang <= 0 || !in_array($trangThaiThanhToan, ['chua_thanh_toan', 'da_thanh_toan', 'hoan_tien'])) {
            $_SESSION['error_msg'] = "Dữ liệu cập nhật không hợp lệ.";
            header('Location: index.php?act=order-list');
            exit;
        }

        try {
            $stmt = $this->pdo->prepare("UPDATE donhang SET TrangThaiThanhToan = ? WHERE MaDonHang = ?");
            $stmt->execute([$trangThaiThanhToan, $maDonHang]);

            $_SESSION['success_msg'] = "Cập nhật trạng thái thanh toán cho đơn hàng #" . $maDonHang . " thành công!";
        } catch (PDOException $e) {
            $_SESSION['error_msg'] = "Lỗi cập nhật trạng thái thanh toán: " . $e->getMessage();
        }
    }
    header('Location: index.php?act=order-list');
    exit;
  }

  public function cancel() {
    // Kiểm tra xem request có phải là GET và có tham số id không
    $maDonHang = $_GET['id'] ?? 0;

    // Debug: Ghi mã đơn hàng nhận được vào log
    error_log("Admin Order Cancel Debug: Order ID received - " . $maDonHang);

    if ($maDonHang <= 0) {
      $_SESSION['error_msg'] = "Mã đơn hàng không hợp lệ!";
      header('Location: ' . BASE_URL . 'admin/index.php?act=order-list'); // Chuyển về trang danh sách đơn hàng admin
      exit;
    }

    try {
      // Lấy trạng thái hiện tại của đơn hàng
      $stmt = $this->pdo->prepare("SELECT TrangThai FROM donhang WHERE MaDonHang = ?");
      $stmt->execute([$maDonHang]);
      $currentStatus = $stmt->fetchColumn();

      // Debug: Ghi trạng thái hiện tại lấy từ DB vào log
      error_log("Admin Order Cancel Debug: Current Status - " . $currentStatus);

      // Chỉ cho phép hủy nếu trạng thái là 'cho_xac_nhan' hoặc 'da_xac_nhan'
      if ($currentStatus === 'cho_xac_nhan' || $currentStatus === 'da_xac_nhan') {
        // Thực hiện hủy đơn hàng
        $stmt = $this->pdo->prepare("UPDATE donhang SET TrangThai = 'da_huy' WHERE MaDonHang = ?");
        $stmt->execute([$maDonHang]);
        $_SESSION['success_msg'] = "Hủy đơn hàng thành công!";
      } else {
        $_SESSION['error_msg'] = "Không thể hủy đơn hàng khi trạng thái đơn hàng không phải 'chờ xác nhận' hoặc 'đã xác nhận'! (Trạng thái hiện tại: " . $currentStatus . ")";
      }
    } catch (PDOException $e) {
      $_SESSION['error_msg'] = "Lỗi hủy đơn hàng: " . $e->getMessage();
    }

    header('Location: ' . BASE_URL . 'admin/index.php?act=order-list'); // Thay đổi chuyển hướng về trang danh sách đơn hàng admin
    exit;
  }
}
