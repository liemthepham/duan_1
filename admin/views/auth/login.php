<?php
// admin/views/auth/login.php
$pageTitle = "Đăng nhập Admin";
?>

<h2 class="text-center mb-4">Đăng nhập Admin</h2>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form action="index.php?act=auth-login" method="post">
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

    <button type="submit" class="btn btn-success w-100">Đăng nhập</button>

    <div class="mt-3 text-center">
        <small>Chưa có tài khoản? <a href="index.php?act=auth-register">Đăng ký ngay</a></small>
    </div>
</form>
