<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>

    <meta charset="utf-8" />
    <title>Dashboard | NN Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- 1) Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- 2) Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/admin/assets/css/custom.min.css" rel="stylesheet" />
    <!-- CSS -->

</head>

<body data-layout="vertical" data-sidebar="dark">






    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- HEADER -->
        <?php
        require_once "./views/layouts/header.php";
        require_once "./views/layouts/siderbar.php";
        require_once "./views/layouts/libs_css.php";
        require_once "./views/layouts/libs_js.php";
        ?>

        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <?php if (!empty($_SESSION['success_msg'])): ?>
                                <div class="alert alert-success alert-dismissible fade show shadow-sm rounded" role="alert">
                                    <i class="me-2 bi bi-check-circle-fill"></i>
                                    <?= htmlspecialchars($_SESSION['success_msg']) ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <?php unset($_SESSION['success_msg']); ?>
                            <?php endif; ?>

                            <?php if (!empty($_SESSION['error_msg'])): ?>
                                <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded" role="alert">
                                    <i class="me-2 bi bi-exclamation-triangle-fill"></i>
                                    <?= htmlspecialchars($_SESSION['error_msg']) ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <?php unset($_SESSION['error_msg']); ?>
                            <?php endif; ?>

                        </div>
                    </div>
                    <?php if (!empty($_SESSION['success_msg'])): ?>
                        <div class="row">
                            <div class="col-12">
                                <div
                                    class="alert alert-success alert-dismissible fade show shadow-sm rounded"
                                    role="alert">
                                    <i class="me-2 bi bi-check-circle-fill"></i>
                                    <?= htmlspecialchars($_SESSION['success_msg']) ?>
                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                        <?php unset($_SESSION['success_msg']); ?>
                    <?php endif; ?>
                </div>