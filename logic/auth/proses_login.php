<?php
session_start();
// Path koneksi SUDAH BENAR (Mundur satu folder lalu masuk includes)
require_once '../../includes/koneksi.php';

// Cek apakah form sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // 1. Cari data user berdasarkan email
    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

    // 2. Cek apakah email ditemukan?
    if (mysqli_num_rows($result) === 1) {

        // Email ketemu, sekarang ambil datanya
        $row = mysqli_fetch_assoc($result);

        // 3. Verifikasi Password (Hash vs Input)
        if (password_verify($password, $row['password'])) {

            $_SESSION['is_login'] = true;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_role'] = $row['role'];
            $_SESSION['user_name'] = $row['full_name']; // default

            // Jika vendor → ganti nama menjadi brand_name
            if ($row['role'] === 'vendor') {
                $userId = intval($row['id']); // aman dari SQL injection
                $query = "SELECT brand_name FROM vendors WHERE user_id = $userId LIMIT 1";
                $result = mysqli_query($conn, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    $vendor = mysqli_fetch_assoc($result);
                    $_SESSION['user_name'] = $vendor['brand_name'];
                }
            }

            echo "<script>
            alert('Login Berhasil! Selamat datang, " . htmlspecialchars($_SESSION['user_name']) . "');
            window.location.href = '../../index.php';
          </script>";
            exit;
        } else {
            // --- KASUS A: PASSWORD SALAH ---
            echo "<script>
                    alert('Password yang Anda masukkan salah!');
                    window.location.href = '../../login.php';
                  </script>";
            exit;
        }
    } else {
        // --- KASUS B: EMAIL TIDAK DITEMUKAN ---
        echo "<script>
                alert('Akun tidak ditemukan! Silakan daftar terlebih dahulu.');
                window.location.href = '../../login.php';
              </script>";
        exit;
    }
}
