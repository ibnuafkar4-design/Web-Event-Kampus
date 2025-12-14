<?php
include 'koneksi.php';
$judul=$_POST['judul'];
$tanggal=$_POST['tanggal'];
$waktu=$_POST['waktu'];
$tempat=$_POST['tempat'];
$deskripsi=$_POST['deskripsi'];
$gambar=$_FILES['gambar']['name'];
$tmp = $_FILES['gambar']['tmp_name'];
move_uploaded_file($tmp, "upload/".$gambar);
$input = mysqli_query($koneksi, "INSERT INTO admin (judul, tanggal, waktu, tempat, deskripsi, gambar) 
VALUES('$judul', '$tanggal', '$waktu', '$tempat', '$deskripsi', '$gambar')") or die(mysqli_error($koneksi));

if($input){
    echo "<script>
            alert('Data Berhasil Disimpan');
            window.location.href ='admindashboard.php'
            </script>";
} else {
    echo "<script>
            alert('Gagal Menyimpan Data');
            window.location.href ='admindashboard.php';
            </script>";
}
?>