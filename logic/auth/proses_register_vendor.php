<?php
require_once '../../includes/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Ambil Data Login
    $first_name = mysqli_real_escape_string($conn, htmlspecialchars($_POST['first_name']));
    $last_name = mysqli_real_escape_string($conn, htmlspecialchars($_POST['last_name']));
    $full_name = $first_name . ' ' . $last_name;
    
    $email = mysqli_real_escape_string($conn, htmlspecialchars($_POST['email']));
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // 2. Ambil Data Profil Vendor
    $brand_name = mysqli_real_escape_string($conn, htmlspecialchars($_POST['brand_name']));
    $category = mysqli_real_escape_string($conn, htmlspecialchars($_POST['category']));
    $instagram = mysqli_real_escape_string($conn, htmlspecialchars($_POST['instagram']));
    $location = mysqli_real_escape_string($conn, htmlspecialchars($_POST['location']));
    
    $role = 'vendor'; 

    // 3. Cek Email Kembar
    $cek_email = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
    if (mysqli_fetch_assoc($cek_email)) {
        echo "<script>
                alert('Email sudah terdaftar! Gunakan email lain.');
                window.location.href = '../../vendor.php';
              </script>";
        exit;
    }

    // 4. Proses Insert (TRANSACTION)
    // Kita pakai Transaction agar jika insert ke vendor gagal, insert ke user dibatalkan
    mysqli_begin_transaction($conn);

    try {
        // A. Insert ke tabel USERS
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $query_user = "INSERT INTO users (full_name, email, password, role) VALUES ('$full_name', '$email', '$password_hash', '$role')";
        mysqli_query($conn, $query_user);
        
        // Ambil ID User yang baru saja dibuat
        $user_id = mysqli_insert_id($conn);

        // B. Insert ke tabel VENDORS
        // Kita kasih default image dulu
        $default_img = "https://ui-avatars.com/api/?name=" . urlencode($brand_name) . "&background=random";
        
        $query_vendor = "INSERT INTO vendors (user_id, brand_name, category, location, instagram, profile_img, cover_img) 
                         VALUES ('$user_id', '$brand_name', '$category', '$location', '$instagram', '$default_img', '$default_img')";
        mysqli_query($conn, $query_vendor);

        // Jika semua lancar, Commit
        mysqli_commit($conn);

        echo "<script>
                alert('Pendaftaran Mitra Berhasil! Silakan Login.');
                window.location.href = '../../login.php';
              </script>";

    } catch (Exception $e) {
        // Jika ada error, Rollback (Batalkan semua)
        mysqli_rollback($conn);
        echo "<script>
                alert('Gagal Mendaftar: " . $e->getMessage() . "');
                window.location.href = '../../vendor.php';
              </script>";
    }
}
?>