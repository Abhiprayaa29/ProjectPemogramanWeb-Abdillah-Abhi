<?php 
session_start();
require_once 'includes/koneksi.php';

// 1. Cek Login & Role Vendor
if (!isset($_SESSION['is_login']) || $_SESSION['user_role'] !== 'vendor') {
    header("Location: login.php");
    exit;
}

$pageTitle = "Dashboard Vendor - JogjaLensa";
$currentPage = "dashboard"; 

include 'components/header.php';
include 'components/navbar.php';

$user_id = $_SESSION['user_id'];

// 2. Ambil Data Vendor ID
$query_vendor = mysqli_query($conn, "SELECT * FROM vendors WHERE user_id = '$user_id'");
$vendor_data = mysqli_fetch_assoc($query_vendor);
$vendor_id = $vendor_data['id'];

// 3. Ambil Pesanan Masuk
$query_orders = "SELECT b.*, u.profile_img, u.full_name as client_name, u.email as client_email, p.name as package_name 
                 FROM bookings b
                 JOIN users u ON b.user_id = u.id
                 JOIN packages p ON b.package_id = p.id
                 WHERE b.vendor_id = '$vendor_id'
                 ORDER BY b.created_at DESC";
$orders = query($query_orders);

// 4. Hitung Pendapatan
$income = 0;
$total_jobs = 0;
foreach($orders as $o) {
    if($o['status'] == 'completed') {
        $income += $o['total_price'];
        $total_jobs++;
    }
}

// 5. AMBIL DATA ULASAN & RATING (BARU)
$query_reviews = "SELECT r.*, u.full_name 
                  FROM reviews r 
                  JOIN bookings b ON r.booking_id = b.id 
                  JOIN users u ON b.user_id = u.id 
                  WHERE b.vendor_id = '$vendor_id' 
                  ORDER BY r.created_at DESC";
$reviews = query($query_reviews);

// Hitung Rata-rata
$total_stars = 0;
$count_reviews = count($reviews);
$average_rating = 0;

if($count_reviews > 0){
    foreach($reviews as $rev){
        $total_stars += $rev['rating'];
    }
    $average_rating = round($total_stars / $count_reviews, 1);
}
?>

