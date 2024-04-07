-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2024 at 08:12 PM
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
-- Database: `sports`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `password`, `fname`, `lname`) VALUES
(1, 'admin@gmail.com', '$2y$10$g93PrI34qqi1RvHKeMdET.Hlaqv6Ai.cYNp1TcsfHfp4S0KNyEKnu', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `advertising_spaces`
--

CREATE TABLE `advertising_spaces` (
  `id` int(11) NOT NULL,
  `advertising_space_name` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `price_unit` decimal(10,2) DEFAULT NULL,
  `inventory_value` decimal(10,2) DEFAULT NULL,
  `sold` tinyint(1) DEFAULT NULL,
  `workload` decimal(5,2) DEFAULT NULL,
  `value_sold` decimal(10,2) DEFAULT NULL,
  `proceeds` decimal(10,2) DEFAULT NULL,
  `club_id` int(11) DEFAULT NULL,
  `partner_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `advertising_spaces`
--

INSERT INTO `advertising_spaces` (`id`, `advertising_space_name`, `unit`, `number`, `price_unit`, `inventory_value`, `sold`, `workload`, `value_sold`, `proceeds`, `club_id`, `partner_id`) VALUES
(1, 'Space Ab', 'Banner', 10, 100.00, 1000.00, 0, 20.50, 0.00, 0.00, 1, 101),
(2, 'Space B', 'Billboard', 5, 500.00, 2500.00, 1, 40.00, 2500.00, 2500.00, 2, 102),
(11, 'cccc', '23', 544, 56.00, 6767.00, 8, 999.99, 448.00, 2424.00, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `clubs`
--

CREATE TABLE `clubs` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `clubName` varchar(255) NOT NULL,
  `clubImagePath` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clubs`
--

INSERT INTO `clubs` (`id`, `email`, `password`, `clubName`, `clubImagePath`) VALUES
(3, 'clubjoy@gmail.com', '$2y$10$l7mWfWwwbEn0JmsO2/.znejRgVsQwLmLNwXh8HaEAcE3jShBZ3YqO', 'Joy Club', '../../club/club_images/65b09458c2d20_forest.jpg'),
(4, 'club@gmail.com', '$2y$10$FILmje.d5saaiqwmZaCMtOi..7nQuSVk1huBHJSxaS9am/zlMV5Uu', 'club', '../../club/club_images/65ce1b2b6733a_The Unlikely Pilgrimage of Harold Fry.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `id` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `club_id` int(11) DEFAULT NULL,
  `partner_id` int(11) DEFAULT NULL,
  `partner_email` varchar(255) DEFAULT NULL,
  `advertising_space_id` int(11) DEFAULT NULL,
  `advertising_space_name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `last_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contracts`
--

INSERT INTO `contracts` (`id`, `start_date`, `end_date`, `club_id`, `partner_id`, `partner_email`, `advertising_space_id`, `advertising_space_name`, `type`, `note`, `status`, `last_modified`) VALUES
(3, '2023-03-01', '2023-08-31', 3, 103, 'partner3@example.com', 3, 'Space C', 'Temporary', 'Summer campaign for digital display.', 'Active', '2023-11-21 02:17:58'),
(20, '2023-11-01', '2023-11-29', 1, 1, 'johndoe@acme.com', 1, 'Space Ab', 'annual', 'i like this', 'Pending', '2023-11-30 01:24:42'),
(21, '2023-11-14', '2023-11-24', 1, 2, 'janesmith@globex.com', 1, 'Space Ab', 'perenial', 'best contract', 'Active', '2023-11-30 01:25:08'),
(22, '2024-01-04', '2024-01-03', 3, 5, 'Array', 0, '', 'xxxxxxxxxx', 'xxxxxxxxx', 'Inactive', '2024-01-24 05:12:17'),
(23, '2024-01-04', '2024-01-10', 3, 5, 'artv@vandelay.comx', 11, 'cccc', 'ccccccccc', 'cccccccccc', 'Active', '2024-01-24 04:54:14');

-- --------------------------------------------------------

--
-- Table structure for table `open_contacts`
--

CREATE TABLE `open_contacts` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `club_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `club_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`id`, `company_name`, `contact_person`, `address`, `telephone`, `email`, `club_id`) VALUES
(1, 'Acme Corporation', 'John Doe', '123 Main Street, Anytown', '123-456-7890', 'johndoe@acme.com', 1),
(2, 'Globex Corporation', 'Jane Smith', '456 Elm Street, Othertown', '234-567-8901', 'janesmith@globex.com', 1),
(3, 'Initech', 'Peter Gibbons', '789 Maple Avenue, Anycity', '345-678-9012', 'peterg@initech.com', 2),
(4, 'Umbrella Corporation', 'Alice Johnson', '101 Oak Lane, Sometown', '456-789-0123', 'alicej@umbrella.com', 2),
(5, 'Vandelay Industriesx', 'Art Vandelayx', '202 Pine Road, Othercityx', '567-890-1234x', 'artv@vandelay.comx', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `advertising_spaces`
--
ALTER TABLE `advertising_spaces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clubs`
--
ALTER TABLE `clubs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `open_contacts`
--
ALTER TABLE `open_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `advertising_spaces`
--
ALTER TABLE `advertising_spaces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `clubs`
--
ALTER TABLE `clubs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `open_contacts`
--
ALTER TABLE `open_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
