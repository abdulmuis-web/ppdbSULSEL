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
-- Table structure for table `pengaturan_bobot_prestasi`
--


--
-- Dumping data for table `pengaturan_bobot_prestasi`
--

INSERT INTO `pengaturan_bobot_prestasi` (`pengaturan_bobot_id`, `tkt_kejuaraan_id`, `thn_pelajaran`, `bobot_juara1`, `bobot_juara2`, `bobot_juara3`) VALUES
(1, 1, '2018/2019', 100, 90, 80),
(2, 2, '2018/2019', 70, 60, 50),
(3, 3, '2018/2019', 40, 30, 20),
(4, 4, '2018/2019', 10, 8, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pengaturan_bobot_prestasi`
--
ALTER TABLE `pengaturan_bobot_prestasi`
  ADD PRIMARY KEY (`pengaturan_bobot_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pengaturan_bobot_prestasi`
--
ALTER TABLE `pengaturan_bobot_prestasi`
  MODIFY `pengaturan_bobot_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
