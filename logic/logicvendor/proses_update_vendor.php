<?php
session_start();
require_once '../../includes/koneksi.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['vendor_id'];
    $brand = htmlspecialchars($_POST['brand_name']);
    $cat = $_POST['category'];
    $loc = $_POST['location'];
    $ig = htmlspecialchars($_POST['instagram']);
    $desc = htmlspecialchars($_POST['description']);
    $img = htmlspecialchars($_POST['profile_url']);
    $cimg = htmlspecialchars($_POST['cover_img']);
    $_SESSION['user_name'] = $brand;
    $query = "UPDATE vendors SET brand_name='$brand', category='$cat', location='$loc', instagram='$ig', description='$desc', profile_img='$img', cover_img='$cimg' WHERE id='$id'";

    if(mysqli_query($conn, $query)) {
        
        echo "<script>alert('Profil Update!'); window.location.href='../../vendor_settings.php';</script>";
    } else {
        echo "<script>alert('Gagal'); window.location.href='../../vendor_settings.php';</script>";
    }
}
?>