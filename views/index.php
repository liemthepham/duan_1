<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cửa hàng điện tử</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/cusstom.css">
</head>

<body class="d-flex flex-column min-vh-100">


    <?php
    $user = $_SESSION['user'] ?? null;
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php?act=home">
                <i class="fas fa-mobile-alt"></i> TechStore
            </a>
            <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- menu chính -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php?act=home">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?act=products">Sản phẩm</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?act=contact">Liên hệ</a></li>
                </ul>

                <!-- phần bên phải -->
                <ul class="navbar-nav ms-auto align-items-center">
                    <!-- icon giỏ -->
                    <li class="nav-item me-3 position-relative">
                        <a class="btn btn-outline-light" href="index.php?act=cart">
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                        <?php if (!empty($_SESSION['cart'])): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?= count($_SESSION['cart']) ?>
                            </span>
                        <?php endif; ?>
                    </li>
                    <!-- nếu chưa login -->
                    <?php if (!$user): ?>
                        <li class="nav-item d-flex">
                            <a href="index.php?act=login"
                                class="btn btn-outline-light me-2 px-3 py-1">
                                Đăng nhập
                            </a>
                            <a href="index.php?act=register"
                                class="btn btn-primary px-3 py-1">
                                Đăng ký
                            </a>
                        </li>

                        <!-- nếu đã login -->
                    <?php else: ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center"
                                href="#" id="userMenu" data-bs-toggle="dropdown">
                                <?php if (!empty($_SESSION['user']['email'])): ?>
                                    <?= htmlspecialchars($_SESSION['user']['email']) ?>
                                <?php endif; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                                <?php if (($user['VaiTro'] ?? '') === 'admin'): ?>
                                    <li>
                                        <a class="dropdown-item" href="/duan1_nhom3/admin/index.php?act=dashboard">Dashboard Admin</a>

                                    </li>

                                    <hr class="dropdown-divider">
                        </li>
                    <?php endif; ?>
                    <li><a class="dropdown-item" href="index.php?act=logout">Đăng xuất</a></li>
                </ul>
                </li>
            <?php endif; ?>
            </ul>
            </div>
        </div>
    </nav>




    <!-- BANNER – BOOTSTRAP CAROUSEL -->
    <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3500">
        <!-- 1) Indicators (đốm nhỏ) -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
            <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="2"></button>
        </div>

        <!-- 2) Wrapper cho các slide -->
        <div class="carousel-inner">

            <!-- Slide 1 -->
            <div class="carousel-item active">
                <img src="public/images/banner1.png" class="d-block w-100 banner-img" alt="Hotsale Mùa Hè 1">
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="display-4">Hotsale Mùa Hè</h1>
                    <p class="lead">Ưu đãi lớn, quà tặng hấp dẫn</p>
                    <a href="index.php?act=product-list" class="btn btn-primary btn-lg">Khám phá</a>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item">
                <img src="public/images/banner2'.jpg" class="d-block w-100 banner-img" alt="Hotsale Mùa Hè 2">
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="display-4">Flash Sale Đỉnh Cao</h1>
                    <p class="lead">Giảm sâu lên tới 50%</p>
                    <a href="index.php?act=product-list" class="btn btn-primary btn-lg">Mua ngay</a>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item">
                <img src="public/images/banner3.jpg" class="d-block w-100 banner-img" alt="Hotsale Mùa Hè 3">
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="display-4">Combo Siêu Tiết Kiệm</h1>
                    <p class="lead">Mua 2 tặng 1 – Chỉ hôm nay</p>
                    <a href="index.php?act=product-list" class="btn btn-primary btn-lg">Xem chi tiết</a>
                </div>
            </div>

        </div>

        <!-- 3) Prev / Next controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
            <span class="visually-hidden">Trước</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
            <span class="visually-hidden">Sau</span>
        </button>
    </div>


    <!-- DANH MỤC -->
    <div class="container py-5">
        <h2 class="section-title text-center">Danh Mục Sản Phẩm</h2>
        <div class="row g-4">
            <?php foreach ($categories as $cat): ?>
                <div class="col-md-3">
                    <div class="category-item text-center">
                        <a href="index.php?act=home&category_id=<?php echo $cat['MaDanhMuc']; ?>"
                            class="text-decoration-none text-dark">
                            <?php
                            $icon = 'mobile-alt';
                            switch (strtolower($cat['TenDanhMuc'])) {
                                case 'ốp lưng':
                                    $icon = 'mobile-screen-button';
                                    break;
                                case 'điện thoại':
                                    $icon = 'mobile';
                                    break;
                                case 'laptop':
                                    $icon = 'laptop';
                                    break;
                                case 'phụ kiện':
                                    $icon = 'headphones';
                                    break;
                            }
                            ?>
                            <div class="category-icon mb-3">
                                <i class="fas fa-<?php echo $icon; ?> fa-2x"></i>
                            </div>
                            <h5><?php echo htmlspecialchars($cat['TenDanhMuc']); ?></h5>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- FORM LỌC SẢN PHẨM -->
    <div class="container py-4">
        <div class="card filter-card">
            <div class="card-body">
                <form action="index.php" method="GET" class="row g-3 align-items-end">
                    <input type="hidden" name="act" value="products">

                    <div class="col-md-4">
                        <label for="keyword" class="form-label">Tìm kiếm</label>
                        <input type="text" class="form-control" id="keyword" name="keyword"
                            placeholder="Nhập tên sản phẩm..."
                            value="<?php echo htmlspecialchars($_GET['keyword'] ?? ''); ?>">
                    </div>

                    <div class="col-md-3">
                        <label for="price_min" class="form-label">Giá từ</label>
                        <input type="number" class="form-control" id="price_min" name="price_min"
                            placeholder="VNĐ" min="0"
                            value="<?php echo htmlspecialchars($_GET['price_min'] ?? ''); ?>">
                    </div>

                    <div class="col-md-3">
                        <label for="price_max" class="form-label">Đến</label>
                        <input type="number" class="form-control" id="price_max" name="price_max"
                            placeholder="VNĐ" min="0"
                            value="<?php echo htmlspecialchars($_GET['price_max'] ?? ''); ?>">
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Lọc
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- DANH SÁCH SẢN PHẨM -->
    <div class="container py-5">
        <h2 class="section-title text-center">
            <?php if ($selected_category_name): ?>
                Sản Phẩm <?php echo htmlspecialchars($selected_category_name); ?>
            <?php else: ?>
                Sản Phẩm Bán Chạy Nhất
            <?php endif; ?>
        </h2>

        <?php if ($category_id): ?>
            <div class="text-center mb-4">
                <a href="index.php?act=home" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Xem tất cả sản phẩm
                </a>
            </div>
        <?php endif; ?>

        <?php if (empty($products)): ?>
            <div class="alert alert-info">
                Không có sản phẩm nào trong danh mục này.
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($products as $product): ?>
                    <div class="col-md-3">
                        <div class="card h-100 product-card">
                            <div class="product-image">
                                <img src="admin/uploads/<?php echo htmlspecialchars($product['AnhDaiDien']); ?>"
                                    class="card-img-top"
                                    alt="<?php echo htmlspecialchars($product['TenSanPham']); ?>">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="product-title"><?php echo htmlspecialchars($product['TenSanPham']); ?></h5>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <p class="product-price text-danger fw-bold mb-0">
                                        <?php echo number_format($product['Gia']); ?> VNĐ
                                    </p>
                                    <?php if (!$category_id): ?>
                                        <span class="badge bg-success">
                                            <i class="fas fa-fire"></i> Bán chạy
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="mt-auto d-flex gap-2">
                                    <a href="index.php?act=product-detail&id=<?php echo $product['MaSanPham']; ?>"
                                        class="btn btn-outline-primary flex-grow-1">
                                        <i class="fas fa-info-circle"></i> Chi tiết
                                    </a>
                                    <form action="index.php?act=add-to-cart" method="POST" class="flex-grow-1">
                                        <input type="hidden" name="product_id"
                                            value="<?php echo $product['MaSanPham']; ?>">
                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php if ($current_page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="index.php?act=home&page=<?php echo $current_page - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                    <a class="page-link" href="index.php?act=home&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($current_page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="index.php?act=home&page=<?php echo $current_page + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

    <!-- SẢN PHẨM GỢI Ý -->
    <div class="container mb-5">
        <h2 class="section-title text-center">Sản Phẩm Gợi Ý Cho Bạn</h2>
        <div class="row g-4">
            <?php foreach ($suggestedProducts as $product): ?>
                <div class="col-md-3">
                    <div class="card h-100 product-card">
                        <div class="product-image">
                            <img src="admin/uploads/<?php echo htmlspecialchars($product['AnhDaiDien']); ?>"
                                class="card-img-top"
                                alt="<?php echo htmlspecialchars($product['TenSanPham']); ?>">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="product-title"><?php echo htmlspecialchars($product['TenSanPham']); ?></h5>
                            <p class="product-price text-danger fw-bold mb-3">
                                <?php echo number_format($product['Gia']); ?> VNĐ
                            </p>
                            <div class="mt-auto d-flex gap-2">
                                <a href="index.php?act=product-detail&id=<?php echo $product['MaSanPham']; ?>"
                                    class="btn btn-outline-primary flex-grow-1">
                                    <i class="fas fa-info-circle"></i> Chi tiết
                                </a>
                                <form action="index.php?act=add-to-cart" method="POST" class="flex-grow-1">
                                    <input type="hidden" name="product_id"
                                        value="<?php echo $product['MaSanPham']; ?>">
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="pt-5 pb-3">
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
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('scroll', () => {
            document.querySelector('.navbar')
                .classList.toggle('scrolled', window.scrollY > 50);
        });
    </script>
</body>

</html>