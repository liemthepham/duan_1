<div class="container-fluid px-4"> <!-- Dùng container-fluid thay vì container -->
  <h2 class="mt-4 mb-4 fw-bold" style="font-size: 2rem; color: #6C2BD9;">
    📦 Danh sách đơn hàng
  </h2>

  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle text-center" style="font-size: 1.1rem;">
      <thead class="table-dark">
        <tr>
          <th style="width: 5%;">#</th>
          <th>Khách hàng</th>
          <th>Ngày đặt</th>
          <th>Tổng tiền</th>
          <th>Phương thức thanh toán</th>
          <th>Trạng thái</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($orders)): ?>
          <tr><td colspan="7" class="text-center text-muted py-4">Chưa có đơn hàng nào.</td></tr>
        <?php else: foreach ($orders as $o): ?>
          <tr>
            <td class="text-primary">#<?= $o['MaDonHang'] ?></td>
            <td><?= htmlspecialchars($o['TenDangNhap']) ?></td>
            <td><?= date('d/m/Y', strtotime($o['NgayDatHang'])) ?></td>
            <td class="text-danger fw-bold"><?= number_format($o['TongTien'], 0, ',', '.') ?>₫</td>
            <td><?= htmlspecialchars($o['PhuongThucThanhToan']) ?></td>
            <td>
              <span class="badge bg-<?= $o['TrangThai'] === 'da_giao' ? 'success' : ($o['TrangThai'] === 'da_huy' ? 'danger' : 'info') ?> px-3 py-2 text-uppercase">
                <?= $o['TrangThai'] ?>
              </span>
            </td>
            <td>
              <a href="index.php?act=order-detail&id=<?= $o['MaDonHang'] ?>"
                 class="btn btn-outline-primary btn-sm">
                <i class="bi bi-eye"></i> Xem
              </a>
            </td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>
