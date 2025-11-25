<?php 
session_start();
// 1. Cek Login
if (!isset($_SESSION['is_login']) || $_SESSION['is_login'] !== true) {
    header("Location: login.php");
    exit;
}

$pageTitle = "Dashboard Saya - JogjaLensa";
require_once 'includes/koneksi.php'; 
include 'components/header.php';
include 'components/navbar.php';

// 2. Ambil Data User
$user_id = $_SESSION['user_id'];
$user_query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
$user_data = mysqli_fetch_assoc($user_query);

// 3. Ambil Data Booking
$query_booking = "SELECT 
                    b.*, 
                    v.brand_name, 
                    v.profile_img, 
                    p.name as package_name,
                    r.id as review_id 
                  FROM bookings b
                  JOIN vendors v ON b.vendor_id = v.id
                  JOIN packages p ON b.package_id = p.id
                  LEFT JOIN reviews r ON b.id = r.booking_id 
                  WHERE b.user_id = '$user_id'
                  ORDER BY b.created_at DESC";
$bookings = query($query_booking);

// 4. Hitung Statistik
$total_spent = 0;
$waiting_confirm = 0; // Diganti dari waiting_payment
$completed_orders = 0;

foreach($bookings as $b) {
    if($b['status'] == 'completed') { $total_spent += $b['total_price']; $completed_orders++; }
    if($b['status'] == 'pending') { $waiting_confirm++; }
}
?>

