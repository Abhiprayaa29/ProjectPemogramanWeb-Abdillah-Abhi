<?php
require_once '../../includes/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $fullname = mysqli_real_escape_string($conn, htmlspecialchars($_POST['fullname']));
    $email = mysqli_real_escape_string($conn, htmlspecialchars($_POST['email']));
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    
    $role = 'client'; 

    if ($password !== $confirm_password) {
        // 2. PERBAIKAN REDIRECT (Pakai ../)
        echo "<script>
                alert('Password dan Ulangi Password tidak cocok!');
                window.location.href = '../register.php';
              </script>";
        exit;
    }

    $cek_email = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
    if (mysqli_fetch_assoc($cek_email)) {
        // Pakai ../
        echo "<script>
                alert('Email sudah terdaftar! Gunakan email lain.');
                window.location.href = '../../register.php';
              </script>";
        exit;
    }

    $default_img = "https://ui-avatars.com/api/?name=" . urlencode($fullname) . "&background=random";

    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (full_name, email, password, role, profile_img) 
              VALUES ('$fullname', '$email', '$password_hash', '$role', '$default_img')";

    if (mysqli_query($conn, $query)) {
        // SUKSES: Redirect ke login di folder luar
        echo "<script>
                alert('Pendaftaran Berhasil! Silakan Login.');
                window.location.href = '../../login.php';
              </script>";
    } else {
        // GAGAL: Redirect kembali ke register
        echo "<script>
                alert('Error: " . mysqli_error($conn) . "');
                window.location.href = '../../register.php';
              </script>";
    }
}
?>