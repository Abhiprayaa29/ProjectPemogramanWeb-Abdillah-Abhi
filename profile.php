<?php
session_start();
// Pastikan path koneksi benar (sesuai struktur folder kamu, biasanya di includes atau components)
require_once 'includes/koneksi.php';

// 1. Cek ID di URL
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// 2. Ambil Data Vendor dari Database
$query_vendor = "SELECT * FROM vendors WHERE id = '$id'";
$result_vendor = mysqli_query($conn, $query_vendor);
$vendor = mysqli_fetch_assoc($result_vendor);

// Jika vendor tidak ditemukan
if (!$vendor) {
    echo "<script>alert('Fotografer tidak ditemukan!'); window.location.href='index.php';</script>";
    exit;
}

// 3. Ambil Paket Harga Vendor Ini
$query_packages = "SELECT * FROM packages WHERE vendor_id = '$id'"; // Tambahkan is_active=1 jika sudah pakai soft delete
$packages = query($query_packages);

// Hitung Total Paket
$total_packages = count($packages);

// Konversi string skills/equipment menjadi array
$skills = !empty($vendor['skills']) ? explode(',', $vendor['skills']) : [];
$equipment = !empty($vendor['equipment']) ? explode(',', $vendor['equipment']) : [];

// 4. Ambil Data Ulasan untuk Vendor Ini
$query_reviews = "SELECT r.rating, r.comment, r.created_at, u.full_name 
                  FROM reviews r 
                  JOIN bookings b ON r.booking_id = b.id 
                  JOIN users u ON b.user_id = u.id 
                  WHERE b.vendor_id = '$id' 
                  ORDER BY r.id DESC";
$reviews = query($query_reviews);

// Hitung Rata-rata Rating
$total_rating = 0;
$count_reviews = count($reviews);
$avg_rating = 0;

if ($count_reviews > 0) {
    foreach ($reviews as $rev) {
        $total_rating += $rev['rating'];
    }
    $avg_rating = round($total_rating / $count_reviews, 1);
}

$sql = "SELECT * FROM portofolio WHERE id_vendor = '$id' ORDER by id DESC";
$hasil = mysqli_query($conn, $sql);
$dataFoto = [];
while ($row = mysqli_fetch_assoc($hasil)) {
    $dataFoto[] = $row;
}


$pageTitle = "Profil " . $vendor['brand_name'];
include 'components/header.php';
?>

<nav class="navbar navbar-light bg-white sticky-top shadow-sm border-bottom z-3">
    <div class="container">
        <a class="btn btn-light rounded-pill px-3 fw-bold text-secondary shadow-sm" href="index.php">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
        <div>
            <a class="navbar-brand fw-bold text-primary fs-4" href="index.php">
                <i class="bi bi-camera-fill me-2"></i>JogjaLensa
            </a>
        </div>
        <button class="btn btn-outline-secondary rounded-circle"><i class="bi bi-share"></i></button>
    </div>
    </div>
</nav>

