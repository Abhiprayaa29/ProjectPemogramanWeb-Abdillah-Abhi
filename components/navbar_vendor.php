<?php 
// Default variabel halaman aktif
if(!isset($currentPage)) { $currentPage = ''; } 
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary fs-4" href="index.php">
            <i class="bi bi-camera-fill me-2"></i>JogjaLensa
        </a>
        
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center fw-medium">
                
                <?php if(!isset($_SESSION['is_login']) || (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'client')): ?>
                    
                    <li class="nav-item">
                        <a class="nav-link px-3 <?php echo ($currentPage == 'home') ? 'active text-primary fw-bold' : ''; ?>" href="index.php">Cari Fotografer</a>
                    </li>

                <?php endif; ?>


                <?php if(isset($_SESSION['is_login']) && $_SESSION['user_role'] == 'vendor'): ?>
                    
                    <li class="nav-item">
                        <a class="nav-link px-3 <?php echo ($currentPage == 'dashboard') ? 'active text-primary fw-bold' : ''; ?>" href="dashboard_vendor.php">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard Mitra
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 <?php echo ($currentPage == 'packages') ? 'active text-primary fw-bold' : ''; ?>" href="vendor_packages.php">
                            <i class="bi bi-box-seam me-1"></i> Paket Saya
                        </a>
                    </li>

                <?php endif; ?>


                <?php if(isset($_SESSION['is_login']) && $_SESSION['is_login'] === true): ?>
                    <li class="nav-item dropdown ms-lg-3">
                        <a class="nav-link dropdown-toggle d-flex align-items-center bg-light rounded-pill px-3 py-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">  
                            <span class="fw-bold text-dark small">Halo, <?php echo explode(' ', $_SESSION['user_name'])[0]; ?></span>
                        </a>
                        
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 mt-2 p-2">
                            <li><span class="dropdown-header text-uppercase small fw-bold text-muted">Akun Saya</span></li>
                            
                            <?php if($_SESSION['user_role'] == 'vendor'): ?>
                                <li><a class="dropdown-item py-2 rounded-2" href="dashboard_vendor.php"><i class="bi bi-grid-fill me-2 text-primary"></i> Area Vendor</a></li>
                                <li><a class="dropdown-item py-2 rounded-2" href="vendor_settings.php"><i class="bi bi-gear me-2 text-secondary"></i> Pengaturan Studio</a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item py-2 rounded-2" href="dashboard_user.php"><i class="bi bi-grid-fill me-2 text-primary"></i> Dashboard Saya</a></li>
                            <?php endif; ?>

                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item py-2 rounded-2 text-danger fw-bold" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Keluar</a></li>
                        </ul>
                    </li>

                <?php else: ?>

                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                        <a href="login.php" class="btn btn-outline-primary rounded-pill px-4 me-2">Masuk</a>
                        <a href="register.php" class="btn btn-primary rounded-pill px-4">Daftar</a>
                    </li>

                <?php endif; ?>
                
            </ul>
        </div>
    </div>
</nav>