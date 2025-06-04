<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index.php?act=dashboard" class="logo logo-dark">
            <span class="logo-sm">
                <img src="assets/images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="assets/images/logo-dark.png" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index.php?act=dashboard" class="logo logo-light">
            <span class="logo-sm">
                <img src="assets/images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="assets/images/logo-light.png" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div class="dropdown sidebar-user m-1 rounded">
        <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="d-flex align-items-center gap-2">
                <img class="rounded header-profile-user" src="assets/images/users/avatar-1.jpg" alt="Header Avatar">
                <span class="text-start">
                    <span class="d-block fw-medium sidebar-user-name-text">Anna Adame</span>
                    <span class="d-block fs-14 sidebar-user-name-sub-text"><i class="ri ri-circle-fill fs-10 text-success align-baseline"></i> <span class="align-middle">Online</span></span>
                </span>
            </span>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
            <!-- item-->
            <h6 class="dropdown-header">Welcome Anna!</h6>
            <a class="dropdown-item" href="pages-profile.html"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
            <a class="dropdown-item" href="auth-logout-basic.html"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
        </div>
    </div>
    <div id="scrollbar">
        <div class="container-fluid">


            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">QUẢN LÝ</span></li>

                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link" href="index.php?act=dashboard">
                        <i class="ri-dashboard-2-line"></i> <span>Dashboards</span>
                    </a>
                </li>

                <!-- Danh Sách Sản Phẩm -->
                <li class="nav-item">
                    <a class="nav-link" href="index.php?act=product-list">
                        <i class="ri-shopping-bag-line"></i> <span>Danh Sách Sản Phẩm</span>
                    </a>
                </li>

                <!-- Danh Sách Danh Mục -->
                <li class="nav-item">
                    <a class="nav-link" href="index.php?act=category-list">
                        <i class="ri-list-check"></i> <span>Danh Sách Danh Mục</span>
                    </a>
                </li>

                <!-- Quản Lý User -->
                <li class="nav-item">
                    <a class="nav-link" href="index.php?act=user-list">
                        <i class="ri-user-line"></i> <span>Quản Lý User</span>
                    </a>
                </li>

                <li class="menu-title"><i class="ri-more-fill"></i> <span>BÁN HÀNG</span></li>
                 <li class="nav-item">
                     <a class="nav-link" href="index.php?act=order-list">
                        <i class="ri-shopping-bag-line"></i><span>Đơn hàng</span> 
                    </a>
                </li>
        

 
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>