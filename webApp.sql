-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 30, 2020 at 10:50 AM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webApp`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `address1` text NOT NULL,
  `address2` text NOT NULL,
  `address3` text NOT NULL,
  `gstn` text NOT NULL,
  `state` text NOT NULL,
  `code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `address1`, `address2`, `address3`, `gstn`, `state`, `code`) VALUES
(4, 'local', '.', '.', 'nthin', '.', '.', 0),
(5, 'marvel', 'kalikatt complex', 'thykoodum', 'nthin', '32BHDSHV86348', 'KERALA', 32),
(6, 'kesari', 'alappat building', 'Mg road, ernakulam', 'nthin', '32FBDSFV425DV2', 'KERALA', 32),
(7, 'intersight', 'opposite whitefort', 'Nh47 maradu', 'nthin', '32JVBKBJ8834YYBC', 'KERALA', 32),
(8, 'Yatra', 'Yatra complex', 'vytilla junction', 'nthin', '32OJWBDVWJ3439179C', 'KERALA', 32);

-- --------------------------------------------------------

--
-- Table structure for table `dropdown`
--

CREATE TABLE `dropdown` (
  `id` int(11) NOT NULL,
  `dKey` varchar(255) NOT NULL,
  `dValue` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dropdown`
--

INSERT INTO `dropdown` (`id`, `dKey`, `dValue`) VALUES
(20, 'vehicle', 'KL39N1090'),
(21, 'vehicle', 'KL39M6090'),
(22, 'vehicle', 'KL39F790'),
(23, 'vehicle', 'KL39H3090'),
(24, 'vehicle', 'KL39J2090'),
(27, 'driver', 'ajay'),
(28, 'driver', 'manu'),
(29, 'driver', 'rahul'),
(30, 'driver', 'edvin'),
(31, 'driver', 'appu'),
(32, 'cleaner', 'nikhil'),
(33, 'cleaner', 'thommen'),
(34, 'cleaner', 'akhil'),
(35, 'cleaner', 'abel'),
(36, 'cleaner', 'miku'),
(37, 'cleaner', 'viswa'),
(39, 'driver', 'suku'),
(40, 'cleaner', 'madhu'),
(42, 'driver', 'allen'),
(43, 'vehicle', 'KL39M1094');

-- --------------------------------------------------------

--
-- Table structure for table `petrol`
--

CREATE TABLE `petrol` (
  `id` int(11) NOT NULL,
  `tripid` int(11) NOT NULL,
  `vehicle` text NOT NULL,
  `pump` text NOT NULL,
  `fdate` text NOT NULL,
  `kmr` int(11) NOT NULL,
  `litre` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `petrol`
--

INSERT INTO `petrol` (`id`, `tripid`, `vehicle`, `pump`, `fdate`, `kmr`, `litre`, `price`) VALUES
(4, 12, 'KL39P5090', 'BPCL kakkanad', '2020-12-04', 14296, 110, 8400),
(5, 11, 'KL39F790', 'BPCL muvattupuzha', '2020-11-27', 21841, 82, 7012),
(6, 11, 'KL39F790', 'BPCL arrekode', '2020-11-26', 121537, 92, 10002),
(7, 11, 'KL39F790', 'BPCL kozhikode', '2020-11-12', 35637, 110, 9600),
(9, 12, 'KL39P5090', 'BPCL kochi', '2020-11-18', 1324, 24, 9700);

-- --------------------------------------------------------

--
-- Table structure for table `trip`
--

CREATE TABLE `trip` (
  `id` int(11) NOT NULL,
  `company` varchar(255) NOT NULL,
  `vehicle` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `sdate` date NOT NULL,
  `advance` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `driver` varchar(255) NOT NULL,
  `cleaner` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `paid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `trip`
--

INSERT INTO `trip` (`id`, `company`, `vehicle`, `destination`, `sdate`, `advance`, `amount`, `driver`, `cleaner`, `description`, `paid`) VALUES
(3, 'intersight', 'KL39F790', 'Munnar', '2020-11-01', 2000, 18000, 'ajay', 'abel', '2 days pickup-drop ', 'np'),
(4, 'kesari', 'KL39H3090', 'kovalam', '2020-11-04', 3000, 26000, 'edvin', 'nikhil', 'tvm railway station pickup-drop 3days', 'np'),
(5, 'local', 'KL39F790', 'kottayam', '2020-11-07', 2000, 16000, 'appu', 'miku', 'kalyanum 1day pickup-drop', 'np'),
(6, 'marvel', 'KL39F790', 'Goa', '2020-11-10', 12000, 86000, 'manu', 'thommen', '8 days pickup-drop', 'np'),
(7, 'Yatra', 'KL39F790', 'mahe', '2020-11-13', 3000, 23000, 'rahul', 'akhil', 'sightseeing pickup-drop', 'np'),
(8, 'intersight', 'KL39J2090', 'kannur', '2020-11-16', 4000, 43000, 'appu', 'nikhil', 'pickup-drop 3days include coorg', 'np'),
(9, 'kesari', 'KL39M6090', 'Bangalore', '2020-11-19', 6500, 56000, 'edvin', 'viswa', 'include mysore pickup-drop', 'p'),
(10, 'local', 'KL39N1090', 'Thekkady', '2020-11-24', 3000, 22000, 'rahul', 'miku', 'school tour pickup-drop', 'p'),
(11, 'marvel', 'KL39F790', 'marayur', '2020-11-27', 12000, 25000, 'edvin', 'abel', 'camping 2 days pickup-drop', 'p'),
(12, 'Yatra', 'KL39P5090', 'Kozhikode', '2020-12-04', 3000, 24000, 'edvin', 'abel', 'sightseeing ship pickup-drop', 'p'),
(13, 'intersight', 'KL39P5090', 'Mangalore', '2020-11-18', 4000, 20000, 'ajay', 'abel', 'ship sightseeing pickup', 'p'),
(14, 'intersight', 'KL39N1090', 'Hosur', '2020-11-24', 6000, 43000, 'appu', 'nikhil', 'company visit pickup-drop', 'p'),
(15, 'intersight', 'KL39N1090', 'Mysore', '2020-11-26', 3000, 38000, 'ajay', 'akhil', 'visting pickup back ernakulam', 'p'),
(16, 'kesari', 'KL39M6090', 'Munnar', '2020-10-20', 2000, 12000, 'ajay', 'abel', 'pickupdrop', 'p'),
(17, 'intersight', 'KL39F790', 'kochi', '2020-11-18', 2000, 22000, 'ajay', 'abel', 'pickupdrop', 'np'),
(18, 'marvel', 'KL39P5090', 'Munnar', '2020-11-10', 2000, 17000, 'ajay', 'abel', 'Pickup drop tour 2days', 'np'),
(19, 'marvel', 'KL39M1094', 'munnar', '2020-11-19', 2000, 14000, 'appu', 'miku', 'dropup', 'p'),
(20, 'marvel', 'KL39M6090', 'munnar', '2020-11-11', 2000, 12000, 'allen', 'miku', 'pickup drop', 'p');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dropdown`
--
ALTER TABLE `dropdown`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `petrol`
--
ALTER TABLE `petrol`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trip`
--
ALTER TABLE `trip`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `dropdown`
--
ALTER TABLE `dropdown`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `petrol`
--
ALTER TABLE `petrol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `trip`
--
ALTER TABLE `trip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
