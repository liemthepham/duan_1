<h2>Quản lý Người dùng</h2>
<form method="get" action="index.php">
  <input type="hidden" name="act" value="user-list">
  <div class="input-group mb-3">
    <input 
      type="text" 
      name="q" 
      class="form-control" 
      placeholder="Tìm tên hoặc email..." 
      value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
    >
    <button class="btn btn-outline-secondary" type="submit">Tìm</button>
  </div>
</form>
<!-- <a href="index.php?act=user-add" class="btn btn-primary btn-sm mb-2">+ Thêm User</a> -->
<table class="table table-striped table-hover align-middle">
  <thead>
    <tr>
      <th>ID</th>
      <th>Tên đăng nhập</th>
      <th>Email</th>
      <th>Vai trò</th>
      <th>Ngày tạo</th>
      <th>Hành động</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($users as $u): ?>
      <tr>
        <td><?= $u['MaNguoiDung'] ?></td>
        <td><?= htmlspecialchars($u['TenDangNhap']) ?></td>
        <td><?= htmlspecialchars($u['Email']) ?></td>
        <td><?= $u['VaiTro'] ?></td>
        <td><?= $u['NgayTao'] ?></td>
        <td>
          <a href="index.php?act=user-edit&id=<?= $u['MaNguoiDung'] ?>" class="btn btn-sm btn-warning me-1">Phân Quyền</a>
          <!-- <a href="index.php?act=user-delete&id=<?= $u['MaNguoiDung'] ?>"
           onclick="return confirm('Xóa user này?')" class="btn btn-sm btn-danger">xóa</a> -->
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>