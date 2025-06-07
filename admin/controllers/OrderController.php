<?php
ob_start(); // Bắt đầu Output Buffering

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

    // Debug: Kiểm tra nội dung biến $orders
    // echo "<pre>Debug \$orders:\n";
    // var_dump($orders);
    // echo "</pre>";
    // exit; // Dừng script để chỉ hiển thị debug

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

  /**
   * Hủy đơn hàng (Admin)
   */
  public function cancel() {
    // Kiểm tra xem request có phải là GET và có tham số id không
    $maDonHang = $_GET['id'] ?? 0;

    // Debug: Mã đơn hàng nhận được
    // echo "Debug Cancel - Order ID: " . $maDonHang . "<br>";

    // Tạm dừng để xem debug - Xóa dòng này sau khi debug xong!
    // Gửi output buffer và flush
    // ob_flush();
    // flush();
    // return; // Dừng script tại đây

    if ($maDonHang <= 0) {
        $_SESSION['error_msg'] = "Mã đơn hàng không hợp lệ!";
        header('Location: admin/index.php?act=order-list'); // Chuyển về trang danh sách đơn hàng admin
        exit;
    }

    try {
        // Lấy trạng thái hiện tại của đơn hàng
        $stmt = $this->pdo->prepare("SELECT TrangThai FROM donhang WHERE MaDonHang = ?");
        $stmt->execute([$maDonHang]);
        $currentStatus = $stmt->fetchColumn();

        // Debug: Trạng thái hiện tại lấy từ DB
        // echo "Debug Cancel - Current Status: [" . $currentStatus . "]<br>";

        // Chỉ cho phép hủy nếu trạng thái là 'cho_xac_nhan' hoặc 'da_xac_nhan'
        if ($currentStatus !== 'cho_xac_nhan' && $currentStatus !== 'da_xac_nhan') {
            // Debug: Điều kiện hủy không thỏa mãn
            // echo "Debug Cancel - Condition not met.<br>";
            $_SESSION['error_msg'] = "Chỉ có thể hủy đơn hàng ở trạng thái Chờ xác nhận hoặc Đã xác nhận!";
            header('Location: index.php?act=order-detail&id=' . $maDonHang); // Chuyển về trang chi tiết đơn hàng
            exit;
        }

        // Cập nhật trạng thái sang 'da_huy'
        $stmt = $this->pdo->prepare("UPDATE donhang SET TrangThai = 'da_huy' WHERE MaDonHang = ?");
        $stmt->execute([$maDonHang]);

        // Debug: Kiểm tra số hàng bị ảnh hưởng bởi UPDATE
        // $affectedRows = $stmt->rowCount();
        // echo "Debug Cancel - Rows affected by UPDATE: " . $affectedRows . "<br>";

        $_SESSION['success_msg'] = "Đã hủy đơn hàng #" . $maDonHang . " thành công!";

    } catch (PDOException $e) {
        $_SESSION['error_msg'] = "Lỗi hủy đơn hàng: " . $e->getMessage();
        // echo "Debug Cancel - Exception: " . $e->getMessage() . "<br>"; // Debug lỗi exception
    }

    // Chuyển hướng về trang chi tiết đơn hàng hoặc danh sách
    if (isset($_SERVER['HTTP_REFERER'])) {
        header('Location: ' . $_SERVER['HTTP_REFERER']); // Quay về trang trước đó (chi tiết hoặc danh sách)
    } else {
        header('Location: index.php?act=order-list');
    }
    exit;
  }
}
