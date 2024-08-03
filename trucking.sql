-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2024 at 05:25 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trucking`
--

-- --------------------------------------------------------

--
-- Table structure for table `list_harga`
--

CREATE TABLE `list_harga` (
  `id` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `secure_id` varchar(52) NOT NULL,
  `muat_id` int(11) NOT NULL,
  `bongkar_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `mobil_id` int(11) NOT NULL,
  `harga` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `list_harga`
--

INSERT INTO `list_harga` (`id`, `created_date`, `modified_date`, `secure_id`, `muat_id`, `bongkar_id`, `vendor_id`, `mobil_id`, `harga`) VALUES
(4, '2024-07-19 00:01:43', '2024-08-03 14:13:57', '14d8b614-4562-11ef-acaf-220b742ac1dc', 6, 7, 4, 4, 500000000),
(5, '2024-07-19 00:01:54', '2024-07-19 00:01:54', '1bc3fcc2-4562-11ef-a92c-220b742ac1dc', 7, 6, 4, 5, 5000000),
(6, '2024-07-20 13:50:34', '2024-07-20 13:50:34', '097be14a-469f-11ef-94fe-7547ce3ef6f6', 6, 10, 6, 5, 500000),
(7, '2024-07-20 13:50:49', '2024-07-20 13:50:49', '12545ff4-469f-11ef-b080-95d37daaef63', 6, 10, 6, 4, 1000000),
(8, '2024-08-03 14:15:11', '2024-08-03 14:15:11', 'cb8a796e-51a2-11ef-957c-7d475141968a', 6, 10, 1, 4, 5000000000),
(9, '2024-08-03 14:17:20', '2024-08-03 14:17:20', '184880fc-51a3-11ef-8278-7d6f0dc2dc8d', 11, 6, 1, 4, 23232300),
(10, '2024-08-03 14:18:14', '2024-08-03 14:18:14', '38cb3590-51a3-11ef-a170-d7601d63302f', 12, 11, 4, 5, 23232300);

-- --------------------------------------------------------

--
-- Table structure for table `mobil`
--

CREATE TABLE `mobil` (
  `id` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `secure_id` varchar(52) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mobil`
--

INSERT INTO `mobil` (`id`, `created_date`, `modified_date`, `secure_id`, `nama`) VALUES
(4, '2024-07-18 23:53:26', '2024-08-03 14:10:20', 'ed0ed3a8-4560-11ef-8367-220b742ac1dc', 'Honda'),
(5, '2024-07-19 00:00:49', '2024-07-20 13:49:25', 'f4faabfe-4561-11ef-9c50-220b742ac1dc', 'Mitsubishi'),
(6, '2024-07-19 00:00:54', '2024-07-20 13:49:28', 'f7a7d4bc-4561-11ef-b57e-220b742ac1dc', 'Toyota');

-- --------------------------------------------------------

--
-- Table structure for table `muat_bongkar`
--

CREATE TABLE `muat_bongkar` (
  `id` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `secure_id` varchar(52) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `muat_bongkar`
--

INSERT INTO `muat_bongkar` (`id`, `created_date`, `modified_date`, `secure_id`, `nama`) VALUES
(6, '2024-07-16 00:21:55', '2024-07-16 00:21:55', '67f635d4-4309-11ef-962c-e89c2592bb8d', 'Jakarta Barat'),
(7, '2024-07-16 00:21:57', '2024-07-16 00:21:57', '698fc9e6-4309-11ef-b35a-e89c2592bb8d', 'Jakarta Timur'),
(10, '2024-07-20 13:48:45', '2024-07-20 13:48:48', 'c883a83a-469e-11ef-8907-b3c1f5012b37', 'Jakarta Utara'),
(11, '2024-08-03 14:17:09', '2024-08-03 14:17:09', '120bb402-51a3-11ef-b048-bb69a187ce8d', 'Priok'),
(12, '2024-08-03 14:18:06', '2024-08-03 14:18:06', '33cf6034-51a3-11ef-8719-f7b3bc8e9297', 'Jakarta Borot');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `secure_id` varchar(52) NOT NULL,
  `role` varchar(20) NOT NULL COMMENT 'MASTER | ADMIN | MEMBER',
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `created_date`, `modified_date`, `secure_id`, `role`, `username`, `password`) VALUES
(1, '2024-07-15 00:23:49', '2024-07-15 00:56:04', '820b19fd-4240-11ef-9384-e89c2592bb8d', 'MASTER', 'master', '60860627d939017b5d02866ccab695da'),
(2, '2024-07-15 00:43:31', '2024-07-15 00:43:31', '42361bc3-4243-11ef-9384-e89c2592bb8d', 'ADMIN', 'admin', 'c3284d0f94606de1fd2af172aba15bf3'),
(3, '2024-07-15 00:43:31', '2024-07-15 00:43:31', '423629d8-4243-11ef-9384-e89c2592bb8d', 'MEMBER', 'member', '14d0f2bb475dbcdc51de4b406857fc62');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `id` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `secure_id` varchar(52) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `mobil_id` varchar(100) NOT NULL COMMENT '["1","2"]'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`id`, `created_date`, `modified_date`, `secure_id`, `nama`, `mobil_id`) VALUES
(1, '2024-07-16 03:06:25', '2024-07-18 23:55:16', '63863e95-4320-11ef-8c61-e89c2592bb8d', 'Vendor A', '[\"4\"]'),
(4, '2024-07-19 00:01:07', '2024-07-19 00:01:07', 'ffa20570-4561-11ef-9ab5-220b742ac1dc', 'Vendor B', '[\"4\",\"5\",\"6\"]'),
(5, '2024-07-20 13:49:56', '2024-07-20 13:49:56', 'f29695ec-469e-11ef-a386-5f9a9c33a510', 'Vendor C', '[\"4\"]'),
(6, '2024-07-20 13:50:01', '2024-07-20 13:50:09', 'f60c0ba8-469e-11ef-8516-03daf4aaa9d7', 'Vendor D', '[\"4\",\"5\"]'),
(7, '2024-07-20 14:04:51', '2024-07-20 14:04:51', '08539428-46a1-11ef-906e-11ae96cf42e9', 'Vendor E', '[\"5\"]');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `list_harga`
--
ALTER TABLE `list_harga`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mobil`
--
ALTER TABLE `mobil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `muat_bongkar`
--
ALTER TABLE `muat_bongkar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `list_harga`
--
ALTER TABLE `list_harga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `mobil`
--
ALTER TABLE `mobil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `muat_bongkar`
--
ALTER TABLE `muat_bongkar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
