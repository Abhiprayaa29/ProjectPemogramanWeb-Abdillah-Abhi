<?php 
$pageTitle = "Cari Fotografer - JogjaLensa";
require_once 'includes/koneksi.php'; 
include 'components/header.php';
include 'components/navbar.php';

// --- 1. TANGKAP INPUT DARI FORM (GET) ---
$keyword  = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';
$category = isset($_GET['cat']) ? $_GET['cat'] : '';
$location = isset($_GET['loc']) ? $_GET['loc'] : '';
$sort     = isset($_GET['sort']) ? $_GET['sort'] : 'az'; // Default A-Z

// --- 2. BANGUN QUERY DINAMIS ---
// Base Query: Join Vendor dengan Package untuk dapat harga terendah
$sql = "SELECT v.*, MIN(p.price) as start_price 
        FROM vendors v 
        LEFT JOIN packages p ON v.id = p.vendor_id 
        WHERE 1=1"; // "WHERE 1=1" trik agar mudah nambah "AND"

// Tambahkan Logika Filter jika ada input
if (!empty($keyword)) {
    $sql .= " AND (v.brand_name LIKE '%$keyword%' OR v.description LIKE '%$keyword%')";
}
if (!empty($category)) {
    $sql .= " AND v.category = '$category'";
}
if (!empty($location)) {
    $sql .= " AND v.location = '$location'";
}

// Grouping agar vendor tidak muncul double
$sql .= " GROUP BY v.id";

// Tambahkan Logika Sorting
switch ($sort) {
    case 'za':
        $sql .= " ORDER BY v.brand_name DESC";
        break;
    case 'cheap':
        $sql .= " ORDER BY start_price ASC";
        break;
    case 'expensive':
        $sql .= " ORDER BY start_price DESC";
        break;
    default: // 'az'
        $sql .= " ORDER BY v.brand_name ASC";
        break;
}

// Eksekusi Query
$vendors = query($sql);
?>

