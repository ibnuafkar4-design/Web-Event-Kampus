<?php

require_once 'config.php';
require_once realpath(__DIR__ . '/../vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function e($v) {
    return htmlspecialchars(trim($v), ENT_QUOTES, 'UTF-8');
}

function generateToken($length = 64) {
    return bin2hex(random_bytes($length / 2));
}

function sendResetEmail($toEmail, $token) {
    $mail = new PHPMailer(true);
    try {
        //server settings
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = SMTP_PORT;

        // recipients
        $mail->setFrom(SMTP_USER, 'No Reply');
        $mail->addAddress($toEmail);

        //content di link email
        $mail->isHTML(true);
        $mail->Subject = 'Password reset request';
        $resetLink = BASE_URL . '/public/reset.php?token=' . urlencode($token);
        $mail->Body = "Klik link berikut untuk mereset password Anda: <a href=\"$resetLink\">$resetLink</a>.<br>Link berlaku 1 jam.";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('Mail error: ' . $mail->ErrorInfo);
        return false;
    }
}