<?php
require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/functions.php';
require_once __DIR__ . '/../vendor/autoload.php';


$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$username = e($_POST['username'] ?? ''); 
$password = $_POST['password'] ?? '';


//ambil user berdasarkan email atau username
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? OR username = ? LIMIT 1");
$stmt->execute([$username, $username]);
$user = $stmt->fetch();


if ($user && password_verify($password, $user['password'])) {
session_regenerate_id(true);
$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['role'] = $user['role'];


//arahkan berdasarkan role
if ($user['role'] === 'admin') {
header('Location: admindashboard.php');
exit;
} else {
header('Location: dashboardusers.php');
exit;
}


} else {
$error = 'Login gagal: email/username atau password salah.';
}
}


?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />
    <link href="assets/logregotplupapw.css" rel="stylesheet" />
</head>

<body>
    <div class="card p-4 text-light">
        <h3 class="text-center mb-3">
            <i class="fa-solid fa-bolt text-warning me-2"></i>Polibatam Event
        </h3>
        <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form id="loginForm" method="POST" action="login.php">
            <h5 class="text-center mb-3">
                <i class="fa-solid fa-right-to-bracket me-2"></i>Login
            </h5>
            <input type="text" name="username" class="form-control mb-3" id="username" placeholder="Username atau Email"
                required />
            <input type="password" name="password" class="form-control mb-3" id="password" placeholder="Password"
                required />
            <button type="submit" class="btn btn-custom w-100 mb-3">Masuk</button>
        </form>

        <p class="text-center">
            <a href="register.php" class="link-light">Daftar |</a>
            <a href="lupapw.php" class="link-light">Lupa Password?</a>
        </p>
    </div>
</body>


</script>

</html>