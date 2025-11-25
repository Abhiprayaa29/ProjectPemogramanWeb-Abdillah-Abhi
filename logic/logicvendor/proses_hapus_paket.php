<?php
require_once '../../includes/koneksi.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    mysqli_query($conn, "DELETE FROM packages WHERE id = '$id'");
    header("Location: ../../vendor_packages.php");
}
?>