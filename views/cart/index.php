<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng - TechStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Logo styles */
        .brand-logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
        }
        .brand-logo i {
            font-size: 2rem;
            margin-right: 10px;
            color: #007bff;
        }
        .brand-logo span {
            background: linear-gradient(45deg, #007bff, #00ff88);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        .brand-logo:hover {
            color: white;
            text-decoration: none;
        }

        /* Cart styles */
        .cart-item {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            transition: all 0.3s;
        }
        .cart-item:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .cart-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }
        .quantity-input {
            width: 60px;
            text-align: center;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 5px;
        }
        .btn-quantity {
            width: 30px;
            height: 30px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
        }
        .cart-summary {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .btn-checkout {
            background: linear-gradient(45deg, #007bff, #0056b3);
            border: none;
            padding: 12px;
            border-radius: 8px;
            width: 100%;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-checkout:hover {
            background: linear-gradient(45deg, #0056b3, #004494);
            transform: translateY(-2px);
        }
        .empty-cart {
            text-align: center;
            padding: 50px 0;
        }
        .empty-cart i {
            font-size: 4rem;
            color: #dee2e6;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand brand-logo" href="index.php">
                <i class="fas fa-mobile-alt"></i>
                <span>TechStore</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Khuyến mãi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Liên hệ</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="cart.php" class="btn btn-outline-light me-2">
                        <i class="fas fa-shopping-cart"></i> Giỏ hàng
                    </a>
                    <button type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#authModal">
                        <i class="fas fa-user"></i> Đăng nhập
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Cart Content -->
    <div class="container py-5">
        <h2 class="mb-4">Giỏ hàng của bạn</h2>
        
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <?php if (empty($cart)): ?>
                <!-- Empty Cart -->
                <div class="empty-cart">
                    <i class="fas fa-shopping-cart"></i>
                    <h3>Giỏ hàng trống</h3>
                    <p>Hãy thêm sản phẩm vào giỏ hàng của bạn</p>
                    <a href="index.php" class="btn btn-primary">Tiếp tục mua sắm</a>
                </div>
                <?php else: ?>
                <!-- Cart Items List -->
                <div class="cart-items">
                    <?php foreach ($cart as $item): ?>
                    <div class="cart-item">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <img src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>" class="img-fluid">
                            </div>
                            <div class="col-md-4">
                                <h5 class="mb-1"><?= $item['name'] ?></h5>
                            </div>
                            <div class="col-md-2">
                                <p class="text-danger fw-bold mb-0"><?= number_format($item['price']) ?>đ</p>
                            </div>
                            <div class="col-md-2">
                                <form action="cart.php?act=update" method="POST" class="d-flex align-items-center">
                                    <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                    <button type="button" class="btn btn-quantity btn-outline-secondary me-2">-</button>
                                    <input type="number" name="quantity" class="quantity-input" value="<?= $item['quantity'] ?>" min="1">
                                    <button type="button" class="btn btn-quantity btn-outline-secondary ms-2">+</button>
                                </form>
                            </div>
                            <div class="col-md-2 text-end">
                                <form action="cart.php?act=remove" method="POST" class="d-inline">
                                    <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                    <button type="submit" class="btn btn-link text-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Cart Summary -->
            <div class="col-lg-4">
                <div class="cart-summary">
                    <h4 class="mb-4">Tổng đơn hàng</h4>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm tính:</span>
                        <span><?= number_format($total) ?>đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Phí vận chuyển:</span>
                        <span>Miễn phí</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold">Tổng cộng:</span>
                        <span class="text-danger fw-bold"><?= number_format($total) ?>đ</span>
                    </div>
                    <button class="btn btn-checkout">
                        Tiến hành thanh toán
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Về chúng tôi</h5>
                    <p>Shop điện thoại uy tín, chất lượng hàng đầu Việt Nam</p>
                </div>
                <div class="col-md-4">
                    <h5>Liên hệ</h5>
                    <p>Email: contact@shopdienthoai.com</p>
                    <p>Hotline: 1900 1234</p>
                </div>
                <div class="col-md-4">
                    <h5>Theo dõi chúng tôi</h5>
                    <div class="social-links">
                        <a href="#" class="text-white me-2"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Xử lý tăng/giảm số lượng
        document.querySelectorAll('.btn-quantity').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentElement.querySelector('.quantity-input');
                const currentValue = parseInt(input.value);
                
                if (this.textContent === '+') {
                    input.value = currentValue + 1;
                } else if (currentValue > 1) {
                    input.value = currentValue - 1;
                }
                
                // Submit form khi thay đổi số lượng
                this.closest('form').submit();
            });
        });
    </script>
</body>
</html> 