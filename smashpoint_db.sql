-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2026 at 06:15 AM
-- Server version: 10.11.16-MariaDB
-- PHP Version: 8.3.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smashpoint_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `community_events`
--

CREATE TABLE `community_events` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(150) NOT NULL,
  `event_location` varchar(255) NOT NULL,
  `event_datetime` datetime NOT NULL,
  `event_description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `community_events`
--

INSERT INTO `community_events` (`event_id`, `event_name`, `event_location`, `event_datetime`, `event_description`, `created_at`) VALUES
(1, 'pop badminton nyc', 'public school 9', '2026-11-13 11:00:00', 'it will be from 11pm - 3pm.\r\nanyone playing any level is welcome to play. \r\nplease make sure to bring water and snacks and please be respectful of the space.\r\n\r\nonly 30 people allowed if you are interested please text 123-456-3458 to confirm your spot', '2026-11-10 04:19:58'),
(2, 'Pop Up Badminton Bronx', 'St. Mary\'s Park', '2026-11-28 10:00:00', 'All Inclusive place. anyone any level is welcome please come in.\r\nwe will have some rackets available but it\'s first come first serve!! \r\nPlease bring your own equipment. Racket, shuttle, etc. \r\nwe will have 5 courts available from 10-1PM. you can bring your friends as well. \r\nlet\'s have fun and network with other Smashers!!!!!!!!!!!!', '2026-11-18 03:51:50');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `member_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `membership_plan` enum('Starter','Standard','Premium') NOT NULL,
  `membership_status` enum('Active','Cancellation Requested','Cancelled') DEFAULT 'Active',
  `registration_date` timestamp NULL DEFAULT current_timestamp(),
  `cancellation_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `name`, `email`, `phone`, `password`, `membership_plan`, `membership_status`, `registration_date`, `cancellation_date`) VALUES
(1, 'rasel ali', 'raselali@gmail.com', '121-212-1212', '$2y$10$k3NvBTaF.GspA7D179vHmO6PgOlOo7NDnjllgVaSxDNsO4WkfCVZ6', 'Standard', 'Active', '2026-11-10 03:27:33', NULL),
(2, 'rasel ali', 'rasel@gmail.org', '121-212-1212', '$2y$10$oqTVAR0K5o9dDok2Ws6xn..iSoZCergGic1opxbeu7x0/nxfC0HB6', 'Standard', 'Cancelled', '2026-11-10 03:36:03', '2026-11-10 03:47:02'),
(3, 'Full Name', 'rarra@gmail.com', '929-929-9292', '$2y$10$4aDdwukP.xxViRWx79h4J.AGlOj8wKCFY3LMi/pjMj2vBo8XEA3ni', 'Starter', 'Active', '2026-11-18 04:46:17', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `community_events`
--
ALTER TABLE `community_events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `community_events`
--
ALTER TABLE `community_events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
