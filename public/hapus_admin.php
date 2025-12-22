<?php

include 'koneksi.php';
$id = $_GET['id'];

$query = mysqli_query($koneksi, "SELECT * FROM admin WHERE id = '$id'");
$data = mysqli_fetch_assoc($query);

unlink("uploads/" . $data['foto']);

mysqli_query($koneksi, "DELETE FROM admin WHERE id = '$id'");
echo "<script>alert('Data berhasil dihapus!'); window.location='admindashboard.php';</script>";
?>  