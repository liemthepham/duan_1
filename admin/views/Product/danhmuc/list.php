<?php require __DIR__ . '/../../layouts/layouts_top.php';?>
<h2>Quản lý Danh mục</h2>
<a href="index.php?act=category-add" class="btn btn-primary mb-2">+ Thêm mới</a>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>ID</th>
      <th>Tên danh mục</th>
      <!-- <th>Danh mục cha</th> -->
      <th>Hành động</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($list as $row): ?>
      <tr>
        <td><?= $row['MaDanhMuc'] ?></td>
        <td><?= htmlspecialchars($row['TenDanhMuc']) ?></td>
        <td>
          <a href="index.php?act=category-edit&id=<?= $row['MaDanhMuc'] ?>"
             class="btn btn-sm btn-warning">Sửa</a>
          <a href="index.php?act=category-delete&id=<?= $row['MaDanhMuc'] ?>"
             onclick="return confirm('Xác nhận xóa?')"
             class="btn btn-sm btn-danger">Xóa</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php require __DIR__ . '/../../layouts/layout_bottom.php';?>


