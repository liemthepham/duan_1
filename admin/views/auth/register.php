<?php
// admin/views/auth/register.php
$pageTitle = "Đăng ký Admin";
?>

<h2 class="text-center mb-4">Đăng ký Admin</h2>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form action="index.php?act=auth-register" method="post">
    <div class="mb-3">
        <label for="TenDangNhap" class="form-label">Tên đăng nhập</label>
        <input
            type="text"
            name="TenDangNhap"
            id="TenDangNhap"
            class="form-control"
            value="<?= htmlspecialchars($values['TenDangNhap'] ?? '') ?>"
            required
        />
    </div>
    <div class="mb-3">
        <label for="Email" class="form-label">Email</label>
        <input
            type="email"
            name="Email"
            id="Email"
            class="form-control"
            value="<?= htmlspecialchars($values['Email'] ?? '') ?>"
            required
        />
    </div>
    <div class="mb-3">
        <label for="MatKhau" class="form-label">Mật khẩu</label>
        <input
            type="password"
            name="MatKhau"
            id="MatKhau"
            class="form-control"
            required
        />
    </div>
    <!-- VaiTro mặc định là admin -->
    <input type="hidden" name="VaiTro" value="<?= htmlspecialchars($values['VaiTro'] ?? 'admin') ?>" />

    <button type="submit" class="btn btn-primary w-100">Đăng ký</button>

    <div class="mt-3 text-center">
        <small>Đã có tài khoản? <a href="index.php?act=auth-login">Đăng nhập ngay</a></small>
    </div>
</form>
