<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRPL 117-3</title>
    <link rel="stylesheet" href="style.css">
    <style>
#content {
    background-color: #f9f9f9; /* Light gray background */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    margin: 20px auto;
    max-width: 800px;
    transition: transform 0.3s ease-in-out;
}

#content:hover {
    transform: scale(1.02); /* Slight scaling on hover */
}

/* Headings */
#content h2 {
    color: #1e90ff; /* Dodger blue */
    text-align: center;
    margin-bottom: 20px;
}

/* Form Container */
#content form {
    background-color: #ffffff; /* White form background */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease-in-out;
}

#content form:hover {
    transform: translateY(-3px); /* Slight lift effect */
}

/* Form Labels */
#content .form-label {
    color: #1e90ff;
    font-weight: bold;
}

/* Form Inputs and Select Fields */
#content .form-control,
#content .form-select {
    border: 1px solid #1e90ff;
    border-radius: 4px;
    padding: 10px;
    width: 100%;
    margin-bottom: 15px;
    transition: box-shadow 0.3s ease, border-color 0.3s ease;
}

#content .form-control:focus,
#content .form-select:focus {
    outline: none;
    border-color: #4682b4;
    box-shadow: 0 0 8px rgba(30, 144, 255, 0.5);
    background-color: #f0f8ff; /* Light blue background on focus */
}

/* Buttons */
#content .btn-primary {
    background-color: #1e90ff;
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 4px;
    transition: background-color 0.3s ease, transform 0.3s ease;
    margin-top: 10px;
    display: block;
    width: 100%; /* Full-width button */
    text-align: center;
}

#content .btn-primary:hover {
    background-color: #4682b4;
    transform: scale(1.05); /* Scale slightly on hover */
}

#content .btn-primary:active {
    transform: scale(0.98); /* Slight press-down effect */
}

/* Error Message Example (Optional) */
#content .error {
    color: red;
    font-size: 0.9rem;
    margin-top: -10px;
    margin-bottom: 15px;
}

    </style>
