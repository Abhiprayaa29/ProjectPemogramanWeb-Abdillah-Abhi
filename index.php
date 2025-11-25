<?php 
$pageTitle = "Beranda - JogjaLensa";
$currentPage = "home";

// 1. Panggil Koneksi & Header
require_once 'includes/koneksi.php'; 
include 'components/header.php';
include 'components/navbar.php';

// 2. Ambil Data Vendor (Top 3 Termurah)
$query_sql = "SELECT v.*, MIN(p.price) as min_price 
              FROM vendors v 
              LEFT JOIN packages p ON v.id = p.vendor_id 
              GROUP BY v.id 
              ORDER BY min_price ASC 
              LIMIT 3";
$photographers = query($query_sql);

// 3. Statistik Database (Real-time)
// Hitung Vendor
$q_vendor = mysqli_query($conn, "SELECT COUNT(*) as total FROM vendors");
$total_vendor = mysqli_fetch_assoc($q_vendor)['total'];

// Hitung Transaksi Selesai
$q_booking = mysqli_query($conn, "SELECT COUNT(*) as total FROM bookings WHERE status = 'completed'");
$total_booking = mysqli_fetch_assoc($q_booking)['total'];

// Hitung Rating Global
$q_rating = mysqli_query($conn, "SELECT AVG(rating) as avg_rat FROM reviews");
$data_rating = mysqli_fetch_assoc($q_rating);
$site_rating = round($data_rating['avg_rat'], 1);
if($site_rating == 0) $site_rating = "4.9"; // Default jika kosong
?>

<header class="position-relative vh-100 d-flex align-items-center justify-content-center text-center text-white overflow-hidden bg-black">
    
    <div class="position-absolute top-0 start-0 w-100 h-100">
        <video autoplay muted loop playsinline class="w-100 h-100 object-fit-cover opacity-60">
            <source src="assets/video/YogyaCinematic.mp4" type="video/mp4">
        </video>
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to bottom, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.8) 100%);"></div>
    </div>

    <div class="container position-relative z-1 mt-5">
        <span class="badge bg-white bg-opacity-10 border border-white border-opacity-25 px-4 py-2 rounded-pill mb-4 backdrop-blur-sm text-uppercase ls-2 fade-in-up">
            ✨ #1 Marketplace Fotografi Jogja
        </span>
        
        <h1 class="display-3 fw-bold mb-4 text-shadow fade-in-up" style="animation-delay: 0.2s;">Abadikan Momen Terbaikmu</h1>
        
        <p class="lead mb-5 opacity-90 fs-5 text-shadow mx-auto fade-in-up" style="max-width: 700px; animation-delay: 0.4s;">
            Platform terpercaya untuk menemukan fotografer Wisuda, Pre-wed, dan Liburan di Yogyakarta dengan harga transparan.
        </p>
        
        <div class="card p-2 mx-auto border-0 rounded-pill shadow-lg fade-in-up" style="max-width: 700px; background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(15px); animation-delay: 0.6s;">
            <div class="card-body p-1">
                <form action="pencarian.php" method="GET">
                    <div class="row g-0 align-items-center">
                        <div class="col-md-9 position-relative">
                            <i class="bi bi-search text-white position-absolute top-50 start-0 translate-middle-y ms-4 fs-5"></i>
                            <input type="text" name="q" class="form-control form-control-lg border-0 bg-transparent text-white ps-5 placeholder-white" placeholder="Cari Fotografer (mis: Wisuda UGM)..." style="box-shadow: none;">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100 btn-lg rounded-pill fw-bold py-2 shadow hover-scale">
                                Cari
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="row mt-5 pt-4 justify-content-center text-white opacity-90 fade-in-up" style="animation-delay: 0.8s;">
            <div class="col-auto px-4 border-end border-light border-opacity-25">
                <div class="fw-bold fs-2"><?php echo $total_vendor; ?>+</div>
                <div class="small text-uppercase ls-1">Mitra Vendor</div>
            </div>
            <div class="col-auto px-4 border-end border-light border-opacity-25">
                <div class="fw-bold fs-2"><?php echo $total_booking; ?>+</div>
                <div class="small text-uppercase ls-1">Transaksi Sukses</div>
            </div>
            <div class="col-auto px-4">
                <div class="fw-bold fs-2 text-warning"><?php echo $site_rating; ?>/5</div>
                <div class="small text-uppercase ls-1">Rating Kepuasan</div>
            </div>
        </div>
    </div>
