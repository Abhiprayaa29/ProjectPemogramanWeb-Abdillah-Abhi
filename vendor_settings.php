<?php 
session_start();
require_once 'includes/koneksi.php';

if (!isset($_SESSION['is_login']) || $_SESSION['user_role'] !== 'vendor') {
    header("Location: login.php"); exit;
}

$pageTitle = "Pengaturan Studio - JogjaLensa";
$currentPage = "settings";
include 'components/header.php';
include 'components/navbar.php';

$user_id = $_SESSION['user_id'];
$vendor = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM vendors WHERE user_id = '$user_id'"));
?>

<div class="bg-light min-vh-100 pb-5" style="padding-top: 100px;">
    <div class="container">
        <div class="row g-4">
            
            <?php include 'components/vendor_sidebar.php'; ?>

            <div class="col-lg-9">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0">Edit Profil Studio</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="logic/logicvendor/proses_update_vendor.php" method="POST">
                            <input type="hidden" name="vendor_id" value="<?php echo $vendor['id']; ?>">
                            
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary">NAMA BRAND</label>
                                <input type="text" name="brand_name" class="form-control" value="<?php echo $vendor['brand_name']; ?>" required>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-secondary">KATEGORI</label>
                                    <select name="category" class="form-select">
                                        <option value="Wisuda" <?php if($vendor['category']=='Wisuda') echo 'selected'; ?>>Wisuda</option>
                                        <option value="Wedding" <?php if($vendor['category']=='Wedding') echo 'selected'; ?>>Wedding</option>
                                        <option value="Event" <?php if($vendor['category']=='Event') echo 'selected'; ?>>Event</option>
                                        <option value="Event" <?php if($vendor['category']=='Event') echo 'selected'; ?>>Produk</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-secondary">LOKASI</label>
                                    <select name="location" class="form-select">
                                        <option value="Sleman" <?php if($vendor['location']=='Sleman') echo 'selected'; ?>>Sleman</option>
                                        <option value="Bantul" <?php if($vendor['location']=='Bantul') echo 'selected'; ?>>Bantul</option>
                                        <option value="Kota Yogyakarta" <?php if($vendor['location']=='Kota Yogyakarta') echo 'selected'; ?>>Kota Yogyakarta</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary">INSTAGRAM</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">@</span>
                                    <input type="text" name="instagram" class="form-control" value="<?php echo $vendor['instagram']; ?>">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary">DESKRIPSI BIO</label>
                                <textarea name="description" class="form-control" rows="4"><?php echo $vendor['description']; ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary">FOTO PROFIL</label>
                                <input type="text" name="profile_url" class="form-control" value="<?php echo $vendor['profile_img']; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary">Preview</label> <br>
                                <label class="form-label small text-secondary" id="preview-img">Preview</label>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary">COVER</label>
                                <input type="text" name="cover_img" class="form-control" value="<?php echo $vendor['cover_img']; ?>" required>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-secondary">Preview</label> <br>
                                <label class="form-label small text-secondary" id="cover-img">Preview</label>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>

<script>
    // Preview Image
    const imgInput = document.querySelector('input[name="profile_url"]');
    const previewImg = document.getElementById('preview-img');

    imgInput.addEventListener('input', function() {
        const url = imgInput.value;
        if (url) {
            previewImg.innerHTML = `<img src="${url}" alt="Preview Image" class="img-fluid rounded-4 shadow-sm " style="height: 100px; width: 100px; object-fit: cover;">`;
        } else {
            previewImg.innerHTML = 'Silahkan masukkan URL gambar.';
        }
    });

    // Trigger input event on page load to show initial preview
    imgInput.dispatchEvent(new Event('input'));



    // Preview Image
    const imgInput1 = document.querySelector('input[name="cover_img"]');
    const previewImg1 = document.getElementById('cover-img');

    imgInput1.addEventListener('input', function() {
        const url = imgInput1.value;
        if (url) {
            previewImg1.innerHTML = `<img src="${url}" alt="Preview Image" class="img-fluid rounded-4 shadow-sm " style="height: 100px; width: 100px; object-fit: cover;">`;
        } else {
            previewImg1.innerHTML = 'Silahkan masukkan URL gambar.';
        }
    });

    // Trigger input event on page load to show initial preview
    imgInput1.dispatchEvent(new Event('input'));
</script>