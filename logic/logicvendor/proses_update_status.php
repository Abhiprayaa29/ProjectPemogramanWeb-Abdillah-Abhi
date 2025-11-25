<?php
session_start();
// Pastikan path koneksi benar (mundur satu folder, masuk components)
require_once '../../includes/koneksi.php';

// Cek apakah User adalah Vendor (Keamanan)
if (!isset($_SESSION['is_login']) || $_SESSION['user_role'] !== 'vendor') {
    header("Location: ../../login.php");
    exit;
}

// Cek apakah ada data ID dan Status di URL
if (isset($_GET['id']) && isset($_GET['status'])) {
    
    $booking_id = $_GET['id'];
    $status = $_GET['status'];
    $vendor_id = $_SESSION['user_id']; // ID Login User (bukan ID tabel vendors)

    // Validasi Status agar tidak diisi sembarangan
    $allowed_status = ['confirmed', 'cancelled', 'completed'];
    
    if (in_array($status, $allowed_status)) {
        
        // Query Update
        // Kita update status HANYA JIKA booking tersebut memang milik vendor yang sedang login
        // (Mencegah vendor A mengutak-atik pesanan vendor B)
        
        // 1. Ambil ID Vendor dari tabel vendors berdasarkan user_id login
        $v_query = mysqli_query($conn, "SELECT id FROM vendors WHERE user_id = '$vendor_id'");
        $v_data = mysqli_fetch_assoc($v_query);
        $real_vendor_id = $v_data['id'];

        // 2. Jalankan Update
        $query = "UPDATE bookings SET status = '$status' WHERE id = '$booking_id' AND vendor_id = '$real_vendor_id'";
        
        if (mysqli_query($conn, $query)) {
            // Berhasil
            echo "<script>
                    // alert('Status pesanan diperbarui!'); // Opsional, dimatikan agar lebih cepat
                    window.location.href = '../../dashboard_vendor.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Gagal mengupdate status.');
                    window.location.href = '../../dashboard_vendor.php';
                  </script>";
        }

    } else {
        echo "Status tidak valid.";
    }

} else {
    // Jika akses langsung tanpa ID
    header("Location: ../../dashboard_vendor.php");
}
?>