<?php
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
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();
    if ($user) {
        $token = bin2hex(random_bytes(50));
        $stmt = $pdo->prepare("UPDATE users SET reset_token = :token, token_expiry = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = :email");
        $stmt->execute(['token' => $token, 'email' => $email]);
        $reset_link = "http://yourdomain.com/reset_password.php?token=$token";
        $to = $email;
        $subject = "Password Reset Request";
        $message = "Hi, click the following link to reset your password: $reset_link";
        $headers = "From: no-reply@yourdomain.com";

        if (mail($to, $subject, $message, $headers)) {
            $success = "Link untuk mereset kata sandi telah dikirim ke email Anda.";
        } else {
            $error = "Gagal mengirim email. Silakan coba lagi.";
        }
    } else {
        $error = "Email tidak ditemukan.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
        }

        .moving-background {
            background: linear-gradient(45deg, #6b46c1, #805ad5, #9f7aea, #b794f4);
            background-size: 400% 400%;
            animation: moveBackground 15s linear infinite;
        }

        /* Slide-in animation */
        @keyframes slideIn {
            0% {
                opacity: 0;
                transform: translateX(100%);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .slide-in {
            animation: slideIn 0.8s ease-out;
        }

        @keyframes moveBackground {
            0% { background-position: 0% 50%; }
            100% { background-position: 100% 50%; }
        }
    </style>
</head>
<body class="moving-background flex items-center justify-center min-h-screen">
    <div class="flex w-full max-w-md bg-white rounded-lg shadow-lg overflow-hidden p-10 slide-in">
        <div class="w-full flex flex-col items-center justify-center">
            <h2 class="text-4xl font-bold text-indigo-900 mb-6">Lupa Kata Sandi</h2>
            <p class="text-gray-500 mb-4 text-center">Masukkan email Anda, kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.</p>
            
            <?php if($error != ''): ?>
                <div class="mb-4 text-red-500">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php if(isset($success)): ?>
                <div class="mb-4 text-green-500">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <form method="post" action="">
                <div class="mb-4 w-full">
                    <label class="block text-gray-700 mb-2" for="email">Email</label>
                    <input class="w-full p-3 rounded-lg bg-gray-200 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" id="email" name="email" type="email" placeholder="Masukkan email Anda" required/>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded-lg font-semibold hover:bg-blue-600 transition duration-300">Kirim Tautan</button>
            </form>

            <div class="text-center mt-6">
                <a href="frontend.php" class="bg-gray-400 text-white p-3 rounded-lg font-semibold hover:bg-gray-500 transition duration-300 inline-block">
                    Kembali Ke Halaman Utama
                </a>
            </div>
        </div>
    </div>
</body>
</html>
