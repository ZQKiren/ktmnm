<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống Quản lý Sinh viên</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --light-color: #f8f9fc;
            --dark-color: #5a5c69;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fc;
        }
        
        .navbar {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 0.8rem 1rem;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color);
        }
        
        .nav-link {
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.3s;
        }
        
        .nav-link:hover {
            color: var(--primary-color);
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border-radius: 0.35rem;
        }
        
        .dropdown-item {
            padding: 0.5rem 1.5rem;
            font-weight: 400;
            transition: all 0.3s;
        }
        
        .dropdown-item:hover {
            background-color: var(--light-color);
            color: var(--primary-color);
        }
        
        .active-page {
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .user-profile {
            background-color: var(--light-color);
            border-radius: 50px;
            padding: 8px 15px;
            margin-right: 10px;
        }
        
        .badge-notification {
            position: relative;
            top: -10px;
            left: -8px;
            font-size: 0.6rem;
        }
        
        .content-wrapper {
            min-height: calc(100vh - 210px);
            padding: 25px 0;
        }
        
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            margin-bottom: 24px;
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid #e3e6f0;
            padding: 1rem 1.25rem;
            font-weight: 700;
            color: var(--dark-color);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-graduation-cap me-2"></i>
                QUẢN LÝ SINH VIÊN
            </a>
            
            <!-- Toggle button for mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- Sinh viên Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="sinhvienDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-graduate me-1"></i> Sinh viên
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="sinhvienDropdown">
                            <li><a class="dropdown-item" href="index.php?controller=sinhvien&action=list">
                                <i class="fas fa-list me-2"></i> Danh sách sinh viên
                            </a></li>
                            <li><a class="dropdown-item" href="index.php?controller=sinhvien&action=add">
                                <i class="fas fa-plus me-2"></i> Thêm sinh viên
                            </a></li>
                        </ul>
                    </li>
                    
                    <!-- Ngành học Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="nganhhocDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-graduation-cap me-1"></i> Ngành học
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="nganhhocDropdown">
                            <li><a class="dropdown-item" href="index.php?controller=nganhhoc&action=list">
                                <i class="fas fa-list me-2"></i> Danh sách ngành học
                            </a></li>
                            <li><a class="dropdown-item" href="index.php?controller=nganhhoc&action=add">
                                <i class="fas fa-plus me-2"></i> Thêm ngành học
                            </a></li>
                        </ul>
                    </li>
                    
                    <!-- Học phần Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="hocphanDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-book me-1"></i> Học phần
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="hocphanDropdown">
                            <li><a class="dropdown-item" href="index.php?controller=hocphan&action=list">
                                <i class="fas fa-list me-2"></i> Danh sách học phần
                            </a></li>
                            <li><a class="dropdown-item" href="index.php?controller=hocphan&action=add">
                                <i class="fas fa-plus me-2"></i> Thêm học phần
                            </a></li>
                        </ul>
                    </li>
                    
                    <!-- Đăng ký Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dangkyDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-clipboard-list me-1"></i> Đăng ký học phần
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dangkyDropdown">
                            <li><a class="dropdown-item" href="index.php?controller=dangky&action=cart">
                                <i class="fas fa-shopping-cart me-2"></i> Giỏ đăng ký
                            </a></li>
                            <li><a class="dropdown-item" href="index.php?controller=dangky&action=history">
                                <i class="fas fa-history me-2"></i> Lịch sử đăng ký
                            </a></li>
                        </ul>
                    </li>
                </ul>
                
                <!-- User Info & Cart -->
                <div class="d-flex align-items-center">
                    <?php if(isset($_SESSION['MaSV'])): ?>
                        <div class="user-profile d-flex align-items-center me-3">
                            <i class="fas fa-user-circle text-primary me-2"></i>
                            <span class="d-none d-md-inline">
                                <?= htmlspecialchars($_SESSION['HoTen']) ?> 
                                <small class="text-muted">(<?= htmlspecialchars($_SESSION['MaSV']) ?>)</small>
                            </span>
                        </div>
                        
                        <!-- Cart Icon with Badge -->
                        <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                            <a href="index.php?controller=dangky&action=cart" class="position-relative me-3">
                                <i class="fas fa-shopping-cart fs-5 text-primary"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger badge-notification">
                                    <?= count($_SESSION['cart']) ?>
                                </span>
                            </a>
                        <?php endif; ?>
                        
                        <!-- Logout Button -->
                        <a href="index.php?controller=dangky&action=logout" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-sign-out-alt me-1"></i> Đăng xuất
                        </a>
                    <?php else: ?>
                        <!-- Login Button -->
                        <a href="index.php?controller=dangky&action=login" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt me-1"></i> Đăng nhập
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <div class="container">
            <!-- Page Content -->
            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= $_SESSION['success']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <?php unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= $_SESSION['error']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>