<div class="bg-light min-vh-100 pb-5" style="padding-top: 100px;">
    <div class="container">
        
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden bg-white">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <img src="<?php echo $vendor_data['profile_img']; ?>" class="rounded-circle me-3 border border-2 border-white shadow-sm object-fit-cover" width="70" height="70">
                    <div>
                        <h4 class="fw-bold mb-0"><?php echo $vendor_data['brand_name']; ?></h4>
                        <p class="text-muted mb-0 small">
                            <i class="bi bi-geo-alt-fill text-danger me-1"></i> <?php echo $vendor_data['location']; ?> 
                            &bull; <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10 rounded-pill px-2"><?php echo $vendor_data['category']; ?></span>
                        </p>
                    </div>
                    <div class="ms-auto d-none d-md-block">
                        <a href="profile.php?id=<?php echo $vendor_id; ?>" class="btn btn-outline-primary rounded-pill btn-sm fw-bold px-3">
                            <i class="bi bi-eye me-1"></i> Lihat Profil Publik
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            
            <?php include 'components/vendor_sidebar.php'; ?>

            <div class="col-lg-9">
                
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 bg-success text-white h-100 overflow-hidden position-relative">
                            <div class="card-body p-4 position-relative z-1">
                                <h6 class="opacity-75 mb-1 text-uppercase ls-1" style="font-size: 0.7rem;">Total Pendapatan</h6>
                                <h2 class="fw-bold mb-0"><?php echo formatRupiah($income); ?></h2>
                            </div>
                            <i class="bi bi-wallet2 position-absolute end-0 bottom-0 mb-n2 me-3 text-white opacity-25" style="font-size: 4rem;"></i>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 bg-white h-100 overflow-hidden position-relative">
                            <div class="card-body p-4 position-relative z-1">
                                <h6 class="text-muted mb-1 text-uppercase ls-1" style="font-size: 0.7rem;">Pekerjaan Selesai</h6>
                                <h2 class="fw-bold mb-0 text-dark"><?php echo $total_jobs; ?> <span class="fs-6 fw-normal text-muted">Project</span></h2>
                            </div>
                            <i class="bi bi-camera-reels position-absolute end-0 bottom-0 mb-n2 me-3 text-secondary opacity-10" style="font-size: 4rem;"></i>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 bg-white h-100 overflow-hidden position-relative">
                            <div class="card-body p-4 position-relative z-1">
                                <h6 class="text-muted mb-1 text-uppercase ls-1" style="font-size: 0.7rem;">Rating Rata-rata</h6>
                                <div class="d-flex align-items-end">
                                    <h2 class="fw-bold mb-0 text-warning"><?php echo $average_rating; ?></h2>
                                    <span class="text-muted small ms-2 mb-1">/ 5.0 (<?php echo $count_reviews; ?>)</span>
                                </div>
                            </div>
                            <i class="bi bi-star-fill position-absolute end-0 bottom-0 mb-n2 me-3 text-warning opacity-25" style="font-size: 4rem;"></i>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Pesanan Masuk</h5>
                        <span class="badge bg-light text-dark border rounded-pill px-3"><?php echo count($orders); ?> Total</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light text-secondary small text-uppercase">
                                    <tr>
                                        <th class="px-4 py-3">Klien</th>
                                        <th>Jadwal</th>
                                        <th>Paket & Status</th>
                                        <th class="text-end px-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(count($orders) > 0): ?>
                                        <?php foreach($orders as $order): ?>
                                        <tr>
                                            <td class="px-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="position-relative d-inline-block mb-3">
                                                        <img src="<?php echo $order['profile_img'] ?>" class="rounded-circle shadow-sm p-1 bg-white object-fit-cover" width="50" height="50" alt="User">
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-dark"><?php echo $order['client_name']; ?></div>
                                                        <div class="small text-muted text-truncate" style="max-width: 150px;"><?php echo $order['client_email']; ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="small fw-bold text-dark"><i class="bi bi-calendar3 me-1 text-primary"></i> <?php echo $order['booking_date']; ?></div>
                                                <div class="small text-muted"><i class="bi bi-clock me-1"></i> <?php echo substr($order['booking_time'],0,5); ?> WIB</div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-primary border border-primary border-opacity-10 mb-1"><?php echo $order['package_name']; ?></span>
                                                <div class="small fw-bold text-dark mb-1"><?php echo formatRupiah($order['total_price']); ?></div>
                                                <?php 
                                                $st = $order['status'];
                                                if($st=='pending') echo '<span class="badge bg-warning text-dark bg-opacity-25 border border-warning rounded-pill">Menunggu</span>';
                                                elseif($st=='confirmed') echo '<span class="badge bg-primary bg-opacity-10 text-primary border border-primary rounded-pill">Aktif</span>';
                                                elseif($st=='completed') echo '<span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill">Selesai</span>';
                                                elseif($st=='cancelled') echo '<span class="badge bg-secondary rounded-pill">Dibatalkan</span>';
                                                ?>
                                            </td>
                                            <td class="text-end px-4">
                                                <?php if($st == 'pending'): ?>
                                                    <div class="btn-group">
                                                        <a href="logic/logicvendor/proses_update_status.php?id=<?php echo $order['id']; ?>&status=confirmed" class="btn btn-sm btn-outline-success fw-bold" onclick="return confirm('Terima pesanan ini?')"><i class="bi bi-check-lg"></i> Terima</a>
                                                        <a href="logic/logicvendor/proses_update_status.php?id=<?php echo $order['id']; ?>&status=cancelled" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tolak pesanan?')"><i class="bi bi-x-lg"></i></a>
                                                    </div>
                                                <?php elseif($st == 'confirmed'): ?>
                                                    <a href="logic/logicvendor/proses_update_status.php?id=<?php echo $order['id']; ?>&status=completed" class="btn btn-sm btn-primary rounded-pill fw-bold px-3" onclick="return confirm('Tandai selesai?')"><i class="bi bi-check-circle-fill me-1"></i> Selesaikan</a>
                                                <?php else: ?>
                                                    <a href="detail_booking.php?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-light rounded-pill text-muted border px-3">Detail</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada pesanan masuk.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-0 py-4 px-4">
                        <h5 class="fw-bold mb-0">Ulasan Terbaru</h5>
                    </div>
                    <div class="card-body p-4 pt-0">
                        <?php if($count_reviews > 0): ?>
                            <?php foreach(array_slice($reviews, 0, 5) as $rev): ?>
                            <div class="border-bottom pb-3 mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <div class="fw-bold text-dark"><?php echo $rev['full_name']; ?></div>
                                    <div class="text-warning small">
                                        <?php for($i=0; $i<$rev['rating']; $i++) echo '<i class="bi bi-star-fill"></i>'; ?>
                                    </div>
                                </div>
                                <p class="text-muted small mb-1 fst-italic">"<?php echo $rev['comment']; ?>"</p>
                                <small class="text-secondary" style="font-size: 0.7rem;"><?php echo date('d M Y', strtotime($rev['created_at'])); ?></small>
                            </div>
                            <?php endforeach; ?>
                            
                            <?php if($count_reviews > 5): ?>
                                <div class="text-center mt-3">
                                    <a href="profile.php?id=<?php echo $vendor_id; ?>" class="text-decoration-none fw-bold small">Lihat Semua Ulasan</a>
                                </div>
                            <?php endif; ?>

                        <?php else: ?>
                            <div class="text-center py-4 text-muted">
                                <i class="bi bi-chat-square-text fs-2 opacity-25 mb-2 d-block"></i>
                                Belum ada ulasan dari klien.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>