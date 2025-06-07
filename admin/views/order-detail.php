<!-- Bootstrap & Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="container-fluid my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary fw-bold">
            <i class="bi bi-receipt-cutoff me-2"></i>Chi tiết đơn hàng <?php echo htmlspecialchars($order['MaDonHang']); ?>
        </h2>
        <a href="index.php?act=order-list" class="btn btn-outline-secondary rounded-pill">
            <i class="bi bi-arrow-left me-1"></i> Quay lại danh sách
        </a>
    </div>

    <!-- Thông tin chung -->
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-header bg-light fw-bold">Thông tin chung</div>
        <div class="card-body">
            <div class="row gy-3">
                <div class="col-md-6">
                    <p><strong>👤 Khách hàng:</strong> <?= htmlspecialchars($order['TenDangNhap'] ?? 'Khách vãng lai') ?></p>
                    <p><strong>🕒 Ngày đặt:</strong> <?= htmlspecialchars($order['NgayDatHang']) ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>📦 Trạng thái:</strong>
                        <span class="badge bg-info text-dark"><?= htmlspecialchars($order['TrangThai']) ?></span>
                    </p>
                    <p><strong>💳 Phương thức thanh toán:</strong> <?= htmlspecialchars($order['PhuongThucThanhToan']) ?></p>
                </div>
            </div>
            <p class="mt-2 fs-5"><strong>💰 Tổng tiền:</strong>
                <span class="text-danger fw-bold"><?= number_format($order['TongTien'], 0, ',', '.') ?> VNĐ</span>
            </p>

            <!-- Debug: Checking TrangThai value for cancel button -->
            <?php // echo 'Debug TrangThai for Cancel: [' . $order['TrangThai'] . ']'; ?>

            <!-- Nút Hủy đơn hàng (chỉ hiển thị khi trạng thái cho phép) -->
            <?php if ($order['TrangThai'] === 'da_xac_nhan' || $order['TrangThai'] === 'dang_giao'): ?>
                <div class="mt-4 pt-3 border-top">
                     <a href="index.php?act=cancel&id=<?= $order['MaDonHang'] ?>" 
                        class="btn btn-danger rounded-pill px-4" 
                        onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng #<?= $order['MaDonHang'] ?> không?');">
                        <i class="bi bi-x-circle me-1"></i> Hủy đơn hàng
                    </a>
                </div>
            <?php endif; ?>

            <!-- Cập nhật trạng thái -->
            <div class="border-top pt-4 mt-4">
                <h5 class="mb-3 text-secondary"><i class="bi bi-pencil-square me-1"></i>Cập nhật trạng thái</h5>
                <form action="index.php?act=update-order-status" method="POST" class="row g-3 align-items-center">
                    <input type="hidden" name="ma_don_hang" value="<?= htmlspecialchars($order['MaDonHang']) ?>">
                    <div class="col-auto">
                        <select name="trang_thai" class="form-select rounded-pill px-4" required>
                            <option value="">-- Chọn trạng thái --</option>
                            <option value="cho_xac_nhan" <?= $order['TrangThai'] == 'cho_xac_nhan' ? 'selected' : '' ?> disabled>Chờ xác nhận</option>
                            <option value="da_xac_nhan" <?= $order['TrangThai'] == 'da_xac_nhan' ? 'selected' : '' ?>>Đã xác nhận / Chờ lấy hàng</option>
                            <option value="dang_giao" <?= $order['TrangThai'] == 'dang_giao' ? 'selected' : '' ?>>Đang giao hàng</option>
                            <option value="da_giao" <?= $order['TrangThai'] == 'da_giao' ? 'selected' : '' ?>>Đã giao hàng</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-save me-1"></i>Cập nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Danh sách sản phẩm -->
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-header bg-light fw-bold">Sản phẩm trong đơn</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
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
                                <td>
                                    <img src="/duan_1/admin/uploads/<?= htmlspecialchars($item['AnhDaiDien']) ?>" width="60" class="rounded">
                                </td>
                                <td><?= htmlspecialchars($item['TenSanPham']) ?></td>
                                <td><?= $item['SoLuong'] ?></td>
                                <td><?= number_format($item['GiaBan'], 0, ',', '.') ?> VNĐ</td>
                                <td class="text-danger fw-semibold">
                                    <?= number_format($item['GiaBan'] * $item['SoLuong'], 0, ',', '.') ?> VNĐ
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
