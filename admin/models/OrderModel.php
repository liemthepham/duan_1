<?php
require_once __DIR__ . '/../../commons/env.php';

class OrderModel {
  private $pdo;
  public function __construct() {
    $this->pdo = new PDO("mysql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME, 
                         DB_USERNAME, DB_PASSWORD);
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  /**
   * Lấy toàn bộ đơn hàng kèm tên user
   */
  public function getAll() {
    $stmt = $this->pdo->prepare(
      "SELECT d.MaDonHang, d.NgayDatHang, d.TongTien, d.TrangThai,
              u.TenDangNhap
       FROM donhang d
       JOIN nguoidung u ON d.MaNguoiDung = u.MaNguoiDung
       ORDER BY d.NgayDatHang  DESC"
    );
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