</head>
<body>
    <div class="container">
        <!-- Navbar -->
        <div class="navbar">
            <ul>
                <li>
                    <a href="">
                        <span class="logo"><img src="polibatam-white.png" width="40px" alt=""></span>
                        <span class="tim">Project Base Learning TRPL 117-3</span>
                    </a>
                </li>
                <li>
                    <a href="#" id="dashboardMenu">
                        <span class="icon"><ion-icon name="grid-outline"></ion-icon></span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#" id="pengajuanMenu">
                        <span class="icon"><ion-icon name="school-outline"></ion-icon></span>
                        <span class="title">Pengajuan MBKM</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
                <img src="prof.jpg" class="user" onclick="menu()">
            </div>

            <!-- Dynamic Content Section -->
            <div id="content">
                <h1>Welcome to Dashboard</h1>
                <p>Select a menu from the sidebar to get started.</p>
            </div>
        </div>

        <!-- Sub Menu -->
        <div class="sub-menu-wrap" id="subMenu">
            <div class="sub-menu">
                <a href="session_destroy.php" class="link">
                    <ion-icon name="log-out-outline"></ion-icon>
                    <p>Logout</p>
                </a>
                <a href="" class="link">
                    <ion-icon name="card-outline"></ion-icon>
                    <p>Edit Profile</p>
                </a>
            </div>
        </div>
    </div>

    <!-- ======== script ======== -->
    <script src="main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <!-- Dynamic Content Switching Script -->
    <script>
        // Add event listeners to sidebar menu items
        document.getElementById('dashboardMenu').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('content').innerHTML = `
                <h1>Welcome to Dashboard</h1>
                <p>Select a menu from the sidebar to get started.</p>
            `;
        });

        document.getElementById('pengajuanMenu').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('content').innerHTML = `
                <h2>Pengajuan Formulir MBKM</h2>
    <form>
        <!-- Existing Fields -->
        <div class="lol">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" placeholder="Masukkan Nama Anda">
        </div>
        <div class="mb-3">
            <label for="nim" class="form-label">NIM</label>
            <input type="text" class="form-control" id="nim" placeholder="Masukkan NIM Anda">
        </div>
        <div class="mb-3">
            <label for="programStudiAsal" class="form-label">Program Studi Asal</label>
            <input type="text" class="form-control" id="programStudiAsal" placeholder="Program Studi Asal">
        </div>
        <div class="mb-3">
            <label for="dosenPembimbing" class="form-label">Dosen Pembimbing</label>
            <input type="text" class="form-control" id="dosenPembimbing" placeholder="Masukkan Nama Dosen Pembimbing">
        </div>
        <div class="mb-3">
            <label for="jenisProgramMbkm" class="form-label">Jenis Program MBKM</label>
            <select class="form-select" id="jenisProgramMbkm">
                <option selected>Pilih Jenis Program MBKM</option>
                <option value="1">Magang/Praktik Kerja</option>
                <option value="2">Pertukaran Pelajar</option>
                <option value="3">Proyek Kemanusiaan</option>
            </select>
        </div>

        <!-- New Fields -->
        <div class="mb-3">
            <label for="alasanMemilihProgram" class="form-label">Alasan Memilih Program</label>
            <textarea class="form-control" id="alasanMemilihProgram" rows="3" placeholder="Jelaskan alasan memilih program ini"></textarea>
        </div>

        <div class="mb-3">
            <label for="judulProgram" class="form-label">Judul Program/Kegiatan</label>
            <input type="text" class="form-control" id="judulProgram" placeholder="Masukkan Judul Program atau Kegiatan">
        </div>

        <div class="mb-3">
            <label for="namaLembaga" class="form-label">Nama Lembaga/Mitra/Usaha</label>
            <input type="text" class="form-control" id="namaLembaga" placeholder="Masukkan Nama Lembaga atau Mitra">
        </div>

        <div class="mb-3">
            <label for="durasiKegiatan" class="form-label">Durasi Kegiatan</label>
            <input type="text" class="form-control" id="durasiKegiatan" placeholder="Masukkan Durasi Kegiatan (misal: 6 bulan)">
        </div>

        <div class="mb-3">
            <label for="posisiPerusahaan" class="form-label">Posisi di Perusahaan</label>
            <input type="text" class="form-control" id="posisiPerusahaan" placeholder="Masukkan Posisi yang Ditempati">
        </div>

        <div class="mb-3">
            <label for="rincianKegiatan" class="form-label">Rincian Kegiatan</label>
            <textarea class="form-control" id="rincianKegiatan" rows="4" placeholder="Jelaskan rincian kegiatan yang dilakukan"></textarea>
        </div>

        <!-- For Program Membangun Desa/Kuliah Kerja Nyata Tematik -->
        <div class="mb-3">
            <label class="form-label">Sumber Pendanaan (Jika Ada)</label>
            <input type="text" class="form-control" id="sumberPendanaan" placeholder="Masukkan Sumber Pendanaan">
        </div>
        <div class="mb-3">
            <label class="form-label">Jumlah Anggota</label>
            <input type="number" class="form-control" id="jumlahAnggota" placeholder="Masukkan Jumlah Anggota">
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Anggota</label>
            <textarea class="form-control" id="namaAnggota" rows="3" placeholder="Masukkan Nama Anggota"></textarea>
        </div>

        <!-- For Program Pertukaran Pelajar -->
        <div class="mb-3">
            <label class="form-label">Jenis Pertukaran Pelajar</label>
            <select class="form-select" id="jenisPertukaranPelajar">
                <option selected>Pilih Jenis Pertukaran Pelajar</option>
                <option value="1">Antar Prodi di Politeknik Negeri Batam</option>
                <option value="2">Antar Prodi pada Perguruan Tinggi yang berbeda</option>
                <option value="3">Prodi sama pada Perguruan Tinggi yang berbeda</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Program Studi Tujuan</label>
            <input type="text" class="form-control" id="programStudiTujuan" placeholder="Masukkan Nama Program Studi Tujuan">
        </div>

        <div class="mb-3">
            <label class="form-label">Matakuliah yang diambil di Program Studi Tujuan</label>
            <textarea class="form-control" id="matakuliahDiambil" rows="3" placeholder="[Kode] – [Nama Matakuliah] [Jumlah SKS]"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Matakuliah yang diklaim</label>
            <textarea class="form-control" id="matakuliahDiklaim" rows="3" placeholder="Cantumkan Kode, Nama Matakuliah, dan SKS"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Ajukan</button>
    </form>
</div>
            `;
        });

        function menu() {
            document.getElementById('subMenu').classList.toggle('open-menu');
        }
    </script>
</body>
</html>
