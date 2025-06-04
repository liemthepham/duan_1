<?php require_once 'views/header.php' ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container my-5">
    <h2 class="section-title text-center">Chi Tiết Đơn Hàng <?php echo htmlspecialchars($order['MaDonHang']); ?></h2>
    <div class="mb-3">
        <strong>Khách hàng:</strong> <?php echo htmlspecialchars($order['TenDangNhap'] ?? 'Khách vãng lai'); ?><br>
        <strong>Ngày đặt:</strong> <?php echo htmlspecialchars($order['NgayDatHang']); ?><br>
        <strong>Trạng thái:</strong> <span class="badge bg-info text-dark"><?php echo htmlspecialchars($order['TrangThai']); ?></span><br>
        <strong>Phương thức thanh toán:</strong> <?php echo htmlspecialchars($order['PhuongThucThanhToan']); ?><br>
        <strong>Tổng tiền:</strong> <span class="text-danger fw-bold"><?php echo number_format($order['TongTien'], 0, ',', '.'); ?> VNĐ</span>
    </div>

    <h4 class="mt-4">Sản phẩm trong đơn</h4>
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
                    <td><img src="admin/uploads/<?php echo htmlspecialchars($item['AnhDaiDien']); ?>" width="60" class="rounded"></td>
                    <td><?php echo htmlspecialchars($item['TenSanPham']); ?></td>
                    <td><?php echo $item['SoLuong']; ?></td>
                    <td><?php echo number_format($item['GiaBan'], 0, ',', '.'); ?> VNĐ</td>
                    <td class="text-danger fw-bold"><?php echo number_format($item['GiaBan'] * $item['SoLuong'], 0, ',', '.'); ?> VNĐ</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <a href="index.php?act=order-list" class="btn btn-secondary mt-3">Quay lại danh sách đơn hàng</a>
</div> 
<?php require_once 'views/footer.php' ?>