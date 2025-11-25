<?php 
$pageTitle = "Daftar - JogjaLensa";
// Panggil komponen header
include 'components/header.php'; 
?>

<div class="position-fixed top-0 start-0 w-100 h-100" style="z-index: -1; overflow: hidden;">
    <video autoplay muted loop playsinline class="w-100 h-100 object-fit-cover" style="filter: blur(8px) brightness(0.4); transform: scale(1.05);">
        <source src="assets/video/YogyaCinematic.mp4" type="video/mp4">
    </video>
</div>

<div class="d-flex align-items-center min-vh-100 py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                
                <div class="text-center mb-4">
                    <a href="index.php" class="text-decoration-none text-white fw-bold fs-3 text-shadow">
                        <i class="bi bi-camera-fill me-2"></i>JogjaLensa
                    </a>
                </div>
                
                <div class="card border-0 shadow-lg rounded-4 p-4">
                    <div class="card-body">
                        <h4 class="fw-bold text-dark mb-1">Buat Akun Baru</h4>
                        <p class="text-muted small mb-4">Bergabunglah dengan komunitas kami.</p>
                        
                        <form action="logic/auth/proses_register.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary">NAMA LENGKAP</label>
                                <input type="text" name="fullname" class="form-control form-control-lg bg-light border-0" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary">EMAIL</label>
                                <input type="email" name="email" class="form-control form-control-lg bg-light border-0" required>
                            </div>
                            <div class="row g-2 mb-4">
                                <div class="col-6">
                                    <label class="form-label small fw-bold text-secondary">PASSWORD</label>
                                    <input type="password" name="password" class="form-control form-control-lg bg-light border-0" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label small fw-bold text-secondary">ULANGI</label>
                                    <input type="password" name="confirm_password" class="form-control form-control-lg bg-light border-0" required>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100 btn-lg rounded-3 fw-bold mb-3">Daftar Akun</button>
                        </form>

                        <div class="text-center mt-4">
                            <p class="small text-muted mb-0">Sudah punya akun? <a href="login.php" class="text-decoration-none fw-bold">Masuk disini</a></p>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <a href="index.php" class="text-white small text-decoration-none hover-white"><i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda</a>
                </div>

            </div>
        </div>
    </div>
</div>

<?php 
// Panggil komponen footer
include 'components/footer.php'; 
?>