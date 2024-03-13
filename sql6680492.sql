-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2024 at 01:21 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sql6680492`
--

-- --------------------------------------------------------

--
-- Table structure for table `wr_booker`
--

CREATE TABLE `wr_booker` (
  `booker_id` int(11) NOT NULL,
  `booker_name` text NOT NULL,
  `booker_phone` int(11) NOT NULL,
  `booker_pin` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wr_booker`
--

INSERT INTO `wr_booker` (`booker_id`, `booker_name`, `booker_phone`, `booker_pin`) VALUES
(13, 'klk', 678678, '013'),
(14, 'Halim', 64565, '014'),
(15, 'fhjdh', 348957489, '015'),
(16, 'Kamal', 457498, '016');

-- --------------------------------------------------------

--
-- Table structure for table `wr_host`
--

CREATE TABLE `wr_host` (
  `host_id` int(11) NOT NULL,
  `host_username` varchar(255) NOT NULL,
  `host_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wr_host`
--

INSERT INTO `wr_host` (`host_id`, `host_username`, `host_password`) VALUES
(1, 'sayem', '123');

-- --------------------------------------------------------

--
-- Table structure for table `wr_positions`
--

CREATE TABLE `wr_positions` (
  `position_id` int(11) NOT NULL,
  `program_id` int(11) DEFAULT NULL,
  `position_table_number` int(11) NOT NULL,
  `position_chair_number` int(11) NOT NULL,
  `position_guest_name` varchar(255) DEFAULT NULL,
  `position_booker_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wr_positions`
--

INSERT INTO `wr_positions` (`position_id`, `program_id`, `position_table_number`, `position_chair_number`, `position_guest_name`, `position_booker_id`) VALUES
(151, 6, 1, 1, NULL, 16),
(152, 6, 1, 2, 'Tanvir', 16),
(153, 6, 2, 1, 'Zaman', 16),
(154, 6, 2, 2, 'Nanapatekar', 16);

-- --------------------------------------------------------

--
-- Table structure for table `wr_programs`
--

CREATE TABLE `wr_programs` (
  `prog_id` int(11) NOT NULL,
  `prog_name` varchar(255) NOT NULL,
  `prog_date_time` timestamp NULL DEFAULT NULL,
  `prog_host_id` int(11) DEFAULT NULL,
  `prog_no_of_tables` int(11) NOT NULL DEFAULT 5,
  `prog_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wr_programs`
--

INSERT INTO `wr_programs` (`prog_id`, `prog_name`, `prog_date_time`, `prog_host_id`, `prog_no_of_tables`, `prog_created_at`) VALUES
(6, 'Sayem\'s Wedding', '2024-03-16 16:14:00', 1, 2, '2024-03-11 10:15:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wr_booker`
--
ALTER TABLE `wr_booker`
  ADD PRIMARY KEY (`booker_id`);

--
-- Indexes for table `wr_host`
--
ALTER TABLE `wr_host`
  ADD PRIMARY KEY (`host_id`);

--
-- Indexes for table `wr_positions`
--
ALTER TABLE `wr_positions`
  ADD PRIMARY KEY (`position_id`);

--
-- Indexes for table `wr_programs`
--
ALTER TABLE `wr_programs`
  ADD PRIMARY KEY (`prog_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wr_booker`
--
ALTER TABLE `wr_booker`
  MODIFY `booker_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `wr_host`
--
ALTER TABLE `wr_host`
  MODIFY `host_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wr_positions`
--
ALTER TABLE `wr_positions`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `wr_programs`
--
ALTER TABLE `wr_programs`
  MODIFY `prog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
