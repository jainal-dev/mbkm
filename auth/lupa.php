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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        // Generate a unique token
        $token = bin2hex(random_bytes(50));

        // Save the token in the database with an expiration time (e.g., 10 minutes)
        $stmt = $pdo->prepare("UPDATE user SET reset_token = :token, token_expiry = DATE_ADD(NOW(), INTERVAL 10 MINUTE) WHERE email = :email");
        $stmt->execute(['token' => $token, 'email' => $email]);

        $success = "Token untuk mereset kata sandi telah berhasil dibuat.";

        // Redirect to the verification page with the token as a query parameter
        header('Location: verifikasi-code.php?email=' . urlencode($email) . '&token=' . urlencode($token));
        exit; // Ensure the script stops executing after redirect
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
    </style>
    <title>Lupa Password</title>
</head>
<body class="moving-background flex items-center justify-center min-h-screen">
    <div class="flex w-full max-w-md bg-white rounded-lg shadow-lg overflow-hidden p-10">
        <div class="w-full flex flex-col items-center justify-center">
            <h2 class="text-4xl font-bold text-indigo-900 mb-6">Lupa Kata Sandi</h2>
            <p class="text-gray-500 mb-4 text-center">Masukkan email Anda, kami akan membuat token untuk mengatur ulang kata sandi Anda.</p>
            
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
                <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded-lg font-semibold hover:bg-blue-600 transition duration-300">Kirim Token</button>
            </form>

            <div class="text-center mt-6">
                <a href="../index.php" class="bg-red-400 text-white p-3 rounded-lg font-semibold hover:bg-white-500 transition duration-300 inline-block">
                    Kembali Ke Halaman Utama
                </a>
            </div>
        </div>
    </div>
</body>
</html>
