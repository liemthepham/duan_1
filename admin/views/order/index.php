<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary fw-bold mb-0"> Danh sách đơn hàng</h1>
    </div>

    <div class="card shadow border-0 rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Khách hàng</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($orders)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-info-circle me-2"></i>Chưa có đơn hàng nào.
                                </td>
                            </tr>
                        <?php else: foreach ($orders as $o): ?>
                            <tr>
                                <td class="fw-bold text-primary">#<?= htmlspecialchars($o['MaDonHang']) ?></td>
                                <td><?= htmlspecialchars($o['TenDangNhap'] ?? 'Khách vãng lai') ?></td>
                                <td><?= date('d/m/Y', strtotime($o['NgayDatHang'])) ?></td>
                                <td class="text-danger fw-semibold"><?= number_format($o['TongTien'], 0, ',', '.') ?>₫</td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        <?= htmlspecialchars($o['TrangThai']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href=" index.php?act=order-detail&id=<?= $o['MaDonHang'] ?>"
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
