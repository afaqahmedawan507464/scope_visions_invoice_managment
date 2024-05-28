-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2024 at 10:01 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scopevision_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `additional_cources`
--

CREATE TABLE `additional_cources` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `degree` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `grade` varchar(255) NOT NULL,
  `gradution_year` int(11) NOT NULL,
  `qualification_mode` varchar(255) NOT NULL,
  `duration` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `detail_breif` varchar(300) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(255) NOT NULL DEFAULT '0',
  `adminname` varchar(255) NOT NULL,
  `adminemailaddress` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_image` varchar(255) DEFAULT NULL,
  `active_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `user_type`, `adminname`, `adminemailaddress`, `password`, `user_image`, `active_status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'lkhsadlkjaD', 'superadmin@superadmin.com', '$2y$12$CZt.cUuD08xa53HmjRshQuP5iEhdiu9b/4CHmg2eWRHE/C5qUEaY.', '/storage/user_image/profile_image/1709624901-userImages.jpg', 1, '2024-03-05 02:41:50', '2024-03-05 02:41:50');

-- --------------------------------------------------------

--
-- Table structure for table `admin_details`
--

CREATE TABLE `admin_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `user_image` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `office_number` varchar(255) NOT NULL,
  `mobile_number` varchar(255) NOT NULL,
  `salutation` varchar(255) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `marred_status` varchar(255) NOT NULL,
  `blood_group` varchar(255) NOT NULL,
  `cnic_number` varchar(255) NOT NULL,
  `father_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `postal_code` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `emergency_contact_person` varchar(255) NOT NULL,
  `relationship` varchar(255) NOT NULL,
  `person_contact` varchar(255) NOT NULL,
  `place_of_birth` varchar(255) NOT NULL,
  `sub_department` varchar(255) NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_details`
--

INSERT INTO `admin_details` (`id`, `admin_id`, `first_name`, `user_image`, `email_address`, `office_number`, `mobile_number`, `salutation`, `nationality`, `date_of_birth`, `marred_status`, `blood_group`, `cnic_number`, `father_name`, `address`, `city`, `province`, `postal_code`, `country`, `contact_number`, `emergency_contact_person`, `relationship`, `person_contact`, `place_of_birth`, `sub_department`, `end_date`, `created_at`, `updated_at`) VALUES
(1, 1, 'lkhsadlkjaD', '/storage/user_image/profile_image/1709624901-userImages.jpg', 'superadmin@superadmin.com', '1234657867', '12345678', 'male', 'pakistan', '2024-03-06', 'single', 'o+', '534564564654', 'ABKSAGD', 'TAXILA', 'TAXILA', 'PUNJAB', '45000', 'PAKISTAN', '12345678', 'DEMO', 'FATHERS', '23146787', 'TAXILA', 'ASDSAD', '0000-00-00', '2024-03-05 02:48:21', '2024-03-05 02:48:21');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_employees`
--

CREATE TABLE `attendance_employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_user` bigint(20) UNSIGNED DEFAULT NULL,
  `employee_user` bigint(20) UNSIGNED DEFAULT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `clockInTime` timestamp NULL DEFAULT NULL,
  `clockInDate` date DEFAULT NULL,
  `clockOutTime` timestamp NULL DEFAULT NULL,
  `clockOutDate` date DEFAULT NULL,
  `lateTime` varchar(255) DEFAULT NULL,
  `overTime` varchar(255) DEFAULT NULL,
  `attendance_status` tinyint(4) NOT NULL DEFAULT 0,
  `late_status` tinyint(4) NOT NULL DEFAULT 0,
  `total_hours` varchar(255) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance_employees`
--

INSERT INTO `attendance_employees` (`id`, `admin_user`, `employee_user`, `employee_id`, `clockInTime`, `clockInDate`, `clockOutTime`, `clockOutDate`, `lateTime`, `overTime`, `attendance_status`, `late_status`, `total_hours`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 1, '2024-03-05 05:15:00', '2024-03-05', '2024-03-05 12:00:00', '2024-03-05', '01:00:00', '00:00:00', 1, 1, '06:45:00', 'For Traffic', '2024-03-05 04:31:52', '2024-03-05 04:32:41'),
(2, NULL, 1, 1, '2024-03-05 05:30:00', '2024-03-02', '2024-03-05 12:14:00', '2024-03-02', '01:15:00', '00:00:00', 1, 1, '06:44:00', NULL, '2024-03-05 04:34:40', '2024-03-05 04:35:40');

-- --------------------------------------------------------

--
-- Table structure for table `bank_expenses`
--

CREATE TABLE `bank_expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_date` longtext NOT NULL,
  `name` longtext NOT NULL,
  `payment_category_type` longtext NOT NULL,
  `slip_number` longtext DEFAULT NULL,
  `payment_amount` longtext DEFAULT NULL,
  `payment_method` longtext DEFAULT NULL,
  `bank_name` longtext DEFAULT NULL,
  `bank_account_number` longtext DEFAULT NULL,
  `check_number` longtext DEFAULT NULL,
  `total_send_amount` longtext DEFAULT NULL,
  `total_received_amount` longtext DEFAULT NULL,
  `remaining_amount` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `client_emailaddress` varchar(255) NOT NULL,
  `client_organizationname` varchar(255) NOT NULL,
  `client_address` varchar(255) NOT NULL,
  `client_contactinformation` varchar(255) NOT NULL,
  `client_type` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `client_name`, `client_emailaddress`, `client_organizationname`, `client_address`, `client_contactinformation`, `client_type`, `created_at`, `updated_at`) VALUES
(1, 'demo client', 'demo@demo.com', 'demo organziation', 'jahgdfkasgfaksgfaksfd', '12345678', 0, '2024-03-05 03:04:55', '2024-03-05 03:04:55');

-- --------------------------------------------------------

--
-- Table structure for table `client_account_historys`
--

CREATE TABLE `client_account_historys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_name` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_date` date NOT NULL,
  `item_id` longtext DEFAULT NULL,
  `invoice_item_srNumber` longtext NOT NULL,
  `invoice_scope_model` longtext DEFAULT NULL,
  `invoice_scope_srno` longtext DEFAULT NULL,
  `invoice_scope_problem` longtext DEFAULT NULL,
  `invoice_need_work` longtext DEFAULT NULL,
  `invoice_item_decription` longtext DEFAULT NULL,
  `invoice_item_disposible_batchNo` longtext DEFAULT NULL,
  `invoice_item_disposible_expDate` longtext DEFAULT NULL,
  `invoice_item_disposible_qtv` longtext DEFAULT NULL,
  `invoice_item_disposible_pricePerUnit` longtext DEFAULT NULL,
  `invoice_total_price` longtext NOT NULL,
  `invoice_grant_total_amount` varchar(255) DEFAULT NULL,
  `payment_type` tinyint(4) NOT NULL,
  `Notes` longtext NOT NULL,
  `Previous_amount` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `client_account_historys`
--

INSERT INTO `client_account_historys` (`id`, `account_name`, `invoice_id`, `invoice_date`, `item_id`, `invoice_item_srNumber`, `invoice_scope_model`, `invoice_scope_srno`, `invoice_scope_problem`, `invoice_need_work`, `invoice_item_decription`, `invoice_item_disposible_batchNo`, `invoice_item_disposible_expDate`, `invoice_item_disposible_qtv`, `invoice_item_disposible_pricePerUnit`, `invoice_total_price`, `invoice_grant_total_amount`, `payment_type`, `Notes`, `Previous_amount`, `created_at`, `updated_at`) VALUES
(1, 1, 10, '2024-03-05', NULL, '[\"1\"]', NULL, NULL, NULL, NULL, '[\"12\"]', NULL, NULL, NULL, NULL, '[\"156757\"]', '161757', 0, 'thrthrtg', '0', '2024-03-05 07:21:56', '2024-03-05 07:21:56'),
(2, 1, 11, '2024-03-05', '[\"1\"]', '[\"4\"]', NULL, NULL, NULL, NULL, NULL, '[\"4\"]', '[\"2024-03-19\"]', '[\"45\"]', '[\"45\"]', '[\"4777\"]', '11777', 0, 'ytytyt', '161757', '2024-03-05 07:22:14', '2024-03-05 07:22:14'),
(3, 1, 12, '2024-03-05', NULL, '[\"1\"]', '[\"gif-260\"]', '[\"1234567\"]', NULL, '[\"Need to replace its button head\"]', NULL, NULL, NULL, NULL, NULL, '[\"50000\"]', '50000', 1, 'thrddfgsd', '173534', '2024-03-05 07:22:56', '2024-03-05 07:22:56'),
(4, 1, 13, '2024-03-05', NULL, '[\"1\"]', '[\"gif-260\"]', '[\"24455\"]', NULL, '[\"sdkjfhdjskhgsdfkjg\"]', NULL, NULL, NULL, NULL, NULL, '[\"505\"]', '7505', 0, 'bgd', '173534', '2024-03-05 07:23:15', '2024-03-05 07:23:15'),
(5, 1, 14, '2024-03-05', NULL, '[\"1\"]', NULL, NULL, NULL, NULL, '[\"13\"]', NULL, NULL, NULL, NULL, '[\"546464\"]', '546516', 0, 'hgjhgjhg', '181039', '2024-03-05 07:23:33', '2024-03-05 07:23:33'),
(6, 1, 15, '2024-03-05', '[\"1\"]', '[\"1\"]', NULL, NULL, NULL, NULL, NULL, '[\"1\"]', '[null]', '[\"12\"]', '[\"12\"]', '[\"144\"]', '196', 0, 'hghjghjgj', '727555', '2024-03-05 07:23:53', '2024-03-05 07:23:53');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_logo` varchar(255) NOT NULL,
  `company_emailaddress` varchar(255) NOT NULL,
  `company_contactnumber` varchar(255) NOT NULL,
  `company_phonenumber` varchar(255) DEFAULT NULL,
  `company_ownername` varchar(255) NOT NULL,
  `company_ntnnumber` varchar(255) NOT NULL,
  `companyTimeIn` timestamp NULL DEFAULT NULL,
  `companyTimeOut` timestamp NULL DEFAULT NULL,
  `company_address` longtext NOT NULL,
  `company_workDetails` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `company_name`, `company_logo`, `company_emailaddress`, `company_contactnumber`, `company_phonenumber`, `company_ownername`, `company_ntnnumber`, `companyTimeIn`, `companyTimeOut`, `company_address`, `company_workDetails`, `created_at`, `updated_at`) VALUES
(3, 'Scope visions', '/storage/company_image1709625799-company logo.jpg', 'scopevisions123@gmail.com', '03015449736', '0511234567', 'shabbir ahmed', '1234564787', '2024-03-05 04:15:00', '2024-03-05 12:45:00', 'Rwalpindi, Taxila', 'Deal in all type of flexible scopes', '2024-03-05 03:03:19', '2024-03-05 03:03:19');

-- --------------------------------------------------------

--
-- Table structure for table `deliever_challans`
--

CREATE TABLE `deliever_challans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `delivery_challan_po_no` varchar(255) NOT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `item_id` longtext DEFAULT NULL,
  `delivery_challan_date` date NOT NULL,
  `delivery_challan` varchar(500) NOT NULL,
  `delivery_challan_item_srNumber` longtext NOT NULL,
  `delivery_challan_item_description` longtext NOT NULL,
  `delivery_challan_item_qtv` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deliever_challans`
--

