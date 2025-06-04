<?php
// session_start();
// if (empty($_SESSION['is_admin'])) {
//     // Chưa là admin → trả về login chung
//     header('Location: index.php?act=auth-login');
//     exit;
// }
class DashboardController {
    public function index() {
        require_once "./views/dashboard.php";
    }
}