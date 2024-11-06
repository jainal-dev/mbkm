<?php
// Informasi koneksi ke database
$host = 'localhost'; // Nama host, biasanya 'localhost'
$dbname = 'mbkm';    // Nama database Anda
$username = 'root';  // Username MySQL Anda (biasanya 'root' untuk lokal)
$password_db = '';   // Password MySQL Anda (kosong untuk lokal atau sesuai konfigurasi Anda)

try {
    // Membuat objek PDO untuk koneksi ke database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password_db);

    // Mengatur mode error PDO untuk menampilkan exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mengatur encoding karakter ke UTF-8
    $pdo->exec("set names utf8");

    // Jika koneksi berhasil, Anda bisa menghapus echo ini
    // echo "Koneksi ke database berhasil!";
} catch (PDOException $e) {
    // Menangani kesalahan koneksi
    die("Tidak dapat terhubung ke database $dbname: " . $e->getMessage());
}
?>