INSERT INTO `deliever_challans` (`id`, `delivery_challan_po_no`, `invoice_id`, `invoice_client_id`, `item_id`, `delivery_challan_date`, `delivery_challan`, `delivery_challan_item_srNumber`, `delivery_challan_item_description`, `delivery_challan_item_qtv`, `created_at`, `updated_at`) VALUES
(1, 'hjfghf', 10, 1, '[\"12\"]', '2024-03-05', '', '[\"1\"]', '', '[\"1\"]', '2024-03-05 07:24:13', '2024-03-05 07:24:13'),
(2, 'hjfghf54', 11, 1, '[\"1\"]', '2024-03-05', '', '[\"4\"]', '', '[\"1\"]', '2024-03-05 07:26:17', '2024-03-05 07:26:17');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(255) NOT NULL DEFAULT '0',
  `employeename` varchar(255) NOT NULL,
  `employeeemailaddress` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_image` varchar(255) DEFAULT NULL,
  `active_status` tinyint(4) NOT NULL DEFAULT 0,
  `online_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `user_type`, `employeename`, `employeeemailaddress`, `password`, `user_image`, `active_status`, `online_status`, `created_at`, `updated_at`) VALUES
(1, 'computer operator', 'Aliha Zubair', 'employee@employee.com', '$2y$12$E4jQOzyzjHSOhzWBc2tmrOt5q97Ei6Im0HsxPoW3fGU.dnBNnf3Du', '/storage/user_image/profile_image/1709629945-userImages.jpg', 1, 0, '2024-03-05 02:41:51', '2024-03-05 02:41:51'),
(3, 'Engr', 'Umer Naseer', 'umernaseer@gmail.com', '$2y$12$VCZw6d19vwwIikQIRtSdj.n0sTSm2zwKHtAcWJucW/rOLHlyB6Mmu', NULL, 1, 0, '2024-03-05 03:57:53', '2024-03-05 04:55:47'),
(4, 'helper', 'Muhammad Sohail', 'sohail@gmail.com', '$2y$12$NPmbqyYF9ErIF5svJhwF8uju2S1B02On89nrqhRV/S.lu.52zVCmi', NULL, 1, 0, '2024-03-05 03:58:37', '2024-03-05 04:55:50'),
(5, 'service engr', 'Aqil Muraad', 'aqil@gmail.com', '$2y$12$USApzV/6.on.PxLnE5opy.DH0dSyhKh0IwhkSlWZbfQf7vtJC8Lf2', NULL, 1, 0, '2024-03-05 04:00:15', '2024-03-05 04:55:54');

-- --------------------------------------------------------

--
-- Table structure for table `employee_details`
--

CREATE TABLE `employee_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `user_image` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `office_number` varchar(255) NOT NULL,
  `mobile_number` varchar(255) NOT NULL,
  `salutation` varchar(255) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `marred_status` varchar(255) NOT NULL,
  `blood_group` varchar(255) NOT NULL,
  `cnic_number` varchar(255) NOT NULL,
  `father_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `postal_code` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `emergency_contact_person` varchar(255) NOT NULL,
  `relationship` varchar(255) NOT NULL,
  `person_contact` varchar(255) NOT NULL,
  `place_of_birth` varchar(255) NOT NULL,
  `sub_department` varchar(255) NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_details`
--

INSERT INTO `employee_details` (`id`, `employee_id`, `first_name`, `user_image`, `email_address`, `office_number`, `mobile_number`, `salutation`, `nationality`, `date_of_birth`, `marred_status`, `blood_group`, `cnic_number`, `father_name`, `address`, `city`, `province`, `postal_code`, `country`, `contact_number`, `emergency_contact_person`, `relationship`, `person_contact`, `place_of_birth`, `sub_department`, `end_date`, `created_at`, `updated_at`) VALUES
(1, 1, 'Aliha Zubair', '/storage/user_image/profile_image/1709629945-userImages.jpg', 'employee@employee.com', '0514908076', '03275083003', 'female', 'pakistan', '2001-05-09', 'married', 'a+', '4250150605012', 'Sagheer Hussain', 'House No, F/403 27 Taxila District Rawalpindi', 'TAXILA', 'PUNJAB', '45000', 'PAKISTAN', '03265656061', 'Zubair', 'Husband', '03485328568', 'wah cantt', 'Computer Oprater', '0000-00-00', '2024-03-05 04:12:25', '2024-03-05 04:12:25');

-- --------------------------------------------------------

--
-- Table structure for table `employee_education_informations`
--

CREATE TABLE `employee_education_informations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `degree` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `grade` varchar(255) NOT NULL,
  `gradution_year` int(11) NOT NULL,
  `qualification_mode` varchar(255) NOT NULL,
  `duration` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `detail_breif` varchar(300) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_socials`
--

CREATE TABLE `employee_socials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `twitter_account` varchar(300) DEFAULT NULL,
  `facebook_account` varchar(300) DEFAULT NULL,
  `instagram_account` varchar(300) DEFAULT NULL,
  `skype_account` varchar(300) DEFAULT NULL,
  `yahoo_account` varchar(300) DEFAULT NULL,
  `google_account` varchar(300) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_socials`
--

INSERT INTO `employee_socials` (`id`, `employee_id`, `twitter_account`, `facebook_account`, `instagram_account`, `skype_account`, `yahoo_account`, `google_account`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, NULL, NULL, NULL, 'alihasagheer5@gmail.com', '2024-03-05 04:14:19', '2024-03-05 04:14:19');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `expense_date` longtext NOT NULL,
  `expense_category_type` longtext NOT NULL,
  `slip_number` longtext DEFAULT NULL,
  `expense_detail` longtext DEFAULT NULL,
  `expense_amount` longtext DEFAULT NULL,
  `expense_payment_method` longtext DEFAULT NULL,
  `expense_patticash_amount` longtext DEFAULT NULL,
  `pre_patticash_month` varchar(255) DEFAULT NULL,
  `remaining_patticash_this_month` varchar(255) DEFAULT NULL,
  `total_received_patticash` varchar(255) DEFAULT NULL,
  `total_use_amount` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `expense_date`, `expense_category_type`, `slip_number`, `expense_detail`, `expense_amount`, `expense_payment_method`, `expense_patticash_amount`, `pre_patticash_month`, `remaining_patticash_this_month`, `total_received_patticash`, `total_use_amount`, `created_at`, `updated_at`) VALUES
(1, '2024-03-05', '[\"2\",\"4\",\"3\"]', '[\"25\",\"0\",\"2345678\"]', '[\"Going to isl\",\"Lunch\",\"Zaheer sab Lahore 234367489\"]', '[\"1000\",\"300\",\"1500\"]', '[\"1\",\"1\",\"1\"]', '1400', NULL, '-1400', '1400', '2800', '2024-03-05 04:45:45', '2024-03-05 04:45:45');

-- --------------------------------------------------------

--
-- Table structure for table `expense_categories`
--

CREATE TABLE `expense_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `expense_category_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incoming_and_outgoings`
--

CREATE TABLE `incoming_and_outgoings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `incoming_report_ids` bigint(20) UNSIGNED DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `item_sr_no` varchar(255) DEFAULT NULL,
  `incoming_date` date NOT NULL,
  `details` longtext DEFAULT NULL,
  `sender_name` varchar(255) NOT NULL,
  `incoming_slip_number` varchar(255) NOT NULL,
  `outgoing_date` date DEFAULT NULL,
  `outgoing_slip_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `incoming_and_outgoings`
--

INSERT INTO `incoming_and_outgoings` (`id`, `incoming_report_ids`, `model`, `item_sr_no`, `incoming_date`, `details`, `sender_name`, `incoming_slip_number`, `outgoing_date`, `outgoing_slip_number`, `created_at`, `updated_at`) VALUES
(2, 1, 'GIF-XQ140', '2600083', '2024-03-01', NULL, 'Dr, Zubair Mulgani Sb', 'self collected', '2024-03-12', 'self deliver', '2024-03-05 05:51:04', '2024-03-05 05:58:35'),
(3, 2, 'GIF-XQ140', '4564564', '2024-03-19', NULL, 'Dr, Zubairsad', '12345678', '2024-03-30', 'self deliver by umer', '2024-03-05 06:01:03', '2024-03-05 06:03:10'),
(4, 3, 'GIF-XQ140', '123456789', '2024-03-06', NULL, 'Dr, Zubairsad', '12345678', '2024-03-05', '45800876', '2024-03-05 06:22:48', '2024-03-05 06:28:23');

-- --------------------------------------------------------

--
-- Table structure for table `incoming_and_outgoing_disposibles`
--

