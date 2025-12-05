<?php
require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/functions.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$username = e($_POST['username'] ?? '');
$email = e($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$password2 = $_POST['password2'] ?? '';


if (strlen($username) < 3) $errors[] = 'Username minimal 3 karakter.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email tidak valid.';
if (strlen($password) < 6) $errors[] = 'Password minimal 6 karakter.';
if ($password !== $password2) $errors[] = 'Password tidak sama.';

//cek email/user udh dipakai
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
$stmt->execute([$email, $username]);
if ($stmt->fetch()) $errors[] = 'Email atau username sudah terpakai.';

//gk ada error, bisa disimpan
if (empty($errors)) {
$hash = password_hash($password, PASSWORD_DEFAULT);
$role = 'user';


$stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
$stmt->execute([$username, $email, $hash, $role]);


header('Location: login.php?registered=1');
exit;
}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />
    <link href="assets/logregotplupapw.css" rel="stylesheet" />
</head>


<body>
    <div class="card p-4 text-light">
        <h3 class="text-center mb-3">
            <i class="fa-solid fa-user-plus text-info me-2"></i>Buat Akun Baru
        </h3>

        <form action="register.php" method="POST">
            <input type="text" name="username" class="form-control mb-3" placeholder="Username" required />
            <input type="email" name="email" class="form-control mb-3" placeholder="Email" required />
            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required />
            <input type="password" name="password2" class="form-control mb-3" placeholder="Konfirmasi Password"
                required />
            <button type="submit" name="register_button" class="btn btn-custom w-100">Daftar</button>
        </form>

        <p class="text-center mt-3">
            <a href="login.php" class="link-light">Sudah punya akun?</a>
        </p>
    </div>

    <script>
    </script>
</body>

</html>