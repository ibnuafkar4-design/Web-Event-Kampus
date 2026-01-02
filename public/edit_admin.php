<?php
// include database connetion file
include '../app/koneksi2.php';
    $id=$_POST['id'];
    $judul=$_POST['judul'];
    $tanggal=$_POST['tanggal'];
    $waktu=$_POST['waktu'];
    $tempat=$_POST['tempat'];
    $deskripsi=$_POST['deskripsi'];
    $gambar=$_POST['gambar'];
    $result = mysqli_query($koneksi, "UPDATE event SET judul='$judul',tanggal='$tanggal'
        ,waktu='$waktu', tempat='$tempat', deskripsi='$deskripsi', gambar='$gambar' WHERE id='$id'");
    // Redirect to homepage to display updated user in list
header("Location: admindashboard.php");
?>