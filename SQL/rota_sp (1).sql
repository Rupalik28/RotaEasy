-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2024 at 05:22 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rota_sp`
--

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `id` int(11) NOT NULL,
  `row_id` int(11) NOT NULL,
  `column_name` varchar(255) NOT NULL,
  `value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`id`, `row_id`, `column_name`, `value`) VALUES
(1, 0, '0', 'Date'),
(2, 0, '1', 'Day'),
(3, 0, '2', 'Rupali'),
(4, 0, '3', 'Shivani'),
(5, 0, '4', 'Haleem'),
(6, 0, '5', 'Anuhk'),
(7, 0, '6', 'Subha'),
(8, 0, '7', 'Jaya'),
(9, 0, '8', 'Shital'),
(10, 0, '9', 'Chanti'),
(11, 0, '10', 'Kelam'),
(12, 0, '11', 'Abhilash'),
(13, 0, '12', 'Suruchi'),
(14, 0, '13', 'Vishal'),
(15, 0, '14', 'Rahul'),
(16, 0, '15', ''),
(17, 1, '0', ''),
(18, 1, '1', ''),
(19, 1, '2', 'SQL'),
(20, 1, '3', 'Windows'),
(21, 1, '4', 'Windows'),
(22, 1, '5', 'Windows'),
(23, 1, '6', 'Windows'),
(24, 1, '7', 'Windows'),
(25, 1, '8', 'SQL'),
(26, 1, '9', 'SQL'),
(27, 1, '10', 'Windows'),
(28, 1, '11', 'SQL'),
(29, 1, '12', 'Windows'),
(30, 1, '13', 'Windows'),
(31, 1, '14', 'Windows'),
(32, 1, '15', ''),
(33, 2, '0', ''),
(34, 2, '1', ''),
(35, 2, '2', 'Hyd'),
(36, 2, '3', 'Pune'),
(37, 2, '4', 'Hyd'),
(38, 2, '5', 'Pune'),
(39, 2, '6', 'Hyd'),
(40, 2, '7', 'Hyd'),
(41, 2, '8', 'Pune'),
(42, 2, '9', 'Hyd'),
(43, 2, '10', 'Hyd'),
(44, 2, '11', 'Hyd'),
(45, 2, '12', 'Pune'),
(46, 2, '13', 'Pune'),
(47, 2, '14', 'Jalgaon'),
(48, 2, '15', ''),
(49, 3, '0', '2024-10-27'),
(50, 3, '1', 'Sunday'),
(51, 3, '2', '1'),
(52, 3, '3', '2'),
(53, 3, '4', '3'),
(54, 3, '5', 'PL'),
(55, 3, '6', 'OD2'),
(56, 3, '7', 'OD1'),
(57, 3, '8', '0'),
(58, 3, '9', '2'),
(59, 3, '10', '3'),
(60, 3, '11', 'SL'),
(61, 3, '12', '1'),
(62, 3, '13', 'SL'),
(63, 3, '14', '1'),
(64, 3, '15', ''),
(65, 4, '0', '2024-10-28'),
(66, 4, '1', 'Monday'),
(67, 4, '2', '1'),
(68, 4, '3', '1'),
(69, 4, '4', '1'),
(70, 4, '5', 'PL'),
(71, 4, '6', 'OD2'),
(72, 4, '7', 'OD1'),
(73, 4, '8', '0'),
(74, 4, '9', '2'),
(75, 4, '10', '3'),
(76, 4, '11', 'SL'),
(77, 4, '12', '1'),
(78, 4, '13', 'SL'),
(79, 4, '14', '2'),
(80, 4, '15', '');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`) VALUES
(5, 'Pune'),
(7, 'Hyd'),
(13, 'Jalgaon');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `name`) VALUES
(3, 'Windows'),
(4, 'SQL');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `role`) VALUES
(1, 'rupali@gmail.com', '$2y$10$uX7TrI5aHSPJXanopCpzzOflHkqhoJXzDxh7yJZYpz6YQDXMNI31K', 'Rupali Kulkarni', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data`
--
ALTER TABLE `data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
