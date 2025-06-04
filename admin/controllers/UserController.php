<?php
require_once __DIR__ . '/../models/UserModel.php';

class UserController
{
    private $userModel;
    private string    $viewRoot;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->viewRoot  = dirname(__DIR__) . '/views';
    }

    /** Danh sách User */
    public function index()
    {
        $q = trim($_GET['q'] ?? '');

        // 2. Nếu có q, gọi search(), còn không gọi get_list()
        if ($q !== '') {
            $users = $this->userModel->search($q);
        } else {
            $users = $this->userModel->get_list();
        }

        require __DIR__ . '/../views/layouts/layouts_top.php';
        require_once $this->viewRoot . '/user/list.php';
        require __DIR__ . '/../views/layouts/layout_bottom.php';
    }

    /** Thêm User */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->userModel->create($_POST);
            header('Location: index.php?act=user-list');
            exit;
        }
        require __DIR__ . '/../views/layouts/layouts_top.php';
        require __DIR__ . '/../views/User/add.php';
        require __DIR__ . '/../views/layouts/layout_bottom.php';
    }

    /** Sửa User */
    public function edit()
    {
        $id = $_GET['id'] ?? null;
        $item = $this->userModel->find($id);
        if (!$item) {
            die("User #{$id} không tồn tại");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->userModel->update($id, $_POST);
            header('Location: index.php?act=user-list');
            exit;
        }

        require __DIR__ . '/../views/layouts/layouts_top.php';
        require __DIR__ . '/../views/User/edit.php';
        require __DIR__ . '/../views/layouts/layout_bottom.php';
    }

    /** Xóa User */
    public function delete()
    {
        $id = $_GET['id'] ?? null;
        $this->userModel->delete($id);
        header('Location: index.php?act=user-list');
        exit;
    }
}
