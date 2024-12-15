<?php
// Memasukkan PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Koneksi ke database
$host = 'localhost';
$dbname = 'mbkm';
$username = 'root';
$password_db = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password_db);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Tidak dapat terhubung ke database $dbname :" . $e->getMessage());
}

$error = '';

// Ambil data pengguna berdasarkan email
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Sanitasi input email

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Email tidak valid.');
    }

    // Cek apakah email terdaftar
    $sql = "SELECT username FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        die('Email tidak ditemukan.');
    }

    $username = $user['username'];

    // Generate OTP
    $otp = rand(100000, 999999); // Generate 6-digit OTP

    // Simpan OTP ke database (untuk keperluan verifikasi)
    $sql = "INSERT INTO otp_table (otp_code, email, created_at) VALUES (:otp, :email, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':otp', $otp);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Menggunakan PHPMailer untuk mengirim email
    require 'vendor/autoload.php'; // Pastikan sudah memuat autoload composer

    // Create an instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      // Disable verbose debug output
        $mail->isSMTP();                                           // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     // SMTP server to send through
        $mail->SMTPAuth   = true;                                  // Enable SMTP authentication
        $mail->Username   = 'jainalsibuea05@gmail.com';           // SMTP username
        $mail->Password   = 'mizqjbsppgciejtq';                   // SMTP password (App Password)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           // Enable implicit TLS encryption
        $mail->Port       = 465;                                   // TCP port to connect to

        // Recipients
        $mail->setFrom('jainalsibuea05@gmail.com', 'Verification');
        $mail->addAddress($email, $username);                      // Send OTP to the email from the database

        // Content
        $mail->isHTML(true);                                       // Set email format to HTML
        $mail->Subject = 'Kode Verifikasi OTP';
        $mail->Body    = 'Kode OTP Anda adalah: ' . $otp . '<br>Kode ini berlaku selama 10 menit.';
        $mail->AltBody = 'Kode OTP Anda adalah: ' . $otp . ' Kode ini berlaku selama 10 menit.';

        // Send email
        $mail->send();
        echo 'Kode OTP berhasil dikirim ke email Anda.';

        // Setelah mengirim email, arahkan pengguna ke halaman OTP
        header('Location: otp_verification.php?email=' . urlencode($email)); // Redirect ke halaman verifikasi OTP
        exit;
    } catch (Exception $e) {
        echo "Pesan gagal dikirim. Kesalahan: {$mail->ErrorInfo}";
    }
}
?>
