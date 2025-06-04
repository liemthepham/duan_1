<?php
class CategoryModel
{
    private $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }

    // 1. Lấy danh sách (có phân cấp)
    public function getAll()
    {
        $sql = "SELECT * FROM danhmuc ORDER BY MaDanhMucCha ASC, MaDanhMuc ASC";
        $stmt = $this->conn->query("SELECT MaDanhMuc, TenDanhMuc FROM danhmuc");
        return $this->conn->query($sql, PDO::FETCH_ASSOC)->fetchAll();
    }

    // 2. Lấy 1 record
    public function find($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM danhmuc WHERE MaDanhMuc = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 3. Tạo mới
    public function create($data)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO danhmuc (TenDanhMuc, MaDanhMucCha) VALUES (?, ?)"
        );
        return $stmt->execute([
            $data['TenDanhMuc'],
            $data['MaDanhMucCha'] ?: null
        ]);
    }

    // 4. Cập nhật
    public function update($id, $data)
    {
        $stmt = $this->conn->prepare(
            "UPDATE danhmuc
             SET TenDanhMuc   = ?,
                 MaDanhMucCha = ?
           WHERE MaDanhMuc = ?"
        );
        return $stmt->execute([
            $data['TenDanhMuc'],
            $data['MaDanhMucCha'] ?: null,
            $id
        ]);
    }

    // 5. Xóa
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM danhmuc WHERE MaDanhMuc = ?");
        return $stmt->execute([$id]);
    }
}
