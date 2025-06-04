<?php

class ProductModel{
  private $conn;

  public function __construct() {
    $this->conn = connectDB();
  }

  public function get_list(){
      $sql = "SELECT 
                  MaSanPham,
                  MaDanhMuc, 
                  TenSanPham, 
                  MoTa, 
                  Gia,
                  SoLuongTon,
                  AnhDaiDien,
                  NgayTao
              FROM sanpham";
      $data = $this->conn->prepare($sql);
      $data->execute();
      return $data->fetchAll(PDO::FETCH_ASSOC);
  }

//add
      public function create($data, $file) {
        // XỬ LÝ UPLOAD ẢNH
        $img = '';
        if (!empty($file['name'])) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $img = uniqid('prd_') . ".$ext";
            move_uploaded_file($file['tmp_name'], __DIR__.'/../uploads/'.$img);
        }
        // CHÈN DỮ LIỆU
        $sql = "INSERT INTO sanpham
                  (MaDanhMuc,TenSanPham,MoTa,SoLuongTon,Gia,AnhDaiDien,NgayTao)
                VALUES (?,?,?,?,?,? ,NOW())";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['MaDanhMuc'],
            $data['TenSanPham'],
            $data['MoTa'],
            $data['SoLuongTon'],
            $data['Gia'],
            $img
        ]);
    }

    //update
      public function update($id, $data, $file) {
    // (1) Lấy filename cũ
    $stmt = $this->conn->prepare("SELECT AnhDaiDien FROM sanpham WHERE MaSanPham = ?");
    $stmt->execute([$id]);
    $old = $stmt->fetch(PDO::FETCH_ASSOC)['AnhDaiDien'];

    // (2) Xử lý ảnh mới
    $filename = $old;
    if (!empty($file['name'])) {
      // xoá cũ
      if ($old && file_exists(__DIR__.'/../uploads/'.$old)) {
        unlink(__DIR__.'/../uploads/'.$old);
      }
      // move file mới
      $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
      $filename = uniqid('prd_').'.'.$ext;
      move_uploaded_file($file['tmp_name'], __DIR__.'/../uploads/'.$filename);
    }

    // (3) Update DB
    $sql = "UPDATE sanpham
             SET MaDanhMuc=?, TenSanPham=?, MoTa=?, SoLuongTon=?, Gia=?, AnhDaiDien=?
           WHERE MaSanPham=?";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([
      $data['MaDanhMuc'],
      $data['TenSanPham'],
      $data['MoTa'],
      $data['SoLuongTon'],
      $data['Gia'],
      $filename,
      $id
    ]);
  }

  /**
   * Lấy 1 bản ghi theo ID
   */
  public function find($id) {
    $stmt = $this->conn->prepare("SELECT * FROM sanpham WHERE MaSanPham=?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  
  //delete

   public function delete($id) {
        // (1) Lấy ảnh cũ để xoá file (nếu có)
        $stmt = $this->conn->prepare("SELECT AnhDaiDien FROM sanpham WHERE MaSanPham = ?");
        $stmt->execute([$id]);
        $old = $stmt->fetch(PDO::FETCH_ASSOC)['AnhDaiDien'];
        if ($old && file_exists(__DIR__.'/../uploads/'.$old)) {
            unlink(__DIR__.'/../uploads/'.$old);
        }

        // (2) Xóa record
        $stmt = $this->conn->prepare("DELETE FROM sanpham WHERE MaSanPham = ?");
        return $stmt->execute([$id]);
    }
public function countByCategory(int $categoryId): int
{
    $sql = "SELECT COUNT(*) AS total FROM sanpham WHERE MaDanhMuc = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$categoryId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return (int)($row['total'] ?? 0);
}

}
