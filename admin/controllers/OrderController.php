<?php
require_once __DIR__ . '/../models/OrderModel.php';

class OrderController {
  private $model;
  public function __construct() {
    $this->model = new OrderModel();
  }

  /**
   * Hiển thị danh sách đơn hàng
   */
  public function index() {
    // gọi model để lấy dữ liệu
    $orders = $this->model->getAll();

    // include layout trên (sidebar, header)
    require_once __DIR__ . '/../views/layouts/layouts_top.php';

    // include view chính
    require_once __DIR__ . '/../views/order/index.php';

    // include layout dưới (footer, script)
    require_once __DIR__ . '/../views/layouts/layout_bottom.php';
  }
}
