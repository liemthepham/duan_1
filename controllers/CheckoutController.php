<?php

class CheckoutController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function index()
    {
        // Lấy thông tin giỏ hàng (tương tự như viewCart trong CartController)
        $cartItems = [];
        $total = 0;

        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            $productIds = array_keys($_SESSION['cart']);
            $placeholders = str_repeat('?, ', count($productIds) - 1) . '?';
            
            $stmt = $this->pdo->prepare("SELECT * FROM sanpham WHERE MaSanPham IN ($placeholders)");
            $stmt->execute($productIds);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($products as $product) {
                $quantity = $_SESSION['cart'][$product['MaSanPham']];
                $subtotal = $product['Gia'] * $quantity;
                $total += $subtotal;

                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal
                ];
            }
        }

        // Kiểm tra nếu giỏ hàng trống thì chuyển hướng về trang giỏ hàng
        if (empty($cartItems)) {
            $_SESSION['error_msg'] = "Giỏ hàng trống, không thể thanh toán!";
            header('Location: index.php?act=cart');
            exit;
        }

        require_once 'views/checkout.php';
    }

    public function process()
    {
        // Bắt đầu session nếu chưa có
         if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Kiểm tra phương thức POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?act=checkout');
            exit;
        }

        // 1. Lấy thông tin từ form (Tên, SĐT, Địa chỉ, Ghi chú...)
        $full_name = $_POST['full_name'] ?? '';
        $phone_number = $_POST['phone_number'] ?? '';
        $address = $_POST['address'] ?? '';
        $note = $_POST['note'] ?? '';
        $payment_method = $_POST['payment_method'] ?? 'cod'; // Mặc định là COD

        // Kiểm tra thông tin bắt buộc
        if (empty($full_name) || empty($phone_number) || empty($address)) {
            $_SESSION['error_msg'] = "Vui lòng điền đầy đủ thông tin giao hàng bắt buộc!";
            header('Location: index.php?act=checkout');
            exit;
        }

        // 2. Kiểm tra thông tin người dùng đã đăng nhập chưa (tùy requirement)
        // Mặc định là đơn hàng của khách vãng lai (MaNguoiDung = NULL) nếu chưa đăng nhập
        $userId = isset($_SESSION['user']['MaNguoiDung']) ? $_SESSION['user']['MaNguoiDung'] : null;

        // 3. Lấy thông tin giỏ hàng từ session và 4. Tính tổng tiền
        $cartItems = [];
        $total = 0;

        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            $productIds = array_keys($_SESSION['cart']);
            $placeholders = str_repeat('?, ', count($productIds) - 1) . '?';
            
            // Lấy thông tin sản phẩm từ DB để đảm bảo giá chính xác tại thời điểm đặt hàng
            $stmt = $this->pdo->prepare("SELECT * FROM sanpham WHERE MaSanPham IN ($placeholders)");
            $stmt->execute($productIds);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Tạo mảng sản phẩm trong giỏ hàng với thông tin chi tiết
            $productsInCart = [];
            foreach($products as $product) {
                $productsInCart[$product['MaSanPham']] = $product;
            }

            foreach ($_SESSION['cart'] as $productId => $quantity) {
                 if (isset($productsInCart[$productId])) {
                    $product = $productsInCart[$productId];
                    $price = $product['Gia'];
                    $subtotal = $price * $quantity;
                    $total += $subtotal;

                     $cartItems[] = [
                        'product' => $product,
                        'quantity' => $quantity,
                        'subtotal' => $subtotal
                    ];
                } else {
                    // Sản phẩm trong giỏ hàng không tồn tại trong DB? Cần xử lý lỗi hoặc bỏ qua.
                    // Tạm thời bỏ qua và có thể thêm log lỗi sau.
                }
            }
        } else {
            // Giỏ hàng trống, chuyển hướng về trang giỏ hàng
            $_SESSION['error_msg'] = "Giỏ hàng trống, không thể đặt hàng!";
            header('Location: index.php?act=cart');
            exit;
        }

        // Kiểm tra lại nếu giỏ hàng rỗng sau khi lọc sản phẩm không tồn tại
         if (empty($cartItems)) {
            $_SESSION['error_msg'] = "Giỏ hàng trống hoặc chứa sản phẩm không hợp lệ!";
            header('Location: index.php?act=cart');
            exit;
         }

        try {
            $this->pdo->beginTransaction(); // Bắt đầu transaction

            // 5. Lưu thông tin đơn hàng vào bảng donhang
            $stmt = $this->pdo->prepare("
                INSERT INTO donhang (MaNguoiDung, TenNguoiNhan, SdtNguoiNhan, DiaChiNguoiNhan, GhiChu, TongTien, NgayDatHang, PhuongThucThanhToan, TrangThaiDonHang)
                VALUES (?, ?, ?, ?, ?, ?, NOW(), ?, ?)  
            ");
            $stmt->execute([
                $userId,
                $full_name,
                $phone_number,
                $address,
                $note,
                $total,
                $payment_method,
                'Pending' // Trạng thái đơn hàng mặc định
            ]);

            $orderId = $this->pdo->lastInsertId(); // Lấy ID của đơn hàng vừa tạo

            // 6. Lưu chi tiết từng sản phẩm vào bảng chitietdonhang
            $stmt = $this->pdo->prepare("
                INSERT INTO chitietdonhang (MaDonHang, MaSanPham, SoLuong, DonGia, ThanhTien)
                VALUES (?, ?, ?, ?, ?)
            ");

            foreach ($cartItems as $item) {
                $product = $item['product'];
                $quantity = $item['quantity'];
                $price = $product['Gia']; // Lấy giá từ sản phẩm đã fetch từ DB
                $subtotal = $item['subtotal'];

                $stmt->execute([
                    $orderId,
                    $product['MaSanPham'],
                    $quantity,
                    $price,
                    $subtotal
                ]);
                 // 7. Cập nhật số lượng tồn kho sản phẩm (nếu có) - Cần thêm logic cập nhật cột SoLuongTonKho trong bảng sanpham
                 // Ví dụ: UPDATE sanpham SET SoLuongTonKho = SoLuongTonKho - ? WHERE MaSanPham = ?
                 // $updateStockStmt = $this->pdo->prepare("UPDATE sanpham SET SoLuongTonKho = SoLuongTonKho - ? WHERE MaSanPham = ?");
                 // $updateStockStmt->execute([$quantity, $product['MaSanPham']]);
            }

            $this->pdo->commit(); // Hoàn tất transaction

            // 8. Xóa giỏ hàng trong session
            unset($_SESSION['cart']);

            // 9. Chuyển hướng đến trang thông báo đặt hàng thành công
            $_SESSION['success_msg'] = "Đơn hàng của bạn đã được đặt thành công!";
            header('Location: index.php?act=order-success'); // Cần tạo trang order-success
            exit;

        } catch (\Exception $e) {
            $this->pdo->rollBack(); // Hoàn tác transaction nếu có lỗi
            $_SESSION['error_msg'] = "Đã xảy ra lỗi khi xử lý đơn hàng: " . $e->getMessage();
            header('Location: index.php?act=checkout');
            exit;
        }
    }

    // Phương thức hiển thị trang đặt hàng thành công (cần tạo view tương ứng)
    public function orderSuccess(){
        require_once 'views/order-success.php';
    }
} 