<div class="bg-light min-vh-100 pb-5">
    
    <div class="bg-primary pt-5 pb-5">
        <div class="container pt-5">
            <div class="row align-items-center text-white">
                <div class="col-md-8">
                    <h2 class="fw-bold">Halo, <?php echo $user_data['full_name']; ?>! 👋</h2>
                    <p class="opacity-75 mb-0">Selamat datang kembali di dashboard pesananmu.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="margin-top: -30px;">
        <div class="row">
            
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 100px; z-index: 1;">
                    <div class="text-center">
                        <div class="position-relative d-inline-block mb-3">
                            <img src="<?php echo $user_data['profile_img'] ?>" class="rounded-circle shadow-sm p-1 bg-white object-fit-cover" width="100" height="100" alt="User">
                        </div>
                        <h5 class="fw-bold mb-1 text-truncate"><?php echo $user_data['full_name']; ?></h5>
                        <p class="text-muted small mb-2 text-truncate"><?php echo $user_data['email']; ?></p>
                        
                        <span class="badge bg-warning text-dark rounded-pill px-3 mb-3">
                            <i class="bi bi-person-badge me-1"></i> <?php echo ucfirst($user_data['role']); ?>
                        </span>
                        <div class="d-grid">
                            <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill fw-bold"><i class="bi bi-box-arrow-right me-2"></i>Keluar</a>
                        </div>
                    </div>
                    
                    <hr class="my-4 border-light">
                    
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action border-0 rounded-3 active bg-primary bg-opacity-10 text-primary fw-bold mb-1"><i class="bi bi-grid-fill me-3"></i>Dashboard</a>
                        
                        <button type="button" class="list-group-item list-group-item-action border-0 rounded-3 text-muted mb-1" data-bs-toggle="modal" data-bs-target="#modalEditProfil">
                            <i class="bi bi-person-gear me-3"></i>Edit Profil
                        </button>
                        
                        <button type="button" class="list-group-item list-group-item-action border-0 rounded-3 text-muted" data-bs-toggle="modal" data-bs-target="#modalGantiPassword">
                            <i class="bi bi-shield-lock me-3"></i>Ganti Password
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 text-success rounded-circle p-3 me-3"><i class="bi bi-wallet2 fs-4"></i></div>
                                    <div><p class="text-muted small mb-0 fw-bold">TOTAL TRANSAKSI</p><h5 class="fw-bold mb-0"><?php echo formatRupiah($total_spent); ?></h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-3 me-3"><i class="bi bi-hourglass-split fs-4"></i></div>
                                    <div><p class="text-muted small mb-0 fw-bold">MENUNGGU KONFIRMASI</p><h5 class="fw-bold mb-0"><?php echo $waiting_confirm; ?> Pesanan</h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3"><i class="bi bi-check-circle-fill fs-4"></i></div>
                                    <div><p class="text-muted small mb-0 fw-bold">SELESAI</p><h5 class="fw-bold mb-0"><?php echo $completed_orders; ?> Project</h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Riwayat Pesanan Terbaru</h5>
                        <a href="index.php" class="btn btn-primary btn-sm rounded-pill px-3"><i class="bi bi-plus-lg me-1"></i> Pesan Lagi</a>
                    </div>
                    
                    <div class="card-body p-0">
                        <?php if(count($bookings) > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light text-secondary small text-uppercase">
                                        <tr>
                                            <th class="px-4 py-3">Vendor & Paket</th>
                                            <th class="py-3">Tanggal</th>
                                            <th class="py-3 text-center">Status</th>
                                            <th class="px-4 py-3 text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($bookings as $row): ?>
                                        <tr>
                                            <td class="px-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <img src="<?php echo $row['profile_img']; ?>" class="rounded-3 me-3 object-fit-cover shadow-sm" width="50" height="50">
                                                    <div>
                                                        <div class="fw-bold text-dark"><?php echo $row['brand_name']; ?></div>
                                                        <div class="small text-primary"><?php echo $row['package_name']; ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-muted small">
                                                <div class="fw-bold text-dark"><?php echo date('d M Y', strtotime($row['booking_date'])); ?></div>
                                                <div><?php echo date('H:i', strtotime($row['booking_time'])); ?> WIB</div>
                                            </td>
                                            <td class="text-center">
                                                <?php 
                                                    $status = $row['status'];
                                                    // Logic Status tanpa 'paid'
                                                    if($status == 'pending') {
                                                        echo "<span class='badge bg-warning text-dark bg-opacity-25 border border-warning rounded-pill px-3'>Menunggu Konfirmasi</span>";
                                                    } elseif($status == 'confirmed') {
                                                        echo "<span class='badge bg-primary bg-opacity-10 text-primary border border-primary rounded-pill px-3'>Diproses Vendor</span>";
                                                    } elseif($status == 'completed') {
                                                        echo "<span class='badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3'>Selesai</span>";
                                                    } elseif($status == 'cancelled') {
                                                        echo "<span class='badge bg-secondary rounded-pill px-3'>Dibatalkan</span>";
                                                    }
                                                ?>
                                            </td>
                                            
                                            <td class="px-4 text-end">
                                                
                                                <?php if($status == 'completed'): ?>
                                                    <?php if($row['review_id']): ?>
                                                        <button class="btn btn-success btn-sm rounded-pill px-3" disabled>
                                                            <i class="bi bi-check-circle-fill me-1"></i> Selesai
                                                        </button>
                                                    <?php else: ?>
                                                        <button onclick="openReviewModal(<?php echo $row['id']; ?>, '<?php echo $row['brand_name']; ?>')" 
                                                                class="btn btn-warning btn-sm rounded-pill px-3 fw-bold shadow-sm">
                                                            <i class="bi bi-star-fill me-1"></i> Beri Rating
                                                        </button>
                                                    <?php endif; ?>

                                                <?php elseif($status == 'confirmed'): ?>
                                                    <a href="detail_booking.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                                        <i class="bi bi-info-circle me-1"></i> Detail
                                                    </a>

                                                <?php else: ?>
                                                    <a href="detail_booking.php?id=<?php echo $row['id']; ?>" class="btn btn-light btn-sm rounded-pill text-muted border">Detail</a>
                                                <?php endif; ?>
                                                
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <p class="text-muted mb-4">Belum ada riwayat pesanan.</p>
                                <a href="index.php" class="btn btn-outline-primary rounded-pill px-4">Cari Fotografer</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditProfil" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-0 px-4 pt-4">
                <h5 class="modal-title fw-bold">Edit Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <form action="logic/logicuser/proses_update_profile.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">NAMA LENGKAP</label>
                        <input type="text" name="fullname" class="form-control form-control-lg bg-light border-0" value="<?php echo $user_data['full_name']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">EMAIL</label>
                        <input type="email" name="email" class="form-control form-control-lg bg-light border-0" value="<?php echo $user_data['email']; ?>" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary">URL FOTO PROFIL</label>
                        <input type="text" name="profile_img" class="form-control form-control-lg bg-light border-0" value="<?php echo $user_data['profile_img']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalGantiPassword" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-0 px-4 pt-4">
                <h5 class="modal-title fw-bold">Ganti Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <form action="logic/logicuser/proses_update_password.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">PASSWORD LAMA</label>
                        <input type="password" name="old_password" class="form-control form-control-lg bg-light border-0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">PASSWORD BARU</label>
                        <input type="password" name="new_password" class="form-control form-control-lg bg-light border-0" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary">ULANGI PASSWORD BARU</label>
                        <input type="password" name="confirm_new_password" class="form-control form-control-lg bg-light border-0" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalReview" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-0 px-4 pt-4">
                <h5 class="modal-title fw-bold">Beri Ulasan & Rating</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <form action="logic/logicuser/proses_review.php" method="POST">
                    <input type="hidden" name="booking_id" id="reviewBookingId">
                    
                    <p class="text-muted small mb-3">Bagaimana pengalamanmu dengan <strong id="reviewVendorName" class="text-dark">Vendor</strong>?</p>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">RATING</label>
                        <select name="rating" class="form-select form-select-lg bg-light border-0 text-warning fw-bold">
                            <option value="5">⭐⭐⭐⭐⭐ (Sempurna)</option>
                            <option value="4">⭐⭐⭐⭐ (Bagus)</option>
                            <option value="3">⭐⭐⭐ (Cukup)</option>
                            <option value="2">⭐⭐ (Kurang)</option>
                            <option value="1">⭐ (Buruk)</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary">KOMENTAR</label>
                        <textarea name="comment" class="form-control bg-light border-0" rows="3" placeholder="Ceritakan kepuasan hasil fotonya..." required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-warning w-100 rounded-pill fw-bold shadow-sm">Kirim Ulasan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>

<script>
function openReviewModal(bookingId, vendorName) {
    document.getElementById('reviewBookingId').value = bookingId;
    document.getElementById('reviewVendorName').innerText = vendorName;
    var myModal = new bootstrap.Modal(document.getElementById('modalReview'));
    myModal.show();
}
</script>