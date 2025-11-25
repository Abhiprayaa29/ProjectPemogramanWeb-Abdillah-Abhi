<?php
// File: logic/logicvendor/proses_tambah_foto_portofolio.php
// NOTE: sesuaikan path requires jika struktur foldermu beda
// Referensi screenshot (lokal): sandbox:/mnt/data/Screenshot 2025-11-24 212639.png
// Referensi screenshot (lokal): sandbox:/mnt/data/Screenshot 2025-11-24 212650.png

session_start();
require_once '../../includes/koneksi.php'; // sesuaikan jika path berbeda

// Pastikan vendor login
if (!isset($_SESSION['is_login']) || $_SESSION['user_role'] !== 'vendor') {
    header("Location: ../../login.php");
    exit;
}

// Ambil input
$vendor_id_post = isset($_POST['vendor_id']) ? intval($_POST['vendor_id']) : 0;
// Validasi vendor yang login
$user_id = $_SESSION['user_id'];
$qv = mysqli_query($conn, "SELECT id FROM vendors WHERE user_id = '".mysqli_real_escape_string($conn, $user_id)."' LIMIT 1");
if (!$qv || mysqli_num_rows($qv) == 0) {
    $_SESSION['flash_error'] = "Vendor tidak ditemukan.";
    header("Location: ../../portofolio.php");
    exit;
}
$vendor = mysqli_fetch_assoc($qv);
$vendor_id = $vendor['id'];

if ($vendor_id != $vendor_id_post) {
    $_SESSION['flash_error'] = "Akses tidak valid.";
    header("Location: ../../portofolio.php");
    exit;
}

// Cek file upload
if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
    $_SESSION['flash_error'] = "File foto tidak ditemukan atau terjadi error.";
    header("Location: ../../portofolio.php");
    exit;
}

$file = $_FILES['photo'];

// Validasi tipe file
$allowed_mimes = ['image/jpeg','image/jpg','image/png','image/webp'];
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

if (!in_array($mime, $allowed_mimes)) {
    $_SESSION['flash_error'] = "Format file tidak didukung. Gunakan JPG, PNG, atau WEBP.";
    header("Location: ../../portofolio.php");
    exit;
}

// batas max 5MB
$maxSize = 5 * 1024 * 1024;
if ($file['size'] > $maxSize) {
    $_SESSION['flash_error'] = "Ukuran file terlalu besar (max 5MB).";
    header("Location: ../../portofolio.php");
    exit;
}

// siapkan folder upload (pastikan folder berada di public root sehingga dapat diakses web)
$uploadDir = __DIR__ . '/../../uploads/portofolio/';
if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0755, true)) {
        $_SESSION['flash_error'] = "Gagal membuat folder upload.";
        header("Location: ../../portofolio.php");
        exit;
    }
}

// buat nama file unik dan aman
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
$ext = preg_replace('/[^a-z0-9]/', '', $ext); // simple sanitize
$filename = 'portofolio_' . $vendor_id . '_' . time() . '.' . $ext;
$target = $uploadDir . $filename;

// pindahkan file
if (!move_uploaded_file($file['tmp_name'], $target)) {
    $_SESSION['flash_error'] = "Gagal menyimpan file.";
    header("Location: ../../portofolio.php");
    exit;
}

// Path relatif untuk disimpan di DB (sesuaikan jika ingin menyimpan URL lengkap)
$photoPath = 'uploads/portofolio/' . $filename;

// Insert ke DB
// Sesuaikan nama kolom: contoh kolom di tabel portofolio (id_vendor, nama, description, link, photo)
$sql = "INSERT INTO `portofolio` (`id_vendor`, `photo`) VALUES (
    '".intval($vendor_id)."',
    '".mysqli_real_escape_string($conn, $photoPath)."'
)";

if (mysqli_query($conn, $sql)) {
    $_SESSION['flash_success'] = "Foto portofolio berhasil diupload.";
} else {
    // hapus file jika gagal insert
    if (file_exists($target)) unlink($target);
    $_SESSION['flash_error'] = "Gagal menyimpan data ke database: " . mysqli_error($conn);
}

header("Location: ../../portofolio.php");
exit;
