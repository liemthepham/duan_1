<?php
// File: admin/controllers/StatsController.php

class StatsController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Phương thức index() trả về trang thống kê
     */
    public function index()
    {
        // 1. Tổng số đơn hàng và tổng doanh thu
        $sqlTotal = "
            SELECT 
                COUNT(*) AS total_orders,
                COALESCE(SUM(TongTien), 0) AS total_revenue
            FROM donhang
        ";
        $stmt = $this->pdo->prepare($sqlTotal);
        $stmt->execute();
        $overview = $stmt->fetch(PDO::FETCH_ASSOC);

        // 2. Số đơn hàng theo trạng thái
        $sqlByStatus = "
            SELECT TrangThai, COUNT(*) AS count_status
            FROM donhang
            GROUP BY TrangThai
        ";
        $stmt = $this->pdo->prepare($sqlByStatus);
        $stmt->execute();
        $byStatus = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        // 3. Doanh thu & số đơn theo từng tháng của năm hiện tại
        $currentYear = date('Y');
        $sqlMonthly = "
            SELECT 
                MONTH(NgayDatHang) AS month_number,
                COUNT(*)           AS orders_count,
                COALESCE(SUM(TongTien), 0) AS revenue
            FROM donhang
            WHERE YEAR(NgayDatHang) = :year
            GROUP BY MONTH(NgayDatHang)
            ORDER BY month_number
        ";
        $stmt = $this->pdo->prepare($sqlMonthly);
        $stmt->execute(['year' => $currentYear]);
        $monthlyRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Chuẩn hoá mảng 1..12 (để nếu tháng nào không có dữ liệu vẫn hiển thị 0)
        $monthly = array_fill(1, 12, ['orders_count' => 0, 'revenue' => 0]);
        foreach ($monthlyRows as $row) {
            $m = (int)$row['month_number'];
            $monthly[$m] = [
                'orders_count' => (int)$row['orders_count'],
                'revenue'      => (float)$row['revenue']
            ];
        }

        // 4. Top 5 sản phẩm bán chạy nhất
        $sqlTopProducts = "
            SELECT 
                sp.MaSanPham,
                sp.TenSanPham,
                sp.AnhDaiDien,
                SUM(cd.SoLuong) AS total_sold
            FROM chitietdonhang cd
            JOIN sanpham sp ON cd.MaSanPham = sp.MaSanPham
            GROUP BY sp.MaSanPham, sp.TenSanPham, sp.AnhDaiDien
            ORDER BY total_sold DESC
            LIMIT 5
        ";
        $stmt = $this->pdo->prepare($sqlTopProducts);
        $stmt->execute();
        $topProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 5. Truyền dữ liệu xuống view
        $data = [
            'overview'    => $overview,
            'byStatus'    => $byStatus,
            'monthly'     => $monthly,
            'topProducts' => $topProducts,
            'currentYear' => $currentYear
        ];
        extract($data);
        require_once __DIR__ . '/../views/layouts/layouts_top.php';
        // Include file view stats.php
        include __DIR__ . '/../views/stats.php';
        require_once __DIR__ . '/../views/layouts/layout_bottom.php';
    }
}
