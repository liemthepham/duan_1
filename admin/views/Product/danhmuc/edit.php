<?php require __DIR__ . '/../../layouts/layouts_top.php';?>
<h2>Sửa Danh mục #<?= $item['MaDanhMuc'] ?></h2>
<form method="post">
  <div class="form-group">
    <label>Tên danh mục</label>
    <input name="TenDanhMuc" class="form-control"
           value="<?= htmlspecialchars($item['TenDanhMuc']) ?>" required>
  </div>
  <button class="btn btn-success">Cập nhật</button>
  <a href="index.php?act=category-list" class="btn btn-secondary">Hủy</a>
</form>
<?php require __DIR__ . '/../../layouts/layout_bottom.php';?>

