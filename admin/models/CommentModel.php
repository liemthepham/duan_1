<?php
require_once __DIR__ . '/../../commons/function.php';

class CommentModel
{
    private $db;

    public function __construct()
    {
        $this->db = connectDB();
    }

    /** Lấy danh sách tất cả bình luận */
    public function get_list(): array
    {
        $sql = "SELECT b.*, n.TenDangNhap, s.TenSanPham 
                FROM binhluan b
                JOIN nguoidung n ON b.MaNguoiDung = n.MaNguoiDung
                JOIN sanpham s ON b.MaSanPham = s.MaSanPham
                ORDER BY b.NgayBinhLuan DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Xoá bình luận theo ID */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM binhluan WHERE MaBinhLuan = ?");
        return $stmt->execute([$id]);
    }

    /** Thêm bình luận (phía user gửi) */
    public function create(array $data): bool
    {
        $sql = "INSERT INTO binhluan (MaNguoiDung, MaSanPham, NoiDung, NgayBinhLuan)
                VALUES (?, ?, ?, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['MaNguoiDung'],
            $data['MaSanPham'],
            $data['NoiDung']
        ]);
    }

    /** Tìm kiếm bình luận (theo ND, SP, Nội dung) */
    public function search(string $q): array
    {
        $sql = "SELECT b.*, n.TenDangNhap, s.TenSanPham 
                FROM binhluan b
                JOIN nguoidung n ON b.MaNguoiDung = n.MaNguoiDung
                JOIN sanpham s ON b.MaSanPham = s.MaSanPham
                WHERE b.NoiDung LIKE :q 
                   OR n.TenDangNhap LIKE :q 
                   OR s.TenSanPham LIKE :q
                ORDER BY b.NgayBinhLuan DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['q' => '%' . $q . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
