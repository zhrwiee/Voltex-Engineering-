-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2024 at 11:22 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `voltexengineering`
--

-- --------------------------------------------------------

--
-- Table structure for table `electrician`
--

CREATE TABLE `electrician` (
  `id` int(10) NOT NULL,
  `fname` varchar(200) NOT NULL,
  `lname` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `email` text DEFAULT NULL,
  `password` text NOT NULL,
  `user_type` varchar(100) NOT NULL,
  `registration_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `electrician`
--

INSERT INTO `electrician` (`id`, `fname`, `lname`, `username`, `email`, `password`, `user_type`, `registration_date`) VALUES
(5, 'Muhammad Fahimi', 'Ridza', 'Fahimi Ridza', 'ridza@gmail.com', 'bacb8745363f834b239755d5ea7bf7c4', 'Admin', '2024-01-30'),
(6, 'Ahmad Taufik', 'Rafie', 'Ahmad Taufik', 'taufik.ahmad@gmail.com', '130afb9328de1ee1e47443221716d8cc', 'Admin', '2024-01-31'),
(7, 'Abang', 'Haizeeq', 'Haizeeq', 'haizeeq.abg@gmail.com', 'da5f67b911fb02478d9dc138357f2624', 'Admin', '2024-01-31'),
(9, 'Sample Electrician', 'One', 'Sample-01', 'sample01@gmail.com', '682a6ceeacf93144179062bcfbbc67b9', 'Electrician', '2024-01-31'),
(10, 'Sample Two', 'Electrician', 'Sample-02', 'sample02@gmail.com', 'd13386a46dfa7d6bd864977d1267d362', 'Electrician', '2024-01-31'),
(11, 'Three Sample', 'Electrician', 'Electrician03', 'sample03@gmail.com', 'ee807065126af224e518d090abc99739', 'Electrician', '2024-01-31');

-- --------------------------------------------------------

--
-- Table structure for table `services_record`
--

CREATE TABLE `services_record` (
  `service_id` int(10) NOT NULL,
  `user_id` int(5) NOT NULL,
  `building_type` varchar(200) NOT NULL,
  `service_type` text NOT NULL,
  `addressLine1` text DEFAULT NULL,
  `addressLine2` text DEFAULT NULL,
  `postcode` int(10) DEFAULT NULL,
  `city` text DEFAULT NULL,
  `state` text DEFAULT NULL,
  `selected_time` text DEFAULT NULL,
  `selected_date` date DEFAULT NULL,
  `assigned_electricianId` int(10) DEFAULT NULL,
  `completion_status` varchar(100) DEFAULT NULL,
  `service_remark` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services_record`
--

INSERT INTO `services_record` (`service_id`, `user_id`, `building_type`, `service_type`, `addressLine1`, `addressLine2`, `postcode`, `city`, `state`, `selected_time`, `selected_date`, `assigned_electricianId`, `completion_status`, `service_remark`) VALUES
(72, 18, 'Commercial', 'Troubleshooting', 'Lot 123, Taman Yen', 'Jalan Matang', 93050, 'Kuching', 'Sarawak', '8 AM', '2024-02-02', NULL, 'PENDING', NULL),
(73, 18, 'Commercial', 'Control Panel Manufacturing', '123, UniGarden', 'Jalan 18D', 94300, 'Samarahan', 'Sarawak', '8 AM', '2024-02-12', NULL, 'PENDING', NULL),
(74, 17, 'Residential', 'Troubleshooting', '001, Jalan Rock', 'Taman Yu', 34500, 'Pekan', 'Pahang', '2 PM', '2024-04-10', 9, 'PENDING', NULL),
(75, 17, 'Residential', 'Switchboard Manufacturing', '22,', 'Lorong Bunga Raya', 31009, 'Ipoh', 'Perak', '8 AM', '2024-02-19', NULL, 'PENDING', NULL),
(76, 19, 'Residential', 'Control Panel Manufacturing', '120, Taman Yen Yen', 'Jalan Matang', 93050, 'Kuching', 'Sarawak', '8 AM', '2024-02-20', NULL, 'PENDING', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_price`
--

CREATE TABLE `service_price` (
  `services` varchar(200) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `deposit` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service_price`
--

INSERT INTO `service_price` (`services`, `price`, `deposit`) VALUES
('Switchboard Manufacturing', '10000.00', '200.00'),
('Control Panel Manufacturing', '500.00', '200.00'),
('Troubleshooting', '300.00', '200.00');

-- --------------------------------------------------------

--
-- Table structure for table `user_record`
--

CREATE TABLE `user_record` (
  `user_id` int(5) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` text NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(100) NOT NULL,
  `phone_no` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_record`
--

INSERT INTO `user_record` (`user_id`, `fname`, `lname`, `username`, `email`, `password`, `user_type`, `phone_no`) VALUES
(17, 'Muhammad', 'Faiz', 'Faiz', 'faiz.iz@gmail.com', 'a538b53daa5b0e61900b294bcdde7c6d', 'Customer', '0123456789'),
(18, 'Elvisfresly', 'Ericky', 'Elvis', 'elvis@gmail.com', '4157ef28be37fefdadef76acde216112', 'Customer', '0111912321'),
(19, 'Tracy', 'Ernest', 'Tracy', 'tracy@gmail.com', 'e0af4b74d5c1d500b90917b3b501cacc', 'Customer', '0129237412');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `electrician`
--
ALTER TABLE `electrician`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services_record`
--
ALTER TABLE `services_record`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `user_record`
--
ALTER TABLE `user_record`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `electrician`
--
ALTER TABLE `electrician`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `services_record`
--
ALTER TABLE `services_record`
  MODIFY `service_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `user_record`
--
ALTER TABLE `user_record`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
