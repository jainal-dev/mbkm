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
    die("Tidak dapat terhubung ke database $dbname: " . $e->getMessage());
}

// Memeriksa jika email sudah dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Sanitasi input email

    // Validasi format email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Email tidak valid.');
    }

    // Cek apakah email terdaftar di database
    $sql = "SELECT username FROM user WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        die('Email tidak ditemukan.');
    }

    $username = $user['username'];

    // Generate OTP (One-Time Password)
    $otp = rand(100000, 999999); // Generate 6-digit OTP

    // Simpan OTP ke database untuk keperluan verifikasi
    $sql = "INSERT INTO otp_table (otp_code, email, created_at) VALUES (:otp, :email, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':otp', $otp);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Menggunakan PHPMailer untuk mengirim email
    require 'vendor/autoload.php'; // Pastikan sudah memuat autoload composer

    // Create an instance of PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Konfigurasi server SMTP
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      // Menonaktifkan output debug yang verbose
        $mail->isSMTP();                                          // Menggunakan SMTP
        $mail->Host       = 'smtp.gmail.com';                     // Server SMTP untuk mengirim email
        $mail->SMTPAuth   = true;                                  // Mengaktifkan autentikasi SMTP
        $mail->Username   = 'jainalsibuea05@gmail.com';           // Username SMTP
        $mail->Password   = 'hvsh ohgn aocc lnrj';                   // Password aplikasi SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          // Menggunakan enkripsi TLS
        $mail->Port       = 465;                                  // Port yang digunakan untuk koneksi

        // Penerima email
        $mail->setFrom('jainalsibuea05@gmail.com', 'Verification');
        $mail->addAddress($email, $username); // Mengirim OTP ke email pengguna

        // Konten email
        $mail->isHTML(true);                                       // Mengatur format email ke HTML
        $mail->Subject = 'Kode Verifikasi OTP';
        $mail->Body    = 'Kode OTP Anda adalah: <b>' . $otp . '</b><br>Kode ini berlaku selama 10 menit.';
        $mail->AltBody = 'Kode OTP Anda adalah: ' . $otp . '. Kode ini berlaku selama 10 menit.';

        // Kirim email
        $mail->send();
        echo 'Kode OTP berhasil dikirim ke email Anda.';

        // Setelah email dikirim, arahkan pengguna ke halaman OTP untuk verifikasi
        header('Location: verifikasi-code.php?email=' . urlencode($email)); // Redirect ke halaman verifikasi OTP
        exit; // Menghentikan eksekusi kode setelah pengalihan
    } catch (Exception $e) {
        echo "Pesan gagal dikirim. Kesalahan: {$mail->ErrorInfo}";
    }
}
?>