<div class="bg-white pb-4 mb-4 shadow-sm">

    <div class="position-relative" style="height: 350px; background-color: #eee;">
        <img src="<?php echo $vendor['cover_img']; ?>" class="w-100 h-100 object-fit-cover">
        <div class="position-absolute bottom-0 start-0 w-100 h-50" style="background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);"></div>
    </div>

    <div class="container position-relative">
        <div class="row">

            <div class="col-md-3 text-center text-md-start">
                <div class="position-relative d-inline-block mt-n5" style="margin-top: -100px;">
                    <img src="<?php echo $vendor['profile_img']; ?>" class="rounded-circle border border-4 border-white shadow-lg bg-white object-fit-cover" width="180" height="180" alt="Profile">
                    <?php if ($vendor['is_verified']): ?>
                        <span class="position-absolute bottom-0 end-0 bg-primary p-2 border border-2 border-white rounded-circle text-white shadow-sm" title="Verified" style="right: 15px;">
                            <i class="bi bi-check-lg fs-5"></i>
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-md-9 pt-3">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h1 class="fw-bold mb-1 text-dark"><?php echo $vendor['brand_name']; ?></h1>
                        <p class="text-muted mb-3">
                            <i class="bi bi-geo-alt-fill text-danger me-1"></i> <?php echo $vendor['location']; ?>
                            &bull; <span class="badge bg-light text-dark border"><?php echo $vendor['category']; ?></span>
                        </p>

                        <div class="d-flex gap-4 text-muted small fw-medium">
                            <div><i class="bi bi-star-fill text-warning me-1"></i> <strong><?php echo ($avg_rating > 0) ? $avg_rating : '-'; ?></strong> (<?php echo $count_reviews; ?> Ulasan)</div>
                            <div><i class="bi bi-camera-fill text-primary me-1"></i> <strong><?php echo $total_packages; ?></strong> Paket</div>
                            <div><i class="bi bi-clock-history text-success me-1"></i> Respon Cepat</div>
                        </div>
                    </div>

                    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                        <?php if (!empty($vendor['instagram'])): ?>
                            <a href="https://instagram.com/<?php echo $vendor['instagram']; ?>" target="_blank" class="btn btn-outline-dark rounded-pill me-2 fw-bold shadow-sm">
                                <i class="bi bi-instagram me-1"></i> Instagram
                            </a>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-4">
    <div class="row g-5">

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4 sticky-top" style="top: 100px; z-index: 1;">
                <div class="card-body p-4">
                    <h6 class="text-uppercase fw-bold text-primary ls-1 mb-3">Tentang Studio</h6>
                    <p class="text-muted small" style="line-height: 1.8; text-align: justify;">
                        <?php echo nl2br($vendor['description']); ?>
                    </p>

                    <hr class="border-light my-4">

                    <?php if (!empty($skills)): ?>
                        <h6 class="text-uppercase fw-bold text-secondary ls-1 mb-3" style="font-size: 0.8rem;">Keahlian</h6>
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            <?php foreach ($skills as $skill): ?>
                                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-normal"><?php echo trim($skill); ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($equipment)): ?>
                        <h6 class="text-uppercase fw-bold text-secondary ls-1 mb-3" style="font-size: 0.8rem;">Gear / Alat</h6>
                        <ul class="list-unstyled small text-muted mb-0">
                            <?php foreach ($equipment as $gear): ?>
                                <li class="mb-2 d-flex align-items-center"><i class="bi bi-camera me-2 text-primary"></i> <?php echo trim($gear); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-8">

            <div class="bg-white rounded-4 shadow-sm border p-2 mb-4 sticky-top" style="top: 90px; z-index: 2;">
                <ul class="nav nav-pills nav-fill" id="myTab" role="tablist">
                    <li class="nav-item"><button class="nav-link active rounded-pill fw-bold py-2" data-bs-toggle="tab" data-bs-target="#packages">📦 Paket Harga</button></li>
                    <li class="nav-item"><button class="nav-link rounded-pill fw-bold py-2" data-bs-toggle="tab" data-bs-target="#portfolio">📷 Galeri</button></li>
                    <li class="nav-item"><button class="nav-link rounded-pill fw-bold py-2" data-bs-toggle="tab" data-bs-target="#reviews">⭐ Ulasan</button></li>
                </ul>
            </div>

            <div class="tab-content">

                <div class="tab-pane fade show active" id="packages">
                    <div class="d-flex align-items-center mb-4">
                        <h5 class="fw-bold mb-0">Pilih Paket Layanan</h5>
                        <span class="badge bg-primary bg-opacity-10 text-primary ms-3 rounded-pill"><?php echo count($packages); ?> Paket Tersedia</span>
                    </div>

                    <?php if (count($packages) > 0): ?>
                        <?php foreach ($packages as $pkg): ?>
                            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden hover-shadow transition position-relative">
                                <div class="card-body p-4">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <h5 class="fw-bold mb-2 text-dark"><?php echo $pkg['name']; ?></h5>
                                            <p class="text-muted small mb-3" style="line-height: 1.6;"><?php echo $pkg['description']; ?></p>
                                            <div class="d-flex gap-2">
                                                <span class="badge bg-light text-dark border"><i class="bi bi-clock me-1"></i> <?php echo $pkg['duration_hours']; ?> Jam Sesi</span>
                                                <span class="badge bg-light text-dark border"><i class="bi bi-image me-1"></i> Edit Tone</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-md-end mt-4 mt-md-0 border-start border-light ps-md-4">
                                            <div class="small text-muted text-uppercase fw-bold mb-1">Harga Mulai</div>
                                            <h3 class="fw-bold text-primary mb-3"><?php echo formatRupiah($pkg['price']); ?></h3>

                                            <?php if (isset($_SESSION['is_login']) && $_SESSION['user_role'] == 'client'): ?>
                                                <button class="btn btn-outline-primary rounded-pill w-100 fw-bold shadow-sm"
                                                    onclick="openBooking('<?php echo $pkg['name']; ?>', <?php echo $pkg['price']; ?>, <?php echo $pkg['id']; ?>, <?php echo $id; ?>)">
                                                    Pilih Paket
                                                </button>
                                            <?php elseif (!isset($_SESSION['is_login'])): ?>
                                                <a href="login.php" class="btn btn-outline-primary rounded-pill w-100 fw-bold shadow-sm">
                                                    Login untuk Pesan
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-5 bg-light rounded-4 border border-dashed">
                            <i class="bi bi-box-seam fs-1 text-muted opacity-50"></i>
                            <p class="text-muted mt-3">Vendor ini belum menambahkan paket harga.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="tab-pane fade" id="portfolio">
                    <?php
                    if (!empty($dataFoto)) {
                        echo '<div class="row g-3">';

                        foreach ($dataFoto as $foto) {
                            $photo = $foto['photo'];

                            echo '<div class="col-md-4">';
                            echo '<div class="card border-0 shadow-sm rounded-4 overflow-hidden hover-shadow transition">';
                            echo '<img src="' . htmlspecialchars($photo) . '" class="w-100" style="height:200px;object-fit:cover;" alt="Portfolio Photo">';
                            echo '</div>';
                            echo '</div>';
                        }

                        echo '</div>';
                    } else {
                        echo '<div class="text-center py-5 bg-light rounded-4 border border-dashed">';
                        echo '<i class="bi bi-image fs-1 text-muted opacity-50"></i>';
                        echo '<p class="text-muted mt-3">Vendor ini belum mengunggah foto portfolio.</p>';
                        echo '</div>';
                    }
                    ?>
                </div>

                <div class="tab-pane fade" id="reviews">
                    <div class="d-flex align-items-center mb-4 p-4 bg-light rounded-4 border">
                        <h1 class="fw-bold m-0 me-3 display-4 text-warning"><?php echo ($avg_rating > 0) ? $avg_rating : '-'; ?></h1>
                        <div>
                            <div class="text-warning fs-5">
                                <?php
                                $stars = round($avg_rating);
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $stars) echo '<i class="bi bi-star-fill"></i>';
                                    else echo '<i class="bi bi-star text-secondary opacity-25"></i>';
                                }
                                ?>
                            </div>
                            <span class="text-muted small fw-bold"><?php echo $count_reviews; ?> Ulasan Terverifikasi</span>
                        </div>
                    </div>

                    <?php if ($count_reviews > 0): ?>
                        <?php foreach ($reviews as $rev): ?>
                            <div class="card border-0 border-bottom rounded-0 p-3 mb-2 bg-white">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold me-3 shadow-sm" style="width: 40px; height: 40px;">
                                            <?php echo substr($rev['full_name'], 0, 1); ?>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-0 text-dark"><?php echo $rev['full_name']; ?></h6>
                                            <span class="text-muted small" style="font-size: 0.75rem;">
                                                <i class="bi bi-calendar2 me-1"></i> <?php echo date('d M Y', strtotime($rev['created_at'])); ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-warning small">
                                        <?php
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $rev['rating']) echo '<i class="bi bi-star-fill"></i>';
                                            else echo '<i class="bi bi-star text-secondary opacity-25"></i>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <p class="text-secondary mt-3 mb-0 ps-5" style="line-height: 1.6;">
                                    "<?php echo htmlspecialchars($rev['comment']); ?>"
                                </p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="bi bi-chat-square-heart fs-1 text-muted opacity-25"></i>
                            <p class="text-muted mt-3">Belum ada ulasan untuk vendor ini.</p>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="bookingModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-dark">Konfirmasi Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">

                <form action="logic/logicuser/proses_booking.php" method="POST">

                    <input type="hidden" name="vendor_id" id="inputVendorId">
                    <input type="hidden" name="package_id" id="inputPackageId">
                    <input type="hidden" name="total_price" id="inputTotalPrice">

                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 mb-4 border border-primary border-opacity-10 d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-primary d-block text-uppercase fw-bold ls-1" style="font-size: 0.7rem;">Paket Dipilih</small>
                            <span class="fw-bold text-dark fs-5" id="modalPackageName">Nama Paket</span>
                        </div>
                        <span class="fw-bold text-primary fs-4" id="modalPrice">Rp 0</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">TANGGAL FOTO</label>
                            <input type="date" name="booking_date" class="form-control bg-light border-0 py-2" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">JAM MULAI</label>
                            <input type="time" name="booking_time" class="form-control bg-light border-0 py-2" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-secondary">CATATAN / REQ KHUSUS</label>
                            <textarea name="note" class="form-control bg-light border-0" rows="3" placeholder="Tulis lokasi detail atau konsep foto yang diinginkan..."></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 btn-lg rounded-3 fw-bold mt-4 shadow-sm hover-scale transition">
                        Lanjut Pembayaran <i class="bi bi-arrow-right ms-2"></i>
                    </button>

                    <div class="text-center mt-3">
                        <small class="text-muted"><i class="bi bi-shield-lock-fill me-1"></i> Transaksi aman dengan Escrow</small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>

<script>
    function openBooking(packageName, price, packageId, vendorId) {
        document.getElementById('modalPackageName').innerText = packageName;
        document.getElementById('modalPrice').innerText = "Rp " + new Intl.NumberFormat('id-ID').format(price);

        document.getElementById('inputPackageId').value = packageId;
        document.getElementById('inputVendorId').value = vendorId;
        document.getElementById('inputTotalPrice').value = price;

        var myModal = new bootstrap.Modal(document.getElementById('bookingModal'));
        myModal.show();
    }
</script>