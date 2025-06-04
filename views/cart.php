<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng - TechStore</title>
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
                        <a class="nav-link active" href="index.php?act=cart">Giỏ hàng</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Cart Content -->
    <div class="container my-5">
        <h2 class="mb-4">Giỏ hàng của bạn</h2>
        
        <?php if (empty($cartItems)): ?>
            <div class="alert alert-info">
                Giỏ hàng của bạn đang trống. <a href="index.php">Tiếp tục mua sắm</a>
            </div>
        <?php else: ?>
            <form action="index.php?act=update-cart" method="POST">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Tổng</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartItems as $item): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="admin/uploads/<?php echo htmlspecialchars($item['product']['AnhDaiDien']); ?>" 
                                                 alt="<?php echo htmlspecialchars($item['product']['TenSanPham']); ?>"
                                                 class="img-thumbnail" style="width: 100px; margin-right: 15px;">
                                            <div>
                                                <h5 class="mb-0"><?php echo htmlspecialchars($item['product']['TenSanPham']); ?></h5>
                                                <small class="text-muted"><?php echo htmlspecialchars($item['product']['MoTa']); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo number_format($item['product']['Gia'], 0, ',', '.'); ?> VNĐ</td>
                                    <td>
                                        <input type="number" name="quantity[<?php echo $item['product']['MaSanPham']; ?>]" 
                                               value="<?php echo $item['quantity']; ?>" 
                                               min="1" class="form-control" style="width: 80px;">
                                    </td>
                                    <td><?php echo number_format($item['subtotal'], 0, ',', '.'); ?> VNĐ</td>
                                    <td>
                                        <a href="index.php?act=remove-from-cart&id=<?php echo $item['product']['MaSanPham']; ?>" 
                                           class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                                <td><strong><?php echo number_format($total, 0, ',', '.'); ?> VNĐ</strong></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Tiếp tục mua sắm
                    </a>
                    <div>
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-sync"></i> Cập nhật giỏ hàng
                        </button>
                        <a href="index.php?act=checkout" class="btn btn-success">
                            <i class="fas fa-shopping-cart"></i> Thanh toán
                        </a>
                    </div>
                </div>
            </form>
        <?php endif; ?>
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