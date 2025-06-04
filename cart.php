<?php
require_once './commons/env.php';
require_once './commons/function.php';
require_once './controllers/CartController.php';

$act = $_GET['act'] ?? '/';

match ($act) {
    '/' => (new CartController())->index(),
    'add' => (new CartController())->add(),
    'update' => (new CartController())->update(),
    'remove' => (new CartController())->remove(),
    default => (new CartController())->index()
};
?> 