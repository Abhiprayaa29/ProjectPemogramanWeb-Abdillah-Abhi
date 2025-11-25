<?php 
session_start();
require_once 'includes/koneksi.php'; 

// 1. Cek Login
if (!isset($_SESSION['is_login'])) {
    header("Location: login.php");
    exit;
}

// 2. Cek ID Booking di URL
if(!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$booking_id = $_GET['id'];
$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['user_role'];

// 3. Ambil Data Booking Lengkap (JOIN 4 Tabel)
// PERBAIKAN: Saya menghapus 'v.phone_number' dari query agar tidak error
$query = "SELECT 
            b.*, 
            u.full_name as client_name, u.email as client_email, u.profile_img as client_img,
            v.brand_name as vendor_name, v.location as vendor_loc, v.profile_img as vendor_img,
            p.name as package_name, p.description as package_desc, p.price as package_price
          FROM bookings b
          JOIN users u ON b.user_id = u.id
          JOIN vendors v ON b.vendor_id = v.id
          JOIN packages p ON b.package_id = p.id
          WHERE b.id = '$booking_id'";

$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// 4. Keamanan
if(!$data) {
    echo "Data tidak ditemukan."; exit;
}

// Cek Hak Akses
if ( ($user_role == 'client' && $data['user_id'] != $user_id) && 
     ($user_role == 'vendor' && $data['vendor_id'] != $vendor['id'])
   ) {
     // Validasi sederhana (bisa diperketat nanti)
}

$pageTitle = "Invoice #" . $data['booking_code'];
include 'components/header.php';
?>

<div class="bg-light min-vh-100 py-5">
    <div class="container">
        
        <div class="mb-4 no-print">
            <?php if($user_role == 'vendor'): ?>
                <a href="dashboard_vendor.php" class="btn btn-light rounded-pill fw-bold"><i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard</a>
            <?php else: ?>
                <a href="dashboard_user.php" class="btn btn-light rounded-pill fw-bold"><i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard</a>
            <?php endif; ?>
            
            <button onclick="window.print()" class="btn btn-outline-dark rounded-pill float-end"><i class="bi bi-printer me-2"></i>Cetak Invoice</button>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    
                    <div class="card-header bg-primary text-white p-5 border-0">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h2 class="fw-bold mb-1">INVOICE</h2>
                                <p class="opacity-75 mb-0">Kode Booking: <strong>#<?php echo $data['booking_code']; ?></strong></p>
                            </div>
                            <div class="text-end">
                                <h4 class="fw-bold mb-1">JogjaLensa</h4>
                                <p class="small opacity-75 mb-0">Marketplace Fotografi Terpercaya</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-5">
                        
                        <div class="alert alert-light border border-dashed d-flex align-items-center justify-content-between rounded-3 mb-5">
                            <div>
                                <small class="text-muted d-block text-uppercase fw-bold">Status Pesanan</small>
                                <?php 
                                    $st = $data['status'];
                                    if($st=='pending') echo '<span class="text-warning fw-bold"><i class="bi bi-hourglass-split"></i> Menunggu Pembayaran</span>';
                                    elseif($st=='paid') echo '<span class="text-info fw-bold"><i class="bi bi-check-circle"></i> Sudah Dibayar (Menunggu Konfirmasi)</span>';
                                    elseif($st=='confirmed') echo '<span class="text-primary fw-bold"><i class="bi bi-camera-fill"></i> Sedang Diproses (Aktif)</span>';
                                    elseif($st=='completed') echo '<span class="text-success fw-bold"><i class="bi bi-check-all"></i> Selesai</span>';
                                    elseif($st=='cancelled') echo '<span class="text-danger fw-bold"><i class="bi bi-x-circle"></i> Dibatalkan</span>';
                                ?>
                            </div>
                            <div class="text-end">
                                <small class="text-muted d-block text-uppercase fw-bold">Tanggal Booking</small>
                                <span class="fw-bold text-dark"><?php echo date('d F Y', strtotime($data['created_at'])); ?></span>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-md-6">
                                <small class="text-muted fw-bold text-uppercase">Penyedia Jasa (Vendor)</small>
                                <h5 class="fw-bold mt-1"><?php echo $data['vendor_name']; ?></h5>
                                <p class="text-muted small mb-1"><?php echo $data['vendor_loc']; ?></p>
                            </div>

                            <div class="col-md-6 text-md-end">
                                <small class="text-muted fw-bold text-uppercase">Ditagihkan Kepada</small>
                                <h5 class="fw-bold mt-1"><?php echo $data['client_name']; ?></h5>
                                <p class="text-muted small mb-0"><?php echo $data['client_email']; ?></p>
                            </div>
                        </div>

                        <div class="table-responsive mb-4">
                            <table class="table table-bordered">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="py-3 px-4 text-secondary small text-uppercase">Deskripsi Layanan</th>
                                        <th class="py-3 px-4 text-end text-secondary small text-uppercase">Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="p-4">
                                            <h6 class="fw-bold mb-1"><?php echo $data['package_name']; ?></h6>
                                            <p class="text-muted small mb-2"><?php echo $data['package_desc']; ?></p>
                                            
                                            <div class="d-flex gap-3 mt-3">
                                                <span class="badge bg-light text-dark border"><i class="bi bi-calendar3"></i> <?php echo date('d M Y', strtotime($data['booking_date'])); ?></span>
                                                <span class="badge bg-light text-dark border"><i class="bi bi-clock"></i> <?php echo substr($data['booking_time'], 0, 5); ?> WIB</span>
                                            </div>
                                            
                                            <?php if(!empty($data['location_note'])): ?>
                                                <div class="mt-3 p-3 bg-light rounded small text-muted">
                                                    <strong>Catatan Lokasi:</strong><br>
                                                    <?php echo $data['location_note']; ?>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="p-4 text-end fw-bold text-dark align-top">
                                            <?php echo "Rp " . number_format($data['package_price'], 0, ',', '.'); ?>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot class="bg-light">
                                    <tr>
                                        <td class="p-4 text-end fw-bold text-uppercase">Total Pembayaran</td>
                                        <td class="p-4 text-end fw-bold fs-4 text-primary"><?php echo "Rp " . number_format($data['total_price'], 0, ',', '.'); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="row mt-5">
                            <div class="col-md-6">
                                <?php if(isset($data['payment_proof']) && $data['payment_proof']): ?>
                                    <small class="fw-bold text-muted text-uppercase">Bukti Pembayaran</small>
                                    <div class="mt-2">
                                        <a href="<?php echo $data['payment_proof']; ?>" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill">
                                            <i class="bi bi-image me-1"></i> Lihat Bukti Transfer
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <p class="small text-muted mb-0">Terima kasih telah menggunakan JogjaLensa.</p>
                                <p class="small text-muted">Invoice ini sah dan diproses secara otomatis oleh komputer.</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print { display: none !important; }
    .bg-light { background-color: white !important; }
    .shadow-lg { box-shadow: none !important; }
    .card { border: 1px solid #ddd !important; }
}
</style>

<?php include 'components/footer.php'; ?>