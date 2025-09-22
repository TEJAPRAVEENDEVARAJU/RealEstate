-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql200.infinityfree.com
-- Generation Time: Sep 22, 2025 at 01:25 PM
-- Server version: 11.4.7-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_39282857_realestate`
--

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
  `id` int(11) NOT NULL,
  `referrer_id` int(11) NOT NULL,
  `referrer_plot` varchar(50) NOT NULL,
  `referred_user_id` int(11) NOT NULL,
  `referred_plot` varchar(50) NOT NULL,
  `status` enum('Pending','Agreement') DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `referrals`
--

INSERT INTO `referrals` (`id`, `referrer_id`, `referrer_plot`, `referred_user_id`, `referred_plot`, `status`, `created_at`) VALUES
(1, 7, '', 14, '', 'Pending', '2025-09-01 07:17:08'),
(9, 7, '', 11, '', 'Pending', '2025-09-01 09:56:19'),
(3, 7, '', 8, '', 'Pending', '2025-09-01 07:17:25'),
(4, 14, '', 13, '', 'Pending', '2025-09-01 08:19:07'),
(5, 8, '', 9, '', 'Pending', '2025-09-01 09:34:27'),
(6, 8, '', 15, '', 'Pending', '2025-09-01 09:34:27'),
(7, 15, '', 16, '', 'Pending', '2025-09-01 09:35:42'),
(8, 15, '', 18, '', 'Pending', '2025-09-01 09:35:42'),
(14, 9, '', 10, '', 'Pending', '2025-09-01 10:04:15'),
(15, 11, '', 17, '', 'Pending', '2025-09-01 10:04:48'),
(16, 11, '', 20, '', 'Pending', '2025-09-01 10:04:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'Bhagya Lakshmi', 'teja@gmail.com', '$2y$10$RjXgrk9btrFmvsqfJxre5OMwcJW77J1Mkm8hMSwCnNab/pXk0W6Em');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `plot` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `registered_date` datetime DEFAULT NULL,
  `booked_date` datetime DEFAULT NULL,
  `agreement_date` datetime DEFAULT NULL,
  `referral_bonus` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `name`, `phone`, `plot`, `status`, `created_at`, `registered_date`, `booked_date`, `agreement_date`, `referral_bonus`) VALUES
(7, 'Obulasetty Syam Prasanth Raj', '9492090059', '70', 'Registered', '2025-06-20 12:21:48', '2025-07-17 15:03:00', '2025-04-21 15:03:00', '2025-05-23 15:03:00', 0),
(8, 'B. Prudhvi Sai Kumar', '9030139038', '60', 'Registered', '2025-06-20 12:23:21', '2025-07-31 15:03:00', '2025-04-26 15:03:00', '2025-05-10 15:03:00', 0),
(9, 'T. Rohith Lavanya Kumar', '1234567890', '58', 'Agreement', '2025-06-20 12:24:47', NULL, '2025-05-10 15:03:00', '2025-06-09 15:03:00', 0),
(10, 'T. Leela Pavan Kumar', '000000000', '103', 'Agreement', '2025-06-20 12:26:14', NULL, '2025-05-10 15:03:00', '2025-06-09 15:03:00', 0),
(11, 'R. Malli Karjuna Naidu', '8340027221', '4', 'Agreement', '2025-06-20 12:27:32', NULL, '2025-05-29 15:03:00', '2025-07-14 15:03:00', 0),
(13, 'V.krupa jothi', '8019513510', '101', 'Agreement', '2025-06-20 12:29:58', NULL, '2025-05-26 15:03:00', '2025-08-20 12:00:00', 0),
(14, 'Obulasetty Teja Praveen Deva Raju', '9492090059', '102', 'Agreement', '2025-06-20 12:31:07', NULL, '2025-05-26 15:03:00', '2025-07-17 15:03:00', 0),
(15, 'AlaKunta Sivaih', '8125446580', '3', 'Registered', '2025-06-20 12:32:41', '2025-08-11 12:00:00', '2025-06-02 15:03:00', '2025-06-02 15:03:00', 0),
(16, 'Alakunta Rananamma', '8125446580', '52', 'Registered', '2025-06-20 12:34:26', '2025-07-11 12:00:00', '2025-06-02 15:03:00', '2025-06-21 15:03:00', 0),
(17, 'T.snehith', '8897620457', '104', 'Agreement', '2025-06-20 12:35:28', NULL, '2025-06-05 15:03:00', '2025-07-17 15:03:00', 0),
(18, 'Kunchala Ramanaih', '9666247823', '2', 'Registered', '2025-06-20 12:36:28', '2025-08-11 12:00:00', '2025-06-05 15:03:00', '2025-06-21 15:03:00', 0),
(20, 'R.Krishnamma	', '8340027221', '51', 'Agreement', '2025-06-20 17:19:26', NULL, '2025-05-29 15:03:00', '2025-07-20 15:09:00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `referrals`
--
ALTER TABLE `referrals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `referrer_id` (`referrer_id`),
  ADD KEY `referred_user_id` (`referred_user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `referrals`
--
ALTER TABLE `referrals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
