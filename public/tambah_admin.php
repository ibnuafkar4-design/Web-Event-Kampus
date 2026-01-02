<?php
include '../app/koneksi2.php';
$judul=$_POST['judul'];
$tanggal=$_POST['tanggal'];
$waktu=$_POST['waktu'];
$tempat=$_POST['tempat'];
$deskripsi=$_POST['deskripsi'];
// Validasi file gambar (foto)
$foto = $_FILES['foto']['name'];
$ukuran_foto = $_FILES['foto']['size'];
$tmp_foto = $_FILES['foto']['tmp_name'];
$ekstensi_foto_diperbolehkan = array('jpg', 'jpeg', 'png');
$x_foto = explode('.', $foto);
$ekstensi_foto = strtolower(end($x_foto));
$path_foto = "uploads/" . $foto;

// Validasi ekstensi dan ukuran file
if (in_array($ekstensi_foto, $ekstensi_foto_diperbolehkan) && $ukuran_foto < 2000000) {

// Pindahkan file ke folder tujuan
if (move_uploaded_file($tmp_foto, $path_foto)) {

// Simpan data ke database
$query = "INSERT INTO admin (judul, tanggal, waktu, tempat, deskripsi, foto)
            VALUES ('$judul', '$tanggal', '$waktu', '$tempat', '$deskripsi', '$foto')";
if (mysqli_query($koneksi, $query)) {
    echo "<script>alert('Data berhasil ditambahkan'); window.location='admindashboard.php';</script>";
    }
} else {
    echo "<script>alert('Gagal menyimpan data ke database'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('File gambar tidak valid atau ukurannya terlalu besar'); window.history.back();</script>";
}
?>