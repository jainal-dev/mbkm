<?php
session_start();
$error = '';
$host = 'localhost';
$dbname = 'mbkm';
$username = 'root';
$password_db = '';

// Database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password_db);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Tidak dapat terhubung ke database $dbname :" . $e->getMessage());
}
// OTP Expiration Time (in seconds)
$otp_expiration_time = 600; // 10 minutes

// Maximum Number of Failed Attempts
$max_failed_attempts = 3;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // die(print_r($_POST));
    $email = $_POST['email']; // Ambil email dari sesi
    $_SESSION['email'] = $email;
    $otp_input = implode('', $_POST['code']); // Menggabungkan array input menjadi satu string

    // Ambil OTP berdasarkan email
    $stmt = $pdo->prepare("SELECT otp_code, created_at, is_used, failed_attempts FROM otp_table WHERE email = :email ORDER BY created_at DESC LIMIT 1");
    $stmt->execute(['email' => $email]);
    $otp_data = $stmt->fetch();

    if ($otp_data) {
        $otp_code = $otp_data['otp_code'];
        $created_at = $otp_data['created_at'];
        $is_used = $otp_data['is_used'];
        $failed_attempts = $otp_data['failed_attempts'];

        // Periksa apakah OTP kadaluarsa
        if ((time() - strtotime($created_at)) > $otp_expiration_time) {
            $error = "Kode OTP sudah kadaluarsa.";
        } elseif ($is_used) {
            $error = "OTP sudah digunakan.";
        } elseif ($otp_code === $otp_input && $failed_attempts < $max_failed_attempts) {
            // Tandai OTP sebagai sudah digunakan
            $stmt = $pdo->prepare("UPDATE otp_table SET is_used = 1 WHERE email = :email AND otp_code = :otp_code");
            $stmt->execute(['email' => $email, 'otp_code' => $otp_code]);

            // OTP berhasil diverifikasi, redirect ke halaman berikutnya
            echo "OTP berhasil diverifikasi!";
            header("Location: verif-code.php");
            exit;
        } else {
            // Tambah jumlah percobaan gagal
            $failed_attempts++;
            $stmt = $pdo->prepare("UPDATE otp_table SET failed_attempts = :failed_attempts WHERE email = :email AND otp_code = :otp_code");
            $stmt->execute(['failed_attempts' => $failed_attempts, 'email' => $email, 'otp_code' => $otp_code]);

            // Tampilkan pesan error jika sudah mencapai batas percobaan
            if ($failed_attempts >= $max_failed_attempts) {
                $error = "Anda telah mencapai batas percobaan. Silakan minta kode OTP baru.";
            } else {
                $error = "Kode OTP salah. Anda memiliki " . ($max_failed_attempts - $failed_attempts) . " kali percobaan lagi.";
            }
        }
    } else {
        $error = "OTP tidak ditemukan atau sudah digunakan.";
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

        <!-- Tampilkan error jika ada -->
        <?php if ($error): ?>
            <div class="text-red-500 mb-4"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="post" action="verifikasi-code.php" class="space-y-4">
            <input type="hidden" name="email" value="<?= $_GET['email'] ?? $email ?>">
            <div class="flex justify-center gap-2">
                <input class="input-box" type="text" maxlength="1" name="code[]" required>
                <input class="input-box" type="text" maxlength="1" name="code[]" required>
                <input class="input-box" type="text" maxlength="1" name="code[]" required>
                <input class="input-box" type="text" maxlength="1" name="code[]" required>
                <input class="input-box" type="text" maxlength="1" name="code[]" required>
                <input class="input-box" type="text" maxlength="1" name="code[]" required>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between items-center mt-6">
                <button type="button" class="bg-gray-300 hover:bg-gray-200 text-gray-700 py-1.5 px-3 text-sm rounded-md">
                    Kirim Ulang Kode
                </button>
                <div class="flex gap-2">
                    <a href="lupa.php" class="bg-gray-400 hover:bg-gray-500 text-white py-1.5 px-3 text-sm rounded-md">
                        Kembali
                    </a>
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-1.5 px-4 text-sm rounded-md">
                        Verifikasi
                    </button>
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