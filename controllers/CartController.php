<?php
class CartController
{

    public function viewCart() {
        global $pdo;
        
        $cartItems = [];
        $total = 0;

        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            $productIds = array_keys($_SESSION['cart']);
            // Tạo chuỗi placeholders cho câu truy vấn IN
            $placeholders = str_repeat('?, ', count($productIds) - 1) . '?';
            
            $stmt = $pdo->prepare("SELECT * FROM sanpham WHERE MaSanPham IN ($placeholders)");
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

        require_once 'views/cart.php';
    }

    public function addToCart() {
        // Bắt đầu session nếu chưa có
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Khởi tạo giỏ hàng nếu chưa có trong session
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $productId = $_POST['product_id'] ?? 0;
        $quantity = $_POST['quantity'] ?? 1;
        
        if ($productId > 0 && $quantity > 0) {
             // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
            if (isset($_SESSION['cart'][$productId])) {
                // Nếu có rồi thì cập nhật số lượng
                $_SESSION['cart'][$productId] += $quantity;
            } else {
                // Nếu chưa có thì thêm mới
                $_SESSION['cart'][$productId] = $quantity;
            }
            $_SESSION['success_msg'] = "Đã thêm sản phẩm vào giỏ hàng!";
        } else {
             $_SESSION['error_msg'] = "Sản phẩm hoặc số lượng không hợp lệ!";
        }

        // Chuyển hướng về trang trước hoặc trang chủ
        header('Location: index.php?act=cart');
        exit;
    }

    public function removeFromCart() {
        // Bắt đầu session nếu chưa có
         if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $productId = $_GET['id'] ?? 0;
        
        if ($productId > 0) {
            if (isset($_SESSION['cart'][$productId])) {
                unset($_SESSION['cart'][$productId]);
                 $_SESSION['success_msg'] = "Đã xóa sản phẩm khỏi giỏ hàng!";
            }
        } else {
             $_SESSION['error_msg'] = "ID sản phẩm không hợp lệ!";
        }

        // Chuyển hướng về trang trước hoặc trang giỏ hàng
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php?act=cart'));
         exit;
    }

    public function updateCart() {
         // Bắt đầu session nếu chưa có
         if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantity'])) {
            foreach ($_POST['quantity'] as $productId => $quantity) {
                // Đảm bảo productId và quantity là số nguyên dương
                $productId = (int) $productId;
                $quantity = (int) $quantity;

                if ($productId > 0) {
                    if ($quantity > 0) {
                         $_SESSION['cart'][$productId] = $quantity;
                    } else {
                         // Nếu số lượng <= 0, xóa sản phẩm khỏi giỏ
                        unset($_SESSION['cart'][$productId]);
                    }
                }
            }
             $_SESSION['success_msg'] = "Đã cập nhật giỏ hàng!";
        } else {
             $_SESSION['error_msg'] = "Dữ liệu cập nhật giỏ hàng không hợp lệ!";
        }

        // Chuyển hướng về trang giỏ hàng
        header('Location: index.php?act=cart');
         exit;
    } 

    public function index()
    {
        // Lấy danh sách sản phẩm trong giỏ hàng từ session
        $cart = $_SESSION['cart'] ?? [];

        // Tính tổng tiền
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Render view
        require_once './views/cart/index.php';
    }

    public function add()
    {
        // 1. Đảm bảo session đã start
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 2. Nếu chưa login, redirect về trang login
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?act=auth-login');
            exit;
        }

        // 3. Nếu đã POST thì xử lý thêm giỏ
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? 0;
            $quantity  = $_POST['quantity']   ?? 1;

            // Lấy data product từ model
            $product = $this->getProduct($productId);
            if ($product) {
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }
                session_start();
                if (!isset($_SESSION['customer'])) {
                    // chuyển về lại index và bật modal
                    header('Location: index.php?act=need_login');
                    exit;
                }

                // Tìm xem đã có trong giỏ chưa
                $found = false;
                foreach ($_SESSION['cart'] as &$item) {
                    if ($item['id'] == $productId) {
                        $item['quantity'] += $quantity;
                        $found = true;
                        break;
                    }
                }
                unset($item);

                // Nếu chưa có thì thêm mới
                if (!$found) {
                    $_SESSION['cart'][] = [
                        'id'       => $productId,
                        'name'     => $product['name'],
                        'price'    => $product['price'],
                        'image'    => $product['image'],
                        'quantity' => $quantity,
                    ];
                }

                // Chuyển về trang giỏ hàng
                header('Location: index.php?act=cart-index');
                exit;
            }
        }

        // Nếu không phải POST hoặc có lỗi => quay về home
        header('Location: index.php');
        exit;
    }



    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? 0;
            $quantity = $_POST['quantity'] ?? 1;

            // Cập nhật số lượng trong giỏ hàng
            if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as &$item) {
                    if ($item['id'] === $productId) {
                        $item['quantity'] = $quantity;
                        break;
                    }
                }
            }

            // Redirect về trang giỏ hàng
            header('Location: cart.php');
            exit;
        }

        // Nếu có lỗi thì redirect về trang chủ
        header('Location: index.php');
        exit;
    }

    public function remove()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? 0;

            // Xóa sản phẩm khỏi giỏ hàng
            if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $key => $item) {
                    if ($item['id'] === $productId) {
                        unset($_SESSION['cart'][$key]);
                        break;
                    }
                }
                // Reindex array
                $_SESSION['cart'] = array_values($_SESSION['cart']);
            }

            // Redirect về trang giỏ hàng
            header('Location: cart.php');
            exit;
        }

        // Nếu có lỗi thì redirect về trang chủ
        header('Location: index.php');
        exit;
    }

    private function getProduct($id)
    {
        // TODO: Lấy thông tin sản phẩm từ database
        // Tạm thời return dữ liệu mẫu
        return [
            'id' => $id,
            'name' => 'Sản phẩm ' . $id,
            'price' => 1000000,
            'image' => 'https://via.placeholder.com/100'
        ];
    }


}