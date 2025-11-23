<?php
require_once 'config.php';
require_once 'functions.php';

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil email
    $email = e($_POST['email'] ?? '');

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Masukkan email yang valid.');</script>";
    } else {

        // Cek apakah email terdaftar
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            // Buat token
            $token = generateToken(64);
            $expiry = date('Y-m-d H:i:s', time() + 3600);

            // Simpan token
            $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_expiry = ? WHERE id = ?");
            $stmt->execute([$token, $expiry, $user['id']]);

            // Kirim email
            if (sendResetEmail($email, $token)) {
                echo "<script>alert('Token reset password telah dikirim ke email Anda.');</script>";
            } else {
                echo "<script>alert('Gagal mengirim email.');</script>";
            }
        } else {
            echo "<script>alert('Email tidak terdaftar.');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Lupa Password</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />
    <link href="logregotplupapw.css" rel="stylesheet" />
</head>

<body>
    <div class="card p-4 text-light">
        <h3 class="text-center mb-3">
            <i class="fa-solid fa-envelope text-warning me-2"></i> Lupa Password
        </h3>

        <!-- FORM KIRIM EMAIL -->
        <form method="POST" action="lupapw.php">
            <input type="email" name="email" class="form-control mb-3" placeholder="Masukkan Email" required />
            <button type="submit" class="btn btn-custom w-100">Kirim Token</button>
        </form>

        <p class="text-center mt-3">
            <a href="login.php" class="link-light">Kembali ke Login</a>
        </p>
    </div>
</body>

</html>