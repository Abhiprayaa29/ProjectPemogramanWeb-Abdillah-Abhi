<?php
session_start();
require_once '../../includes/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pastikan user login
    if (!isset($_SESSION['is_login'])) {
        echo "<script>alert('Silakan Login Dulu!'); window.location.href='../../login.php';</script>";
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $vendor_id = $_POST['vendor_id']; // Harus dikirim dari form (hidden input)
    $package_id = $_POST['package_id']; // Harus dikirim dari form (hidden input)
    $date = $_POST['booking_date'];
    $time = $_POST['booking_time'];
    $note = $_POST['note'];
    $total = $_POST['total_price']; // Sebaiknya hitung ulang di server, tapi ini contoh simpel
    
    $code = "INV-" . time(); // Bikin kode unik

    $query = "INSERT INTO bookings (booking_code, user_id, vendor_id, package_id, booking_date, booking_time, location_note, total_price, status)
              VALUES ('$code', '$user_id', '$vendor_id', '$package_id', '$date', '$time', '$note', '$total', 'pending')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Booking Berhasil! Silakan cek dashboard.'); window.location.href='../../dashboard_user.php';</script>";
    } else {
        echo "<script>alert('Gagal Booking.'); window.location.href='../../index.php';</script>";
    }
}
?>