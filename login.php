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
    die("Tidak dapat terhubung ke database $dbname: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard_mahasiswa.php"); 
        exit();
    } else {
        echo "<script>
                alert('localhost says: Username atau kata sandi salah.');
                window.location.href = 'login.php'; // Redirect kembali ke halaman login
              </script>";
        exit(); 
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>
    <title>Login</title>
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            animation: gradient-animation 10s ease infinite;
            opacity: 0;
            animation: fade-in 1s ease-in-out forwards; 
        }

        @keyframes gradient-animation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes fade-in {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .animate-slide-in {
            animation: slide-in 1s ease-out forwards;
        }

        @keyframes slide-in {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .animate-fade-in {
            animation: fade-in 1.5s ease forwards;
        }

        .hover-animate:hover {
            transform: none; 
            box-shadow: none;
            transition: none;
        }
        .transition {
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="flex w-full max-w-4xl bg-white rounded-lg shadow-lg overflow-hidden transition">
        <div class="w-1/2 flex flex-col items-center justify-center p-10 animate-slide-in">
            <div class="flex items-center mb-4">
                <i class="fas fa-graduation-cap text-2xl text-indigo-900"></i>
                <span class="ml-2 text-indigo-900 font-semibold">PBLTRPL-117</span>
            </div>
            <img alt="Silam Image" src="formulir.png" class="mb-4" height="200" width="300"/>
            <div class="text-center">
                <h1 class="text-4xl font-bold text-blue-900">Kampus Merdeka</h1>
                <p class="text-lg text-yellow-500">INDONESIA JAYA</p>
            </div>
        </div>
        <div class="w-1/2 bg-gradient-to-r from-purple-500 to-blue-500 p-10 flex flex-col justify-center animate-fade-in">
            <div class="flex items-center mb-6">
                <a href="frontend.php" class="text-white text-2xl mr-4 hover-animate">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h2 class="text-4xl font-bold text-white">Masuk Akun Anda!</h2>
            </div>
            <p class="text-white mb-6">Silakan masukkan detail akun Anda</p>
            <?php if ($error != ''): ?>
                <div class="mb-4 text-red-500">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <form method="post" action="">
                <div class="mb-4">
                    <label class="block text-white mb-2" for="username">Username</label>
                    <input class="w-full p-3 rounded-lg bg-gray-200 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition" id="username" name="username" type="text" placeholder="Masukkan Username Anda" required/>
                </div>
                <div class="mb-4 relative">
                    <label class="block text-white mb-2" for="password">Kata Sandi</label>
                    <input class="w-full p-3 rounded-lg bg-gray-200 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition" id="password" name="password" type="password" placeholder="Masukkan Kata Sandi Anda" required/>
                    <span toggle="#password" class="fas fa-eye-slash absolute right-2 top-1/2 cursor-pointer" id="togglePassword"></span>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded-lg font-semibold hover:bg-blue-600 transition duration-300">Masuk</button>
            </form>
            <div class="text-center mt-6">
                <a href="register.php" class="bg-gray-400 text-white p-3 rounded-lg font-semibold hover:bg-gray-500 transition duration-300 inline-block">
                    Belum punya akun? Daftar
                </a>
            </div>
            <div class="text-center mt-6">
                <a href="lupa.php" class="bg-gray-400 text-white p-3 rounded-lg font-semibold hover:bg-gray-500 transition duration-300 inline-block">
                    Lupa Password?
                </a>
            </div>
        </div>
    </div>
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
