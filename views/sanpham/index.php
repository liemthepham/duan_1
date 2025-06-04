<?php include_once __DIR__ . '/../header.php'; ?>

<!-- MAIN CONTENT -->
  <main class="flex-fill">
    <div class="container my-5">

      <!-- Tiêu đề Trang -->
      <h2 class="section-title text-center">Danh sách sản phẩm</h2>

      <!-- FILTER CARD -->
      <div class="filter-card mb-5 p-4 rounded shadow-sm">
        <form method="get" action="index.php" class="row gx-3 gy-3 align-items-end">
          <input type="hidden" name="act" value="products">

          <!-- Keyword -->
          <div class="col-lg-4">
            <label class="form-label text-secondary">Từ khóa</label>
            <div class="input-group">
              <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
              <input type="text" name="keyword" class="form-control" placeholder="Tìm sản phẩm…" value="<?= htmlspecialchars($keyword) ?>">
            </div>
          </div>

          <!-- Category -->
          <div class="col-lg-3">
            <label class="form-label text-secondary">Danh mục</label>
            <select name="category" class="form-select">
              <option value="">Tất cả</option>
              <?php foreach($cats as $c): ?>
              <option value="<?= $c['MaDanhMuc'] ?>" <?= $category==$c['MaDanhMuc']?'selected':''?>>
                <?= htmlspecialchars($c['TenDanhMuc']) ?>
              </option>
              <?php endforeach;?>
            </select>
          </div>

          <!-- Price Min -->
          <div class="col-lg-2">
            <label class="form-label text-secondary">Giá từ (₫)</label>
            <input type="number" name="price_min" class="form-control" placeholder="0" value="<?= $price_min>0?$price_min:'' ?>">
          </div>

          <!-- Price Max -->
          <div class="col-lg-2">
            <label class="form-label text-secondary">Giá đến (₫)</label>
            <input type="number" name="price_max" class="form-control" placeholder="0" value="<?= $price_max>0?$price_max:'' ?>">
          </div>

          <!-- Submit -->
          <div class="col-lg-1 d-grid">
            <button type="submit" class="btn btn-primary btn-lg">
              <i class="bi bi-funnel-fill me-1"></i>Lọc
            </button>
          </div>
        </form>
      </div>

      <!-- PRODUCT GRID -->
      <?php if (empty($products)): ?>
        <p class="text-center text-muted">Không có sản phẩm phù hợp.</p>
      <?php else: ?>
      <div class="row gx-4 gy-5">
        <?php foreach($products as $p): ?>
        <div class="col-md-3">
          <div class="product-card h-100 d-flex flex-column">
            <div class="product-image overflow-hidden">
              <img src="admin/uploads/<?= htmlspecialchars($p['AnhDaiDien']) ?>" 
                   alt="<?= htmlspecialchars($p['TenSanPham']) ?>" class="w-100">
            </div>
            <div class="product-body p-3">
              <h5 class="product-title"><?= htmlspecialchars($p['TenSanPham']) ?></h5>
              <p class="product-price text-success fw-bold">
                <?= number_format($p['Gia'],0,',','.') ?>₫
              </p>
            </div>
            <div class="mt-auto p-3 text-center">
              <a href="index.php?act=product-detail&id=<?= $p['MaSanPham'] ?>"
                 class="btn btn-outline-primary w-100">
                Xem chi tiết
              </a>
            </div>
          </div>
        </div>
        <?php endforeach;?>
      </div>
      <?php endif;?>
    </div>
  </main>

<?php include_once __DIR__ . '/../footer.php'; ?>