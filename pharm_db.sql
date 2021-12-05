-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2021 at 03:31 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pharm_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `Role_role_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(45) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `Active` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `firstname`, `lastname`, `Role_role_id`, `email`, `password`, `create_date`, `update_date`, `Active`) VALUES
(1, 'System', 'Admin', 3, 'admin@admin.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', '2021-08-20 00:00:00', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `awarded`
--

CREATE TABLE `awarded` (
  `award_id` int(11) NOT NULL,
  `Awardedcol` varchar(45) DEFAULT NULL,
  `GenericResponse_generic_response_id` int(11) NOT NULL,
  `Supplier_supplier_id` int(11) NOT NULL,
  `Generic_generic_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `status` varchar(45) DEFAULT 'Pending',
  `quantity` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `delevery_date` date DEFAULT NULL,
  `received_status` tinyint(4) DEFAULT 0,
  `create_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `Active` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `bill_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`bill_id`, `customer_id`, `status`, `create_date`) VALUES
(4, 2, 1, '2021-09-25 07:02:30'),
(5, 2, 1, '2021-09-25 07:48:40'),
(6, 2, 1, '2021-09-25 07:49:23'),
(7, 3, 1, '2021-09-25 07:51:12'),
(8, 2, 1, '2021-09-26 09:30:28');

-- --------------------------------------------------------

--
-- Table structure for table `bill_item`
--

CREATE TABLE `bill_item` (
  `bill_item_id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bill_item`
--

INSERT INTO `bill_item` (`bill_item_id`, `bill_id`, `product_id`, `quantity`, `price`, `amount`, `create_date`) VALUES
(6, 4, 5, 3, 100, 300, '2021-09-25 07:46:57'),
(7, 4, 8, 3, 150, 450, '2021-09-25 07:47:10'),
(8, 5, 6, 1, 5000, 5000, '2021-09-25 07:48:40'),
(9, 6, 9, 5, 20, 100, '2021-09-25 07:49:23'),
(10, 7, 10, 2, 6000, 12000, '2021-09-25 07:51:12'),
(11, 8, 6, 1, 5000, 5000, '2021-09-26 09:30:28'),
(12, 8, 9, 1, 20, 20, '2021-09-26 09:30:36'),
(13, 8, 5, 2, 100, 200, '2021-09-27 18:16:45');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `name`, `create_date`, `update_date`) VALUES
(1, 'Medicine', '0000-00-00 00:00:00', NULL),
(2, 'Medical Devices', '2021-08-02 00:00:00', NULL),
(3, 'Wellness Products', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `Role_role_id` int(11) NOT NULL DEFAULT 2,
  `firstname` varchar(45) DEFAULT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `gender` varchar(45) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `contactNo` varchar(45) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(100) NOT NULL,
  `age` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `Active` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `Role_role_id`, `firstname`, `lastname`, `gender`, `address`, `contactNo`, `email`, `password`, `age`, `city`, `create_date`, `update_date`, `Active`) VALUES
