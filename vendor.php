<?php 
$pageTitle = "Gabung Jadi Vendor - JogjaLensa";
$currentPage = "vendor"; 
include 'components/header.php';
include 'components/navbar_vendor.php';
?>

<div class="position-fixed top-0 start-0 w-100 h-100" style="z-index: -1; overflow: hidden;">
    <video autoplay muted loop playsinline class="w-100 h-100 object-fit-cover" style="filter: blur(8px) brightness(0.4); transform: scale(1.05);">
        <source src="assets/video/YogyaCinematic.mp4" type="video/mp4">
    </video>
</div>

<div class="position-relative d-flex align-items-center justify-content-center text-center text-white" style="min-height: 50vh; padding-top: 80px; padding-bottom: 100px;">
    <div class="container position-relative z-1">
        <span class="badge bg-warning text-dark px-4 py-2 mb-4 fw-bold rounded-pill shadow-lg ls-2">MITRA JOGJALENSA</span>
        <h1 class="display-3 fw-bold text-shadow mb-3">Ubah Hobi Jadi Profesi</h1>
        <p class="lead opacity-90 mx-auto text-shadow fs-5" style="max-width: 700px; line-height: 1.8;">
            Bergabunglah dengan ekosistem fotografer terbesar di Yogyakarta. <br>Atur jadwalmu sendiri, perluas jangkauan klien, dan tingkatkan penghasilan.
        </p>
    </div>
</div>

