<?php
require_once __DIR__ . '/../../commons/function.php'; // chứa hàm connectDB()

class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = connectDB();
    }

    /** Lấy tất cả người dùng */
    public function get_list()
    {
        $stmt = $this->db->query("SELECT * FROM nguoidung ORDER BY MaNguoiDung DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Lấy 1 user theo ID */
    public function findOne(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM nguoidung WHERE MaNguoiDung = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /** Tạo mới user */
    public function create(array $data)
    {
        $sql = "INSERT INTO nguoidung (TenDangNhap, Email, MatKhau, VaiTro, NgayTao)
                VALUES (?, ?, ?, ?, NOW())";
        $stmt = $this->db->prepare($sql);

        // Mã hóa mật khẩu
        $hash = password_hash($data['MatKhau'], PASSWORD_DEFAULT);

        return $stmt->execute([
            $data['TenDangNhap'],
            $data['Email'],
            $hash,
            $data['VaiTro']
        ]);
    }

    /** Tìm user theo email (đã có) */
    public function findByEmail(string $email)
    {
        $sql  = "SELECT * FROM nguoidung WHERE Email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /** Tìm user theo tên đăng nhập (mới) */
    public function findByUsername(string $username)
    {
        $sql  = "SELECT * FROM nguoidung WHERE TenDangNhap = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /** Cập nhật user (nếu MatKhau để trống thì giữ nguyên) */
    public function update(int $id, array $data)
    {
        if (!empty($data['MatKhau'])) {
            $hash = password_hash($data['MatKhau'], PASSWORD_DEFAULT);
            $sql  = "UPDATE nguoidung
                     SET TenDangNhap = ?, Email = ?, MatKhau = ?, VaiTro = ?
                     WHERE MaNguoiDung = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $data['TenDangNhap'],
                $data['Email'],
                $hash,
                $data['VaiTro'],
                $id
            ]);
        } else {
            $sql  = "UPDATE nguoidung
                     SET TenDangNhap = ?, Email = ?, VaiTro = ?
                     WHERE MaNguoiDung = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $data['TenDangNhap'],
                $data['Email'],
                $data['VaiTro'],
                $id
            ]);
        }
    }

    /** Xóa user */
    public function delete(int $id)
    {
        $stmt = $this->db->prepare("DELETE FROM nguoidung WHERE MaNguoiDung = ?");
        return $stmt->execute([$id]);
    }

    /** Tìm user theo điều kiện search (đã có) */
    public function search(string $q): array
    {
        $sql = "SELECT * FROM nguoidung
                WHERE TenDangNhap LIKE :q
                   OR Email       LIKE :q
                ORDER BY MaNguoiDung DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['q' => '%' . $q . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
