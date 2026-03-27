<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'JP SPORT - Cầu lông Chính hãng'; ?></title>
    <meta name="description" content="Shop cầu lông chính hãng Yonex, Victor, Lining - Vợt cầu lông, giày cầu lông, phụ kiện cầu lông">
    <link rel="shortcut icon" href="assets\images\favicon\JPfavicon.png" type="image/x-icon">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets\css\style.css">
    <link rel="stylesheet" href="assets\css\products.css">
</head>
<body>

<!-- Header -->
<header class="main-header">
    <!-- Header Top -->
    <div class="header-top">
        <div class="container">
            <div class="row align-items-center">
                <!-- Logo -->
                <div class="col-lg-2 col-md-3 col-6">
                    <a href="/websitebatminton/" class="jp-logo">
                        <img src="assets\images\logo\JPTachnen.png" alt="JP SPORT Logo" class="logo-jptachnenpng img-fluid w-75">
                    </a>
                </div>
                
                <!-- Search Bar -->
                <div class="col-lg-5 col-md-5">
                    <form action="/websitebatminton/products" method="GET" class="search-box">
                        <input type="text" name="search" placeholder="Tìm kiếm sản phẩm...">
                        <button type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>
                
                <!-- Right Side -->
                <div class="col-lg-5 col-md-4 col-6">
                    <div class="header-actions d-flex align-items-center justify-content-end h-100">
                        <!-- Hotline -->
                        <div class="hotline d-none d-lg-flex align-items-center me-4">
                            <i class="bi bi-telephone me-2 text-primary fs-5"></i>
                            <span class="text-uppercase fw-bold me-1 text-dark">Hotline:</span>
                            <div class="hotline-numbers fw-bold custom-blue-text">
                            <span class="fw-bold">0342826430 | 0961624535</span>
                            </div>
                        </div>
                        
                        <!-- Action Icons -->
                        <div class="action-icons d-flex gap-3">
                            <a href="/websitebatminton/products" class="action-item d-flex flex-column align-items-center text-decoration-none" title="Tra cứu">
                                <div class="action-icon rounded-circle border p-2 d-flex align-items-center justify-content-center mb-1">
                                    <i class="bi bi-search"></i>
                                </div>
                                <small class="action-label fw-medium text-muted small-text text-nowrap">Tra cứu</small>
                            </a>

                            <a href="/websitebatminton/login" class="action-item d-flex flex-column align-items-center text-decoration-none" title="Tài khoản">
                                <div class="action-icon rounded-circle border p-2 d-flex align-items-center justify-content-center mb-1">
                                    <i class="bi bi-person"></i>
                                </div>
                                <small class="action-label fw-medium text-muted small-text text-nowrap">Tài khoản</small>
                            </a>
                            <a href="/websitebatminton/cart" class="action-item d-flex flex-column align-items-center text-decoration-none position-relative" title="Giỏ hàng">
                                <div class="action-icon rounded-circle border p-2 d-flex align-items-center justify-content-center mb-1">
                                    <i class="bi bi-cart3"></i>
                                </div>
                                <small class="action-label fw-medium text-muted small-text text-nowrap">Giỏ hàng</small>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">0</span>
                            <?php $session = new \Session(); ?>
                            <?php if ($session->isLoggedIn()): ?>
                                <div class="dropdown d-inline-block">
                                    <a href="#" class="action-icon text-dark" data-bs-toggle="dropdown" aria-expanded="false" title="Tài khoản">
                                        <i class="bi bi-person-circle"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="/websitebatminton/profile">Thông tin cá nhân</a></li>
                                        <li><a class="dropdown-item" href="/websitebatminton/logout">Đăng xuất</a></li>
                                    </ul>
                                </div>
                            <?php else: ?>
                                <div class="dropdown d-inline-block">
                                    <a href="#" class="action-icon text-dark" data-bs-toggle="dropdown" aria-expanded="false" title="Tài khoản">
                                        <i class="bi bi-person-circle"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="/websitebatminton/login">Đăng nhập</a></li>
                                        <li><a class="dropdown-item" href="/websitebatminton/register">Đăng ký</a></li>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <a href="/websitebatminton/cart" class="action-icon" title="Giỏ hàng">
                                <i class="bi bi-cart3"></i>
                                <span class="cart-count"><?= cartItemCount() ?></span>

                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Mobile Search -->
    <div class="mobile-search d-md-none px-3 pb-3">
        <form action="/websitebatminton/products" method="GET" class="search-box">
            <input type="text" name="search" placeholder="Tìm kiếm sản phẩm...">
            <button type="submit">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div>
    
    <!-- Main Navigation -->
    <nav class="main-nav navbar navbar-expand-lg">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-list text-white"></i>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/websitebatminton/">Trang chủ</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="/websitebatminton/products" id="productsDropdown" role="button" data-bs-toggle="dropdown">
                            Sản phẩm
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/websitebatminton/products?category=1">Vợt cầu lông</a></li>
                            <li><a class="dropdown-item" href="/websitebatminton/products?category=2">Giày cầu lông</a></li>
                            <li><a class="dropdown-item" href="/websitebatminton/products?category=3">Phụ kiện</a></li>
                            <li><a class="dropdown-item" href="/websitebatminton/products?category=4">Quần áo</a></li>
                            <li><a class="dropdown-item" href="/websitebatminton/products?category=5">Balo cầu lông</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/websitebatminton/news">Tin tức</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/websitebatminton/guide">Hướng dẫn</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/websitebatminton/about">Giới thiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/websitebatminton/contact">Liên hệ</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

