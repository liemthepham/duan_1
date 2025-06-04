<div class="container-fluid py-4">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Danh Sách Sản Phẩm</h5>
      <a href="index.php?act=product-add" class="btn btn-primary btn-sm">+ Thêm Sản Phẩm</a>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover table-sm align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th style="width: 50px;">Mã SP</th>
              <th style="width: 50px;">Mã DM</th>
              <th>Tên SP</th>
              <th>Mô Tả</th>
              <th style="width: 80px;">SL Tồn</th>
              <th style="width: 100px;">Giá</th>
              <th style="width: 100px;">Ảnh</th>
              <th style="width: 120px;">Hành Động</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($products as $p): ?>
            <tr>
              <td><?= $p['MaSanPham'] ?></td>
              <td><?= $p['MaDanhMuc'] ?></td>
              <td><?= htmlspecialchars($p['TenSanPham']) ?></td>
              <td><?= htmlspecialchars($p['MoTa']) ?></td>
              <td class="text-center"><?= $p['SoLuongTon'] ?></td>
              <td class="text-end"><?= number_format($p['Gia'],0,',','.') ?> ₫</td>
              <td>
                <?php if (!empty($p['AnhDaiDien'])): ?>
                  <img src="uploads/<?= rawurlencode($p['AnhDaiDien']) ?>"
                       style="max-width:60px; max-height:60px; object-fit:cover;">
                <?php endif; ?>
              </td>
              <td>
                <a href="index.php?act=product-edit&id=<?= $p['MaSanPham'] ?>"
                   class="btn btn-sm btn-warning me-1">Sửa</a>
                <a href="index.php?act=product-delete&id=<?= $p['MaSanPham'] ?>"
                   onclick="return confirm('Xác nhận xóa?')"
                   class="btn btn-sm btn-danger">Xóa</a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
