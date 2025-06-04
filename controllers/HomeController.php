<?php
// controllers/HomeController.php

require_once __DIR__ . '/../config/database.php';

class HomeController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Phương thức hiển thị trang chủ (case 'home')
    public function index() {
        // -------------------------------------------
        // Pagination settings
        $items_per_page = 8; // Số sản phẩm trên mỗi trang
        $current_page   = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset         = ($current_page - 1) * $items_per_page;

        // Lấy category_id từ URL nếu có
        $category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;

        // Chuẩn bị câu query cơ bản
        $baseQuery   = "FROM sanpham s JOIN danhmuc d ON s.MaDanhMuc = d.MaDanhMuc";
        $whereClause = "";
        $params      = array();

        // Thêm điều kiện lọc theo danh mục nếu có
        if ($category_id) {
            $whereClause           .= ($whereClause ? " AND" : " WHERE") . " s.MaDanhMuc = :category_id";
            $params[':category_id'] = $category_id;
        }

        // Thêm điều kiện tìm kiếm theo tên sản phẩm
        if (!empty($_GET['search'])) {
            $whereClause           .= ($whereClause ? " AND" : " WHERE") . " s.TenSanPham LIKE :search";
            $params[':search']      = '%' . $_GET['search'] . '%';
        }

        // Đếm tổng số sản phẩm thỏa điều kiện
        $countStmt = $this->pdo->prepare("SELECT COUNT(*) AS total " . $baseQuery . $whereClause);
        $countStmt->execute($params);
        $totalItems = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Lấy danh sách sản phẩm cho trang hiện tại
        $limitStmt = $this->pdo->prepare(
            "SELECT s.*, d.TenDanhMuc " . $baseQuery . $whereClause . " LIMIT :offset, :limit"
        );
        // Bind giá trị offset và limit (phải dùng bindValue vì chỉ số lượng kiểu INT)
        $limitStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $limitStmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
        // Bind các điều kiện filter
        foreach ($params as $key => $val) {
            $limitStmt->bindValue($key, $val);
        }
        $limitStmt->execute();
        $products = $limitStmt->fetchAll(PDO::FETCH_ASSOC);

        // Tính total page để view hiển thị phân trang
        $totalPages = ceil($totalItems / $items_per_page);

        // Cuối cùng: include view
        include __DIR__ . '/../views/index.php';

    }
}
