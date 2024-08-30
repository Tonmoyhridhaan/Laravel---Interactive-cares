-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 30, 2024 at 08:20 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `interactivecares_assignment-5`
--

-- --------------------------------------------------------

--
-- Table structure for table `balance`
--

CREATE TABLE `balance` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `balance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `balance`
--

INSERT INTO `balance` (`id`, `email`, `balance`) VALUES
(1, 'tonmoy@gmail.com', 2520),
(2, 'nahian@gmail.com', 10),
(3, 'shaon@gmail.com', 0),
(4, 'shaon@gmail.com', 0),
(5, 'faisal@gmai.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `password`) VALUES
(2, 'Tonmoy', 'tonmoy@gmail.com', '$2y$10$VIKUJVqoIbMKInbnrUocoO0R6ts3UJHXVcFlV6bhkK7h60YxhOJdy'),
(3, 'Nahian', 'nahian@gmail.com', '$2y$10$togAPLWRG.oAivpKW9vaAeGFBrIDT0oaF8/LVR2G8vc17rS2ilaei'),
(4, 'Ahmed Shaon', 'shaon@gmail.com', '$2y$10$.JbVVdp0T2zLHpTpwlm.fe.sZvasmcnBq4.agDLu4wh3nfpXOBZPm'),
(6, 'Faisal Ahmed', 'faisal@gmai.com', '$2y$10$0sttDwM4rczmt0qIga6aQuGGlNFsc6Nq2tbDKu5vqZ1kqZBFx9IoW');

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `id` int(11) NOT NULL,
  `dateTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `from_email` varchar(255) NOT NULL,
  `to_email` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transfers`
--

INSERT INTO `transfers` (`id`, `dateTime`, `from_email`, `to_email`, `amount`) VALUES
(2, '2024-08-30 05:55:54', 'nahian@gmail.com', 'tonmoy@gmail.com', 100),
(3, '2024-08-30 01:56:15', 'nahian@gmail.com', 'tonmoy@gmail.com', 200),
(4, '2024-08-30 01:56:36', 'nahian@gmail.com', 'tonmoy@gmail.com', 100),
(5, '2024-08-30 01:57:10', 'nahian@gmail.com', 'tonmoy@gmail.com', 10),
(6, '2024-08-30 01:57:37', 'nahian@gmail.com', 'tonmoy@gmail.com', 90);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `balance`
--
ALTER TABLE `balance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `balance`
--
ALTER TABLE `balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