CREATE TABLE `incoming_and_outgoing_disposibles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_incomingDate` date NOT NULL,
  `item_sendername` varchar(255) NOT NULL,
  `incoming_type` varchar(255) NOT NULL,
  `incoming_description` varchar(255) DEFAULT NULL,
  `item_model` varchar(255) DEFAULT NULL,
  `item_srno` varchar(255) DEFAULT NULL,
  `item_disposible_batchNo` varchar(255) DEFAULT NULL,
  `item_disposible_expDate` date DEFAULT NULL,
  `item_disposible_qtv` int(11) DEFAULT NULL,
  `outgoing_type` varchar(255) DEFAULT NULL,
  `item_outgoing_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `incoming_and_outgoing_disposibles`
--

INSERT INTO `incoming_and_outgoing_disposibles` (`id`, `item_incomingDate`, `item_sendername`, `incoming_type`, `incoming_description`, `item_model`, `item_srno`, `item_disposible_batchNo`, `item_disposible_expDate`, `item_disposible_qtv`, `outgoing_type`, `item_outgoing_date`, `created_at`, `updated_at`) VALUES
(1, '2024-03-06', 'Demo Person', 'self collected By Afaq', 'Biopsy Forcep Reuseable', NULL, NULL, '5464564', '2024-03-27', 5, '645456456', '2024-03-05', '2024-03-05 06:09:26', '2024-03-05 06:09:26'),
(2, '2024-03-05', 'Zaheer Sab Lahore', '12345678', 'Video Processor 140 series', 'Cv-140', '1234567', NULL, NULL, NULL, '556778953', '2024-03-05', '2024-03-05 06:32:39', '2024-03-05 06:32:39');

-- --------------------------------------------------------

--
-- Table structure for table `incoming_inspection_reports`
--

CREATE TABLE `incoming_inspection_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `scope_model` varchar(300) NOT NULL,
  `scope_incoming_date` date NOT NULL,
  `scope_sr_number` varchar(255) NOT NULL,
  `sender_name` varchar(255) NOT NULL,
  `scope_sending_with` longtext NOT NULL,
  `scope_leakage` tinyint(4) NOT NULL DEFAULT 0,
  `scope_view` tinyint(4) NOT NULL DEFAULT 0,
  `scope_lightguide` tinyint(4) NOT NULL DEFAULT 0,
  `scope_airwater` tinyint(4) NOT NULL DEFAULT 0,
  `scope_angulation` tinyint(4) NOT NULL DEFAULT 0,
  `scope_lgtube` tinyint(4) NOT NULL DEFAULT 0,
  `scope_insertiontube` tinyint(4) NOT NULL DEFAULT 0,
  `scope_biopsychannel` tinyint(4) NOT NULL DEFAULT 0,
  `scope_objectivelenz` tinyint(4) NOT NULL DEFAULT 0,
  `scope_suction` tinyint(4) NOT NULL DEFAULT 0,
  `scope_angulation_lock` tinyint(4) NOT NULL DEFAULT 0,
  `scope_freezing_buttons` tinyint(4) NOT NULL DEFAULT 0,
  `scope_tjf_elevator_channel` tinyint(4) DEFAULT NULL,
  `scope_tjf_elevator_wire` tinyint(4) DEFAULT NULL,
  `scope_tjf_elevator_axel` tinyint(4) DEFAULT NULL,
  `scope_tjf_tip_cover` tinyint(4) DEFAULT NULL,
  `scope_tjf_elevator_clinder` tinyint(4) DEFAULT NULL,
  `scope_tjf_liver` tinyint(4) DEFAULT NULL,
  `remarks` longtext NOT NULL,
  `inspectedby_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `incoming_inspection_reports`
--

INSERT INTO `incoming_inspection_reports` (`id`, `scope_model`, `scope_incoming_date`, `scope_sr_number`, `sender_name`, `scope_sending_with`, `scope_leakage`, `scope_view`, `scope_lightguide`, `scope_airwater`, `scope_angulation`, `scope_lgtube`, `scope_insertiontube`, `scope_biopsychannel`, `scope_objectivelenz`, `scope_suction`, `scope_angulation_lock`, `scope_freezing_buttons`, `scope_tjf_elevator_channel`, `scope_tjf_elevator_wire`, `scope_tjf_elevator_axel`, `scope_tjf_tip_cover`, `scope_tjf_elevator_clinder`, `scope_tjf_liver`, `remarks`, `inspectedby_id`, `company_id`, `created_at`, `updated_at`) VALUES
(1, 'GIF-XQ140', '2024-03-01', '2600083', 'Dr, Zubair Mulgani Sb', 'Black Bag', 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '1- Leakage are Buttons Head.\r\n2- Light Guide 70% ok\r\n3- Insertion tube 40 to 50 Area Punch', 5, 3, '2024-03-05 05:00:49', '2024-03-05 05:00:49'),
(2, 'GIF-XQ140', '2024-03-19', '4564564', 'Dr, Zubairsad', 'd', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'sdasdasdasdasd', 5, 3, '2024-03-05 05:53:30', '2024-03-05 05:53:30'),
(3, 'GIF-XQ140', '2024-03-06', '123456789', 'Dr, Zubairsad', 'hfghfhgfgd', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'nfhgfddfghdghdghgdgh', 5, 3, '2024-03-05 06:18:22', '2024-03-05 06:18:22');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quotation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `item_id` longtext DEFAULT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `invoice_date` date NOT NULL,
  `invoice_heading` varchar(1000) NOT NULL,
  `invoice_item_srNumber` longtext NOT NULL,
  `invoice_scope_model` longtext DEFAULT NULL,
  `invoice_scope_srno` longtext DEFAULT NULL,
  `invoice_scope_problem` longtext DEFAULT NULL,
  `invoice_need_work` longtext DEFAULT NULL,
  `invoice_item_decription` longtext DEFAULT NULL,
  `invoice_item_disposible_batchNo` longtext DEFAULT NULL,
  `invoice_item_disposible_expDate` longtext DEFAULT NULL,
  `invoice_item_disposible_qtv` longtext DEFAULT NULL,
  `invoice_item_disposible_pricePerUnit` longtext DEFAULT NULL,
  `invoice_total_price` longtext NOT NULL,
  `invoice_gsttext` varchar(255) DEFAULT NULL,
  `invoice_grant_total_amount` varchar(255) DEFAULT NULL,
  `invoice_grant_total_amount_inWords` varchar(1000) DEFAULT NULL,
  `invoice_termAndConditions` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `quotation_id`, `invoice_client_id`, `item_id`, `invoice_number`, `invoice_date`, `invoice_heading`, `invoice_item_srNumber`, `invoice_scope_model`, `invoice_scope_srno`, `invoice_scope_problem`, `invoice_need_work`, `invoice_item_decription`, `invoice_item_disposible_batchNo`, `invoice_item_disposible_expDate`, `invoice_item_disposible_qtv`, `invoice_item_disposible_pricePerUnit`, `invoice_total_price`, `invoice_gsttext`, `invoice_grant_total_amount`, `invoice_grant_total_amount_inWords`, `invoice_termAndConditions`, `created_at`, `updated_at`) VALUES
(10, 2, 1, NULL, 'mth-123456', '2024-03-05', '', '[\"1\"]', NULL, NULL, NULL, NULL, '[\"12\"]', NULL, NULL, NULL, NULL, '[\"156757\"]', '5000', NULL, NULL, '[\"payment and cash basis\"]', '2024-03-05 07:13:17', '2024-03-05 07:13:17'),
(11, 3, 1, '[\"1\"]', 'mih/3', '2024-03-05', '', '[\"4\"]', NULL, NULL, NULL, NULL, NULL, '[\"4\"]', '[\"2024-03-19\"]', '[\"45\"]', '[\"45\"]', '[\"4777\"]', '7000', NULL, NULL, '[\"payment and cash basis\"]', '2024-03-05 07:13:41', '2024-03-05 07:13:41'),
(12, 1, 1, NULL, 'mih/1', '2024-03-05', '', '[\"1\"]', '[\"gif-260\"]', '[\"1234567\"]', '[\"LEAKAGE ARE BUTTON HEAD\"]', '[\"Need to replace its button head\"]', NULL, NULL, NULL, NULL, NULL, '[\"50000\"]', NULL, NULL, NULL, '[\"payment and cash basis\"]', '2024-03-05 07:16:08', '2024-03-05 07:16:08'),
(13, NULL, 1, NULL, 'mih/7', '2024-03-05', '', '[\"1\"]', '[\"gif-260\"]', '[\"24455\"]', NULL, '[\"sdkjfhdjskhgsdfkjg\"]', NULL, NULL, NULL, NULL, NULL, '[\"505\"]', '7000', NULL, NULL, '[\"payment and cash basis\"]', '2024-03-05 07:18:47', '2024-03-05 07:18:47'),
(14, NULL, 1, NULL, 'mih/8', '2024-03-05', '', '[\"1\"]', NULL, NULL, NULL, NULL, '[\"13\"]', NULL, NULL, NULL, NULL, '[\"546464\"]', '52', NULL, NULL, '[\"payment and cash basis\"]', '2024-03-05 07:19:36', '2024-03-05 07:19:36'),
(15, NULL, 1, '[\"1\"]', 'mih/9', '2024-03-05', '', '[\"1\"]', NULL, NULL, NULL, NULL, NULL, '[\"1\"]', '[null]', '[\"12\"]', '[\"12\"]', '[\"144\"]', '52', NULL, NULL, '[\"payment and cash basis\"]', '2024-03-05 07:20:30', '2024-03-05 07:20:30'),
(16, 4, 1, NULL, 'mih/10', '2024-03-28', '', '[\"1\"]', '[\"gif-260\"]', '[\"12345566\"]', '[\"ksahfkjasdhfkja\"]', '[\"askfdhasdkjfkdf\"]', NULL, NULL, NULL, NULL, NULL, '[\"5000\"]', '52', NULL, NULL, '[\"payment and cash basis\"]', '2024-03-05 07:37:54', '2024-03-05 07:37:54');

-- --------------------------------------------------------

--
-- Table structure for table `leave_employees`
--

CREATE TABLE `leave_employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_user` bigint(20) UNSIGNED DEFAULT NULL,
  `employee_user` bigint(20) UNSIGNED DEFAULT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `reason` varchar(1000) NOT NULL,
  `leave_duration` tinyint(4) NOT NULL DEFAULT 0,
  `leave_starting_date` date NOT NULL,
  `leave_ending_date` date NOT NULL,
  `leave_status` tinyint(4) NOT NULL DEFAULT 0,
  `read_status` tinyint(4) NOT NULL DEFAULT 0,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `leaveDate` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_employees`
--

INSERT INTO `leave_employees` (`id`, `admin_user`, `employee_user`, `employee_id`, `reason`, `leave_duration`, `leave_starting_date`, `leave_ending_date`, `leave_status`, `read_status`, `approved_by`, `leaveDate`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 1, 'Wedding', 1, '2024-03-04', '2024-03-09', 0, 1, NULL, '2024-03-05', '2024-03-05 04:37:45', '2024-03-05 04:38:00');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_01_14_060628_create_admins_table', 1),
(6, '2024_01_14_062326_create_employees_table', 1),
(7, '2024_01_16_054827_create_permission_tables', 1),
(8, '2024_01_18_024529_create_companies_table', 1),
(9, '2024_01_19_103609_create_clients_table', 1),
(10, '2024_01_20_093751_create_incoming_inspection_reports_table', 1),
(11, '2024_01_20_093954_create_outgoing_inspection_reports_table', 1),
(12, '2024_01_23_031754_create_stock_records_table', 1),
(13, '2024_01_23_031755_create_incoming_and_outgoings_table', 1),
(14, '2024_01_26_023402_create_quotations_table', 1),
(15, '2024_01_29_022019_create_invoices_table', 1),
(16, '2024_01_29_134520_create_deliever_challans_table', 1),
(17, '2024_01_30_070634_create_service_reports_table', 1),
(18, '2024_02_01_091116_create_incoming_and_outgoing_disposibles_table', 1),
(19, '2024_02_02_040308_create_stock_outgoings_table', 1),
(20, '2024_02_03_025053_create_client_account_historys_table', 1),
(21, '2024_02_07_033115_create_attendance_employees_table', 1),
(22, '2024_02_09_042342_create_expenses_table', 1),
(23, '2024_02_09_050426_create_expense_categories_table', 1),
(24, '2024_02_11_045642_create_bank_expenses_table', 1),
(25, '2024_02_12_031715_create_notifications_table', 1),
(26, '2024_02_12_123303_create_employee_details_table', 1),
(27, '2024_02_12_123337_create_admin_details_table', 1),
(28, '2024_02_13_083906_create_leave_employees_table', 1),
(29, '2024_02_29_044759_create_employee_education_informations_table', 1),
(30, '2024_02_29_045903_create_employee_socials_table', 1),
(31, '2024_02_29_050120_create_additional_cources_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\adminside\\Admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `message` varchar(255) NOT NULL,
  `read_status` tinyint(4) NOT NULL DEFAULT 0,
  `readByEmployee` bigint(20) UNSIGNED DEFAULT NULL,
  `readByAdmin` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `message`, `read_status`, `readByEmployee`, `readByAdmin`, `created_at`, `updated_at`) VALUES
