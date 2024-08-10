-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2024 at 11:22 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `contactdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phonenumber` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `user_id`, `fullname`, `email`, `phonenumber`, `created_at`) VALUES
(1, 1, 'VALENCE PHENOM', 'mwiganivalence@gmail.com', '0736774724', '2023-12-12 18:43:32'),
(4, 2, 'PHENOM LEGACY', 'phenomenalvalence@gmail.com', '0753775184', '2023-12-13 06:27:53'),
(5, 2, 'MO SALAH', 'HREF@YAHOO.COM', '0753775184', '2023-12-13 07:08:45'),
(6, 3, 'NIGHTJADE', 'mwiganivalence@gmail.com', '0764576756', '2023-12-13 07:28:30'),
(31, 2, 'CASEMIRO', 'WILOK@GMAIL.COM', '07645767', '2023-12-15 07:08:36'),
(33, 3, 'CASEMIRO', 'WILOK@GMAIL.COM', '07645767', '2023-12-15 07:21:25'),
(35, 3, 'KANE SPURS', 'WILOK@GMAIL.COM', '0753775184', '2023-12-15 07:29:07'),
(36, 2, 'RASMUS HOJLUND', 'WILOK@GMAIL.COM', '0753775184', '2023-12-15 07:47:02'),
(37, 2, 'PHENOM LIBRA', 'phenomenalvalence@gmail.com', '0622774724', '2023-12-15 07:47:28'),
(42, 3, 'RASHFORD', 'phenomenalvalence@gmail.com', '0753775184', '2023-12-15 13:23:53'),
(51, 2, 'VALENCE PHENOM', 'mwiganivalence@gmail.com', '0736774724', '2023-12-16 13:23:19'),
(52, 1, 'PHENOM LEGACY', 'phenomenalvalence@gmail.com', '0753775184', '2023-12-16 13:31:14'),
(53, 1, 'VALERIE', 'MAGOMBA@GMAIL.COM', '07645767', '2023-12-16 13:45:52'),
(54, 2, 'VALERIE', 'MAGOMBA@GMAIL.COM', '07645767', '2023-12-16 13:46:32'),
(55, 7, 'PHENOM LEGACY', 'phenomenalvalence@gmail.com', '0753775184', '2023-12-16 13:58:57'),
(56, 7, 'NIGHTJADE', 'mwiganivalence@gmail.com', '0764576756', '2023-12-16 14:01:08'),
(57, 8, 'ASENTRIC10', 'aasentric@gmail.com', '0765432345', '2023-12-19 18:13:51'),
(58, 1, 'MISKIIIII', 'mwiganivalence@gmail.com', '0753775184', '2023-12-30 09:05:57');

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `status` enum('pending','accepted','declined') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friend_requests`
--

INSERT INTO `friend_requests` (`id`, `sender_id`, `receiver_id`, `status`, `created_at`) VALUES
(15, 2, 1, 'accepted', '2023-12-13 05:29:36'),
(16, 1, 2, 'accepted', '2023-12-13 05:37:52'),
(17, 3, 1, 'accepted', '2023-12-13 07:37:57'),
(18, 3, 2, 'accepted', '2023-12-15 07:22:05'),
(27, 7, 2, 'accepted', '2023-12-16 13:56:46'),
(28, 7, 1, '', '2023-12-16 13:56:52'),
(29, 7, 3, 'accepted', '2023-12-16 13:56:56'),
(30, 1, 7, 'accepted', '2023-12-16 13:58:10'),
(31, 1, 8, 'accepted', '2023-12-19 18:14:12');

-- --------------------------------------------------------

--
-- Table structure for table `shared_contacts`
--

CREATE TABLE `shared_contacts` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `status` enum('pending','accepted','denied') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shared_contacts`
--

INSERT INTO `shared_contacts` (`id`, `sender_id`, `receiver_id`, `contact_id`, `status`, `created_at`) VALUES
(1, 2, 1, 31, 'accepted', '2023-12-16 13:42:11'),
(2, 1, 3, 1, 'accepted', '2023-12-16 13:42:47'),
(3, 2, 1, 37, 'denied', '2023-12-16 13:43:57'),
(4, 1, 2, 53, 'accepted', '2023-12-16 13:46:06'),
(5, 2, 3, 54, 'denied', '2023-12-16 13:47:29'),
(6, 2, 7, 4, 'accepted', '2023-12-16 13:58:39'),
(7, 3, 7, 6, 'accepted', '2023-12-16 14:00:28'),
(8, 3, 7, 35, 'denied', '2023-12-16 14:00:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `passwords` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `session_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `passwords`, `created_at`, `session_id`) VALUES
(1, 'VALENCE', 'mwiganivalence@gmail.com', '$2y$10$58Ynt6Dsvr5c3qdnIT10ke4lulsrt9c05NkyFP5odb4Lh4OMtMSnW', '2023-12-12 18:39:41', 0),
(2, 'PHENOM LEGACY', 'WILOK@GMAIL.COM', '$2y$10$nWNUBo/L88xFYE9jCX4mN.W.cfVFpe8y8M2XSGNs3quzFM51bYY8S', '2023-12-12 18:49:00', 0),
(3, 'NIGHTJADE', 'mwiganivalE@gmail.com', '$2y$10$i6pLr719DeNw5/DH.EMIfu7..ydAt2uCrlq5IM..qW8Kn7pM6v1d6', '2023-12-13 07:28:01', 0),
(7, 'ALLIANC3', 'allianz@gmail.com', '$2y$10$HEMupnzj6/QwZJonFY3YjeVDVa.M5xM5An32gQlm/fNztT.y1eh46', '2023-12-16 13:56:34', 0),
(8, 'KEISSY10', 'kentric@gmail.com', '$2y$10$Qn94h.7wtPu3Vf0jQOjpMuwgfZrADg7bGJw9mfqiG/gG3d5Y1pqiy', '2023-12-19 18:12:52', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sender_id_users` (`sender_id`),
  ADD KEY `fk_receiver_id_users` (`receiver_id`);

--
-- Indexes for table `shared_contacts`
--
ALTER TABLE `shared_contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`),
  ADD KEY `contact_id` (`contact_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `shared_contacts`
--
ALTER TABLE `shared_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD CONSTRAINT `fk_receiver_id_users` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_sender_id_users` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shared_contacts`
--
ALTER TABLE `shared_contacts`
  ADD CONSTRAINT `shared_contacts_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `shared_contacts_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `shared_contacts_ibfk_3` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
