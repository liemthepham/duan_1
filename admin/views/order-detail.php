<!-- Sử dụng Bootstrap cho giao diện -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container-fluid my-4">
    <h2>Chi tiết đơn hàng #<?php echo htmlspecialchars($order['MaDonHang']); ?></h2>

    <div class="card mb-4">
        <div class="card-header">
            Thông tin chung
        </div>
        <div class="card-body">
            <p><strong>Khách hàng:</strong> <?php echo htmlspecialchars($order['TenDangNhap'] ?? 'Khách vãng lai'); ?></p>
            <p><strong>Ngày đặt:</strong> <?php echo htmlspecialchars($order['NgayDatHang']); ?></p>
            <p><strong>Trạng thái:</strong> <span class="badge bg-info text-dark"><?php echo htmlspecialchars($order['TrangThai']); ?></span></p>
            <p><strong>Phương thức thanh toán:</strong> <?php echo htmlspecialchars($order['PhuongThucThanhToan']); ?></p>
            <p><strong>Tổng tiền:</strong> <span class="text-danger fw-bold"><?php echo number_format($order['TongTien'], 0, ',', '.'); ?> VNĐ</span></p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            Sản phẩm trong đơn
        </div>
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
                            <td><img src="../uploads/<?php echo htmlspecialchars($item['AnhDaiDien']); ?>" width="60" class="rounded"></td> <!-- Chú ý đường dẫn ảnh -->
                            <td><?php echo htmlspecialchars($item['TenSanPham']); ?></td>
                            <td><?php echo $item['SoLuong']; ?></td>
                            <td><?php echo number_format($item['GiaBan'], 0, ',', '.'); ?> VNĐ</td>
                            <td><?php echo number_format($item['GiaBan'] * $item['SoLuong'], 0, ',', '.'); ?> VNĐ</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <a href="index.php?act=orders" class="btn btn-secondary">Quay lại danh sách đơn hàng</a>
</div> 