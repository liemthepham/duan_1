<?php
// File: admin/views/stats.php
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Thống kê hệ thống</title>

    <!-- 1) Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- 2) Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- 3) CSS tùy chỉnh cho Stats -->
    <link href="../assets/css/stats.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid my-4">
    <!-- Tiêu đề -->
    <h2 class="mb-4">
      <i class="bi bi-bar-chart-fill me-2"></i>Thống kê hệ thống (Năm <?php echo $currentYear; ?>)
    </h2>

    <!-- 1. Tổng quan: Số đơn & Doanh thu -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card stats-card bg-primary h-100">
                <div class="card-body">
                    <h5 class="card-title">
                      <i class="bi bi-receipt me-2"></i>Tổng số đơn hàng
                    </h5>
                    <p class="display-6 mb-0">
                      <?php echo number_format($overview['total_orders']); ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card stats-card bg-success h-100">
                <div class="card-body">
                    <h5 class="card-title">
                      <i class="bi bi-currency-dollar me-2"></i>Tổng doanh thu
                    </h5>
                    <p class="display-6 mb-0">
                      <?php echo number_format($overview['total_revenue'], 0, ',', '.'); ?> VNĐ
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Đơn hàng theo trạng thái -->
    <div class="card mb-4 stats-card">
        <div class="card-header bg-secondary text-white">
            <i class="bi bi-list-task me-2"></i>Đơn hàng theo trạng thái
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle table-status mb-0">
                    <thead>
                        <tr>
                            <th>Trạng thái</th>
                            <th class="text-center">Số lượng</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $statusLabels = [
                        'cho_xac_nhan' => 'Chờ xác nhận',
                        'da_xac_nhan'  => 'Đã xác nhận',
                        'dang_giao'    => 'Đang giao',
                        'da_giao'      => 'Đã giao',
                        'da_huy'       => 'Đã hủy',
                    ];
                    foreach ($byStatus as $statusKey => $count): 
                        $label = $statusLabels[$statusKey] ?? $statusKey;
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($label); ?></td>
                            <td class="text-center"><?php echo number_format($count); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 3. Doanh thu & Đơn hàng theo tháng -->
    <div class="card mb-4 stats-card">
        <div class="card-header bg-info text-white">
            <i class="bi bi-calendar-event me-2"></i>Doanh thu & Đơn hàng theo tháng
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-monthly text-center mb-0">
                    <thead>
                        <tr>
                            <th>Tháng</th>
                            <th>Số đơn</th>
                            <th>Doanh thu (VNĐ)</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php for ($m = 1; $m <= 12; $m++): 
                        $ordersCount = $monthly[$m]['orders_count'];
                        $revenue    = $monthly[$m]['revenue'];
                    ?>
                        <tr>
                            <td>Tháng <?php echo $m; ?></td>
                            <td><?php echo number_format($ordersCount); ?></td>
                            <td class="text-end"><?php echo number_format($revenue, 0, ',', '.'); ?></td>
                        </tr>
                    <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 4. Top 5 sản phẩm bán chạy nhất -->
    <div class="card mb-4 stats-card">
        <div class="card-header bg-warning text-dark">
            <i class="bi bi-star-fill me-2"></i>Top 5 sản phẩm bán chạy nhất
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-top-products align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th class="text-center">Đã bán</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $no = 1;
                    foreach ($topProducts as $product): 
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $no++; ?></td>
                            <td>
                                <img 
                                  src="../uploads/<?php echo htmlspecialchars($product['AnhDaiDien']); ?>" 
                                  alt="<?php echo htmlspecialchars($product['TenSanPham']); ?>" 
                                  class="img-thumbnail"
                                  style="max-width:70px;"
                                >
                            </td>
                            <td><?php echo htmlspecialchars($product['TenSanPham']); ?></td>
                            <td class="text-center"><?php echo number_format($product['total_sold']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 5. Nút “Quay lại” -->
    <div class="text-end mb-5">
        <a href="index.php?act=order-list" class="btn btn-back">
            <i class="bi bi-arrow-left-circle me-1"></i> Quay lại danh sách đơn hàng
        </a>
    </div>
</div>

<!-- 6) Bootstrap JS (nếu layout chưa include) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
