<?php
session_start();
require_once '../../includes/koneksi.php';

// Pastikan User Login
if (!isset($_SESSION['is_login'])) {
    header("Location: ../../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $fullname = mysqli_real_escape_string($conn, htmlspecialchars($_POST['fullname']));
    $email = mysqli_real_escape_string($conn, htmlspecialchars($_POST['email']));
    $profile_img = mysqli_real_escape_string($conn, htmlspecialchars($_POST['profile_img']));

    // Cek apakah email dipakai orang lain (Kecuali punya sendiri)
    $cek_email = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email' AND id != '$user_id'");
    if (mysqli_num_rows($cek_email) > 0) {
        echo "<script>alert('Email sudah digunakan user lain!'); window.location.href='../../dashboard_user.php';</script>";
        exit;
    }

    // Update Database
    $query = "UPDATE users SET full_name = '$fullname', email = '$email', profile_img = '$profile_img' WHERE id = '$user_id'";
    
    if (mysqli_query($conn, $query)) {
        // Update Session Nama juga agar navbar langsung berubah
        $_SESSION['user_name'] = $fullname;
        
        echo "<script>alert('Profil berhasil diperbarui!'); window.location.href='../../dashboard_user.php';</script>";
    } else {
        echo "<script>alert('Gagal update profil.'); window.location.href='../../dashboard_user.php';</script>";
    }
}
?>