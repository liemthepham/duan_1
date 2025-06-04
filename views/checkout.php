<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán - TechStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="admin/assets/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="public/css/cusstom.css"> -->
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">TechStore</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?act=cart">Giỏ hàng</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link active" href="index.php?act=checkout">Thanh toán</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Checkout Content -->
    <div class="container my-5">
        <h2 class="mb-4">Thông tin thanh toán</h2>

        <?php if (isset($_SESSION['error_msg'])): ?>
            <div class="alert alert-danger">
                <?php 
                echo $_SESSION['error_msg'];
                unset($_SESSION['error_msg']);
                ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-8">
                <h4>Thông tin giao hàng</h4>
                <form action="index.php?act=process-checkout" method="POST">
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control" id="phone_number" name="phone_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ nhận hàng</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                    </div>
                     <div class="mb-3">
                        <label for="note" class="form-label">Ghi chú (tùy chọn)</label>
                        <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                    </div>

                     <h4>Phương thức thanh toán</h4>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                            <label class="form-check-label" for="cod">
                                Thanh toán khi nhận hàng (COD)
                            </label>
                        </div>
                         <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer" disabled>
                            <label class="form-check-label" for="bank_transfer">
                                Chuyển khoản ngân hàng (Đang cập nhật)
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg">Đặt hàng</button>
                </form>
            </div>

            <div class="col-md-4">
                <h4>Tóm tắt đơn hàng</h4>
                <ul class="list-group mb-3">
                    <?php foreach ($cartItems as $item): ?>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0"><?php echo htmlspecialchars($item['product']['TenSanPham']); ?></h6>
                                <small class="text-muted">SL: <?php echo $item['quantity']; ?></small>
                            </div>
                            <span class="text-muted"><?php echo number_format($item['subtotal'], 0, ',', '.'); ?> VNĐ</span>
                        </li>
                    <?php endforeach; ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Tổng cộng (VNĐ)</span>
                        <strong><?php echo number_format($total, 0, ',', '.'); ?> VNĐ</strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Về chúng tôi</h5>
                    <p>Cửa hàng điện tử uy tín, chất lượng</p>
                </div>
                <div class="col-md-4">
                    <h5>Liên hệ</h5>
                    <p>Email: contact@example.com</p>
                    <p>Điện thoại: 0123 456 789</p>
                </div>
                <div class="col-md-4">
                    <h5>Theo dõi chúng tôi</h5>
                    <div class="d-flex">
                        <a href="#" class="text-light me-2"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-light me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 