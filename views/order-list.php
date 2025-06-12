<?php require_once 'views/header.php' ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<div class="container my-5">

    <?php
    if (isset($_SESSION['success_msg'])) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
        echo $_SESSION['success_msg'];
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
        unset($_SESSION['success_msg']);
    }
    if (isset($_SESSION['error_msg'])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo $_SESSION['error_msg'];
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
        unset($_SESSION['error_msg']);
    }
    ?>

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
                                <th>Tên khách hàng</th>
                                <th>Ngày mua</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái thanh toán</th>
                                <th>Trạng thái đơn hàng</th>
                                <th>Phương thức thanh toán</th>
                                <th>Chi tiết</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                            <tr>
                                <td class="fw-bold text-primary">#<?= htmlspecialchars($order['MaDonHang']) ?></td>
                                <td>
                                    <?php
                                    if (!empty($order['TenKhachHang'])) {
                                        echo htmlspecialchars($order['TenKhachHang']);
                                    } elseif (!empty($order['HoTen'])) {
                                        echo htmlspecialchars($order['HoTen']);
                                    } elseif (!empty($order['TenDangNhap'])) {
                                        echo htmlspecialchars($order['TenDangNhap']);
                                    } else {
                                        echo 'Khách vãng lai';
                                    }
                                    ?>
                                </td>
                                <td><?= htmlspecialchars($order['NgayDatHang']) ?></td>
                                <td class="text-danger fw-semibold">
                                    <?= number_format($order['TongTien'], 0, ',', '.') ?> VNĐ
                                </td>
                                <td>
                                    <?php
                                        switch ($order['TrangThai']) {
                                            case 'cho_xac_nhan':
                                            case 'da_xac_nhan':
                                            case 'dang_giao':
                                            case 'da_giao':
                                                echo '<span class="badge bg-warning text-dark">Chờ thanh toán</span>';
                                                break;
                                            case 'da_nhan':
                                                echo '<span class="badge bg-success">Đã thanh toán</span>';
                                                break;
                                            case 'da_huy':
                                                echo '<span class="badge bg-secondary">Đã hủy</span>';
                                                break;
                                            default:
                                                echo '<span class="badge bg-dark">Không rõ</span>';
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        switch ($order['TrangThai']) {
                                            case 'cho_xac_nhan':
                                                echo '<span class="badge bg-primary">Chờ xác nhận</span>';
                                                break;
                                            case 'da_xac_nhan':
                                                echo '<span class="badge bg-info text-dark">Đã xác nhận</span>';
                                                break;
                                            case 'dang_giao':
                                                echo '<span class="badge bg-warning text-dark">Đang giao hàng</span>';
                                                break;
                                            case 'da_giao':
                                                echo '<span class="badge bg-success">Đã giao hàng</span>';
                                                break;
                                            case 'da_nhan':
                                                echo '<span class="badge bg-success">Đã nhận</span>';
                                                break;
                                            case 'da_huy':
                                                echo '<span class="badge bg-danger">Đã hủy</span>';
                                                break;
                                            default:
                                                echo '<span class="badge bg-dark">' . htmlspecialchars($order['TrangThai']) . '</span>';
                                        }
                                    ?>
                                </td>
                                <td><?= htmlspecialchars($order['PhuongThucThanhToan'] ?? '') ?></td>
                                <td>
                                    <a href="index.php?act=order-detail&id=<?= $order['MaDonHang'] ?>" class="btn btn-outline-info btn-sm rounded-pill">
                                        <i class="bi bi-eye"></i> Xem
                                    </a>
                                </td>
                                <td>
                                    <?php if ($order['TrangThai'] == 'cho_xac_nhan' || $order['TrangThai'] == 'da_xac_nhan'): ?>
                                        <a href="index.php?act=cancel-order&id=<?= $order['MaDonHang'] ?>" class="btn btn-danger btn-sm rounded-pill me-1" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng #<?= $order['MaDonHang'] ?> không?');">
                                            <i class="bi bi-x-circle"></i> Hủy
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($order['TrangThai'] == 'da_giao'): ?>
                                         <a href="index.php?act=complete-order-client&id=<?= $order['MaDonHang'] ?>" class="btn btn-success btn-sm rounded-pill" onclick="return confirm('Bạn có chắc chắn đã nhận được đơn hàng #<?= $order['MaDonHang'] ?> không?');">
                                            <i class="bi bi-check-circle"></i> Đã nhận
                                        </a>
                                    <?php endif; ?>
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
