<?php
session_start();
require_once '../../includes/koneksi.php';

if (!isset($_SESSION['is_login'])) {
    header("Location: ../../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    // 1. Ambil Password Lama dari DB
    $query = mysqli_query($conn, "SELECT password FROM users WHERE id = '$user_id'");
    $data = mysqli_fetch_assoc($query);

    // 2. Verifikasi Password Lama
    if (!password_verify($old_password, $data['password'])) {
        echo "<script>alert('Password Lama Salah!'); window.location.href='../../dashboard_user.php';</script>";
        exit;
    }

    // 3. Cek Password Baru Sama
    if ($new_password !== $confirm_new_password) {
        echo "<script>alert('Password Baru dan Konfirmasi tidak cocok!'); window.location.href='../../dashboard_user.php';</script>";
        exit;
    }

    // 4. Update Password Baru (Hashing)
    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
    $update = "UPDATE users SET password = '$new_password_hash' WHERE id = '$user_id'";

    if (mysqli_query($conn, $update)) {
        echo "<script>alert('Password Berhasil Diganti! Silakan Login Ulang.'); window.location.href='../../logout.php';</script>";
    } else {
        echo "<script>alert('Gagal update password.'); window.location.href='../../dashboard_user.php';</script>";
    }
}
?>