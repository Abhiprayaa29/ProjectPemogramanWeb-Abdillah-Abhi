<?php
// File: portofolio.php
// Referensi screenshot (lokal): /mnt/data/9cbc9106-0f37-4dca-be98-be74865ec799.png

session_start();
require_once 'includes/koneksi.php'; // pastikan path benar

// Redirect jika bukan vendor
if (!isset($_SESSION['is_login']) || $_SESSION['user_role'] !== 'vendor') {
    header("Location: login.php");
    exit;
}

// helper fallback kalau fungsi formatRupiah tidak tersedia
if (!function_exists('formatRupiah')) {
    function formatRupiah($angka)
    {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }
}

// Ambil vendor_id dari tabel vendors berdasarkan user_id session
$user_id = $_SESSION['user_id'];
$qv = mysqli_query($conn, "SELECT id FROM vendors WHERE user_id = '" . mysqli_real_escape_string($conn, $user_id) . "' LIMIT 1");
if (!$qv || mysqli_num_rows($qv) == 0) {
    $_SESSION['flash_error'] = "Vendor tidak ditemukan.";
    header("Location: vendor_dashboard.php");
    exit;
}
$vendor = mysqli_fetch_assoc($qv);
$vendor_id = $vendor['id'];

// Ambil daftar portofolio vendor
$sql = "SELECT * FROM portofolio WHERE id_vendor = '" . intval($vendor_id) . "' ORDER BY id DESC";
$res = mysqli_query($conn, $sql);
$portfolios = [];
if ($res) {
    while ($r = mysqli_fetch_assoc($res)) $portfolios[] = $r;
}

// ambil flash message (jika ada) dan kosongkan
$flash_success = isset($_SESSION['flash_success']) ? $_SESSION['flash_success'] : null;
$flash_error = isset($_SESSION['flash_error']) ? $_SESSION['flash_error'] : null;
unset($_SESSION['flash_success'], $_SESSION['flash_error']);

// header + navbar (sesuaikan)
$pageTitle = "Portofolio - JogjaLensa";
$currentPage = "porto"; // untuk highlight sidebar
include 'components/header.php';
include 'components/navbar.php';
?>

<div class="bg-light min-vh-100 pb-5" style="padding-top: 100px;">
    <div class="container">

        <!-- Flash messages -->
        <?php if ($flash_success): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($flash_success); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if ($flash_error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($flash_error); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Layout dua kolom: sidebar (include) dan konten portofolio -->
        <div class="d-flex bd-highlight">
            <?php include 'components/vendor_sidebar.php'; ?>
            <div class="g-3 p-2 flex-fill bd-highlight">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0">Portofolio Saya</h4>
                    <div>
                        <button class="btn btn-primary rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#modalAddPhoto">
                            <i class="bi bi-image me-2"></i>Tambah Foto Portofolio
                        </button>
                    </div>
                </div>
                <?php if (count($portfolios) == 0): ?>
                    <div class="col-12 text-center py-5">
                        <div class="bg-white p-5 rounded-4 border border-dashed shadow-sm">
                            <i class="bi bi-box-seam fs-1 text-muted opacity-25"></i>
                            <p class="text-muted mt-3 mb-0">Belum ada portofolio yang diupload.</p>
                            <p class="text-muted small mb-0">Klik "Tambah Foto Portofolio" untuk mulai menambahkan.</p>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="d-flex">
                        <?php foreach ($portfolios as $p): ?>
                            <div class="col-md-6 col-xl-4 me-2">
                                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                                    <?php
                                    // cek file exist lebih aman: cek file path relatif terhadap file ini
                                    $photoPath = '';
                                    if (!empty($p['photo'])) {
                                        $possible = __DIR__ . '/' . $p['photo'];
                                        if (is_file($possible)) {
                                            // gunakan path relatif yang disimpan agar <img src> bisa diakses oleh browser
                                            $photoPath = $p['photo'];
                                        } else {
                                            // jika path bukan file di server (mis: sudah URL penuh), pakai apa adanya
                                            $photoPath = $p['photo'];
                                        }
                                    }
                                    ?>
                                    <?php if (!empty($photoPath)): ?>
                                        <img src="<?php echo htmlspecialchars($photoPath); ?>" class="card-img-top" alt="Foto" style="object-fit:cover; height:220px;">
                                    <?php else: ?>
                                        <div class="d-flex align-items-center justify-content-center bg-secondary bg-opacity-10" style="height:220px;">
                                            <i class="bi bi-image fs-1 text-muted"></i>
                                        </div>
                                    <?php endif; ?>

                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-secondary">ID: <?php echo intval($p['id']); ?></small>
                                            <div>
                                                <!-- Hapus -->
                                                <a href="logic/logicvendor/proses_hapus_foto_portofolio.php?id=<?php echo $p['id']; ?>"
                                                    class="btn btn-sm btn-outline-danger rounded-pill"
                                                    onclick="return confirm('Yakin hapus foto portofolio ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    </div>
            </div>
        <?php endif; ?>
        </div>
    </div>
</div> <!-- akhir row -->
</div> <!-- akhir container -->
</div> <!-- akhir bg -->

<!-- Modal Upload Foto Portofolio -->
<div class="modal fade" id="modalAddPhoto" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 px-4 pt-4">
                <h5 class="modal-title fw-bold">Upload Foto Portofolio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <form action="logic/logicvendor/proses_tambah_foto_portofolio.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="vendor_id" value="<?php echo intval($vendor_id); ?>">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">PILIH FOTO</label>
                        <input type="file" id="inputPhoto" name="photo" class="form-control" accept=".jpg,.jpeg,.png,.webp" required>
                        <small class="text-muted">Format: JPG, PNG, WEBP. Max 5MB.</small>
                    </div>

                    <div class="mb-3" id="previewWrapper" style="display:none;">
                        <label class="form-label small fw-bold text-secondary">Preview</label>
                        <div>
                            <img id="previewImage" src="#" alt="Preview" style="max-width:100%; height:auto; border-radius:8px;">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">Upload Foto</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>

<script>
    // Preview file sebelum upload
    const inputPhoto = document.getElementById('inputPhoto');
    if (inputPhoto) {
        inputPhoto.addEventListener('change', function(e) {
            const file = this.files[0];
            if (!file) return;
            const allowed = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            if (!allowed.includes(file.type)) {
                alert('Format file tidak didukung. Gunakan JPG, PNG, atau WEBP.');
                this.value = '';
                return;
            }
            if (file.size > 5 * 1024 * 1024) {
                alert('Ukuran file terlalu besar (max 5MB).');
                this.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = function(ev) {
                document.getElementById('previewImage').src = ev.target.result;
                document.getElementById('previewWrapper').style.display = 'block';
            };
            reader.readAsDataURL(file);
        });
    }
</script>