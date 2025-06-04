<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['TenSanPham']); ?> - TechStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                </ul>
            </div>
        </div>
    </nav>

    <!-- Product Detail -->
    <div class="container my-5">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php 
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <!-- Product Image -->
            <div class="col-md-6">
                <img src="admin/uploads/<?php echo htmlspecialchars($product['AnhDaiDien']); ?>" 
                     alt="<?php echo htmlspecialchars($product['TenSanPham']); ?>"
                     class="img-fluid rounded">
            </div>

            <!-- Product Info -->
            <div class="col-md-6">
                <h1 class="mb-3"><?php echo htmlspecialchars($product['TenSanPham']); ?></h1>
                <p class="text-muted mb-3">Danh mục: <?php echo htmlspecialchars($product['TenDanhMuc']); ?></p>
                
                <div class="mb-4">
                    <h3 class="text-danger"><?php echo number_format($product['Gia'], 0, ',', '.'); ?> VNĐ</h3>
                </div>

                <div class="mb-4">
                    <h5>Mô tả sản phẩm:</h5>
                    <p><?php echo nl2br(htmlspecialchars($product['MoTa'])); ?></p>
                </div>

                <form action="index.php?act=add-to-cart" method="POST" class="mb-4">
                    <input type="hidden" name="product_id" value="<?php echo $product['MaSanPham']; ?>">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <label for="quantity" class="form-label">Số lượng:</label>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" 
                                   class="form-control" style="width: 100px;">
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng
                            </button>
                        </div>
                    </div>
                </form>

                <div class="mb-4">
                    <h5>Trạng thái:</h5>
                    <span class="badge bg-<?php echo $product['TrangThai'] == 1 ? 'success' : 'danger'; ?>">
                        <?php echo $product['TrangThai'] == 1 ? 'Còn hàng' : 'Hết hàng'; ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <div class="mt-5">
            <h3 class="section-title text-center">Sản phẩm liên quan</h3>
            <div class="row">
                <?php foreach ($relatedProducts as $related): ?>
                    <div class="col-md-3">
                        <div class="card h-100">
                            <img src="admin/uploads/<?php echo htmlspecialchars($related['AnhDaiDien']); ?>" 
                                 class="card-img-top" alt="<?php echo htmlspecialchars($related['TenSanPham']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($related['TenSanPham']); ?></h5>
                                <p class="card-text text-danger">
                                    <?php echo number_format($related['Gia'], 0, ',', '.'); ?> VNĐ
                                </p>
                                <a href="index.php?act=product-detail&id=<?php echo $related['MaSanPham']; ?>" 
                                   class="btn btn-primary">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Specifications (Thông số kỹ thuật) -->
        <div class="mt-5">
            <h3 class="mb-4">Thông số kỹ thuật</h3>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th scope="row" style="width: 30%;">Màn hình</th>
                        <td>[Thông tin màn hình từ DB]</td>
                    </tr>
                    <tr>
                        <th scope="row">Bộ xử lý</th>
                        <td>[Thông tin bộ xử lý từ DB]</td>
                    </tr>
                    <tr>
                        <th scope="row">RAM</th>
                        <td>[Thông tin RAM từ DB]</td>
                    </tr>
                     <tr>
                        <th scope="row">Bộ nhớ trong</th>
                        <td>[Thông tin bộ nhớ trong từ DB]</td>
                    </tr>
                     <tr>
                        <th scope="row">Camera sau</th>
                        <td>[Thông tin camera sau từ DB]</td>
                    </tr>
                     <tr>
                        <th scope="row">Camera trước</th>
                        <td>[Thông tin camera trước từ DB]</td>
                    </tr>
                     <tr>
                        <th scope="row">Pin</th>
                        <td>[Thông tin pin từ DB]</td>
                    </tr>
                    <tr>
                        <th scope="row">Hệ điều hành</th>
                        <td>[Thông tin hệ điều hành từ DB]</td>
                    </tr>
                    <tr>
                        <th scope="row">Kết nối</th>
                        <td>[Thông tin kết nối từ DB]</td>
                    </tr>
                    <tr>
                        <th scope="row">Kích thước</th>
                        <td>[Thông tin kích thước từ DB]</td>
                    </tr>
                     <tr>
                        <th scope="row">Trọng lượng</th>
                        <td>[Thông tin trọng lượng từ DB]</td>
                    </tr>
                    
                    <!-- Thêm các thông số khác nếu có -->

                </tbody>
            </table>
             <p class="text-muted">*Lưu ý: Thông số chi tiết có thể thay đổi tùy phiên bản. Vui lòng liên hệ để có thông tin chính xác nhất.</p>
        </div>

        <!-- Comments -->
        <div class="mt-5">
            <h3 class="mb-4">Bình luận</h3>
            
            <!-- Comment Form -->
            <form action="index.php?act=add-comment" method="POST" class="mb-4">
                <input type="hidden" name="product_id" value="<?php echo $product['MaSanPham']; ?>">
                <div class="mb-3">
                    <textarea name="content" class="form-control" rows="3" 
                              placeholder="Viết bình luận của bạn..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Gửi bình luận</button>
            </form>

            <!-- Comments List -->
            <div class="comments">
                <?php if (empty($comments)): ?>
                    <p class="text-muted">Chưa có bình luận nào cho sản phẩm này.</p>
                <?php else: ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="card-subtitle text-muted">
                                        <?php echo htmlspecialchars($comment['TenNguoiDung']); ?>
                                    </h6>
                                    <small class="text-muted">
                                        <?php echo date('d/m/Y H:i', strtotime($comment['NgayBinhLuan'])); ?>
                                    </small>
                                </div>
                                <p class="card-text"><?php echo nl2br(htmlspecialchars($comment['NoiDung'])); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
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