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

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = :token AND token_expiry > NOW()");
    $stmt->execute(['token' => $token]);
    $user = $stmt->fetch();

    if ($user) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            if ($password == $confirm_password) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET password = :password, reset_token = NULL, token_expiry = NULL WHERE id = :id");
                $stmt->execute(['password' => $hashed_password, 'id' => $user['id']]);
                $success = "Kata sandi Anda berhasil direset. Silakan login dengan kata sandi baru Anda.";
            } else {
                $error = "Kata sandi tidak cocok. Silakan coba lagi.";
            }
        }
    } else {
        $error = "Token tidak valid atau telah kedaluwarsa.";
    }
} else {
    $error = "Token tidak ditemukan.";
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
    </style>
</head>
<body class="moving-background flex items-center justify-center min-h-screen">
    <div class="flex w-full max-w-md bg-white rounded-lg shadow-lg overflow-hidden p-10">
        <div class="w-full flex flex-col items-center justify-center">
            <h2 class="text-4xl font-bold text-indigo-900 mb-6">Reset Kata Sandi</h2>

            <?php if($error != ''): ?>
                <div class="mb-4 text-red-500">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php if(isset($success)): ?>
                <div class="mb-4 text-green-500">
                    <?php echo $success; ?>
                </div>
                <a href="login.php" class="w-full bg-blue-500 text-white p-3 rounded-lg font-semibold hover:bg-blue-600 transition duration-300 text-center">Login</a>
            <?php else: ?>
                <form method="post" action="">
                    <div class="mb-4 w-full">
                        <label class="block text-gray-700 mb-2" for="password">Kata Sandi Baru</label>
                        <input class="w-full p-3 rounded-lg bg-gray-200 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" id="password" name="password" type="password" placeholder="Masukkan kata sandi baru" required/>
                    </div>
                    <div class="mb-4 w-full">
                        <label class="block text-gray-700 mb-2" for="confirm_password">Konfirmasi Kata Sandi</label>
                        <input class="w-full p-3 rounded-lg bg-gray-200 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" id="confirm_password" name="confirm_password" type="password" placeholder="Konfirmasi kata sandi baru" required/>
                    </div>
                    <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded-lg font-semibold hover:bg-blue-600 transition duration-300">Reset Kata Sandi</button>
                </form>
            <?php endif; ?>

            <div class="text-center mt-6">
                <a href="frontend.php" class="bg-gray-400 text-white p-3 rounded-lg font-semibold hover:bg-gray-500 transition duration-300 inline-block">
                    Kembali Ke Halaman Utama
                </a>
            </div>
        </div>
    </div>
</body>
</html>
