-- phpMyAdmin SQL Dump
-- version 3.5.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 12, 2015 at 11:31 AM
-- Server version: 5.5.28-log
-- PHP Version: 5.4.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `aev_osls`
--

-- --------------------------------------------------------

--
-- Table structure for table `agency_bu`
--

CREATE TABLE IF NOT EXISTS `agency_bu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agency_id` int(11) NOT NULL,
  `bu_id` int(11) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `agency_bu`
--

INSERT INTO `agency_bu` (`id`, `agency_id`, `bu_id`, `start`, `end`) VALUES
(1, 1, 1, '2010-03-12', '2016-02-29'),
(2, 1, 2, '2009-12-11', '2025-09-22'),
(3, 2, 3, '2005-07-18', '2019-10-20'),
(6, 3, 1, '2011-01-01', '2022-02-02'),
(7, 5, 2, '2008-08-08', '2017-07-07'),
(8, 5, 3, '2007-07-07', '2015-12-08'),
(9, 5, 4, '2006-06-06', '2016-01-06'),
(10, 5, 1, '2005-05-05', '2025-05-05'),
(11, 5, 5, '2004-04-04', '2024-04-04'),
(12, 6, 3, '2001-01-01', '2021-01-01'),
(13, 6, 2, '2009-09-09', '2019-09-09');

-- --------------------------------------------------------

--
-- Table structure for table `agency_clients`
--

CREATE TABLE IF NOT EXISTS `agency_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agency_id` int(11) NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `agency_clients`
--

INSERT INTO `agency_clients` (`id`, `agency_id`, `client_name`, `start`, `end`) VALUES
(1, 1, 'Shoe Mart', '2005-08-12', '2026-01-11'),
(2, 2, 'Coca-Cola', '2001-09-12', '2019-05-31'),
(3, 3, 'Mang Inasal', '2002-02-02', '2030-03-03'),
(4, 5, 'JuJu Adventures', '2004-04-04', '2040-02-04'),
(5, 5, 'Starmall', '2003-03-03', '2023-03-31');

-- --------------------------------------------------------

--
-- Table structure for table `agency_mst`
--

CREATE TABLE IF NOT EXISTS `agency_mst` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agency_name` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL,
  `oic` varchar(200) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `license_number` varchar(50) NOT NULL,
  `license_issued` date NOT NULL,
  `license_expiration` date NOT NULL,
  `company_profile` text NOT NULL,
  `contract_status` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `agency_mst`
--

INSERT INTO `agency_mst` (`id`, `agency_name`, `address`, `oic`, `contact_number`, `license_number`, `license_issued`, `license_expiration`, `company_profile`, `contract_status`) VALUES
(1, 'The Security Agency', 'Street, City, Province, Philippines', 'The Boss', '08734567', '007-21JH-2020', '2012-08-04', '2021-08-29', 'It was good.\r\nBetter.', 'Active'),
(2, '2nd Agency', 'BGC, Taguig', 'Wacky Policarps', '09213456767', '011-9876-AB', '2008-02-09', '2016-01-09', 'So-so', 'Active'),
(3, 'JLP Security', 'Cebu, Cebu', 'Ken Kennings', '0922333444', '002W-13MP', '2001-09-21', '2021-12-21', 'The one-stop security agency', 'Active'),
(5, 'The Other Agency', 'The Other Place', 'The Other Boss', '09876666555', '098J-2W34', '2001-07-29', '2019-10-10', 'All you need is us.', 'Active'),
(6, 'Fifth Five Fifty', '77 Poste', 'Eybi Sy', '09212122333', 'SL-7002-888', '2013-09-01', '2023-06-30', 'Formidable Forever 21 22', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `agency_remarks`
--

CREATE TABLE IF NOT EXISTS `agency_remarks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agency_id` int(11) NOT NULL,
  `remarks_date` date NOT NULL,
  `remarks` text NOT NULL,
  `remarker` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `agency_remarks`
--

INSERT INTO `agency_remarks` (`id`, `agency_id`, `remarks_date`, `remarks`, `remarker`) VALUES
(1, 1, '2015-08-19', 'They are OK', ''),
(2, 1, '2015-09-15', 'g\r\ng\r\ng', ''),
(3, 5, '2015-09-28', 'Yeah baby', '');

-- --------------------------------------------------------

--
-- Table structure for table `alert_recipients`
--

CREATE TABLE IF NOT EXISTS `alert_recipients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recipient_id` int(11) NOT NULL,
  `bu_id` int(11) NOT NULL,
  `alert_sec_agency` int(11) NOT NULL,
  `alert_guard` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `bu_mst`
--

CREATE TABLE IF NOT EXISTS `bu_mst` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `bu` varchar(200) NOT NULL,
  `bu_code` varchar(10) NOT NULL,
  `main_group` int(11) NOT NULL,
  `regional_group` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `bu_mst`
--

INSERT INTO `bu_mst` (`id`, `bu`, `bu_code`, `main_group`, `regional_group`) VALUES
(1, 'Test BU 2', 'TBU', 1, 2),
(2, 'Imaginary BU', 'IBU', 5, 1),
(3, 'Non-existent BU', 'NBU', 2, 3),
(4, 'Outside BU', 'OBU', 3, 1),
(5, 'The Other BU', 'TOBU', 1, 2),
(6, 'Seventh Bu', '7BU', 2, 3),
(7, 'Eight BU', '8BU', 5, 2),
(8, 'Something BU', 'SBU', 3, 3),
(9, 'Legendary Unit', 'LU', 5, 4),
(10, 'Last One', 'LO', 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `disposition_revisions`
--

CREATE TABLE IF NOT EXISTS `disposition_revisions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `disposition` text NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `edit_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `disposition_revisions`
--

INSERT INTO `disposition_revisions` (`id`, `disposition`, `ticket_id`, `user_id`, `edit_date`) VALUES
(1, 'It was opened again', 70, 3, '2015-11-16'),
(2, 'It was closed again forever', 70, 3, '2015-11-16'),
(3, 'closed again', 71, 3, '2015-11-18'),
(4, 'ahhhhhhhhhhhhhhhhhhhhh', 71, 3, '2015-11-18');

-- --------------------------------------------------------

--
-- Table structure for table `entries_activity`
--

CREATE TABLE IF NOT EXISTS `entries_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `entries_activity`
--

INSERT INTO `entries_activity` (`id`, `name`) VALUES
(1, 'Day-Shift Roving'),
(3, 'Guard Mounting');

-- --------------------------------------------------------

--
-- Table structure for table `entries_expro`
--

CREATE TABLE IF NOT EXISTS `entries_expro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `entries_expro`
--

INSERT INTO `entries_expro` (`id`, `name`) VALUES
(1, 'Guard It'),
(2, 'Escort Visitor');

-- --------------------------------------------------------

--
-- Table structure for table `entries_incident`
--

CREATE TABLE IF NOT EXISTS `entries_incident` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `entries_incident`
--

INSERT INTO `entries_incident` (`id`, `name`) VALUES
(1, 'Fire'),
(2, 'Earthquake'),
(3, 'Flood'),
(4, 'Theft');

-- --------------------------------------------------------

--
-- Table structure for table `guard_personnel`
--

CREATE TABLE IF NOT EXISTS `guard_personnel` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fname` varchar(200) NOT NULL,
  `mname` varchar(200) NOT NULL,
  `lname` varchar(200) NOT NULL,
  `contact` varchar(11) NOT NULL,
  `agency` varchar(250) NOT NULL,
  `guard_code` varchar(20) NOT NULL,
  `bu` varchar(150) NOT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'Active',
  `date_created` date NOT NULL,
  `birthdate` date NOT NULL,
  `civil_status` varchar(20) NOT NULL,
  `present_address` varchar(200) NOT NULL,
  `provincial_address` varchar(200) NOT NULL,
  `date_posted` date NOT NULL,
  `agency_employment` date NOT NULL,
  `guard_category` varchar(100) NOT NULL,
  `badge_number` varchar(100) NOT NULL,
  `license_number` varchar(100) NOT NULL,
  `license_issue_date` date NOT NULL,
  `license_expiry_date` date NOT NULL,
  `performance` varchar(200) NOT NULL,
  `comment` text NOT NULL,
  `gender` varchar(10) NOT NULL,
  `blood_type` varchar(5) NOT NULL,
  `guard_photo` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `guard_personnel`
--