(2, 2, 'Kalindu', 'Senadheera', 'Male', '400/22, morakatiya rd, Galle', '0774567892', 'kalindu@gmail.com', 'bf7ba7aa55b20000b4a878202debab5c3079f1d3', '25', 'Galle', '2021-09-24 09:06:28', '2021-09-24 09:06:28', 1),
(3, 2, 'Kasun', 'Yapa', 'Male', '158/22, Araliya Uyana, Depanama', '077844567', 'kasun@gmail.com', '29615818ed9788ec125dc0798ef685fef5379aaf', '30', 'Colombo', '2021-09-25 05:43:31', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `generic`
--

CREATE TABLE `generic` (
  `generic_id` int(11) NOT NULL,
  `Category_category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `current_stock_level` int(11) DEFAULT NULL,
  `reorder_stock_level` int(11) DEFAULT NULL,
  `buffer_stock_level` int(11) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `total_space` int(11) DEFAULT NULL,
  `total_req_per_year` int(11) DEFAULT NULL,
  `monthly_consumption` int(11) DEFAULT NULL,
  `lead_time` int(11) DEFAULT NULL,
  `purchese_amount` int(11) DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `Active` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `generic`
--

INSERT INTO `generic` (`generic_id`, `Category_category_id`, `name`, `current_stock_level`, `reorder_stock_level`, `buffer_stock_level`, `status`, `total_space`, `total_req_per_year`, `monthly_consumption`, `lead_time`, `purchese_amount`, `create_date`, `update_date`, `Active`) VALUES
(2, 3, 'Aqueous Cream', 142, 60, 50, '', 150, 120, 10, 50, 1, '2021-09-24 09:14:40', NULL, 1),
(3, 1, 'Azithromycin', 1494, 600, 500, '', 1500, 1200, 100, 500, 1, '2021-09-24 09:17:44', NULL, 1),
(4, 2, 'Catheters', 26, 60, 50, '', 150, 120, 10, 5, 1, '2021-09-25 07:01:33', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `genericrequest`
--

CREATE TABLE `genericrequest` (
  `generic_request_id` int(11) NOT NULL,
  `Generic_generic_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `quote_value` int(11) NOT NULL,
  `generic_order_status` tinyint(4) NOT NULL DEFAULT 0,
  `award_status` int(11) NOT NULL DEFAULT 0,
  `create_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `Active` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `genericrequest`
--

INSERT INTO `genericrequest` (`generic_request_id`, `Generic_generic_id`, `quantity`, `quote_value`, `generic_order_status`, `award_status`, `create_date`, `update_date`, `Active`) VALUES
(3, 4, 2, 0, 1, 0, '2021-09-25 06:47:35', NULL, 1),
(4, 4, 2, 0, 1, 0, '2021-09-25 11:39:18', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `genericrequestsupplier`
--

CREATE TABLE `genericrequestsupplier` (
  `generic_request_supplier_id` int(11) NOT NULL,
  `generic_request_id` int(11) NOT NULL,
  `Supplier_supplier_id` int(11) NOT NULL,
  `supplier_acceptance` varchar(45) DEFAULT NULL,
  `request_status` tinyint(4) NOT NULL DEFAULT 1,
  `create_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `Active` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `genericrequestsupplier`
--

INSERT INTO `genericrequestsupplier` (`generic_request_supplier_id`, `generic_request_id`, `Supplier_supplier_id`, `supplier_acceptance`, `request_status`, `create_date`, `update_date`, `Active`) VALUES
(3, 3, 31, 'Pending', 1, '2021-09-25 06:47:37', NULL, 1),
(4, 4, 30, 'Pending', 1, '2021-09-25 11:39:18', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `genericresponse`
--

CREATE TABLE `genericresponse` (
  `generic_response_id` int(11) NOT NULL,
  `GenericRequest_generic_request_id` int(11) NOT NULL,
  `GenericRequestSupplier_id` int(11) NOT NULL,
  `Product_product_id` int(11) NOT NULL,
  `price_evaluate_status` tinyint(4) DEFAULT 0,
  `quality_evaluate_status` tinyint(4) DEFAULT 0,
  `award_acceptance` varchar(45) DEFAULT 'Pending',
  `quantity` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `pri_stat` tinyint(4) NOT NULL DEFAULT 0,
  `deliverydate` date NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `Active` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nrmi`
--

CREATE TABLE `nrmi` (
  `productname` varchar(11) NOT NULL,
  `regno` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nrmi`
--

INSERT INTO `nrmi` (`productname`, `regno`) VALUES
('Tempo', 'D001'),
('Performa', 'D002'),
('Hickman', 'D003'),
('Puzucil', 'M001'),
('Zithrozine', 'M002'),
('Azifred', 'M003'),
('Baby Cheram', 'W001'),
('Pairs', 'W002'),
('Silky', 'W003');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `Generic_generic_id` int(11) NOT NULL,
  `Supplier_supplier_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `NMRA_regno` varchar(100) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `manufacture_name` varchar(100) DEFAULT NULL,
  `manufacture_country` varchar(100) DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `Active` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `Generic_generic_id`, `Supplier_supplier_id`, `name`, `NMRA_regno`, `price`, `manufacture_name`, `manufacture_country`, `create_date`, `update_date`, `Active`) VALUES
(5, 2, 31, 'Baby Cheramy', 'W001', 100, NULL, NULL, '2021-09-23 15:36:07', NULL, 1),
(6, 4, 31, 'Tempo', 'D001', 5000, NULL, NULL, '2021-09-23 15:36:07', NULL, 1),
(7, 3, 31, 'Puzucil', 'M001', 10, NULL, NULL, '2021-09-23 15:36:07', NULL, 1),
(8, 2, 30, 'Pairs', 'W002', 150, NULL, NULL, '2021-09-23 15:39:11', NULL, 1),
(9, 3, 30, 'Zithrozine', 'M002', 20, NULL, NULL, '2021-09-23 15:39:11', NULL, 1),
(10, 4, 30, 'Performa', 'D002', 6000, NULL, NULL, '2021-09-23 15:39:11', NULL, 1),
(11, 2, 32, 'Silky', 'W003', 200, NULL, NULL, '2021-09-23 15:43:42', NULL, 1),
(12, 3, 32, 'Azifred', 'M003', 30, NULL, NULL, '2021-09-23 15:43:42', NULL, 1),
(13, 4, 32, 'Hickman', 'D003', 7000, NULL, NULL, '2021-09-23 15:43:42', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `roal_name` varchar(45) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `Active` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `roal_name`, `create_date`, `update_date`, `Active`) VALUES
(1, 'Supplier', '0000-00-00 00:00:00', NULL, 1),
(2, 'Customer', '2021-08-01 00:00:00', NULL, 1),
(3, 'Admin', '2021-08-01 00:00:00', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `stock_log`
--

CREATE TABLE `stock_log` (
  `id` int(11) NOT NULL,
  `gen_id_scrap` int(11) NOT NULL,
  `status` varchar(100) NOT NULL,
  `amount` int(11) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock_log`
--

INSERT INTO `stock_log` (`id`, `gen_id_scrap`, `status`, `amount`, `create_date`) VALUES
(15, 2, 'Order', 3, '2021-09-25 07:47:40'),
(16, 2, 'Order', 3, '2021-09-25 07:47:40'),
(17, 4, 'Order', 1, '2021-09-25 07:49:10'),
(18, 3, 'Order', 5, '2021-09-25 07:49:56'),
(19, 4, 'Order', 2, '2021-09-25 07:51:30'),
(20, 4, 'Order', 1, '2021-09-27 18:17:25'),
(21, 3, 'Order', 1, '2021-09-27 18:17:25'),
(22, 2, 'Order', 2, '2021-09-27 18:17:25');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` int(11) NOT NULL,
  `Role_role_id` int(11) NOT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `gender` varchar(45) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `contactNo` varchar(45) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(100) NOT NULL,
  `age` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `Active` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `Role_role_id`, `firstname`, `lastname`, `gender`, `address`, `contactNo`, `email`, `password`, `age`, `city`, `create_date`, `update_date`, `Active`) VALUES
(30, 1, 'Supun', 'Perera', 'Male', '100/22,salmal uyana, Pannipitiya', '0771234567', 'supuneosu@gmail.com', 'c1e4a5949439776922719fc76497d31f7e7a80e0', '28', 'Colombo', '2021-09-23 13:51:46', NULL, 1),
(31, 1, 'Saman', 'Kumara', 'Male', '200/22,uyana rd, Pannipitiya', '0772345678', 'samaneosu@gmail.com', 'e9fd308dc5b9fbef3820fceb8998dcc4c7df6968', '29', 'Colombo', '2021-09-23 13:54:20', NULL, 1),
(32, 1, 'Supuli', 'Samarasinghe', 'Male', '300/22,Pamunuwa, Maharagama', '0773456789', 'supulieosu@gmail.com', '615aed3117fd80c3c53699e0cd540677feaa4ddf', '30', 'Colombo', '2021-09-23 13:56:15', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `suppliercompany`
--

CREATE TABLE `suppliercompany` (
  `company_id` int(11) NOT NULL,
  `Supplier_supplier_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `contactNo` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `regnNo` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `year_established` int(11) DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `Active` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suppliercompany`
--

INSERT INTO `suppliercompany` (`company_id`, `Supplier_supplier_id`, `name`, `address`, `contactNo`, `email`, `regnNo`, `city`, `year_established`, `create_date`, `update_date`, `Active`) VALUES
(2, 30, 'Supun Pvt Ltd', '158/22, Araliya Uyana, Kaduruwa', '0112562745', 'supunco@gmail.com', 'REG12', 'Kaduruwa', 2000, '2021-09-23 13:59:57', NULL, 1),
(3, 31, 'SamanCo Pvt Ltd', '200/22, nidahas mw, Colombo', '0112562747', 'samaneosu@gmail.com', 'REG45', 'Colombo', 1998, '2021-09-24 06:19:50', NULL, 1),
(4, 32, 'Supulico Pvt Ltd', '300/55,parakum pl, Colombo', '0112789456', 'supulieosu@gmail.com', 'REG43', 'Colombo', 2000, '2021-09-24 06:25:24', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD KEY `fk_Admin_Role1_idx` (`Role_role_id`);

--
-- Indexes for table `awarded`
--
ALTER TABLE `awarded`
  ADD PRIMARY KEY (`award_id`),
  ADD KEY `fk_Awarded_GenericResponse1_idx` (`GenericResponse_generic_response_id`),
  ADD KEY `fk_Awarded_Supplier1_idx` (`Supplier_supplier_id`),
  ADD KEY `fk_Awarded_Generic1_idx` (`Generic_generic_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`bill_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `bill_item`
--
ALTER TABLE `bill_item`
  ADD PRIMARY KEY (`bill_item_id`),
  ADD KEY `FK_Prod_ID` (`product_id`),
  ADD KEY `FK_Bill_ID` (`bill_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `fk_Supplier_Role1_idx` (`Role_role_id`);

--
-- Indexes for table `generic`
--
ALTER TABLE `generic`
  ADD PRIMARY KEY (`generic_id`),
  ADD KEY `fk_Generic_Category_idx` (`Category_category_id`);

--
-- Indexes for table `genericrequest`
--
ALTER TABLE `genericrequest`
  ADD PRIMARY KEY (`generic_request_id`),
  ADD KEY `fk_GenericRequest_Generic1_idx` (`Generic_generic_id`);

--
-- Indexes for table `genericrequestsupplier`
--
ALTER TABLE `genericrequestsupplier`
  ADD PRIMARY KEY (`generic_request_supplier_id`),
  ADD KEY `fk_GenericRequest_generic_request_id_idx` (`generic_request_id`),
  ADD KEY `fk_GenericRequest_Supplier1_1_idx` (`Supplier_supplier_id`);

--
-- Indexes for table `genericresponse`
--
ALTER TABLE `genericresponse`
  ADD PRIMARY KEY (`generic_response_id`),
  ADD KEY `fk_GenericResponse_GenericRequest1_idx` (`GenericRequest_generic_request_id`),
  ADD KEY `fk_GenericResponse_Product1_idx` (`Product_product_id`),
  ADD KEY `GenericRequestSupplier_id` (`GenericRequestSupplier_id`);

--
-- Indexes for table `nrmi`
--
ALTER TABLE `nrmi`
  ADD PRIMARY KEY (`regno`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_Product_Generic1_idx` (`Generic_generic_id`),
  ADD KEY `fk_Product_Supplier1_idx` (`Supplier_supplier_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `stock_log`
--
ALTER TABLE `stock_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`),
  ADD KEY `fk_Supplier_Role1_idx` (`Role_role_id`);

--
-- Indexes for table `suppliercompany`
--
ALTER TABLE `suppliercompany`
  ADD PRIMARY KEY (`company_id`),
  ADD KEY `fk_SupplierCompany_Supplier1_idx` (`Supplier_supplier_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `awarded`
--
ALTER TABLE `awarded`
  MODIFY `award_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `bill_item`
--
ALTER TABLE `bill_item`
  MODIFY `bill_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `generic`
--
ALTER TABLE `generic`
  MODIFY `generic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `genericrequest`
--
ALTER TABLE `genericrequest`
  MODIFY `generic_request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `genericrequestsupplier`
--
ALTER TABLE `genericrequestsupplier`
  MODIFY `generic_request_supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `genericresponse`
--
ALTER TABLE `genericresponse`
  MODIFY `generic_response_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stock_log`
--
ALTER TABLE `stock_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `suppliercompany`
--
ALTER TABLE `suppliercompany`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `fk_Admin_Role1` FOREIGN KEY (`Role_role_id`) REFERENCES `role` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `awarded`
--
ALTER TABLE `awarded`
  ADD CONSTRAINT `Awarded_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `fk_Awarded_Generic1` FOREIGN KEY (`Generic_generic_id`) REFERENCES `generic` (`generic_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Awarded_GenericResponse1` FOREIGN KEY (`GenericResponse_generic_response_id`) REFERENCES `genericresponse` (`generic_response_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Awarded_Supplier1` FOREIGN KEY (`Supplier_supplier_id`) REFERENCES `supplier` (`supplier_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `bill`
--
ALTER TABLE `bill`
  ADD CONSTRAINT `Bill_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);

--
-- Constraints for table `bill_item`
--
ALTER TABLE `bill_item`
  ADD CONSTRAINT `FK_Bill_ID` FOREIGN KEY (`bill_id`) REFERENCES `bill` (`bill_id`),
  ADD CONSTRAINT `FK_Prod_ID` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `Customer_ibfk_1` FOREIGN KEY (`Role_role_id`) REFERENCES `role` (`role_id`);

--
-- Constraints for table `generic`
--
ALTER TABLE `generic`
  ADD CONSTRAINT `fk_Generic_Category` FOREIGN KEY (`Category_category_id`) REFERENCES `category` (`category_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `genericrequest`
--
ALTER TABLE `genericrequest`
  ADD CONSTRAINT `fk_GenericRequest_Generic1` FOREIGN KEY (`Generic_generic_id`) REFERENCES `generic` (`generic_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `genericrequestsupplier`
--
ALTER TABLE `genericrequestsupplier`
  ADD CONSTRAINT `fk_GenericRequest_Supplier1_1` FOREIGN KEY (`Supplier_supplier_id`) REFERENCES `supplier` (`supplier_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_GenericRequest_generic_request_id` FOREIGN KEY (`generic_request_id`) REFERENCES `genericrequest` (`generic_request_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `genericresponse`
--
ALTER TABLE `genericresponse`
  ADD CONSTRAINT `GenericResponse_ibfk_1` FOREIGN KEY (`GenericRequestSupplier_id`) REFERENCES `supplier` (`supplier_id`),
  ADD CONSTRAINT `fk_GenericResponse_GenericRequest1` FOREIGN KEY (`GenericRequest_generic_request_id`) REFERENCES `genericrequest` (`generic_request_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_GenericResponse_Product1` FOREIGN KEY (`Product_product_id`) REFERENCES `product` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_Product_Generic1` FOREIGN KEY (`Generic_generic_id`) REFERENCES `generic` (`generic_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Product_Supplier1` FOREIGN KEY (`Supplier_supplier_id`) REFERENCES `supplier` (`supplier_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `supplier`
--
ALTER TABLE `supplier`
  ADD CONSTRAINT `fk_Supplier_Role1` FOREIGN KEY (`Role_role_id`) REFERENCES `role` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `suppliercompany`
--
ALTER TABLE `suppliercompany`
  ADD CONSTRAINT `fk_SupplierCompany_Supplier1` FOREIGN KEY (`Supplier_supplier_id`) REFERENCES `supplier` (`supplier_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
