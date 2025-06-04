<?php require_once 'views/header.php' ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<div class="container my-5">
    <div class="text-center mb-4">
        <h2 class="text-primary fw-bold">Đơn hàng của bạn</h2>
        <p class="text-muted">Xem lại lịch sử mua hàng và theo dõi trạng thái đơn hàng.</p>
    </div>

    <div class="mb-4 text-end">
        <a href="index.php?act=cart" class="btn btn-outline-primary rounded-pill px-4">
            <i class="bi bi-cart4 me-1"></i> Xem giỏ hàng
        </a>
    </div>

    <?php if (empty($orders)): ?>
        <div class="alert alert-warning text-center py-4 rounded-3 shadow-sm">
            <i class="bi bi-exclamation-circle fs-4 me-2"></i>Bạn chưa có đơn hàng nào.
        </div>
    <?php else: ?>
        <div class="card shadow border-0 rounded-4">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Mã ĐH</th>
                                <th>Ngày đặt</th>
                                <th>Trạng thái</th>
                                <th>Tổng tiền</th>
                                <th>Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                            <tr>
                                <td class="fw-bold text-primary">#<?= htmlspecialchars($order['MaDonHang']) ?></td>
                                <td><?= htmlspecialchars($order['NgayDatHang']) ?></td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        <?php
                                            switch ($order['TrangThai']) {
                                                case 'cho_xac_nhan':
                                                    echo 'Chờ xác nhận';
                                                    break;
                                                case 'da_xac_nhan':
                                                    echo 'Đã xác nhận';
                                                    break;
                                                case 'dang_giao':
                                                    echo 'Đang giao hàng';
                                                    break;
                                                case 'da_giao':
                                                    echo 'Đã nhận';
                                                    break;
                                                default:
                                                    echo htmlspecialchars($order['TrangThai']);
                                            }
                                        ?>
                                    </span>
                                </td>
                                <td class="text-danger fw-semibold">
                                    <?= number_format($order['TongTien'], 0, ',', '.') ?> VNĐ
                                </td>
                                <td>
                                    <a href="index.php?act=order-detail&id=<?= $order['MaDonHang'] ?>" class="btn btn-outline-info btn-sm rounded-pill">
                                        <i class="bi bi-eye"></i> Xem
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div> 
<?php require_once 'views/footer.php' ?>
