<?php
require_once __DIR__ . '/../models/CategoryModel.php';
require_once __DIR__ . '/../models/ProductModel.php';

class CategoryController
{
    private CategoryModel $categoryModel;
    private ProductModel  $productModel;
    private $model;
    public function __construct()
    {
        $this->model = new CategoryModel();
        $this->categoryModel = new CategoryModel();
        $this->productModel  = new ProductModel();
    }

    // Hiện form và xử lý POST
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->create($_POST);
            header('Location: index.php?act=category-list');
            exit;
        }
        // Lấy danh mục để chọn cha
        $parents = $this->model->getAll();
        require __DIR__ . '/../views/Product/danhmuc/add.php';
    }

    // Sửa
    public function edit()
    {
        $id = $_GET['id'] ?? null;
        $item = $this->model->find($id);
        if (!$item) {
            die("Danh mục #{$id} không tồn tại");
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->update($id, $_POST);
            header('Location: index.php?act=category-list');
            exit;
        }
        $parents = $this->model->getAll();
        require __DIR__ . '/../views/Product/danhmuc/edit.php';
    }
    //xóa
    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $_SESSION['error_msg'] = 'ID không hợp lệ.';
            header('Location: index.php?act=category-list');
            exit;
        }

        // Đếm số SP
        $count = $this->productModel->countByCategory((int)$id);
        if ($count > 0) {
            $_SESSION['error_msg'] = "Không thể xóa: còn $count sản phẩm.";
            header('Location: index.php?act=category-list');
            exit;
        }

        // Xóa nếu OK
        $this->categoryModel->delete((int)$id);
        $_SESSION['success_msg'] = 'Xóa thành công.';
        header('Location: index.php?act=category-list');
        exit;
    }



    // Danh sách
    public function index()
    {
        $list = $this->model->getAll();
        require __DIR__ . '/../views/Product/danhmuc/list.php';
    }
}
