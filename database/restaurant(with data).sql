-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2022 at 12:23 PM
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
(3, 'burger'),
(4, 'pizza');

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
(2, 'thanasak', '11121112', 'thanasak', 'limsila', 'some where', '1234567890', '278523561_551085866434063_4389545182311135483_n.jpg'),
(3, 'test01', '123456789', 'Porter', 'Freeman', 'some where in the world', '1234567890', ''),
(4, 'test02', '123456789', 'Riley', 'Bryant', 'some where in the world', '1234567890', ''),
(5, 'test03', '123456789', 'Scott', 'Hunter', 'some where in the world', '1234567890', ''),
(6, 'test04', '123456789', 'Simmons', 'Wells', 'some where in the world', '1234567890', ''),
(7, 'test05', '123456789', 'Mendoza', 'Ward', 'some where in the world', '1234567890', '');

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

--
-- Dumping data for table `delivery`
--

INSERT INTO `delivery` (`order_id`, `bill_id`, `order_price`, `order_status`, `order_payment`, `order_time`, `order_date`, `cus_id`) VALUES
(6, 'D2204231', 105.60, 'received', '263707445_466903101519007_9047869345502216499_n.jpg', '14:16:00', '2022-04-25', 2),
(7, 'D2204237', 232.93, 'received', 'bank.png', '17:29:00', '2022-04-25', 3),
(8, 'D2204238', 121.65, 'received', 'bank.png', '17:33:00', '2022-04-25', 4),
(9, 'D2204239', 207.25, 'received', 'bank.png', '17:39:00', '2022-04-25', 5),
(10, 'D22042310', 255.40, 'received', 'bank.png', '21:24:00', '2022-04-25', 6),
(11, 'D22042311', 207.25, 'received', 'bank.png', '21:25:00', '2022-04-25', 7),
(12, 'D22042512', 232.93, 'waiting', '', '16:03:00', '2022-04-25', 3),
(13, 'D22042513', 271.45, 'waiting', '', '16:08:00', '2022-04-25', 5);

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
(11, 'T22042219', 'levi', 'table', 181.20, 'paid', '10:04:00', '2022-04-25', 2378.00, 2196.80),
(13, 'T22042321', 'Kelley', 'table', 79.55, 'paid', '10:56:00', '2022-04-25', 100.00, 20.45),
(14, 'P22042322', 'Fisher', 'package', 159.80, 'paid', '11:10:00', '2022-04-25', 160.00, 0.20),
(15, 'T22042523', 'Thom', 'table', 111.65, 'paid', '12:16:00', '2022-04-25', 200.00, 88.35),
(16, 'T22042524', 'Penny', 'table', 111.65, 'paid', '13:42:00', '2022-04-25', 200.00, 88.35),
(17, 'P22042525', 'Ellie', 'package', 222.93, 'paid', '15:36:00', '2022-04-25', 500.00, 277.07),
(18, 'T22042526', 'Tan', 'table', 229.35, 'paid', '15:39:00', '2022-04-25', 250.00, 20.65),
(19, 'T22042527', 'Lucy', 'table', 288.20, 'paid', '17:05:00', '2022-04-25', 300.00, 11.80),
(20, 'P22042528', 'New', 'package', 320.30, 'paid', '17:26:00', '2022-04-25', 340.00, 19.70),
(21, 'T22042529', 'Lee', 'table', 618.83, 'paid', '17:58:00', '2022-04-25', 1000.00, 381.17),
(22, 'P22042530', 'Ram', 'package', 170.50, 'paid', '18:09:00', '2022-04-25', 200.00, 29.50);

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
(1, 'burrito', 'beef', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione dicta blanditiis dolores. Offic', 80.00, 'burrito.jpg', 1),
(2, 'enchiladas', 'beef', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda sed officia rerum commodi illum m', 95.00, 'enchiladas.jpg', 1),
(3, 'fajitas', 'chicken', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda sed officia rerum commodi illum m', 165.00, 'fajitas.jpg', 1),
(4, 'guacamole', '', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda sed officia rerum commodi illum m', 30.00, 'guacamole-dip.jpg', 1),
(5, '3 tacos', 'pork', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda sed officia rerum commodi illum m', 65.00, 'tacos.jpg', 1),
(6, 'cheeseburger', '', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda sed officia rerum commodi illum m', 70.00, 'burgur.jpg', 3),
(7, 'stir fried basil', 'pork', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda sed officia rerum commodi illum m', 50.00, 'Stir Fried Basil.jpg', 2),
(8, 'tomyumkung', '', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda sed officia rerum commodi illum m', 120.00, 'tom-yum-soup-6126147_960_720.jpg', 2),
(9, 'pepperoni ', 'M', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda sed officia rerum commodi illum m', 199.00, 'pepperoni pizza.jpg', 4);

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
(10, 'T22042219', 1, 2, 160.00),
(17, 'D2204231', 1, 1, 80.00),
(18, 'T22042321', 5, 1, 65.00),
(19, 'P22042322', 6, 2, 140.00),
(20, 'D2204237', 9, 1, 199.00),
(21, 'D2204238', 5, 1, 65.00),
(22, 'D2204238', 4, 1, 30.00),
(23, 'D2204239', 1, 1, 80.00),
(24, 'D2204239', 2, 1, 95.00),
(25, 'D22042310', 7, 2, 100.00),
(26, 'D22042310', 8, 1, 120.00),
(27, 'D22042311', 1, 1, 80.00),
(28, 'D22042311', 2, 1, 95.00),
(29, 'T22042523', 2, 1, 95.00),
(30, 'T22042524', 5, 1, 65.00),
(31, 'T22042524', 4, 1, 30.00),
(32, 'P22042525', 9, 1, 199.00),
(33, 'T22042526', 2, 1, 95.00),
(34, 'T22042526', 1, 1, 80.00),
(35, 'T22042526', 4, 1, 30.00),
(36, 'T22042527', 4, 1, 30.00),
(37, 'T22042527', 3, 1, 165.00),
(38, 'T22042527', 5, 1, 65.00),
(39, 'P22042528', 7, 2, 100.00),
(40, 'P22042528', 8, 1, 120.00),
(41, 'P22042528', 6, 1, 70.00),
(42, 'T22042529', 9, 1, 199.00),
(43, 'T22042529', 5, 1, 65.00),
(44, 'T22042529', 6, 2, 140.00),
(45, 'T22042529', 3, 1, 165.00),
(46, 'P22042530', 7, 3, 150.00),
(47, 'D22042512', 9, 1, 199.00),
(48, 'D22042513', 6, 2, 140.00),
(49, 'D22042513', 2, 1, 95.00);

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
  MODIFY `cate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `cus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `emp_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `front`
--
ALTER TABLE `front`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `set_id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
