-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2018 at 03:45 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gas_book_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `aid` int(10) NOT NULL,
  `pwd` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`aid`, `pwd`) VALUES
(1, 'rootroot');

-- --------------------------------------------------------

--
-- Table structure for table `consumer_detail`
--

CREATE TABLE `consumer_detail` (
  `cid` int(10) NOT NULL,
  `did` int(5) NOT NULL,
  `pwd` varchar(16) DEFAULT NULL,
  `name` varchar(30) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(10) NOT NULL,
  `pin` int(6) NOT NULL,
  `m_no` bigint(10) NOT NULL,
  `e_id` varchar(30) NOT NULL,
  `reg_date` date DEFAULT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'Not Registered'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `consumer_detail`
--

INSERT INTO `consumer_detail` (`cid`, `did`, `pwd`, `name`, `address`, `city`, `pin`, `m_no`, `e_id`, `reg_date`, `status`) VALUES
(2, 1, '111111', 'Raj Pravinbhai Zalavadiya', '201,Sai Darshan, Nana Varachha', 'Surat', 394525, 8787954652, 'raj@outlook.com', '2018-02-07', 'Deactive'),
(3, 2, '333333', 'Biren V. Gadhiya', 'B12, Khodiyar row house, Katargam', 'Ahmedabad', 366666, 7877777777, 'bg@outlook.com', '2018-02-08', 'Active'),
(5, 1, '555555', 'Jenish Kishorbhai Mangukiya', 'D2/304, Gangotri rec., Sudama chowk, Mota Varachha', 'Surat', 394101, 9904436106, 'mjenish8@gmail.com', '2018-02-09', 'Active'),
(6, 1, NULL, 'Krunal Dineshbhai Lukhi', '21, White House, Panvel point road', 'Surat', 394101, 9876543210, 'kd_likhi@gmail.com', NULL, 'Not Registered'),
(225, 1, '225225', 'Ravi K. Kanpara', '22', 'Surat', 388554, 8565655521, 'ravi@gmail.com', '2018-02-21', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `distributor_detail`
--

CREATE TABLE `distributor_detail` (
  `did` int(5) NOT NULL,
  `pwd` varchar(16) NOT NULL,
  `name` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(10) NOT NULL,
  `pin` int(6) NOT NULL,
  `m_no` bigint(10) NOT NULL,
  `e_id` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Deactive',
  `proof` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `distributor_detail`
--

INSERT INTO `distributor_detail` (`did`, `pwd`, `name`, `address`, `city`, `pin`, `m_no`, `e_id`, `status`, `proof`) VALUES
(1, '111111', 'Jai Ganesh Agency', 'D12, GIDC-Kapodra', 'Surat', 384511, 8200703812, 'jganesh@gmail.com', 'Active', 'distributor/proof/1.jpg'),
(2, '222222', 'Gitanjali PVT LTD', '12, Amazon plaza, Ring road', 'Ahmedabad', 355002, 8547856321, 'gpvtltd@hotmail.com', 'Active', 'distributor/proof/2.jpg'),
(9, '111111', 'Nandan LTD', '12, Birla Mart, Behind Maruti Chowk', 'Bhavnagar', 555656, 7898765421, 'nan@ymail.com', 'Active', 'distributor/proof/9.jpg'),
(10, '333333', 'Tapovan Group', 'A55, JZ Shopping Mart, LH road', 'Vadodara', 366444, 9875452121, 'tapo@gmail.com', 'Deactive', 'distributor/proof/10.png');

-- --------------------------------------------------------

--
-- Table structure for table `feedback_complain`
--

CREATE TABLE `feedback_complain` (
  `cid` int(10) NOT NULL,
  `did` int(5) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `type` varchar(10) NOT NULL,
  `subject` varchar(30) NOT NULL,
  `description` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feedback_complain`
--

INSERT INTO `feedback_complain` (`cid`, `did`, `date`, `time`, `type`, `subject`, `description`) VALUES
(5, 1, '2018-02-25', '10:34:46', 'Feedback', 'Product related', 'Last product delivery taken two weeks.'),
(5, 1, '2018-02-25', '10:34:53', 'Feedback', 'Website related', 'Your website\'s interface is awesome.'),
(225, 1, '2018-02-25', '10:35:48', 'Complaint', 'Defected Product', 'Delivered product is defected.'),
(225, 1, '2018-02-25', '10:35:54', 'Feedback', 'Website related', 'Good user-interface.'),
(3, 2, '2018-04-06', '18:14:48', 'Complaint', 'Notification related', 'Since two month, I didn\'t getting any SMS/Email regarding product delivery, I am doing manually by checking order status in website. Please fix this issue.');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `oid` int(10) NOT NULL,
  `cid` int(10) NOT NULL,
  `did` int(5) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `amt` float NOT NULL DEFAULT '475',
  `status` varchar(20) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`oid`, `cid`, `did`, `date`, `time`, `amt`, `status`) VALUES
(10, 5, 1, '2018-02-14', '10:07:17', 475, 'Delivered'),
(15, 5, 1, '2018-02-14', '10:15:24', 475, 'Delivered'),
(16, 5, 1, '2018-02-14', '11:13:52', 475, 'Delivered'),
(17, 225, 1, '2018-02-21', '10:10:04', 475, 'Delivered'),
(18, 225, 1, '2018-02-26', '10:04:35', 475, 'Approved'),
(19, 5, 1, '2018-03-21', '18:36:45', 475, 'Delivered'),
(24, 5, 1, '2018-03-22', '13:32:31', 475, 'Pending'),
(25, 3, 2, '2018-04-06', '17:39:56', 475, 'Pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `consumer_detail`
--
ALTER TABLE `consumer_detail`
  ADD PRIMARY KEY (`cid`),
  ADD KEY `con_dis_id` (`did`);

--
-- Indexes for table `distributor_detail`
--
ALTER TABLE `distributor_detail`
  ADD PRIMARY KEY (`did`);

--
-- Indexes for table `feedback_complain`
--
ALTER TABLE `feedback_complain`
  ADD KEY `fc_con_id` (`cid`),
  ADD KEY `fc_dis_id` (`did`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`oid`),
  ADD KEY `od_con_id` (`cid`),
  ADD KEY `od_dis_id` (`did`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `aid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `consumer_detail`
--
ALTER TABLE `consumer_detail`
  MODIFY `cid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=226;

--
-- AUTO_INCREMENT for table `distributor_detail`
--
ALTER TABLE `distributor_detail`
  MODIFY `did` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `oid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `consumer_detail`
--
ALTER TABLE `consumer_detail`
  ADD CONSTRAINT `con_dis_id` FOREIGN KEY (`did`) REFERENCES `distributor_detail` (`did`);

--
-- Constraints for table `feedback_complain`
--
ALTER TABLE `feedback_complain`
  ADD CONSTRAINT `fc_con_id` FOREIGN KEY (`cid`) REFERENCES `consumer_detail` (`cid`),
  ADD CONSTRAINT `fc_dis_id` FOREIGN KEY (`did`) REFERENCES `distributor_detail` (`did`);

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `od_con_id` FOREIGN KEY (`cid`) REFERENCES `consumer_detail` (`cid`),
  ADD CONSTRAINT `od_dis_id` FOREIGN KEY (`did`) REFERENCES `distributor_detail` (`did`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
