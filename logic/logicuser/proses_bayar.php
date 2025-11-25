<?php
session_start();
// Mundur 2 folder
require_once '../../includes/koneksi.php';

// Cek Login
if (!isset($_SESSION['is_login'])) {
    header("Location: ../../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = $_POST['booking_id'];
    $user_id = $_SESSION['user_id'];

    // 1. Validasi: Pastikan pesanan ini milik user yang login
    $cek = mysqli_query($conn, "SELECT id FROM bookings WHERE id='$booking_id' AND user_id='$user_id'");
    if(mysqli_num_rows($cek) == 0) {
        echo "<script>alert('Pesanan tidak valid!'); window.location.href='../../dashboard_user.php';</script>";
        exit;
    }

    // 2. Proses Upload Gambar
    // Target folder penyimpanan
    $target_dir = "../../assets/bukti_transfer/";
    
    // Buat folder jika belum ada
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Ambil info file
    $file_tmp = $_FILES['payment_proof']['tmp_name'];
    $file_name = $_FILES['payment_proof']['name'];
    $file_size = $_FILES['payment_proof']['size'];
    
    // Rename file agar unik (pake timestamp)
    $new_name = time() . '_' . $file_name;
    $target_file = $target_dir . $new_name;
    
    // Path yang akan disimpan di database (tanpa ../../)
    $db_path = "assets/bukti_transfer/" . $new_name;

    // Validasi Ukuran (Max 2MB)
    if ($file_size > 2000000) {
        echo "<script>alert('Ukuran file terlalu besar! Maksimal 2MB.'); window.location.href='../../dashboard_user.php';</script>";
        exit;
    }

    // Upload File
    if (move_uploaded_file($file_tmp, $target_file)) {
        
        // 3. Update Database
        // Ubah status jadi 'paid' dan simpan lokasi gambar
        $query = "UPDATE bookings SET status = 'paid', payment_proof = '$db_path' WHERE id = '$booking_id'";
        
        if (mysqli_query($conn, $query)) {
            echo "<script>
                    alert('Bukti pembayaran berhasil dikirim! Mohon tunggu konfirmasi vendor.'); 
                    window.location.href='../../dashboard_user.php';
                  </script>";
        } else {
            echo "<script>alert('Gagal update database.'); window.location.href='../../dashboard_user.php';</script>";
        }

    } else {
        echo "<script>alert('Gagal mengupload gambar.'); window.location.href='../../dashboard_user.php';</script>";
    }
}
?>