(1, 'demo employee Is Created New User', 0, NULL, 1, '2024-03-05 03:17:10', '2024-03-05 03:17:10'),
(2, 'demo employee Is Added New & Product Name Is Biopsy forceps for colono', 0, NULL, 1, '2024-03-05 03:29:43', '2024-03-05 03:29:43'),
(3, 'demo employee Is Added New & Product Name Is Forceps pathratic gastro and bronco scope', 0, NULL, 1, '2024-03-05 03:31:15', '2024-03-05 03:31:15'),
(4, 'demo employee Is Added New & Product Name Is Forceps for colono with spike', 0, NULL, 1, '2024-03-05 03:36:33', '2024-03-05 03:36:33'),
(5, 'demo employee Is Added New & Product Name Is Forceps for colono without spike', 0, NULL, 1, '2024-03-05 03:38:19', '2024-03-05 03:38:19'),
(6, 'demo employee Is Added New & Product Name Is Air/Water bottle Vodel (OSH5)', 0, NULL, 1, '2024-03-05 03:44:50', '2024-03-05 03:44:50'),
(7, 'demo employee Is Added New & Product Name Is Fuse', 0, NULL, 1, '2024-03-05 03:50:25', '2024-03-05 03:50:25'),
(8, 'demo employee Is Created New User', 0, NULL, 1, '2024-03-05 03:57:53', '2024-03-05 03:57:53'),
(9, 'demo employee Is Created New User', 0, NULL, 1, '2024-03-05 03:58:37', '2024-03-05 03:58:37'),
(10, 'demo employee Is Created New User', 0, NULL, 1, '2024-03-05 04:00:15', '2024-03-05 04:00:15'),
(11, 'Aliha Zubair Is Added New & Product Name Is L.G Tube', 0, NULL, 1, '2024-03-05 04:16:39', '2024-03-05 04:16:39'),
(12, 'Aliha Zubair Is Added New & Product Name Is Insertion tube', 0, NULL, 1, '2024-03-05 04:17:12', '2024-03-05 04:17:12'),
(13, 'Aliha Zubair Is Added New & Product Name Is Elevator Wire', 0, NULL, 1, '2024-03-05 04:18:13', '2024-03-05 04:18:13'),
(14, 'Aliha Zubair Is Added New & Product Name Is Trolley', 0, NULL, 1, '2024-03-05 04:20:48', '2024-03-05 04:20:48'),
(15, 'Aliha Zubair Is Added New & Product Name Is Video Processor', 0, NULL, 1, '2024-03-05 04:23:58', '2024-03-05 04:23:58'),
(16, 'Aliha Zubair Is Added New & Product Name Is Light Source 260 series', 0, NULL, 1, '2024-03-05 04:26:09', '2024-03-05 04:26:09'),
(17, 'This item is near by expire: Biopsy forceps for colonoExpire Date is: Mar 05, 2024', 0, NULL, 1, '2024-03-05 04:27:00', '2024-03-05 04:27:00'),
(18, 'This item is near by expire: Forceps pathratic gastro and bronco scopeExpire Date is: Mar 05, 2024', 0, NULL, 1, '2024-03-05 04:27:00', '2024-03-05 04:27:00'),
(19, 'This item is near by expire: Forceps for colono with spikeExpire Date is: Mar 05, 2024', 0, NULL, 1, '2024-03-05 04:27:00', '2024-03-05 04:27:00'),
(20, 'This item is near by expire: Forceps for colono without spikeExpire Date is: Mar 05, 2024', 0, NULL, 1, '2024-03-05 04:27:00', '2024-03-05 04:27:00'),
(21, 'This item is near by expire: Air/Water bottle Vodel (OSH5)Expire Date is: Mar 05, 2024', 0, NULL, 1, '2024-03-05 04:27:00', '2024-03-05 04:27:00'),
(22, 'This item is near by expire: FuseExpire Date is: Mar 05, 2024', 0, NULL, 1, '2024-03-05 04:27:00', '2024-03-05 04:27:00'),
(23, 'This item is near by expire: Biopsy forceps for colonoExpire Date is: Mar 05, 2024', 0, 1, NULL, '2024-03-05 04:27:00', '2024-03-05 04:27:00'),
(24, 'This item is near by expire: Forceps pathratic gastro and bronco scopeExpire Date is: Mar 05, 2024', 0, 1, NULL, '2024-03-05 04:27:00', '2024-03-05 04:27:00'),
(25, 'This item is near by expire: Forceps for colono with spikeExpire Date is: Mar 05, 2024', 0, 1, NULL, '2024-03-05 04:27:00', '2024-03-05 04:27:00'),
(26, 'This item is near by expire: Forceps for colono without spikeExpire Date is: Mar 05, 2024', 0, 1, NULL, '2024-03-05 04:27:00', '2024-03-05 04:27:00'),
(27, 'This item is near by expire: Air/Water bottle Vodel (OSH5)Expire Date is: Mar 05, 2024', 0, 1, NULL, '2024-03-05 04:27:00', '2024-03-05 04:27:00'),
(28, 'This item is near by expire: FuseExpire Date is: Mar 05, 2024', 0, 1, NULL, '2024-03-05 04:27:00', '2024-03-05 04:27:00'),
(35, 'This item is near by expire: Biopsy forceps for colonoExpire Date is: Mar 05, 2024', 0, 3, NULL, '2024-03-05 04:27:00', '2024-03-05 04:27:00'),
(36, 'This item is near by expire: Forceps pathratic gastro and bronco scopeExpire Date is: Mar 05, 2024', 0, 3, NULL, '2024-03-05 04:27:00', '2024-03-05 04:27:00'),
(37, 'This item is near by expire: Forceps for colono with spikeExpire Date is: Mar 05, 2024', 0, 3, NULL, '2024-03-05 04:27:00', '2024-03-05 04:27:00'),
(38, 'This item is near by expire: Forceps for colono without spikeExpire Date is: Mar 05, 2024', 0, 3, NULL, '2024-03-05 04:27:00', '2024-03-05 04:27:00'),
(39, 'This item is near by expire: Air/Water bottle Vodel (OSH5)Expire Date is: Mar 05, 2024', 0, 3, NULL, '2024-03-05 04:27:00', '2024-03-05 04:27:00'),
(40, 'This item is near by expire: FuseExpire Date is: Mar 05, 2024', 0, 3, NULL, '2024-03-05 04:27:00', '2024-03-05 04:27:00'),
(41, 'This item is near by expire: Biopsy forceps for colonoExpire Date is: Mar 05, 2024', 0, 4, NULL, '2024-03-05 04:27:01', '2024-03-05 04:27:01'),
(42, 'This item is near by expire: Forceps pathratic gastro and bronco scopeExpire Date is: Mar 05, 2024', 0, 4, NULL, '2024-03-05 04:27:01', '2024-03-05 04:27:01'),
(43, 'This item is near by expire: Forceps for colono with spikeExpire Date is: Mar 05, 2024', 0, 4, NULL, '2024-03-05 04:27:01', '2024-03-05 04:27:01'),
(44, 'This item is near by expire: Forceps for colono without spikeExpire Date is: Mar 05, 2024', 0, 4, NULL, '2024-03-05 04:27:01', '2024-03-05 04:27:01'),
(45, 'This item is near by expire: Air/Water bottle Vodel (OSH5)Expire Date is: Mar 05, 2024', 0, 4, NULL, '2024-03-05 04:27:01', '2024-03-05 04:27:01'),
(46, 'This item is near by expire: FuseExpire Date is: Mar 05, 2024', 0, 4, NULL, '2024-03-05 04:27:01', '2024-03-05 04:27:01'),
(47, 'This item is near by expire: Biopsy forceps for colonoExpire Date is: Mar 05, 2024', 0, 5, NULL, '2024-03-05 04:27:01', '2024-03-05 04:27:01'),
(48, 'This item is near by expire: Forceps pathratic gastro and bronco scopeExpire Date is: Mar 05, 2024', 0, 5, NULL, '2024-03-05 04:27:01', '2024-03-05 04:27:01'),
(49, 'This item is near by expire: Forceps for colono with spikeExpire Date is: Mar 05, 2024', 0, 5, NULL, '2024-03-05 04:27:01', '2024-03-05 04:27:01'),
(50, 'This item is near by expire: Forceps for colono without spikeExpire Date is: Mar 05, 2024', 0, 5, NULL, '2024-03-05 04:27:01', '2024-03-05 04:27:01'),
(51, 'This item is near by expire: Air/Water bottle Vodel (OSH5)Expire Date is: Mar 05, 2024', 0, 5, NULL, '2024-03-05 04:27:01', '2024-03-05 04:27:01'),
(52, 'This item is near by expire: FuseExpire Date is: Mar 05, 2024', 0, 5, NULL, '2024-03-05 04:27:01', '2024-03-05 04:27:01'),
(53, 'Aliha Zubair Is Updated & Product Name Is Video Processor 260 series', 0, NULL, 1, '2024-03-05 04:29:06', '2024-03-05 04:29:06'),
(54, 'Aliha Zubair Is Attendance Timein', 0, NULL, 1, '2024-03-05 04:31:52', '2024-03-05 04:31:52'),
(55, 'Aliha Zubair Is Attendance Timeout Attendance', 0, NULL, 1, '2024-03-05 04:32:41', '2024-03-05 04:32:41'),
(56, 'Aliha Zubair Is Attendance Timein', 0, NULL, 1, '2024-03-05 04:34:40', '2024-03-05 04:34:40'),
(57, 'Aliha Zubair Is Attendance Timeout Attendance', 0, NULL, 1, '2024-03-05 04:35:40', '2024-03-05 04:35:40'),
(58, 'Aliha Zubair Is Created New Leave & Employee Id Is 1', 0, NULL, 1, '2024-03-05 04:37:45', '2024-03-05 04:37:45'),
(59, 'Aliha Zubair Is Created New Office Expense', 0, NULL, 1, '2024-03-05 04:45:45', '2024-03-05 04:45:45'),
(60, 'Aliha Zubair Is Created New Inspection Report Scope Model Is GIF-XQ140 & Serial Number Is 2600083', 0, NULL, 1, '2024-03-05 05:00:49', '2024-03-05 05:00:49'),
(61, 'Aliha Zubair Is Incoming Scope GIF-XQ140 & Serial Number Is 2600083', 0, NULL, 1, '2024-03-05 05:51:04', '2024-03-05 05:51:04'),
(62, 'Aliha Zubair Is Added New & Product Name Is GIF-XQ140', 0, NULL, 1, '2024-03-05 05:51:43', '2024-03-05 05:51:43'),
(63, 'Aliha Zubair Is Product Name Is L.G Tube Exit Product And Current Qtv Is 0', 0, NULL, 1, '2024-03-05 05:52:11', '2024-03-05 05:52:11'),
(64, 'Aliha Zubair Is Created New Inspection Report Scope Model Is GIF-XQ140 & Serial Number Is 4564564', 0, NULL, 1, '2024-03-05 05:53:30', '2024-03-05 05:53:30'),
(65, 'Aliha Zubair Is Outgoing Inspection Report Scope Model Is GIF-XQ140 & Serial Number Is 2600083', 0, NULL, 1, '2024-03-05 05:57:07', '2024-03-05 05:57:07'),
(66, 'Aliha Zubair Is Outgoing Scope GIF-XQ140 & Serial Number Is 2600083', 0, NULL, 1, '2024-03-05 05:58:35', '2024-03-05 05:58:35'),
(67, 'Aliha Zubair Is Incoming Scope GIF-XQ140 & Serial Number Is 4564564', 0, NULL, 1, '2024-03-05 06:01:03', '2024-03-05 06:01:03'),
(68, 'Aliha Zubair Is Outgoing Inspection Report Scope Model Is GIF-XQ140 & Serial Number Is 4564564', 0, NULL, 1, '2024-03-05 06:01:48', '2024-03-05 06:01:48'),
(69, 'Aliha Zubair Is Outgoing Scope GIF-XQ140 & Serial Number Is 4564564', 0, NULL, 1, '2024-03-05 06:03:10', '2024-03-05 06:03:10'),
(70, 'Aliha Zubair Is Incoming Biopsy Forcep Reuseable', 0, NULL, 1, '2024-03-05 06:08:28', '2024-03-05 06:08:28'),
(71, 'Aliha Zubair Is Outgoing Biopsy Forcep Reuseable', 0, NULL, 1, '2024-03-05 06:09:26', '2024-03-05 06:09:26'),
(72, 'Aliha Zubair Is Created New Inspection Report Scope Model Is GIF-XQ140 & Serial Number Is 123456789', 0, NULL, 1, '2024-03-05 06:18:22', '2024-03-05 06:18:22'),
(73, 'Aliha Zubair Is Incoming Scope GIF-XQ140 & Serial Number Is 123456789', 0, NULL, 1, '2024-03-05 06:22:48', '2024-03-05 06:22:48'),
(74, 'Aliha Zubair Is Product Name Is Insertion tube Exit Product And Current Qtv Is 0', 0, NULL, 1, '2024-03-05 06:23:16', '2024-03-05 06:23:16'),
(75, 'Aliha Zubair Is Added New & Product Name Is GIF-XQ140', 0, NULL, 1, '2024-03-05 06:23:49', '2024-03-05 06:23:49'),
(76, 'Aliha Zubair Is Outgoing Inspection Report Scope Model Is GIF-XQ140 & Serial Number Is 123456789', 0, NULL, 1, '2024-03-05 06:27:16', '2024-03-05 06:27:16'),
(77, 'Aliha Zubair Is Outgoing Scope GIF-XQ140 & Serial Number Is 123456789', 0, NULL, 1, '2024-03-05 06:28:23', '2024-03-05 06:28:23'),
(78, 'Aliha Zubair Is Incoming Video Processor 140 series', 0, NULL, 1, '2024-03-05 06:30:45', '2024-03-05 06:30:45'),
(79, 'Aliha Zubair Is Outgoing Video Processor 140 series', 0, NULL, 1, '2024-03-05 06:32:39', '2024-03-05 06:32:39'),
(80, 'Aliha Zubair Is Created Service Report Gastro scope', 0, NULL, 1, '2024-03-05 06:38:04', '2024-03-05 06:38:04'),
(81, 'Aliha Zubair Is Created Repairing Quotation mih/1', 0, NULL, 1, '2024-03-05 06:44:37', '2024-03-05 06:44:37'),
(82, 'Aliha Zubair Is Created Repairing Invoice mih/1', 0, NULL, 1, '2024-03-05 06:46:29', '2024-03-05 06:46:29'),
(83, 'Aliha Zubair Is Created Repairing Invoice mih/1', 0, NULL, 1, '2024-03-05 06:49:07', '2024-03-05 06:49:07'),
(84, 'Aliha Zubair Is Created Repairing Invoice mih/1', 0, NULL, 1, '2024-03-05 06:53:06', '2024-03-05 06:53:06'),
(85, 'Aliha Zubair Is Created Repairing Invoice mih/2', 0, NULL, 1, '2024-03-05 06:54:37', '2024-03-05 06:54:37'),
(86, 'Aliha Zubair Is Created Repairing Invoice mih/1', 0, NULL, 1, '2024-03-05 07:02:48', '2024-03-05 07:02:48'),
(87, 'Aliha Zubair Is Created System Quotation mth-123456', 0, NULL, 1, '2024-03-05 07:05:22', '2024-03-05 07:05:22'),
(88, 'Aliha Zubair Is Created System Invoice mth-123456', 0, NULL, 1, '2024-03-05 07:06:31', '2024-03-05 07:06:31'),
(89, 'Aliha Zubair Is Created Disposible Quotation mih/3', 0, NULL, 1, '2024-03-05 07:08:45', '2024-03-05 07:08:45'),
(90, 'Aliha Zubair Is Created Disposible Invoice mih/3', 0, NULL, 1, '2024-03-05 07:10:16', '2024-03-05 07:10:16'),
(91, 'Aliha Zubair Is Created Repairing Invoice mih/7', 0, NULL, 1, '2024-03-05 07:18:47', '2024-03-05 07:18:47'),
(92, 'Aliha Zubair Is Created System Invoice mih/8', 0, NULL, 1, '2024-03-05 07:19:36', '2024-03-05 07:19:36'),
(93, 'Aliha Zubair Is Created Disposible Invoice mih/9', 0, NULL, 1, '2024-03-05 07:20:30', '2024-03-05 07:20:30'),
(94, 'Aliha Zubair Is added balance in this client demo client', 0, NULL, 1, '2024-03-05 07:21:56', '2024-03-05 07:21:56'),
(95, 'Aliha Zubair Is added balance in this client demo client', 0, NULL, 1, '2024-03-05 07:22:14', '2024-03-05 07:22:14'),
(96, 'Aliha Zubair Is added balance in this client demo client', 0, NULL, 1, '2024-03-05 07:22:56', '2024-03-05 07:22:56'),
(97, 'Aliha Zubair Is added balance in this client demo client', 0, NULL, 1, '2024-03-05 07:23:15', '2024-03-05 07:23:15'),
(98, 'Aliha Zubair Is added balance in this client demo client', 0, NULL, 1, '2024-03-05 07:23:33', '2024-03-05 07:23:33'),
(99, 'Aliha Zubair Is added balance in this client demo client', 0, NULL, 1, '2024-03-05 07:23:53', '2024-03-05 07:23:53'),
(100, 'Aliha Zubair Is Created Delivery Challan hjfghf', 0, NULL, 1, '2024-03-05 07:24:13', '2024-03-05 07:24:13'),
(101, 'Aliha Zubair Is Created Delivery Challan hjfghf54', 0, NULL, 1, '2024-03-05 07:26:17', '2024-03-05 07:26:17'),
(102, 'Aliha Zubair Is Product Name Is Light Source 260 series Exit Product And Current Qtv Is 0', 0, NULL, 1, '2024-03-05 07:26:45', '2024-03-05 07:26:45'),
(103, 'Aliha Zubair Is Added New & Product Name Is Biopsy cap', 0, NULL, 1, '2024-03-06 03:57:23', '2024-03-06 03:57:23'),
(104, 'Aliha Zubair Is Added New & Product Name Is Stock cook', 0, NULL, 1, '2024-03-06 03:58:26', '2024-03-06 03:58:26'),
(105, 'Aliha Zubair Is Added New & Product Name Is ETO Wanting Cap', 0, NULL, 1, '2024-03-06 03:59:47', '2024-03-06 03:59:47'),
(106, 'Aliha Zubair Is Added New & Product Name Is Air/water and section valve', 0, NULL, 1, '2024-03-06 04:00:56', '2024-03-06 04:00:56'),
(107, 'Aliha Zubair Is Added New & Product Name Is water resistance cap', 0, NULL, 1, '2024-03-06 04:02:06', '2024-03-06 04:02:06'),
(108, 'Aliha Zubair Is Added New & Product Name Is TJF tip cover Japab', 0, NULL, 1, '2024-03-06 04:03:19', '2024-03-06 04:03:19'),
(109, 'Aliha Zubair Is Added New & Product Name Is FCN-scope Button Fiber Optic', 0, NULL, 1, '2024-03-06 04:04:28', '2024-03-06 04:04:28'),
(110, 'Aliha Zubair Is Added New & Product Name Is Section Button', 0, NULL, 1, '2024-03-06 04:05:32', '2024-03-06 04:05:32'),
(111, 'Aliha Zubair Is Added New & Product Name Is Air/ Water valve', 0, NULL, 1, '2024-03-06 04:06:34', '2024-03-06 04:06:34'),
(112, 'Aliha Zubair Is Added New & Product Name Is Biopsy cap for Fiujinon', 0, NULL, 1, '2024-03-06 04:07:43', '2024-03-06 04:07:43'),
(113, 'Aliha Zubair Is Added New & Product Name Is Polypectomy snare', 0, NULL, 1, '2024-03-06 04:08:37', '2024-03-06 04:08:37'),
(114, 'Aliha Zubair Is Added New & Product Name Is Air/water valves 100 series scopes', 0, NULL, 1, '2024-03-06 04:14:22', '2024-03-06 04:14:22'),
(115, 'Aliha Zubair Is Updated & Product Name Is Biopsy cap', 0, NULL, 1, '2024-03-06 04:19:44', '2024-03-06 04:19:44'),
(116, 'Aliha Zubair Is Updated & Product Name Is Stock cookQuantities Is 1', 0, NULL, 1, '2024-03-06 04:21:49', '2024-03-06 04:21:49'),
(117, 'Aliha Zubair Is Added New & Product Name Is Biopsy cap Reusable', 0, NULL, 1, '2024-03-06 04:23:45', '2024-03-06 04:23:45'),
(118, 'Aliha Zubair Is Added New & Product Name Is Section valve 140 series', 0, NULL, 1, '2024-03-06 04:24:40', '2024-03-06 04:24:40'),
(119, 'Aliha Zubair Is Added New & Product Name Is Air/water valve 140 series', 0, NULL, 1, '2024-03-06 04:25:33', '2024-03-06 04:25:33'),
(120, 'Aliha Zubair Is Added New & Product Name Is Air/water valves', 0, NULL, 1, '2024-03-06 04:26:15', '2024-03-06 04:26:15'),
(121, 'Aliha Zubair Is Added New & Product Name Is Air/ water valve 140 series', 0, NULL, 1, '2024-03-06 04:27:16', '2024-03-06 04:27:16'),
(122, 'Aliha Zubair Is Added New & Product Name Is Mouth piece', 0, NULL, 1, '2024-03-06 04:28:10', '2024-03-06 04:28:10'),
(123, 'Aliha Zubair Is Added New & Product Name Is Mouth piece reusable for peeds', 0, NULL, 1, '2024-03-06 04:29:26', '2024-03-06 04:29:26'),
(124, 'Aliha Zubair Is Added New & Product Name Is Moth piece Dis', 0, NULL, 1, '2024-03-06 04:30:50', '2024-03-06 04:30:50'),
(125, 'Aliha Zubair Is Added New & Product Name Is Biopsy cap for bronco scope', 0, NULL, 1, '2024-03-06 04:31:56', '2024-03-06 04:31:56'),
(126, 'Aliha Zubair Is Added New & Product Name Is Biopsy cap Olympus', 0, NULL, 1, '2024-03-06 04:32:30', '2024-03-06 04:32:30'),
(127, 'Aliha Zubair Is Added New & Product Name Is Section button for cysto scope', 0, NULL, 1, '2024-03-06 04:33:27', '2024-03-06 04:33:27'),
(128, 'Aliha Zubair Is Added New & Product Name Is Leakage taster concenter', 0, NULL, 1, '2024-03-06 04:34:08', '2024-03-06 04:34:08'),
(129, 'Aliha Zubair Is Added New & Product Name Is Wanting cap', 0, NULL, 1, '2024-03-06 04:34:42', '2024-03-06 04:34:42'),
(130, 'Aliha Zubair Is Added New & Product Name Is Section valve 140 series (Reusable)', 0, NULL, 1, '2024-03-06 04:35:48', '2024-03-06 04:35:48'),
(131, 'Aliha Zubair Is Added New & Product Name Is Air/water and section valves', 0, NULL, 1, '2024-03-06 04:36:43', '2024-03-06 04:36:43'),
(132, 'Aliha Zubair Is Added New & Product Name Is Cleaning Brush', 0, NULL, 1, '2024-03-06 04:37:22', '2024-03-06 04:37:22'),
(133, 'Aliha Zubair Is Added New & Product Name Is Channel Cleaning brush for (ENF,ENT) scope', 0, NULL, 1, '2024-03-06 04:40:00', '2024-03-06 04:40:00'),
(134, 'Aliha Zubair Is Added New & Product Name Is Channel Cleaning brush', 0, NULL, 1, '2024-03-06 04:41:41', '2024-03-06 04:41:41'),
(135, 'Aliha Zubair Is Added New & Product Name Is Cleaning brush for cysto scope', 0, NULL, 1, '2024-03-06 04:42:29', '2024-03-06 04:42:29'),
(136, 'Aliha Zubair Is Added New & Product Name Is Cleaning brush for gastro and colono scope', 0, NULL, 1, '2024-03-06 04:43:12', '2024-03-06 04:43:12'),
(137, 'Aliha Zubair Is Added New & Product Name Is Grasping forcep', 0, NULL, 1, '2024-03-06 04:44:06', '2024-03-06 04:44:06'),
(138, 'Aliha Zubair Is Added New & Product Name Is Magnetic forceps', 0, NULL, 1, '2024-03-06 04:45:09', '2024-03-06 04:45:09'),
(139, 'Aliha Zubair Is Added New & Product Name Is Air/ water channel cleaning adopter', 0, NULL, 1, '2024-03-06 04:46:11', '2024-03-06 04:46:11'),
(140, 'Aliha Zubair Is Added New & Product Name Is Channel Cleaning Brush Olympus', 0, NULL, 1, '2024-03-06 04:46:57', '2024-03-06 04:46:57'),
(141, 'Aliha Zubair Is Added New & Product Name Is Bands wire', 0, NULL, 1, '2024-03-06 04:49:03', '2024-03-06 04:49:03'),
(142, 'Aliha Zubair Is Updated & Product Name Is Biopsy forceps for colonoQuantities Is 5', 0, NULL, 1, '2024-03-06 05:16:10', '2024-03-06 05:16:10'),
(143, 'Aliha Zubair Is Updated & Product Name Is Forceps pathratic gastro and bronco scopeQuantities Is 8', 0, NULL, 1, '2024-03-06 05:16:30', '2024-03-06 05:16:30'),
(144, 'Aliha Zubair Is Updated & Product Name Is Forceps for colono with spikeQuantities Is 1', 0, NULL, 1, '2024-03-06 05:16:45', '2024-03-06 05:16:45'),
(145, 'Aliha Zubair Is Updated & Product Name Is Forceps for colono without spikeQuantities Is 1', 0, NULL, 1, '2024-03-06 05:17:06', '2024-03-06 05:17:06'),
(146, 'Aliha Zubair Is Updated & Product Name Is Air/Water bottle Vodel (OSH5)Quantities Is 1', 0, NULL, 1, '2024-03-06 05:17:22', '2024-03-06 05:17:22'),
(147, 'Aliha Zubair Is Updated & Product Name Is Fuse', 0, NULL, 1, '2024-03-06 05:17:42', '2024-03-06 05:17:42'),
(148, 'Aliha Zubair Is Added New & Product Name Is Stant Amsterdam 1', 0, NULL, 1, '2024-03-06 05:52:58', '2024-03-06 05:52:58'),
(149, 'Aliha Zubair Is Added New & Product Name Is Stant Amsterdam 2', 0, NULL, 1, '2024-03-06 05:53:40', '2024-03-06 05:53:40'),
(150, 'Aliha Zubair Is Added New & Product Name Is Stant Amsterdam 3', 0, NULL, 1, '2024-03-06 05:54:43', '2024-03-06 05:54:43'),
(151, 'Aliha Zubair Is Added New & Product Name Is Stant Amsterdam, 3', 0, NULL, 1, '2024-03-06 05:56:37', '2024-03-06 05:56:37'),
(152, 'Aliha Zubair Is Added New & Product Name Is Stant Amsterdam, 5', 0, NULL, 1, '2024-03-12 01:51:01', '2024-03-12 01:51:01'),
(153, 'Aliha Zubair Is Added New & Product Name Is Stant Amsterdam, 6', 0, NULL, 1, '2024-03-12 01:51:37', '2024-03-12 01:51:37');