</header>

<section class="py-5 bg-white">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h6 class="text-primary fw-bold text-uppercase ls-2">Layanan Kami</h6>
            <h2 class="fw-bold display-6">Apapun Momennya, Kami Siap</h2>
            <p class="text-muted">Pilih kategori spesialisasi sesuai kebutuhan acaramu.</p>
        </div>

        <div class="row g-4">
            <div class="col-6 col-lg-3">
                <a href="pencarian.php?q=Wisuda" class="text-decoration-none">
                    <div class="card border-0 rounded-4 overflow-hidden text-white h-100 shadow-sm category-card position-relative">
                        <img src="assets/image/wisuda.jpg" class="card-img w-100 h-100 object-fit-cover transition-transform" style="height: 380px;">
                        <div class="card-img-overlay d-flex flex-column justify-content-end p-4 bg-gradient-to-t">
                            <div class="icon-box bg-white text-primary rounded-circle d-flex align-items-center justify-content-center mb-3 shadow" style="width: 50px; height: 50px;">
                                <i class="bi bi-mortarboard-fill fs-4"></i>
                            </div>
                            <h4 class="fw-bold mb-1">Wisuda</h4>
                            <p class="small text-white-50 mb-0">Dokumentasi kelulusan.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-6 col-lg-3">
                <a href="pencarian.php?q=Wedding" class="text-decoration-none">
                    <div class="card border-0 rounded-4 overflow-hidden text-white h-100 shadow-sm category-card position-relative">
                        <img src="assets/image/wedding.jpg" class="card-img w-100 h-100 object-fit-cover transition-transform" style="height: 380px;">
                        <div class="card-img-overlay d-flex flex-column justify-content-end p-4 bg-gradient-to-t">
                            <div class="icon-box bg-white text-danger rounded-circle d-flex align-items-center justify-content-center mb-3 shadow" style="width: 50px; height: 50px;">
                                <i class="bi bi-heart-fill fs-4"></i>
                            </div>
                            <h4 class="fw-bold mb-1">Wedding</h4>
                            <p class="small text-white-50 mb-0">Pre-wedding & Resepsi.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-6 col-lg-3">
                <a href="pencarian.php?q=Event" class="text-decoration-none">
                    <div class="card border-0 rounded-4 overflow-hidden text-white h-100 shadow-sm category-card position-relative">
                        <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=600&q=80" class="card-img w-100 h-100 object-fit-cover transition-transform" style="height: 380px;">
                        <div class="card-img-overlay d-flex flex-column justify-content-end p-4 bg-gradient-to-t">
                            <div class="icon-box bg-white text-success rounded-circle d-flex align-items-center justify-content-center mb-3 shadow" style="width: 50px; height: 50px;">
                                <i class="bi bi-camera-reels-fill fs-4"></i>
                            </div>
                            <h4 class="fw-bold mb-1">Event</h4>
                            <p class="small text-white-50 mb-0">Konser & Gathering.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-6 col-lg-3">
                <a href="pencarian.php?q=Produk" class="text-decoration-none">
                    <div class="card border-0 rounded-4 overflow-hidden text-white h-100 shadow-sm category-card position-relative">
                        <img src="https://images.unsplash.com/photo-1484723091739-30a097e8f929?auto=format&fit=crop&w=600&q=80" class="card-img w-100 h-100 object-fit-cover transition-transform" style="height: 380px;">
                        <div class="card-img-overlay d-flex flex-column justify-content-end p-4 bg-gradient-to-t">
                            <div class="icon-box bg-white text-warning rounded-circle d-flex align-items-center justify-content-center mb-3 shadow" style="width: 50px; height: 50px;">
                                <i class="bi bi-basket-fill fs-4"></i>
                            </div>
                            <h4 class="fw-bold mb-1">Produk</h4>
                            <p class="small text-white-50 mb-0">Katalog UMKM & Makanan.</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light position-relative overflow-hidden">
    <div class="position-absolute top-0 start-0 translate-middle bg-primary opacity-10 rounded-circle blur-3xl" style="width: 400px; height: 400px; filter: blur(80px);"></div>
    <div class="position-absolute bottom-0 end-0 translate-middle bg-warning opacity-10 rounded-circle blur-3xl" style="width: 300px; height: 300px; filter: blur(60px);"></div>

    <div class="container py-5 position-relative z-1">
        <div class="text-center mb-5">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3 fw-bold">HOW IT WORKS</span>
            <h2 class="fw-bold display-6">4 Langkah Mudah Booking</h2>
        </div>

        <div class="row g-4 position-relative">
            <div class="d-none d-lg-block position-absolute top-0 start-0 w-100 mt-5 pt-4" style="z-index: 0;">
                <div class="border-top border-2 border-secondary border-opacity-10 w-75 mx-auto" style="border-style: dashed !important;"></div>
            </div>

            <div class="col-lg-3 col-md-6 position-relative z-1">
                <div class="card border-0 bg-white shadow-sm rounded-4 text-center h-100 p-4 hover-lift transition">
                    <div class="position-relative mx-auto mb-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px;">
                            <i class="bi bi-search fs-2"></i>
                        </div>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary border border-4 border-white shadow-sm" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">1</span>
                    </div>
                    <h5 class="fw-bold">Cari Fotografer</h5>
                    <p class="text-muted small mb-0">Temukan fotografer yang cocok dengan gaya dan budget kamu.</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 position-relative z-1">
                <div class="card border-0 bg-white shadow-sm rounded-4 text-center h-100 p-4 hover-lift transition">
                    <div class="position-relative mx-auto mb-4">
                        <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px;">
                            <i class="bi bi-calendar2-check fs-2"></i>
                        </div>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark border border-4 border-white shadow-sm" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">2</span>
                    </div>
                    <h5 class="fw-bold">Booking Jadwal</h5>
                    <p class="text-muted small mb-0">Pilih tanggal dan tunggu konfirmasi ketersediaan dari vendor.</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 position-relative z-1">
                <div class="card border-0 bg-white shadow-sm rounded-4 text-center h-100 p-4 hover-lift transition">
                    <div class="position-relative mx-auto mb-4">
                        <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px;">
                            <i class="bi bi-camera-fill fs-2"></i>
                        </div>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-4 border-white shadow-sm" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">3</span>
                    </div>
                    <h5 class="fw-bold">Sesi Foto</h5>
                    <p class="text-muted small mb-0">Bertemu di lokasi dan nikmati momen pemotretanmu.</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 position-relative z-1">
                <div class="card border-0 bg-white shadow-sm rounded-4 text-center h-100 p-4 hover-lift transition">
                    <div class="position-relative mx-auto mb-4">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px;">
                            <i class="bi bi-cloud-arrow-down-fill fs-2"></i>
                        </div>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success border border-4 border-white shadow-sm" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">4</span>
                    </div>
                    <h5 class="fw-bold">Terima Hasil</h5>
                    <p class="text-muted small mb-0">Download foto HD dan berikan rating terbaikmu.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container py-5 my-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h3 class="fw-bold m-0">Fotografer Pilihan</h3>
            <p class="text-muted m-0">Rekomendasi terbaik minggu ini</p>
        </div>
        <a href="pencarian.php" class="btn btn-outline-primary rounded-pill px-4 fw-bold shadow-sm hover-scale">Lihat Semua</a>
    </div>

    <div class="row g-4">
        <?php if(count($photographers) > 0) : foreach($photographers as $foto): ?>
        <div class="col-md-4">
            <a href="profile.php?id=<?php echo $foto['id']; ?>" class="text-decoration-none text-dark">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative hover-lift transition">
                    <div class="position-relative">
                        <img src="<?php echo $foto['cover_img']; ?>" class="card-img-top object-fit-cover" style="height: 220px;" alt="Vendor">
                        <?php if($foto['is_verified']): ?>
                        <span class="position-absolute bottom-0 start-0 m-3 badge bg-primary shadow-sm rounded-pill px-2 py-1 small">
                            <i class="bi bi-patch-check-fill"></i> Verified
                        </span>
                        <?php endif; ?>
                    </div>
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-1 text-truncate"><?php echo $foto['brand_name']; ?></h5>
                        <p class="text-muted small mb-3"><i class="bi bi-geo-alt-fill text-danger me-1"></i> <?php echo $foto['location']; ?></p>
                        
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10 rounded-pill px-3 mb-3">
                            <?php echo $foto['category']; ?>
                        </span>
                        
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <span class="text-muted small">Mulai dari</span>
                            <span class="fw-bold text-primary fs-5"><?php echo ($foto['min_price'] > 0) ? formatRupiah($foto['min_price']) : 'Hubungi Admin'; ?></span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach; else: ?>
            <div class="col-12 text-center py-5"><p class="text-muted">Belum ada data.</p></div>
        <?php endif; ?>
    </div>
