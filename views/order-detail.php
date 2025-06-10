<?php require_once 'views/header.php' ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container my-5">

    <h2 class="section-title text-center">Chi Tiết Đơn Hàng <?php echo htmlspecialchars($order['MaDonHang']); ?></h2>

    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <?php if (!empty($orderDetails)): ?>
                <div class="col-md-3 text-center">
                    <img src="admin/uploads/<?php echo htmlspecialchars($orderDetails[0]['AnhDaiDien']); ?>" width="120" class="rounded-3 shadow-sm mb-3 mb-md-0">
                    <p class="text-muted mb-0"><?php echo count($orderDetails); ?> sản phẩm</p>
                </div>
                <?php endif; ?>
                <div class="col-md-9">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <p class="mb-2"><i class="bi bi-person-circle me-2 text-primary"></i><strong>Khách hàng:</strong> <?php echo htmlspecialchars($order['TenKhachHang'] ?? 'Khách vãng lai'); ?></p>
                            <p class="mb-2"><i class="bi bi-calendar-event me-2 text-primary"></i><strong>Ngày đặt:</strong> <?php echo htmlspecialchars($order['NgayDatHang']); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><i class="bi bi-info-circle me-2 text-primary"></i><strong>Trạng thái:</strong> 
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
                                                echo 'Đã giao hàng';
                                                break;
                                            case 'da_nhan':
                                                echo 'Đã nhận';
                                                break;
                                            default:
                                                echo htmlspecialchars($order['TrangThai']);
                                        }
                                    ?>
                                </span>
                            </p>
                            <p class="mb-2"><i class="bi bi-credit-card me-2 text-primary"></i><strong>Thanh toán:</strong> <?php echo htmlspecialchars($order['PhuongThucThanhToan']); ?></p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <p class="mb-0"><i class="bi bi-cash-coin me-2 text-primary"></i><strong>Tổng tiền:</strong> <span class="text-danger fw-bold fs-5"><?php echo number_format($order['TongTien'], 0, ',', '.'); ?> VNĐ</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-lg rounded-4 border-0">
        <div class="card-body p-5">
            <h2 class="mb-4 text-primary">Đơn hàng <?php echo htmlspecialchars($order['MaDonHang']); ?></h2>
            
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <p><i class="bi bi-person-circle me-2 text-secondary"></i><strong>Khách hàng:</strong> <?php echo htmlspecialchars($order['TenDangNhap'] ?? 'Khách vãng lai'); ?></p>
                    <p><i class="bi bi-calendar-event me-2 text-secondary"></i><strong>Ngày đặt:</strong> <?php echo htmlspecialchars($order['NgayDatHang']); ?></p>
                </div>
                <div class="col-md-6">
                    <p><i class="bi bi-info-circle me-2 text-secondary"></i><strong>Trạng thái:</strong> <span class="badge bg-info text-dark">
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
                                    echo 'Đã giao hàng';
                                    break;
                                case 'da_nhan':
                                    echo 'Đã nhận';
                                    break;
                                default:
                                    echo htmlspecialchars($order['TrangThai']);
                            }
                        ?>
                    </span></p>
                    <p><i class="bi bi-credit-card me-2 text-secondary"></i><strong>Thanh toán:</strong> <?php echo htmlspecialchars($order['PhuongThucThanhToan']); ?></p>
                    <p><i class="bi bi-cash-coin me-2 text-secondary"></i><strong>Tổng tiền:</strong> <span class="text-danger fw-bold"><?php echo number_format($order['TongTien'], 0, ',', '.'); ?> VNĐ</span></p>
                </div>
            </div>


            <h4 class="mt-4 mb-3 text-secondary">Danh sách sản phẩm</h4>
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle text-center rounded-3 overflow-hidden">
                    <thead class="table-dark">
                        <tr>
                            <th>Ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá bán</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderDetails as $item): ?>
                        <tr>
                            <td><img src="admin/uploads/<?php echo htmlspecialchars($item['AnhDaiDien']); ?>" width="60" class="rounded-2 shadow-sm"></td>
                            <td><?php echo htmlspecialchars($item['TenSanPham']); ?></td>
                            <td><?php echo $item['SoLuong']; ?></td>
                            <td><?php echo number_format($item['GiaBan'], 0, ',', '.'); ?> VNĐ</td>
                            <td class="text-danger fw-bold"><?php echo number_format($item['GiaBan'] * $item['SoLuong'], 0, ',', '.'); ?> VNĐ</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="text-end mt-4">
                <?php if ($order['TrangThai'] === 'da_giao'): ?>
                    <a href="index.php?act=receive-order&id=<?php echo htmlspecialchars($order['MaDonHang']); ?>" class="btn btn-success rounded-pill px-4 me-2">Đã nhận hàng</a>
                <?php endif; ?>
                <a href="index.php?act=order-list" class="btn btn-outline-primary rounded-pill px-4">← Quay lại danh sách</a>
            </div>
        </div>
    </div>

    <a href="index.php?act=order-list" class="btn btn-secondary mt-3">Quay lại danh sách đơn hàng</a>
</div> 
<?php require_once 'views/footer.php' ?>

