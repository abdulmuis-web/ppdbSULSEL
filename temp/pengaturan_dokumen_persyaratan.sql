-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 06, 2018 at 09:43 PM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u4201654_ppdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan_dokumen_persyaratan`
--

--
-- Dumping data for table `pengaturan_dokumen_persyaratan`
--

INSERT INTO `pengaturan_dokumen_persyaratan` (`pengaturan_dokumen_id`, `jalur_id`, `thn_pelajaran`, `dokumen_id`, `status`) VALUES
(1, 1, '2018/2019', 1, 'mandatory'),
(2, 1, '2018/2019', 2, 'mandatory'),
(3, 1, '2018/2019', 3, 'mandatory'),
(4, 2, '2018/2019', 1, 'mandatory'),
(5, 2, '2018/2019', 2, 'mandatory'),
(6, 2, '2018/2019', 3, 'mandatory'),
(7, 2, '2018/2019', 9, 'mandatory'),
(8, 2, '2018/2019', 10, 'mandatory'),
(9, 3, '2018/2019', 1, 'mandatory'),
(10, 3, '2018/2019', 2, 'mandatory'),
(11, 3, '2018/2019', 3, 'mandatory'),
(12, 4, '2018/2019', 1, 'mandatory'),
(13, 4, '2018/2019', 2, 'mandatory'),
(14, 4, '2018/2019', 3, 'mandatory'),
(15, 5, '2018/2019', 1, 'mandatory'),
(16, 5, '2018/2019', 2, 'mandatory'),
(17, 5, '2018/2019', 3, 'mandatory'),
(18, 5, '2018/2019', 11, 'mandatory'),
(19, 1, '2018/2019', 12, 'optional'),
(20, 2, '2018/2019', 12, 'optional'),
(21, 3, '2018/2019', 12, 'optional'),
(22, 4, '2018/2019', 12, 'optional'),
(23, 5, '2018/2019', 12, 'optional');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pengaturan_dokumen_persyaratan`
--
ALTER TABLE `pengaturan_dokumen_persyaratan`
  ADD PRIMARY KEY (`pengaturan_dokumen_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