</section>

<section class="container py-5">
    <div class="row g-5">
        <div class="col-lg-7">
            <h3 class="fw-bold mb-4">Spot Foto Favorit</h3>
            <div class="row g-3">
                <div class="col-12">
                    <div class="card border-0 rounded-4 text-white overflow-hidden shadow-sm h-100 position-relative category-card">
                        <img src="assets/image/malioboro.jpg" class="card-img w-100 h-100 object-fit-cover transition-transform" style="height: 250px;">
                        <div class="card-img-overlay d-flex flex-column justify-content-end bg-gradient-to-t p-4">
                            <h4 class="fw-bold mb-0">Jalan Malioboro</h4>
                            <p class="small mb-0 opacity-90"><i class="bi bi-geo-alt-fill text-warning"></i> Pusat Kota Yogyakarta</p>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card border-0 rounded-4 text-white overflow-hidden shadow-sm h-100 position-relative category-card">
                        <img src="assets/image/tamansari.jpg" class="card-img w-100 h-100 object-fit-cover transition-transform" style="height: 200px;">
                        <div class="card-img-overlay d-flex flex-column justify-content-end bg-gradient-to-t p-3">
                            <h6 class="fw-bold mb-0">Tamansari</h6>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card border-0 rounded-4 text-white overflow-hidden shadow-sm h-100 position-relative category-card">
                        <img src="assets/image/prambanan.jpg" class="card-img w-100 h-100 object-fit-cover transition-transform" style="height: 200px;">
                        <div class="card-img-overlay d-flex flex-column justify-content-end bg-gradient-to-t p-3">
                            <h6 class="fw-bold mb-0">Prambanan</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <h3 class="fw-bold mb-4">Punya Pertanyaan?</h3>
            
            <div class="accordion accordion-flush shadow-sm rounded-4 overflow-hidden border" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold py-3 bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            Apakah harga sudah termasuk tiket?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted small pt-0">Tidak. Tiket masuk lokasi wisata ditanggung oleh klien.</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold py-3 bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            Apakah uang aman?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted small pt-0">Sangat aman! Kami menggunakan sistem Escrow. Uang hanya cair ke vendor setelah pekerjaan selesai.</div>
                    </div>
                </div>
            </div>

            <div class="bg-primary bg-opacity-10 p-4 rounded-4 mt-4 text-center border border-primary border-opacity-10">
                <h5 class="fw-bold text-primary">Kamu Fotografer?</h5>
                <p class="small text-muted mb-3">Bergabunglah dengan kami dan dapatkan klien baru setiap hari.</p>
                <a href="vendor.php" class="btn btn-primary w-100 rounded-pill fw-bold shadow-sm hover-scale">Daftar Jadi Mitra</a>
            </div>
        </div>
    </div>
</section>

<style>
    .bg-gradient-to-t { background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 100%); }
    
    .category-card img { transition: transform 0.6s cubic-bezier(0.25, 0.8, 0.25, 1); }
    .category-card:hover img { transform: scale(1.1); }
    
    .hover-lift { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .hover-lift:hover { transform: translateY(-5px); box-shadow: 0 1rem 3rem rgba(0,0,0,.15)!important; }

    /* Placeholder warna putih untuk input search */
    .placeholder-white::placeholder { color: rgba(255, 255, 255, 0.7); }

    /* Fade In Animation */
    .fade-in-up { animation: fadeInUp 0.8s ease-out forwards; opacity: 0; transform: translateY(20px); }
    @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
</style>

<?php include 'components/footer.php'; ?>