-- --------------------------------------------------------

--
-- Table structure for table `outgoing_inspection_reports`
--

CREATE TABLE `outgoing_inspection_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `incoming_report_id` bigint(20) UNSIGNED NOT NULL,
  `scope_model` varchar(300) NOT NULL,
  `scope_incoming_date` date NOT NULL,
  `scope_sr_number` varchar(255) NOT NULL,
  `sender_name` varchar(255) NOT NULL,
  `scope_sending_with` longtext NOT NULL,
  `scope_leakage` tinyint(4) NOT NULL DEFAULT 0,
  `scope_view` tinyint(4) NOT NULL DEFAULT 0,
  `scope_lightguide` tinyint(4) NOT NULL DEFAULT 0,
  `scope_airwater` tinyint(4) NOT NULL DEFAULT 0,
  `scope_angulation` tinyint(4) NOT NULL DEFAULT 0,
  `scope_lgtube` tinyint(4) NOT NULL DEFAULT 0,
  `scope_insertiontube` tinyint(4) NOT NULL DEFAULT 0,
  `scope_biopsychannel` tinyint(4) NOT NULL DEFAULT 0,
  `scope_objectivelenz` tinyint(4) NOT NULL DEFAULT 0,
  `scope_suction` tinyint(4) NOT NULL DEFAULT 0,
  `scope_angulation_lock` tinyint(4) NOT NULL DEFAULT 0,
  `scope_freezing_buttons` tinyint(4) NOT NULL DEFAULT 0,
  `scope_tjf_elevator_channel` tinyint(4) DEFAULT NULL,
  `scope_tjf_elevator_wire` tinyint(4) DEFAULT NULL,
  `scope_tjf_elevator_axel` tinyint(4) DEFAULT NULL,
  `scope_tjf_tip_cover` tinyint(4) DEFAULT NULL,
  `scope_tjf_elevator_clinder` tinyint(4) DEFAULT NULL,
  `scope_tjf_liver` tinyint(4) DEFAULT NULL,
  `remarks` longtext NOT NULL,
  `inspectedby_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `outgoing_inspection_reports`
