<?php
// views/login.php

// Bắt session (nếu chưa)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Nếu đã login rồi, chuyển về home
if (isset($_SESSION['user'])) {
    header('Location: index.php?act=home');
    exit;
}

// Xử lý POST khi submit form
$errorMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Giả sử bạn có Model User tại models/User.php
    require_once __DIR__ . '/../models/User.php';
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $userModel = new User();
    $user = $userModel->authenticate($username, $password);

    if ($user) {
        // Lưu session và redirect về home
        $_SESSION['user'] = $user;
        header('Location: index.php?act=home');
        exit;
    } else {
        $errorMsg = 'Tên đăng nhập hoặc mật khẩu không đúng';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập | TechStore</title>
    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <!-- Font Awesome -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        rel="stylesheet">
    <!-- Custom CSS -->
    <!-- <link rel="stylesheet" href="/duan1/public/css/custom.css">s -->
</head>

<body>

    <!-- Navbar (copy nguyên từ views/index.php) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php?act=home">
                <i class="fas fa-mobile-alt"></i> TechStore
            </a>
            <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#mainNav"
                aria-controls="mainNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="index.php?act=home">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?act=product-list">Sản phẩm</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?act=promo">Khuyến mãi</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?act=contact">Liên hệ</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Nội dung chính: Form login -->
    <div class="container py-5" style="max-width: 400px;">
        <h2 class="mb-4 text-center">Đăng nhập</h2>

        <?php if ($errorMsg): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($errorMsg) ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['registered'])): ?>
            <div class="alert alert-success">
                Đăng ký thành công! Bạn hãy đăng nhập ngay.
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php?act=login">
            <div class="mb-3">
                <label class="form-label">Email hoặc tên đăng nhập</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
        </form>

        <p class="mt-3 text-center">
            Chưa có tài khoản? <a href="index.php?act=register">Đăng ký ngay</a>
        </p>
    </div>

    <!-- Footer (copy từ views/index.php nếu có) -->
    <footer class="bg-dark text-white py-4 mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Về chúng tôi</h5>
                    <p>Cửa hàng điện tử uy tín, chất lượng</p>
                </div>
                <div class="col-md-4">
                    <h5>Liên hệ</h5>
                    <p>Email: contact@example.com</p>
                    <p>Điện thoại: 0123 456 789</p>
                </div>
                <div class="col-md-4">
                    <h5>Theo dõi chúng tôi</h5>
                    <a href="#" class="text-white me-2"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-white me-2"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
    </script>
</body>

</html>