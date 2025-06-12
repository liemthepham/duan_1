<?php require_once 'views/header.php'; ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom style -->
<style>
    .badge-cho_xac_nhan { background-color: #ffc107; color: #000; }
    .badge-da_xac_nhan { background-color: #0d6efd; }
    .badge-dang_giao    { background-color: #17a2b8; }
    .badge-da_giao      { background-color: #198754; }
    .badge-da_nhan      { background-color: #6f42c1; }
    .badge-khac         { background-color: #6c757d; }

    .card-order-detail {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 0 30px rgba(0,0,0,0.08);
        padding: 2rem;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 2rem;
    }

    .order-summary {
        font-size: 1.1rem;
    }

    .table th, .table td {
        vertical-align: middle !important;
    }
</style>

<div class="container my-5">

    <h2 class="section-title text-center text-primary">Chi Tiết Đơn Hàng #<?php echo htmlspecialchars($order['MaDonHang']); ?></h2>

    <?php
        // Xử lý trạng thái và màu tương ứng
        $status = $order['TrangThai'];
        $badgeClass = 'badge-';
        switch ($status) {
            case 'cho_xac_nhan':
                $badgeClass .= 'cho_xac_nhan';
                $statusText = 'Chờ xác nhận';
                break;
            case 'da_xac_nhan':
                $badgeClass .= 'da_xac_nhan';
                $statusText = 'Đã xác nhận';
                break;
            case 'dang_giao':
                $badgeClass .= 'dang_giao';
                $statusText = 'Đang giao hàng';
                break;
            case 'da_giao':
                $badgeClass .= 'da_giao';
                $statusText = 'Đã giao hàng';
                break;
            case 'da_nhan':
                $badgeClass .= 'da_nhan';
                $statusText = 'Đã nhận';
                break;
            default:
                $badgeClass .= 'khac';
                $statusText = htmlspecialchars($status);
        }
    ?>

    <div class="card card-order-detail">
        <div class="row g-4">
            <!-- Thông tin khách hàng -->
            <div class="col-md-6">
                <h5 class="mb-3 text-secondary">Thông tin khách hàng</h5>
                <p><strong>Khách hàng:</strong> 
                    <?php
                        if (!empty($order['TenKhachHang'])) echo htmlspecialchars($order['TenKhachHang']);
                        elseif (!empty($order['HoTen'])) echo htmlspecialchars($order['HoTen']);
                        elseif (!empty($order['TenDangNhap'])) echo htmlspecialchars($order['TenDangNhap']);
                        else echo 'Khách vãng lai';
                    ?>
                </p>
                <p><strong>Điện thoại:</strong> <?php echo htmlspecialchars($order['SoDienThoai'] ?? 'Không có'); ?></p>
                <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($order['DiaChi'] ?? 'Không có'); ?></p>
                <p><strong>Ngày đặt hàng:</strong> <?php echo htmlspecialchars($order['NgayDatHang']); ?></p>
            </div>

            <!-- Thông tin đơn hàng -->
            <div class="col-md-6">
                <h5 class="mb-3 text-secondary">Thông tin đơn hàng</h5>
                <p><strong>Trạng thái:</strong> <span class="badge <?php echo $badgeClass; ?>"><?php echo $statusText; ?></span></p>
                <p><strong>Phương thức thanh toán:</strong> <?php echo htmlspecialchars($order['PhuongThucThanhToan']); ?></p>
                <p><strong>Tổng tiền:</strong> <span class="text-danger fw-bold"><?php echo number_format($order['TongTien'], 0, ',', '.'); ?> VNĐ</span></p>
            </div>
        </div>

        <hr class="my-4">

        <!-- Danh sách sản phẩm -->
        <h5 class="mb-3 text-secondary">Danh sách sản phẩm</h5>
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle text-center">
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
                            <td><img src="admin/uploads/<?php echo htmlspecialchars($item['AnhDaiDien']); ?>" width="60" class="rounded shadow-sm"></td>
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
            <a href="index.php?act=order-list" class="btn btn-outline-primary rounded-pill">← Quay lại danh sách</a>
        </div>
    </div>

</div>

<?php require_once 'views/footer.php'; ?>
