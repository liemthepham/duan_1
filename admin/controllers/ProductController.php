<?php

class ProductController
{
    private $productModel;
    private $categoryModel;


    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $products = $this->productModel->get_list();

        require __DIR__ . '/../views/layouts/layouts_top.php';
        require __DIR__ . '/../views/Product/list.php';
        require __DIR__ . '/../views/layouts/layout_bottom.php';
    }

    public function add()
    {
        $categories = (new CategoryModel())->getAll();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            (new ProductModel())->create($_POST, $_FILES['AnhDaiDien']);
            $_SESSION['success_msg'] = '🎉 Thêm sản phẩm thành công!';
            header('Location: index.php?act=product-list');
            exit;
        }
        require __DIR__ . '/../views/layouts/layouts_top.php';
        require __DIR__ . '/../views/Product/add.php';
        require __DIR__ . '/../views/layouts/layout_bottom.php';
    }
    //update
    public function edit()
    {
        // 1. Lấy ID từ query string
        $id = $_GET['id'] ?? null;
        if (!$id) {
            die("ID sản phẩm không hợp lệ");
        }

        // 2. Lấy dữ liệu SP cũ
        $item = $this->productModel->find($id);
        if (!$item) {
            die("Sản phẩm #{$id} không tồn tại");
        }

        // 3. Lấy danh mục để fill vào select
        $categories = $this->categoryModel->getAll();

        // 4. Nếu POST lên thì xử lý update
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->productModel->update($id, $_POST, $_FILES['AnhDaiDien']);
            $_SESSION['success_msg'] = '✏️ Sửa sản phẩm thành công!';
            header('Location: index.php?act=product-list');
            exit;
        }

        // 5. Hiển thị form edit
        require __DIR__ . '/../views/layouts/layouts_top.php';
        require __DIR__ . '/../views/Product/edit.php';
        require __DIR__ . '/../views/layouts/layout_bottom.php';
    }
    //detail
    public function detail()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if (!$id) {
            header('Location: index.php');
            exit;
        }
        $prd = $this->productModel->find($id);
        if (!$prd) {
            echo "Sản phẩm không tồn tại";
            exit;
        }
        require_once __DIR__ . '/../views/layouts/layouts_top.php';
        require_once __DIR__ . '/../views/product/detail.php';
        require_once __DIR__ . '/../views/layouts/layout_bottom.php';
    }


    //delete

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            die("ID không hợp lệ");
        }
        $this->productModel->delete($id);
        $_SESSION['success_msg'] = '🗑️ Xóa sản phẩm thành công!';
        // Sau khi xóa, quay về danh sách
        header('Location: index.php?act=product-list');
        exit;
    }
}
