-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2024 at 12:47 PM
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
-- Database: `users`
--

-- --------------------------------------------------------

--
-- Table structure for table `billing_clients`
--

CREATE TABLE `billing_clients` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `lane_address1` varchar(30) NOT NULL,
  `lane_address2` varchar(30) NOT NULL,
  `pincode` varchar(30) NOT NULL,
  `state` varchar(30) NOT NULL,
  `gst` varchar(30) NOT NULL,
  `added_by` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `billing_clients`
--

INSERT INTO `billing_clients` (`id`, `name`, `lane_address1`, `lane_address2`, `pincode`, `state`, `gst`, `added_by`) VALUES
(8, 'omdatt sharma', 'tirupati complex sector 36 ', 'kaothe', '410209', 'Maharashtra', '1234', 'akash'),
(9, 'akash sharma', 'tirupati complex sector 36 ', 'kaothe', '410209', 'Maharashtra', '1234', 'akash');

-- --------------------------------------------------------

--
-- Table structure for table `bill_generated`
--

CREATE TABLE `bill_generated` (
  `id` int(11) NOT NULL,
  `companyname` varchar(30) NOT NULL,
  `date` varchar(30) NOT NULL,
  `bill_to_client` varchar(30) NOT NULL,
  `ship_to_client` varchar(30) NOT NULL,
  `asset_code` varchar(30) NOT NULL,
  `asset_code_make` varchar(30) NOT NULL,
  `ac_model` varchar(30) NOT NULL,
  `ac_sub_type` varchar(30) NOT NULL,
  `reg_no` varchar(30) NOT NULL,
  `billing_month` varchar(30) NOT NULL,
  `start_date` varchar(30) NOT NULL,
  `end_date` varchar(30) NOT NULL,
  `sac` varchar(30) NOT NULL,
  `uom` varchar(30) NOT NULL,
  `rate` varchar(30) NOT NULL,
  `qty` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bill_generated`
--

INSERT INTO `bill_generated` (`id`, `companyname`, `date`, `bill_to_client`, `ship_to_client`, `asset_code`, `asset_code_make`, `ac_model`, `ac_sub_type`, `reg_no`, `billing_month`, `start_date`, `end_date`, `sac`, `uom`, `rate`, `qty`) VALUES
(11, 'akash', '2024-05-18', 'akash sharma', 'omdatt sharma', '1', 'Bauer', '12', 'Concrete Boom Placer', '1213', 'February', '2024-02-01', '2024-02-29', '23567', 'Days', '18000.23', '29'),
(12, 'akash', '', 'akash sharma', 'omdatt sharma', '1', 'Bharat Benz', '12', 'Concrete Boom Placer', '1213', 'January', '2024-01-01', '2024-01-31', '23567', 'Hours', '18000', '29'),
(14, 'akash', '2024-06-25', 'akash sharma', 'omdatt sharma', '1', 'Bharat Benz', '12', 'Concrete Boom Placer', '1213', 'March', '2024-03-01', '2024-03-31', '23567', 'Days', '18000', '29'),
(15, 'akash', '2024-06-25', 'akash sharma', 'akash sharma', '1', 'Bharat Benz', '12', 'Concrete Boom Placer', '1213', 'April', '2024-04-01', '2024-04-30', '23567', 'Days', '18000', '26'),
(16, 'akash', '2024-06-25', 'akash sharma', 'akash sharma', '1', 'Bharat Benz', '12', 'Concrete Boom Placer', '1213', 'April', '2024-04-01', '2024-04-30', '23567', 'Days', '18000', '26');

-- --------------------------------------------------------

--
-- Table structure for table `brkdown_log`
--

CREATE TABLE `brkdown_log` (
  `id` int(11) NOT NULL,
  `date` varchar(30) NOT NULL,
  `asset_code` varchar(30) NOT NULL,
  `asset_make` varchar(30) NOT NULL,
  `equipment` varchar(30) NOT NULL,
  `model` varchar(30) NOT NULL,
  `brkdown_hour` varchar(30) NOT NULL,
  `reason` varchar(50) NOT NULL,
  `operator_name` varchar(30) NOT NULL,
  `companyname` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brkdown_log`
--

INSERT INTO `brkdown_log` (`id`, `date`, `asset_code`, `asset_make`, `equipment`, `model`, `brkdown_hour`, `reason`, `operator_name`, `companyname`) VALUES
(11, '', '1', 'Bharat Benz', 'Concrete Boom Placer', '12', '111', '', 'akash sharma', 'akash');

-- --------------------------------------------------------

--
-- Table structure for table `closed_requirement_epc_latest`
--

CREATE TABLE `closed_requirement_epc_latest` (
  `id` int(11) NOT NULL,
  `equipment_type` varchar(50) NOT NULL,
  `equipment_capacity` varchar(30) NOT NULL,
  `boom_combination` varchar(30) NOT NULL,
  `project_type` varchar(30) NOT NULL,
  `duration_month` varchar(30) NOT NULL,
  `state` varchar(30) NOT NULL,
  `district` varchar(30) NOT NULL,
  `working_shift` varchar(30) NOT NULL,
  `tentative_date` varchar(30) NOT NULL,
  `epc_name` varchar(30) NOT NULL,
  `epc_email` varchar(30) NOT NULL,
  `epc_number` varchar(30) NOT NULL,
  `fleet_category` varchar(40) NOT NULL,
  `contact_person` varchar(30) NOT NULL,
  `engine_hour` varchar(30) NOT NULL,
  `notes` longtext NOT NULL,
  `unit` varchar(30) NOT NULL,
  `project_code` varchar(30) NOT NULL,
  `fuel_scope` varchar(30) NOT NULL,
  `accomodation_scope` varchar(30) NOT NULL,
  `platform` varchar(30) NOT NULL,
  `vendor` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `closed_requirement_epc_latest`
--

INSERT INTO `closed_requirement_epc_latest` (`id`, `equipment_type`, `equipment_capacity`, `boom_combination`, `project_type`, `duration_month`, `state`, `district`, `working_shift`, `tentative_date`, `epc_name`, `epc_email`, `epc_number`, `fleet_category`, `contact_person`, `engine_hour`, `notes`, `unit`, `project_code`, `fuel_scope`, `accomodation_scope`, `platform`, `vendor`) VALUES
(2, 'Batching Plant', '45', '2', 'Road', '12', 'Assam', 'w', 'Single', '2024-04-11', 'akash epc', 'epc', '07700022497', 'Concrete Equipment', 'akash', '', 'qded', 'Meter', '1', 'Service Provider', 'Service Provider', 'Fleet EIP', 'abcd rental'),
(3, 'Excavator', '45', '2', 'Marine', '12', 'Assam', 'w', 'Flexi Single', '2024-04-11', 'akash epc', 'epc', '07700022497', 'EarthMovers and Road Equipments

', 'akash', '312', 'none', 'Ton', '1', 'EPC Scope', 'EPC Scope', 'Fleet EIP', 'akash'),
(4, 'Hydraulic Crawler Crane', '45', '2', 'PipeLine', '12', 'Assam', 'w', 'Double', '2024-04-04', 'akash epc', 'epc', '07700022497', 'Material Handling Equipments', 'akash', '300', 'none', 'Meter', '1', 'Service Provider', 'Service Provider', 'Fleet EIP', 'q'),
(5, 'Bulldozer', '45', '2', 'PipeLine', '12', 'Assam', 'w', 'Single', '2024-04-25', 'akash epc', 'epc', '07700022497', 'EarthMovers and Road Equipments

', 'akash', '', 'none', 'Meter', '1', 'EPC Scope', 'EPC Scope', 'Fleet EIP', 'abcd rental'),
(6, 'Self Propelled Articulated Boomlift', '45', '2', 'Marine', '12', 'Assam', 'w', 'Single', '2024-04-04', 'akash epc', 'epc', '07700022497', 'Aerial Work Platform', 'akash', '', 'none', 'Meter', '1', 'EPC Scope', 'EPC Scope', 'Fleet EIP', 'abcd rental'),
(7, 'Concrete Boom Placer', '1', '1', 'PipeLine', '1', 'Goa', '1', 'Double', '2024-05-14', 'akash epc', 'epc', '1', 'Concrete Equipment', '1', '312', 'dsda', 'Ton', '12', 'Service Provider', 'Service Provider', 'Other Platform', 'none'),
(8, 'Self Propelled Articulated Boomlift', '101', '4', 'Road', '24', 'Maharashtra', 'raigad', 'Single', '2024-05-16', 'akash epc', 'epc', '7700022497', 'Aerial Work Platform', 'omdutt sharma', '', 'none', 'Ton', '121', 'EPC Scope', 'EPC Scope', 'Other Platform', 'none'),
(9, 'Concrete Boom Placer', '50', '3', 'Urban Infra', '12', 'Maharashtra', 'raigad', 'Single', '2024-06-07', 'epc', 'epc', '7718003747', 'Concrete Equipment', 'raj sharma', '', 'none', 'Ton', '410209', 'EPC Scope', 'EPC Scope', 'Fleet EIP', 'akash'),
(10, 'Bulldozer', '30', '3', 'PipeLine', '24', 'Haryana', 'sonipat', 'Single', '2024-06-24', 'epc', 'epc', '7700022497', 'EarthMovers and Road Equipments

', 'akash sharma', '', 'yom not less then 2012', 'Ton', '212', 'EPC Scope', 'Service Provider', 'Other Platform', 'none'),
(11, 'Skid Loader', '23', '2', 'Urban Infra', '36', 'Madhya Pradesh', 'raigad', 'Single', '2024-06-12', 'epc', 'epc', '7718003747', 'EarthMovers and Road Equipments

', 'om sharma', '', 'none', 'Ton', '232141', 'Service Provider', 'EPC Scope', 'Other Platform', 'none'),
(12, 'Rotary Drilling Rig', '21', '2', 'Bridge And Metro', '12', 'Goa', 'goa district', 'Single', '2024-06-19', 'epc', 'epc', '7700022497', 'Ground Engineering Equipments', 'akash sharma', '', 'none', 'Ton', '1', 'EPC Scope', 'Service Provider', 'Other Platform', 'none'),
(13, 'Silent Diesel Generator', '20', '2', 'Marine', '12', 'Madhya Pradesh', 'navi mumbai', 'Single', '2024-06-25', 'epc', 'epc', '39031293', 'Generator and Lighting', 'akshay sharma', '', 'jnfkasf', 'Ton', '7700022', 'EPC Scope', 'EPC Scope', 'Other Platform', 'none'),
(14, 'Scissor Lift Diesel', '12', '2', 'Plant', '36', 'Gujarat', 'ahmedabad', 'Single', '2024-06-19', 'epc', 'epc', '35r7498483927', 'Aerial Work Platform', 'peehu sharma', '', 'none', 'Ton', '1', 'EPC Scope', 'EPC Scope', 'Other Platform', 'none'),
(15, 'Moli Pump', '30', '2', 'Urban Infra', '12', 'Karnataka', 'kr district', 'Single', '2024-06-13', 'epc', 'epc', '7700022497', 'Concrete Equipment', 'raj sharma', '', 'none', 'Ton', '1', 'EPC Scope', 'EPC Scope', 'Other Platform', 'none');

-- --------------------------------------------------------

--
-- Table structure for table `commercial_rmc_req_by_epc`
--

CREATE TABLE `commercial_rmc_req_by_epc` (
  `id` int(11) NOT NULL,
  `project_code` varchar(20) NOT NULL,
  `project_name` varchar(50) NOT NULL,
  `project_type` varchar(40) NOT NULL,
  `project_location` varchar(40) NOT NULL,
  `site_pincode` varchar(10) NOT NULL,
  `date_of_requirement` varchar(20) NOT NULL,
  `completion_time` varchar(20) NOT NULL,
  `month_days` varchar(10) NOT NULL,
  `tm_qty_req` varchar(30) NOT NULL,
  `notes_for_vendor` mediumtext NOT NULL,
  `pouring_equipment` varchar(30) NOT NULL,
  `no_of_pouring_equipment` varchar(30) NOT NULL,
  `grade1` varchar(30) NOT NULL,
  `grade2` varchar(30) NOT NULL,
  `grade3` varchar(30) NOT NULL,
  `grade4` varchar(30) NOT NULL,
  `grade5` varchar(30) NOT NULL,
  `quantity1` varchar(30) NOT NULL,
  `quantity2` varchar(30) NOT NULL,
  `quantity3` varchar(30) NOT NULL,
  `quantity4` varchar(30) NOT NULL,
  `quantity5` varchar(30) NOT NULL,
  `cement_qty1` varchar(30) NOT NULL,
  `cement_qty2` varchar(30) NOT NULL,
  `cement_qty3` varchar(30) NOT NULL,
  `cement_qty4` varchar(30) NOT NULL,
  `cement_qty5` varchar(30) NOT NULL,
  `fly_ash1` varchar(30) NOT NULL,
  `fly_ash2` varchar(30) NOT NULL,
  `fly_ash3` varchar(30) NOT NULL,
  `fly_ash4` varchar(30) NOT NULL,
  `fly_ash5` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complete_profile`
--

CREATE TABLE `complete_profile` (
  `id` int(11) NOT NULL,
  `letter_head` varchar(30) NOT NULL,
  `bank_name` varbinary(30) NOT NULL,
  `account_num` varchar(30) NOT NULL,
  `branch` varchar(30) NOT NULL,
  `ifsc_code` varchar(30) NOT NULL,
  `account_type` varchar(30) NOT NULL,
  `companyname` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complete_profile`
--

INSERT INTO `complete_profile` (`id`, `letter_head`, `bank_name`, `account_num`, `branch`, `ifsc_code`, `account_type`, `companyname`) VALUES
(5, 'sign.jpg', 0x617869732062616e6b, '62064031546', 'kamothe', '', 'Savings', 'akash');

-- --------------------------------------------------------

--
-- Table structure for table `dl_expiry`
--

CREATE TABLE `dl_expiry` (
  `sno` int(11) NOT NULL,
  `driver_name` varchar(50) NOT NULL,
  `dl` varchar(50) NOT NULL,
  `expiry_date` varchar(30) NOT NULL,
  `days_left` varchar(30) NOT NULL,
  `company_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dl_expiry`
--

INSERT INTO `dl_expiry` (`sno`, `driver_name`, `dl`, `expiry_date`, `days_left`, `company_name`) VALUES
(246, 'akash ', '10101', '2024-06-19', '-8', 'akash'),
(249, 'akash ', '10101', '2024-06-19', '-10', 'akash'),
(257, 'akash ', '10101', '2024-06-19', '-11', 'akash');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `snum` int(11) NOT NULL,
  `emailid` varchar(30) NOT NULL,
  `mobno` int(30) NOT NULL,
  `feedback` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`snum`, `emailid`, `mobno`, `feedback`) VALUES
(1, '', 0, ''),
(2, '', 0, ''),
(3, '', 0, ''),
(4, '', 0, ''),
(5, '', 0, ''),
(6, 'akash', 349830, 'dnmdbnddbvmsdvhbv'),
(7, 'akash', 349830, 'dnmdbnddbvmsdvhbv'),
(8, 'sxas', 0, 'sxasx');

-- --------------------------------------------------------

--
-- Table structure for table `fleet`
--

CREATE TABLE `fleet` (
  `sno` int(11) NOT NULL,
  `make` varchar(22) NOT NULL,
  `model` varchar(22) NOT NULL,
  `chassis` varchar(22) NOT NULL,
  `email` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `yom` varchar(30) NOT NULL,
  `capacity` varchar(30) NOT NULL,
  `registration` varchar(40) NOT NULL,
  `engine` varchar(40) NOT NULL,
  `boom_length` varchar(30) NOT NULL,
  `jib_length` varchar(30) NOT NULL,
  `luffing_length` varchar(30) NOT NULL,
  `diesel_tank_capacity` varchar(30) NOT NULL,
  `hydraulic_oil_tank` varchar(30) NOT NULL,
  `engine_oil_capacity` varchar(30) NOT NULL,
  `engine_oil_grade` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL,
  `hydraulic_oil_grade` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fleet`
--

INSERT INTO `fleet` (`sno`, `make`, `model`, `chassis`, `email`, `type`, `yom`, `capacity`, `registration`, `engine`, `boom_length`, `jib_length`, `luffing_length`, `diesel_tank_capacity`, `hydraulic_oil_tank`, `engine_oil_capacity`, `engine_oil_grade`, `status`, `hydraulic_oil_grade`) VALUES
(548, 'a', 'a', 'a', 'latika', 'Telescopic', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'Working', 'a'),
(550, 'crane2', 'crane2', '', 'latika', '', '', '', '', '', '', '', '', '', '', '', '', 'Idle', ''),
(552, 'b', 'b', 'b', 'latika', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `fleet1`
--

CREATE TABLE `fleet1` (
  `snum` int(11) NOT NULL,
  `companyname` varchar(30) NOT NULL,
  `category` varchar(50) NOT NULL,
  `sub_type` varchar(50) NOT NULL,
  `make` varchar(30) NOT NULL,
  `other_make` varchar(30) NOT NULL,
  `model` varchar(30) NOT NULL,
  `assetcode` varchar(30) NOT NULL,
  `chassis` varchar(30) NOT NULL,
  `other_chassis` varchar(30) NOT NULL,
  `chassis_number` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `yom` varchar(30) NOT NULL,
  `capacity` varchar(30) NOT NULL,
  `unit` varchar(10) NOT NULL,
  `registration` varchar(30) NOT NULL,
  `engine` varchar(30) NOT NULL,
  `boom_length` varchar(30) NOT NULL,
  `jib_length` varchar(30) NOT NULL,
  `luffing_length` varchar(30) NOT NULL,
  `diesel_tank_capacity` varchar(30) NOT NULL,
  `hydraulic_oil_tank` varchar(30) NOT NULL,
  `engine_oil_capacity` varchar(30) NOT NULL,
  `engine_oil_grade` varchar(30) NOT NULL,
  `hydraulic_oil_grade` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  `workorder` varchar(30) NOT NULL,
  `client_name` varchar(40) NOT NULL,
  `project_name` varchar(50) NOT NULL,
  `project_location` varchar(40) NOT NULL,
  `hour_shift` varchar(30) NOT NULL,
  `workorder_valid` varchar(30) NOT NULL,
  `rc_valid` varchar(30) NOT NULL,
  `fc_valid` varchar(30) NOT NULL,
  `insaurance_valid` varchar(30) NOT NULL,
  `np_valid` varchar(30) NOT NULL,
  `operator_fname` varchar(30) NOT NULL,
  `operator_lname` varchar(30) NOT NULL,
  `date_time` varchar(30) NOT NULL DEFAULT current_timestamp(),
  `rental_charges_wo` int(40) NOT NULL,
  `shift_wo` varchar(30) NOT NULL,
  `ot_charges` varchar(30) NOT NULL,
  `working_days_in_month` varchar(30) NOT NULL,
  `condition_sundays` varchar(30) NOT NULL,
  `fuel_norms` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fleet1`
--

INSERT INTO `fleet1` (`snum`, `companyname`, `category`, `sub_type`, `make`, `other_make`, `model`, `assetcode`, `chassis`, `other_chassis`, `chassis_number`, `email`, `type`, `yom`, `capacity`, `unit`, `registration`, `engine`, `boom_length`, `jib_length`, `luffing_length`, `diesel_tank_capacity`, `hydraulic_oil_tank`, `engine_oil_capacity`, `engine_oil_grade`, `hydraulic_oil_grade`, `status`, `workorder`, `client_name`, `project_name`, `project_location`, `hour_shift`, `workorder_valid`, `rc_valid`, `fc_valid`, `insaurance_valid`, `np_valid`, `operator_fname`, `operator_lname`, `date_time`, `rental_charges_wo`, `shift_wo`, `ot_charges`, `working_days_in_month`, `condition_sundays`, `fuel_norms`) VALUES
(102, 'akash', 'Concrete Equipment', 'Concrete Boom Placer', 'Putzmeister', '', 'M36-4', '1', 'TATA', '', '', '', '', '2022', '36', 'Meter', 'MH46BK3152', '', '', '', '', '', '', '', '', '', 'Working', 'yes', 'akash sharma', 'Ganga express way', 'raebareli', '12', '2024-12-30', '2024-06-30', '2024-06-30', '2024-06-30', '2024-06-28', '', '', '2024-05-06 15:20:27', 420000, 'Single', '100', '28', 'Excluding Sunday', '10');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `companyname` varchar(30) NOT NULL,
  `category` varchar(30) NOT NULL,
  `sub_type` varchar(50) NOT NULL,
  `kmr` varchar(20) NOT NULL,
  `hmr` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `price` varchar(40) NOT NULL,
  `contact_no` varchar(50) NOT NULL,
  `front_pic` varchar(300) NOT NULL,
  `left_side_pic` varchar(300) NOT NULL,
  `right_side_pic` varchar(300) NOT NULL,
  `pic4` varchar(300) NOT NULL,
  `pic5` varchar(300) NOT NULL,
  `model` varchar(30) NOT NULL,
  `make` varchar(30) NOT NULL,
  `capacity` varchar(30) NOT NULL,
  `unit` varchar(30) NOT NULL,
  `yom` varchar(30) NOT NULL,
  `location` varchar(30) NOT NULL,
  `boomlength` varchar(30) NOT NULL,
  `jiblength` varchar(30) NOT NULL,
  `luffinglength` varchar(30) NOT NULL,
  `description` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `companyname`, `category`, `sub_type`, `kmr`, `hmr`, `email`, `price`, `contact_no`, `front_pic`, `left_side_pic`, `right_side_pic`, `pic4`, `pic5`, `model`, `make`, `capacity`, `unit`, `yom`, `location`, `boomlength`, `jiblength`, `luffinglength`, `description`) VALUES
(59, 'akash', 'Aerial Work Platform', 'Self Propelled Articulated Boomlift', 'kmr', 'hmr', 'akashrental', 'price', 'num', 'IMG-66701f0321f586.72180822.png', 'IMG-66701f03221042.01284757.png', 'IMG-66701f03222730.67247941.png', 'none', 'none', 'model', 'make', 'cap', '', 'yom', 'loc', '', '', '', 'desc'),
(60, 'akash', 'Material Handling Equipments', 'Hydraulic Crawler Crane', '', '3000', 'akashrental', '160000000', '07700022497', 'IMG-6677f223912e98.85108815.png', 'IMG-6677f223917e57.08250411.png', 'IMG-6677f223919dc6.19085065.png', 'none', 'none', 'xgc800', 'xcmg', '800', 'disabled selected', '2023', 'tirchy', '147', '12', 'na', 'description');

-- --------------------------------------------------------

--
-- Table structure for table `insaurance_notification`
--

CREATE TABLE `insaurance_notification` (
  `sno` int(11) NOT NULL,
  `document_expiring` varchar(30) NOT NULL,
  `valid_till` varchar(30) NOT NULL,
  `company_name` varchar(30) NOT NULL,
  `days_left` varchar(30) NOT NULL,
  `asset_code` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `insaurance_notification`
--

INSERT INTO `insaurance_notification` (`sno`, `document_expiring`, `valid_till`, `company_name`, `days_left`, `asset_code`) VALUES
(1851, 'Insaurance', '2024-06-30', 'akash', '1', '1'),
(1852, 'Registration certificate', '2024-06-30', 'akash', '1', '1'),
(1853, 'Fitness Certificate', '2024-06-30', 'akash', '1', '1'),
(1854, 'National Permit', '2024-06-28', 'akash', '-1', '1'),
(1883, 'Insaurance', '2024-06-30', 'akash', '0', '1'),
(1884, 'Registration certificate', '2024-06-30', 'akash', '0', '1'),
(1885, 'Fitness Certificate', '2024-06-30', 'akash', '0', '1'),
(1886, 'National Permit', '2024-06-28', 'akash', '-2', '1');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `sno` int(11) NOT NULL,
  `email` varchar(30) DEFAULT NULL,
  `username` varchar(30) NOT NULL,
  `added_by` varchar(30) NOT NULL,
  `designation` varchar(30) NOT NULL,
  `password` varchar(30) DEFAULT NULL,
  `companyname` varchar(50) DEFAULT NULL,
  `company_address` varchar(30) NOT NULL,
  `compnay_pincode` varchar(30) NOT NULL,
  `gst` varchar(30) DEFAULT NULL,
  `gst_certificate` varchar(200) NOT NULL,
  `pancard` varchar(30) DEFAULT NULL,
  `pan_card_photo` varchar(200) NOT NULL,
  `contactnumber` varchar(30) DEFAULT NULL,
  `comp_web` varchar(30) NOT NULL,
  `webiste_address` varchar(30) NOT NULL,
  `enterprise` varchar(30) NOT NULL,
  `add_on_services` varchar(50) NOT NULL,
  `rmc_type` varchar(30) NOT NULL,
  `rmc_location` varchar(30) NOT NULL,
  `rmc_pincode` varchar(30) NOT NULL,
  `code` int(11) DEFAULT NULL,
  `status` varchar(30) DEFAULT 'notverified',
  `time` varchar(11) DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`sno`, `email`, `username`, `added_by`, `designation`, `password`, `companyname`, `company_address`, `compnay_pincode`, `gst`, `gst_certificate`, `pancard`, `pan_card_photo`, `contactnumber`, `comp_web`, `webiste_address`, `enterprise`, `add_on_services`, `rmc_type`, `rmc_location`, `rmc_pincode`, `code`, `status`, `time`) VALUES
(80, 'akashrental', 'akash', '', '', '1234', 'akash', 'B301 Roman Court Sector 61 Kun', '131023', '06CBIPS9819L1ZT', '', 'CBIPS9819', '', '9326178925', 'yes', 'urbcorp.in', 'rental', 'RMC Plant And Foundation Work', 'Dedicated', 'navi mumabi', '410209', NULL, 'verified', '2024-03-30 '),
(137, 'epc', 'akashepc', '', '', '1234', 'epc', 'asd', 'as', 'dsf', '2017-01-31-17-57-52-859.jpg', 'sdasd', '2017-01-31-15-23-13-169.jpg', '2837912', 'No', '', 'epc', 'None', 'None', '', '', NULL, 'notverified', '2024-06-06 '),
(138, 'support@fleeteip.com', 'fleeteip', '', '', 'fleetEIP@0807', 'FleetEIP', '', '', NULL, '', NULL, '', NULL, '', '', 'admin', '', '', '', '', NULL, 'notverified', 'current_tim'),
(142, 'akash.s0167@gmail.com', 'akash12', '', '', '1234', 'URB Corporation', 'B301 Roman Court Sector 61 Kun', '131023', 'fdsfsdf', 'SAMPLE PAN.png', 'sad', '', '09326178925', 'No', '', 'logistics', 'None', 'None', '', '', NULL, 'notverified', '2024-06-28 '),
(157, 'vishal32saini@gmail.com', 'vishu', '', '', '1234', 'hbk', 'kbk', 'bjkjb', 'nb', 'SAMPLE PAN.png', 'dasd', '', 'bkj', 'No', '', 'rental', 'None', 'None', '', '', 0, 'verified', '2024-06-29 ');

-- --------------------------------------------------------

--
-- Table structure for table `logistics_need`
--

CREATE TABLE `logistics_need` (
  `id` int(11) NOT NULL,
  `email_need_generator` varchar(30) NOT NULL,
  `company_number` varchar(30) NOT NULL,
  `companyname_need_generator` varchar(30) NOT NULL,
  `material_detail` varchar(30) NOT NULL,
  `type_of_requirement` varchar(30) NOT NULL,
  `trailor_type1` varchar(30) NOT NULL,
  `length1` varchar(30) NOT NULL,
  `width1` varchar(30) NOT NULL,
  `height1` varchar(30) NOT NULL,
  `weight1` varchar(30) NOT NULL,
  `from` varchar(30) NOT NULL,
  `from_pincode` varchar(30) NOT NULL,
  `to` varchar(30) NOT NULL,
  `to_pincode` varchar(30) NOT NULL,
  `payment_terms` varchar(30) NOT NULL,
  `price_quoted` varchar(30) NOT NULL,
  `number_of_trailor` int(11) NOT NULL,
  `trailor2` int(11) NOT NULL,
  `trailor3` int(11) NOT NULL,
  `trailor4` int(11) NOT NULL,
  `trailor5` int(11) NOT NULL,
  `trailor6` int(11) NOT NULL,
  `trailor7` int(11) NOT NULL,
  `trailor8` int(11) NOT NULL,
  `trailor9` int(11) NOT NULL,
  `trailor10` int(11) NOT NULL,
  `length2` int(11) NOT NULL,
  `length3` int(11) NOT NULL,
  `length4` int(11) NOT NULL,
  `length5` int(11) NOT NULL,
  `length6` int(11) NOT NULL,
  `length7` int(11) NOT NULL,
  `length8` int(11) NOT NULL,
  `length9` int(11) NOT NULL,
  `length10` int(11) NOT NULL,
  `width2` int(11) NOT NULL,
  `width3` int(11) NOT NULL,
  `width4` int(11) NOT NULL,
  `width5` int(11) NOT NULL,
  `width6` int(11) NOT NULL,
  `width7` int(11) NOT NULL,
  `width8` int(11) NOT NULL,
  `width9` int(11) NOT NULL,
  `width10` int(11) NOT NULL,
  `height2` int(11) NOT NULL,
  `height3` int(11) NOT NULL,
  `height4` int(11) NOT NULL,
  `height5` int(11) NOT NULL,
  `height6` int(11) NOT NULL,
  `height7` int(11) NOT NULL,
  `height8` int(11) NOT NULL,
  `height9` int(11) NOT NULL,
  `height10` int(11) NOT NULL,
  `weight2` int(11) NOT NULL,
  `weight3` int(11) NOT NULL,
  `weight4` int(11) NOT NULL,
  `weight5` int(11) NOT NULL,
  `weight6` int(11) NOT NULL,
  `weight7` int(11) NOT NULL,
  `weight8` int(11) NOT NULL,
  `weight9` int(11) NOT NULL,
  `weight10` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logistics_need`
--

INSERT INTO `logistics_need` (`id`, `email_need_generator`, `company_number`, `companyname_need_generator`, `material_detail`, `type_of_requirement`, `trailor_type1`, `length1`, `width1`, `height1`, `weight1`, `from`, `from_pincode`, `to`, `to_pincode`, `payment_terms`, `price_quoted`, `number_of_trailor`, `trailor2`, `trailor3`, `trailor4`, `trailor5`, `trailor6`, `trailor7`, `trailor8`, `trailor9`, `trailor10`, `length2`, `length3`, `length4`, `length5`, `length6`, `length7`, `length8`, `length9`, `length10`, `width2`, `width3`, `width4`, `width5`, `width6`, `width7`, `width8`, `width9`, `width10`, `height2`, `height3`, `height4`, `height5`, `height6`, `height7`, `height8`, `height9`, `height10`, `weight2`, `weight3`, `weight4`, `weight5`, `weight6`, `weight7`, `weight8`, `weight9`, `weight10`) VALUES
(24, 'akash.s0167@gmail.com', '07700022497', 'akash rental', 'pipes', 'Budgeting', 'LBT', '46', '1', '1', '12', 'mumbai', '32341', 'jfvnfj', '34322', 'Credit 30 Days', '', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `logi_price_quoted`
--

CREATE TABLE `logi_price_quoted` (
  `id` int(11) NOT NULL,
  `req_no` varchar(11) NOT NULL,
  `requirement_company_email` varchar(30) NOT NULL,
  `requirement_company_name` varchar(30) NOT NULL,
  `requirement_company_number` varchar(30) NOT NULL,
  `material_detail` varchar(30) NOT NULL,
  `type_of_requirement` varchar(30) NOT NULL,
  `trailor_type` varchar(30) NOT NULL,
  `length` varchar(30) NOT NULL,
  `width` varchar(30) NOT NULL,
  `height` varchar(30) NOT NULL,
  `weight` varchar(30) NOT NULL,
  `from_location` varchar(30) NOT NULL,
  `from_pincode` varchar(30) NOT NULL,
  `to_location` varchar(30) NOT NULL,
  `to_pincode` varchar(30) NOT NULL,
  `payment_terms` varchar(30) NOT NULL,
  `quote_price` varchar(30) NOT NULL,
  `logistic_company_name` varchar(30) NOT NULL,
  `logistic_company_number` varchar(30) NOT NULL,
  `logistic_company_email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logi_price_quoted`
--

INSERT INTO `logi_price_quoted` (`id`, `req_no`, `requirement_company_email`, `requirement_company_name`, `requirement_company_number`, `material_detail`, `type_of_requirement`, `trailor_type`, `length`, `width`, `height`, `weight`, `from_location`, `from_pincode`, `to_location`, `to_pincode`, `payment_terms`, `quote_price`, `logistic_company_name`, `logistic_company_number`, `logistic_company_email`) VALUES
(15, '9', 'rental', 'akash rental', '7700022497', 'box', 'Immediate', 'LBT', '20', '20', '10', '30ton', 'kamothe', '410210', 'delhi', '131023', 'Credit 30 Days', '120000', 'akash logistic', '8097772622', 'logistic'),
(16, '9', 'rental', 'akash rental', '7700022497', 'box', 'Immediate', 'LBT', '20', '20', '10', '30ton', 'kamothe', '410210', 'delhi', '131023', 'Credit 30 Days', '115000', 'logi123', '9004559751', 'logi'),
(17, '24', 'akash.s0167@gmail.com', 'akash rental', '07700022497', 'pipes', 'Budgeting', '0', '0', '0', '0', '0', 'mumbai', '32341', 'jfvnfj', '34322', 'Credit 30 Days', '204834340', 'akash logi', '42343142', 'logi');

-- --------------------------------------------------------

--
-- Table structure for table `logsheet`
--

CREATE TABLE `logsheet` (
  `id` int(11) NOT NULL,
  `assetcode` varchar(30) NOT NULL,
  `hours_shift` varchar(30) NOT NULL,
  `operator_name` varchar(40) NOT NULL,
  `asset_id` varchar(30) NOT NULL,
  `make` varchar(30) NOT NULL,
  `model` varchar(30) NOT NULL,
  `equipment` varchar(30) NOT NULL,
  `date` varchar(30) NOT NULL,
  `shift` varchar(30) NOT NULL,
  `start_time` int(30) NOT NULL,
  `unit1` varchar(30) NOT NULL,
  `close_time` int(30) NOT NULL,
  `unit2` varchar(30) NOT NULL,
  `start_hmr` int(30) NOT NULL,
  `closed_hmr` int(30) NOT NULL,
  `start_km` int(30) NOT NULL,
  `closed_km` int(30) NOT NULL,
  `fuel_taken` varchar(30) NOT NULL,
  `engineer_name` varchar(30) NOT NULL,
  `night_shift_operator` varchar(30) NOT NULL,
  `night_shift_engineer` varchar(30) NOT NULL,
  `night_start_time` int(30) NOT NULL,
  `night_close_time` int(30) NOT NULL,
  `unit1_night` varchar(30) NOT NULL,
  `unit2_night` varchar(30) NOT NULL,
  `night_start_hmr` int(30) NOT NULL,
  `night_close_hmr` int(30) NOT NULL,
  `night_start_km` int(30) NOT NULL,
  `night_close_km` int(30) NOT NULL,
  `remark` varchar(30) NOT NULL,
  `companyname` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logsheet`
--

INSERT INTO `logsheet` (`id`, `assetcode`, `hours_shift`, `operator_name`, `asset_id`, `make`, `model`, `equipment`, `date`, `shift`, `start_time`, `unit1`, `close_time`, `unit2`, `start_hmr`, `closed_hmr`, `start_km`, `closed_km`, `fuel_taken`, `engineer_name`, `night_shift_operator`, `night_shift_engineer`, `night_start_time`, `night_close_time`, `unit1_night`, `unit2_night`, `night_start_hmr`, `night_close_hmr`, `night_start_km`, `night_close_km`, `remark`, `companyname`) VALUES
(112, '1', '12 ', 'akash sharma', '102', 'Bharat Benz', '12', 'Concrete Boom Placer', '2024-05-05', 'Single', 5, 'AM', 5, 'PM', 78, 79, 120, 121, '', '', '', '', 0, 0, '', '', 0, 0, 0, 0, '', 'akash'),
(113, '1', '12 ', 'akash sharma', '102', 'Bharat Benz', '12', 'Concrete Boom Placer', '2024-05-21', 'Single', 5, 'AM', 5, 'PM', 78, 78, 120, 120, '', '', '', '', 0, 0, '', '', 0, 0, 0, 0, '', 'akash'),
(115, '1', '12 ', 'akash sharma', '102', 'Bharat Benz', '12', 'Concrete Boom Placer', '2024-05-24', '', 5, 'AM', 5, 'PM', 78, 79, 120, 132, '', '', '', '', 0, 0, '', '', 0, 0, 0, 0, '', 'akash');

-- --------------------------------------------------------

--
-- Table structure for table `myoperators`
--

CREATE TABLE `myoperators` (
  `id` int(30) NOT NULL,
  `operator_fname` varchar(30) NOT NULL,
  `designation` varchar(30) NOT NULL,
  `company_name` varchar(30) NOT NULL,
  `startdate_crnt_company` varchar(30) NOT NULL,
  `fleet_category` varchar(50) NOT NULL,
  `fleet_Type` varchar(50) NOT NULL,
  `cap_metric_ton` varchar(30) NOT NULL,
  `salary` varchar(50) NOT NULL,
  `pf_deduction` varchar(30) NOT NULL,
  `esic` varchar(30) NOT NULL,
  `travel_allowance` varchar(30) NOT NULL,
  `accomodation_allowance` varchar(30) NOT NULL,
  `food_allowance` varchar(30) NOT NULL,
  `bonus` varchar(30) NOT NULL,
  `driving_license` varchar(30) NOT NULL,
  `issued_date` varchar(30) NOT NULL,
  `dl_expiry` varchar(30) NOT NULL,
  `upload_dl` varchar(200) NOT NULL,
  `aadhar_card` varchar(30) NOT NULL,
  `upload_aadharcard` varchar(200) NOT NULL,
  `pancard` varchar(30) NOT NULL,
  `upload_pancard` varchar(200) NOT NULL,
  `mobile_number` varchar(30) NOT NULL,
  `address` varchar(30) NOT NULL,
  `pincode` varchar(30) NOT NULL,
  `reference1` varchar(30) NOT NULL,
  `relation_refernce1` varchar(30) NOT NULL,
  `reference1_mobile` varchar(30) NOT NULL,
  `reference2` varchar(30) NOT NULL,
  `relation_refernce2` varchar(30) NOT NULL,
  `reference2_mobile` varchar(30) NOT NULL,
  `previous_company` varchar(30) NOT NULL,
  `startdate_previous_company` varchar(30) NOT NULL,
  `enddate_previous_company` varchar(30) NOT NULL,
  `current_status` varchar(30) NOT NULL,
  `driving_asset_code` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `myoperators`
--

INSERT INTO `myoperators` (`id`, `operator_fname`, `designation`, `company_name`, `startdate_crnt_company`, `fleet_category`, `fleet_Type`, `cap_metric_ton`, `salary`, `pf_deduction`, `esic`, `travel_allowance`, `accomodation_allowance`, `food_allowance`, `bonus`, `driving_license`, `issued_date`, `dl_expiry`, `upload_dl`, `aadhar_card`, `upload_aadharcard`, `pancard`, `upload_pancard`, `mobile_number`, `address`, `pincode`, `reference1`, `relation_refernce1`, `reference1_mobile`, `reference2`, `relation_refernce2`, `reference2_mobile`, `previous_company`, `startdate_previous_company`, `enddate_previous_company`, `current_status`, `driving_asset_code`) VALUES
(32, 'akash ', 'Operator', 'akash', '2024-06-19', 'Material Handling Equipments', 'Hydraulic Crawler Crane', '36', '10000', 'No', 'Yes', '1000', '1000', '1000', '21212', '10101', '2024-06-18', '2024-06-19', 'dl sample.jpg', '590282824347', 'aadhar sample.jpg', 'nnjps7581b', 'pancard sample.jpg', '7700022497', 'navi mumbai', '410209', 'akash ', 'mother', '7718003747', 'ref 2', 'mother', '7738475283', '1start', '2024-06-18', '2024-06-18', 'working', '1');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `sno` int(11) NOT NULL,
  `news_head` varchar(300) NOT NULL,
  `news_content` longtext NOT NULL,
  `news_image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`sno`, `news_head`, `news_content`, `news_image`) VALUES
(28, '\"Wipro GE Announces ₹8,000 Crore Investment in India for Manufacturing and R&D\"', 'In a significant move aimed at bolstering India\'s healthcare infrastructure, Wipro GE Healthcare has announced plans to invest over ₹8,000 crore in the country over the next five years. The investment will primarily focus on enhancing local manufacturing capabilities and ramping up research and development (R&D) initiatives.<br />\r\n<br />\r\nAs part of this investment, the company will be exporting its \'Made in India\' PET CT Discovery IQ scanner to 15 countries, showcasing India\'s prowess in medical technology on a global scale. Additionally, locally manufactured products such as the Revolution Aspire CT, Revolution ACT, and MR breast coils will be supplied worldwide, further solidifying India\'s position as a key player in the global healthcare market.', 'wipro.jpg'),
(29, '\"Kalpataru Projects International Subsidiaries Secure Orders Worth Rs. 2,071 Crore\"', 'Kalpataru Projects International and its subsidiary arms have successfully secured orders totaling Rs 2,071 crore, as announced in a statement on Thursday. These new orders encompass projects in the Transmission & Distribution (T&D) sector across international markets, underscoring the company\'s global reach and expertise.<br />\r\n<br />\r\nAdditionally, the company has also received an order for the design and construction of an underground metro rail project in India, further diversifying its portfolio of projects', 'kalpatru.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `new_fleet_enquiry_generated`
--

CREATE TABLE `new_fleet_enquiry_generated` (
  `sno` int(10) NOT NULL,
  `category` varchar(30) NOT NULL,
  `sub_type` varchar(30) NOT NULL,
  `capacity` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `new_fleet_enquiry_generated`
--

INSERT INTO `new_fleet_enquiry_generated` (`sno`, `category`, `sub_type`, `capacity`, `email`) VALUES
(109, '', 'concrete_boom_placer', '', ''),
(110, '', 'concrete_boom_placer', '11', ''),
(111, '', 'concrete_boom_placer', '1111', 'rental'),
(112, 'aerial_work_platform', 'concrete_boom_placer', '2123', 'rental'),
(113, 'concrete_equipment', 'concrete_boom_placer', '', 'rental'),
(114, 'concrete_equipment', 'concrete_boom_placer', '', 'rental'),
(115, 'concrete_equipment', 'concrete_boom_placer', '', 'rental'),
(116, '', '', '', 'rental'),
(117, 'concrete_equipment', 'concrete_boom_placer', '', 'rental'),
(118, 'concrete_equipment', 'concrete_boom_placer', '', 'rental1'),
(119, 'concrete_equipment', 'concrete_boom_placer', '', 'rental1'),
(120, 'concrete_equipment', 'concrete_boom_placer', '', 'rental001'),
(121, 'concrete_equipment', 'concrete_boom_placer', '', 'rental'),
(122, 'concrete_equipment', 'bulldozer', '12', 'rental'),
(123, 'Concrete Equipment', 'Bulldozer', '12', 'rental'),
(124, 'Concrete Equipment', 'Bulldozer', '12', 'rental'),
(125, 'Concrete Equipment', 'Bulldozer', '12', 'rental'),
(126, 'Concrete Equipment', 'Bulldozer', '12', 'rental'),
(127, 'Concrete Equipment', 'Bulldozer', '12', 'rental'),
(128, 'Concrete Equipment', 'Bulldozer', '12', 'rental'),
(129, 'Concrete Equipment', 'Bulldozer', '12', 'rental'),
(130, 'Concrete Equipment', 'Bulldozer', '12', 'rental'),
(131, 'Concrete Equipment', 'Bulldozer', '12', 'rental'),
(132, 'Concrete Equipment', 'Bulldozer', '12', 'rental'),
(133, 'Concrete Equipment', 'Bulldozer', '12', 'rental'),
(134, 'Concrete Equipment', 'Transit Mixer', '12', 'rental'),
(135, 'Concrete Equipment', 'Transit Mixer', '12', 'rental'),
(136, 'Concrete Equipment', 'Transit Mixer', '12', 'rental'),
(137, 'Concrete Equipment', 'Static Boom Placer', '12', 'rental'),
(138, 'Concrete Equipment', '', '12', 'rental'),
(139, 'Concrete Equipment', 'Batching Plant', '12', 'rental'),
(140, 'Concrete Equipment', '', '12', 'rental'),
(141, 'Concrete Equipment', 'Concrete Pump', '12', 'rental'),
(142, 'Concrete Equipment', 'Concrete Pump', '12', 'rental'),
(143, 'Concrete Equipment', 'Moli Pump', '12', 'rental'),
(144, 'EarthMovers and Road Equipments
', 'Bulldozer', '12', 'rental'),
(145, 'Aerial Work Platform', 'Scissor Lift Diesel', '12', 'rental'),
(146, 'Aerial Work Platform', 'Scissor Lift Electric', '45', 'rental'),
(147, 'Aerial Work Platform', 'Self Propelled Articulated Boo', '45', 'rental'),
(148, 'Aerial Work Platform', 'Self Propelled Articulated Boo', '45', 'rental'),
(149, 'Aerial Work Platform', 'Self Propelled Articulated Boo', '45', 'rental'),
(150, 'Aerial Work Platform', 'Self Propelled Articulated Boo', '45', 'rental'),
(151, 'Aerial Work Platform', 'Self Propelled Articulated Boo', '45', 'rental'),
(152, 'Aerial Work Platform', 'Self Propelled Articulated Boo', '45', 'rental'),
(153, 'Aerial Work Platform', 'Self Propelled Articulated Boo', '45', 'rental'),
(154, 'Aerial Work Platform', 'Scissor Lift Diesel', '50', 'akashrental');

-- --------------------------------------------------------

--
-- Table structure for table `notinterested_rental`
--

CREATE TABLE `notinterested_rental` (
  `id` int(11) NOT NULL,
  `requirement_id` varchar(30) NOT NULL,
  `equipment_type` varchar(30) NOT NULL,
  `equipment_capacity` varchar(30) NOT NULL,
  `boom_combination` varchar(30) NOT NULL,
  `project_type` varchar(30) NOT NULL,
  `state` varchar(40) NOT NULL,
  `district` varchar(40) NOT NULL,
  `duration` varchar(40) NOT NULL,
  `shift` varchar(30) NOT NULL,
  `tentative_date` varchar(40) NOT NULL,
  `epc_company` varchar(40) NOT NULL,
  `epc_email` varchar(40) NOT NULL,
  `epc_contact` varchar(40) NOT NULL,
  `rental_name` varchar(40) NOT NULL,
  `rental_email` varchar(40) NOT NULL,
  `not_interested_reason` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notinterested_rental`
--

INSERT INTO `notinterested_rental` (`id`, `requirement_id`, `equipment_type`, `equipment_capacity`, `boom_combination`, `project_type`, `state`, `district`, `duration`, `shift`, `tentative_date`, `epc_company`, `epc_email`, `epc_contact`, `rental_name`, `rental_email`, `not_interested_reason`) VALUES
(9, '20', 'Concrete Boom Placer', '1', '1', 'PipeLine', 'Goa', '1', '1', 'Double', '2024-05-14', 'akash epc', 'epc', '1', 'akash', 'akashrental', 'Client Issue'),
(10, '20', 'Concrete Boom Placer', '1', '1', 'PipeLine', 'Goa', '1', '1', 'Double', '2024-05-14', 'akash epc', 'epc', '1', '', 'gaurav', 'Non Serviceable Area'),
(11, '22', 'Concrete Boom Placer', '1011', '4', 'PipeLine', 'Maharashtra', 'raigad', '24', 'Single', '2024-05-16', 'akash epc', 'epc', '7700022497', 'akash', 'akashrental', 'Rental Period Is Short'),
(12, '22', 'Concrete Boom Placer', '1011', '4', 'PipeLine', 'Maharashtra', 'raigad', '24', 'Single', '2024-05-16', 'akash epc', 'epc', '7700022497', '', 'gaurav', 'Equipment Not Available'),
(13, '29', 'Moli Pump', '30', '2', 'Urban Infra', 'Karnataka', 'kr district', '12', 'Single', '2024-06-13', 'epc', 'epc', '7700022497', 'akash', 'akashrental', 'Client Issue');

-- --------------------------------------------------------

--
-- Table structure for table `oem_fleet`
--

CREATE TABLE `oem_fleet` (
  `email` varchar(30) NOT NULL,
  `companyname` varchar(30) NOT NULL,
  `make` varchar(20) NOT NULL,
  `model` varchar(30) NOT NULL,
  `fleet_category` varchar(30) NOT NULL,
  `fleet_type` varchar(50) NOT NULL,
  `capacity` varchar(30) NOT NULL,
  `unit` varchar(30) NOT NULL,
  `counter_weight` varchar(30) NOT NULL,
  `superlift_counter_weight` varchar(30) NOT NULL,
  `engine_make` varchar(30) NOT NULL,
  `boom_section` int(30) NOT NULL,
  `boom_length` varchar(30) NOT NULL,
  `jib_length` varchar(30) NOT NULL,
  `luffing_length` varchar(30) NOT NULL,
  `diesel_tank_cap` varchar(30) NOT NULL,
  `hydraulic_oil_tank` varchar(30) NOT NULL,
  `hydraulic_oil_grade` varchar(30) NOT NULL,
  `engine_oil_cap` varchar(30) NOT NULL,
  `engine_oil_grade` varchar(30) NOT NULL,
  `wire_rope` varchar(30) NOT NULL,
  `wire_rop_dia` varchar(30) NOT NULL,
  `auxilary_wire_rop` varchar(30) NOT NULL,
  `auxilary_wire_rop_dia` varchar(30) NOT NULL,
  `sno` int(10) NOT NULL,
  `other_make_brand` varchar(30) NOT NULL,
  `superlift_weight_input` varchar(20) NOT NULL,
  `pdf` varchar(200) NOT NULL,
  `chassis_make` varchar(30) NOT NULL,
  `chassis_make_other` varchar(30) NOT NULL,
  `transport_length` varchar(30) NOT NULL,
  `transport_width` varchar(30) NOT NULL,
  `transport_height` varchar(30) NOT NULL,
  `transport_weight` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `oem_fleet`
--

INSERT INTO `oem_fleet` (`email`, `companyname`, `make`, `model`, `fleet_category`, `fleet_type`, `capacity`, `unit`, `counter_weight`, `superlift_counter_weight`, `engine_make`, `boom_section`, `boom_length`, `jib_length`, `luffing_length`, `diesel_tank_cap`, `hydraulic_oil_tank`, `hydraulic_oil_grade`, `engine_oil_cap`, `engine_oil_grade`, `wire_rope`, `wire_rop_dia`, `auxilary_wire_rop`, `auxilary_wire_rop_dia`, `sno`, `other_make_brand`, `superlift_weight_input`, `pdf`, `chassis_make`, `chassis_make_other`, `transport_length`, `transport_width`, `transport_height`, `transport_weight`) VALUES
('oem', 'akash oem', 'ACE', 'xcmg123', 'Aerial Work Platform', 'Self Propelled Articulated Boomlift', '45', 'ton', '50', 'no', '1234', 4, '', '', '', '45', '50', '50', '45', '321313', '233', '50', '3213', '3213', 38, '', '', '', 'Eicher', '', '46', '34245', '24356', '2456');

-- --------------------------------------------------------

--
-- Table structure for table `oem_general_req`
--

CREATE TABLE `oem_general_req` (
  `id` int(11) NOT NULL,
  `fleet_category` varchar(30) NOT NULL,
  `fleet_type` varchar(50) NOT NULL,
  `fleet_capacity` varchar(30) NOT NULL,
  `project_location` varchar(30) NOT NULL,
  `contact_number` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `company name` varchar(30) NOT NULL,
  `more_specifics` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `oem_general_req`
--

INSERT INTO `oem_general_req` (`id`, `fleet_category`, `fleet_type`, `fleet_capacity`, `project_location`, `contact_number`, `email`, `company name`, `more_specifics`) VALUES
(1, '', '', '', '', '', '', '', ''),
(2, 'Aerial Work Platform', 'Self Propelled Articulated Boomlift', '45', 'navi mumbai', '07700022497', 'rental', 'akash rental', 'dgdfgsdg');

-- --------------------------------------------------------

--
-- Table structure for table `oem_quote`
--

CREATE TABLE `oem_quote` (
  `id` int(10) NOT NULL,
  `fleet_category` varchar(30) NOT NULL,
  `fleet_type` varchar(30) NOT NULL,
  `fleet_capacity` varchar(30) NOT NULL,
  `project_location` varchar(30) NOT NULL,
  `contact` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `company_name` varchar(30) NOT NULL,
  `specifics` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `operator_rating`
--

CREATE TABLE `operator_rating` (
  `sno` int(11) NOT NULL,
  `operator_license` varchar(30) NOT NULL,
  `operator_rating` varchar(30) NOT NULL,
  `feedback` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `operator_rating`
--

INSERT INTO `operator_rating` (`sno`, `operator_license`, `operator_rating`, `feedback`) VALUES
(2, '3132312312312', '4', 'done somoe good work');

-- --------------------------------------------------------

--
-- Table structure for table `quotation_generated`
--

CREATE TABLE `quotation_generated` (
  `sno` int(11) NOT NULL,
  `quote_date` varchar(30) NOT NULL,
  `letterhead_logo` varchar(300) NOT NULL,
  `to_name` varchar(30) NOT NULL,
  `to_address` varchar(30) NOT NULL,
  `contact_person` varchar(30) NOT NULL,
  `contact_person_cell` varchar(40) NOT NULL,
  `email_id_contact_person` varchar(40) NOT NULL,
  `site_loc` varchar(30) NOT NULL,
  `asset_code` varchar(30) NOT NULL,
  `yom` varchar(30) NOT NULL,
  `make` varchar(30) NOT NULL,
  `model` varchar(30) NOT NULL,
  `sub_Type` varchar(40) NOT NULL,
  `fuel/hour` varchar(30) NOT NULL,
  `availability` varchar(30) NOT NULL,
  `tentative_date` varchar(30) NOT NULL,
  `cap` varchar(30) NOT NULL,
  `cap_unit` varchar(30) NOT NULL,
  `boom` varchar(30) NOT NULL,
  `jib` varchar(30) NOT NULL,
  `luffing` varchar(30) NOT NULL,
  `hours_duration` varchar(30) NOT NULL,
  `days_duration` varchar(30) NOT NULL,
  `sunday_included` varchar(30) NOT NULL,
  `rental_charges` varchar(30) NOT NULL,
  `mob_charges` varchar(30) NOT NULL,
  `demob_charges` varchar(30) NOT NULL,
  `crane_location` varchar(30) NOT NULL,
  `adblue` varchar(30) NOT NULL,
  `sender_name` varchar(30) NOT NULL,
  `sender_number` varchar(30) NOT NULL,
  `sender_contact` varchar(30) NOT NULL,
  `company_name` varchar(30) NOT NULL,
  `sender_office_address` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quotation_generated`
--

INSERT INTO `quotation_generated` (`sno`, `quote_date`, `letterhead_logo`, `to_name`, `to_address`, `contact_person`, `contact_person_cell`, `email_id_contact_person`, `site_loc`, `asset_code`, `yom`, `make`, `model`, `sub_Type`, `fuel/hour`, `availability`, `tentative_date`, `cap`, `cap_unit`, `boom`, `jib`, `luffing`, `hours_duration`, `days_duration`, `sunday_included`, `rental_charges`, `mob_charges`, `demob_charges`, `crane_location`, `adblue`, `sender_name`, `sender_number`, `sender_contact`, `company_name`, `sender_office_address`) VALUES
(34, '2024-06-18', '', 'raj', 'sonipar', 'peehu sharma', 'none', 'none', 'none', '121', '2024-05-10', 'Bull', '121', 'Concrete Pump', '12', 'Immediate', 'none', '21', 'Ton', '', '', '', '12', '12', 'Including Sundays', '12', '12', '12', '21', 'Yes', 'akash', '7700022497', 'akash.s0167@gmail.com', 'akash', 'tirupati complex'),
(41, '2024-06-23', '', 'omdutt sharma', 'sonipat', 'omdutt sharma', '07700022497', 'urb@gmail.com', 'navi mumbai', '21213', '2023', 'Mahindra', 'egweg', 'Self Propelled Articulated Boomlift', '3', 'Immediate', 'none', '23', 'Ton', '', '', '', '13', '22', 'Including Sundays', '100000', '12000', '12000', 'mumbai', 'Yes', 'akash', '7700022497', 'akash.s0167@gmail.com', 'akash', 'tirupati complex'),
(42, '2024-06-23', '', 'omdutt sharma', 'sonipat', 'omdutt sharma', '07700022497', 'urb@gmail.com', 'navi mumbai', '121', '2024-05-10', 'Bull', '121', 'Concrete Pump', '3', 'Immediate', 'none', '21', 'Ton', '', '', '', '13', '22', 'Including Sundays', '100000', '12000', '12000', 'mumbai', 'Yes', 'akash', '7700022497', 'akash.s0167@gmail.com', 'akash', 'tirupati complex');

-- --------------------------------------------------------

--
-- Table structure for table `quote_required`
--

CREATE TABLE `quote_required` (
  `id` int(30) NOT NULL,
  `oem_company` varchar(30) NOT NULL,
  `fleet_category` varchar(30) NOT NULL,
  `fleet_type` varchar(30) NOT NULL,
  `fleet_capacity` varchar(30) NOT NULL,
  `project_location` varchar(30) NOT NULL,
  `contact_number` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `company name` varchar(30) NOT NULL,
  `more specifics` varchar(30) NOT NULL,
  `price` varchar(30) NOT NULL,
  `oem_contact_number` varchar(30) NOT NULL,
  `oem_email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quote_required`
--

INSERT INTO `quote_required` (`id`, `oem_company`, `fleet_category`, `fleet_type`, `fleet_capacity`, `project_location`, `contact_number`, `email`, `company name`, `more specifics`, `price`, `oem_contact_number`, `oem_email`) VALUES
(9, 'akash oem', 'Concrete Equipment', 'Bulldozer', '12', 'delhi', '07700022497', 'rental', 'akash rental', 'nope', '4534', '8097772622', 'oem'),
(11, 'akash oem', 'Concrete Equipment', 'Bulldozer', '12', 'sonipat', '1234567890', 'rental', 'akash rental', '', '111', '778654545', 'oem'),
(12, 'akash oem', 'Aerial Work Platform', 'Self Propelled Articulated Boo', '45', 'navi mumbai', '07700022497', 'rental', 'akash rental', 'nothing', '98', '07700022497', 'oem'),
(13, 'akash oem', 'Aerial Work Platform', 'Self Propelled Articulated Boo', '45', 'navi mumbai', '07700022497', 'rental', 'akash rental', 'nothing', '', '', ''),
(14, 'akash oem', 'Aerial Work Platform', 'Self Propelled Articulated Boo', '45', 'navi mumbai', '07700022497', 'rental', 'akash rental', 'nothing', '', '', ''),
(15, 'akash oem', 'Aerial Work Platform', 'Self Propelled Articulated Boo', '45', 'navi mumbai', '07700022497', 'rental', 'akash rental', 'nothing', '', '', ''),
(16, 'akash oem', 'Aerial Work Platform', 'Self Propelled Articulated Boo', '45', 'navi mumbai', '07700022497', 'rental', 'akash rental', 'nothing', '', '', ''),
(17, 'akash oem', 'Aerial Work Platform', 'Self Propelled Articulated Boo', '45', 'navi mumbai', '07700022497', 'rental', 'akash rental', 'nothing', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `requirement_price_byrental`
--

CREATE TABLE `requirement_price_byrental` (
  `id` int(11) NOT NULL,
  `req_id` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `cap` varchar(30) NOT NULL,
  `boom_combination` varchar(30) NOT NULL,
  `project_type` varchar(30) NOT NULL,
  `state` varchar(30) NOT NULL,
  `district` varchar(30) NOT NULL,
  `duration` varchar(30) NOT NULL,
  `working_shift` varchar(30) NOT NULL,
  `date` varchar(30) NOT NULL,
  `epc_name` varchar(30) NOT NULL,
  `epc_email` varchar(30) NOT NULL,
  `epc_number` varchar(30) NOT NULL,
  `price_quoted` varchar(30) NOT NULL,
  `rental_name` varchar(30) NOT NULL,
  `rental_email` varchar(30) NOT NULL,
  `rental_number` varchar(30) NOT NULL,
  `fleet_category` varchar(30) NOT NULL,
  `contact_person` varchar(30) NOT NULL,
  `unit` varchar(10) NOT NULL,
  `engine_hour` varchar(30) NOT NULL,
  `offer_make` varchar(35) NOT NULL,
  `offer_model` varchar(35) NOT NULL,
  `offer_yom` varchar(35) NOT NULL,
  `offer_assembly` varchar(35) NOT NULL,
  `offer_assembly_scope` varchar(35) NOT NULL,
  `offer_equip_location` varchar(35) NOT NULL,
  `offer_district` varchar(35) NOT NULL,
  `available_From_offer` varchar(35) NOT NULL,
  `payment_terms` varchar(35) NOT NULL,
  `mob_charges` varchar(35) NOT NULL,
  `demob_charges` varchar(35) NOT NULL,
  `contact_person_offer` varchar(35) NOT NULL,
  `contact_person_offer_email` varchar(35) NOT NULL,
  `epc_notes` longtext NOT NULL,
  `rental_notes` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requirement_price_byrental`
--

INSERT INTO `requirement_price_byrental` (`id`, `req_id`, `type`, `cap`, `boom_combination`, `project_type`, `state`, `district`, `duration`, `working_shift`, `date`, `epc_name`, `epc_email`, `epc_number`, `price_quoted`, `rental_name`, `rental_email`, `rental_number`, `fleet_category`, `contact_person`, `unit`, `engine_hour`, `offer_make`, `offer_model`, `offer_yom`, `offer_assembly`, `offer_assembly_scope`, `offer_equip_location`, `offer_district`, `available_From_offer`, `payment_terms`, `mob_charges`, `demob_charges`, `contact_person_offer`, `contact_person_offer_email`, `epc_notes`, `rental_notes`) VALUES
(18, '26', 'Silent Diesel Generator', '20', '2', 'Marine', 'Madhya Pradesh', 'navi mumbai', '12', 'Single', '25-06-2024', 'epc', 'epc', '39031293', '167011', 'akash', 'akashrental', ' 8097772622', 'Generator and Lighting', 'akshay sharma', 'Ton', '', 'ACE', 'ak model', '2024', 'Yes', 'Rental Company', 'Maharashtra', 'kamothe', '2024-07-16', 'Advance', '12000', '24000', 'akash sharma rental', '', '', ''),
(19, '28', 'Scissor Lift Diesel', '12', '2', 'Plant', 'Gujarat', 'ahmedabad', '36', 'Single', '19-06-2024', 'epc', 'epc', '35r7498483927', '350000', 'akash', 'akashrental', 'jffn', 'Aerial Work Platform', 'peehu sharma', 'Ton', '', 'Cat', 'mouse', '2021', 'Yes', 'Rental Company', 'Gujarat', 'gujarat district', '2024-06-12', 'Advance', '10000', '12000', 'anyone', 'fm,sdfaf', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `req_by_epc`
--

CREATE TABLE `req_by_epc` (
  `id` int(11) NOT NULL,
  `equipment_type` varchar(50) NOT NULL,
  `equipment_capacity` varchar(30) NOT NULL,
  `boom_combination` varchar(30) NOT NULL,
  `project_type` varchar(30) NOT NULL,
  `duration_month` varchar(30) NOT NULL,
  `state` varchar(30) NOT NULL,
  `district` varchar(30) NOT NULL,
  `working_shift` varchar(30) NOT NULL,
  `tentative_date` varchar(30) NOT NULL,
  `enquiry_posted_date` varchar(30) NOT NULL,
  `epc_name` varchar(30) NOT NULL,
  `epc_email` varchar(30) NOT NULL,
  `epc_number` varchar(30) NOT NULL,
  `fleet_category` varchar(40) NOT NULL,
  `contact_person` varchar(30) NOT NULL,
  `engine_hour` varchar(30) NOT NULL,
  `notes` longtext NOT NULL,
  `unit` varchar(30) NOT NULL,
  `project_code` varchar(30) NOT NULL,
  `fuel_scope` varchar(30) NOT NULL,
  `accomodation_scope` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `req_by_epc`
--

INSERT INTO `req_by_epc` (`id`, `equipment_type`, `equipment_capacity`, `boom_combination`, `project_type`, `duration_month`, `state`, `district`, `working_shift`, `tentative_date`, `enquiry_posted_date`, `epc_name`, `epc_email`, `epc_number`, `fleet_category`, `contact_person`, `engine_hour`, `notes`, `unit`, `project_code`, `fuel_scope`, `accomodation_scope`) VALUES
(30, 'Concrete Boom Placer', '1011', '4', 'Urban Infra', '24', 'Maharashtra', 'raigad', 'Single', '2024-06-26', '2024-06-25 17:55:36', 'urb infrastructure', 'support@fleeteip.com', '07700022497', 'Concrete Equipment', 'omdutt sharma', '', 'none', 'Ton', '121', 'EPC Scope', 'EPC Scope'),
(31, 'Hydraulic Crawler Crane', '100', '', 'Refinery', '6', 'Gujarat', 'Mithapur', 'Double', '2024-07-01', '2024-06-26 09:22:33', 'epc', 'epc', '8199801682', 'Material Handling Equipments', 'Sandeep Sharma', '312', 'Piling and unloading and loading hours requirement may extend upto 12 months', 'Ton', '01', 'EPC Scope', 'EPC Scope'),
(32, 'Self Propelled Articulated Boomlift', '36', '57meter', 'Refinery', '1', 'Gujarat', 'Dahej', 'Single', '2024-07-01', '2024-06-26 09:27:10', 'epc', 'epc', '9958219785', 'Aerial Work Platform', 'Rahul Saksena', '', '', 'Meter', '02', 'EPC Scope', 'EPC Scope');

-- --------------------------------------------------------

--
-- Table structure for table `selling_fleet`
--

CREATE TABLE `selling_fleet` (
  `sno` int(10) NOT NULL,
  `make` varchar(30) NOT NULL,
  `model` varchar(30) NOT NULL,
  `capacity` varchar(30) NOT NULL,
  `boom_length` varchar(30) NOT NULL,
  `jib_length` varchar(30) NOT NULL,
  `yom` varchar(30) NOT NULL,
  `location` varchar(30) NOT NULL,
  `crane_desc` varchar(100) NOT NULL,
  `front_pic` varchar(300) NOT NULL,
  `back_pic` varchar(300) NOT NULL,
  `side_pic` varchar(300) NOT NULL,
  `type` varchar(300) NOT NULL,
  `chassis_num` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `selling_fleet`
--

INSERT INTO `selling_fleet` (`sno`, `make`, `model`, `capacity`, `boom_length`, `jib_length`, `yom`, `location`, `crane_desc`, `front_pic`, `back_pic`, `side_pic`, `type`, `chassis_num`, `email`) VALUES
(1, 'xcmg', 'a1', '50', '30', '30', '2019', 'maharashtra', 'well conditioned', '9134.png_860.png', '63-630024_crane-clipart-cartoon-construction-construction-site-vector-png.png', '63-630024_crane-clipart-cartoon-construction-construction-site-vector-png.png', 'Bulldozers', '', 'ak'),
(2, 'xcmg', 'a1', '50', '30', '30', '2019', 'maharashtra', 'well conditioned', '9134.png_860.png', '63-630024_crane-clipart-cartoon-construction-construction-site-vector-png.png', '63-630024_crane-clipart-cartoon-construction-construction-site-vector-png.png', 'Bulldozers', '1234', 'ak'),
(3, 'xcmgg', 'a', '12', '32', '32', '2019', 'mumbaii', 'good', '9134.png_860.png', '9134.png_860.png', '9134.png_860.png', 'Crawler', '12221', 'ak'),
(4, 'xcmg', 'a1', '50', '30', '30', '2019', 'mumbai', 'well conditioned', 'Velvex.jpg', 'Schwing 43.jpeg', '9134.png_860.png', 'Crawler', '11111', 'ak'),
(5, 'xcmg', '1', '1', '1', '1', '1', '1', '1', '', '', '', 'Barges', '1', 'rental'),
(6, 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'add fleet logo.jpg', '', '', 'Bulldozers', 'a', 'rental'),
(7, 'akash', '', '', '', '', '', '', '', '', '', '', 'Concrete pump', '', 'rental'),
(8, '123', '', '', '', '', '', '', '', '', '', '', 'Tipper', '', 'rental'),
(9, 'abbb', '', '', '', '', '', '', '', '', '', '', 'Rig', '', 'rental'),
(10, 'lift', 'kjhgf', 'gfhkj', 'hjk', 'fhgjk', 'gjhk', 'hjk', 'gfhjk', '', '', '', 'Lift', 'sdgfh', 'rental'),
(11, 'barges', 'barges', '', '', '', '', '', '', '', '', '', 'Barges', '', 'rental');

-- --------------------------------------------------------

--
-- Table structure for table `sold`
--

CREATE TABLE `sold` (
  `id` int(11) NOT NULL,
  `sold_platform` varchar(50) NOT NULL,
  `companyname` varchar(30) NOT NULL,
  `category` varchar(30) NOT NULL,
  `sub_type` varchar(50) NOT NULL,
  `kmr` varchar(30) NOT NULL,
  `hmr` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `price` varchar(30) NOT NULL,
  `contact_no` varchar(30) NOT NULL,
  `front_pic` varchar(300) NOT NULL,
  `left_side_pic` varchar(300) NOT NULL,
  `right_side_pic` varchar(300) NOT NULL,
  `model` varchar(30) NOT NULL,
  `make` varchar(30) NOT NULL,
  `capacity` varchar(30) NOT NULL,
  `yom` varchar(30) NOT NULL,
  `location` varchar(30) NOT NULL,
  `boomlength` varchar(30) NOT NULL,
  `jiblength` varchar(30) NOT NULL,
  `luffinglength` varchar(30) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sold`
--

INSERT INTO `sold` (`id`, `sold_platform`, `companyname`, `category`, `sub_type`, `kmr`, `hmr`, `email`, `price`, `contact_no`, `front_pic`, `left_side_pic`, `right_side_pic`, `model`, `make`, `capacity`, `yom`, `location`, `boomlength`, `jiblength`, `luffinglength`, `description`) VALUES
(13, 'FleetEIP', 'akash rental', 'Concrete Equipment', 'Concrete Boom Placer', '112', '11', 'rental', '1', '1', 'IMG-660513f4b7a157.54722994.jpg', 'IMG-660513f4b8a256.32691649.jpg', 'IMG-660513f4b91da9.38836252.jpg', '112', '1', '1', '123', '1', '1', '1', '12', '1'),
(15, 'offline', 'akash rental', 'Aerial Work Platform', 'Self Propelled Articulated Boomlift', '112', '11', 'rental', '2542433', '1', 'IMG-66052b783e5634.89750686.jpg', 'IMG-66052b783f4f94.70045946.jpg', 'IMG-66052b783fb5a5.66794318.jpg', 'q', 'xcmggg', 'qq', '123', '1', 'm', '6', 'a', 'q'),
(16, 'FleetEIP', 'akash rental', 'Aerial Work Platform', 'Self Propelled Articulated Boomlift', '112', '11', 'rental', '101', '1', 'IMG-66052ddb65eee0.08472109.jpg', 'IMG-66052ddb6646f0.90462392.jpg', 'IMG-66052ddb668b55.84292188.jpg', 'abcd', 'abcd', 'qq', '123', '1', 'q', '12', 'a', 'q'),
(17, 'FleetEIP', 'akash rental', 'EarthMovers and Road Equipments
', 'Motor Grader', 'd', 'wd', 'rental', '0', 'WDQ', 'IMG-66053fca30f5b2.27436732.jpg', 'IMG-66053fca32d104.19581214.jpg', 'IMG-66053fca3321e5.47520112.jpg', 'dwqd', 'dasd', 'd', 'd', 'dwq', 'dw', 'ddwd', 'ddq', 'qddwef'),
(18, 'Sold Offline', 'akash rental', 'Generator and Lighting', 'Mobile Light Tower', 'jghj', 'h', 'rental', '0', 'j', 'IMG-660540f29087c0.06571471.jpg', 'IMG-660540f2910275.17807535.jpg', 'IMG-660540f2912ea2.23709242.jpg', 'wet', 're', 'hgvjhk', 'jh', 'jj', 'j', 'j', 'j', 'jj');

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `sno` int(11) NOT NULL,
  `added_by` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `mob_number` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `company_name` varchar(30) NOT NULL,
  `designation` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`sno`, `added_by`, `name`, `mob_number`, `email`, `company_name`, `designation`) VALUES
(12, 'akashrental', 'akash', '7700022497', 'akash.s0167@gmail.com', 'akash', 'marketing'),
(13, 'akashrental', 'testing', '98348', 'afjkd', 'akash', 'marketing'),
(14, 'akashrental', 'testing', '07700022497', 'fdfsf', 'akash', 'operation'),
(15, 'akashrental', 'fsfdng', 'gsdg', 'gdsdgfmh', 'akash', 'accounts'),
(16, 'akashrental', 'omdatt sharma', '7718003747', 'shivlogistic501@gmail.com', 'akash', 'operation'),
(17, 'akashrental', 'omdatt sharma', '7718003747', 'shivlogistic501@gmail.com', 'akash', 'operation'),
(18, '', 'rajkumar sharma', '8097772622', 'info@urbcorporation.in', 'urb corporation', 'marketing');

-- --------------------------------------------------------

--
-- Table structure for table `todo_noti`
--

CREATE TABLE `todo_noti` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `task` varchar(200) NOT NULL,
  `listed_by` varchar(30) NOT NULL,
  `assinged_to` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  `companyname` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `to_do`
--

CREATE TABLE `to_do` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `task` varchar(200) NOT NULL,
  `listed_by` varchar(30) NOT NULL,
  `assinged_to` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  `companyname` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `to_do`
--

INSERT INTO `to_do` (`id`, `date`, `task`, `listed_by`, `assinged_to`, `status`, `companyname`) VALUES
(44, '2024-06-22', 'task 1', 'akash', 'akash', 'Open', 'akash');

-- --------------------------------------------------------

--
-- Table structure for table `trial`
--

CREATE TABLE `trial` (
  `name` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trial`
--

INSERT INTO `trial` (`name`, `password`) VALUES
('aksh', 'sharma'),
('akashhhh', 'sharmaaaa'),
('latika', 'latika'),
('krishna', 'sharma'),
('siya', 'sharma');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `sno` int(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `companyname` varchar(20) NOT NULL,
  `gst` varchar(20) NOT NULL,
  `pancard` varchar(20) NOT NULL,
  `contactnumber` varchar(20) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `cpassword` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `billing_clients`
--
ALTER TABLE `billing_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bill_generated`
--
ALTER TABLE `bill_generated`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brkdown_log`
--
ALTER TABLE `brkdown_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `closed_requirement_epc_latest`
--
ALTER TABLE `closed_requirement_epc_latest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commercial_rmc_req_by_epc`
--
ALTER TABLE `commercial_rmc_req_by_epc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complete_profile`
--
ALTER TABLE `complete_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dl_expiry`
--
ALTER TABLE `dl_expiry`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`snum`);

--
-- Indexes for table `fleet`
--
ALTER TABLE `fleet`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `fleet1`
--
ALTER TABLE `fleet1`
  ADD PRIMARY KEY (`snum`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `insaurance_notification`
--
ALTER TABLE `insaurance_notification`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `logistics_need`
--
ALTER TABLE `logistics_need`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logi_price_quoted`
--
ALTER TABLE `logi_price_quoted`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logsheet`
--
ALTER TABLE `logsheet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `myoperators`
--
ALTER TABLE `myoperators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD UNIQUE KEY `sno` (`sno`);

--
-- Indexes for table `new_fleet_enquiry_generated`
--
ALTER TABLE `new_fleet_enquiry_generated`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `notinterested_rental`
--
ALTER TABLE `notinterested_rental`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oem_fleet`
--
ALTER TABLE `oem_fleet`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `oem_general_req`
--
ALTER TABLE `oem_general_req`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oem_quote`
--
ALTER TABLE `oem_quote`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `operator_rating`
--
ALTER TABLE `operator_rating`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `quotation_generated`
--
ALTER TABLE `quotation_generated`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `quote_required`
--
ALTER TABLE `quote_required`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requirement_price_byrental`
--
ALTER TABLE `requirement_price_byrental`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `req_by_epc`
--
ALTER TABLE `req_by_epc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `selling_fleet`
--
ALTER TABLE `selling_fleet`
  ADD UNIQUE KEY `sno` (`sno`);

--
-- Indexes for table `sold`
--
ALTER TABLE `sold`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `todo_noti`
--
ALTER TABLE `todo_noti`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `to_do`
--
ALTER TABLE `to_do`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `billing_clients`
--
ALTER TABLE `billing_clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `bill_generated`
--
ALTER TABLE `bill_generated`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `brkdown_log`
--
ALTER TABLE `brkdown_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `closed_requirement_epc_latest`
--
ALTER TABLE `closed_requirement_epc_latest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `commercial_rmc_req_by_epc`
--
ALTER TABLE `commercial_rmc_req_by_epc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `complete_profile`
--
ALTER TABLE `complete_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dl_expiry`
--
ALTER TABLE `dl_expiry`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=258;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `snum` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `fleet`
--
ALTER TABLE `fleet`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=553;

--
-- AUTO_INCREMENT for table `fleet1`
--
ALTER TABLE `fleet1`
  MODIFY `snum` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `insaurance_notification`
--
ALTER TABLE `insaurance_notification`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1887;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT for table `logistics_need`
--
ALTER TABLE `logistics_need`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `logi_price_quoted`
--
ALTER TABLE `logi_price_quoted`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `logsheet`
--
ALTER TABLE `logsheet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `myoperators`
--
ALTER TABLE `myoperators`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `new_fleet_enquiry_generated`
--
ALTER TABLE `new_fleet_enquiry_generated`
  MODIFY `sno` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `notinterested_rental`
--
ALTER TABLE `notinterested_rental`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `oem_fleet`
--
ALTER TABLE `oem_fleet`
  MODIFY `sno` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `oem_general_req`
--
ALTER TABLE `oem_general_req`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oem_quote`
--
ALTER TABLE `oem_quote`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `operator_rating`
--
ALTER TABLE `operator_rating`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `quotation_generated`
--
ALTER TABLE `quotation_generated`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `quote_required`
--
ALTER TABLE `quote_required`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `requirement_price_byrental`
--
ALTER TABLE `requirement_price_byrental`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `req_by_epc`
--
ALTER TABLE `req_by_epc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `selling_fleet`
--
ALTER TABLE `selling_fleet`
  MODIFY `sno` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sold`
--
ALTER TABLE `sold`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `todo_noti`
--
ALTER TABLE `todo_noti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `to_do`
--
ALTER TABLE `to_do`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