<div class="container pb-5" style="margin-top: -80px;">
    <div class="row justify-content-center g-5"> 
        
        <div class="col-lg-4 position-relative z-1 d-none d-lg-block">
            <div class="bg-white bg-opacity-10 text-white p-5 rounded-5 shadow-lg h-100 sticky-top border border-white border-opacity-25" style="top: 120px; z-index: 1; backdrop-filter: blur(20px);">
                <h3 class="fw-bold mb-5">Kenapa Harus Gabung?</h3>
                
                <div class="d-flex align-items-start mb-5">
                    <div class="bg-white text-primary p-3 rounded-4 me-3 flex-shrink-0 shadow-sm">
                        <i class="bi bi-people-fill fs-4"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold">Akses Klien Premium</h5>
                        <p class="small opacity-75 mb-0" style="line-height: 1.6;">Ribuan mahasiswa wisuda & turis mencari fotografer setiap hari.</p>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-5">
                    <div class="bg-white text-primary p-3 rounded-4 me-3 flex-shrink-0 shadow-sm">
                        <i class="bi bi-calendar-check-fill fs-4"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold">Manajemen Otomatis</h5>
                        <p class="small opacity-75 mb-0" style="line-height: 1.6;">Dashboard canggih untuk atur paket, jadwal, dan portofolio.</p>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-4">
                    <div class="bg-white text-primary p-3 rounded-4 me-3 flex-shrink-0 shadow-sm">
                        <i class="bi bi-credit-card-fill fs-4"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold">Pembayaran Aman</h5>
                        <p class="small opacity-75 mb-0" style="line-height: 1.6;">Sistem Escrow menjamin bayaran cair tepat waktu.</p>
                    </div>
                </div>

                <hr class="border-white opacity-25 my-5">
                
                <div class="text-center opacity-75 small">
                    <p class="mb-2">Sudah punya akun vendor?</p>
                    <a href="login.php" class="btn btn-outline-light rounded-pill px-4 fw-bold w-100">Masuk Dashboard</a>
                </div>
            </div>
        </div>

        <div class="col-lg-8 position-relative z-1">
            <div class="card shadow-lg border-0 rounded-5 overflow-hidden">
                <div class="card-header bg-white border-0 p-5 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-dark text-white rounded-circle p-3 me-3 d-flex align-items-center justify-content-center shadow" style="width: 60px; height: 60px;">
                            <i class="bi bi-camera-fill fs-3"></i>
                        </div>
                        <div>
                            <h2 class="fw-bold text-dark mb-1">Formulir Mitra</h2>
                            <p class="text-muted mb-0">Lengkapi profil studio foto kamu.</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-5">
                    <form action="logic/auth/proses_register_vendor.php" method="POST"> 
                        
                        <h6 class="text-primary fw-bold text-uppercase ls-2 mb-4"><i class="bi bi-person-circle me-2"></i>Data Pemilik</h6>
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">NAMA DEPAN</label>
                                <input type="text" name="first_name" class="form-control form-control-lg bg-light border-0 fs-6" placeholder="Nama depanmu" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">NAMA BELAKANG</label>
                                <input type="text" name="last_name" class="form-control form-control-lg bg-light border-0 fs-6" placeholder="Nama belakangmu" required>
                            </div>
                        </div>

                        <hr class="border-light my-5">

                        <h6 class="text-primary fw-bold text-uppercase ls-2 mb-4"><i class="bi bi-shop-window me-2"></i>Profil Bisnis</h6>
                        
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-secondary">NAMA BRAND / STUDIO</label>
                            <input type="text" name="brand_name" class="form-control form-control-lg bg-light border-0 fs-6" placeholder="Contoh: Lensa Jogja Art" required>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">KATEGORI UTAMA</label>
                                <select name="category" class="form-select form-select-lg bg-light border-0 fs-6" required>
                                    <option value="" selected disabled>Pilih Spesialisasi...</option>
                                    <option value="Wisuda">Wisuda & Graduation</option>
                                    <option value="Wedding">Wedding & Prewedding</option>
                                    <option value="Event">Event & Dokumentasi</option>
                                    <option value="Produk">Foto Produk & Makanan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">DOMISILI</label>
                                <select name="location" class="form-select form-select-lg bg-light border-0 fs-6" required>
                                    <option value="" selected disabled>Pilih Lokasi...</option>
                                    <option value="Sleman">Sleman</option>
                                    <option value="Bantul">Bantul</option>
                                    <option value="Kota Yogyakarta">Kota Yogyakarta</option>
                                    <option value="Kulon Progo">Kulon Progo</option>
                                    <option value="Gunung Kidul">Gunung Kidul</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-secondary">PORTOFOLIO (INSTAGRAM)</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="bi bi-instagram"></i></span>
                                <input type="text" name="instagram" class="form-control bg-light border-0 fs-6" placeholder="username_instagram_studio" required>
                            </div>
                            <div class="form-text ms-1">Pastikan akun tidak di-private agar tim kami bisa memverifikasi.</div>
                        </div>

                        <hr class="border-light my-5">

                        <h6 class="text-primary fw-bold text-uppercase ls-2 mb-4"><i class="bi bi-shield-lock me-2"></i>Akun Login</h6>
                        
                        <div class="alert alert-primary bg-primary bg-opacity-10 border-0 rounded-3 d-flex align-items-center mb-4" role="alert">
                            <i class="bi bi-info-circle-fill me-3 fs-4 text-primary"></i>
                            <div class="small text-dark">Email dan Password ini akan digunakan untuk masuk ke Dashboard Vendor untuk mengelola pesanan.</div>
                        </div>

                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">EMAIL BISNIS</label>
                                <input type="email" name="email" class="form-control form-control-lg bg-light border-0 fs-6" placeholder="email@bisnis.com" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">PASSWORD</label>
                                <input type="password" name="password" class="form-control form-control-lg bg-light border-0 fs-6" placeholder="********" required>
                            </div>
                        </div>

                        <div class="form-check mb-5 p-3 bg-light rounded-3 border border-light">
                            <input class="form-check-input ms-1 mt-1" type="checkbox" id="agreeTerms" required style="transform: scale(1.2);">
                            <label class="form-check-label small text-muted ms-3" for="agreeTerms" style="line-height: 1.6;">
                                Saya menyatakan bahwa portofolio yang saya lampirkan adalah karya asli saya, dan saya menyetujui <a href="#" class="text-decoration-none fw-bold text-primary">Syarat & Ketentuan</a> Mitra JogjaLensa.
                            </label>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 btn-lg rounded-pill fw-bold shadow-lg py-3 hover-scale transition text-uppercase ls-1">
                            <i class="bi bi-rocket-takeoff-fill me-2"></i>Daftar Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>