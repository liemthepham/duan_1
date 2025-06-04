<?php
require_once 'commons/env.php';
require_once 'commons/function.php';
class FrontProductController {
    private $pdo;

    public function __construct() {
        
        $this->pdo = connectDB();
    }
//index
 public function index() {
        // 1. Lấy filter từ URL
        $keyword   = trim($_GET['keyword']   ?? '');
        $category  = $_GET['category']       ?? '';
        $price_min = (float)($_GET['price_min'] ?? 0);
        $price_max = (float)($_GET['price_max'] ?? 0);

        // 2. Nhóm điều kiện
        $group1 = [];   // keyword + price là OR
        $params = [];

        if ($keyword !== '') {
            $group1[]        = "s.TenSanPham LIKE :kw";
            $params[':kw']   = "%{$keyword}%";
        }
        if ($price_min > 0) {
            $group1[]        = "s.Gia >= :min";
            $params[':min']  = $price_min;
        }
        if ($price_max > 0) {
            $group1[]        = "s.Gia <= :max";
            $params[':max']  = $price_max;
        }

        $group2 = [];   // category là AND bắt buộc
        if ($category !== '') {
            $group2[]          = "s.MaDanhMuc = :cat";
            $params[':cat']    = $category;
        }

        // 3. Kết hợp WHERE
        $clauses = [];
        if (count($group1)) {
            $clauses[] = '(' . implode(' AND ', $group1) . ')';
        }
        if (count($group2)) {
            $clauses[] = implode(' AND ', $group2);
        }

        $where = '';
        if (count($clauses)) {
            $where = 'WHERE ' . implode(' AND ', $clauses);
        }

        // 4. Thực thi truy vấn chính
        $sql  = "SELECT s.*, d.TenDanhMuc 
                FROM sanpham s 
                JOIN danhmuc d ON s.MaDanhMuc = d.MaDanhMuc 
                $where 
                ORDER BY s.NgayTao DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 5. Lấy để show dropdown Danh mục
        $stmt2 = $this->pdo->query("SELECT MaDanhMuc, TenDanhMuc FROM danhmuc");
        $cats   = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        // 6. Render view, truyền $products, $cats và các filter cũ
        require_once __DIR__ . '/../views/sanpham/index.php';
    }
//aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
    public function show($id) {
        // Lấy thông tin chi tiết sản phẩm
        $stmt = $this->pdo->prepare("
            SELECT s.*, d.TenDanhMuc 
            FROM sanpham s 
            JOIN danhmuc d ON s.MaDanhMuc = d.MaDanhMuc 
            WHERE s.MaSanPham = ?
        ");
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            header('Location: index.php');
            exit;
        }

        // Lấy các sản phẩm liên quan (cùng danh mục)
        $stmt = $this->pdo->prepare("
            SELECT * FROM sanpham 
            WHERE MaDanhMuc = ? AND MaSanPham != ? 
            LIMIT 4
        ");
        $stmt->execute([$product['MaDanhMuc'], $id]);
        $relatedProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Lấy bình luận của sản phẩm
        $stmt = $this->pdo->prepare("
            SELECT b.*, n.TenDangNhap 
            FROM binhluan b
            JOIN nguoidung n ON b.MaNguoiDung = n.MaNguoiDung
            WHERE b.MaSanPham = ?
            ORDER BY b.NgayBinhLuan DESC
        ");
        $stmt->execute([$id]);
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once 'views/product-detail.php';
    }

    public function addComment() {
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Vui lòng đăng nhập để bình luận!";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? 0;
            $content = $_POST['content'] ?? '';
            $userId = $_SESSION['user']['MaNguoiDung'];

            if (empty($content)) {
                $_SESSION['error'] = "Nội dung bình luận không được để trống!";
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }

            $stmt = $this->pdo->prepare("
                INSERT INTO binhluan (MaSanPham, MaNguoiDung, NoiDung, NgayBinhLuan)
                VALUES (?, ?, ?, NOW())
            ");
            
            if ($stmt->execute([$productId, $userId, $content])) {
                $_SESSION['success'] = "Bình luận đã được thêm thành công!";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi thêm bình luận!";
            }
        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
} 