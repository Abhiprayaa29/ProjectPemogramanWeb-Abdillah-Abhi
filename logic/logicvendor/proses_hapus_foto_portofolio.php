<?php
// File: logic/logicvendor/proses_hapus_foto_portofolio.php
// NOTE: ubah path require_once jika struktur foldermu berbeda
// Referensi file (contoh dari percakapan): /mnt/data/dee9bebd-7367-4b32-bc13-4aa6d62e50e9.png

session_start();
require_once '../../includes/koneksi.php'; // sesuaikan jika perlu

// Pastikan vendor login
if (!isset($_SESSION['is_login']) || $_SESSION['user_role'] !== 'vendor') {
    header("Location: ../../login.php"); exit;
}

// Ambil id dari query string
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['flash_error'] = "ID portofolio tidak valid.";
    header("Location: ../../portofolio.php"); exit;
}

$portfolio_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Ambil record portofolio dan vendor terkait untuk validasi ownership
$sql = "SELECT p.*, v.id AS vendor_id, v.user_id AS vendor_user_id
        FROM portofolio p
        LEFT JOIN vendors v ON p.id_vendor = v.id
        WHERE p.id = {$portfolio_id}
        LIMIT 1";
$res = mysqli_query($conn, $sql);

if (!$res || mysqli_num_rows($res) == 0) {
    $_SESSION['flash_error'] = "Data portofolio tidak ditemukan.";
    header("Location: ../../portofolio.php"); exit;
}

$row = mysqli_fetch_assoc($res);

// Pastikan vendor yang login adalah pemilik portofolio
if (!isset($row['vendor_user_id']) || intval($row['vendor_user_id']) !== intval($user_id)) {
    $_SESSION['flash_error'] = "Akses ditolak. Anda bukan pemilik portofolio ini.";
    header("Location: ../../portofolio.php"); exit;
}

// Hapus file fisik jika berupa path relatif di folder uploads/portofolio
if (!empty($row['photo'])) {
    $photo = $row['photo'];

    // Jika photo adalah full URL (http/https) -> jangan unlink
    if (preg_match('#^https?://#i', $photo) === 0) {
        // treat as relative path; buat path absolute
        $absolutePath = realpath(__DIR__ . '/../../' . $photo);

        // Tetapkan folder upload yang diizinkan (absolute)
        $allowedDir = realpath(__DIR__ . '/../../uploads/portofolio/');

        // Cek keamanan: file harus berada di dalam allowedDir
        if ($absolutePath && $allowedDir && strpos($absolutePath, $allowedDir) === 0 && is_file($absolutePath)) {
            // coba hapus file, tapi jangan fatal jika gagal
            if (!@unlink($absolutePath)) {
                // tidak berhasil menghapus file, tapi kita tetap lanjut menghapus record DB
                // kamu bisa log error di sini jika mau
            }
        }
    }
}

// Hapus record database
$deleteSql = "DELETE FROM portofolio WHERE id = {$portfolio_id} LIMIT 1";
if (mysqli_query($conn, $deleteSql)) {
    $_SESSION['flash_success'] = "Portofolio berhasil dihapus.";
} else {
    $_SESSION['flash_error'] = "Gagal menghapus portofolio: " . mysqli_error($conn);
}

// Redirect kembali ke halaman portofolio
header("Location: ../../portofolio.php");
exit;