INSERT INTO `guard_personnel` (`id`, `fname`, `mname`, `lname`, `contact`, `agency`, `guard_code`, `bu`, `status`, `date_created`, `birthdate`, `civil_status`, `present_address`, `provincial_address`, `date_posted`, `agency_employment`, `guard_category`, `badge_number`, `license_number`, `license_issue_date`, `license_expiry_date`, `performance`, `comment`, `gender`, `blood_type`, `guard_photo`) VALUES
(1, 'Test Guard', 'Middle', 'Guard Test', '09212121212', '1', '001', '1', 'Active', '2015-07-07', '0000-00-00', '', '', '', '0000-00-00', '0000-00-00', '', '', '', '0000-00-00', '0000-00-00', '', '', '', '', NULL),
(2, 'Juanito', 'Tamad', 'de la Cruz', '09876543210', '1', '002', '1', 'Active', '2015-07-14', '1980-07-07', 'Married', 'Right', 'Outside', '2012-01-25', '2005-12-23', 'Sikyo', '777D-12345', '01W-28576', '2014-05-07', '2021-08-24', 'Good', 'The\r\nbest\r\nin\r\nthe\r\nwest', 'Male', 'AB+', NULL),
(3, 'Dingdong', 'Dong', 'Gwantes', '09435679843', '2', '007', '1', 'Active', '2015-07-14', '0000-00-00', '', '', '', '0000-00-00', '0000-00-00', '', '', '', '0000-00-00', '0000-00-00', '', '', '', '', NULL),
(4, 'Sheryl', 'Conan', 'Holmes', '09123456789', '2', '8989G', '1', 'Active', '0000-00-00', '1970-12-05', 'Single', 'Baker Street', 'Over There', '2009-03-12', '1999-01-01', 'Security Officer', '777', 'A098833412', '2015-01-22', '2020-01-22', 'Good', 'ok\r\nok ok\r\npo', 'Female', 'AB+', NULL),
(5, 'Karl', 'Carlos', 'Kaloy', '0988884321', '3', '888', '4', 'Active', '0000-00-00', '1979-04-27', 'Married', 'Outer Wall', 'Catacombs', '2015-08-31', '2014-04-28', 'Roving', '98h7567', 'HFDGF90', '2015-05-05', '2018-09-03', 'Good', 'Fleet-footed', 'Male', 'B-', NULL),
(6, 'FirstName', 'MiddleName', 'LastName', '09887776666', '3', 'GH79', '1', 'Active', '0000-00-00', '1974-11-02', 'Single', 'Some Barangay', 'Some Province', '2014-01-01', '1998-01-01', 'Security Officer', '09-34332-1', '007L', '2012-01-01', '2016-01-01', 'Good', 'Ok sa allright', 'Male', 'O+', NULL),
(7, 'Lex', 'William', 'Luthor', '09267631111', '6', '78F', '8', 'Active', '0000-00-00', '1980-06-19', 'Separated', 'Some Village', 'Over There', '2012-07-31', '2000-01-01', 'Lady Guard', '87-82334-1', 'O45L-BIN', '2014-02-02', '2016-02-02', 'Good', 'Yey', 'Female', 'B+', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `incident_counterfeit`
--

CREATE TABLE IF NOT EXISTS `incident_counterfeit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_name` varchar(50) NOT NULL,
  `account_id` varchar(50) NOT NULL,
  `customer_rep` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `amount` varchar(20) NOT NULL,
  `bill_serial` varchar(50) NOT NULL,
  `relationship` varchar(20) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `incident_counterfeit`
--

INSERT INTO `incident_counterfeit` (`id`, `account_name`, `account_id`, `customer_rep`, `address`, `amount`, `bill_serial`, `relationship`, `ticket_id`) VALUES
(1, 'NotCityBank', '01-0101-01', 'Ball Jack', 'In the office', '5000', 'FY73493', 'Account Owner', 46);

-- --------------------------------------------------------

--
-- Table structure for table `incident_suspect`
--

CREATE TABLE IF NOT EXISTS `incident_suspect` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(50) NOT NULL,
  `MiddleName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Remark` text NOT NULL,
  `logId` bigint(20) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Age` int(11) NOT NULL,
  `Gender` varchar(6) NOT NULL,
  `Height` int(11) NOT NULL,
  `Weight` int(11) NOT NULL,
  `Contact` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `incident_suspect`
--

INSERT INTO `incident_suspect` (`id`, `FirstName`, `MiddleName`, `LastName`, `Remark`, `logId`, `dateCreated`, `Address`, `Age`, `Gender`, `Height`, `Weight`, `Contact`) VALUES
(1, 'Kulas', 'Poro', 'Piro', 'Known drug-addict', 41, '2015-09-30 10:50:04', 'Doon lapit', 35, 'Male', 183, 55, '09123435555');

-- --------------------------------------------------------

--
-- Table structure for table `incident_vehicle`
--

CREATE TABLE IF NOT EXISTS `incident_vehicle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plate_no` varchar(20) NOT NULL,
  `type` varchar(50) NOT NULL,
  `make` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `color` varchar(50) NOT NULL,
  `remarks` text NOT NULL,
  `ticket_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `incident_vehicle`
--

INSERT INTO `incident_vehicle` (`id`, `plate_no`, `type`, `make`, `model`, `color`, `remarks`, `ticket_id`) VALUES
(1, 'ASD-3342', '4-wheeled Vehicle', 'Toyota', 'Vios', 'Blue', 'Noooo', 42);

-- --------------------------------------------------------

--
-- Table structure for table `incident_victim`
--

CREATE TABLE IF NOT EXISTS `incident_victim` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(50) NOT NULL,
  `MiddleName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Remark` text NOT NULL,
  `logId` bigint(20) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Age` int(11) DEFAULT NULL,
  `Gender` varchar(6) NOT NULL,
  `Height` int(11) DEFAULT NULL,
  `Weight` int(11) DEFAULT NULL,
  `Contact` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `incident_victim`
--

INSERT INTO `incident_victim` (`id`, `FirstName`, `MiddleName`, `LastName`, `Remark`, `logId`, `dateCreated`, `Address`, `Age`, `Gender`, `Height`, `Weight`, `Contact`) VALUES
(1, 'Pitong', 'Jose', 'Soriano', 'Friend of the suspect', 41, '2015-09-30 10:50:04', 'Doon layo', 40, 'Male', 173, 60, '0345676655');

-- --------------------------------------------------------

--
-- Table structure for table `incident_witness`
--

CREATE TABLE IF NOT EXISTS `incident_witness` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(50) NOT NULL,
  `MiddleName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Remark` text NOT NULL,
  `logId` bigint(20) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Age` int(11) DEFAULT NULL,
  `Gender` varchar(6) NOT NULL,
  `Height` int(11) DEFAULT NULL,
  `Weight` int(11) DEFAULT NULL,
  `Contact` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `incident_witness`
--

INSERT INTO `incident_witness` (`id`, `FirstName`, `MiddleName`, `LastName`, `Remark`, `logId`, `dateCreated`, `Address`, `Age`, `Gender`, `Height`, `Weight`, `Contact`) VALUES
(1, 'Manang', 'Gitna', 'Testigo', 'Joke lng', 19, '2015-08-05 09:12:48', 'Doon lang', 65, 'Female', 169, 90, ''),
(2, 'FN', '', 'LN', '', 23, '2015-08-05 09:35:26', '', 0, 'Male', 0, 0, ''),
(3, 'Manong', '', 'Guard', '', 24, '2015-08-18 14:35:31', '', 0, 'Male', 0, 0, ''),
(4, 'Hanz', '', 'Solo', '', 38, '0000-00-00 00:00:00', '', 0, '', 0, 0, ''),
(5, 'Lorenza', 'Cruz', 'Santos', 'Bystander', 41, '2015-09-30 10:50:04', 'Doon lang', 25, 'Female', 172, 45, '09223334444'),
(6, 'Charlie', 'Blue', 'Brown', 'Bystander# 2', 41, '2015-09-30 10:50:04', 'Doon lang din', 26, 'Male', 163, 50, '08763451213'),
(7, 'Orong', '', 'Orong', '', 72, '2015-11-18 09:45:21', '', 0, '', 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `location_mst`
--

CREATE TABLE IF NOT EXISTS `location_mst` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location_code` varchar(20) NOT NULL,
  `location` text NOT NULL,
  `bu` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `location_mst`
--

INSERT INTO `location_mst` (`id`, `location_code`, `location`, `bu`) VALUES
(1, 'TST', 'Test Location', 1),
(2, 'RFT A', 'Rooftop A', 1),
(5, 'WH', 'Warehouse', 1),
(6, 'SOC', 'Security Operations Center', 1),
(8, 'PLT B', 'Plant B', 1),
(9, 'PLT C', 'Plant C', 1),
(12, 'PLT D', 'Plant D', 1),
(14, 'WH2', 'Warehouse 2', 1),
(15, 'PLT A', 'Plant A', 1),
(16, 'PLT E', 'Plant E', 1),
(17, 'WH3', 'Warehouse 3', 1),
(18, 'BLDG A', 'Building A', 4),
(19, 'WH4', 'Warehouse 4', 1),
(20, 'H1', 'Hallway 1', 7),
(21, 'WH5', 'Warehouse 5', 1);

-- --------------------------------------------------------

--
-- Table structure for table `logrevision_mst`
--

CREATE TABLE IF NOT EXISTS `logrevision_mst` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) NOT NULL,
  `date_created` date NOT NULL,
  `time_created` time NOT NULL,
  `gid` bigint(20) NOT NULL,
  `remarks` text NOT NULL,
  `ticket` bigint(20) DEFAULT NULL,
  `date_revised` date NOT NULL,
  `time_revised` time NOT NULL,
  `revision_num` int(11) NOT NULL,
  `log_id` int(11) NOT NULL,
  `revised_by` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `logrevision_mst`
--

INSERT INTO `logrevision_mst` (`id`, `uid`, `date_created`, `time_created`, `gid`, `remarks`, `ticket`, `date_revised`, `time_revised`, `revision_num`, `log_id`, `revised_by`) VALUES
(35, 3, '2015-10-01', '11:55:57', 3, 'Translated entry', 46, '2015-10-05', '17:04:45', 1, 86, '1'),
(36, 3, '2015-10-01', '11:55:57', 3, 'Corrected translated entry', 46, '2015-10-05', '17:19:31', 2, 86, '1'),
(37, 3, '2015-10-01', '11:52:44', 2, 'Edited logs', 45, '2015-10-06', '09:27:04', 1, 85, '1'),
(39, 3, '2015-10-01', '11:52:44', 2, 'Edited Edited logs', 45, '2015-10-06', '09:27:32', 2, 85, '1'),
(40, 3, '2015-10-01', '11:50:56', 4, 'Test edit', 44, '2015-10-06', '09:28:53', 1, 84, '1'),
(41, 3, '2015-10-01', '11:50:56', 4, 'Test edit 2', 44, '2015-10-06', '09:30:30', 2, 84, '1'),
(42, 3, '2015-09-30', '15:56:04', 4, 'That is not what happened', 42, '2015-10-06', '09:32:16', 1, 83, '1'),
(43, 3, '2015-09-30', '15:56:04', 4, 'This is what really happened', 42, '2015-10-06', '09:32:42', 2, 83, '1'),
(44, 3, '2015-09-30', '10:02:41', 3, 'Edit', 41, '2015-10-06', '09:56:49', 1, 82, '3'),
(45, 3, '2015-09-30', '10:02:41', 3, 'Edit Edit', 41, '2015-10-06', '09:57:01', 2, 82, '3'),
(46, 3, '2015-09-30', '10:01:03', 2, 'The events', 40, '2015-10-06', '10:12:26', 1, 81, '3'),
(47, 3, '2015-11-03', '17:45:17', 1, 'kkk', 67, '2015-11-13', '08:25:04', 1, 111, '3'),
(48, 3, '2015-11-18', '08:33:34', 4, 'ahh', 71, '2015-11-18', '09:20:33', 1, 115, '3'),
(49, 3, '2015-11-18', '09:43:53', 2, 'test incident part2', 72, '2015-11-18', '09:45:51', 1, 116, '3'),
(50, 3, '2015-11-18', '09:43:53', 2, 'test incident part3', 72, '2015-11-23', '09:40:31', 2, 116, '3');

-- --------------------------------------------------------

--
-- Table structure for table `log_mst`
--

CREATE TABLE IF NOT EXISTS `log_mst` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) NOT NULL,
  `urcid` bigint(20) NOT NULL,
  `date_created` date NOT NULL,
  `time_created` time NOT NULL,
  `gid` bigint(20) NOT NULL,
  `remarks` text NOT NULL,
  `upload1` text,
  `upload2` text,
  `upload3` text,
  `bu` bigint(20) NOT NULL,
  `main_group` int(11) NOT NULL,
  `regional_group` int(11) NOT NULL,
  `location` int(11) NOT NULL,
  `ticket` bigint(20) DEFAULT NULL,
  `oic` tinyint(1) DEFAULT NULL,
  `datesubmitted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=122 ;

--
-- Dumping data for table `log_mst`
--

INSERT INTO `log_mst` (`id`, `uid`, `urcid`, `date_created`, `time_created`, `gid`, `remarks`, `upload1`, `upload2`, `upload3`, `bu`, `main_group`, `regional_group`, `location`, `ticket`, `oic`, `datesubmitted`) VALUES
(1, 2, 1, '2015-07-07', '14:37:00', 1, 'TEST message', '', '', '', 1, 1, 1, 1, 3, 0, '2015-07-07 14:38:30'),
(2, 2, 1, '2015-07-08', '13:16:00', 1, 'test message again', '', '', '', 1, 1, 1, 1, 4, 0, '2015-07-08 13:16:48'),
(3, 2, 2, '2015-07-09', '15:54:00', 1, 'test test test', 'upload/3-Chrysanthemum.jpg', '', '', 1, 1, 1, 1, 5, 0, '2015-07-09 15:55:15'),
(7, 2, 2, '2015-07-16', '10:30:24', 3, 'remarksss', NULL, NULL, NULL, 1, 1, 1, 1, 4, 0, '2015-07-16 10:31:06'),
(8, 2, 1, '2015-07-16', '10:32:22', 3, 'test2', NULL, NULL, NULL, 1, 1, 1, 1, 4, 0, '2015-07-16 10:32:58'),
(9, 2, 1, '2015-07-16', '10:39:57', 2, 'test pa more', NULL, NULL, NULL, 1, 1, 1, 1, 4, 0, '2015-07-16 10:40:12'),
(10, 2, 2, '2015-07-16', '10:42:43', 2, 'test pa rin', NULL, NULL, NULL, 1, 1, 1, 1, 4, 0, '2015-07-16 10:43:06'),
(11, 2, 1, '2015-07-16', '10:47:10', 2, 'test it', NULL, NULL, NULL, 1, 1, 1, 1, 5, 0, '2015-07-16 10:47:26'),
(12, 2, 2, '2015-07-16', '10:48:43', 3, 'weeeeeeeeee', NULL, NULL, NULL, 1, 1, 1, 1, 5, 0, '2015-07-16 10:48:55'),
(13, 2, 2, '2015-07-16', '10:55:56', 1, 'go go go', NULL, NULL, NULL, 1, 1, 1, 1, 4, 0, '2015-07-16 10:56:13'),
(15, 2, 1, '2015-07-16', '10:59:09', 1, 'test', NULL, NULL, NULL, 1, 1, 1, 1, 5, 0, '2015-07-16 10:59:25'),
(16, 2, 2, '2015-07-16', '11:02:40', 2, 'testttt', NULL, NULL, NULL, 1, 1, 1, 1, 5, 0, '2015-07-16 11:02:54'),
(17, 2, 2, '2015-07-16', '11:04:14', 3, 'game n', NULL, NULL, NULL, 1, 1, 1, 1, 4, 0, '2015-07-16 11:04:34'),
(18, 2, 1, '2015-07-16', '11:06:39', 2, 'wew', NULL, NULL, NULL, 1, 1, 1, 1, 4, 0, '2015-07-16 11:07:00'),
(19, 2, 2, '2015-07-16', '11:12:05', 2, 'waw', NULL, NULL, NULL, 1, 1, 1, 1, 4, 0, '2015-07-16 11:12:17'),
(20, 2, 2, '2015-07-16', '11:13:09', 3, 'wrefd', NULL, NULL, NULL, 1, 1, 1, 1, 5, 0, '2015-07-16 11:13:19'),
(21, 2, 2, '2015-07-20', '14:42:09', 2, 'test pa more', '', '', '', 1, 1, 1, 1, 6, 0, '2015-07-20 14:42:41'),
(22, 2, 1, '2015-07-20', '14:45:24', 2, 'isa pang test', '', '', '', 1, 1, 1, 1, 6, 0, '2015-07-20 14:45:40'),
(23, 2, 2, '2015-07-20', '14:54:46', 2, 'aaa', 'upload/23-Penguins.jpg', '', '', 1, 1, 1, 1, 6, 0, '2015-07-20 14:55:12'),
(24, 2, 1, '2015-07-20', '14:57:53', 3, 'yeah ', '', '', '', 1, 1, 1, 1, 6, 0, '2015-07-20 14:58:08'),
(25, 2, 2, '2015-07-20', '15:19:29', 1, 'haha', '', '', '', 1, 1, 1, 1, 6, 0, '2015-07-20 15:19:41'),
(26, 2, 1, '2015-07-20', '15:22:21', 3, 'ay', '', '', '', 1, 1, 1, 1, 6, 0, '2015-07-20 15:22:34'),
(27, 2, 2, '2015-07-20', '15:24:41', 2, 'testttt', '', '', '', 1, 1, 1, 1, 6, 0, '2015-07-20 15:24:53'),
(28, 2, 2, '2015-07-20', '15:27:35', 3, 'tst', '', '', '', 1, 1, 1, 1, 6, 0, '2015-07-20 15:28:01'),
(29, 2, 1, '2015-07-20', '15:30:19', 1, 'testttttt', '', '', '', 1, 1, 1, 1, 6, 0, '2015-07-20 15:30:29'),
(30, 2, 2, '2015-07-21', '15:56:14', 3, 'erererererer', '', '', '', 1, 1, 1, 1, 7, 1, '2015-07-21 15:56:38'),
(31, 2, 1, '2015-07-22', '14:37:25', 2, 'yeah baby', '', '', '', 1, 1, 1, 1, 5, 0, '2015-07-22 14:37:57'),
(32, 2, 2, '2015-07-22', '15:15:43', 2, 'arrgh', '', '', '', 1, 1, 1, 1, 9, 0, '2015-07-22 15:16:09'),
(33, 2, 2, '2015-07-22', '15:16:23', 2, 'bomb!!', '', '', '', 1, 1, 1, 1, 8, 1, '2015-07-22 15:16:46'),
(34, 2, 2, '2015-07-23', '17:22:46', 2, 'tenenentenen', '', '', '', 1, 1, 1, 1, 8, 1, '2015-07-23 17:23:02'),
(35, 2, 2, '2015-07-30', '14:20:15', 3, 'yeaboi', '', '', '', 1, 1, 1, 1, 10, 1, '2015-07-30 14:23:15'),
(36, 2, 1, '2015-07-30', '14:29:07', 3, 'nag sandwich', '', '', '', 1, 1, 1, 1, 11, 1, '2015-07-30 14:30:43'),
(37, 2, 2, '2015-07-30', '14:42:48', 2, 'hahaha', '', '', '', 1, 1, 1, 1, 12, 1, '2015-07-30 14:45:53'),
(38, 2, 2, '2015-07-30', '14:58:22', 2, 'qweqwek', '', '', '', 1, 1, 1, 1, 12, 1, '2015-07-30 14:59:05'),
(39, 2, 2, '2015-07-30', '15:07:52', 2, 'we', '', '', '', 1, 1, 1, 1, 12, 1, '2015-07-30 15:08:50'),
(40, 2, 1, '2015-07-30', '15:11:12', 1, 'wewewe', '', '', '', 1, 1, 1, 1, 12, 1, '2015-07-30 15:11:34'),
(41, 2, 2, '2015-07-30', '15:16:02', 3, 'weeee', '', '', '', 1, 1, 1, 1, 12, 1, '2015-07-30 15:16:30'),
(42, 2, 1, '2015-07-30', '15:19:36', 2, 'asdf', '', '', '', 1, 1, 1, 1, 12, 1, '2015-07-30 15:20:17'),
(43, 2, 2, '2015-07-30', '15:25:52', 2, 'wewe', '', '', '', 1, 1, 1, 1, 13, 1, '2015-07-30 15:26:12'),
(44, 2, 2, '2015-07-30', '15:28:38', 3, 'wewe', '', '', '', 1, 1, 1, 1, 13, 1, '2015-07-30 15:28:58'),
(45, 2, 2, '2015-07-30', '15:30:28', 3, 'ewe', '', '', '', 1, 1, 1, 1, 13, 1, '2015-07-30 15:30:45'),
(46, 2, 2, '2015-07-30', '15:43:29', 2, 'wewewe', '', '', '', 1, 1, 1, 1, 13, 1, '2015-07-30 15:43:52'),
(47, 2, 2, '2015-07-30', '15:45:34', 2, 'weweew', '', '', '', 1, 1, 1, 1, 13, 1, '2015-07-30 15:51:26'),
(48, 2, 2, '2015-07-30', '15:59:57', 2, 'wewe', '', '', '', 1, 1, 1, 1, 13, 1, '2015-07-30 16:02:42'),
(49, 2, 2, '2015-07-30', '16:32:02', 1, 'grrr', '', '', '', 1, 1, 1, 1, 13, 1, '2015-07-30 16:32:40'),
(50, 2, 1, '2015-08-03', '14:17:48', 2, 'weh', '', '', '', 1, 1, 1, 1, 16, 0, '2015-08-03 14:28:09'),
(51, 2, 1, '2015-08-03', '16:08:08', 0, 'ding', '', '', '', 1, 1, 1, 1, 16, 0, '2015-08-03 16:08:19'),
(52, 2, 2, '2015-08-03', '16:42:48', 2, 'forever', '', '', '', 1, 1, 1, 1, 16, 0, '2015-08-03 16:42:58'),
(53, 2, 2, '2015-08-03', '17:33:02', 3, 'gwantes', '', '', '', 1, 1, 1, 1, 16, 0, '2015-08-03 17:33:12'),
(54, 2, 5, '2015-08-04', '10:48:29', 2, 'full screen', '', '', '', 1, 1, 1, 1, 16, 0, '2015-08-04 10:49:11'),
(55, 2, 3, '2015-08-04', '15:17:22', 2, 'oyea gumana ka', '', '', '', 1, 1, 1, 1, 16, 0, '2015-08-04 15:17:45'),
(56, 2, 4, '2015-08-04', '15:33:41', 3, 'Ya-Ha!!', '', '', '', 1, 1, 1, 1, 0, 1, '2015-08-04 15:37:19'),
(57, 2, 3, '2015-08-04', '15:45:51', 2, 'Happy Meal', '', '', '', 1, 1, 1, 1, 0, 1, '2015-08-04 15:46:21'),
(58, 2, 3, '2015-08-04', '16:22:31', 3, 'k', '', '', '', 1, 1, 1, 1, 0, 1, '2015-08-04 16:22:49'),
(59, 2, 6, '2015-08-04', '16:24:29', 3, 'wlang forever', '', '', '', 1, 1, 1, 1, 20, 1, '2015-08-04 16:24:46'),
(60, 2, 4, '2015-08-04', '16:27:11', 2, 'eeeeemergency', '', '', '', 1, 1, 1, 1, 21, 1, '2015-08-04 16:27:32'),
(61, 2, 3, '2015-08-05', '09:31:57', 3, 'wewewewe', '', '', '', 1, 1, 1, 1, 23, 1, '2015-08-05 09:32:54'),
(62, 2, 2, '2015-08-05', '10:46:33', 2, '', '', '', '', 1, 1, 1, 1, 22, 0, '2015-08-05 10:46:49'),
(63, 2, 3, '2015-08-05', '10:47:16', 3, '', '', '', '', 1, 1, 1, 1, 22, 0, '2015-08-05 10:47:28'),
(64, 2, 7, '2015-08-05', '10:53:05', 1, 'relay mo', '', '', '', 1, 1, 1, 1, 22, 0, '2015-08-05 10:53:20'),
(65, 2, 3, '2015-08-06', '09:32:56', 2, 'wewewe', '', '', '', 1, 1, 1, 1, 24, 1, '2015-08-06 09:33:11'),
(66, 3, 7, '2015-08-07', '09:47:06', 2, 'he''s, haha, haha, your''s', '', '', '', 1, 1, 1, 1, 22, 0, '2015-08-07 09:48:08'),
(67, 3, 1, '2015-08-07', '10:16:59', 1, 'dfgh', '', '', '', 1, 1, 1, 1, 22, 0, '2015-08-07 10:17:05'),
(68, 3, 2, '2015-08-10', '14:03:52', 1, 'we', '', '', '', 1, 1, 1, 1, 22, 0, '2015-08-10 14:04:26'),
(69, 3, 3, '2015-08-18', '14:51:06', 4, 'oha', '', '', '', 1, 1, 1, 9, 25, 1, '2015-08-18 14:51:30'),
(70, 3, 20, '2015-09-02', '16:53:11', 3, 'Good bye', '', '', '', 1, 1, 2, 6, 26, 1, '2015-09-02 16:53:37'),
(71, 2, 18, '2015-09-03', '15:31:00', 3, 'dan dan dan', '', '', '', 1, 1, 2, 6, 22, 0, '2015-09-03 15:31:42'),
(72, 3, 20, '2015-09-04', '10:44:28', 2, 'Ok', '', '', '', 1, 1, 2, 19, 28, 1, '2015-09-04 10:44:55'),
(73, 2, 15, '2015-09-08', '15:06:07', 2, 'Good job', '', '', '', 1, 1, 2, 6, 29, 1, '2015-09-08 15:06:31'),
(74, 3, 20, '2015-09-15', '11:14:38', 2, 'Plant D.\r\nYeah', '', '', '', 1, 1, 2, 12, 30, 0, '2015-09-15 11:14:59'),
(75, 3, 6, '2015-09-30', '09:09:52', 3, 'Bomb threat', '', '', '', 1, 1, 2, 8, 34, 1, '2015-09-30 09:10:09'),
(76, 3, 4, '2015-09-30', '09:27:25', 2, 'Fiyah', '', '', '', 1, 1, 2, 12, 35, 1, '2015-09-30 09:27:36'),
(77, 3, 20, '2015-09-30', '09:30:59', 4, 'wegrhtjtg', '', '', '', 1, 1, 2, 5, 36, 1, '2015-09-30 09:31:09'),
(78, 3, 3, '2015-09-30', '09:35:50', 4, 'dsdfgj', '', '', '', 1, 1, 2, 1, 37, 1, '2015-09-30 09:36:04'),
(79, 3, 7, '2015-09-30', '09:37:57', 2, 'erer', '', '', '', 1, 1, 2, 9, 38, 1, '2015-09-30 09:38:04'),
(80, 3, 10, '2015-09-30', '09:43:13', 2, 'ereradfasd', '', '', '', 1, 1, 2, 2, 39, 1, '2015-09-30 09:43:24'),
(81, 3, 15, '2015-09-30', '10:01:03', 2, 'erer', '', '', '', 1, 1, 2, 1, 40, 1, '2015-09-30 10:01:13'),
(82, 3, 5, '2015-09-30', '10:02:41', 3, 'ererer', '', '', '', 1, 1, 2, 9, 41, 1, '2015-09-30 10:03:02'),
(83, 3, 16, '2015-09-30', '15:56:04', 4, 'oh noes', '', '', '', 1, 1, 2, 2, 42, 1, '2015-09-30 15:56:36'),
(84, 3, 20, '2015-10-01', '11:50:56', 4, 'refggrd', '', '', '', 1, 1, 2, 5, 44, 1, '2015-10-01 11:51:08'),
(85, 3, 16, '2015-10-01', '11:52:44', 2, 'erdfd', '', '', '', 1, 1, 2, 9, 45, 1, '2015-10-01 11:52:52'),
(86, 3, 18, '2015-10-01', '11:55:57', 3, 'dsdfghjk', '', '', '', 1, 1, 2, 9, 46, 1, '2015-10-01 11:56:06'),
(87, 3, 6, '2015-10-02', '17:15:33', 3, 'the the', '', '', '', 1, 1, 2, 12, 49, 1, '2015-10-02 17:15:51'),
(88, 3, 13, '2015-10-06', '11:24:41', 2, 'eqrr', '', '', '', 1, 1, 2, 16, 50, 1, '2015-10-06 11:24:50'),
(89, 3, 1, '2015-10-06', '11:38:29', 3, 'zzz', '', '', '', 1, 1, 2, 1, 51, 1, '2015-10-06 11:38:42'),
(90, 2, 7, '2015-10-15', '10:43:44', 3, 'gg', '', '', '', 1, 1, 2, 16, 51, 0, '2015-10-15 10:44:05'),
(91, 1, 7, '2015-10-15', '11:15:55', 1, 'dfghj', '', '', '', 0, 0, 0, 12, 51, 0, '2015-10-15 11:17:31'),
(92, 2, 6, '2015-10-15', '15:14:31', 3, 'qwrr', '', '', '', 1, 1, 2, 14, 51, 1, '2015-10-15 15:14:51'),
(93, 3, 20, '2015-10-15', '15:42:25', 1, 'ok n', '', '', '', 1, 1, 2, 5, 59, 0, '2015-10-15 15:42:35'),
(94, 3, 4, '2015-10-20', '16:49:53', 4, 'noooo', '', '', '', 1, 1, 2, 17, 63, 0, '2015-10-20 16:50:05'),
(95, 3, 2, '2015-10-20', '16:50:16', 3, 'yes', '', '', '', 1, 1, 2, 2, 63, 0, '2015-10-20 16:50:28'),
(96, 3, 16, '2015-10-20', '16:50:52', 3, 'nooosh', '', '', '', 1, 1, 2, 8, 64, 1, '2015-10-20 16:51:05'),
(97, 2, 22, '2015-10-23', '10:25:22', 1, 'One day, isang araw. I saw, nakakita. One Bird, isang Ibon. Flying, lumilipad. I shoot, binaril ko. I hit, tinamaan ko. I cook, niluto ko. I ate, kinain ko.', '', '', '', 1, 1, 2, 6, 65, 1, '2015-10-23 10:27:16'),
(98, 2, 6, '2015-10-23', '10:33:22', 3, 'The quick brown fox jumps over the lazy dog.', '', '', '', 1, 1, 2, 12, 65, 1, '2015-10-23 10:33:48'),
(99, 3, 3, '2015-10-26', '17:28:57', 1, 'wsdsad', '', '', '', 1, 1, 2, 5, 64, 1, '2015-10-26 17:29:09'),
(100, 3, 3, '2015-10-26', '17:28:57', 1, 'wsdsad', '', '', '', 1, 1, 2, 5, 64, 1, '2015-10-26 17:29:31'),
(101, 3, 2, '2015-10-26', '17:33:06', 4, 'ewwe', '', '', '', 1, 1, 2, 12, 65, 1, '2015-10-26 17:33:15'),
(102, 2, 17, '2015-10-29', '09:20:06', 4, 'All clear', '', '', '', 1, 1, 2, 17, 63, 0, '2015-10-29 09:20:22'),
(103, 2, 10, '2015-10-29', '09:25:30', 1, 'All checked', '', '', '', 1, 1, 2, 19, 63, 0, '2015-10-29 09:25:45'),
(104, 2, 25, '2015-10-29', '09:30:20', 3, 'Ok all right', '', '', '', 1, 1, 2, 2, 63, 0, '2015-10-29 09:30:35'),
(105, 2, 5, '2015-10-29', '09:31:29', 2, 'Reporting for duty', '', '', '', 1, 1, 2, 9, 63, 0, '2015-10-29 09:31:43'),
(106, 2, 26, '2015-10-29', '09:35:00', 3, 'Coming soon', '', '', '', 1, 1, 2, 5, 63, 0, '2015-10-29 09:35:13'),
(107, 2, 22, '2015-10-29', '09:37:42', 1, 'noooooo', NULL, NULL, NULL, 1, 1, 2, 6, 63, 0, '2015-10-29 09:37:59'),
(108, 2, 3, '2015-10-29', '09:39:27', 4, 'Weh', NULL, NULL, NULL, 1, 1, 2, 8, 63, 0, '2015-10-29 09:39:47'),
(109, 2, 4, '2015-10-29', '09:45:51', 4, 'ehem', '', '', '', 1, 1, 2, 6, 63, 0, '2015-10-29 09:46:03'),
(110, 2, 20, '2015-10-29', '10:39:51', 2, 'ok', '', '', '', 1, 1, 2, 1, 63, 0, '2015-10-29 10:40:06'),
(111, 3, 1, '2015-11-03', '17:45:17', 1, 'kk', '', '', '', 1, 1, 2, 12, 67, 1, '2015-11-03 17:45:25'),
(112, 3, 1, '2015-11-03', '17:45:17', 1, 'kk', '', '', '', 1, 1, 2, 12, 68, 1, '2015-11-03 17:45:46'),
(113, 3, 1, '2015-11-03', '17:45:17', 1, 'kk', '', '', '', 1, 1, 2, 12, 69, 1, '2015-11-03 17:46:08'),
(114, 3, 15, '2015-11-16', '08:50:29', 4, 'ok guys', '', '', '', 1, 1, 2, 16, 70, 0, '2015-11-16 08:50:51'),
(115, 3, 25, '2015-11-18', '08:33:34', 4, 'ehem', '', '', '', 1, 1, 2, 5, 71, 0, '2015-11-18 08:33:55'),
(116, 3, 3, '2015-11-18', '09:43:53', 2, 'test incident', '', '', '', 1, 1, 2, 2, 72, 0, '2015-11-18 09:44:18'),
(117, 3, 5, '2015-11-27', '09:17:01', 4, 'In Service', '', '', '', 1, 1, 2, 6, 73, 0, '2015-11-27 09:17:27'),
(118, 3, 5, '2015-12-09', '09:04:56', 2, 'ok', '', '', '', 1, 1, 2, 9, 74, 0, '2015-12-09 09:05:20'),
(119, 3, 3, '2015-12-09', '09:35:43', 3, 'Kain din', 'upload/119-Jellyfish.jpg', '', '', 1, 1, 2, 12, 74, 0, '2015-12-09 09:36:10'),
(120, 3, 15, '2015-12-10', '18:09:08', 2, 'gahahaha', 'upload/120-Tulips.jpg', 'upload/120-Koala.jpg', '', 1, 1, 2, 17, 75, 1, '2015-12-10 18:09:35'),
(121, 3, 4, '2015-12-10', '18:10:04', 1, 'guhuhuhu', 'upload/121-Hydrangeas.jpg', '', '', 1, 1, 2, 9, 75, 1, '2015-12-10 18:10:24');

-- --------------------------------------------------------

--
-- Table structure for table `main_groups`
--

CREATE TABLE IF NOT EXISTS `main_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `main_groups`
--

INSERT INTO `main_groups` (`id`, `name`) VALUES
(1, 'test main group'),
(2, '2nd main'),
(3, 'Light Bulbs'),
(5, 'Superpower Group'),
(6, 'more group');

-- --------------------------------------------------------

--
-- Table structure for table `oic_mst`
--

CREATE TABLE IF NOT EXISTS `oic_mst` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email_ad` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `bu` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `oic_mst`
--

INSERT INTO `oic_mst` (`id`, `fname`, `mname`, `lname`, `email_ad`, `mobile`, `bu`) VALUES
(1, 'Jan Virgil', 'Galido', 'Fruto', 'jvfruto@gmail.com', '09228286817', 1),
(2, 'Jan Virgil', 'Galido', 'Fruto', 'butohnc@yahoo.com', '09228286817', 1);

-- --------------------------------------------------------

--
-- Table structure for table `regional_group`
--

CREATE TABLE IF NOT EXISTS `regional_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `regional_group`
--

INSERT INTO `regional_group` (`id`, `name`) VALUES
(1, 'test region'),
(2, 'nether region'),
(3, 'Calabarzon'),
(4, 'Everywhere Region'),
(5, 'more region');

-- --------------------------------------------------------

--
-- Table structure for table `system_log`
--

CREATE TABLE IF NOT EXISTS `system_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `log` text NOT NULL,
  `datetime` datetime NOT NULL,
  `bu_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1011 ;

--
-- Dumping data for table `system_log`
--

INSERT INTO `system_log` (`id`, `uid`, `log`, `datetime`, `bu_id`) VALUES
(1, 1, 'Logged in', '2015-07-03 13:45:27', 0),
(2, 1, 'Logged in', '2015-07-06 09:16:39', 0),
(3, 1, 'Logged in', '2015-07-07 08:52:40', 0),
(4, 1, 'Created 1 BU / Team.', '2015-07-07 09:04:42', 0),
(5, 1, 'Created 1 new USER entry.', '2015-07-07 09:07:27', 0),
(6, 1, 'Logged out', '2015-07-07 09:07:37', 0),
(7, 2, 'Logged in', '2015-07-07 09:07:49', 1),
(8, 2, 'Logged out', '2015-07-07 09:16:54', 1),
(9, 2, 'Logged in', '2015-07-07 09:17:05', 1),
(10, 2, 'Logged out', '2015-07-07 09:19:15', 1),
(11, 2, 'Logged in', '2015-07-07 09:24:18', 1),
(12, 2, 'Logged out', '2015-07-07 09:31:54', 1),
(13, 2, 'Logged in', '2015-07-07 09:32:02', 1),
(14, 2, 'Logged out', '2015-07-07 09:32:24', 1),
(15, 2, 'Logged in', '2015-07-07 09:33:45', 1),
(16, 2, 'Logged out', '2015-07-07 09:57:32', 1),
(17, 2, 'Logged in', '2015-07-07 09:58:10', 1),
(18, 2, 'Logged out', '2015-07-07 10:10:43', 1),
(19, 2, 'Logged in', '2015-07-07 10:12:28', 1),
(20, 2, 'Logged out', '2015-07-07 10:13:29', 1),
(21, 2, 'Logged in', '2015-07-07 10:22:02', 1),
(22, 2, 'Logged out', '2015-07-07 10:22:19', 1),
(23, 2, 'Logged in', '2015-07-07 10:23:34', 1),
(24, 2, 'Logged out', '2015-07-07 10:36:35', 1),
(25, 2, 'Logged in', '2015-07-07 10:36:50', 1),
(26, 2, 'Logged out', '2015-07-07 10:37:12', 1),
(27, 2, 'Logged in', '2015-07-07 10:38:31', 1),
(28, 2, 'Logged out', '2015-07-07 11:23:08', 1),
(29, 2, 'Logged in', '2015-07-07 11:23:25', 1),
(30, 2, 'Logged out', '2015-07-07 11:28:00', 1),
(31, 2, 'Logged in', '2015-07-07 11:28:09', 1),
(32, 2, 'Logged out', '2015-07-07 11:32:28', 1),
(33, 2, 'Logged in', '2015-07-07 11:32:40', 1),
(34, 2, 'Logged out', '2015-07-07 11:33:13', 1),
(35, 2, 'Logged in', '2015-07-07 11:34:27', 1),
(36, 2, 'Logged out', '2015-07-07 11:34:30', 1),
(37, 2, 'Logged in', '2015-07-07 11:35:06', 1),
(38, 2, 'Logged out', '2015-07-07 11:35:19', 1),
(39, 2, 'Logged in', '2015-07-07 11:36:10', 1),
(40, 2, 'Logged out', '2015-07-07 11:36:46', 1),
(41, 2, 'Logged in', '2015-07-07 11:36:53', 1),
(42, 2, 'Logged out', '2015-07-07 11:38:10', 1),
(43, 2, 'Logged in', '2015-07-07 11:39:41', 1),
(44, 2, 'Logged out', '2015-07-07 11:40:21', 1),
(45, 2, 'Logged in', '2015-07-07 11:40:47', 1),
(46, 2, 'Logged out', '2015-07-07 11:40:53', 1),
(47, 2, 'Logged in', '2015-07-07 11:43:35', 1),
(48, 2, 'Logged out', '2015-07-07 11:46:19', 1),
(49, 2, 'Logged in', '2015-07-07 11:46:26', 1),
(50, 2, 'Logged out', '2015-07-07 11:48:32', 1),
(51, 2, 'Logged in', '2015-07-07 11:48:37', 1),
(52, 2, 'Logged in', '2015-07-07 12:40:12', 1),
(53, 2, 'Logged out', '2015-07-07 12:45:17', 1),
(54, 2, 'Logged in', '2015-07-07 12:45:37', 1),
(55, 2, 'Logged out', '2015-07-07 13:07:00', 1),
(56, 2, 'Logged in', '2015-07-07 13:07:06', 1),
(57, 2, 'Logged out', '2015-07-07 13:08:46', 1),
(58, 2, 'Logged in', '2015-07-07 13:08:52', 1),
(59, 2, 'Logged out', '2015-07-07 13:23:15', 1),
(60, 2, 'Logged in', '2015-07-07 13:23:20', 1),
(61, 2, 'Logged out', '2015-07-07 14:03:59', 1),
(62, 2, 'Logged in', '2015-07-07 14:08:15', 1),
(63, 2, 'Logged out', '2015-07-07 14:27:20', 1),
(64, 1, 'Logged in', '2015-07-07 14:27:28', 0),
(65, 1, 'Created 1 new 10-00 Series Codes.', '2015-07-07 14:28:15', 0),
(66, 1, 'Created 1 new Location entry.', '2015-07-07 14:35:19', 0),
(67, 1, 'Created 1 new GUARD PERSONNEL entry.', '2015-07-07 14:36:31', 0),
(68, 1, 'Logged out', '2015-07-07 14:36:50', 0),
(69, 2, 'Logged in', '2015-07-07 14:36:55', 1),
(70, 2, 'Added entry to logbook', '2015-07-07 14:38:30', 1),
(71, 2, 'Logged out', '2015-07-07 14:41:57', 1),
(72, 2, 'Logged in', '2015-07-07 14:44:40', 1),
(73, 2, 'Logged out', '2015-07-07 15:27:32', 1),
(74, 2, 'Logged in', '2015-07-07 15:27:38', 1),
(75, 2, 'Logged out', '2015-07-07 17:14:50', 1),
(76, 2, 'Logged in', '2015-07-07 17:16:15', 1),
(77, 2, 'Logged in', '2015-07-08 07:37:25', 1),
(78, 2, 'Logged out', '2015-07-08 10:45:20', 1),
(79, 2, 'Logged in', '2015-07-08 10:45:25', 1),
(80, 2, 'Logged out', '2015-07-08 10:47:04', 1),
(81, 2, 'Logged in', '2015-07-08 10:47:24', 1),
(82, 2, 'Logged out', '2015-07-08 11:07:42', 1),
(83, 1, 'Logged in', '2015-07-08 11:07:48', 0),
(84, 1, 'Logged out', '2015-07-08 11:08:00', 0),
(85, 2, 'Logged in', '2015-07-08 11:08:47', 1),
(86, 2, 'Logged out', '2015-07-08 11:33:33', 1),
(87, 1, 'Logged in', '2015-07-08 11:33:39', 0),
(88, 1, 'Logged out', '2015-07-08 13:14:45', 0),
(89, 2, 'Logged in', '2015-07-08 13:16:03', 1),
(90, 2, 'Added entry to logbook', '2015-07-08 13:16:48', 1),
(91, 2, 'Logged out', '2015-07-08 13:17:37', 1),
(92, 2, 'Logged in', '2015-07-08 13:17:43', 1),
(93, 2, 'Logged out', '2015-07-08 14:49:37', 1),
(94, 1, 'Logged in', '2015-07-08 14:49:52', 0),
(95, 1, 'Created 1 new 10-00 Series Codes.', '2015-07-08 14:51:05', 0),
(96, 1, 'Logged out', '2015-07-08 14:51:14', 0),
(97, 2, 'Logged in', '2015-07-08 14:51:18', 1),
(98, 2, 'Logged out', '2015-07-08 14:51:27', 1),
(99, 2, 'Logged in', '2015-07-08 14:52:05', 1),
(100, 2, 'Logged out', '2015-07-08 15:07:20', 1),
(101, 2, 'Logged in', '2015-07-08 15:07:26', 1),
(102, 2, 'Logged in', '2015-07-09 11:33:07', 1),
(103, 2, 'Logged out', '2015-07-09 11:35:41', 1),
(104, 2, 'Logged in', '2015-07-09 11:35:45', 1),
(105, 2, 'Logged out', '2015-07-09 15:53:25', 1),
(106, 2, 'Logged in', '2015-07-09 15:54:13', 1),
(107, 2, 'Added entry to logbook', '2015-07-09 15:55:15', 1),
(108, 2, 'Logged out', '2015-07-09 15:56:13', 1),
(109, 2, 'Logged in', '2015-07-09 15:56:44', 1),
(110, 2, 'Logged in', '2015-07-10 07:54:13', 1),
(111, 1, 'Logged in', '2015-07-13 08:27:11', 0),
(112, 1, 'Logged out', '2015-07-13 08:27:54', 0),
(113, 2, 'Logged in', '2015-07-13 08:42:28', 1),
(114, 2, 'Logged out', '2015-07-13 11:11:47', 1),
(115, 2, 'Logged in', '2015-07-13 11:21:50', 1),
(116, 2, 'Logged out', '2015-07-13 15:30:25', 1),
(117, 2, 'Logged in', '2015-07-13 15:30:29', 1),
(118, 2, 'Logged out', '2015-07-13 15:30:52', 1),
(119, 2, 'Logged in', '2015-07-13 15:30:58', 1),
(120, 2, 'Logged out', '2015-07-13 17:23:19', 1),
(121, 2, 'Logged in', '2015-07-13 17:24:02', 1),
(122, 2, 'Logged out', '2015-07-13 17:24:27', 1),
(123, 2, 'Logged in', '2015-07-13 17:24:34', 1),
(124, 2, 'Logged in', '2015-07-14 08:02:03', 1),
(125, 2, 'Logged out', '2015-07-14 08:04:15', 1),
(126, 2, 'Logged in', '2015-07-14 08:04:21', 1),
(127, 2, 'Logged out', '2015-07-14 10:44:21', 1),
(128, 1, 'Logged in', '2015-07-14 10:44:28', 0),
(129, 1, 'Created 1 new GUARD PERSONNEL entry.', '2015-07-14 10:45:28', 0),
(130, 1, 'Logged out', '2015-07-14 10:45:33', 0),
(131, 2, 'Logged in', '2015-07-14 10:45:39', 1),
(132, 2, 'Logged out', '2015-07-14 14:54:05', 1),
(133, 1, 'Logged in', '2015-07-14 14:54:10', 0),
(134, 1, 'Created 1 new GUARD PERSONNEL entry.', '2015-07-14 14:54:59', 0),
(135, 1, 'Logged out', '2015-07-14 14:55:06', 0),
(136, 2, 'Logged in', '2015-07-14 14:55:21', 1),
(137, 2, 'Logged out', '2015-07-14 15:24:26', 1),
(138, 2, 'Logged in', '2015-07-14 15:24:41', 1),
(139, 2, 'Logged out', '2015-07-14 15:34:09', 1),
(140, 2, 'Logged in', '2015-07-14 15:34:13', 1),
(141, 2, 'Logged out', '2015-07-14 15:36:14', 1),
(142, 2, 'Logged in', '2015-07-14 15:36:19', 1),
(143, 2, 'Logged out', '2015-07-14 15:37:10', 1),
(144, 2, 'Logged in', '2015-07-14 15:37:16', 1),
(145, 2, 'Logged out', '2015-07-14 15:58:39', 1),
(146, 2, 'Logged in', '2015-07-14 15:58:44', 1),
(147, 2, 'Logged out', '2015-07-14 16:04:18', 1),
(148, 2, 'Logged in', '2015-07-14 16:04:26', 1),
(149, 2, 'Logged out', '2015-07-14 16:30:30', 1),
(150, 2, 'Logged in', '2015-07-14 16:30:36', 1),
(151, 2, 'Logged out', '2015-07-14 16:35:03', 1),
(152, 2, 'Logged in', '2015-07-14 16:35:15', 1),
(153, 2, 'Logged out', '2015-07-14 16:36:06', 1),
(154, 2, 'Logged in', '2015-07-14 16:36:17', 1),
(155, 2, 'Logged out', '2015-07-14 16:39:36', 1),
(156, 2, 'Logged in', '2015-07-14 16:39:46', 1),
(157, 2, 'Logged out', '2015-07-14 16:43:15', 1),
(158, 2, 'Logged in', '2015-07-14 16:43:21', 1),
(159, 2, 'Logged out', '2015-07-14 16:43:55', 1),
(160, 2, 'Logged in', '2015-07-14 16:43:59', 1),
(161, 2, 'Logged out', '2015-07-14 16:54:36', 1),
(162, 2, 'Logged in', '2015-07-14 16:54:47', 1),
(163, 2, 'Logged out', '2015-07-14 16:55:51', 1),
(164, 2, 'Logged in', '2015-07-14 16:56:00', 1),
(165, 2, 'Logged out', '2015-07-14 16:56:23', 1),
(166, 2, 'Logged in', '2015-07-14 16:56:28', 1),
(167, 2, 'Logged out', '2015-07-14 16:59:35', 1),
(168, 2, 'Logged in', '2015-07-14 16:59:41', 1),
(169, 2, 'Logged in', '2015-07-14 17:06:19', 1),
(170, 2, 'Logged out', '2015-07-14 17:19:50', 1),
(171, 2, 'Logged in', '2015-07-14 17:19:55', 1),
(172, 2, 'Logged in', '2015-07-15 13:08:47', 1),
(173, 2, 'Logged out', '2015-07-15 13:14:17', 1),
(174, 2, 'Logged in', '2015-07-15 13:14:21', 1),
(175, 2, 'Logged out', '2015-07-15 13:31:03', 1),
(176, 2, 'Logged in', '2015-07-15 13:31:10', 1),
(177, 2, 'Logged out', '2015-07-15 13:37:17', 1),
(178, 2, 'Logged in', '2015-07-15 13:37:28', 1),
(179, 2, 'Logged out', '2015-07-15 13:37:53', 1),
(180, 2, 'Logged in', '2015-07-15 13:37:59', 1),
(181, 2, 'Logged out', '2015-07-15 13:41:21', 1),
(182, 2, 'Logged in', '2015-07-15 13:41:35', 1),
(183, 2, 'Logged out', '2015-07-15 14:42:30', 1),
(184, 2, 'Logged in', '2015-07-15 14:42:35', 1),
(185, 2, 'Logged out', '2015-07-15 14:43:56', 1),
(186, 2, 'Logged in', '2015-07-15 14:44:01', 1),
(187, 2, 'Logged out', '2015-07-15 14:44:45', 1),
(188, 2, 'Logged in', '2015-07-15 14:44:49', 1),
(189, 2, 'Logged out', '2015-07-15 14:50:27', 1),
(190, 2, 'Logged in', '2015-07-15 14:50:35', 1),
(191, 2, 'Logged out', '2015-07-15 14:55:45', 1),
(192, 2, 'Logged in', '2015-07-15 14:55:51', 1),
(193, 2, 'Logged out', '2015-07-15 15:02:27', 1),
(194, 2, 'Logged in', '2015-07-15 15:02:42', 1),
(195, 2, 'Logged out', '2015-07-15 15:52:48', 1),
(196, 2, 'Logged in', '2015-07-15 15:52:51', 1),
(197, 2, 'Logged out', '2015-07-15 15:58:01', 1),
(198, 2, 'Logged in', '2015-07-15 15:58:05', 1),
(199, 2, 'Logged out', '2015-07-15 15:58:58', 1),
(200, 2, 'Logged in', '2015-07-15 15:59:03', 1),
(201, 2, 'Logged out', '2015-07-15 16:00:32', 1),
(202, 2, 'Logged in', '2015-07-15 16:00:36', 1),
(203, 2, 'Logged out', '2015-07-15 16:01:47', 1),
(204, 2, 'Logged in', '2015-07-15 16:01:55', 1),
(205, 2, 'Logged out', '2015-07-15 16:02:52', 1),
(206, 2, 'Logged in', '2015-07-15 16:02:57', 1),
(207, 2, 'Logged out', '2015-07-15 16:03:55', 1),
(208, 2, 'Logged in', '2015-07-15 16:04:01', 1),
(209, 2, 'Logged out', '2015-07-15 16:04:45', 1),
(210, 2, 'Logged in', '2015-07-15 16:04:50', 1),
(211, 2, 'Logged out', '2015-07-15 16:06:39', 1),
(212, 2, 'Logged in', '2015-07-15 16:06:44', 1),
(213, 2, 'Logged out', '2015-07-15 16:07:45', 1),
(214, 2, 'Logged in', '2015-07-15 16:07:49', 1),
(215, 2, 'Logged out', '2015-07-15 16:15:04', 1),
(216, 2, 'Logged in', '2015-07-15 16:15:09', 1),
(217, 2, 'Logged out', '2015-07-15 16:21:40', 1),
(218, 2, 'Logged in', '2015-07-15 16:21:45', 1),
(219, 2, 'Logged out', '2015-07-15 16:22:31', 1),
(220, 2, 'Logged in', '2015-07-15 16:22:38', 1),
(221, 2, 'Logged out', '2015-07-15 16:37:04', 1),
(222, 2, 'Logged in', '2015-07-15 16:37:10', 1),
(223, 2, 'Logged in', '2015-07-15 16:56:02', 1),
(224, 2, 'Logged in', '2015-07-16 07:56:56', 1),
(225, 2, 'Logged out', '2015-07-16 08:52:58', 1),
(226, 2, 'Logged in', '2015-07-16 08:53:02', 1),
(227, 2, 'Logged out', '2015-07-16 08:53:47', 1),
(228, 2, 'Logged in', '2015-07-16 08:53:52', 1),
(229, 2, 'Logged out', '2015-07-16 08:54:19', 1),
(230, 2, 'Logged in', '2015-07-16 08:54:28', 1),
(231, 2, 'Logged out', '2015-07-16 09:08:58', 1),
(232, 2, 'Logged in', '2015-07-16 09:09:05', 1),
(233, 2, 'Logged out', '2015-07-16 09:10:08', 1),
(234, 2, 'Logged in', '2015-07-16 09:10:17', 1),
(235, 2, 'Logged out', '2015-07-16 09:14:02', 1),
(236, 2, 'Logged in', '2015-07-16 09:14:12', 1),
(237, 2, 'Logged out', '2015-07-16 09:54:23', 1),
(238, 2, 'Logged in', '2015-07-16 09:54:35', 1),
(239, 2, 'Logged out', '2015-07-16 09:56:29', 1),
(240, 2, 'Logged in', '2015-07-16 09:56:42', 1),
(241, 2, 'Logged out', '2015-07-16 10:17:14', 1),
(242, 2, 'Logged in', '2015-07-16 10:17:20', 1),
(243, 2, 'Logged out', '2015-07-16 10:21:54', 1),
(244, 2, 'Logged in', '2015-07-16 10:21:59', 1),
(245, 2, 'Logged out', '2015-07-16 10:23:07', 1),
(246, 2, 'Logged in', '2015-07-16 10:23:12', 1),
(247, 2, 'Logged out', '2015-07-16 10:26:17', 1),
(248, 2, 'Logged in', '2015-07-16 10:26:22', 1),
(249, 2, 'Logged out', '2015-07-16 10:29:57', 1),
(250, 2, 'Logged in', '2015-07-16 10:30:22', 1),
(251, 2, 'Logged out', '2015-07-16 10:31:37', 1),
(252, 2, 'Logged in', '2015-07-16 10:31:43', 1),
(253, 2, 'Logged out', '2015-07-16 10:33:14', 1),
(254, 2, 'Logged in', '2015-07-16 10:34:13', 1),
(255, 2, 'Logged out', '2015-07-16 10:37:51', 1),
(256, 2, 'Logged in', '2015-07-16 10:37:57', 1),
(257, 2, 'Logged out', '2015-07-16 10:39:40', 1),
(258, 2, 'Logged in', '2015-07-16 10:39:47', 1),
(259, 2, 'Logged out', '2015-07-16 10:42:14', 1),
(260, 2, 'Logged in', '2015-07-16 10:42:20', 1),
(261, 2, 'Logged out', '2015-07-16 10:46:43', 1),
(262, 2, 'Logged in', '2015-07-16 10:46:48', 1),
(263, 2, 'Logged out', '2015-07-16 10:48:17', 1),
(264, 2, 'Logged in', '2015-07-16 10:48:22', 1),
(265, 2, 'Logged out', '2015-07-16 10:49:22', 1),
(266, 2, 'Logged in', '2015-07-16 10:49:28', 1),
(267, 2, 'Logged out', '2015-07-16 10:49:56', 1),
(268, 2, 'Logged in', '2015-07-16 10:50:01', 1),
(269, 2, 'Logged out', '2015-07-16 10:53:45', 1),
(270, 2, 'Logged in', '2015-07-16 10:53:52', 1),
(271, 2, 'Logged out', '2015-07-16 10:53:59', 1),
(272, 2, 'Logged in', '2015-07-16 10:55:54', 1),
(273, 2, 'Logged out', '2015-07-16 10:56:52', 1),
(274, 2, 'Logged in', '2015-07-16 10:56:57', 1),
(275, 2, 'Logged out', '2015-07-16 10:58:52', 1),
(276, 2, 'Logged in', '2015-07-16 10:58:58', 1),
(277, 2, 'Logged out', '2015-07-16 10:59:47', 1),
(278, 2, 'Logged in', '2015-07-16 11:00:29', 1),
(279, 2, 'Logged out', '2015-07-16 11:02:26', 1),
(280, 2, 'Logged in', '2015-07-16 11:02:33', 1),
(281, 2, 'Logged out', '2015-07-16 11:03:22', 1),
(282, 2, 'Logged in', '2015-07-16 11:04:12', 1),
(283, 2, 'Logged out', '2015-07-16 11:05:38', 1),
(284, 2, 'Logged in', '2015-07-16 11:06:19', 1),
(285, 2, 'Logged out', '2015-07-16 11:07:13', 1),
(286, 2, 'Logged in', '2015-07-16 11:07:18', 1),
(287, 2, 'Logged out', '2015-07-16 11:10:24', 1),
(288, 2, 'Logged in', '2015-07-16 11:10:31', 1),
(289, 2, 'Logged out', '2015-07-16 11:10:41', 1),
(290, 2, 'Logged in', '2015-07-16 11:10:47', 1),
(291, 2, 'Logged out', '2015-07-16 11:11:56', 1),
(292, 2, 'Logged in', '2015-07-16 11:12:03', 1),
(293, 2, 'Logged out', '2015-07-16 11:12:38', 1),
(294, 2, 'Logged in', '2015-07-16 11:13:07', 1),
(295, 2, 'Logged out', '2015-07-16 11:25:33', 1),
(296, 2, 'Logged in', '2015-07-16 11:26:52', 1),
(297, 2, 'Logged out', '2015-07-16 11:35:26', 1),
(298, 2, 'Logged in', '2015-07-16 11:35:30', 1),
(299, 2, 'Logged out', '2015-07-16 11:36:45', 1),
(300, 2, 'Logged in', '2015-07-16 11:36:50', 1),
(301, 2, 'Logged out', '2015-07-16 11:37:11', 1),
(302, 2, 'Logged in', '2015-07-16 11:37:19', 1),
(303, 2, 'Logged out', '2015-07-16 11:37:59', 1),
(304, 2, 'Logged in', '2015-07-16 11:38:04', 1),
(305, 2, 'Logged out', '2015-07-16 11:48:23', 1),
(306, 2, 'Logged in', '2015-07-16 11:48:28', 1),
(307, 2, 'Logged out', '2015-07-16 11:49:08', 1),
(308, 2, 'Logged in', '2015-07-16 11:49:12', 1),
(309, 2, 'Logged out', '2015-07-16 11:57:00', 1),
(310, 2, 'Logged in', '2015-07-16 11:57:06', 1),
(311, 2, 'Logged out', '2015-07-16 11:57:45', 1),
(312, 2, 'Logged in', '2015-07-16 12:01:04', 1),
(313, 2, 'Logged out', '2015-07-16 12:07:07', 1),
(314, 1, 'Logged in', '2015-07-16 12:07:16', 0),
(315, 1, 'Logged out', '2015-07-16 12:09:01', 0),
(316, 2, 'Logged in', '2015-07-16 12:17:04', 1),
(317, 2, 'Logged out', '2015-07-16 12:26:47', 1),
(318, 2, 'Logged in', '2015-07-16 12:49:46', 1),
(319, 2, 'Logged out', '2015-07-16 14:12:08', 1),
(320, 2, 'Logged in', '2015-07-16 14:12:14', 1),
(321, 2, 'Logged out', '2015-07-16 14:13:14', 1),
(322, 2, 'Logged in', '2015-07-16 14:13:19', 1),
(323, 2, 'Logged out', '2015-07-16 14:23:51', 1),
(324, 2, 'Logged in', '2015-07-16 14:23:59', 1),
(325, 2, 'Logged out', '2015-07-16 14:24:26', 1),
(326, 2, 'Logged in', '2015-07-16 14:24:35', 1),
(327, 2, 'Logged out', '2015-07-16 14:26:14', 1),
(328, 2, 'Logged in', '2015-07-16 14:26:28', 1),
(329, 2, 'Logged out', '2015-07-16 14:27:07', 1),
(330, 2, 'Logged in', '2015-07-16 14:27:12', 1),
(331, 2, 'Logged out', '2015-07-16 14:28:15', 1),
(332, 2, 'Logged in', '2015-07-16 14:28:19', 1),
(333, 2, 'Logged out', '2015-07-16 15:25:42', 1),
(334, 2, 'Logged in', '2015-07-16 15:25:54', 1),
(335, 2, 'Logged out', '2015-07-16 15:31:56', 1),
(336, 2, 'Logged in', '2015-07-16 15:32:05', 1),
(337, 2, 'Logged out', '2015-07-16 16:35:10', 1),
(338, 2, 'Logged in', '2015-07-16 16:35:16', 1),
(339, 2, 'Logged out', '2015-07-16 16:36:55', 1),
(340, 2, 'Logged in', '2015-07-16 16:37:01', 1),
(341, 2, 'Logged out', '2015-07-16 16:44:59', 1),
(342, 2, 'Logged in', '2015-07-16 16:45:10', 1),
(343, 2, 'Logged out', '2015-07-16 16:47:47', 1),
(344, 2, 'Logged in', '2015-07-16 16:47:55', 1),
(345, 2, 'Logged out', '2015-07-16 16:53:21', 1),
(346, 2, 'Logged in', '2015-07-16 16:53:33', 1),
(347, 2, 'Logged out', '2015-07-16 17:25:16', 1),
(348, 2, 'Logged in', '2015-07-16 17:25:36', 1),
(349, 2, 'Logged out', '2015-07-16 17:26:26', 1),
(350, 2, 'Logged in', '2015-07-16 17:26:31', 1),
(351, 2, 'Logged out', '2015-07-16 17:27:41', 1),
(352, 2, 'Logged in', '2015-07-16 17:27:45', 1),
(353, 2, 'Logged out', '2015-07-16 17:29:27', 1),
(354, 2, 'Logged in', '2015-07-20 07:40:53', 1),
(355, 2, 'Logged out', '2015-07-20 11:15:10', 1),
(356, 2, 'Logged in', '2015-07-20 11:15:19', 1),
(357, 2, 'Logged out', '2015-07-20 11:18:51', 1),
(358, 2, 'Logged in', '2015-07-20 11:18:57', 1),
(359, 2, 'Logged out', '2015-07-20 13:54:50', 1),
(360, 2, 'Logged in', '2015-07-20 13:54:55', 1),
(361, 2, 'Logged out', '2015-07-20 14:07:07', 1),
(362, 2, 'Logged in', '2015-07-20 14:07:13', 1),
(363, 2, 'Logged out', '2015-07-20 14:14:09', 1),
(364, 2, 'Logged in', '2015-07-20 14:14:14', 1),
(365, 2, 'Logged out', '2015-07-20 14:17:35', 1),
(366, 2, 'Logged in', '2015-07-20 14:17:53', 1),
(367, 2, 'Logged out', '2015-07-20 14:41:35', 1),
(368, 2, 'Logged in', '2015-07-20 14:41:48', 1),
(369, 2, 'Added entry to logbook', '2015-07-20 14:42:41', 1),
(370, 2, 'Logged out', '2015-07-20 14:45:09', 1),
(371, 2, 'Logged in', '2015-07-20 14:45:16', 1),
(372, 2, 'Added entry to logbook', '2015-07-20 14:45:40', 1),
(373, 2, 'Logged out', '2015-07-20 14:54:35', 1),
(374, 2, 'Logged in', '2015-07-20 14:54:40', 1),
(375, 2, 'Added entry to logbook', '2015-07-20 14:55:12', 1),
(376, 2, 'Logged out', '2015-07-20 14:57:41', 1),
(377, 2, 'Logged in', '2015-07-20 14:57:47', 1),
(378, 2, 'Added entry to logbook', '2015-07-20 14:58:08', 1),
(379, 2, 'Logged out', '2015-07-20 15:01:03', 1),
(380, 2, 'Logged in', '2015-07-20 15:05:47', 1),
(381, 2, 'Logged out', '2015-07-20 15:19:16', 1),
(382, 2, 'Logged in', '2015-07-20 15:19:22', 1),
(383, 2, 'Added entry to logbook', '2015-07-20 15:19:41', 1),
(384, 2, 'Logged out', '2015-07-20 15:22:01', 1),
(385, 2, 'Logged in', '2015-07-20 15:22:09', 1),
(386, 2, 'Added entry to logbook', '2015-07-20 15:22:34', 1),
(387, 2, 'Logged out', '2015-07-20 15:24:25', 1),
(388, 2, 'Logged in', '2015-07-20 15:24:30', 1),
(389, 2, 'Added entry to logbook', '2015-07-20 15:24:53', 1),
(390, 2, 'Logged out', '2015-07-20 15:27:22', 1),
(391, 2, 'Logged in', '2015-07-20 15:27:28', 1),
(392, 2, 'Added entry to logbook', '2015-07-20 15:28:01', 1),
(393, 2, 'Logged out', '2015-07-20 15:28:18', 1),
(394, 2, 'Logged in', '2015-07-20 15:28:25', 1),
(395, 2, 'Logged out', '2015-07-20 15:28:48', 1),
(396, 2, 'Logged in', '2015-07-20 15:28:53', 1),
(397, 2, 'Logged out', '2015-07-20 15:29:20', 1),
(398, 2, 'Logged in', '2015-07-20 15:29:29', 1),
(399, 2, 'Logged out', '2015-07-20 15:30:05', 1),
(400, 2, 'Logged in', '2015-07-20 15:30:10', 1),
(401, 2, 'Added entry to logbook', '2015-07-20 15:30:29', 1),
(402, 2, 'Logged out', '2015-07-20 15:36:56', 1),
(403, 2, 'Logged in', '2015-07-20 15:37:03', 1),
(404, 2, 'Logged out', '2015-07-20 15:37:34', 1),
(405, 2, 'Logged in', '2015-07-20 15:37:44', 1),
(406, 2, 'Logged out', '2015-07-20 15:39:33', 1),
(407, 2, 'Logged in', '2015-07-20 15:39:40', 1),
(408, 2, 'Logged out', '2015-07-20 15:41:12', 1),
(409, 2, 'Logged in', '2015-07-20 15:41:17', 1),
(410, 2, 'Logged out', '2015-07-20 15:41:30', 1),
(411, 2, 'Logged in', '2015-07-20 15:41:41', 1),
(412, 2, 'Logged out', '2015-07-20 15:41:54', 1),
(413, 2, 'Logged in', '2015-07-20 15:42:15', 1),
(414, 2, 'Logged out', '2015-07-20 15:45:17', 1),
(415, 2, 'Logged in', '2015-07-20 15:45:22', 1),
(416, 2, 'Logged out', '2015-07-20 16:54:59', 1),
(417, 2, 'Logged in', '2015-07-20 16:55:07', 1),
(418, 2, 'Logged out', '2015-07-20 16:56:32', 1),
(419, 2, 'Logged in', '2015-07-20 16:56:38', 1),
(420, 2, 'Logged out', '2015-07-20 16:58:48', 1),
(421, 2, 'Logged in', '2015-07-20 16:58:56', 1),
(422, 2, 'Logged out', '2015-07-20 16:59:33', 1),
(423, 2, 'Logged in', '2015-07-20 16:59:38', 1),
(424, 2, 'Logged out', '2015-07-20 16:59:50', 1),
(425, 2, 'Logged in', '2015-07-20 17:02:46', 1),
(426, 2, 'Logged out', '2015-07-20 17:04:03', 1),
(427, 2, 'Logged in', '2015-07-20 17:04:10', 1),
(428, 2, 'Logged out', '2015-07-20 17:05:37', 1),
(429, 2, 'Logged in', '2015-07-20 17:05:42', 1),
(430, 2, 'Logged out', '2015-07-20 17:08:29', 1),
(431, 2, 'Logged in', '2015-07-20 17:08:34', 1),
(432, 2, 'Logged out', '2015-07-20 17:09:18', 1),
(433, 2, 'Logged in', '2015-07-20 17:10:39', 1),
(434, 2, 'Logged out', '2015-07-20 17:22:36', 1),
(435, 2, 'Logged in', '2015-07-20 17:22:44', 1),
(436, 2, 'Logged out', '2015-07-20 17:25:52', 1),
(437, 2, 'Logged in', '2015-07-20 17:25:58', 1),
(438, 2, 'Logged out', '2015-07-20 17:32:46', 1),
(439, 2, 'Logged in', '2015-07-20 17:32:53', 1),
(440, 2, 'Logged out', '2015-07-20 17:33:15', 1),
(441, 2, 'Logged in', '2015-07-20 17:34:55', 1),
(442, 2, 'Logged in', '2015-07-21 08:20:58', 1),
(443, 2, 'Logged out', '2015-07-21 08:41:40', 1),
(444, 2, 'Logged in', '2015-07-21 08:41:45', 1),
(445, 2, 'Logged out', '2015-07-21 10:46:02', 1),
(446, 2, 'Logged in', '2015-07-21 10:46:09', 1),
(447, 2, 'Logged out', '2015-07-21 10:47:06', 1),
(448, 2, 'Logged in', '2015-07-21 10:47:11', 1),
(449, 2, 'Logged out', '2015-07-21 10:48:01', 1),
(450, 2, 'Logged in', '2015-07-21 10:48:06', 1),
(451, 2, 'Logged out', '2015-07-21 10:54:55', 1),
(452, 2, 'Logged in', '2015-07-21 10:55:02', 1),
(453, 2, 'Logged out', '2015-07-21 10:55:46', 1),
(454, 2, 'Logged in', '2015-07-21 10:55:52', 1),
(455, 2, 'Logged out', '2015-07-21 10:56:43', 1),
(456, 2, 'Logged in', '2015-07-21 10:56:50', 1),
(457, 2, 'Logged out', '2015-07-21 10:59:24', 1),
(458, 2, 'Logged in', '2015-07-21 10:59:30', 1),
(459, 2, 'Logged out', '2015-07-21 11:04:30', 1),
(460, 2, 'Logged in', '2015-07-21 11:04:35', 1),
(461, 2, 'Logged out', '2015-07-21 11:26:53', 1),
(462, 2, 'Logged in', '2015-07-21 11:27:01', 1),
(463, 2, 'Logged out', '2015-07-21 11:28:11', 1),
(464, 2, 'Logged in', '2015-07-21 11:28:18', 1),
(465, 2, 'Logged out', '2015-07-21 11:38:02', 1),
(466, 2, 'Logged in', '2015-07-21 11:38:09', 1),
(467, 2, 'Logged out', '2015-07-21 11:50:39', 1),
(468, 2, 'Logged in', '2015-07-21 11:50:45', 1),
(469, 2, 'Logged out', '2015-07-21 11:51:31', 1),
(470, 2, 'Logged in', '2015-07-21 11:51:35', 1),
(471, 2, 'Logged out', '2015-07-21 11:52:45', 1),
(472, 2, 'Logged in', '2015-07-21 11:52:51', 1),
(473, 2, 'Logged out', '2015-07-21 11:56:25', 1),
(474, 2, 'Logged in', '2015-07-21 11:56:37', 1),
(475, 2, 'Logged out', '2015-07-21 12:33:53', 1),
(476, 2, 'Logged in', '2015-07-21 12:33:59', 1),
(477, 2, 'Logged out', '2015-07-21 12:36:44', 1),
(478, 2, 'Logged in', '2015-07-21 12:37:41', 1),
(479, 2, 'Logged out', '2015-07-21 13:21:38', 1),
(480, 2, 'Logged in', '2015-07-21 13:21:42', 1),
(481, 2, 'Logged out', '2015-07-21 13:24:08', 1),
(482, 2, 'Logged in', '2015-07-21 13:24:13', 1),
(483, 2, 'Logged out', '2015-07-21 15:22:06', 1),
(484, 2, 'Logged in', '2015-07-21 15:22:12', 1),
(485, 2, 'Logged out', '2015-07-21 15:30:02', 1),
(486, 2, 'Logged in', '2015-07-21 15:39:20', 1),
(487, 2, 'Logged out', '2015-07-21 15:39:46', 1),
(488, 2, 'Logged in', '2015-07-21 15:39:50', 1),
(489, 2, 'Logged out', '2015-07-21 15:40:40', 1),
(490, 2, 'Logged in', '2015-07-21 15:40:44', 1),
(491, 2, 'Logged out', '2015-07-21 15:41:21', 1),
(492, 2, 'Logged in', '2015-07-21 15:41:27', 1),
(493, 2, 'Added entry to logbook', '2015-07-21 15:56:38', 1),
(494, 2, 'Logged in', '2015-07-22 08:31:04', 1),
(495, 2, 'Logged out', '2015-07-22 09:36:40', 1),
(496, 2, 'Logged in', '2015-07-22 09:36:45', 1),
(497, 2, 'Logged out', '2015-07-22 09:52:13', 1),
(498, 1, 'Logged in', '2015-07-22 09:52:19', 0),
(499, 1, 'Logged out', '2015-07-22 11:06:21', 0),
(500, 2, 'Logged in', '2015-07-22 11:06:25', 1),
(501, 2, 'Logged out', '2015-07-22 11:16:30', 1),
(502, 2, 'Logged in', '2015-07-22 11:16:41', 1),
(503, 2, 'Logged out', '2015-07-22 11:18:11', 1),
(504, 2, 'Logged in', '2015-07-22 11:18:16', 1),
(505, 2, 'Logged out', '2015-07-22 11:26:40', 1),
(506, 2, 'Logged in', '2015-07-22 11:28:02', 1),
(507, 2, 'Logged out', '2015-07-22 13:09:31', 1),
(508, 2, 'Logged in', '2015-07-22 13:09:39', 1),
(509, 2, 'Logged out', '2015-07-22 13:10:37', 1),
(510, 2, 'Logged in', '2015-07-22 13:10:58', 1),
(511, 2, 'Logged out', '2015-07-22 13:13:11', 1),
(512, 2, 'Logged in', '2015-07-22 13:13:16', 1),
(513, 2, 'Logged out', '2015-07-22 13:15:09', 1),
(514, 2, 'Logged in', '2015-07-22 13:15:13', 1),
(515, 2, 'Logged out', '2015-07-22 13:20:02', 1),
(516, 2, 'Logged in', '2015-07-22 13:20:10', 1),
(517, 2, 'Logged out', '2015-07-22 13:21:09', 1),
(518, 2, 'Logged in', '2015-07-22 13:21:14', 1),
(519, 2, 'Logged out', '2015-07-22 13:58:51', 1),
(520, 2, 'Logged in', '2015-07-22 13:58:57', 1),
(521, 2, 'Logged out', '2015-07-22 14:01:19', 1),
(522, 2, 'Logged in', '2015-07-22 14:09:35', 1),
(523, 2, 'Logged out', '2015-07-22 14:09:43', 1),
(524, 2, 'Logged in', '2015-07-22 14:09:50', 1),
(525, 2, 'Logged out', '2015-07-22 14:11:41', 1),
(526, 2, 'Logged in', '2015-07-22 14:11:57', 1),
(527, 2, 'Logged out', '2015-07-22 14:27:57', 1),
(528, 2, 'Logged in', '2015-07-22 14:28:05', 1),
(529, 2, 'Logged out', '2015-07-22 14:35:54', 1),
(530, 2, 'Logged in', '2015-07-22 14:36:05', 1),
(531, 2, 'Added entry to logbook', '2015-07-22 14:37:57', 1),
(532, 2, 'Logged out', '2015-07-22 14:45:48', 1),
(533, 2, 'Logged in', '2015-07-22 14:45:54', 1),
(534, 2, 'Logged out', '2015-07-22 14:52:37', 1),
(535, 2, 'Logged in', '2015-07-22 14:52:42', 1),
(536, 2, 'Logged out', '2015-07-22 14:53:02', 1),
(537, 2, 'Logged in', '2015-07-22 15:05:59', 1),
(538, 2, 'Logged out', '2015-07-22 15:13:59', 1),
(539, 2, 'Logged in', '2015-07-22 15:14:21', 1),
(540, 2, 'Added entry to logbook', '2015-07-22 15:16:09', 1),
(541, 2, 'Added entry to logbook', '2015-07-22 15:16:46', 1),
(542, 2, 'Logged out', '2015-07-22 16:29:52', 1),
(543, 2, 'Logged in', '2015-07-22 16:29:57', 1),
(544, 2, 'Logged out', '2015-07-22 16:38:17', 1),
(545, 2, 'Logged in', '2015-07-22 16:38:21', 1),
(546, 2, 'Logged out', '2015-07-22 16:41:15', 1),
(547, 2, 'Logged in', '2015-07-22 16:41:19', 1),
(548, 2, 'Logged out', '2015-07-22 16:54:43', 1),
(549, 2, 'Logged in', '2015-07-22 16:54:51', 1),
(550, 2, 'Logged out', '2015-07-22 17:11:57', 1),
(551, 2, 'Logged in', '2015-07-22 17:12:06', 1),
(552, 2, 'Logged out', '2015-07-22 17:13:23', 1),
(553, 2, 'Logged in', '2015-07-22 17:13:34', 1),
(554, 2, 'Logged in', '2015-07-23 08:27:23', 1),
(555, 2, 'Logged out', '2015-07-23 08:41:28', 1),
(556, 2, 'Logged in', '2015-07-23 08:41:36', 1),
(557, 2, 'Logged out', '2015-07-23 08:43:33', 1),
(558, 2, 'Logged in', '2015-07-23 08:43:39', 1),
(559, 2, 'Logged out', '2015-07-23 08:44:34', 1),
(560, 2, 'Logged in', '2015-07-23 08:45:10', 1),
(561, 2, 'Logged out', '2015-07-23 10:13:44', 1),
(562, 2, 'Logged in', '2015-07-23 10:13:56', 1),
(563, 2, 'Logged out', '2015-07-23 11:18:46', 1),
(564, 1, 'Logged in', '2015-07-23 11:18:51', 0),
(565, 1, 'Logged out', '2015-07-23 11:22:58', 0),
(566, 2, 'Logged in', '2015-07-23 11:23:19', 1),
(567, 2, 'Logged out', '2015-07-23 12:04:17', 1),
(568, 2, 'Logged in', '2015-07-23 12:04:21', 1),
(569, 2, 'Logged out', '2015-07-23 12:04:51', 1),
(570, 2, 'Logged in', '2015-07-23 12:05:01', 1),
(571, 2, 'Logged out', '2015-07-23 12:06:28', 1),
(572, 2, 'Logged in', '2015-07-23 12:06:35', 1),
(573, 2, 'Logged out', '2015-07-23 12:07:23', 1),
(574, 2, 'Logged in', '2015-07-23 12:07:34', 1),
(575, 2, 'Logged out', '2015-07-23 12:10:43', 1),
(576, 2, 'Logged in', '2015-07-23 12:10:49', 1),
(577, 2, 'Logged out', '2015-07-23 12:12:07', 1),
(578, 2, 'Logged in', '2015-07-23 12:12:12', 1),
(579, 2, 'Logged out', '2015-07-23 12:12:53', 1),
(580, 2, 'Logged in', '2015-07-23 12:13:33', 1),
(581, 2, 'Logged out', '2015-07-23 12:21:24', 1),
(582, 2, 'Logged in', '2015-07-23 12:21:32', 1),
(583, 2, 'Logged out', '2015-07-23 12:25:54', 1),
(584, 2, 'Logged in', '2015-07-23 12:25:59', 1),
(585, 2, 'Logged out', '2015-07-23 12:49:08', 1),
(586, 2, 'Logged in', '2015-07-23 12:49:21', 1),
(587, 2, 'Logged out', '2015-07-23 13:37:14', 1),
(588, 2, 'Logged in', '2015-07-23 13:37:19', 1),
(589, 2, 'Logged out', '2015-07-23 13:39:01', 1),
(590, 2, 'Logged in', '2015-07-23 13:39:08', 1),
(591, 2, 'Logged out', '2015-07-23 16:05:13', 1),
(592, 2, 'Logged in', '2015-07-23 16:05:18', 1),
(593, 2, 'Logged out', '2015-07-23 16:06:43', 1),
(594, 2, 'Logged in', '2015-07-23 16:06:48', 1),
(595, 2, 'Logged out', '2015-07-23 16:07:10', 1),
(596, 2, 'Logged in', '2015-07-23 16:07:15', 1),
(597, 2, 'Logged out', '2015-07-23 16:27:11', 1),
(598, 2, 'Logged in', '2015-07-23 16:27:17', 1),
(599, 2, 'Added entry to logbook', '2015-07-23 17:23:02', 1),
(600, 2, 'Logged out', '2015-07-23 17:39:41', 1),
(601, 2, 'Logged in', '2015-07-23 17:39:46', 1),
(602, 2, 'Logged in', '2015-07-24 07:54:21', 1),
(603, 2, 'Logged out', '2015-07-24 16:15:52', 1),
(604, 2, 'Logged in', '2015-07-24 16:16:01', 1),
(605, 2, 'Logged out', '2015-07-24 16:16:23', 1),
(606, 2, 'Logged in', '2015-07-24 16:16:28', 1),
(607, 2, 'Logged out', '2015-07-24 16:23:41', 1),
(608, 2, 'Logged in', '2015-07-24 16:23:48', 1),
(609, 2, 'Logged out', '2015-07-24 17:07:49', 1),
(610, 2, 'Logged in', '2015-07-24 17:07:54', 1),
(611, 2, 'Logged out', '2015-07-24 17:09:39', 1),
(612, 2, 'Logged in', '2015-07-24 17:09:44', 1),
(613, 2, 'Logged out', '2015-07-24 17:24:10', 1),
(614, 2, 'Logged in', '2015-07-24 17:24:15', 1),
(615, 2, 'Logged in', '2015-07-27 07:35:50', 1),
(616, 2, 'Logged in', '2015-07-27 08:53:28', 1),
(617, 2, 'Logged out', '2015-07-27 09:12:48', 1),
(618, 2, 'Logged in', '2015-07-27 09:12:53', 1),
(619, 2, 'Logged out', '2015-07-27 09:14:09', 1),
(620, 2, 'Logged in', '2015-07-27 09:14:14', 1),
(621, 2, 'Logged out', '2015-07-27 10:30:44', 1),
(622, 2, 'Logged in', '2015-07-27 10:30:57', 1),
(623, 2, 'Logged out', '2015-07-27 11:23:29', 1),
(624, 2, 'Logged in', '2015-07-27 11:23:40', 1),
(625, 2, 'Logged out', '2015-07-27 11:24:15', 1),
(626, 2, 'Logged in', '2015-07-27 11:24:21', 1),
(627, 2, 'Logged out', '2015-07-27 11:24:47', 1),
(628, 2, 'Logged in', '2015-07-27 11:25:20', 1),
(629, 2, 'Logged out', '2015-07-27 11:25:32', 1),
(630, 2, 'Logged in', '2015-07-27 11:25:44', 1),
(631, 2, 'Logged out', '2015-07-27 11:27:14', 1),
(632, 2, 'Logged in', '2015-07-27 11:28:03', 1),
(633, 2, 'Logged out', '2015-07-27 11:28:22', 1),
(634, 2, 'Logged in', '2015-07-27 11:31:09', 1),
(635, 2, 'Logged out', '2015-07-27 11:34:55', 1),
(636, 2, 'Logged in', '2015-07-27 11:34:59', 1),
(637, 2, 'Logged out', '2015-07-27 11:35:19', 1),
(638, 2, 'Logged in', '2015-07-27 11:35:23', 1),
(639, 2, 'Logged out', '2015-07-27 11:51:03', 1),
(640, 2, 'Logged in', '2015-07-27 11:51:07', 1),
(641, 2, 'Logged out', '2015-07-27 11:51:23', 1),
(642, 2, 'Logged in', '2015-07-27 11:52:10', 1),
(643, 2, 'Logged out', '2015-07-27 11:52:48', 1),
(644, 2, 'Logged in', '2015-07-27 11:52:52', 1),
(645, 2, 'Logged out', '2015-07-27 11:55:37', 1),
(646, 2, 'Logged in', '2015-07-27 11:55:43', 1),
(647, 2, 'Logged out', '2015-07-27 11:55:55', 1),
(648, 2, 'Logged in', '2015-07-27 11:56:00', 1),
(649, 2, 'Logged out', '2015-07-27 11:57:10', 1),
(650, 2, 'Logged in', '2015-07-27 11:57:19', 1),
(651, 2, 'Logged out', '2015-07-27 11:57:31', 1),
(652, 2, 'Logged in', '2015-07-27 11:57:38', 1),
(653, 2, 'Logged out', '2015-07-27 11:58:26', 1),
(654, 2, 'Logged in', '2015-07-27 11:58:31', 1),
(655, 2, 'Logged out', '2015-07-27 12:00:31', 1),
(656, 2, 'Logged in', '2015-07-27 12:00:39', 1),
(657, 2, 'Logged out', '2015-07-27 12:06:43', 1),
(658, 2, 'Logged in', '2015-07-27 12:06:47', 1),
(659, 2, 'Logged out', '2015-07-27 12:51:00', 1),
(660, 2, 'Logged in', '2015-07-27 12:51:05', 1),
(661, 2, 'Logged out', '2015-07-27 12:51:18', 1),
(662, 2, 'Logged in', '2015-07-27 12:58:37', 1),
(663, 2, 'Logged out', '2015-07-27 12:58:49', 1),
(664, 2, 'Logged in', '2015-07-27 13:11:56', 1),
(665, 2, 'Logged out', '2015-07-27 13:12:14', 1),
(666, 2, 'Logged in', '2015-07-27 13:12:46', 1),
(667, 2, 'Logged out', '2015-07-27 13:33:34', 1),
(668, 2, 'Logged in', '2015-07-27 13:36:16', 1),
(669, 2, 'Logged out', '2015-07-27 13:36:27', 1),
(670, 2, 'Logged in', '2015-07-27 13:36:31', 1),
(671, 2, 'Logged out', '2015-07-27 13:37:13', 1),
(672, 2, 'Logged in', '2015-07-27 13:37:18', 1),
(673, 2, 'Logged out', '2015-07-27 13:38:00', 1),
(674, 2, 'Logged in', '2015-07-27 13:38:04', 1),
(675, 2, 'Logged out', '2015-07-27 13:39:28', 1),
(676, 2, 'Logged in', '2015-07-27 13:39:44', 1),
(677, 2, 'Logged out', '2015-07-27 13:40:11', 1),
(678, 2, 'Logged in', '2015-07-27 13:40:18', 1),
(679, 2, 'Logged out', '2015-07-27 13:41:04', 1),
(680, 2, 'Logged in', '2015-07-27 13:41:10', 1),
(681, 2, 'Logged out', '2015-07-27 13:42:42', 1),
(682, 2, 'Logged in', '2015-07-27 13:42:52', 1),
(683, 2, 'Logged out', '2015-07-27 13:43:03', 1),
(684, 2, 'Logged in', '2015-07-27 13:43:13', 1),
(685, 2, 'Logged out', '2015-07-27 14:04:07', 1),
(686, 2, 'Logged in', '2015-07-27 14:04:14', 1),
(687, 2, 'Logged out', '2015-07-27 14:04:39', 1),
(688, 2, 'Logged in', '2015-07-27 14:04:49', 1),
(689, 2, 'Logged in', '2015-07-27 15:02:50', 1),
(690, 2, 'Logged in', '2015-07-28 07:45:25', 1),
(691, 2, 'Logged in', '2015-07-28 08:55:46', 1),
(692, 2, 'Logged out', '2015-07-28 09:03:45', 1),
(693, 2, 'Logged in', '2015-07-28 09:10:38', 1),
(694, 2, 'Logged out', '2015-07-28 10:30:06', 1),
(695, 2, 'Logged in', '2015-07-28 10:30:16', 1),
(696, 2, 'Logged out', '2015-07-28 10:42:13', 1),
(697, 2, 'Logged in', '2015-07-28 10:42:19', 1),
(698, 2, 'Logged out', '2015-07-28 10:44:28', 1),
(699, 2, 'Logged in', '2015-07-28 10:44:41', 1),
(700, 2, 'Logged out', '2015-07-28 10:47:39', 1),
(701, 2, 'Logged in', '2015-07-28 10:47:42', 1),
(702, 2, 'Logged out', '2015-07-28 10:48:20', 1),
(703, 2, 'Logged in', '2015-07-28 10:48:24', 1),
(704, 2, 'Logged out', '2015-07-28 10:49:33', 1),
(705, 2, 'Logged in', '2015-07-28 10:53:28', 1),
(706, 2, 'Logged out', '2015-07-28 11:03:16', 1),
(707, 2, 'Logged in', '2015-07-28 11:03:22', 1),
(708, 2, 'Logged out', '2015-07-28 11:25:10', 1),
(709, 2, 'Logged in', '2015-07-28 11:25:19', 1),
(710, 2, 'Logged out', '2015-07-28 11:32:21', 1),
(711, 2, 'Logged in', '2015-07-28 11:32:28', 1),
(712, 2, 'Logged out', '2015-07-28 11:34:31', 1),
(713, 2, 'Logged in', '2015-07-28 11:34:36', 1),
(714, 2, 'Logged out', '2015-07-28 13:43:26', 1),
(715, 2, 'Logged in', '2015-07-28 13:44:20', 1),
(716, 2, 'Logged out', '2015-07-28 13:52:46', 1),
(717, 2, 'Logged in', '2015-07-28 13:52:53', 1),
(718, 2, 'Logged out', '2015-07-28 16:10:10', 1),
(719, 2, 'Logged in', '2015-07-28 16:10:15', 1),
(720, 2, 'Logged out', '2015-07-28 16:21:03', 1),
(721, 2, 'Logged in', '2015-07-28 16:21:09', 1),
(722, 2, 'Logged out', '2015-07-28 16:22:06', 1),
(723, 2, 'Logged in', '2015-07-28 16:22:11', 1),
(724, 2, 'Logged out', '2015-07-28 16:58:58', 1),
(725, 2, 'Logged in', '2015-07-28 16:59:03', 1),
(726, 2, 'Logged out', '2015-07-28 17:11:58', 1),
(727, 2, 'Logged in', '2015-07-28 17:12:04', 1),
(728, 2, 'Logged in', '2015-07-29 08:36:58', 1),
(729, 2, 'Logged out', '2015-07-29 09:22:01', 1),
(730, 2, 'Logged in', '2015-07-29 09:22:05', 1),
(731, 2, 'Logged out', '2015-07-29 15:54:20', 1),
(732, 2, 'Logged in', '2015-07-29 15:54:26', 1),
(733, 2, 'Logged in', '2015-07-30 07:40:28', 1),
(734, 2, 'Logged out', '2015-07-30 09:13:22', 1),
(735, 2, 'Logged in', '2015-07-30 09:13:28', 1),
(736, 2, 'Logged out', '2015-07-30 09:16:38', 1),
(737, 2, 'Logged in', '2015-07-30 09:16:41', 1),
(738, 2, 'Logged out', '2015-07-30 09:18:38', 1),
(739, 2, 'Logged in', '2015-07-30 09:18:42', 1),
(740, 2, 'Logged out', '2015-07-30 09:19:38', 1),
(741, 2, 'Logged in', '2015-07-30 09:19:42', 1),
(742, 2, 'Logged out', '2015-07-30 09:45:14', 1),
(743, 2, 'Logged in', '2015-07-30 09:45:27', 1),
(744, 2, 'Logged in', '2015-07-30 11:19:36', 1),
(745, 2, 'Logged out', '2015-07-30 14:19:18', 1),
(746, 2, 'Logged in', '2015-07-30 14:19:28', 1),
(747, 2, 'Added entry to logbook', '2015-07-30 14:23:15', 1),
(748, 2, 'Logged out', '2015-07-30 14:25:52', 1),
(749, 2, 'Logged in', '2015-07-30 14:26:00', 1),
(750, 2, 'Logged out', '2015-07-30 14:27:37', 1),
(751, 2, 'Logged in', '2015-07-30 14:28:18', 1),
(752, 2, 'Added entry to logbook', '2015-07-30 14:30:43', 1),
(753, 2, 'Logged out', '2015-07-30 14:41:36', 1),
(754, 2, 'Logged in', '2015-07-30 14:42:11', 1),
(755, 2, 'Added entry to logbook', '2015-07-30 14:45:53', 1),
(756, 2, 'Logged out', '2015-07-30 14:46:27', 1),
(757, 2, 'Logged in', '2015-07-30 14:46:32', 1),
(758, 2, 'Logged out', '2015-07-30 14:58:02', 1),
(759, 2, 'Logged in', '2015-07-30 14:58:18', 1),
(760, 2, 'Added entry to logbook', '2015-07-30 14:59:05', 1),
(761, 2, 'Logged out', '2015-07-30 15:03:10', 1),
(762, 2, 'Logged in', '2015-07-30 15:03:16', 1),
(763, 2, 'Logged out', '2015-07-30 15:07:42', 1),
(764, 2, 'Logged in', '2015-07-30 15:07:47', 1),
(765, 2, 'Added entry to logbook', '2015-07-30 15:08:50', 1),
(766, 2, 'Logged out', '2015-07-30 15:11:00', 1),
(767, 2, 'Logged in', '2015-07-30 15:11:08', 1),
(768, 2, 'Added entry to logbook', '2015-07-30 15:11:34', 1),
(769, 2, 'Logged out', '2015-07-30 15:14:02', 1),
(770, 2, 'Logged in', '2015-07-30 15:14:11', 1),
(771, 2, 'Logged out', '2015-07-30 15:15:31', 1),
(772, 2, 'Logged in', '2015-07-30 15:15:41', 1),
(773, 2, 'Added entry to logbook', '2015-07-30 15:16:30', 1),
(774, 2, 'Logged out', '2015-07-30 15:17:10', 1),
(775, 2, 'Logged in', '2015-07-30 15:19:28', 1),
(776, 2, 'Added entry to logbook', '2015-07-30 15:20:17', 1),
(777, 2, 'Logged out', '2015-07-30 15:20:44', 1),
(778, 2, 'Logged in', '2015-07-30 15:20:53', 1),
(779, 2, 'Logged out', '2015-07-30 15:25:26', 1),
(780, 2, 'Logged in', '2015-07-30 15:25:43', 1),
(781, 2, 'Added entry to logbook', '2015-07-30 15:26:12', 1),
(782, 2, 'Logged out', '2015-07-30 15:28:30', 1),
(783, 2, 'Logged in', '2015-07-30 15:28:35', 1),
(784, 2, 'Added entry to logbook', '2015-07-30 15:28:58', 1),
(785, 2, 'Logged out', '2015-07-30 15:30:10', 1),
(786, 2, 'Logged in', '2015-07-30 15:30:16', 1),
(787, 2, 'Added entry to logbook', '2015-07-30 15:30:45', 1),
(788, 2, 'Logged out', '2015-07-30 15:33:36', 1),
(789, 2, 'Logged in', '2015-07-30 15:43:22', 1),
(790, 2, 'Added entry to logbook', '2015-07-30 15:43:52', 1),
(791, 2, 'Logged out', '2015-07-30 15:45:10', 1),
(792, 2, 'Logged in', '2015-07-30 15:45:15', 1),
(793, 2, 'Added entry to logbook', '2015-07-30 15:51:26', 1),
(794, 2, 'Logged out', '2015-07-30 15:59:12', 1),
(795, 2, 'Logged in', '2015-07-30 15:59:16', 1),
(796, 2, 'Added entry to logbook', '2015-07-30 16:02:42', 1),
(797, 2, 'Logged out', '2015-07-30 16:31:16', 1),
(798, 2, 'Logged in', '2015-07-30 16:31:58', 1),
(799, 2, 'Added entry to logbook', '2015-07-30 16:32:40', 1),
(800, 2, 'Logged out', '2015-07-30 16:32:46', 1),
(801, 2, 'Logged in', '2015-07-30 16:58:18', 1),
(802, 2, 'Logged out', '2015-07-30 17:05:23', 1),
(803, 2, 'Logged in', '2015-07-30 17:05:28', 1),
(804, 2, 'Logged in', '2015-07-31 07:49:29', 1),
(805, 2, 'Logged out', '2015-07-31 09:43:02', 1),
(806, 2, 'Logged in', '2015-07-31 09:43:10', 1),
(807, 2, 'Logged out', '2015-07-31 10:39:00', 1),
(808, 2, 'Logged in', '2015-07-31 10:39:05', 1),
(809, 2, 'Logged out', '2015-07-31 11:21:58', 1),
(810, 2, 'Logged in', '2015-07-31 11:22:03', 1),
(811, 2, 'Logged out', '2015-07-31 11:22:43', 1),
(812, 2, 'Logged in', '2015-07-31 11:22:48', 1),
(813, 2, 'Logged in', '2015-07-31 14:18:39', 1),
(814, 2, 'Logged in', '2015-08-03 07:45:29', 1),
(815, 2, 'Logged out', '2015-08-03 10:29:17', 1),
(816, 2, 'Logged in', '2015-08-03 10:29:34', 1),
(817, 2, 'Logged out', '2015-08-03 12:20:36', 1),
(818, 2, 'Logged in', '2015-08-03 12:20:44', 1),
(819, 2, 'Logged out', '2015-08-03 12:21:20', 1),
(820, 2, 'Logged in', '2015-08-03 12:22:54', 1),
(821, 2, 'Logged out', '2015-08-03 14:03:40', 1),
(822, 2, 'Logged in', '2015-08-03 14:03:51', 1),
(823, 2, 'Logged out', '2015-08-03 14:06:24', 1),
(824, 2, 'Logged in', '2015-08-03 14:06:30', 1),
(825, 2, 'Added entry to logbook', '2015-08-03 14:28:09', 1),
(826, 2, 'Logged out', '2015-08-03 15:01:32', 1),
(827, 2, 'Logged in', '2015-08-03 15:01:38', 1),
(828, 2, 'Logged out', '2015-08-03 15:03:55', 1),
(829, 2, 'Logged in', '2015-08-03 15:04:01', 1),
(830, 2, 'Logged out', '2015-08-03 15:33:30', 1),
(831, 2, 'Logged in', '2015-08-03 15:33:42', 1),
(832, 2, 'Logged out', '2015-08-03 15:35:22', 1),
(833, 2, 'Logged in', '2015-08-03 15:35:41', 1),
(834, 2, 'Logged out', '2015-08-03 15:39:49', 1),
(835, 2, 'Logged in', '2015-08-03 15:39:57', 1),
(836, 2, 'Logged out', '2015-08-03 15:45:41', 1),
(837, 2, 'Logged in', '2015-08-03 15:45:48', 1),
(838, 2, 'Logged out', '2015-08-03 16:07:54', 1),
(839, 2, 'Logged in', '2015-08-03 16:08:04', 1),
(840, 2, 'Added entry to logbook', '2015-08-03 16:08:19', 1),
(841, 2, 'Logged out', '2015-08-03 16:10:31', 1),
(842, 2, 'Logged in', '2015-08-03 16:10:47', 1),
(843, 2, 'Logged out', '2015-08-03 16:34:12', 1),
(844, 2, 'Logged in', '2015-08-03 16:34:36', 1),
(845, 2, 'Logged out', '2015-08-03 16:34:38', 1),
(846, 2, 'Logged in', '2015-08-03 16:36:03', 1),
(847, 2, 'Logged out', '2015-08-03 16:36:43', 1),
(848, 2, 'Logged in', '2015-08-03 16:36:47', 1),
(849, 2, 'Logged out', '2015-08-03 16:40:28', 1),
(850, 2, 'Logged in', '2015-08-03 16:40:35', 1),
(851, 2, 'Logged out', '2015-08-03 16:42:39', 1),
(852, 2, 'Logged in', '2015-08-03 16:42:44', 1),
(853, 2, 'Added entry to logbook', '2015-08-03 16:42:58', 1),
(854, 2, 'Logged out', '2015-08-03 16:48:04', 1),
(855, 2, 'Logged in', '2015-08-03 16:48:09', 1),
(856, 2, 'Logged out', '2015-08-03 17:17:42', 1),
(857, 2, 'Logged in', '2015-08-03 17:17:48', 1),
(858, 2, 'Logged out', '2015-08-03 17:29:42', 1),
(859, 2, 'Logged in', '2015-08-03 17:29:47', 1),
(860, 2, 'Logged out', '2015-08-03 17:30:19', 1),
(861, 2, 'Logged in', '2015-08-03 17:30:26', 1),
(862, 2, 'Logged out', '2015-08-03 17:32:36', 1),
(863, 2, 'Logged in', '2015-08-03 17:32:57', 1),
(864, 2, 'Added entry to logbook', '2015-08-03 17:33:12', 1),
(865, 2, 'Logged out', '2015-08-03 17:34:59', 1),
(866, 2, 'Logged in', '2015-08-03 17:35:05', 1),
(867, 2, 'Logged out', '2015-08-03 17:35:12', 1),
(868, 2, 'Logged in', '2015-08-04 07:48:32', 1),
(869, 2, 'Logged out', '2015-08-04 10:01:59', 1),
(870, 1, 'Logged in', '2015-08-04 10:02:07', 0),
(871, 1, 'Created 1 new Codes.', '2015-08-04 10:02:26', 0),
(872, 1, 'Created 1 new 10-00 Series Codes.', '2015-08-04 10:04:35', 0),
(873, 1, 'Created 1 new 10-00 Series Codes.', '2015-08-04 10:10:36', 0),
(874, 1, 'Created 1 new 11-00 Series Codes.', '2015-08-04 10:16:29', 0),
(875, 1, 'Created 1 new 10-00 Series Codes.', '2015-08-04 10:19:16', 0),
(876, 1, 'Logged out', '2015-08-04 10:19:18', 0),
(877, 2, 'Logged in', '2015-08-04 10:19:23', 1),
(878, 2, 'Added entry to logbook', '2015-08-04 10:49:11', 1),
(879, 2, 'Logged out', '2015-08-04 10:54:05', 1),
(880, 2, 'Logged in', '2015-08-04 10:54:16', 1),
(881, 2, 'Logged out', '2015-08-04 11:00:08', 1),
(882, 2, 'Logged in', '2015-08-04 11:00:14', 1),
(883, 2, 'Logged out', '2015-08-04 11:01:03', 1),
(884, 2, 'Logged in', '2015-08-04 11:01:10', 1),
(885, 2, 'Logged out', '2015-08-04 11:02:41', 1),
(886, 2, 'Logged in', '2015-08-04 11:02:47', 1),
(887, 2, 'Logged out', '2015-08-04 11:02:55', 1),
(888, 2, 'Logged in', '2015-08-04 11:04:23', 1),
(889, 2, 'Logged out', '2015-08-04 13:30:44', 1),
(890, 2, 'Logged in', '2015-08-04 13:30:57', 1),
(891, 2, 'Logged out', '2015-08-04 13:43:57', 1),
(892, 2, 'Logged in', '2015-08-04 13:44:02', 1),
(893, 2, 'Logged out', '2015-08-04 15:16:06', 1),
(894, 2, 'Logged in', '2015-08-04 15:16:14', 1),
(895, 2, 'Logged out', '2015-08-04 15:17:06', 1),
(896, 2, 'Logged in', '2015-08-04 15:17:20', 1),
(897, 2, 'Added entry to logbook', '2015-08-04 15:17:46', 1),
(898, 2, 'Logged out', '2015-08-04 15:20:35', 1),
(899, 2, 'Logged in', '2015-08-04 15:21:09', 1),
(900, 2, 'Logged out', '2015-08-04 15:31:00', 1),
(901, 2, 'Logged in', '2015-08-04 15:31:09', 1),
(902, 2, 'Logged out', '2015-08-04 15:33:21', 1),
(903, 2, 'Logged in', '2015-08-04 15:33:27', 1),
(904, 2, 'Added entry to logbook', '2015-08-04 15:37:19', 1),
(905, 2, 'Logged out', '2015-08-04 15:45:20', 1),
(906, 2, 'Logged in', '2015-08-04 15:45:26', 1),
(907, 2, 'Added entry to logbook', '2015-08-04 15:46:21', 1),
(908, 2, 'Logged out', '2015-08-04 15:46:37', 1),
(909, 2, 'Logged in', '2015-08-04 16:17:18', 1),
(910, 2, 'Logged out', '2015-08-04 16:19:29', 1),
(911, 2, 'Logged in', '2015-08-04 16:20:02', 1),
(912, 2, 'Logged out', '2015-08-04 16:22:07', 1),
(913, 2, 'Logged in', '2015-08-04 16:22:20', 1),
(914, 2, 'Added entry to logbook', '2015-08-04 16:22:49', 1),
(915, 2, 'Logged out', '2015-08-04 16:23:53', 1),
(916, 2, 'Logged in', '2015-08-04 16:24:09', 1),
(917, 2, 'Added entry to logbook', '2015-08-04 16:24:46', 1),
(918, 2, 'Logged out', '2015-08-04 16:25:10', 1),
(919, 2, 'Logged in', '2015-08-04 16:26:54', 1),
(920, 2, 'Added entry to logbook', '2015-08-04 16:27:32', 1),
(921, 2, 'Logged out', '2015-08-04 16:40:47', 1),
(922, 2, 'Logged in', '2015-08-04 16:40:52', 1),
(923, 2, 'Logged out', '2015-08-04 16:48:22', 1),
(924, 1, 'Logged in', '2015-08-04 16:48:27', 0),
(925, 1, 'Logged out', '2015-08-04 16:51:48', 0),
(926, 2, 'Logged in', '2015-08-04 16:51:55', 1),
(927, 2, 'Logged out', '2015-08-04 17:18:37', 1),
(928, 2, 'Logged in', '2015-08-04 17:18:52', 1),
(929, 2, 'Logged out', '2015-08-04 17:39:34', 1),
(930, 2, 'Logged in', '2015-08-04 17:39:40', 1),
(931, 2, 'Logged out', '2015-08-04 17:41:36', 1),
(932, 2, 'Logged in', '2015-08-04 17:41:42', 1),
(933, 2, 'Logged out', '2015-08-04 17:43:13', 1),
(934, 2, 'Logged in', '2015-08-04 17:45:34', 1),
(935, 2, 'Logged out', '2015-08-04 17:51:59', 1),
(936, 2, 'Logged in', '2015-08-04 17:52:03', 1),
(937, 2, 'Logged in', '2015-08-05 08:01:52', 1),
(938, 2, 'Logged out', '2015-08-05 09:26:09', 1),
(939, 2, 'Logged in', '2015-08-05 09:27:18', 1),
(940, 2, 'Logged out', '2015-08-05 09:30:43', 1),
(941, 2, 'Logged in', '2015-08-05 09:30:56', 1),
(942, 2, 'Added entry to logbook', '2015-08-05 09:32:54', 1),
(943, 2, 'Logged out', '2015-08-05 09:32:56', 1),
(944, 2, 'Logged in', '2015-08-05 09:33:04', 1),
(945, 2, 'Logged out', '2015-08-05 09:34:29', 1),
(946, 2, 'Logged in', '2015-08-05 09:34:38', 1),
(947, 2, 'Logged out', '2015-08-05 09:55:30', 1),
(948, 2, 'Logged in', '2015-08-05 09:55:36', 1),
(949, 2, 'Logged out', '2015-08-05 10:01:04', 1),
(950, 2, 'Logged in', '2015-08-05 10:01:17', 1),
(951, 2, 'Logged out', '2015-08-05 10:05:51', 1),
(952, 2, 'Logged in', '2015-08-05 10:06:04', 1),
(953, 2, 'Logged out', '2015-08-05 10:06:43', 1),
(954, 2, 'Logged in', '2015-08-05 10:06:50', 1),
(955, 2, 'Logged out', '2015-08-05 10:11:29', 1),
(956, 2, 'Logged in', '2015-08-05 10:11:36', 1),
(957, 2, 'Logged out', '2015-08-05 10:11:55', 1),
(958, 2, 'Logged in', '2015-08-05 10:13:13', 1),
(959, 2, 'Added something', '2015-10-29 09:33:00', 1),
(960, 2, 'Added logbook entry', '2015-10-29 09:46:03', 1),
(961, 2, 'Added log entry number 110', '2015-10-29 10:40:06', 1),
(962, 2, 'Closed ticket #', '2015-10-29 11:06:30', 1),
(963, 2, 'Closed ticket #49', '2015-10-29 11:11:21', 1),
(964, 2, 'Created incident ticket', '2015-11-03 14:16:18', 1),
(965, 3, 'Added guard personnel', '2015-11-03 15:46:26', 1),
(966, 3, 'Edited guard personnel #6', '2015-11-03 15:46:41', 1),
(967, 1, 'Added guard Luthor, Lex William', '2015-11-03 15:56:49', 8),
(968, 3, 'Added ticket entry #67', '2015-11-03 17:45:25', 1),
(969, 3, 'Added logbook entry #111', '2015-11-03 17:45:25', 1),
(970, 3, 'Added ticket entry #68', '2015-11-03 17:45:46', 1),
(971, 3, 'Added logbook entry #112', '2015-11-03 17:45:46', 1),
(972, 3, 'Added ticket entry #69', '2015-11-03 17:46:08', 1),
(973, 3, 'Added logbook entry #113', '2015-11-03 17:46:08', 1),
(974, 3, 'Closed ticket #67', '2015-11-13 08:02:40', 1),
(975, 3, 'Made revisions to logs', '2015-11-13 08:25:04', 1),
(976, 3, 'Added ticket entry #70', '2015-11-16 08:50:51', 1),
(977, 3, 'Added logbook entry #114', '2015-11-16 08:50:51', 1),
(978, 3, 'Closed ticket #70', '2015-11-16 08:51:10', 1),
(979, 3, 'Edited disposition of ticket #', '2015-11-16 09:25:36', 1),
(980, 3, 'Edited disposition of ticket #', '2015-11-16 09:26:14', 1),
(981, 3, 'Edited disposition of ticket #', '2015-11-16 09:36:09', 1),
(982, 3, 'Edited disposition of ticket #', '2015-11-16 09:38:49', 1),
(983, 3, 'Edited disposition of ticket #', '2015-11-16 09:39:18', 1),
(984, 3, 'Added ticket entry #71', '2015-11-18 08:33:55', 1),
(985, 3, 'Added logbook entry #115', '2015-11-18 08:33:55', 1),
(986, 3, 'Closed ticket #71', '2015-11-18 08:35:16', 1),
(987, 3, 'Edited disposition of ticket #', '2015-11-18 08:35:25', 1),
(988, 3, 'Made revisions to logs', '2015-11-18 09:20:34', 1),
(989, 3, 'Edited disposition of ticket #', '2015-11-18 09:23:24', 1),
(990, 3, 'Added ticket entry #72', '2015-11-18 09:44:18', 1),
(991, 3, 'Added logbook entry #116', '2015-11-18 09:44:18', 1),
(992, 3, 'Added witness(es) to ticket #72', '2015-11-18 09:45:21', 1),
(993, 3, 'Added damage details to ticket #72', '2015-11-18 09:45:21', 1),
(994, 3, 'Closed ticket #72', '2015-11-18 09:45:21', 1),
(995, 3, 'Made revisions to logs', '2015-11-18 09:45:51', 1),
(996, 3, 'Made revisions to a revised logs', '2015-11-23 09:40:31', 1),
(997, 3, 'Added dropdown entry', '2015-11-27 09:16:53', 1),
(998, 3, 'Added logbook entry #117', '2015-11-27 09:17:27', 1),
(999, 3, 'Added new location', '2015-11-27 09:19:27', 1),
(1000, 3, 'Added security alert recipiebt', '2015-11-27 09:20:12', 1),
(1001, 3, 'Changed password', '2015-11-27 09:29:35', 1),
(1002, 3, 'Changed password', '2015-11-27 09:30:00', 1),
(1003, 3, 'Added dropdown entry', '2015-12-09 09:04:52', 1),
(1004, 3, 'Added logbook entry #118', '2015-12-09 09:05:20', 1),
(1005, 3, 'Added logbook entry #119', '2015-12-09 09:36:10', 1),
(1006, 3, 'Added ticket entry #75', '2015-12-10 18:09:35', 1),
(1007, 3, 'Added logbook entry #120', '2015-12-10 18:09:35', 1),
(1008, 3, 'Added logbook entry #121', '2015-12-10 18:10:24', 1),
(1009, 3, 'Closed ticket #75', '2015-12-10 18:21:54', 1),
(1010, 3, 'Edited guard personnel #4', '2015-12-10 20:57:52', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE IF NOT EXISTS `ticket` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(45) DEFAULT NULL,
  `bu` bigint(20) DEFAULT NULL,
  `is_open` tinyint(1) DEFAULT NULL,
  `dateadded` date NOT NULL,
  `ticket_type` int(11) NOT NULL,
  `datesubmitted` datetime DEFAULT NULL,
  `damage_cost` int(11) DEFAULT NULL,
  `loss_type` varchar(50) DEFAULT NULL,
  `disposition` text,
  `dateclosed` date DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `responding_guard` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`id`, `description`, `bu`, `is_open`, `dateadded`, `ticket_type`, `datesubmitted`, `damage_cost`, `loss_type`, `disposition`, `dateclosed`, `location`, `responding_guard`) VALUES
(1, 'test', 1, 0, '2015-07-07', 2, '2015-07-07 10:39:08', 0, '', '', '0000-00-00', '', ''),
(2, 'test activity', 1, 0, '2015-07-07', 2, '2015-07-07 14:26:28', 0, '', '', '0000-00-00', '', ''),
(4, 'test activity 4', 1, 0, '2015-07-08', 2, '2015-07-08 13:16:21', 0, '', '', '0000-00-00', '', ''),
(5, 'test 4 activity', 1, 0, '2015-07-09', 2, '2015-07-09 15:54:29', 0, '', '', '0000-00-00', '', ''),
(6, 'TEST - Roving', 1, 0, '2015-07-16', 2, '2015-07-16 16:35:37', 0, '', '', '0000-00-00', '', ''),
(7, 'TEST - Fire', 1, 0, '2015-07-20', 1, '2015-07-20 14:18:18', 0, '', '', '0000-00-00', '1', '3'),
(8, 'TEST - Bomb', 1, 0, '2015-07-22', 1, '2015-07-22 14:45:00', 0, '', '', '0000-00-00', '1', '2'),
(9, 'test july 22', 1, 0, '2015-07-22', 2, '2015-07-22 15:15:38', 0, '', '', '0000-00-00', '', ''),
(10, 'Test july 30', 1, 0, '2015-07-30', 1, '2015-07-30 14:20:13', 0, '', '', '0000-00-00', '1', '3'),
(11, 'test july 30a', 1, 0, '2015-07-30', 1, '2015-07-30 14:26:59', 0, '', '', '0000-00-00', '1', '3'),
(12, 'Test squeak squeak', 1, 0, '2015-07-30', 1, '2015-07-30 14:42:45', 0, '', '', '0000-00-00', '1', '2'),
(13, 'test witness', 1, 0, '2015-07-30', 1, '2015-07-30 15:21:14', 0, '', '', '0000-00-00', '1', '2'),
(14, 'test more', 1, 0, '2015-07-30', 1, '2015-07-30 17:02:19', 0, '', '', '0000-00-00', '', ''),
(15, 'test activity july 30', 1, 0, '2015-07-30', 2, '2015-07-30 17:02:44', 0, '', '', '0000-00-00', '', ''),
(16, 'test august 3', 1, 0, '2015-08-03', 2, '2015-08-03 12:23:15', 0, '', '', '0000-00-00', '', ''),
(19, 'Incident August 04', 1, 0, '2015-08-04', 1, '2015-08-04 16:22:49', 0, '', '', '0000-00-00', '', ''),
(20, 'it''s over', 1, 0, '2015-08-04', 1, '2015-08-04 16:24:46', 0, '', '', '0000-00-00', '1', '3'),
(21, 'Oh yeah', 1, 0, '2015-08-04', 1, '2015-08-04 16:27:32', 0, '', '', '0000-00-00', '1', '2'),
(22, 'ibenta mo na', 1, 0, '2015-08-04', 2, '2015-08-04 17:25:43', 0, '', '', '0000-00-00', '', ''),
(23, 'OMG', 1, 0, '2015-08-05', 1, '2015-08-05 09:32:54', 0, '', '', '0000-00-00', '1', '3'),
(24, 'Boom Sabog', 1, 0, '2015-08-06', 1, '2015-08-06 09:33:11', 0, '', 'Case closed', '2015-09-21', '1', '2'),
(25, 'test - incident aug 18', 1, 0, '2015-08-18', 1, '2015-08-18 14:51:30', 5000, 'Not Applicable', 'Investigation finished. Case filed.', '2015-09-29', '9', '4'),
(26, 'RN Incident', 1, 0, '2015-09-02', 1, '2015-09-02 16:53:37', 0, '', 'yeah', '2015-09-29', '6', '3'),
(27, 'Activity Test Sept 3', 1, 0, '2015-09-03', 2, '2015-09-03 15:33:40', 0, '', '', '0000-00-00', '', ''),
(28, 'Fire', 1, 0, '2015-09-04', 1, '2015-09-04 10:44:55', 0, '', 'no way', '2015-09-30', '19', '2'),
(29, 'Example Incident', 1, 0, '2015-09-08', 1, '2015-09-08 15:06:30', 0, '', 'ok', '2015-09-30', '6', '2'),
(30, 'Activity!! Sept.15', 1, 0, '2015-09-15', 2, '2015-09-15 11:14:36', 0, '', '', '2015-09-29', '', ''),
(33, '1', 1, 0, '2015-09-29', 2, '2015-09-29 09:55:09', 0, '', '', '2015-09-30', '', ''),
(34, '2', 1, 0, '2015-09-30', 1, '2015-09-30 09:10:09', 0, '', 'wa', '2015-09-30', '8', '3'),
(35, '1', 1, 0, '2015-09-30', 1, '2015-09-30 09:27:36', 0, '', 'w', '2015-09-30', '12', '2'),
(36, '2', 1, 0, '2015-09-30', 1, '2015-09-30 09:31:09', 0, '', 'we', '2015-09-30', '5', '4'),
(37, '1', 1, 0, '2015-09-30', 1, '2015-09-30 09:36:04', 0, '', 'dfghj', '2015-09-30', '1', '4'),
(38, '1', 1, 0, '2015-09-30', 1, '2015-09-30 09:38:04', 0, '', 'waa', '2015-09-30', '9', '2'),
(39, '2', 1, 0, '2015-09-30', 1, '2015-09-30 09:43:24', 0, '', 'zzz', '2015-09-30', '2', '2'),
(40, '1', 1, 0, '2015-09-30', 1, '2015-09-30 10:01:13', 0, '', 'rty', '2015-09-30', '1', '2'),
(41, '2', 1, 0, '2015-09-30', 1, '2015-09-30 10:03:02', 5000, 'Not Applicable', 'It was resolved.', '2015-09-30', '9', '3'),
(42, '2', 1, 0, '2015-09-30', 1, '2015-09-30 15:56:36', 0, '', 'Yes', '2015-10-01', '2', '4'),
(43, '3', 1, 0, '2015-09-30', 2, '2015-09-30 15:56:46', 0, '', '', '2015-10-26', '', ''),
(44, '1', 1, 0, '2015-10-01', 1, '2015-10-01 11:51:08', 5000, 'Not Applicable', 'WQERTY', '2015-10-01', '5', '4'),
(45, '2', 1, 0, '2015-10-01', 1, '2015-10-01 11:52:52', 0, '', 'sdfghjkl', '2015-10-01', '9', '2'),
(46, '1', 1, 0, '2015-10-01', 1, '2015-10-01 11:56:06', 0, '', 'ASDFGHJKL', '2015-10-01', '9', '3'),
(47, '1', 1, 0, '2015-10-02', 2, '2015-10-02 15:04:03', 0, '', '', '2015-10-22', '', ''),
(48, '1', 1, 0, '2015-10-02', 2, '2015-10-02 15:31:03', 0, '', '', '2015-10-22', '', ''),
(49, '2', 1, 0, '2015-10-02', 1, '2015-10-02 17:15:51', 0, '', 'Ok sa allright', '2015-10-29', '12', '3'),
(50, '3', 1, 1, '2015-10-06', 1, '2015-10-06 11:24:50', 0, '', '', '0000-00-00', '16', '2'),
(51, '2', 1, 1, '2015-10-06', 1, '2015-10-06 11:38:42', 0, '', '', '0000-00-00', '1', '3'),
(52, '1', 1, 0, '2015-10-14', 2, '2015-10-14 18:38:25', 0, '', '', '2015-10-22', '', ''),
(53, '3', 1, 0, '2015-10-14', 2, '2015-10-14 18:38:54', 0, '', '', '2015-10-29', '', ''),
(54, '1', 1, 0, '2015-10-14', 2, '2015-10-14 18:41:39', 0, '', '', '2015-10-29', '', ''),
(55, '3', 1, 1, '2015-10-14', 2, '2015-10-14 18:41:43', 0, '', '', '0000-00-00', '', ''),
(56, '3', 1, 1, '2015-10-15', 2, '2015-10-15 15:33:31', 0, '', '', '0000-00-00', '', ''),
(57, '1', 1, 1, '2015-10-15', 2, '2015-10-15 15:33:38', 0, '', '', '0000-00-00', '', ''),
(58, '3', 1, 1, '2015-10-15', 2, '2015-10-15 15:36:46', 0, '', '', '0000-00-00', '', ''),
(59, '1', 1, 1, '2015-10-15', 2, '2015-10-15 15:36:53', 0, '', '', '0000-00-00', '', ''),
(60, '1', 4, 1, '2015-10-15', 2, '2015-10-15 16:15:08', 0, '', '', '0000-00-00', '', ''),
(61, '3', 1, 1, '2015-10-19', 2, '2015-10-19 16:01:35', 0, '', '', '0000-00-00', '', ''),
(62, '1', 1, 1, '2015-10-20', 2, '2015-10-20 16:42:10', 0, '', '', '0000-00-00', '', ''),
(63, '3', 1, 0, '2015-10-20', 2, '2015-10-20 16:49:13', 0, '', '', '2015-11-03', '', ''),
(64, '2', 1, 1, '2015-10-20', 1, '2015-10-20 16:51:05', 0, '', '', '0000-00-00', '', ''),
(65, '1', 1, 1, '2015-10-23', 1, '2015-10-23 10:21:22', NULL, NULL, NULL, NULL, '', ''),
(71, '4', 1, 0, '2015-11-18', 1, '2015-11-18 08:33:55', NULL, NULL, 'Case closed', '2015-11-18', '5', '4'),
(72, '3', 1, 0, '2015-11-18', 1, '2015-11-18 09:44:18', 5000, 'Loss Recovered', 'Filed police blatter', '2015-11-18', '2', '2'),
(73, '1', 1, 1, '2015-11-27', 2, '2015-11-27 09:16:53', NULL, NULL, NULL, NULL, NULL, NULL),
(74, '3', 1, 1, '2015-12-09', 2, '2015-12-09 09:04:52', NULL, NULL, NULL, NULL, NULL, NULL),
(75, '4', 1, 0, '2015-12-10', 1, '2015-12-10 18:09:35', NULL, NULL, 'It was tested', '2015-12-10', '17', '2');

-- --------------------------------------------------------

--
-- Table structure for table `urc_mst`
--

CREATE TABLE IF NOT EXISTS `urc_mst` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codes` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `series` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `urc_mst`
--

INSERT INTO `urc_mst` (`id`, `codes`, `description`, `series`) VALUES
(1, '10-20', 'Location', '10-00'),
(2, '10-4', 'Message Received', '10-00'),
(3, 'CODE 7', 'Meal Time', 'codes'),
(4, '10-33', 'Emergency', '10-00'),
(5, '10-8', 'In Service', '10-00'),
(6, '11-24', 'Abandoned Vehicle', '11-00'),
(7, '10-5', 'Relay Message', '10-00'),
(10, 'CLR', 'Clear', 'disposition'),
(11, 'Alpha', 'A', 'phonetic'),
(13, 'Bravo', 'B', 'phonetic'),
(14, 'Charlie', 'C', 'phonetic'),
(15, '10-99', 'The End', '10-00'),
(16, '11-99', 'It''s Over', '11-00'),
(17, 'CHK', 'Checked', 'disposition'),
(18, 'CODE 3', 'Emergency!!', 'codes'),
(20, 'CODE-10', 'He''s dead Jim.', 'codes'),
(21, 'Delta', 'D', 'phonetic'),
(22, '10-10', 'Noooo!!', '10-00'),
(24, '10-45', 'noo', '10-00'),
(25, '10-55', 'yess', '10-00'),
(26, '10-98', 'Almost There', '10-00');

-- --------------------------------------------------------

--
-- Table structure for table `users_mst`
--

CREATE TABLE IF NOT EXISTS `users_mst` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fname` varchar(100) NOT NULL,
  `mi` varchar(1) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `bu` bigint(20) NOT NULL,
  `level` varchar(15) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Active',
  `date_created` date NOT NULL,
  `gender` varchar(6) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `changepass` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `users_mst`
--

INSERT INTO `users_mst` (`id`, `fname`, `mi`, `lname`, `bu`, `level`, `email`, `password`, `status`, `date_created`, `gender`, `contact`, `changepass`) VALUES
(1, 'Super', 'S', 'Admin', 0, 'Super Admin', 'superadmin', '81dc9bdb52d04dc20036dbd8313ed055', 'Active', '2015-10-28', 'Female', '09212221111', 0),
(2, 'Test', 'T', 'User', 1, 'User', 'testuser', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'Active', '2015-08-17', 'Female', '09232323232', 0),
(3, 'Admin', 'A', 'Test', 1, 'Admin', 'admintest', '827ccb0eea8a706c4c34a16891f84e7b', 'Active', '2015-10-28', 'Male', '09334567890', 0),
(4, 'Bernardo', 'G', 'Rogelio', 4, 'User', 'brogelio', '74c4261e0cc749fe6173cea1b516c4da', 'Active', '2015-10-15', 'Male', '09992223333', 1),
(5, 'Super', 'P', 'Groot', 10, 'Admin', 'sgroot', '74c4261e0cc749fe6173cea1b516c4da', 'Active', '2015-10-28', 'Male', '09367856321', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
