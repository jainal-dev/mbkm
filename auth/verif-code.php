<?php
session_start();
$error = ''; // Initialize error message

// Database connection
$host = 'localhost';
$dbname = 'mbkm'; // your database name
$username = 'root'; // your MySQL username
$password_db = ''; // your MySQL password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password_db);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['new-password']) && isset($_POST['confirm-password'])) {
        $newPassword = $_POST['new-password'];
        $confirmPassword = $_POST['confirm-password'];

        // Basic validation
        if ($newPassword === $confirmPassword) {
            // Hash the password for security
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Assuming you have a valid user ID (from email or token)
            $userId = 1; // Replace this with actual user ID from the session or token

            // Update password in the database
            $stmt = $pdo->prepare("UPDATE user SET password = :password WHERE id = :id");
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':id', $userId);

            if ($stmt->execute()) {
                echo "Password Berhasil Di Ganti.";
            } else {
                echo "Gagal Mengganti Password.";
            }
        } else {
            echo "Kata sandi tidak cocok.";
        }
    } else {
        echo "Data password belum lengkap.";
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="bg-purple-900 flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md">
        <h1 class="text-2xl font-bold text-center mb-4">Reset Kata Sandi</h1>
        <p class="text-green-500 text-center mb-4">Verifikasi Berhasil</p>
        <p class="text-gray-500 text-center mb-6">Silahkan buat Kata Sandi Baru Anda</p>
        <form action="password_reset.php" method="POST">
    <div class="mb-4">
        <label for="new-password" class="block text-gray-700 mb-2">Kata Sandi Baru</label>
        <input type="password" id="new-password" name="new-password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan Kata Sandi Baru" required>
    </div>
    <div class="mb-6">
        <label for="confirm-password" class="block text-gray-700 mb-2">Konfirmasi Kata Sandi</label>
        <div class="relative">
            <input type="password" id="confirm-password" name="confirm-password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Konfirmasi Kata Sandi Anda" required>
            <i class="fas fa-eye absolute right-3 top-3 text-gray-500 cursor-pointer"></i>
        </div>
    </div>
    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition duration-200">Reset Kata Sandi</button>
    <button type="button" class="w-full bg-gray-300 text-gray-700 py-2 rounded-lg mt-4 hover:bg-gray-400 transition duration-200" onclick="window.location.href='../index.php';">Kembali Ke Halaman Utama</button>
</form>
    </div>
    <script>
        // Toggle password visibility
document.querySelector('.fa-eye').addEventListener('click', function () {
    const passwordInput = document.getElementById('new-password');
    const confirmPasswordInput = document.getElementById('confirm-password');
    
    const newType = passwordInput.type === 'password' ? 'text' : 'password';
    passwordInput.type = newType;
    confirmPasswordInput.type = newType;

    this.classList.toggle('fa-eye-slash');
});

    </script>
</body>
</html>
