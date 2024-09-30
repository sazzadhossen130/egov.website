-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 24, 2024 at 10:23 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `svc_crack`
--

-- --------------------------------------------------------

--
-- Table structure for table `control`
--

CREATE TABLE `control` (
  `id` int NOT NULL,
  `charge` varchar(120) DEFAULT NULL,
  `approval` varchar(120) DEFAULT NULL,
  `register` varchar(200) DEFAULT NULL,
  `login` varchar(250) DEFAULT NULL,
  `bot_token` varchar(250) DEFAULT NULL,
  `log_channel` varchar(120) DEFAULT NULL,
  `rg_msg` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `notice` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `robi_user` varchar(250) DEFAULT NULL,
  `robi_token` longtext,
  `bl_user` varchar(120) DEFAULT NULL,
  `bl_token` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `control`
--

INSERT INTO `control` (`id`, `charge`, `approval`, `register`, `login`, `bot_token`, `log_channel`, `rg_msg`, `notice`, `robi_user`, `robi_token`, `bl_user`, `bl_token`) VALUES
(1, '5', '100', '1', '1', '10000', '100', 'SCRIPT BY Blackcat', 'SCRIPT BY Blackcat', 'Blackcat', '400', 'Blackcat', 'Blackcat');

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `id` int NOT NULL,
  `FullName` varchar(120) DEFAULT NULL,
  `Username` varchar(120) DEFAULT NULL,
  `UserEmail` varchar(200) DEFAULT NULL,
  `Password` varchar(250) DEFAULT NULL,
  `role` tinyint(1) NOT NULL DEFAULT '0',
  `RegDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`id`, `FullName`, `Username`, `UserEmail`, `Password`, `role`, `RegDate`) VALUES
(1, 'TEAM X 1337', 'tx1337Admin', 'tx1337Admin@teamxstore.xyz', 'e77c8c08f575557a75a41284fd43c7e8', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_balance`
--

CREATE TABLE `tbl_balance` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `username` varchar(120) DEFAULT NULL,
  `deposit` int DEFAULT '0',
  `withdraw` int DEFAULT '0',
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `tbl_balance`
--

INSERT INTO `tbl_balance` (`id`, `user_id`, `username`, `deposit`, `withdraw`, `date`) VALUES
(1, 1, '3213dsada', 500, 0, '2024-06-24 21:18:50'),
(87, 1, NULL, 0, 100, '2024-06-24 21:21:26'),
(88, 1, NULL, 231323, 0, '2024-06-24 21:25:15');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_request`
--

CREATE TABLE `tbl_request` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `username` varchar(120) DEFAULT NULL,
  `deposit` int NOT NULL DEFAULT '0',
  `number` int NOT NULL,
  `txn_id` varchar(120) DEFAULT NULL,
  `withdraw` int DEFAULT '0',
  `date` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_submission`
--

CREATE TABLE `tbl_submission` (
  `id` int NOT NULL,
  `certi_no` varchar(55) DEFAULT NULL,
  `type` varchar(11) DEFAULT NULL,
  `national_id` varchar(55) DEFAULT NULL,
  `passport_no` varchar(55) DEFAULT NULL,
  `nationality` text,
  `name` varchar(55) DEFAULT NULL,
  `date_birth` varchar(10) DEFAULT NULL,
  `gender` varchar(11) DEFAULT NULL,
  `doseone_date` date DEFAULT NULL,
  `doseone_name` text,
  `dosetwo_date` date DEFAULT NULL,
  `dosetwo_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `dosethree_date` date DEFAULT NULL,
  `dosethree_name` text,
  `vacc_center` text,
  `vacc_by` text,
  `total_dose` varchar(11) DEFAULT NULL,
  `qr_code` varchar(55) DEFAULT NULL,
  `created_by` varchar(55) DEFAULT NULL,
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `submitted_by` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `control`
--
ALTER TABLE `control`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_balance`
--
ALTER TABLE `tbl_balance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_request`
--
ALTER TABLE `tbl_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_submission`
--
ALTER TABLE `tbl_submission`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3678;

--
-- AUTO_INCREMENT for table `tbl_balance`
--
ALTER TABLE `tbl_balance`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `tbl_request`
--
ALTER TABLE `tbl_request`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_submission`
--
ALTER TABLE `tbl_submission`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
