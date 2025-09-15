-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 12, 2025 at 05:28 PM
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
-- Database: `library_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `all_users`
--

CREATE TABLE `all_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','librarian','student') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `all_users`
--

INSERT INTO `all_users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Sabbir', 'sabbir@gmail.com', '$2y$10$L/zPd8fflwsV98Aprn8vyeVSHtxDcy6AxC9G9by4Fw.FjFLyuWTCu', 'admin'),
(3, 'Hossain ', 'hossain@gmail.com', '$2y$10$wLRr8iDmTX6nyLVX4VP6Eef60UwN.YRx5dH4xyreuTTjyRR/6407W', 'librarian'),
(5, 'Niyaz', 'niyaz@gmail.com', '$2y$10$fbWknEBAdZeAReAiQhs1VuLTKw4/IHXcd6xIee7byGoGAiNCuFxF.', 'student'),
(8, 'st', 'sabbirt@gmail.com', '$2y$10$IZsBiAsSJcoYZ6/oBK9xf.33BBMKVgHuyH9gahhHscfwwapUrCtz2', 'admin'),
(9, 'test', 'test@gmail.com', '$2y$10$J4luMO0rpKH3SJ7pfvEnVOHdFkWRQDVI4M7MMSvVUOJ.3Di/6iMg2', 'admin'),
(10, 'testl', 'testl@gmail.com', '$2y$10$/48UYG8HN7WR4wEzxeLK4uaQcjuDVn3utdLQpoiEkARnlwGsueqKa', 'student'),
(11, 'new Admin', 'nadmin@gmail.com', '$2y$10$mVx8DnjqNInIXY3pOaBVCeEyVH0xfnhaN3m9Mq4kvUpqSNDspFHQe', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `all_users`
--
ALTER TABLE `all_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `all_users`
--
ALTER TABLE `all_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
