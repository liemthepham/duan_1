<?php
session_start();


require_once 'config/database.php';
// require_once 'controllers/HomeController.php'; // Sẽ tạo lại sau
require_once 'controllers/FrontProductController.php';

require_once 'controllers/CartController.php';
require_once 'controllers/CheckoutController.php';
require_once 'models/user.php';

$productController = new FrontProductController($pdo);
$cartController = new CartController();
$checkoutController = new CheckoutController($pdo);
// $homeController = new HomeController($pdo); // Sẽ tạo lại sau

$act = $_GET['act'] ?? 'home';

switch ($act) {
    case 'home':
        // Hiển thị trang chủ

        // Pagination settings
        $items_per_page = 8; // Số sản phẩm trên mỗi trang
        $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($current_page - 1) * $items_per_page;

        // Lấy category_id từ URL nếu có
        $category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;

        // Chuẩn bị câu query cơ bản
        $baseQuery = "FROM sanpham s JOIN danhmuc d ON s.MaDanhMuc = d.MaDanhMuc";
        $whereClause = "";
        $params = array();
        
        // Thêm điều kiện lọc theo danh mục nếu có
        if ($category_id) {
            $whereClause .= ($whereClause ? " AND" : " WHERE") . " s.MaDanhMuc = :category_id";
            $params[':category_id'] = $category_id;
        }

        // Thêm điều kiện tìm kiếm theo tên sản phẩm
        if (!empty($_GET['search'])) {
            $search = '%' . $_GET['search'] . '%';
            $whereClause .= ($whereClause ? " AND" : " WHERE") . " s.TenSanPham LIKE :search";
            $params[':search'] = $search;
        }

        // Thêm điều kiện lọc theo giá
        if (!empty($_GET['min_price'])) {
            $whereClause .= ($whereClause ? " AND" : " WHERE") . " s.GiaBan >= :min_price";
            $params[':min_price'] = $_GET['min_price'];
        }
        if (!empty($_GET['max_price'])) {
            $whereClause .= ($whereClause ? " AND" : " WHERE") . " s.GiaBan <= :max_price";
            $params[':max_price'] = $_GET['max_price'];
        }

        // Đếm tổng số sản phẩm cho phân trang
        $countQuery = "SELECT COUNT(*) " . $baseQuery . $whereClause;
        $countStmt = $pdo->prepare($countQuery);
        foreach ($params as $key => $value) {
            $countStmt->bindValue($key, $value);
        }
        $countStmt->execute();
        $total_items = $countStmt->fetchColumn();
        $total_pages = ceil($total_items / $items_per_page);

        // Query lấy sản phẩm với phân trang
        $productQuery = "SELECT s.*, d.TenDanhMuc, COALESCE(SUM(ct.SoLuong), 0) as SoLuongBan 
                       FROM sanpham s 
                       JOIN danhmuc d ON s.MaDanhMuc = d.MaDanhMuc
                       LEFT JOIN chitietdonhang ct ON s.MaSanPham = ct.MaSanPham
                       " . $whereClause . "
                       GROUP BY s.MaSanPham
                       ORDER BY s.NgayTao DESC 
                       LIMIT :limit OFFSET :offset";
        
        $stmt = $pdo->prepare($productQuery);
        
        // Bind các tham số lọc
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Lấy danh sách danh mục
        $categoryStmt = $pdo->query("SELECT * FROM danhmuc");
        $categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);

        // Lấy sản phẩm gợi ý (4 sản phẩm ngẫu nhiên khác với sản phẩm đang xem)
        $suggestQuery = "SELECT s.*, d.TenDanhMuc 
                        FROM sanpham s 
                        JOIN danhmuc d ON s.MaDanhMuc = d.MaDanhMuc 
                        ORDER BY RAND() 
                        LIMIT 4";
        $suggestStmt = $pdo->query($suggestQuery);
        $suggestedProducts = $suggestStmt->fetchAll(PDO::FETCH_ASSOC);

        // Lấy tên danh mục đang được chọn (nếu có)
        $selected_category_name = '';
        if ($category_id) {
            foreach ($categories as $cat) {
                if ($cat['MaDanhMuc'] == $category_id) {
                    $selected_category_name = $cat['TenDanhMuc'];
                    break;
                }
            }
        }

        require_once 'views/index.php';
        break;



    case 'products':
        require_once __DIR__ . '/controllers/FrontProductController.php';
        (new FrontProductController())->index();
        break;


    case 'product-detail':
        // Hiển thị chi tiết sản phẩm
        $id = $_GET['id'] ?? 0;
        $productController->show($id);
        break;

    case 'add-comment':
        // Thêm bình luận
        $productController->addComment();
        break;

    case 'add-to-cart':
        // Thêm vào giỏ hàng
        $cartController->addToCart();
        break;

    case 'remove-from-cart':
        // Xóa khỏi giỏ hàng
        $cartController->removeFromCart();
        break;

    case 'update-cart':
        // Cập nhật giỏ hàng
        $cartController->updateCart();
        break;

    case 'cart':
        // Xem giỏ hàng
        $cartController->viewCart();
        break;

    case 'checkout':
        // Hiển thị trang thanh toán
        $checkoutController->index();
        break;

    case 'process-checkout':
        // Xử lý đặt hàng
        $checkoutController->process($pdo);
        break;

    case 'order-success':
        $checkoutController->orderSuccess();
        break;

        // Thêm các case cho đăng nhập/đăng ký/thanh toán sau
        //case login:
        if (isset($_GET['act']) && $_GET['act'] === 'logout') {
            session_destroy();
            header('Location: index.php?act=login');

            exit;
        }

    case 'login':
        // Nếu đã login rồi, chuyển về home
        if (isset($_SESSION['user'])) {
            header('Location: index.php?act=home');
            exit;
        }

        // Nếu POST (submit form)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            // Xác thực
            $userModel = new User();
            $user = $userModel->authenticate($username, $password);

            if ($user) {
                // Lưu session
                $_SESSION['user'] = $user;
                // Redirect theo vai trò
                if ($user['VaiTro'] === 'admin') {
                    header('Location: admin/');
                } else {
                    header('Location: index.php?act=home');
                }
                exit;
            } else {
                // Sai thông tin: gắn lỗi và render lại form
                $errorMsg = 'Tên đăng nhập hoặc mật khẩu không đúng';
                require_once __DIR__ . '/views/login.php';
                break;
            }
        }

        // Nếu GET: chỉ render form login
        require_once __DIR__ . '/views/login.php';
        break;



    case 'logout':
        $_SESSION['flash'] = [
            'type'    => 'success',
            'message' => 'Bạn đã đăng xuất thành công.'  // ← Dòng này!
        ];

        // 3. Giữ lại flash riêng, xoá phần còn lại của session
        $flash = $_SESSION['flash'];
        session_unset();
        session_destroy();

        // 4. Mở lại session và restore flash
        session_start();
        $_SESSION['flash'] = $flash;

        // 5. Redirect về trang home
        header('Location: index.php?act=home');
        exit;
        break;

    case 'register':
        require_once 'views/register.php';
        break;
    case 'do-register':
        // Lấy dữ liệu
        $u     = trim($_POST['username']   ?? '');
        $e     = trim($_POST['email']      ?? '');
        $p1    = $_POST['password']        ?? '';
        $p2    = $_POST['password2']       ?? '';
        $agree = isset($_POST['agreeTerms']);
        $vt    = $_POST['vaiTro'] ?? 'khachhang';

        // Validate cơ bản
        if (!$u || !$e || !$p1 || $p1 !== $p2 || !$agree) {
            $errorMsg = 'Vui lòng điền đầy đủ và chính xác.';
            require_once 'views/register.php';
            break;
        }

        // Chỉ Admin mới có thể tạo Admin
        if ($vt === 'admin') {
            if (empty($_SESSION['user']) || $_SESSION['user']['VaiTro'] !== 'admin') {
                // Nếu không phải admin, ép về khachhang
                $vt = 'khachhang';
            }
        }

        // Kiểm tra tồn tại
        $stmt = $pdo->prepare(
            "SELECT COUNT(*) FROM nguoidung
     WHERE TenDangNhap=:u OR Email=:e"
        );
        $stmt->execute([':u' => $u, ':e' => $e]);
        if ($stmt->fetchColumn() > 0) {
            $errorMsg = 'Tên đăng nhập hoặc Email đã tồn tại.';
            require_once 'views/register.php';
            break;
        }

        // Chèn mới với VaiTro lấy từ form
        $hash = password_hash($p1, PASSWORD_DEFAULT);
        $insert = $pdo->prepare(
            "INSERT INTO nguoidung
     (TenDangNhap, Email, MatKhau, VaiTro)
     VALUES (:u, :e, :p, :v)"
        );
        $insert->execute([
            ':u' => $u,
            ':e' => $e,
            ':p' => $hash,
            ':v' => $vt
        ]);

        // Nếu Admin tạo user thì quay lại dashboard admin,
        // còn user thường thì redirect về login
        if (!empty($_SESSION['user']) && $_SESSION['user']['VaiTro'] === 'admin') {
            header('Location: admin/index.php');
        } else {
            header('Location: index.php?act=login&registered=1');
        }
        exit;

    default:
        // Trang 404
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
        break;
}