<div class="bg-light py-5 mb-4 border-bottom">
    <div class="container pt-5 pb-2">
        <h1 class="fw-bold mb-2">Temukan Fotografer</h1>
        <p class="text-muted">
            Menampilkan <strong><?php echo count($vendors); ?></strong> hasil 
            <?php if($keyword) echo "untuk pencarian \"".htmlspecialchars($keyword)."\""; ?>
        </p>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-4">
        
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 100px; z-index: 10;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold m-0"><i class="bi bi-sliders2 me-2"></i>Filter</h5>
                    <a href="pencarian.php" class="small text-decoration-none text-danger fw-bold">Reset</a>
                </div>
                
                <form action="pencarian.php" method="GET">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary text-uppercase ls-1">Kata Kunci</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                            <input type="text" name="q" class="form-control border-start-0" placeholder="Nama Vendor..." value="<?php echo htmlspecialchars($keyword); ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary text-uppercase ls-1">Kategori</label>
                        <select name="cat" class="form-select">
                            <option value="">Semua Kategori</option>
                            <option value="Wisuda" <?php if($category == 'Wisuda') echo 'selected'; ?>>Wisuda</option>
                            <option value="Wedding" <?php if($category == 'Wedding') echo 'selected'; ?>>Wedding</option>
                            <option value="Event" <?php if($category == 'Event') echo 'selected'; ?>>Event</option>
                            <option value="Produk" <?php if($category == 'Produk') echo 'selected'; ?>>Produk</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary text-uppercase ls-1">Domisili</label>
                        <select name="loc" class="form-select">
                            <option value="">Semua Lokasi</option>
                            <option value="Sleman" <?php if($location == 'Sleman') echo 'selected'; ?>>Sleman</option>
                            <option value="Bantul" <?php if($location == 'Bantul') echo 'selected'; ?>>Bantul</option>
                            <option value="Kota Yogyakarta" <?php if($location == 'Kota Yogyakarta') echo 'selected'; ?>>Kota Yogyakarta</option>
                            <option value="Kulon Progo" <?php if($location == 'Kulon Progo') echo 'selected'; ?>>Kulon Progo</option>
                            <option value="Gunung Kidul" <?php if($location == 'Gunung Kidul') echo 'selected'; ?>>Gunung Kidul</option>
                        </select>
                    </div>

                    <hr class="border-light my-4">

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary text-uppercase ls-1">Urutkan</label>
                        <div class="d-grid gap-2">
                            <input type="radio" class="btn-check" name="sort" id="sort1" value="az" <?php if($sort == 'az') echo 'checked'; ?>>
                            <label class="btn btn-outline-light text-dark text-start btn-sm border" for="sort1"><i class="bi bi-sort-alpha-down me-2"></i> Nama (A-Z)</label>

                            <input type="radio" class="btn-check" name="sort" id="sort2" value="za" <?php if($sort == 'za') echo 'checked'; ?>>
                            <label class="btn btn-outline-light text-dark text-start btn-sm border" for="sort2"><i class="bi bi-sort-alpha-up me-2"></i> Nama (Z-A)</label>

                            <input type="radio" class="btn-check" name="sort" id="sort3" value="cheap" <?php if($sort == 'cheap') echo 'checked'; ?>>
                            <label class="btn btn-outline-light text-dark text-start btn-sm border" for="sort3"><i class="bi bi-sort-numeric-down me-2"></i> Harga Terendah</label>

                            <input type="radio" class="btn-check" name="sort" id="sort4" value="expensive" <?php if($sort == 'expensive') echo 'checked'; ?>>
                            <label class="btn btn-outline-light text-dark text-start btn-sm border" for="sort4"><i class="bi bi-sort-numeric-up-alt me-2"></i> Harga Tertinggi</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold shadow-sm">Terapkan Filter</button>
                </form>
            </div>
        </div>

        <div class="col-lg-9">
            
            <?php if(count($vendors) == 0): ?>
                <div class="text-center py-5 bg-white rounded-4 border border-dashed">
                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486754.png" width="120" class="mb-3 opacity-50" alt="Empty">
                    <h4 class="fw-bold text-secondary">Tidak ditemukan</h4>
                    <p class="text-muted mb-0">Coba ubah filter atau kata kunci pencarianmu.</p>
                    <a href="pencarian.php" class="btn btn-link text-decoration-none mt-2">Reset Pencarian</a>
                </div>
            <?php endif; ?>

            <div class="row g-3">
                <?php foreach($vendors as $v): ?>
                <div class="col-md-6 col-xl-4">
                    <a href="profile.php?id=<?php echo $v['id']; ?>" class="text-decoration-none text-dark">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow transition position-relative">
                            
                            <div class="position-relative" style="height: 200px;">
                                <img src="<?php echo $v['cover_img']; ?>" class="w-100 h-100 object-fit-cover" alt="<?php echo $v['brand_name']; ?>">
                                
                                <div class="position-absolute top-0 start-0 w-100 p-2 d-flex justify-content-between align-items-start">
                                    <span class="badge bg-white text-dark shadow-sm rounded-pill px-2 py-1 small fw-normal">
                                        <?php echo $v['category']; ?>
                                    </span>
                                    <span class="badge bg-white text-warning shadow-sm rounded-pill px-2 py-1 small fw-bold">
                                        <i class="bi bi-star-fill"></i> 4.9
                                    </span>
                                </div>
                            </div>

                            <div class="card-body p-3">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="<?php echo $v['profile_img']; ?>" class="rounded-circle border me-2 object-fit-cover" width="40" height="40">
                                    <div class="overflow-hidden">
                                        <h6 class="card-title fw-bold mb-0 text-truncate"><?php echo $v['brand_name']; ?></h6>
                                        <small class="text-muted d-block text-truncate">
                                            <i class="bi bi-geo-alt-fill text-danger me-1"></i> <?php echo $v['location']; ?>
                                        </small>
                                    </div>
                                </div>

                                <hr class="border-light my-2">
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small" style="font-size: 0.75rem;">Mulai dari</span>
                                    <span class="fw-bold text-primary">
                                        <?php echo ($v['start_price'] > 0) ? formatRupiah($v['start_price']) : 'Hubungi Admin'; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>