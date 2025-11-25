<?php
session_start();
require_once '../../includes/koneksi.php';

// Cek Login
if (!isset($_SESSION['is_login'])) {
    header("Location: ../../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = $_POST['booking_id'];
    $rating = $_POST['rating'];
    $comment = mysqli_real_escape_string($conn, htmlspecialchars($_POST['comment']));
    $user_id = $_SESSION['user_id'];

    // 1. Validasi Booking
    $cek_booking = mysqli_query($conn, "SELECT id FROM bookings WHERE id='$booking_id' AND user_id='$user_id' AND status='completed'");

    if(mysqli_num_rows($cek_booking) > 0) {
        
        // 2. Cek Duplikasi (Biar gak review 2x)
        $cek_review = mysqli_query($conn, "SELECT id FROM reviews WHERE booking_id='$booking_id'");
        if(mysqli_num_rows($cek_review) > 0) {
            echo "<script>alert('Anda sudah mengulas pesanan ini.'); window.location.href='../../dashboard_user.php';</script>";
            exit;
        }

        // 3. Simpan
        $query = "INSERT INTO reviews (booking_id, rating, comment) VALUES ('$booking_id', '$rating', '$comment')";
        
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Ulasan terkirim!'); window.location.href='../../dashboard_user.php';</script>";
        } else {
            echo "<script>alert('Error Database.'); window.location.href='../../dashboard_user.php';</script>";
        }
        
    } else {
        echo "<script>alert('Pesanan tidak valid.'); window.location.href='../../dashboard_user.php';</script>";
    }
}
?>