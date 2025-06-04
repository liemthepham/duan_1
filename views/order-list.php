<?php require_once 'views/header.php' ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container my-5">
    <h2 class="mb-4 text-center">Đơn hàng của bạn</h2>
    <div class="mb-3 text-end">
        <a href="index.php?act=cart" class="btn btn-primary">
            <i class="fas fa-shopping-cart"></i> Xem giỏ hàng
        </a>
    </div>
    <?php if (empty($orders)): ?>
        <div class="alert alert-info">Bạn chưa có đơn hàng nào.</div>
    <?php else: ?>
    <table class="table table-bordered table-hover mt-3">
        <thead class="table-dark">
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
                <td><?= $order['MaDonHang'] ?></td>
                <td><?= $order['NgayDatHang'] ?></td>
                <td><?= $order['TrangThai'] ?></td>
                <td><?= number_format($order['TongTien'], 0, ',', '.') ?> VNĐ</td>
                <td><a href="index.php?act=order-detail&id=<?= $order['MaDonHang'] ?>" class="btn btn-info btn-sm">Xem</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div> 
<?php require_once 'views/footer.php' ?>