<?php
session_start();
// vì auth.php nằm ở duan1/admin/auth.php
// nên commons/env.php nằm ở duan1/admin/commons/env.php
require_once __DIR__ . '/../commons/env.php';
require_once __DIR__ . '/../commons/function.php';
require_once __DIR__ . '/controllers/AuthController.php';

$act = $_GET['act'] ?? 'auth-login';
$auth = new AuthController();

match ($act) {
  'auth-register' => $auth->register(),
  default         => $auth->login(),
};
exit;
