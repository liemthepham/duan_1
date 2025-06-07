<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Thanh toán - TechStore</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .checkout-card {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.07);
      padding: 30px;
    }
    .form-control, .form-check-input {
      border-radius: 8px;
    }
    .section-title {
      border-left: 4px solid #198754;
      padding-left: 10px;
      font-weight: bold;
      margin-bottom: 20px;
    }
    .summary-img {
      border-radius: 10px;
      width: 60px;
      height: 60px;
      object-fit: cover;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    footer {
      background: #212529;
      color: #ccc;
    }
    footer h5 {
      color: #fff;
    }
  </style>
</head>
<body>

<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="index.php">TechStore</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Trang chủ</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php?act=cart">Giỏ hàng</a></li>
        <li class="nav-item"><a class="nav-link active" href="index.php?act=checkout">Thanh toán</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Checkout Section -->
<div class="container my-5">
  <div class="row g-4">
    <!-- Form Column -->
    <div class="col-lg-8">
      <div class="checkout-card">
        <h4 class="section-title">Thông tin giao hàng</h4>
        <form action="index.php?act=process-checkout" method="POST">
          <!-- Các input hidden sẽ giữ nguyên PHP như bạn có -->
          <?php
          $selected_for_checkout = $_SESSION['selected_for_checkout'] ?? [];
          foreach ($selected_for_checkout as $productId) {
              echo '<input type="hidden" name="selected_products[]" value="' . htmlspecialchars($productId) . '">';
          }
          unset($_SESSION['selected_for_checkout']);
          ?>

          <div class="mb-3">
            <label for="full_name" class="form-label">Họ và tên</label>
            <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo htmlspecialchars($_SESSION['user']['HoTen'] ?? ''); ?>" required>
          </div>
          <div class="mb-3">
            <label for="phone_number" class="form-label">Số điện thoại</label>
            <input type="tel" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($_SESSION['user']['SoDienThoai'] ?? ''); ?>" required>
          </div>
          <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ nhận hàng</label>
            <textarea class="form-control" id="address" name="address" rows="3" required><?php echo htmlspecialchars($_SESSION['user']['DiaChi'] ?? ''); ?></textarea>
          </div>
          <div class="mb-3">
            <label for="note" class="form-label">Ghi chú (tùy chọn)</label>
            <textarea class="form-control" id="note" name="note" rows="3"></textarea>
          </div>

          <h4 class="section-title">Phương thức thanh toán</h4>
          <div class="mb-3">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
              <label class="form-check-label" for="cod">Thanh toán khi nhận hàng (COD)</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer" disabled>
              <label class="form-check-label text-muted" for="bank_transfer">Chuyển khoản ngân hàng (Đang cập nhật)</label>
            </div>
          </div>

          <button type="submit" class="btn btn-success btn-lg w-100">Đặt hàng ngay</button>
        </form>
      </div>
    </div>

    <!-- Order Summary -->
    <div class="col-lg-4">
      <div class="checkout-card">
        <h4 class="section-title">Tóm tắt đơn hàng</h4>
        <ul class="list-group mb-3">
          <?php foreach ($cartItems as $item): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <div class="d-flex align-items-center">
                <?php if (!empty($item['product']['AnhDaiDien'])): ?>
                  <img src="admin/uploads/<?php echo htmlspecialchars($item['product']['AnhDaiDien']); ?>" class="summary-img me-3" alt="<?php echo htmlspecialchars($item['product']['TenSanPham']); ?>">
                <?php endif; ?>
                <div>
                  <div><?php echo htmlspecialchars($item['product']['TenSanPham']); ?></div>
                  <small class="text-muted">SL: <?php echo $item['quantity']; ?></small>
                </div>
              </div>
              <span class="fw-bold text-success"><?php echo number_format($item['subtotal'], 0, ',', '.'); ?>₫</span>
            </li>
          <?php endforeach; ?>
          <li class="list-group-item d-flex justify-content-between">
            <strong>Tổng cộng</strong>
            <strong class="text-primary"><?php echo number_format($total, 0, ',', '.'); ?>₫</strong>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="py-4 mt-5">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <h5>Về chúng tôi</h5>
        <p>TechStore - Địa chỉ mua sắm công nghệ uy tín</p>
      </div>
      <div class="col-md-4">
        <h5>Liên hệ</h5>
        <p>Email: contact@example.com</p>
        <p>Hotline: 0123 456 789</p>
      </div>
      <div class="col-md-4">
        <h5>Kết nối với chúng tôi</h5>
        <div class="d-flex gap-2">
          <a href="#" class="text-light"><i class="fab fa-facebook fa-lg"></i></a>
          <a href="#" class="text-light"><i class="fab fa-instagram fa-lg"></i></a>
          <a href="#" class="text-light"><i class="fab fa-twitter fa-lg"></i></a>
        </div>
      </div>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
