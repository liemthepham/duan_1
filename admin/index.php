<?php
session_set_cookie_params(['path' => '/', 'httponly' => true]);
session_start();

$act = $_GET['act'] ?? 'dashboard';
$publicRoutes = ['auth-login', 'auth-register'];

if (!in_array($act, $publicRoutes) && (!isset($_SESSION['user']) || $_SESSION['user']['VaiTro'] !== "admin")) {
    // Nếu chưa login hoặc không phải admin thì chuyển về login
    header('Location: index.php?act=auth-login');
    exit;
}

// Require file Common
require_once '../commons/env.php';      // Khai báo biến môi trường (DB, BASE_URL, ...)
require_once '../commons/function.php'; // Hàm hỗ trợ connectDB(), ...

// Tạo kết nối database PDO
$pdo = connectDB();

// Require toàn bộ Controllers
require_once 'controllers/ProductController.php';
require_once 'controllers/CategoryController.php';
require_once 'controllers/OrderController.php';
require_once 'controllers/UserController.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/DashboardController.php';
require_once 'controllers/StatsController.php';
require_once 'controllers/AdminCommentController.php';

// Require toàn bộ Models (nếu cần thiết)
// require_once 'models/ProductModel.php';
// require_once 'models/CategoryModel.php';
// require_once 'models/OrderModel.php';
// require_once 'models/UserModel.php';

// Route
match ($act) {
    // ... các route khác ...
    'auth-register' => (new AuthController())->register(),
    'auth-login'    => (new AuthController())->login(),
    'auth-logout'   => (new AuthController())->logout(),
    'dashboard'     => (new DashboardController())->index(),

    // Sản phẩm
    'product-list'   => (new ProductController())->index(),
    'product-add'    => (new ProductController())->add(),
    'product-edit'   => (new ProductController())->edit(),
    'product-delete' => (new ProductController())->delete(),

    // Danh mục
    'category-list'   => (new CategoryController())->index(),
    'category-add'    => (new CategoryController())->add(),
    'category-edit'   => (new CategoryController())->edit(),
    'category-delete' => (new CategoryController())->delete(),

    // Quản lý user
    'user-list'   => (new UserController())->index(),
    'user-add'    => (new UserController())->add(),
    'user-edit'   => (new UserController())->edit(),
    'user-delete' => (new UserController())->delete(),

    // Quản lý đơn hàng
    'order-list' => (new OrderController($pdo))->index(),
    'order-detail' => (new OrderController($pdo))->detail(),

    //thong ke
    'stats'        => (new StatsController($pdo))->index(),

    'update-order-status' => (new OrderController($pdo))->updateStatus(),



    //comments
    'admin-comment-list'   => (new AdminCommentController())->index(),
    'admin-comment-delete' => (new AdminCommentController())->delete(),
    default => (new DashboardController())->index(),

};
