-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2024 at 12:19 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mbkm`
--

-- --------------------------------------------------------

--
-- Table structure for table `berkas_akhir`
--

CREATE TABLE `berkas_akhir` (
  `id_berkas` int(11) NOT NULL,
  `lokasi_berkas` varchar(255) NOT NULL,
  `waktu_submisi` date NOT NULL,
  `id_pengajuan` int(11) NOT NULL,
  `nim` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mitra`
--

CREATE TABLE `mitra` (
  `id_mitra` int(11) NOT NULL,
  `nama_mitra` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `id_nilai` int(11) NOT NULL,
  `nilai_akhir` float NOT NULL,
  `id_pengajuan` int(11) NOT NULL,
  `nim` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan`
--

CREATE TABLE `pengajuan` (
  `id_pengajuan` int(11) NOT NULL,
  `waktu` datetime NOT NULL,
  `durasi_kegiatan` int(2) NOT NULL,
  `status_pengajuan` varchar(50) NOT NULL,
  `id_mitra` int(11) NOT NULL,
  `id_program` int(11) NOT NULL,
  `nim` int(12) NOT NULL,
  `rincian_kegiatan` varchar(100) NOT NULL,
  `jenis_pertukaran_pelajar` varchar(100) NOT NULL,
  `posisi_di_perusahaan` varchar(50) NOT NULL,
  `alasan_memilih_program` varchar(100) NOT NULL,
  `nama_prodi_tujuan` varchar(100) NOT NULL,
  `jumlah_anggota` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prodi`
--

CREATE TABLE `prodi` (
  `id_prodi` int(11) NOT NULL,
  `kode_prodi` varchar(20) NOT NULL,
  `nama_prodi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prodi`
--

INSERT INTO `prodi` (`id_prodi`, `kode_prodi`, `nama_prodi`) VALUES
(1, '001', 'TRPL'),
(2, '002', 'TRM'),
(3, '003', 'IF'),
(4, '004', 'RKS');

-- --------------------------------------------------------

--
-- Table structure for table `program`
--

CREATE TABLE `program` (
  `id_program` int(11) NOT NULL,
  `nama_program` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `nama` varchar(100) NOT NULL,
  `role` enum('admin','mahasiswa','dosen','') NOT NULL,
  `password` varchar(100) NOT NULL,
  `id_prodi` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `nim` int(12) NOT NULL,
  `foto` mediumblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`nama`, `role`, `password`, `id_prodi`, `username`, `nim`, `foto`) VALUES
('', 'admin', '', 1, '', 1, ''),
('zaky', 'admin', '$2y$10$QPOApOoktJWmemkk2sbrQ.arQJ4c1u0M0qHlaehpiYdHDo1NtAwki', 1, 'zaky', 213110, NULL),
('Agus', 'mahasiswa', '$2y$10$Tal0wrOqBKs1VuZKAhXVE.PVM1jz8MSGwP5n0itUpdBCJ3rSasbBK', 4, 'riadyagus1', 224345, ''),
('habzz', 'admin', '$2y$10$R9iMldrzS2MqwfnU81cyyetv8iMSrFU9CX7CN9wkAOue94RWgiy1i', 1, 'abinubli', 2147483647, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `berkas_akhir`
--
ALTER TABLE `berkas_akhir`
  ADD PRIMARY KEY (`id_berkas`),
  ADD KEY `id_pengajuan` (`id_pengajuan`),
  ADD KEY `nim` (`nim`);

--
-- Indexes for table `mitra`
--
ALTER TABLE `mitra`
  ADD PRIMARY KEY (`id_mitra`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `id_pengajuan` (`id_pengajuan`),
  ADD KEY `nim` (`nim`);

--
-- Indexes for table `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD PRIMARY KEY (`id_pengajuan`),
  ADD KEY `id_mitra` (`id_mitra`),
  ADD KEY `id_program` (`id_program`),
  ADD KEY `nim` (`nim`);

--
-- Indexes for table `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`id_prodi`);

--
-- Indexes for table `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`id_program`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`nim`),
  ADD KEY `id_prodi` (`id_prodi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `berkas_akhir`
--
ALTER TABLE `berkas_akhir`
  MODIFY `id_berkas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mitra`
--
ALTER TABLE `mitra`
  MODIFY `id_mitra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengajuan`
--
ALTER TABLE `pengajuan`
  MODIFY `id_pengajuan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prodi`
--
ALTER TABLE `prodi`
  MODIFY `id_prodi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `program`
--
ALTER TABLE `program`
  MODIFY `id_program` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `nim` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2147483648;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `berkas_akhir`
--
ALTER TABLE `berkas_akhir`
  ADD CONSTRAINT `berkas_akhir_ibfk_1` FOREIGN KEY (`id_pengajuan`) REFERENCES `program` (`id_program`),
  ADD CONSTRAINT `berkas_akhir_ibfk_2` FOREIGN KEY (`nim`) REFERENCES `user` (`nim`);

--
-- Constraints for table `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`id_pengajuan`) REFERENCES `pengajuan` (`id_pengajuan`),
  ADD CONSTRAINT `nilai_ibfk_2` FOREIGN KEY (`nim`) REFERENCES `user` (`nim`);

--
-- Constraints for table `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD CONSTRAINT `pengajuan_ibfk_1` FOREIGN KEY (`id_mitra`) REFERENCES `mitra` (`id_mitra`),
  ADD CONSTRAINT `pengajuan_ibfk_2` FOREIGN KEY (`id_program`) REFERENCES `program` (`id_program`),
  ADD CONSTRAINT `pengajuan_ibfk_3` FOREIGN KEY (`nim`) REFERENCES `user` (`nim`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_prodi`) REFERENCES `prodi` (`id_prodi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
