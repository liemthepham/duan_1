<div class="container-fluid">
  <h1 class="mt-4">Danh sách đơn hàng</h1>
  <table class="table table-striped table-bordered mt-3">
    <thead class="table-dark">
      <tr>
        <th>#</th>
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
        <tr><td colspan="7" class="text-center">Chưa có đơn hàng nào.</td></tr>
      <?php else: foreach ($orders as $o): ?>
        <tr>
          <td class="text-primary">#<?= $o['MaDonHang'] ?></td>
          <td><?= htmlspecialchars($o['TenKhachHang'] ?? 'Khách vãng lai') ?></td>
          <td><?= date('d/m/Y', strtotime($o['NgayDatHang'])) ?></td>
          <td><?= number_format($o['TongTien'], 0, ',', '.') ?>₫</td>
          <td><?= htmlspecialchars($o['PhuongThucThanhToan']) ?></td>
          <td><?= htmlspecialchars($o['TrangThai']) ?></td>
          <td>
            <a href="http://localhost/duan_1/admin/index.php?act=order-detail&id=<?= $o['MaDonHang'] ?>"
               class="btn btn-sm btn-primary">Xem chi tiết</a>
          </td>
        </tr>
      <?php endforeach; endif; ?>
    </tbody>
  </table>
</div>
