<div class="container-fluid px-4 py-4">
  <div class="card shadow-lg border-0 rounded-4">
    <div class="card-header bg-primary bg-gradient text-white rounded-top-4 d-flex justify-content-between align-items-center">
      <h3 class="mb-0"><i class="bi bi-box-seam"></i> Danh sách đơn hàng</h3>
      <span class="badge bg-light text-dark fw-semibold"><?= count($orders) ?> đơn</span>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center mb-0">
          <thead class="table-light text-dark">
            <tr class="fw-semibold">
              <th>#</th>
              <th>Khách hàng</th>
              <th>Ngày đặt</th>
              <th>Tổng tiền</th>
              <th>Phương thức</th>
              <th>TT Thanh toán</th>
              <th>Trạng thái đơn</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($orders)): ?>
              <tr>
                <td colspan="8" class="text-center text-muted py-5">
                  <i class="bi bi-cart-x fs-2"></i><br>Chưa có đơn hàng nào.
                </td>
              </tr>
            <?php else: foreach ($orders as $o): ?>
              <tr>
                <td class="text-primary fw-bold">#<?= $o['MaDonHang'] ?></td>
                <td><?= htmlspecialchars($o['TenKhachHang'] ?? 'Khách vãng lai') ?></td>
                <td><i class="bi bi-calendar-event"></i> <?= date('d/m/Y', strtotime($o['NgayDatHang'])) ?></td>
                <td class="text-danger fw-semibold"><?= number_format($o['TongTien'], 0, ',', '.') ?>₫</td>
                <td>
                  <span class="badge bg-info bg-opacity-25 text-dark px-3 py-2 rounded-pill">
                    <?= htmlspecialchars($o['PhuongThucThanhToan']) ?>
                  </span>
                </td>
                <td>
                  <?php
                    switch ($o['TrangThai']) {
                      case 'cho_xac_nhan':
                      case 'da_xac_nhan':
                      case 'dang_giao':
                        $paymentStatus = 'Chờ thanh toán';
                        $paymentBadgeColor = 'bg-warning text-dark';
                        break;
                      case 'da_giao':
                      case 'da_nhan':
                      case 'hoan_thanh':
                        $paymentStatus = 'Đã thanh toán';
                        $paymentBadgeColor = 'bg-success text-white';
                        break;
                      case 'da_huy':
                        $paymentStatus = 'Đã hủy';
                        $paymentBadgeColor = 'bg-secondary text-white';
                        break;
                      default:
                        $paymentStatus = 'Không rõ';
                        $paymentBadgeColor = 'bg-light text-dark';
                    }
                  ?>
                  <span class="badge <?= $paymentBadgeColor ?> px-3 py-2 rounded-pill">
                    <?= $paymentStatus ?>
                  </span>
                </td>
                <td>
                  <?php
                    switch ($o['TrangThai']) {
                      case 'cho_xac_nhan':
                        $displayText = 'Chờ xác nhận';
                        $badgeColor = 'bg-primary text-white';
                        break;
                      case 'da_xac_nhan':
                        $displayText = 'Đã xác nhận';
                        $badgeColor = 'bg-info text-dark';
                        break;
                      case 'dang_giao':
                        $displayText = 'Đang giao hàng';
                        $badgeColor = 'bg-warning text-dark';
                        break;
                      case 'da_giao':
                        $displayText = 'Đã giao hàng';
                        $badgeColor = 'bg-success text-white';
                        break;
                      case 'da_nhan':
                        $displayText = 'Đã nhận';
                        $badgeColor = 'bg-success text-white';
                        break;
                      case 'da_huy':
                        $displayText = 'Đã hủy';
                        $badgeColor = 'bg-danger text-white';
                        break;
                      default:
                        $displayText = htmlspecialchars($o['TrangThai']);
                        $badgeColor = 'bg-light text-dark';
                    }
                  ?>
                  <span class="badge <?= $badgeColor ?> px-3 py-2 rounded-pill">
                    <?= $displayText ?>
                  </span>
                </td>
                <td>
                  <a href="index.php?act=order-detail&id=<?= $o['MaDonHang'] ?>"
                     class="btn btn-sm btn-outline-primary rounded-pill px-3">
                    <i class="bi bi-eye"></i> Xem
                  </a>
                </td>
              </tr>
            <?php endforeach; endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
