<?php
require_once 'config.php';
require_once 'functions.php';


$token = $_GET['token'] ?? null;
$error = '';
$ok = '';


if (!$token) {
die('Token tidak ditemukan.');
}


// Ambil user berdasarkan token
$stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = ? LIMIT 1");
$stmt->execute([$token]);
$user = $stmt->fetch();


if (!$user) die('Token tidak valid.');
if (strtotime($user['reset_expiry']) < time()) die('Token sudah kedaluwarsa.');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$pw = $_POST['password'] ?? '';
$pw2 = $_POST['password2'] ?? '';


if (strlen($pw) < 6) {
$error = 'Password minimal 6 karakter.';
} elseif ($pw !== $pw2) {
$error = 'Password tidak sama.';
}


if (!$error) {
$hash = password_hash($pw, PASSWORD_DEFAULT);


$stmt = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expiry = NULL WHERE id = ?");
$stmt->execute([$hash, $user['id']]);


$ok = 'Password berhasil direset. Silakan <a href="login.php">login</a>.';
}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Atur Ulang Password - Polibatam Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />
    <link href="logregotplupapw.css" rel="stylesheet" />
    <style>
    .notif {
        display: none;
        margin-top: 15px;
        background-color: #d4edda;
        color: #155724;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #c3e6cb;
        text-align: center;
        animation: fadeIn 0.4s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    </style>
</head>

<body>
    <div class="card p-4 text-light">

        <h3 class="text-center mb-3">
            <i class="fa-solid fa-lock text-warning me-2"></i>Atur Ulang Password
        </h3>

        <?php if ($error): ?>
        <div class="alert alert-danger">
            <?= $error ?>
        </div>
        <?php endif; ?>

        <?php if ($ok): ?>
        <div class="alert alert-success">
            <?= $ok ?>
        </div>
        <?php endif; ?>

        <form method="POST" action="reset.php?token=<?= $token ?>">
            <div class="mb-3">
                <label class="form-label">
                    <i class="fa-solid fa-key me-2"></i>Password Baru
                </label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan Password Baru"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    <i class="fa-solid fa-key me-2"></i>Konfirmasi Password Baru
                </label>
                <input type="password" name="password2" class="form-control" placeholder="Ulangi Password Baru"
                    required>
            </div>

            <button type="submit" class="btn btn-custom w-100">
                <i class="fa-solid fa-rotate me-2"></i>Ubah Password
            </button>
        </form>
        <div id="notif" class="notif mt-3">
            Password berhasil diubah! Mengarahkan ke halaman login
        </div>
        <p class="text-center mt-3">
            <a href="login.php" class="link-light">
                <i class="fa-solid fa-arrow-left me-1"></i>Kembali ke Login
            </a>
        </p>
    </div>

</body>

</html>