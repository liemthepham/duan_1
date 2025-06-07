<?php

session_set_cookie_params(['path' => '/', 'httponly' => true]);
session_start();

// Get the action from the URL, default to dashboard
$act = $_GET['act'] ?? 'dashboard';

// Define public routes that don't require admin login
$publicRoutes = ['auth-login', 'auth-register']; // Add other public routes if any

// Check if the user is logged in and is an admin (if not a public route)
if (!in_array($act, $publicRoutes) && (!isset($_SESSION['user']) || $_SESSION['user']['VaiTro'] !== 'admin')) {
    // If not logged in or not admin, redirect to login page
    header('Location: index.php?act=auth-login');
    exit;
}

// Require common files
require_once '../commons/env.php';      // Database configuration, etc.
require_once '../commons/function.php'; // Helper functions like connectDB()

// Establish database connection
$pdo = connectDB();

// Require controllers
require_once 'controllers/ProductController.php';
require_once 'controllers/CategoryController.php';
require_once 'controllers/OrderController.php'; // Assuming OrderController is used in admin
require_once 'controllers/UserController.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/DashboardController.php';
require_once 'controllers/StatsController.php';
require_once 'controllers/AdminCommentController.php';

// Simple Routing based on 'act'
match ($act) {
    'dashboard' => (new DashboardController())->index(),

    // Authentication Routes
    'auth-login' => (new AuthController())->login(),
    'auth-register' => (new AuthController())->register(),
    'auth-logout' => (new AuthController())->logout(),

    // Product Routes
    'product-list' => (new ProductController())->index(),
    'product-add' => (new ProductController())->add(),
    'product-edit' => (new ProductController())->edit(),
    'product-delete' => (new ProductController())->delete(),

    // Category Routes
    'category-list' => (new CategoryController())->index(),
    'category-add' => (new CategoryController())->add(),
    'category-edit' => (new CategoryController())->edit(),
    'category-delete' => (new CategoryController())->delete(),

    // User Routes
    'user-list' => (new UserController())->index(),
    'user-add' => (new UserController())->add(),
    'user-edit' => (new UserController())->edit(),
    'user-delete' => (new UserController())->delete(),

    // Order Routes
    'order-list' => (new OrderController($pdo))->index(),
    'order-detail' => (new OrderController($pdo))->detail(),
    'update-order-status' => (new OrderController($pdo))->updateStatus(),
    'cancel' => (new OrderController($pdo))->cancel(), // Add the cancel route


    // Stats Route
    'stats' => (new StatsController($pdo))->index(),
    //comments
    'admin-comment-list'   => (new AdminCommentController())->index(),
    'admin-comment-delete' => (new AdminCommentController())->delete(),
    default => (new DashboardController())->index(),

};

?>
