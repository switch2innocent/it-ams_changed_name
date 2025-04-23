-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2025 at 08:53 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `itamsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_tbl`
--

CREATE TABLE `audit_tbl` (
  `id` int(11) NOT NULL,
  `asset_id` int(11) DEFAULT NULL,
  `old_value` text DEFAULT NULL,
  `new_value` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `changed_at` date NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_tbl`
--

INSERT INTO `audit_tbl` (`id`, `asset_id`, `old_value`, `new_value`, `user_id`, `changed_at`, `status`) VALUES
(1, 1, '<b>Description:</b> Sample <br> <b>Accountable:</b> Sample <br> <b>User:</b> Sample <br> <b>Department:</b> Support Services <br> <b>Location:</b> ALABANG, MANILA <br> <b>Building Level:</b> Sample <br> <b>Status:</b> In Good Condition <br> <b>Remarks:</b> Sample', '<b>Description:</b> Sample <br> <b>Accountable:</b> Sample <br> <b>User:</b> Sample <br> <b>Department:</b> Support Services <br> <b>Location:</b> ALABANG, MANILA <br> <b>Building Level:</b> Sample <br> <b>Status:</b> Defective <br> <b>Remarks:</b> Sample', 473, '2025-04-22', 1),
(2, 1, '<b>Description:</b> Sample <br> <b>Accountable:</b> Sample <br> <b>User:</b> Sample <br> <b>Department:</b> Support Services <br> <b>Location:</b> ALABANG, MANILA <br> <b>Building Level:</b> Sample <br> <b>Status:</b> Defective <br> <b>Remarks:</b> Sample', '<b>Description:</b> Sample <br> <b>Accountable:</b> Sample <br> <b>User:</b> Sample <br> <b>Department:</b> Support Services <br> <b>Location:</b> ALABANG, MANILA <br> <b>Building Level:</b> Sample <br> <b>Status:</b> In IT Storage Room - Defective <br> <b>Remarks:</b> Sample', 473, '2025-04-22', 1),
(3, 2, '<b>Description:</b> Defective <br> <b>Accountable:</b> Defective <br> <b>User:</b> Defective <br> <b>Department:</b> PMO <br> <b>Location:</b> CALYX CENTRE <br> <b>Building Level:</b> Defective <br> <b>Status:</b> Defective <br> <b>Remarks:</b> Defective', '<b>Description:</b> Defective <br> <b>Accountable:</b> Defective <br> <b>User:</b> Defective <br> <b>Department:</b> PMO <br> <b>Location:</b> CALYX CENTRE <br> <b>Building Level:</b> Defective <br> <b>Status:</b> Scrap <br> <b>Remarks:</b> Defective', 473, '2025-04-22', 1),
(4, 4, '<b>Description:</b> Desktop Pc <br> <b>Accountable:</b> Dexter <br> <b>User:</b> Dexter <br> <b>Department:</b> IT Department <br> <b>Location:</b> TGU <br> <b>Building Level:</b> 15 <br> <b>Status:</b> In Good Condition <br> <b>Remarks:</b> None', '<b>Description:</b> Desktop Pc <br> <b>Accountable:</b> Dexter <br> <b>User:</b> Dexter <br> <b>Department:</b> IT Department <br> <b>Location:</b> TGU <br> <b>Building Level:</b> 15 <br> <b>Status:</b> Defective <br> <b>Remarks:</b> None', 473, '2025-04-23', 1),
(5, 4, '<b>Description:</b> Desktop Pc <br> <b>Accountable:</b> Dexter <br> <b>User:</b> Dexter <br> <b>Department:</b> IT Department <br> <b>Location:</b> TGU <br> <b>Building Level:</b> 15 <br> <b>Status:</b> Defective <br> <b>Remarks:</b> None', '<b>Description:</b> Desktop Pc <br> <b>Accountable:</b> Dexter <br> <b>User:</b> Dexter <br> <b>Department:</b> IT Department <br> <b>Location:</b> TGU <br> <b>Building Level:</b> 15 <br> <b>Status:</b> Scrap <br> <b>Remarks:</b> None', 473, '2025-04-23', 1),
(6, 1, '<b>Description:</b> Sample <br> <b>Accountable:</b> Sample <br> <b>User:</b> Sample <br> <b>Department:</b> Support Services <br> <b>Location:</b> ALABANG, MANILA <br> <b>Building Level:</b> Sample <br> <b>Status:</b> In IT Storage Room - Defective <br> <b>Remarks:</b> Sample', '<b>Description:</b> Sample <br> <b>Accountable:</b> Sample <br> <b>User:</b> Sample <br> <b>Department:</b> Support Services <br> <b>Location:</b> ALABANG, MANILA <br> <b>Building Level:</b> Sample <br> <b>Status:</b> Scrap <br> <b>Remarks:</b> Sample', 473, '2025-04-23', 1),
(7, 5, '<b>Description:</b> Desk <br> <b>Accountable:</b> Jiemart Amancio <br> <b>User:</b> Jiemart Amancio <br> <b>Department:</b> IT Department <br> <b>Location:</b> TGU <br> <b>Building Level:</b> GRND FLR <br> <b>Status:</b> In Good Condition <br> <b>Remarks:</b> None', '<b>Description:</b> Desk <br> <b>Accountable:</b> Jeff Amancio <br> <b>User:</b> Jiemart Amancio <br> <b>Department:</b> IT Department <br> <b>Location:</b> TGU <br> <b>Building Level:</b> GRND FLR <br> <b>Status:</b> In Good Condition <br> <b>Remarks:</b> None', 473, '2025-04-23', 1),
(8, 5, '<b>Description:</b> Desk <br> <b>Accountable:</b> Jeff Amancio <br> <b>User:</b> Jiemart Amancio <br> <b>Department:</b> IT Department <br> <b>Location:</b> TGU <br> <b>Building Level:</b> GRND FLR <br> <b>Status:</b> In Good Condition <br> <b>Remarks:</b> None', '<b>Description:</b> Desk <br> <b>Accountable:</b> Jeff Amancio <br> <b>User:</b> Jiemart Amancio <br> <b>Department:</b> IT Department <br> <b>Location:</b> TGU <br> <b>Building Level:</b> GRND FLR <br> <b>Status:</b> In Good Condition <br> <b>Remarks:</b> None1', 473, '2025-04-23', 1),
(9, 5, '<b>Description:</b> Desk <br> <b>Accountable:</b> Jeff Amancio <br> <b>User:</b> Jiemart Amancio <br> <b>Department:</b> IT Department <br> <b>Location:</b> TGU <br> <b>Building Level:</b> GRND FLR <br> <b>Status:</b> In Good Condition <br> <b>Remarks:</b> None1', '<b>Description:</b> Desk <br> <b>Accountable:</b> Jeff Amancio <br> <b>User:</b> Jiemart Amancio <br> <b>Department:</b> IT Department <br> <b>Location:</b> TGU <br> <b>Building Level:</b> GRND FLR <br> <b>Status:</b> Scrap <br> <b>Remarks:</b> None1', 473, '2025-04-23', 1),
(10, 3, '<b>Description:</b> Avr <br> <b>Accountable:</b> Dexter <br> <b>User:</b> Dexter <br> <b>Department:</b> IT Department <br> <b>Location:</b> TGU <br> <b>Building Level:</b> 15 <br> <b>Status:</b> In Good Condition <br> <b>Remarks:</b> Sample', '<b>Description:</b> Avr <br> <b>Accountable:</b> Dexter <br> <b>User:</b> Dexter <br> <b>Department:</b> IT Department <br> <b>Location:</b> TGU <br> <b>Building Level:</b> 15 <br> <b>Status:</b> In Good Condition <br> <b>Remarks:</b> Sample', 473, '2025-04-23', 1),
(11, 3, '<b>Description:</b> Avr <br> <b>Accountable:</b> Dexter <br> <b>User:</b> Dexter <br> <b>Department:</b> IT Department <br> <b>Location:</b> TGU <br> <b>Building Level:</b> 15 <br> <b>Status:</b> In Good Condition <br> <b>Remarks:</b> Sample', '<b>Description:</b> Avr <br> <b>Accountable:</b> Dexter <br> <b>User:</b> Dexter <br> <b>Department:</b> IT Department <br> <b>Location:</b> TGU <br> <b>Building Level:</b> 15 <br> <b>Status:</b> In Good Condition <br> <b>Remarks:</b> Sample', 473, '2025-04-23', 1),
(12, 6, '<b>Description:</b> Avr <br> <b>Accountable:</b> Elmar Malazarte <br> <b>User:</b> Elmar Malazarte <br> <b>Department:</b> IT Department <br> <b>Location:</b> TGU <br> <b>Building Level:</b> 15 <br> <b>Status:</b> In Good Condition <br> <b>Remarks:</b> None', '<b>Description:</b> Avr <br> <b>Accountable:</b> Elmar Malazarte <br> <b>User:</b> Elmar Malazarte <br> <b>Department:</b> IT Department <br> <b>Location:</b> TGU <br> <b>Building Level:</b> 15 <br> <b>Status:</b> Scrap <br> <b>Remarks:</b> None', 473, '2025-04-23', 1),
(13, 7, '<b>Description:</b> Avr Ups <br> <b>Accountable:</b> Dexter Epi <br> <b>User:</b> Rolando Carabuena <br> <b>Department:</b> IT Department <br> <b>Location:</b> TGU <br> <b>Building Level:</b> 15 Floor <br> <b>Status:</b> In Good Condition <br> <b>Remarks:</b> Reject', '<b>Description:</b> Avr Ups <br> <b>Accountable:</b> Dexter Epi <br> <b>User:</b> Rolando Carabuena <br> <b>Department:</b> IT Department <br> <b>Location:</b> TGU <br> <b>Building Level:</b> 15 Floor <br> <b>Status:</b> Defective <br> <b>Remarks:</b> Reject', 473, '2025-04-23', 1),
(14, 7, '<b>Description:</b> Avr Ups <br> <b>Accountable:</b> Dexter Epi <br> <b>User:</b> Rolando Carabuena <br> <b>Department:</b> IT Department <br> <b>Location:</b> TGU <br> <b>Building Level:</b> 15 Floor <br> <b>Status:</b> Defective <br> <b>Remarks:</b> Reject', '<b>Description:</b> Avr Ups <br> <b>Accountable:</b> Dexter Epi <br> <b>User:</b> Rolando Carabuena <br> <b>Department:</b> IT Department <br> <b>Location:</b> TGU <br> <b>Building Level:</b> 15 Floor <br> <b>Status:</b> In Good Condition <br> <b>Remarks:</b> Reject', 1, '2025-04-23', 1);

-- --------------------------------------------------------

--
-- Table structure for table `form_categories_tbl`
--

CREATE TABLE `form_categories_tbl` (
  `id` int(11) NOT NULL,
  `form_name` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form_categories_tbl`
--

INSERT INTO `form_categories_tbl` (`id`, `form_name`, `status`) VALUES
(1, 'Desktop PC', 1),
(2, 'AVR UPS', 1),
(3, 'Laptop', 1),
(4, 'Printer', 1),
(5, 'Server', 1),
(6, 'Computer Peripheral', 1),
(7, 'Network Device', 1),
(8, 'Scanner', 1),
(9, 'Communication', 1);

-- --------------------------------------------------------

--
-- Table structure for table `it_asset_tbl`
--

CREATE TABLE `it_asset_tbl` (
  `id` int(11) NOT NULL,
  `form_type` varchar(100) NOT NULL,
  `bar_no` varchar(255) DEFAULT NULL,
  `item_desc` varchar(255) DEFAULT NULL,
  `acct_name` varchar(100) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `bldg_lvl` varchar(100) DEFAULT NULL,
  `stat_id` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `it_asset_tbl`
--

INSERT INTO `it_asset_tbl` (`id`, `form_type`, `bar_no`, `item_desc`, `acct_name`, `user`, `dept_id`, `location_id`, `bldg_lvl`, `stat_id`, `remarks`, `created_by_id`, `created_at`, `status`) VALUES
(1, 'Desktop PC', '123', 'Sample', 'Sample', 'Sample', 15, 2, 'Sample', 4, 'Sample', 473, '2025-04-23', 1),
(2, 'Desktop PC', '321', 'Defective', 'Defective', 'Defective', 11, 14, 'Defective', 4, 'Defective', 473, '2025-04-22', 1),
(3, 'AVR UPS', '00540001', 'Avr', 'Dexter', 'Dexter', 7, 1, '15', 1, 'Sample', 473, '2025-04-23', 1),
(4, 'Desktop PC', '001111', 'Desktop Pc', 'Dexter', 'Dexter', 7, 1, '15', 4, 'None', 473, '2025-04-23', 1),
(5, 'Desktop PC', '1232123', 'Desk', 'Jeff Amancio', 'Jiemart Amancio', 7, 1, 'GRND FLR', 4, 'None1', 473, '2025-04-23', 1),
(6, 'AVR UPS', '00540002', 'Avr', 'Elmar Malazarte', 'Elmar Malazarte', 7, 1, '15', 4, 'None', 473, '2025-04-23', 1),
(7, 'AVR UPS', '00540003', 'Avr Ups', 'Dexter Epi', 'Rolando Carabuena', 7, 1, '15 Floor', 1, 'Reject', 473, '2025-04-23', 1);

-- --------------------------------------------------------

--
-- Table structure for table `status_tbl`
--

CREATE TABLE `status_tbl` (
  `id` int(11) NOT NULL,
  `stat_name` varchar(50) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status_tbl`
--

INSERT INTO `status_tbl` (`id`, `stat_name`, `status`) VALUES
(1, 'In Good Condition', 1),
(2, 'Defective', 1),
(3, 'In IT Storage Room - Defective', 1),
(4, 'Scrap', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_tbl`
--
ALTER TABLE `audit_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_categories_tbl`
--
ALTER TABLE `form_categories_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `it_asset_tbl`
--
ALTER TABLE `it_asset_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_tbl`
--
ALTER TABLE `status_tbl`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_tbl`
--
ALTER TABLE `audit_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `form_categories_tbl`
--
ALTER TABLE `form_categories_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `it_asset_tbl`
--
ALTER TABLE `it_asset_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `status_tbl`
--
ALTER TABLE `status_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
