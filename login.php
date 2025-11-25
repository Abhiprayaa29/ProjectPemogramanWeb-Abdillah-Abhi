<?php 
$pageTitle = "Masuk - JogjaLensa";
// UPDATE: Path diubah dari 'includes' ke 'components'
include 'components/header.php'; 
?>

<div class="position-fixed top-0 start-0 w-100 h-100" style="z-index: -1; overflow: hidden;">
    <video autoplay muted loop playsinline class="w-100 h-100 object-fit-cover" style="filter: blur(8px) brightness(0.4); transform: scale(1.05);">
        <source src="assets/video/YogyaCinematic.mp4" type="video/mp4">
    </video>
</div>

<div class="d-flex align-items-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                
                <div class="text-center mb-4">
                    <a href="index.php" class="text-decoration-none text-white fw-bold fs-3 text-shadow">
                        <i class="bi bi-camera-fill me-2"></i>JogjaLensa
                    </a>
                </div>
                
                <div class="card border-0 shadow-lg rounded-4 p-4">
                    <div class="card-body">
                        <h4 class="fw-bold text-dark mb-1">Selamat Datang</h4>
                        <p class="text-muted small mb-4">Masuk untuk mengelola pesanan Anda.</p>
                        
                        <form action="logic/auth/proses_login.php" method="POST"> 
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary">ALAMAT EMAIL</label>
                                <input type="email" name="email" class="form-control form-control-lg bg-light border-0" placeholder="nama@email.com" required>
                            </div>
                            <div class="mb-4">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label small fw-bold text-secondary">PASSWORD</label>
                                    <a href="#" class="small text-decoration-none">Lupa password?</a>
                                </div>
                                <input type="password" name="password" class="form-control form-control-lg bg-light border-0" placeholder="******" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 btn-lg rounded-3 fw-bold mb-3">Masuk Sekarang</button>
                        </form>

                        <div class="text-center mt-4">
                            <p class="small text-muted mb-0">Belum punya akun? <a href="register.php" class="text-decoration-none fw-bold">Daftar Gratis</a></p>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <a href="index.php" class="text-white small text-decoration-none"><i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include 'components/footer.php'; 
?>