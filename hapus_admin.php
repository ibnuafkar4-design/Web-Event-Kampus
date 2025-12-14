<?php

include 'koneksi.php';
$id = $_GET['id'];
$result = mysqli_query($koneksi, "DELETE FROM admin WHERE id='$id'");
header("Location: admindashboard.php")
?>