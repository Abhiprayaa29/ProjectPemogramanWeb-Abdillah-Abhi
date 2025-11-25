<?php
require_once '../../includes/koneksi.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['vendor_id'];
    $name = htmlspecialchars($_POST['name']);
    $price = $_POST['price'];
    $dur = $_POST['duration'];
    $desc = htmlspecialchars($_POST['desc']);

    $query = "INSERT INTO packages (vendor_id, name, description, price, duration_hours) VALUES ('$id', '$name', '$desc', '$price', '$dur')";
    mysqli_query($conn, $query);
    // mengetahui id paket yang baru ditambahkan
    $query_id = "SELECT id FROM packages WHERE vendor_id='$id' ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $query_id);
    $row = mysqli_fetch_assoc($result);
    $package_id = $row['id'];
    $query = "INSERT INTO packages_history (id, vendor_id, name, description, price, duration_hours) VALUES ('$package_id', '$id', '$name', '$desc', '$price', '$dur')";
    
    if(mysqli_query($conn, $query)) {
        header("Location: ../../vendor_packages.php");
    } else {
        echo "<script>alert('Gagal tambah paket'); window.location.href='../../vendor_packages.php';</script>";
    }
}
?>