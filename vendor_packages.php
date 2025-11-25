<?php 
session_start();
require_once 'includes/koneksi.php';

// Cek Login Vendor
if (!isset($_SESSION['is_login']) || $_SESSION['user_role'] !== 'vendor') {
    header("Location: login.php");
    exit;
}

$pageTitle = "Kelola Paket - JogjaLensa";
$currentPage = "packages"; 
include 'components/header.php';
include 'components/navbar.php';

$user_id = $_SESSION['user_id'];
// Ambil ID Vendor
$vendor = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM vendors WHERE user_id = '$user_id'"));
$vendor_id = $vendor['id'];

// Ambil Daftar Paket
$packages = query("SELECT * FROM packages WHERE vendor_id = '$vendor_id'");
?>

<div class="bg-light min-vh-100 pb-5" style="padding-top: 100px;">
    <div class="container">
        <div class="row g-4">
            
            <?php include 'components/vendor_sidebar.php'; ?>

            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0">Daftar Paket Harga</h4>
                    <button class="btn btn-primary rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#modalAddPackage">
                        <i class="bi bi-plus-lg me-2"></i>Tambah Paket
                    </button>
                </div>

                <div class="row g-3">
                    <?php foreach($packages as $pkg): ?>
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm rounded-4 position-relative overflow-hidden hover-shadow transition">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between mb-3">
                                    <h5 class="fw-bold mb-0 text-dark"><?php echo $pkg['name']; ?></h5>
                                    <div class="text-primary fw-bold fs-5"><?php echo formatRupiah($pkg['price']); ?></div>
                                </div>
                                <p class="text-muted small mb-4" style="min-height: 40px; line-height: 1.6;">
                                    <?php echo nl2br($pkg['description']); ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                    <span class="badge bg-light text-secondary border rounded-pill px-3">
                                        <i class="bi bi-clock me-1"></i> <?php echo $pkg['duration_hours']; ?> Jam
                                    </span>
                                    
                                    <div>
                                        <button class="btn btn-sm btn-outline-warning rounded-pill me-1 fw-bold" 
                                                onclick="editPackage(
                                                    '<?php echo $pkg['id']; ?>', 
                                                    '<?php echo addslashes($pkg['name']); ?>', 
                                                    '<?php echo $pkg['price']; ?>', 
                                                    '<?php echo $pkg['duration_hours']; ?>', 
                                                    '<?php echo addslashes($pkg['description']); ?>'
                                                )">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>

                                        <a href="logic/logicvendor/proses_hapus_paket.php?id=<?php echo $pkg['id']; ?>" 
                                           class="btn btn-sm btn-outline-danger rounded-pill" 
                                           onclick="return confirm('Yakin hapus paket ini?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    
                    <?php if(count($packages) == 0): ?>
                        <div class="col-12 text-center py-5">
                            <div class="bg-white p-5 rounded-4 border border-dashed shadow-sm">
                                <i class="bi bi-box-seam fs-1 text-muted opacity-25"></i>
                                <p class="text-muted mt-3 mb-0">Belum ada paket yang dibuat.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAddPackage" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 px-4 pt-4">
                <h5 class="modal-title fw-bold">Buat Paket Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <form action="logic/logicvendor/proses_tambah_paket.php" method="POST">
                    <input type="hidden" name="vendor_id" value="<?php echo $vendor_id; ?>">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">NAMA PAKET</label>
                        <input type="text" name="name" class="form-control bg-light border-0" placeholder="Misal: Wisuda Basic" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-secondary">HARGA (RP)</label>
                            <input type="number" name="price" class="form-control bg-light border-0" placeholder="350000" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-secondary">DURASI (JAM)</label>
                            <input type="number" name="duration" class="form-control bg-light border-0" placeholder="1" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary">DESKRIPSI / FASILITAS</label>
                        <textarea name="desc" class="form-control bg-light border-0" rows="3" placeholder="Apa saja yang didapat klien..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">Simpan Paket</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditPackage" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 px-4 pt-4">
                <h5 class="modal-title fw-bold text-warning">Edit Paket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <form action="logic/logicvendor/proses_edit_paket.php" method="POST">
                    <input type="hidden" name="package_id" id="editId">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">NAMA PAKET</label>
                        <input type="text" name="name" id="editName" class="form-control bg-light border-0" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-secondary">HARGA (RP)</label>
                            <input type="number" name="price" id="editPrice" class="form-control bg-light border-0" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-secondary">DURASI (JAM)</label>
                            <input type="number" name="duration" id="editDuration" class="form-control bg-light border-0" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary">DESKRIPSI</label>
                        <textarea name="desc" id="editDesc" class="form-control bg-light border-0" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-warning w-100 rounded-pill fw-bold">Update Paket</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>

<script>
    function editPackage(id, name, price, duration, desc) {
        document.getElementById('editId').value = id;
        document.getElementById('editName').value = name;
        document.getElementById('editPrice').value = price;
        document.getElementById('editDuration').value = duration;
        document.getElementById('editDesc').value = desc; // Textarea bisa pakai .value

        var myModal = new bootstrap.Modal(document.getElementById('modalEditPackage'));
        myModal.show();
    }
</script>