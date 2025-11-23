<?php

$db_host = '127.0.0.1';
$db_name = 'pbl';
$db_user = 'root';
$db_pass = 'Rickyarian228';
$dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
} catch (PDOException $e) {
    die('DB Connection failed: ' . $e->getMessage());
}

// SMTP (untuk PHPMailer)
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_USER', 'jastinreja@gmail.com');
define('SMTP_PASS', 'epck mkiu zfew ukwm');
define('SMTP_PORT', 587);

define('BASE_URL', 'http://localhost/pbl'); 

session_start();