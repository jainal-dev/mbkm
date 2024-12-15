<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Autoload PHPMailer

session_start();
$error = '';
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';

    // Cek apakah email ada di database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        // Buat OTP
        $otp = rand(100000, 999999);
        $otp_expiration = date("Y-m-d H:i:s", strtotime("+10 minutes"));

        // Simpan OTP di database
        $stmt = $pdo->prepare("UPDATE users SET otp_code = :otp, otp_expiration = :otp_expiration WHERE email = :email");
        $stmt->execute([
            'otp' => $otp,
            'otp_expiration' => $otp_expiration,
            'email' => $email
        ]);

        // Kirim OTP ke email
        $mail = new PHPMailer(true);
        try {
            // Konfigurasi SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Gunakan SMTP Gmail atau server email Anda
            $mail->SMTPAuth = true;
            $mail->Username = 'youremail@gmail.com'; // Email Anda
            $mail->Password = 'yourpassword'; // Kata sandi email Anda (gunakan App Password untuk Gmail)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Pengaturan email
            $mail->setFrom('youremail@gmail.com', 'Nama Aplikasi Anda');
            $mail->addAddress($email, $user['nama']);
            $mail->Subject = 'Kode OTP Anda';
            $mail->Body = "Kode OTP Anda adalah: $otp\nKode ini berlaku selama 10 menit.";

            $mail->send();
            echo "Kode OTP berhasil dikirim ke email Anda.";
        } catch (Exception $e) {
            echo "Gagal mengirim email. Error: {$mail->ErrorInfo}";
        }
    } else {
        $error = "Email tidak terdaftar.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Kode</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #4c51bf, #6b46c1, #9f7aea, #b794f4);
            background-size: 400% 400%;
            animation: gradientBG 10s ease infinite;
            font-family: 'Poppins', sans-serif;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .input-box {
            width: 50px;
            height: 50px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 20px;
            font-weight: bold;
            transition: border-color 0.3s;
        }

        .input-box:focus {
            border-color: #4c51bf;
            outline: none;
            box-shadow: 0 0 5px rgba(76, 81, 191, 0.5);
        }
    </style>
</head>
<body class="flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-96 text-center">
        <h2 class="text-2xl font-bold mb-4">Masukan Kode Verifikasi</h2>
        <p class="text-gray-500 mb-6">Silakan masukkan 6 digit kode yang baru saja dikirim ke email</p>
        <form method="post" action="verif-code.php" class="space-y-4">
    <div class="flex justify-center gap-2">
        <input class="input-box" type="text" maxlength="1" name="code[]" required>
        <input class="input-box" type="text" maxlength="1" name="code[]" required>
        <input class="input-box" type="text" maxlength="1" name="code[]" required>
        <input class="input-box" type="text" maxlength="1" name="code[]" required>
        <input class="input-box" type="text" maxlength="1" name="code[]" required>
        <input class="input-box" type="text" maxlength="1" name="code[]" required>
    </div>
    <button type="submit">Verifikasi</button>
</form>

           <!-- Buttons -->
<div class="flex justify-between items-center mt-6">
    <!-- Resend Code Button -->
    <button type="button" class="bg-gray-300 hover:bg-gray-200 text-gray-700 py-1.5 px-3 text-sm rounded-md">
        Kirim Ulang Kode
    </button>
    <!-- Back and Verify Buttons -->
    <div class="flex gap-2">
        <a href="lupa.php" class="bg-gray-400 hover:bg-gray-500 text-white py-1.5 px-3 text-sm rounded-md">
            Kembali
        </a>
        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-1.5 px-4 text-sm rounded-md">
            Verifikasi
        </button>
    </div>
</div>

                </div>
            </div>
        </form>
    </div>

    <!-- Optional: Auto Focus Script for OTP -->
    <script>
        const inputs = document.querySelectorAll(".input-box");
        inputs.forEach((input, index) => {
            input.addEventListener("input", (e) => {
                if (input.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });

            input.addEventListener("keydown", (e) => {
                if (e.key === "Backspace" && index > 0 && input.value === "") {
                    inputs[index - 1].focus();
                }
            });
        });
    </script>
</body>
</html>