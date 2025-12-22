<?php
// include database connetion file
include 'koneksi.php';
    $id=$_POST['id'];
    $judul=$_POST['judul'];
    $tanggal=$_POST['tanggal'];
    $waktu=$_POST['waktu'];
    $tempat=$_POST['tempat'];
    $deskripsi=$_POST['deskripsi'];
    
    // Cek apakah file baru diunggah untuk foto
if (isset($_FILES['foto']['name']) && $_FILES['foto']['name'] != '') {
    $foto = $_FILES['foto']['name'];
    $targetFoto = "uploads/" . basename($foto);
    // Upload file baru
    if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetFoto)) {
        // Hapus foto lama jika ada
        $queryFoto = mysqli_query($koneksi, "SELECT foto FROM admin WHERE id = '$id'");
        $oldFoto = mysqli_fetch_assoc($queryFoto)['foto'];
        if ($oldFoto && file_exists("uploads/$oldFoto")) {
            unlink("uploads/$oldFoto");
        }
    } else {
        echo "Gagal mengunggah foto.";
        exit;
    }
} else {
    // Jika tidak ada file baru, tetap gunakan foto lama
    $queryFoto = mysqli_query($koneksi, "SELECT foto FROM admin WHERE id = '$id'");
    $foto = mysqli_fetch_assoc($queryFoto)['foto'];
}
    // Perbarui data di database
$queryUpdate = "UPDATE admin SET
    judul = '$judul',
    tanggal = '$tanggal',
    waktu = '$waktu',
    tempat = '$tempat',
    deskripsi = '$deskripsi',
    foto = '$foto'
    WHERE id = '$id'";

if (mysqli_query($koneksi, $queryUpdate)) {
    header("Location: admindashboard.php?status=success"); // Redirect ke halaman utama dengan status berhasil
} else {
    echo "Gagal memperbarui data: " . mysqli_error($koneksi);
}
?>