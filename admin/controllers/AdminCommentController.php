<?php

require_once 'models/CommentModel.php';

class AdminCommentController
{
    private $model;

    public function __construct()
    {
        $this->model = new CommentModel();
    }

    public function index()
    {
        $comments = $this->model->get_list();
        $q = trim($_GET['q'] ?? '');
        if ($q !== '') {
            $comments = $this->model->search($q);
        } else {
            $comments = $this->model->get_list();
        }
        require __DIR__ . '/../views/layouts/layouts_top.php';
        require 'views/binhluan/list.php';
        require __DIR__ . '/../views/layouts/layout_bottom.php';
    }

    public function delete()
    {
        if (isset($_GET['id'])) {
            $this->model->delete((int)$_GET['id']);
        }
        header('Location: index.php?act=admin-comment-list');
    }
}
