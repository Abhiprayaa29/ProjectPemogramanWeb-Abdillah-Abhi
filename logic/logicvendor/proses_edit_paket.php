<?php
require_once '../../includes/koneksi.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['package_id'];
    $name = htmlspecialchars($_POST['name']);
    $price = $_POST['price'];
    $dur = $_POST['duration'];
    $desc = htmlspecialchars($_POST['desc']);

    $query = "UPDATE packages SET name='$name', description='$desc', price=$price, duration_hours=$dur WHERE id=$id";
    mysqli_query($conn, $query);
    $query = "UPDATE packages_history SET name='$name', description='$desc', price=$price, duration_hours=$dur WHERE id=$id";
    
    if(mysqli_query($conn, $query)) {
        header("Location: ../../vendor_packages.php");
    } else {
        echo "<script>alert('Gagal Update paket'); window.location.href='../../vendor_packages.php';</script>";
    }
}
?>