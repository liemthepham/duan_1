
<div class="container-fluid py-4">
  <div class="card shadow-sm border-0 mx-auto" style="max-width:800px;">
    <div class="card-header bg-white">
      <h5 class="mb-0">Sửa Sản Phẩm <?= $item['MaSanPham'] ?></h5>
    </div>
    <div class="card-body">
      <form method="post" enctype="multipart/form-data">
        <div class="row gy-3">
          <!-- Danh mục -->
          <div class="col-md-6">
            <label class="form-label">Danh mục</label>
            <select name="MaDanhMuc" class="form-select" required>
              <?php foreach($categories as $c): ?>
                <option value="<?= $c['MaDanhMuc'] ?>"
                  <?= $c['MaDanhMuc']==$item['MaDanhMuc']?'selected':'' ?>>
                  <?= htmlspecialchars($c['TenDanhMuc']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <!-- Tên SP -->
          <div class="col-md-6">
            <label class="form-label">Tên sản phẩm</label>
            <input type="text" name="TenSanPham"
                   class="form-control"
                   value="<?= htmlspecialchars($item['TenSanPham']) ?>"
                   required>
          </div>
          <!-- Mô tả -->
          <div class="col-12">
            <label class="form-label">Mô tả</label>
            <textarea name="MoTa" rows="4"
                      class="form-control"><?= htmlspecialchars($item['MoTa']) ?></textarea>
          </div>
          <!-- Số lượng -->
          <div class="col-md-4">
            <label class="form-label">Số lượng tồn</label>
            <input type="number" name="SoLuongTon"
                   class="form-control"
                   min="0"
                   value="<?= $item['SoLuongTon'] ?>"
                   required>
          </div>
          <!-- Giá -->
          <div class="col-md-4">
            <label class="form-label">Giá (VNĐ)</label>
            <input type="number" name="Gia"
                   class="form-control"
                   min="0" step="1000"
                   value="<?= $item['Gia'] ?>"
                   required>
          </div>
          <!-- Ảnh đại diện -->
          <div class="col-md-4">
            <label class="form-label">Ảnh đại diện</label>
            <input type="file" name="AnhDaiDien" class="form-control mb-2" accept="image/*">
            <?php if ($item['AnhDaiDien']): ?>
              <img src="uploads/<?= rawurlencode($item['AnhDaiDien']) ?>"
                   style="max-width:100px; display:block;" alt="">
            <?php endif; ?>
          </div>
        </div>

        <div class="mt-4 d-flex justify-content-end">
          <button type="submit" class="btn btn-success me-2">Lưu thay đổi</button>
          <a href="index.php?act=product-list" class="btn btn-outline-secondary">Hủy</a>
        </div>
      </form>
    </div>
  </div>
</div>
