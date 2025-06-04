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
        // Lấy thông tin giỏ hàng từ session
        $cart = $_SESSION['cart'] ?? [];
        $cartItems = [];
        $total = 0;

        // Lấy danh sách sản phẩm được chọn từ POST nếu có (khi chuyển từ giỏ hàng)
        $selectedProducts = $_POST['selected_products'] ?? array_keys($cart); // Mặc định chọn tất cả nếu không có POST

        // Lọc giỏ hàng chỉ giữ lại các sản phẩm đã được chọn
        $filteredCart = array_filter(
            $cart,
            function($productId) use ($selectedProducts) {
                return in_array($productId, $selectedProducts);
            },
            ARRAY_FILTER_USE_KEY
        );

        if (empty($filteredCart)) {
            $_SESSION['error_msg'] = "Giỏ hàng trống hoặc không có sản phẩm nào được chọn!";
            header('Location: index.php?act=cart');
            exit;
        }

        $productIds = array_keys($filteredCart);
        $placeholders = str_repeat('?, ', count($productIds) - 1) . '?';

        // Lấy thông tin sản phẩm từ DB để đảm bảo giá chính xác
        $stmt = $this->pdo->prepare("SELECT * FROM sanpham WHERE MaSanPham IN ($placeholders)");
        $stmt->execute($productIds);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Tạo mảng sản phẩm trong giỏ hàng với thông tin chi tiết và tính tổng tiền
        $productsInCart = [];
        foreach($products as $product) {
            $productsInCart[$product['MaSanPham']] = $product;
        }

        $total = 0;
        foreach ($filteredCart as $productId => $quantity) {
             if (isset($productsInCart[$productId])) {
                $product = $productsInCart[$productId];
                $price = $product['Gia'];
                $subtotal = $price * $quantity;
                $total += $subtotal;

                 $cartItems[] = [ // Sử dụng lại $cartItems cho view
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal
                ];
            }
        }

        // Lưu danh sách sản phẩm được chọn vào session để sử dụng ở trang process
        $_SESSION['selected_for_checkout'] = $selectedProducts;

        // Kiểm tra nếu giỏ hàng trống sau khi lọc thì chuyển hướng về trang giỏ hàng
        if (empty($cartItems)) {
            $_SESSION['error_msg'] = "Giỏ hàng trống sau khi lọc sản phẩm, không thể thanh toán!";
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

        // Đã kiểm tra dữ liệu POST, giờ xóa dòng này đi
        // var_dump($_POST);
        // exit;

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

        // Lấy danh sách sản phẩm được chọn từ form giỏ hàng
        $selectedProducts = $_POST['selected_products'] ?? [];

        // Kiểm tra xem có sản phẩm nào được chọn không
        if (empty($selectedProducts)) {
             $_SESSION['error_msg'] = "Vui lòng chọn ít nhất một sản phẩm để thanh toán!";
             header('Location: index.php?act=cart'); // Quay lại trang giỏ hàng
             exit;
        }

        // 2. Kiểm tra thông tin người dùng đã đăng nhập chưa (tùy requirement)
        // Mặc định là đơn hàng của khách vãng lai (MaNguoiDung = NULL) nếu chưa đăng nhập
        $userId = isset($_SESSION['user']['MaNguoiDung']) ? $_SESSION['user']['MaNguoiDung'] : null;

        // 3. Lấy thông tin giỏ hàng từ session và 4. Tính tổng tiền
        $cartItems = [];
        $total = 0;

        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            // Lọc giỏ hàng chỉ giữ lại các sản phẩm đã được chọn
            $filteredCart = array_filter(
                $_SESSION['cart'],
                function($productId) use ($selectedProducts) {
                    return in_array($productId, $selectedProducts);
                },
                ARRAY_FILTER_USE_KEY // Áp dụng callback cho key (product ID)
            );

            if (empty($filteredCart)) {
                // Sau khi lọc, nếu không còn sản phẩm nào (ví dụ: user remove hết sp được chọn)
                $_SESSION['error_msg'] = "Giỏ hàng trống hoặc không có sản phẩm nào được chọn!";
                header('Location: index.php?act=cart'); // Quay lại trang giỏ hàng
                exit;
            }

            $productIds = array_keys($filteredCart);

            // Tạo chuỗi placeholders cho câu truy vấn IN (từ danh sách sản phẩm đã lọc)
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

            $total = 0; // Tính lại tổng tiền chỉ cho các sản phẩm đã chọn
            $cartItemsToProcess = []; // Danh sách chi tiết đơn hàng chỉ cho các sản phẩm đã chọn

            foreach ($filteredCart as $productId => $quantity) { // Lặp qua filteredCart
                 if (isset($productsInCart[$productId])) {
                    $product = $productsInCart[$productId];
                    $price = $product['Gia'];
                    $subtotal = $price * $quantity;
                    $total += $subtotal;

                     $cartItemsToProcess[] = [ // Lưu vào mảng mới
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
            // Giỏ hàng trống ban đầu, chuyển hướng về trang giỏ hàng
            $_SESSION['error_msg'] = "Giỏ hàng trống, không thể đặt hàng!";
            header('Location: index.php?act=cart');
            exit;
        }

        // Kiểm tra lại nếu giỏ hàng rỗng sau khi lọc sản phẩm không tồn tại
         if (empty($cartItemsToProcess)) { // Kiểm tra mảng mới
            $_SESSION['error_msg'] = "Giỏ hàng trống hoặc chứa sản phẩm không hợp lệ sau khi chọn!";
            header('Location: index.php?act=cart');
            exit;
         }

        try {
            $this->pdo->beginTransaction(); // Bắt đầu transaction

            // 5. Lưu thông tin đơn hàng vào bảng donhang (sử dụng $total mới)
            $stmt = $this->pdo->prepare("
                INSERT INTO donhang (MaNguoiDung, NgayDatHang, TrangThai, PhuongThucThanhToan, TongTien)
                VALUES (?, NOW(), ?, ?, ?)
            ");
            $stmt->execute([
                $userId,
                'cho_xac_nhan', // Trạng thái đơn hàng mặc định
                $payment_method,
                $total
            ]);

            $orderId = $this->pdo->lastInsertId(); // Lấy ID của đơn hàng vừa tạo

            // 6. Lưu chi tiết từng sản phẩm vào bảng chitietdonhang (sử dụng $cartItemsToProcess)
            $stmt = $this->pdo->prepare("
                INSERT INTO chitietdonhang (MaDonHang, MaSanPham, SoLuong, GiaBan)
                VALUES (?, ?, ?, ?)
            ");

            foreach ($cartItemsToProcess as $item) { // Lặp qua mảng mới
                $product = $item['product'];
                $quantity = $item['quantity'];
                $price = $item['product']['Gia']; // Lấy giá từ sản phẩm

                $stmt->execute([
                    $orderId,
                    $product['MaSanPham'],
                    $quantity,
                    $price
                ]);
                 // 7. Cập nhật số lượng tồn kho sản phẩm (nếu có) - Cần thêm logic cập nhật cột SoLuongTonKho trong bảng sanpham
                 // Ví dụ: UPDATE sanpham SET SoLuongTonKho = SoLuongTonKho - ? WHERE MaSanPham = ?
                 // $updateStockStmt = $this->pdo->prepare("UPDATE sanpham SET SoLuongTonKho = SoLuongTonKho - ? WHERE MaSanPham = ?");
                 // $updateStockStmt->execute([$quantity, $product['MaSanPham']]);
            }

            $this->pdo->commit(); // Hoàn tất transaction

            // 8. Xóa CÁC SẢN PHẨM ĐÃ THANH TOÁN khỏi giỏ hàng trong session
            foreach ($selectedProducts as $productId) {
                unset($_SESSION['cart'][$productId]);
            }

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