--

INSERT INTO `outgoing_inspection_reports` (`id`, `incoming_report_id`, `scope_model`, `scope_incoming_date`, `scope_sr_number`, `sender_name`, `scope_sending_with`, `scope_leakage`, `scope_view`, `scope_lightguide`, `scope_airwater`, `scope_angulation`, `scope_lgtube`, `scope_insertiontube`, `scope_biopsychannel`, `scope_objectivelenz`, `scope_suction`, `scope_angulation_lock`, `scope_freezing_buttons`, `scope_tjf_elevator_channel`, `scope_tjf_elevator_wire`, `scope_tjf_elevator_axel`, `scope_tjf_tip_cover`, `scope_tjf_elevator_clinder`, `scope_tjf_liver`, `remarks`, `inspectedby_id`, `company_id`, `created_at`, `updated_at`) VALUES
(2, 1, 'GIF-XQ140', '2024-03-20', '2600083', 'Dr, Zubair Mulgani Sb', 'Black Bag', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '1- Leakage are Buttons Head.\r\n2- Light Guide 70% ok\r\n3- Insertion tube 40 to 50 Area Punch', 5, 3, '2024-03-05 05:57:07', '2024-03-05 05:57:07'),
(3, 2, 'GIF-XQ140', '2024-03-21', '4564564', 'Dr, Zubairsad', 'd', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'sdasdasdasdasd', 5, 3, '2024-03-05 06:01:48', '2024-03-05 06:01:48'),
(4, 3, 'GIF-XQ140', '2024-03-05', '123456789', 'Dr, Zubairsad', 'hfghfhgfgd', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'nfhgfddfghdghdghgdgh', 5, 3, '2024-03-05 06:27:16', '2024-03-05 06:27:16');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE `quotations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `item_id` longtext DEFAULT NULL,
  `quotation_number` varchar(255) NOT NULL,
  `quotation_date` date NOT NULL,
  `quotation_heading` varchar(1000) NOT NULL,
  `quotation_item_srNumber` longtext NOT NULL,
  `quotation_scope_model` longtext DEFAULT NULL,
  `quotation_scope_srno` longtext DEFAULT NULL,
  `quotation_scope_problem` longtext DEFAULT NULL,
  `quotation_need_work` longtext DEFAULT NULL,
  `quotation_item_decription` longtext DEFAULT NULL,
  `quotation_item_disposible_batchNo` longtext DEFAULT NULL,
  `quotation_item_disposible_expDate` longtext DEFAULT NULL,
  `quotation_item_disposible_qtv` longtext DEFAULT NULL,
  `quotation_item_disposible_pricePerUnit` longtext DEFAULT NULL,
  `quotation_total_price` longtext NOT NULL,
  `quotation_gsttext` varchar(255) DEFAULT NULL,
  `quotation_grant_total_amount` varchar(255) DEFAULT NULL,
  `quotation_grant_total_amount_inWords` varchar(1000) DEFAULT NULL,
  `quotation_termAndConditions` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quotations`
--

INSERT INTO `quotations` (`id`, `client_id`, `item_id`, `quotation_number`, `quotation_date`, `quotation_heading`, `quotation_item_srNumber`, `quotation_scope_model`, `quotation_scope_srno`, `quotation_scope_problem`, `quotation_need_work`, `quotation_item_decription`, `quotation_item_disposible_batchNo`, `quotation_item_disposible_expDate`, `quotation_item_disposible_qtv`, `quotation_item_disposible_pricePerUnit`, `quotation_total_price`, `quotation_gsttext`, `quotation_grant_total_amount`, `quotation_grant_total_amount_inWords`, `quotation_termAndConditions`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'mih/1', '2024-03-05', '', '[\"1\"]', '[\"gif-260\"]', '[\"1234567\"]', '[\"LEAKAGE ARE BUTTON HEAD\"]', '[\"Need to replace its button head\"]', NULL, NULL, NULL, NULL, NULL, '[\"50000\"]', '5000', NULL, NULL, '[\"payment and cash basis\"]', '2024-03-05 06:44:37', '2024-03-05 06:44:37'),
(2, 1, NULL, 'mth-123456', '2024-03-05', '', '[\"1\",\"2\",\"3\"]', NULL, NULL, NULL, NULL, '[\"11\",\"13\",\"12\"]', NULL, NULL, NULL, NULL, '[\"1200000\",null,null]', '5000', NULL, NULL, '[\"payment and cash basis\"]', '2024-03-05 07:05:22', '2024-03-05 07:05:22'),
(3, 1, '[\"1\"]', 'mih/3', '2024-03-05', '', '[\"1\"]', NULL, NULL, NULL, NULL, NULL, '[\"00000\"]', '[\"2024-08-21\"]', '[\"1\"]', '[\"25000\"]', '[\"25000\"]', '7000', NULL, NULL, '[\"payment and cash basis\"]', '2024-03-05 07:08:45', '2024-03-05 07:08:45'),
(4, 1, NULL, 'mih/10', '2024-03-28', '', '[\"1\"]', '[\"gif-260\"]', '[\"12345566\"]', '[\"ksahfkjasdhfkja\"]', '[\"askfdhasdkjfkdf\"]', NULL, NULL, NULL, NULL, NULL, '[\"5000\"]', '20', NULL, NULL, '[\"payment and cash basis\"]', '2024-03-05 07:37:35', '2024-03-05 07:37:35');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', '2024-03-05 02:41:49', '2024-03-05 02:41:49');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_reports`
--

CREATE TABLE `service_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_date` date NOT NULL,
  `equiment_name` varchar(500) NOT NULL,
  `equiment_model` varchar(500) NOT NULL,
  `equiment_srNo` varchar(500) NOT NULL,
  `service_report_item_srNumber` longtext NOT NULL,
  `service_report_item_question` longtext NOT NULL,
  `service_report_item_answer` longtext NOT NULL,
  `service_report_anycomment` varchar(1000) NOT NULL,
  `service_report_name` varchar(255) NOT NULL,
  `service_report_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_reports`
--

