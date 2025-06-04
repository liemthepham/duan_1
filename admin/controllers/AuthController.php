<?php
// admin/controllers/AuthController.php
require_once __DIR__ . '/../models/UserModel.php';

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Hiển thị và xử lý đăng ký (register)
     */
    public function register()
    {
        // Khởi tạo mảng $values để tránh warning undefined key
        $values = [
            'TenDangNhap' => '',
            'Email'       => '',
            'MatKhau'     => '',
            'VaiTro'      => 'admin',
        ];
        $error = '';

        // Nếu form vừa được submit (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $values['TenDangNhap'] = trim($_POST['TenDangNhap'] ?? '');
            $values['Email']       = trim($_POST['Email'] ?? '');
            $values['MatKhau']     = trim($_POST['MatKhau'] ?? '');

            // 1) Kiểm tra các trường không được rỗng
            if (empty($values['TenDangNhap']) || empty($values['Email']) || empty($values['MatKhau'])) {
                $error = "Vui lòng điền đầy đủ tên đăng nhập, email và mật khẩu.";
            } else {
                // 2) Kiểm tra username/email đã tồn tại chưa
                $existsByUsername = $this->userModel->findByUsername($values['TenDangNhap']);
                $existsByEmail    = $this->userModel->findByEmail($values['Email']);

                if ($existsByUsername) {
                    $error = "Tên đăng nhập '{$values['TenDangNhap']}' đã tồn tại.";
                } elseif ($existsByEmail) {
                    $error = "Email '{$values['Email']}' đã được đăng ký.";
                }
            }

            // 3) Nếu không có lỗi, tạo user mới và redirect về login
            if (empty($error)) {
                $created = $this->userModel->create([
                    'TenDangNhap' => $values['TenDangNhap'],
                    'Email'       => $values['Email'],
                    'MatKhau'     => $values['MatKhau'],
                    'VaiTro'      => $values['VaiTro'],
                ]);

                if ($created) {
                    header('Location: index.php?act=auth-login');
                    exit;
                } else {
                    $error = "Không thể tạo tài khoản. Vui lòng thử lại.";
                }
            }
        }

        // Cuối cùng: include view đăng ký
        require_once __DIR__ . '/../views/layouts/authtop.php';
        require_once __DIR__ . '/../views/auth/register.php';
        require_once __DIR__ . '/../views/layouts/authbottom.php';
    }

    /**
     * Hiển thị và xử lý đăng nhập (login)
     */
    public function login()
    {
        // Khởi tạo mảng $values để tránh warning undefined key
        $values = [
            'Email'   => '',
            'MatKhau' => '',
        ];
        $error = '';

        // Nếu form vừa được submit (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $values['Email']   = trim($_POST['Email'] ?? '');
            $values['MatKhau'] = trim($_POST['MatKhau'] ?? '');

            // 1) Kiểm tra các trường không được rỗng
            if (empty($values['Email']) || empty($values['MatKhau'])) {
                $error = "Vui lòng nhập đầy đủ email và mật khẩu.";
            } else {
                // 2) Tìm user theo email
                $user = $this->userModel->findByEmail($values['Email']);

                if (!$user) {
                    $error = "Email chưa được đăng ký.";
                } else {
                    // 3) Kiểm tra mật khẩu (password_verify)
                    if (password_verify($values['MatKhau'], $user['MatKhau'])) {
                        // 4) Nếu đúng, lưu session và redirect dashboard
                        session_regenerate_id(true);
                        $_SESSION['user'] = [
                            'MaNguoiDung' => $user['MaNguoiDung'],
                            'TenDangNhap' => $user['TenDangNhap'],
                            'Email'       => $user['Email'],
                            'VaiTro'      => $user['VaiTro'],
                        ];
                        header('Location: index.php?act=dashboard');
                        exit;
                    } else {
                        $error = "Mật khẩu không đúng.";
                    }
                }
            }
        }

        // Cuối cùng: include view đăng nhập
        require_once __DIR__ . '/../views/layouts/authtop.php';
        require_once __DIR__ . '/../views/auth/login.php';
        require_once __DIR__ . '/../views/layouts/authbottom.php';
    }

    /**
     * Đăng xuất (logout)
     */
    public function logout()
    {
        session_destroy();
        header('Location: index.php?act=auth-login');
        exit;
    }
}
