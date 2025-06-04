<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cửa hàng điện tử</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet" href="public/css/cusstom.css">
</head>

<body class=" d-flex flex-column min-vh-100">

    <?php
    $user = $_SESSION['user'] ?? null;
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php?act=home">
                <i class="fas fa-mobile-alt"></i> TechStore
            </a>
            <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- menu chính -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php?act=home">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?act=products">Sản phẩm</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?act=contact">Liên hệ</a></li>
                </ul>

                <!-- phần bên phải -->
                <ul class="navbar-nav ms-auto align-items-center">
                    <!-- icon giỏ -->
                    <li class="nav-item me-3 position-relative">
                        <a class="btn btn-outline-light" href="index.php?act=cart">
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                        <?php if (!empty($_SESSION['cart'])): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?= count($_SESSION['cart']) ?>
                            </span>
                        <?php endif; ?>
                    </li>
                    <!-- nếu chưa login -->
                    <?php if (!$user): ?>
                        <li class="nav-item d-flex">
                            <a href="index.php?act=login"
                                class="btn btn-outline-light me-2 px-3 py-1">
                                Đăng nhập
                            </a>
                            <a href="index.php?act=register"
                                class="btn btn-primary px-3 py-1">
                                Đăng ký
                            </a>
                        </li>

                        <!-- nếu đã login -->
                    <?php else: ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center"
                                href="#" id="userMenu" data-bs-toggle="dropdown">
                                <?php if (!empty($_SESSION['user'])): ?>
                                    <i class="fas fa-user-circle me-1"></i>
                                    <?= htmlspecialchars($_SESSION['user']['Email']) ?>
                                <?php endif; ?>

                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                                <?php if (($user['VaiTro'] ?? '') === 'admin'): ?>
                                    <li><a class="dropdown-item" href="/duan1_nhom3/admin/index.php?act=dashboard">Dashboard Admin</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                <?php endif; ?>
                                <li><a class="dropdown-item" href="index.php?act=logout">Đăng xuất</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>