<h2>Sửa Người dùng #<?= $item['MaNguoiDung'] ?></h2>
<form method="post">
  <div class="mb-3">
    <label class="form-label">Tên đăng nhập</label>
    <input name="TenDangNhap" value="<?= htmlspecialchars($item['TenDangNhap']) ?>" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="Email" value="<?= htmlspecialchars($item['Email']) ?>" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Mật khẩu mới (để trống giữ nguyên)</label>
    <input type="password" name="MatKhau" class="form-control">
  </div>
  <div class="mb-3">
    <label class="form-label">Vai trò</label>
    <select name="VaiTro" class="form-select">
      <option value="khachhang" <?= $item['VaiTro']=='khachhang'?'selected':'' ?>>Khách hàng</option>
      <option value="admin" <?= $item['VaiTro']=='admin'?'selected':'' ?>>Admin</option>
    </select>
  </div>
  <button class="btn btn-success">Cập nhật</button>
  <a href="index.php?act=user-list" class="btn btn-secondary">Hủy</a>
</form>
