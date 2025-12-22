<?php
session_start();
include __DIR__ . '/../database/koneksi2.php'; 

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_POST['username']) || !isset($_POST['password'])) {
        $error = "Form tidak lengkap.";
    } else {

        $username = mysqli_real_escape_string($koneksi, $_POST['username']);
        $password = mysqli_real_escape_string($koneksi, $_POST['password']);

        $sql = "SELECT * FROM admin1 WHERE username='$username' AND password='$password'";
   

        $data = mysqli_query($koneksi, $sql);

        if (!$data) {
            die("Query Error: " . mysqli_error($koneksi));
        }

        if (mysqli_num_rows($data) > 0) {
            $row = mysqli_fetch_assoc($data);
            $_SESSION['username'] = $row['username'];
            header("Location: admindashboard.php");
            exit();
        } else {
            $error = "Username atau password salah.";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />
    <link href="assets/logregotplupapw.css" rel="stylesheet" />
</head>
<style>
body {
    background: linear-gradient(135deg, #0b1b3a, #1a2b5e);
    color: white;
    font-family: 'Poppins', sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.card {
    background-color: #14204b;
    border: none;
    width: 380px;
    box-shadow: 0 0 20px rgba(255, 60, 172, 0.4);
}

.form-control {
    background-color: #ffffff;
    border: none;
    color: rgb(0, 0, 0);
}

.form-control:focus {
    box-shadow: 0 0 10px #ff3cac;
    background-color: #fbfbfb;
}

.btn-custom {
    background: #ff3cac;
    color: white;
    border: none;
    transition: 0.3s;
}

.btn-custom:hover {
    background: #ff5fb2;
}
</style>

<body>
    <div class="card p-4 text-light">
        <h3 class="text-center mb-3">
            <i class="fa-solid fa-bolt text-warning me-2"></i>Admin Panel
        </h3>
        <form id="loginForm" method="POST" action="login.php">
            <h5 class="text-center mb-3">
                <i class="fa-solid fa-right-to-bracket me-2"></i>Login Admin
            </h5>
            <input type="text" name="username" class="form-control mb-3" id="username" placeholder="Username atau Email"
                required />
            <input type="password" name="password" class="form-control mb-3" id="password" placeholder="Password"
                required />
            <button type="submit" class="btn btn-custom w-100 mb-3">Masuk</button>
        </form>

    </div>
</body>



</html>