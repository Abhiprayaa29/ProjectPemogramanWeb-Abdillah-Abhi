<?php
$host = "localhost";
$user = "root";
$pass = "";
$name = "db_jogjalensa"; // <--- Pastikan ini sesuai nama database di phpMyAdmin

$conn = mysqli_connect($host, $user, $pass, $name);

if (!$conn) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}

function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }
    return $rows;
}

function formatRupiah($angka){
    return "Rp " . number_format($angka, 0, ',', '.');
}
?>