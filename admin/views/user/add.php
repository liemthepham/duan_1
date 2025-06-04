<h2>Thêm Người dùng</h2>
<form method="post">
  <div class="mb-3">
    <label class="form-label">Tên đăng nhập</label>
    <input name="TenDangNhap" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="Email" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Mật khẩu</label>
    <input type="password" name="MatKhau" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Vai trò</label>
    <select name="VaiTro" class="form-select">
      <option value="khachhang">Khách hàng</option>
      <option value="admin">Admin</option>
    </select>
  </div>
  <button class="btn btn-success">Lưu</button>
  <a href="index.php?act=user-list" class="btn btn-secondary">Hủy</a>
</form>
