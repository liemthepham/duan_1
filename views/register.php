<?php
// views/register.php
if (!empty($_SESSION['user']) && $_SESSION['user']['VaiTro'] === 'khachhang') {
    // Nếu đã login với vai trò khách hàng, chuyển về home
    header('Location: index.php?act=home');
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Đăng ký – TechStore</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <link href="public/css/custom.css" rel="stylesheet">
</head>

<body class="bg-light">

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

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="mb-4 text-center">Đăng ký tài khoản</h3>
                        <?php if (!empty($errorMsg)): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($errorMsg) ?></div>
                        <?php endif; ?>
                        <form action="index.php?act=do-register" method="POST" novalidate>
                            <div class="mb-3">
                                <label class="form-label">Tên đăng nhập</label>
                                <input name="username" type="text" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input name="email" type="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mật khẩu</label>
                                <input name="password" type="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nhập lại mật khẩu</label>
                                <input name="password2" type="password" class="form-control" required>
                            </div>

                            <?php if (!empty($_SESSION['user']) && $_SESSION['user']['VaiTro'] === 'admin'): ?>
                                <!-- Nếu Admin đang đăng nhập thì cho chọn VaiTro -->
                                <div class="mb-3">
                                    <label class="form-label">Vai trò</label>
                                    <select name="vaiTro" class="form-select" required>
                                        <option value="khachhang">Khách hàng</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                            <?php else: ?>
                                <!-- Nếu chưa login thì vaiTro luôn là khachhang -->
                                <input type="hidden" name="vaiTro" value="khachhang">
                            <?php endif; ?>

                            <div class="mb-3 form-check">
                                <input name="agreeTerms" type="checkbox" class="form-check-input" required>
                                <label class="form-check-label">
                                    Tôi đồng ý Điều khoản sử dụng
                                </label>
                            </div>
                            <button class="btn btn-primary w-100">Đăng ký</button>
                        </form>

                        <p class="mt-3 text-center">
                            Đã có tài khoản?
                            <a href="index.php?act=login">Đăng nhập</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    
</body>

</html>