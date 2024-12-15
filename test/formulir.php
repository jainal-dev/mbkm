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
    <title>Form Pengajuan MBKM</title>
</head>
<body>
<h2>Pengajuan Formulir MBKM</h2>
    <form>
        <!-- Existing Fields -->
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
</body>
</html>

    