-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2021 at 01:38 PM
-- Server version: 10.4.18-MariaDB-log
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko`
--

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `IdProduk` int(11) NOT NULL,
  `KodeProduk` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NamaProduk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `HargaJual` int(11) DEFAULT NULL,
  `Stok` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`IdProduk`, `KodeProduk`, `NamaProduk`, `HargaJual`, `Stok`) VALUES
(2, '8999999273378', 'CONERLLO CHOCOLUV 135', 25000, 100),
(3, '8999999275556', 'WALLS NINJA JELLY', 25000, 100),
(4, '8999999275563', 'NINJA EAGLE SURP', 25000, 100),
(5, '8999999275570', 'RAINBOW PEAK', 25000, 100),
(6, '8999999275587', 'PADDLE POP CHOKO KICK', 25000, 100),
(7, '8999999278458', 'CONELO DISC VAN', 25000, 100);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `IdUser` int(11) NOT NULL,
  `Username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NamaLengkap` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NoHp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ApiKey` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`IdUser`, `Username`, `NamaLengkap`, `Email`, `NoHp`, `Password`, `ApiKey`) VALUES
(1, 'user', 'User', 'user@user.com', '0822222222222', 'user1234', 'TVXYQc8WVp1jJHLpVRLXvs4tuoXHVSg0'),
(3, 'dikkyuser', 'dikky', 'dikky@gmail.com', '08383838383', 'cobaan', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJJZFVzZXIiOiIzIiwiVXNlcm5hbWUiOiJkaWtreSJ9.9VuXvUeQh6_I1dTqzisgJadOgD0SAsl9xfP4nP77csg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`IdProduk`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`IdUser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `IdProduk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `IdUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
