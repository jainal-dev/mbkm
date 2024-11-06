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
    die("Tidak dapat terhubung ke database $dbname :" . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $nim_nip = $_POST['nim_nip'] ?? '';
    $password = $_POST['password'] ?? '';
    $nama = $_POST['nama'] ?? ''; 
    $id_prodi = $_POST['id_prodi'] ?? ''; 
    $role = $_POST['role'] ?? ''; 

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user) {
        $error = "Username sudah terdaftar.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (username, password, `nim/nip`, `id_prodi`, `nama`, `role`) VALUES (:username, :password, :nim_nip, :id_prodi, :nama, :role)");
        $stmt->execute([
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'nim_nip' => $nim_nip,
            'id_prodi' => $id_prodi, 
            'nama' => $nama, 
            'role' => $role 
        ]);
        $_SESSION['username'] = $username;
        header("Location: login.php");
        exit();
    }
}
$prodi_stmt = $pdo->prepare("SELECT * FROM prodi");
$prodi_stmt->execute();
$prodi_list = $prodi_stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Daftar Akun</title>
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
        }
        .moving-background {
            animation: move 5s linear infinite;
        }

        @keyframes move {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animate-slide-in {
            animation: slide-in 0.5s ease-out forwards;
        }
        @keyframes slide-in {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        .animate-fade-in {
            animation: fade-in 0.5s ease forwards;
        }
        @keyframes fade-in {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body class="moving-background flex items-center justify-center min-h-screen">
    <div class="flex w-full max-w-4xl bg-white rounded-lg shadow-lg overflow-hidden">
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
            <h2 class="text-4xl font-bold text-white mb-2">Daftar Sekarang!</h2>
            <p class="text-white mb-6">Silakan buat akun baru Anda</p>
            <?php if ($error != ''): ?>
                <div class="mb-4 text-red-500">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <form method="post" action="">
                <div class="mb-4">
                    <label class="block text-white mb-2" for="username">Username</label>
                    <input class="w-full p-3 rounded-lg bg-gray-200 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" id="username" name="username" type="text" placeholder="Masukkan Username Anda" required/>
                </div>
                <div class="mb-4">
                    <label class="block text-white mb-2" for="nim_nip">NIM/NIP</label>
                    <input class="w-full p-3 rounded-lg bg-gray-200 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" id="nim_nip" name="nim_nip" type="text" placeholder="Masukkan NIM/NIP Anda" required/>
                </div>
                <div class="mb-4">
                    <label class="block text-white mb-2" for="id_prodi">Program Studi</label>
                    <select class="w-full p-3 rounded-lg bg-gray-200 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" id="id_prodi" name="id_prodi" required>
                        <option value="" disabled selected>Pilih Program Studi</option>
                        <?php foreach ($prodi_list as $prodi): ?>
                            <option value="<?php echo $prodi['id_prodi']; ?>"><?php echo $prodi['nama_prodi']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-white mb-2" for="role">Role</label>
                    <select class="w-full p-3 rounded-lg bg-gray-200 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" id="role" name="role" required>
                        <option value="" disabled selected>Pilih Role</option>
                        <option value="student">Student</option>
                        <option value="lecturer">Lecturer</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="mb-4 relative">
                    <label class="block text-white mb-2" for="password">Kata Sandi</label>
                    <input class="w-full p-3 rounded-lg bg-gray-200 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition" id="password" name="password" type="password" placeholder="Masukkan Kata Sandi Anda" required/>
                    <span toggle="#password" class="fas fa-eye-slash absolute right-2 top-1/2 cursor-pointer" id="togglePassword"></span>
                </div>
                <div class="mb-4">
                    <label class="block text-white mb-2" for="nama">Nama Lengkap</label>
                    <input class="w-full p-3 rounded-lg bg-gray-200 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" id="nama" name="nama" type="text" placeholder="Masukkan Nama Lengkap Anda" required/>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded-lg font-semibold hover:bg-blue-600 transition duration-300">Daftar</button>
            </form>
            <div class="text-center mt-6">
                <a href="login.php" class="bg-gray-400 text-white p-3 rounded-lg font-semibold hover:bg-gray-500 transition duration-300 inline-block">
                    Sudah punya akun? Masuk
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
