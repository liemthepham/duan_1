
<?php
require_once 'config/database.php';
// models/User.php

class User
{
    private $db;
    public function __construct()
    {
        global $pdo;
        $this->db = $pdo;
    }

    public function authenticate($username, $password)
    {
        $stmt = $this->db->prepare("
  SELECT MaNguoiDung, TenDangNhap, Email, MatKhau, VaiTro
  FROM nguoidung
  WHERE TenDangNhap = :u OR Email = :e
  LIMIT 1
");
        $stmt->execute(['u' => $username, 'e' => $username]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['MatKhau'])) {
            unset($user['MatKhau']);
            return $user;
        }
        return false;
    }
}
