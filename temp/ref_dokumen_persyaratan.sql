-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 25, 2018 at 06:23 AM
-- Server version: 5.5.56
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ppdb_sulsel`
--

-- --------------------------------------------------------

--
-- Table structure for table `ref_dokumen_persyaratan`
--


--
-- Dumping data for table `ref_dokumen_persyaratan`
--

INSERT INTO `ref_dokumen_persyaratan` (`ref_dokumen_id`, `nama_dokumen`) VALUES
(1, 'Kartu Keluarga'),
(2, 'Ijazah/STTB SM/bentuk lain yang sederajat'),
(3, 'SHUN/SKHUN SMP/bentuk lain yang sederajat'),
(4, 'Kartu Keluarga Sejahtera (KKS)'),
(5, 'Kartu Indonesia Sehat (KIS)'),
(6, 'Kartu Indonesia Pintar (KIP)'),
(7, 'Kartu Perlindungan Sosial (KPS)'),
(8, 'Kartu Harapan Sejahtera (KHS)'),
(9, 'Dokumen Lainnya');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ref_dokumen_persyaratan`
--
ALTER TABLE `ref_dokumen_persyaratan`
  ADD PRIMARY KEY (`ref_dokumen_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
