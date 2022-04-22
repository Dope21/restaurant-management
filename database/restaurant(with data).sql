-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2022 at 08:50 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cate_id` int(11) NOT NULL,
  `cate_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cate_id`, `cate_name`) VALUES
(1, 'mexican'),
(2, 'thai'),
(3, 'burger');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `cus_id` int(11) NOT NULL,
  `cus_username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `cus_password` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `cus_fname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `cus_lname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `cus_address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `cus_number` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `cus_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cus_id`, `cus_username`, `cus_password`, `cus_fname`, `cus_lname`, `cus_address`, `cus_number`, `cus_image`) VALUES
(2, 'thanasak', '11121112', 'thanasak', 'limsila', 'some where', '1234567890', '278523561_551085866434063_4389545182311135483_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `order_id` int(11) NOT NULL,
  `bill_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `order_price` double(7,2) NOT NULL,
  `order_status` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `order_payment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order_time` time NOT NULL,
  `order_date` date NOT NULL,
  `cus_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `emp_id` int(10) NOT NULL,
  `emp_username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `emp_password` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `emp_address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `emp_number` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `emp_fname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `emp_lname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `emp_status` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `emp_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_id`, `emp_username`, `emp_password`, `emp_address`, `emp_number`, `emp_fname`, `emp_lname`, `emp_status`, `emp_image`) VALUES
(1, 'admin', '123456789', '-', '9999999999', 'admin', 'admin', 'admin', '3073867 (1).jpg');

-- --------------------------------------------------------

--
-- Table structure for table `front`
--

CREATE TABLE `front` (
  `order_id` int(11) NOT NULL,
  `bill_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `order_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `order_cate` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `order_price` double(7,2) NOT NULL,
  `order_status` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `order_time` time NOT NULL,
  `order_date` date NOT NULL,
  `order_receive` double(7,2) NOT NULL,
  `order_change` double(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `front`
--

INSERT INTO `front` (`order_id`, `bill_id`, `order_name`, `order_cate`, `order_price`, `order_status`, `order_time`, `order_date`, `order_receive`, `order_change`) VALUES
(11, 'T22042219', 'levi', 'table', 181.20, 'paid', '13:03:00', '2022-04-22', 2378.00, 2196.80);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL,
  `menu_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `menu_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `menu_description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `menu_price` double(7,2) NOT NULL,
  `menu_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cate_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `menu_name`, `menu_type`, `menu_description`, `menu_price`, `menu_image`, `cate_id`) VALUES
(1, 'burrito', 'beef', '    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione dicta blanditiis dolores. Offic', 80.00, 'burrito.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `detail_id` int(11) NOT NULL,
  `bill_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `menu_id` int(11) NOT NULL,
  `menu_qt` int(10) NOT NULL,
  `menu_total` double(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`detail_id`, `bill_id`, `menu_id`, `menu_qt`, `menu_total`) VALUES
(1, 'T2204229', 1, 2, 160.00),
(10, 'T22042219', 1, 2, 160.00);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `set_id` int(1) NOT NULL,
  `set_vat` int(3) NOT NULL,
  `set_serv` double(7,2) NOT NULL,
  `set_deliver` double(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`set_id`, `set_vat`, `set_serv`, `set_deliver`) VALUES
(1, 7, 10.00, 20.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cate_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`cus_id`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `front`
--
ALTER TABLE `front`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`detail_id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`set_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `cus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `emp_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `front`
--
ALTER TABLE `front`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `set_id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
