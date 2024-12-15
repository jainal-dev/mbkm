<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = 'uploads/'; // Direktori untuk menyimpan file yang diupload
    
    // Buat direktori upload jika belum ada
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $allowedTypes = ['image/png', 'image/jpg', 'image/jpeg', 'application/pdf'];
    $maxFileSize = 5 * 1024 * 1024; // 5MB
    $uploadedFiles = [];
    $errors = [];

    // Periksa apakah file telah dipilih
    if (!empty($_FILES['files']['name'][0])) {
        $fileCount = count($_FILES['files']['name']);

        for ($i = 0; $i < $fileCount; $i++) {
            $fileName = $_FILES['files']['name'][$i];
            $fileTmpName = $_FILES['files']['tmp_name'][$i];
            $fileSize = $_FILES['files']['size'][$i];
            $fileType = $_FILES['files']['type'][$i];

            // Validasi tipe file
            if (!in_array($fileType, $allowedTypes)) {
                $errors[] = "File $fileName tidak diizinkan. Hanya PNG, JPG, dan PDF yang diperbolehkan.";
                continue;
            }

            // Validasi ukuran file
            if ($fileSize > $maxFileSize) {
                $errors[] = "File $fileName terlalu besar. Maksimal 5MB.";
                continue;
            }

            // Generate nama file unik
            $uniqueFileName = uniqid() . '_' . $fileName;
            $uploadFilePath = $uploadDir . $uniqueFileName;

            // Pindahkan file ke direktori upload
            if (move_uploaded_file($fileTmpName, $uploadFilePath)) {
                $uploadedFiles[] = $uniqueFileName;
            } else {
                $errors[] = "Gagal mengunggah file $fileName";
            }
        }
    }

    // Siapkan respon
    if (!empty($uploadedFiles)) {
        echo "<h2>File berhasil diupload:</h2>";
        echo "<ul>";
        foreach ($uploadedFiles as $file) {
            echo "<li>$file</li>";
        }
        echo "</ul>";
    }

    if (!empty($errors)) {
        echo "<h2>Error:</h2>";
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
}
?>