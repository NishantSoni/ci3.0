-- phpMyAdmin SQL Dump
-- version 4.6.5.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Apr 27, 2017 at 11:53 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shopping`
--

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

CREATE TABLE `orderitems` (
  `orderitemid` bigint(20) NOT NULL,
  `userorderid` bigint(20) NOT NULL,
  `itemname` varchar(100) NOT NULL,
  `itemprice` float NOT NULL,
  `itemquantity` int(11) NOT NULL,
  `createdat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orderitems`
--

INSERT INTO `orderitems` (`orderitemid`, `userorderid`, `itemname`, `itemprice`, `itemquantity`, `createdat`, `updatedat`) VALUES
(7, 5, 'TShirt', 489, 4, '2017-04-27 02:10:14', '2017-04-27 02:10:14'),
(8, 5, 'Jeans', 2489, 3, '2017-04-27 02:10:14', '2017-04-27 02:10:14'),
(9, 5, 'Shirt', 1489, 2, '2017-04-27 02:10:14', '2017-04-27 02:10:14'),
(10, 6, 'TShirt', 489, 4, '2017-04-27 02:43:27', '2017-04-27 02:43:27'),
(11, 6, 'Jeans', 2489, 3, '2017-04-27 02:43:27', '2017-04-27 02:43:27'),
(12, 6, 'Shirt', 1489, 2, '2017-04-27 02:43:27', '2017-04-27 02:43:27'),
(13, 7, 'TShirt', 489, 4, '2017-04-27 11:38:02', '2017-04-27 11:38:02'),
(14, 7, 'Jeans', 2489, 3, '2017-04-27 11:38:02', '2017-04-27 11:38:02'),
(15, 7, 'Shirt', 1489, 2, '2017-04-27 11:38:02', '2017-04-27 11:38:02'),
(16, 7, 'TShirt', 489, 4, '2017-04-28 12:17:08', '2017-04-28 12:17:08'),
(17, 7, 'Jeans', 2489, 3, '2017-04-28 12:17:08', '2017-04-28 12:17:08'),
(18, 7, 'Shirt', 1489, 2, '2017-04-28 12:17:08', '2017-04-28 12:17:08');

-- --------------------------------------------------------

--
-- Table structure for table `userorders`
--

CREATE TABLE `userorders` (
  `userorderid` bigint(20) NOT NULL,
  `userid` bigint(20) NOT NULL,
  `status` enum('created','processed','delivered','cancelled') NOT NULL DEFAULT 'created',
  `ispaymentreceived` tinyint(4) NOT NULL DEFAULT '0',
  `createdat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `userorders`
--

INSERT INTO `userorders` (`userorderid`, `userid`, `status`, `ispaymentreceived`, `createdat`, `updatedat`) VALUES
(5, 1, 'created', 0, '2017-04-27 02:10:14', '2017-04-27 02:10:14'),
(6, 1, 'created', 0, '2017-04-27 02:43:26', '2017-04-27 02:43:26'),
(7, 1, 'cancelled', 1, '2017-04-27 11:38:02', '2017-04-27 11:38:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` bigint(20) NOT NULL,
  `useremail` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `createdat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `useremail`, `username`, `createdat`, `updatedat`) VALUES
(1, 'soninishantsoni@gmail.com', 'nishant soni', '2017-04-27 02:01:08', '2017-04-27 02:01:08'),
(2, 'safasdf@gmail.com', 'asdfasfasdf', '2017-04-28 11:55:33', '2017-04-28 11:55:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`orderitemid`);

--
-- Indexes for table `userorders`
--
ALTER TABLE `userorders`
  ADD PRIMARY KEY (`userorderid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `orderitemid` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `userorders`
--
ALTER TABLE `userorders`
  MODIFY `userorderid` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
