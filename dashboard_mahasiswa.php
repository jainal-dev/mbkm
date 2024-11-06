<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            color: #333;
        }
        #sidebar {
            min-height: 100vh;
            background-color: #343a40;
            color: #fff;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            transition: width 0.3s ease;
        }
        #sidebar .nav-link {
            color: #cfd8dc;
            font-weight: 600;
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            font-size: 1.2rem;
        }
        #sidebar .nav-link.active {
            background-color: #00b4d8;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        #sidebar .nav-link:hover {
            background-color: #0077b6;
            color: white;
            transform: scale(1.05);
        }
        #sidebar .nav-link i {
            margin-right: 10px;
        }
        .collapse-inner {
            padding-left: 20px;
        }
        .collapse-inner .nav-link {
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }
        .content {
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            margin-top: 20px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeIn 0.5s forwards;
            display: none;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .content.active {
            display: block;
        }
        .content h2 {
            font-weight: bold;
            color: #0077b6;
            margin-bottom: 20px;
        }
        .form-label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #00b4d8;
            border: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn-primary:hover {
            background-color: #0077b6;
            transform: scale(1.05);
        }
        #sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            overflow-y: auto;
        }
        main {
            margin-left: 240px;
            transition: margin-left 0.3s ease;
        }
        @media (max-width: 768px) {
            #sidebar {
                display: none;
            }
            main {
                margin-left: 0;
            }
        }
        .toggle-btn {
            background-color: #0077b6;
            color: white;
            border: none;
            position: fixed;
            top: 10px;
            left: 10px;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            display: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .toggle-btn:hover {
            background-color: #005f80;
            transform: scale(1.05);
        }
        @media (max-width: 768px) {
            .toggle-btn {
                display: block;
            }
        }
    </style>
</head>
<body>

<button class="toggle-btn" onclick="toggleSidebar()">☰ Menu</button>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#dashboard" onclick="showContent('dashboard', this)">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#mbkmSubmenu" aria-expanded="false">
                            <i class="fas fa-folder-open"></i>Program MBKM
                        </a>
                        <div class="collapse" id="mbkmSubmenu">
                            <div class="collapse-inner">
                                <a class="nav-link" href="#formulir" id="sidebar-formulir" onclick="showContent('formulir', this)">+ Pengajuan Formulir MBKM</a>
                                <a class="nav-link" href="#persetujuan" id="sidebar-persetujuan" onclick="showContent('persetujuan', this)">+ Persetujuan</a>
                                <a class="nav-link" href="#pengumpulan" id="sidebar-pengumpulan" onclick="showContent('pengumpulan', this)">+ Pengumpulan Berkas Akhir</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#penilaianSubmenu" aria-expanded="false">
                            <i class="fas fa-star"></i> Penilaian
                        </a>
                        <div class="collapse" id="penilaianSubmenu">
                            <div class="collapse-inner">
                                <a class="nav-link" href="#penilaian-mbkm" id="sidebar-mbkm">+ Nilai Program MBKM</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#settingsSubmenu" aria-expanded="false">
                            <i class="fas fa-cogs"></i> Pengaturan
                        </a>
                        <div class="collapse" id="settingsSubmenu">
                            <div class="collapse-inner">
                                <a class="nav-link" href="#profil" id="sidebar-profil" onclick="showContent('profil', this)">+ Profil</a>
                                <a class="nav-link" href="#ubah-password" id="sidebar-password" onclick="showContent('ubah-password', this)">+ Ubah Password</a>
                                <a class="nav-link" href="javascript:void(0)" id="sidebar-logout" onclick="confirmLogout()">+ Keluar</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div id="dashboard" class="content active">
                <h2>Dashboard Mahasiswa</h2>
                <p>Selamat datang di dashboard MBKM. Akses menu di sidebar untuk mulai mengisi formulir, melihat persetujuan, dan pengumpulan berkas akhir.</p>

               
                <h3>Jumlah Mahasiswa dan Dosen</h3>
                <canvas id="mahasiswaDosenChart" width="650" height="300"></canvas>
            </div>

            <div id="formulir" class="content">
    <h2>Pengajuan Formulir MBKM</h2>
    <form>
        <div class="mb-3">
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
                <option value="4">Pengajuan Acara Formal / Non Formal</option>
            </select>
        </div>
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
            <div id="persetujuan" class="content">
                <h2>Persetujuan</h2>
                <p>Halaman ini akan menampilkan status persetujuan pengajuan Anda.</p>
            </div>

            <div id="pengumpulan" class="content">
                <h2>Pengumpulan Berkas Akhir</h2>
                <form>
                    <div class="mb-3">
                        <label for="berkasAkhir" class="form-label">Upload Berkas Akhir</label>
                        <input type="file" class="form-control" id="berkasAkhir">
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </form>
            </div>

            <div id="penilaian-mbkm" class="content">
                <h2>Nilai Program MBKM</h2>
                <p>Halaman ini akan menampilkan nilai Anda untuk program MBKM.</p>
            </div>

            <div id="profil" class="content">
                <h2>Profil</h2>
                <p>Halaman ini menampilkan detail profil Anda.</p>
            </div>

            <div id="ubah-password" class="content">
                <h2>Ubah Password</h2>
                <form>
                    <div class="mb-3">
                        <label for="passwordLama" class="form-label">Password Lama</label>
                        <input type="password" class="form-control" id="passwordLama" placeholder="Masukkan Password Lama">
                    </div>
                    <div class="mb-3">
                        <label for="passwordBaru" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" id="passwordBaru" placeholder="Masukkan Password Baru">
                    </div>
                    <button type="submit" class="btn btn-primary">Ubah Password</button>
                </form>
            </div>
        </main>
    </div>
</div>

<script>
    function showContent(contentId, link) {
        const contents = document.querySelectorAll('.content');
        contents.forEach(content => {
            content.classList.remove('active');
        });
        document.getElementById(contentId).classList.add('active');

        const links = document.querySelectorAll('.nav-link');
        links.forEach(link => {
            link.classList.remove('active');
        });
        link.classList.add('active');
    }

    const ctx = document.getElementById('mahasiswaDosenChart').getContext('2d');
    const mahasiswaDosenChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Mahasiswa', 'Dosen'],
            datasets: [{
                label: 'Jumlah',
                data: [50, 10],
                backgroundColor: ['#0077b6', '#00b4d8'],
                borderColor: ['#005f80', '#0082b8'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });


    function confirmLogout() {
    var confirmation = confirm("Apakah Anda yakin ingin keluar?");
    if (confirmation) {
        window.location.href = 'frontend.php';
    }
}
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.querySelector('main');

        sidebar.classList.toggle('hide');
        mainContent.classList.toggle('sidebar-hide');
    }
</script>
</body>
</html>