INSERT INTO `service_reports` (`id`, `invoice_client_id`, `service_date`, `equiment_name`, `equiment_model`, `equiment_srNo`, `service_report_item_srNumber`, `service_report_item_question`, `service_report_item_answer`, `service_report_anycomment`, `service_report_name`, `service_report_date`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-03-05', 'Gastro scope', 'GIF-260', '12345767', '[\"1\"]', '[\"Scope is all ok\"]', '[\"Yes\"]', 'All ok Scope', 'Aqil Murad', '2024-03-05', '2024-03-05 06:38:04', '2024-03-05 06:38:04');

-- --------------------------------------------------------

--
-- Table structure for table `stock_outgoings`
--

CREATE TABLE `stock_outgoings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `inspection_id` bigint(20) UNSIGNED DEFAULT NULL,
  `solid_qtv` int(11) NOT NULL,
  `solid_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_outgoings`
--

INSERT INTO `stock_outgoings` (`id`, `item_id`, `invoice_id`, `inspection_id`, `solid_qtv`, `solid_date`, `created_at`, `updated_at`) VALUES
(1, 7, NULL, 1, 1, '2024-03-01', '2024-03-05 05:52:11', '2024-03-05 05:52:11'),
(2, 8, NULL, 3, 1, '2024-03-06', '2024-03-05 06:23:16', '2024-03-05 06:23:16'),
(3, 12, 10, NULL, 1, '2024-03-05', '2024-03-05 07:26:45', '2024-03-05 07:26:45');

-- --------------------------------------------------------

--
-- Table structure for table `stock_records`
--

CREATE TABLE `stock_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `incoming_report_ids` bigint(20) UNSIGNED DEFAULT NULL,
  `item_incomingdate` date NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_model` varchar(255) DEFAULT NULL,
  `item_srno` varchar(255) DEFAULT NULL,
  `item_companyname` varchar(255) DEFAULT NULL,
  `item_batchNo` varchar(255) DEFAULT NULL,
  `item_expDate` varchar(255) DEFAULT NULL,
  `item_qtv` int(11) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `part_companyname` varchar(255) DEFAULT NULL,
  `item_scope_model` varchar(255) DEFAULT NULL,
  `ratePerUnit` varchar(255) DEFAULT NULL,
  `totalAmount` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_records`
--

INSERT INTO `stock_records` (`id`, `incoming_report_ids`, `item_incomingdate`, `item_name`, `item_model`, `item_srno`, `item_companyname`, `item_batchNo`, `item_expDate`, `item_qtv`, `size`, `part_companyname`, `item_scope_model`, `ratePerUnit`, `totalAmount`, `created_at`, `updated_at`) VALUES
(1, NULL, '2024-03-06', 'Biopsy forceps for colono', NULL, NULL, NULL, '1234567', '2024-03-05', 5, '2.3mm', NULL, NULL, '0', '0.00', '2024-03-05 03:29:43', '2024-03-06 05:16:10'),
(2, NULL, '2024-03-06', 'Forceps pathratic gastro and bronco scope', NULL, NULL, NULL, '2345678', '2024-03-05', 8, '1.8mm', NULL, NULL, '0', '0.00', '2024-03-05 03:31:15', '2024-03-06 05:16:30'),
(3, NULL, '2024-03-06', 'Forceps for colono with spike', NULL, NULL, NULL, '345678', '2024-03-05', 1, '2.3mm', NULL, NULL, '0', '0.00', '2024-03-05 03:36:33', '2024-03-06 05:16:45'),
(4, NULL, '2024-03-06', 'Forceps for colono without spike', NULL, NULL, NULL, '4567890', '2024-03-05', 1, '2300mm', NULL, NULL, '0', '0.00', '2024-03-05 03:38:19', '2024-03-06 05:17:06'),
(5, NULL, '2024-03-06', 'Air/Water bottle Vodel (OSH5)', NULL, NULL, NULL, 'Pentax', '2024-03-05', 1, '200ser', NULL, NULL, '0', '0.00', '2024-03-05 03:44:50', '2024-03-06 05:17:22'),
(6, NULL, '2024-03-06', 'Fuse', NULL, NULL, NULL, 'china', '2024-03-05', 2, NULL, NULL, NULL, '0', '0.00', '2024-03-05 03:50:25', '2024-03-06 05:17:42'),
(7, NULL, '2024-03-05', 'L.G Tube', NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Olympus Japan', NULL, NULL, '0', '2024-03-05 04:16:39', '2024-03-05 05:52:11'),
(8, NULL, '2024-03-05', 'Insertion tube', NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Olympus Japan', NULL, NULL, '0', '2024-03-05 04:17:12', '2024-03-05 06:23:16'),
(9, NULL, '2024-03-05', 'Elevator Wire', NULL, NULL, NULL, NULL, NULL, 1, NULL, 'China', NULL, NULL, NULL, '2024-03-05 04:18:13', '2024-03-05 04:18:13'),
(10, NULL, '2024-03-05', 'Trolley', 'WM60', '00000', 'Olympus', NULL, NULL, 1, NULL, NULL, NULL, '0', '0.00', '2024-03-05 04:20:48', '2024-03-05 04:20:48'),
(11, NULL, '2024-03-05', 'Video Processor 260 series', 'Cv-260SL', '7149871', 'Olympus', NULL, NULL, 1, NULL, NULL, NULL, '0', '0.00', '2024-03-05 04:23:58', '2024-03-05 04:29:06'),
(12, NULL, '2024-03-05', 'Light Source 260 series', 'CLV-260SL', '7112899', 'Olympus', NULL, NULL, 0, NULL, NULL, NULL, '0', '0', '2024-03-05 04:26:09', '2024-03-05 07:26:45'),
(13, 1, '2024-03-05', 'GIF-XQ140', NULL, '2600083', 'oly', NULL, NULL, 1, NULL, NULL, 'GIF-XQ140', '0', '0.00', '2024-03-05 05:51:43', '2024-03-05 05:51:43'),
(14, 3, '2024-03-05', 'GIF-XQ140', NULL, '123456789', 'olympus', NULL, NULL, 1, NULL, NULL, 'GIF-XQ140', '0', '0.00', '2024-03-05 06:23:49', '2024-03-05 06:23:49'),
(15, NULL, '2024-03-06', 'Biopsy cap', NULL, NULL, NULL, 'Pentax', '2024-03-06', 1, NULL, NULL, NULL, '0', '0.00', '2024-03-06 03:57:23', '2024-03-06 04:19:44'),
(16, NULL, '2024-03-06', 'Stock cook', NULL, NULL, NULL, 'Pentax', '2024-03-06', 1, 'Mod: OS-A63', NULL, NULL, '0', '0.00', '2024-03-06 03:58:26', '2024-03-06 04:21:49'),
(17, NULL, '2024-03-06', 'ETO Wanting Cap', NULL, NULL, NULL, 'Pentax', '2024-03-06', 1, 'Mod: OFC5', NULL, NULL, '0', '0.00', '2024-03-06 03:59:47', '2024-03-06 03:59:47'),
(18, NULL, '2024-03-06', 'Air/water and section valve', NULL, NULL, NULL, 'Pentax', '2024-03-06', 1, NULL, NULL, NULL, '0', '0.00', '2024-03-06 04:00:56', '2024-03-06 04:00:56'),
(19, NULL, '2024-03-06', 'water resistance cap', NULL, NULL, NULL, 'Pentax', '2024-03-06', 2, NULL, NULL, NULL, '0', '0.00', '2024-03-06 04:02:06', '2024-03-06 04:02:06'),
(20, NULL, '2024-03-06', 'TJF tip cover Japab', NULL, NULL, NULL, 'Pentax', '2024-03-06', 1, 'Mod: OF-A39', NULL, NULL, '0', '0.00', '2024-03-06 04:03:19', '2024-03-06 04:03:19'),
(21, NULL, '2024-03-06', 'FCN-scope Button Fiber Optic', NULL, NULL, NULL, 'Pentax', '2024-03-06', 1, 'Mod: ECN-1530', NULL, NULL, '0', '0.00', '2024-03-06 04:04:28', '2024-03-06 04:04:28'),
(22, NULL, '2024-03-06', 'Section Button', NULL, NULL, NULL, 'Pentax', '2024-03-06', 1, 'Mod: OF-13136', NULL, NULL, '0', '0.00', '2024-03-06 04:05:32', '2024-03-06 04:05:32'),
(23, NULL, '2024-03-06', 'Air/ Water valve', NULL, NULL, NULL, 'Fiujinon', '2024-03-06', 3, NULL, NULL, NULL, '0', '0.00', '2024-03-06 04:06:34', '2024-03-06 04:06:34'),
(24, NULL, '2024-03-06', 'Biopsy cap for Fiujinon', NULL, NULL, NULL, 'Fiujinon', '2024-03-06', 1, NULL, NULL, NULL, '0', '0.00', '2024-03-06 04:07:43', '2024-03-06 04:07:43'),
(25, NULL, '2024-03-06', 'Polypectomy snare', NULL, NULL, NULL, 'Pentax', '2024-03-06', 1, NULL, NULL, NULL, '0', '0.00', '2024-03-06 04:08:37', '2024-03-06 04:08:37'),
(26, NULL, '2024-03-06', 'Air/water valves 100 series scopes', NULL, NULL, NULL, 'Reusable', '2024-03-06', 6, NULL, NULL, NULL, '0', '0.00', '2024-03-06 04:14:22', '2024-03-06 04:14:22'),
(27, NULL, '2024-03-06', 'Biopsy cap Reusable', NULL, NULL, NULL, 'Reusable', '2024-03-06', 1, NULL, NULL, NULL, '0', '0.00', '2024-03-06 04:23:45', '2024-03-06 04:23:45'),
(28, NULL, '2024-03-06', 'Section valve 140 series', NULL, NULL, NULL, 'Olympus', '2024-03-06', 1, NULL, NULL, NULL, '0', '0.00', '2024-03-06 04:24:40', '2024-03-06 04:24:40'),
(29, NULL, '2024-03-06', 'Air/water valve 140 series', NULL, NULL, NULL, 'Reusable', '2024-03-06', 2, NULL, NULL, NULL, '0', '0.00', '2024-03-06 04:25:33', '2024-03-06 04:25:33'),
(30, NULL, '2024-03-06', 'Air/water valves', NULL, NULL, NULL, 'Reusable', '2024-03-06', 3, NULL, NULL, NULL, '0', '0.00', '2024-03-06 04:26:15', '2024-03-06 04:26:15'),
(31, NULL, '2024-03-06', 'Air/ water valve 140 series', NULL, NULL, NULL, 'Disposable', '2024-03-06', 1, NULL, NULL, NULL, '0', '0.00', '2024-03-06 04:27:16', '2024-03-06 04:27:16'),
(32, NULL, '2024-03-06', 'Mouth piece', NULL, NULL, NULL, 'Reusable', '2024-03-06', 2, NULL, NULL, NULL, '0', '0.00', '2024-03-06 04:28:10', '2024-03-06 04:28:10'),
(33, NULL, '2024-03-06', 'Mouth piece reusable for peeds', NULL, NULL, NULL, 'Olympus', '2024-03-06', 2, NULL, NULL, NULL, '0', '0.00', '2024-03-06 04:29:26', '2024-03-06 04:29:26'),
(34, NULL, '2024-03-06', 'Moth piece Dis', NULL, NULL, NULL, 'Disposable', '2024-03-06', 2, NULL, NULL, NULL, '0', '0.00', '2024-03-06 04:30:50', '2024-03-06 04:30:50'),
(35, NULL, '2024-03-06', 'Biopsy cap for bronco scope', NULL, NULL, NULL, 'Olympus', '2024-03-06', 8, 'Disposable', NULL, NULL, '0', '0.00', '2024-03-06 04:31:56', '2024-03-06 04:31:56'),
(36, NULL, '2024-03-06', 'Biopsy cap Olympus', NULL, NULL, NULL, 'Olympus', '2024-03-06', 1, NULL, NULL, NULL, '0', '0.00', '2024-03-06 04:32:30', '2024-03-06 04:32:30'),
(37, NULL, '2024-03-06', 'Section button for cysto scope', NULL, NULL, NULL, 'Olympus', '2024-03-06', 2, 'Reusable', NULL, NULL, '0', '0.00', '2024-03-06 04:33:27', '2024-03-06 04:33:27'),
(38, NULL, '2024-03-06', 'Leakage taster concenter', NULL, NULL, NULL, 'Olympus', '2024-03-06', 1, NULL, NULL, NULL, '0', '0.00', '2024-03-06 04:34:08', '2024-03-06 04:34:08'),
(39, NULL, '2024-03-06', 'Wanting cap', NULL, NULL, NULL, 'Olympus', '2024-03-06', 2, NULL, NULL, NULL, '0', '0.00', '2024-03-06 04:34:42', '2024-03-06 04:34:42'),
(40, NULL, '2024-03-06', 'Section valve 140 series (Reusable)', NULL, NULL, NULL, 'Olympus', '2024-03-06', 2, 'Reusable', NULL, NULL, '0', '0.00', '2024-03-06 04:35:48', '2024-03-06 04:35:48'),
(41, NULL, '2024-03-06', 'Air/water and section valves', NULL, NULL, NULL, 'Olympus', '2024-03-06', 8, NULL, NULL, NULL, '0', '0.00', '2024-03-06 04:36:43', '2024-03-06 04:36:43'),
(42, NULL, '2024-03-06', 'Cleaning Brush', NULL, NULL, NULL, 'Micro Tech', '2024-03-06', 9, NULL, NULL, NULL, '0', '0.00', '2024-03-06 04:37:22', '2024-03-06 04:37:22'),
(43, NULL, '2024-03-06', 'Channel Cleaning brush for (ENF,ENT) scope', NULL, NULL, NULL, 'Olympus', '2024-03-06', 3, NULL, NULL, NULL, '0', '0.00', '2024-03-06 04:40:00', '2024-03-06 04:40:00'),
(44, NULL, '2024-03-06', 'Channel Cleaning brush', NULL, NULL, NULL, 'Olympus', '2024-03-06', 1, 'Mod: BC-12C', NULL, NULL, '0', '0.00', '2024-03-06 04:41:41', '2024-03-06 04:41:41'),
(45, NULL, '2024-03-06', 'Cleaning brush for cysto scope', NULL, NULL, NULL, 'Olympus', '2024-03-06', 1, 'Reusable', NULL, NULL, '0', '0.00', '2024-03-06 04:42:29', '2024-03-06 04:42:29'),
(46, NULL, '2024-03-06', 'Cleaning brush for gastro and colono scope', NULL, NULL, NULL, 'Olympus', '2024-03-06', 2, NULL, NULL, NULL, '0', '0.00', '2024-03-06 04:43:12', '2024-03-06 04:43:12'),
(47, NULL, '2024-03-06', 'Grasping forcep', NULL, NULL, NULL, 'China', '2024-03-06', 1, 'Disposable', NULL, NULL, '0', '0.00', '2024-03-06 04:44:06', '2024-03-06 04:44:06'),
(48, NULL, '2024-03-06', 'Magnetic forceps', NULL, NULL, NULL, 'Hospiline', '2024-03-06', 3, 'Reusable', NULL, NULL, '0', '0.00', '2024-03-06 04:45:09', '2024-03-06 04:45:09'),
(49, NULL, '2024-03-06', 'Air/ water channel cleaning adopter', NULL, NULL, NULL, 'Olympus', '2024-03-06', 1, 'Mod: MH-948', NULL, NULL, '0', '0.00', '2024-03-06 04:46:11', '2024-03-06 04:46:11'),
(50, NULL, '2024-03-06', 'Channel Cleaning Brush Olympus', NULL, NULL, NULL, 'Olympus', '2024-03-06', 2, NULL, NULL, NULL, '0', '0.00', '2024-03-06 04:46:57', '2024-03-06 04:46:57'),
(51, NULL, '2024-03-06', 'Bands wire', NULL, NULL, NULL, 'Hospiline', '2024-03-06', 101, NULL, NULL, NULL, '0', '0.00', '2024-03-06 04:49:03', '2024-03-06 04:49:03'),
(52, NULL, '2024-03-06', 'Stant Amsterdam 1', NULL, NULL, NULL, 'Biliary', '2024-03-06', 10, '10fr/10cm', NULL, NULL, '0', '0.00', '2024-03-06 05:52:58', '2024-03-06 05:52:58'),
(53, NULL, '2024-03-06', 'Stant Amsterdam 2', NULL, NULL, NULL, 'Biliary', '2024-03-06', 10, '10fr/12cm', NULL, NULL, '0', '0.00', '2024-03-06 05:53:40', '2024-03-06 05:53:40'),
(54, NULL, '2024-03-06', 'Stant Amsterdam 3', NULL, NULL, NULL, 'Biliary', '2024-03-06', 30, '10fr/7cm', NULL, NULL, '0', '0.00', '2024-03-06 05:54:43', '2024-03-06 05:54:43'),
(55, NULL, '2024-03-06', 'Stant Amsterdam, 3', NULL, NULL, NULL, 'Biliary', '2024-03-06', 30, '10fr/7cm', NULL, NULL, '00', '0.00', '2024-03-06 05:56:37', '2024-03-06 05:56:37'),
(56, NULL, '2024-03-12', 'Stant Amsterdam, 5', NULL, NULL, NULL, 'Biliary', '2024-03-12', 42, '7fr/10cm', NULL, NULL, '0', '0.00', '2024-03-12 01:51:01', '2024-03-12 01:51:01'),
(57, NULL, '2024-03-12', 'Stant Amsterdam, 6', NULL, NULL, NULL, 'Biliary', '2024-03-12', 39, '7fr/12cm', NULL, NULL, '0', '0.00', '2024-03-12 01:51:37', '2024-03-12 01:51:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additional_cources`
--
ALTER TABLE `additional_cources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `additional_cources_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_details`
--
ALTER TABLE `admin_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_details_email_address_unique` (`email_address`),
  ADD KEY `admin_details_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `attendance_employees`
--
ALTER TABLE `attendance_employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendance_employees_admin_user_foreign` (`admin_user`),
  ADD KEY `attendance_employees_employee_user_foreign` (`employee_user`),
  ADD KEY `attendance_employees_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `bank_expenses`
--
ALTER TABLE `bank_expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clients_client_emailaddress_unique` (`client_emailaddress`);

--
-- Indexes for table `client_account_historys`
--
ALTER TABLE `client_account_historys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_account_historys_account_name_foreign` (`account_name`),
  ADD KEY `client_account_historys_invoice_id_foreign` (`invoice_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deliever_challans`
--
ALTER TABLE `deliever_challans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deliever_challans_invoice_id_foreign` (`invoice_id`),
  ADD KEY `deliever_challans_invoice_client_id_foreign` (`invoice_client_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_details`
--
ALTER TABLE `employee_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_details_email_address_unique` (`email_address`),
  ADD KEY `employee_details_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `employee_education_informations`
--
ALTER TABLE `employee_education_informations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_education_informations_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `employee_socials`
--
ALTER TABLE `employee_socials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_socials_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `incoming_and_outgoings`
--
ALTER TABLE `incoming_and_outgoings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `incoming_and_outgoings_incoming_report_ids_foreign` (`incoming_report_ids`);

--
-- Indexes for table `incoming_and_outgoing_disposibles`
--
ALTER TABLE `incoming_and_outgoing_disposibles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incoming_inspection_reports`
--
ALTER TABLE `incoming_inspection_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `incoming_inspection_reports_inspectedby_id_foreign` (`inspectedby_id`),
  ADD KEY `incoming_inspection_reports_company_id_foreign` (`company_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoices_quotation_id_foreign` (`quotation_id`),
  ADD KEY `invoices_invoice_client_id_foreign` (`invoice_client_id`);

--
-- Indexes for table `leave_employees`
--
ALTER TABLE `leave_employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_employees_admin_user_foreign` (`admin_user`),
  ADD KEY `leave_employees_employee_user_foreign` (`employee_user`),
  ADD KEY `leave_employees_employee_id_foreign` (`employee_id`),
  ADD KEY `leave_employees_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_readbyemployee_foreign` (`readByEmployee`),
  ADD KEY `notifications_readbyadmin_foreign` (`readByAdmin`);

--
-- Indexes for table `outgoing_inspection_reports`
--
ALTER TABLE `outgoing_inspection_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `outgoing_inspection_reports_incoming_report_id_foreign` (`incoming_report_id`),
  ADD KEY `outgoing_inspection_reports_inspectedby_id_foreign` (`inspectedby_id`),
  ADD KEY `outgoing_inspection_reports_company_id_foreign` (`company_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotations_client_id_foreign` (`client_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `service_reports`
--
ALTER TABLE `service_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_reports_invoice_client_id_foreign` (`invoice_client_id`);

--
-- Indexes for table `stock_outgoings`
--
ALTER TABLE `stock_outgoings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_outgoings_item_id_foreign` (`item_id`),
  ADD KEY `stock_outgoings_invoice_id_foreign` (`invoice_id`),
  ADD KEY `stock_outgoings_inspection_id_foreign` (`inspection_id`);

--
-- Indexes for table `stock_records`
--
ALTER TABLE `stock_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_records_incoming_report_ids_foreign` (`incoming_report_ids`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additional_cources`
--
ALTER TABLE `additional_cources`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_details`
--
ALTER TABLE `admin_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `attendance_employees`
--
ALTER TABLE `attendance_employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bank_expenses`
--
ALTER TABLE `bank_expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `client_account_historys`
--
ALTER TABLE `client_account_historys`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `deliever_challans`
--
ALTER TABLE `deliever_challans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employee_details`
--
ALTER TABLE `employee_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employee_education_informations`
--
ALTER TABLE `employee_education_informations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_socials`
--
ALTER TABLE `employee_socials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expense_categories`
--
ALTER TABLE `expense_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incoming_and_outgoings`
--
ALTER TABLE `incoming_and_outgoings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `incoming_and_outgoing_disposibles`
--
ALTER TABLE `incoming_and_outgoing_disposibles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `incoming_inspection_reports`
--
ALTER TABLE `incoming_inspection_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `leave_employees`
--
ALTER TABLE `leave_employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `outgoing_inspection_reports`
--
ALTER TABLE `outgoing_inspection_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `service_reports`
--
ALTER TABLE `service_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock_outgoings`
--
ALTER TABLE `stock_outgoings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stock_records`
--
ALTER TABLE `stock_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `additional_cources`
--
ALTER TABLE `additional_cources`
  ADD CONSTRAINT `additional_cources_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `admin_details`
--
ALTER TABLE `admin_details`
  ADD CONSTRAINT `admin_details_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attendance_employees`
--
ALTER TABLE `attendance_employees`
  ADD CONSTRAINT `attendance_employees_admin_user_foreign` FOREIGN KEY (`admin_user`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendance_employees_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendance_employees_employee_user_foreign` FOREIGN KEY (`employee_user`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_account_historys`
--
ALTER TABLE `client_account_historys`
  ADD CONSTRAINT `client_account_historys_account_name_foreign` FOREIGN KEY (`account_name`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_account_historys_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `deliever_challans`
--
ALTER TABLE `deliever_challans`
  ADD CONSTRAINT `deliever_challans_invoice_client_id_foreign` FOREIGN KEY (`invoice_client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `deliever_challans_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_details`
--
ALTER TABLE `employee_details`
  ADD CONSTRAINT `employee_details_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_education_informations`
--
ALTER TABLE `employee_education_informations`
  ADD CONSTRAINT `employee_education_informations_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_socials`
--
ALTER TABLE `employee_socials`
  ADD CONSTRAINT `employee_socials_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `incoming_and_outgoings`
--
ALTER TABLE `incoming_and_outgoings`
  ADD CONSTRAINT `incoming_and_outgoings_incoming_report_ids_foreign` FOREIGN KEY (`incoming_report_ids`) REFERENCES `incoming_inspection_reports` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `incoming_inspection_reports`
--
ALTER TABLE `incoming_inspection_reports`
  ADD CONSTRAINT `incoming_inspection_reports_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `incoming_inspection_reports_inspectedby_id_foreign` FOREIGN KEY (`inspectedby_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_invoice_client_id_foreign` FOREIGN KEY (`invoice_client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoices_quotation_id_foreign` FOREIGN KEY (`quotation_id`) REFERENCES `quotations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `leave_employees`
--
ALTER TABLE `leave_employees`
  ADD CONSTRAINT `leave_employees_admin_user_foreign` FOREIGN KEY (`admin_user`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `leave_employees_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `leave_employees_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `leave_employees_employee_user_foreign` FOREIGN KEY (`employee_user`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_readbyadmin_foreign` FOREIGN KEY (`readByAdmin`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifications_readbyemployee_foreign` FOREIGN KEY (`readByEmployee`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `outgoing_inspection_reports`
--
ALTER TABLE `outgoing_inspection_reports`
  ADD CONSTRAINT `outgoing_inspection_reports_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `outgoing_inspection_reports_incoming_report_id_foreign` FOREIGN KEY (`incoming_report_id`) REFERENCES `incoming_inspection_reports` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `outgoing_inspection_reports_inspectedby_id_foreign` FOREIGN KEY (`inspectedby_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quotations`
--
ALTER TABLE `quotations`
  ADD CONSTRAINT `quotations_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_reports`
--
ALTER TABLE `service_reports`
  ADD CONSTRAINT `service_reports_invoice_client_id_foreign` FOREIGN KEY (`invoice_client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stock_outgoings`
--
ALTER TABLE `stock_outgoings`
  ADD CONSTRAINT `stock_outgoings_inspection_id_foreign` FOREIGN KEY (`inspection_id`) REFERENCES `incoming_inspection_reports` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stock_outgoings_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stock_outgoings_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `stock_records` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stock_records`
--
ALTER TABLE `stock_records`
  ADD CONSTRAINT `stock_records_incoming_report_ids_foreign` FOREIGN KEY (`incoming_report_ids`) REFERENCES `incoming_inspection_reports` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
