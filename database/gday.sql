-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2020 at 12:48 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gday`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rank` smallint(6) NOT NULL,
  `staff_id` bigint(20) UNSIGNED NOT NULL,
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `balances`
--

CREATE TABLE `balances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `amount` double(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `balances`
--

INSERT INTO `balances` (`id`, `customer_id`, `amount`, `created_at`, `updated_at`) VALUES
(1, 1, 700.00, NULL, '2020-06-27 09:24:37'),
(2, 4, 0.00, '2020-06-25 07:51:56', '2020-06-25 07:51:56'),
(3, 5, 2300.00, '2020-06-25 08:31:31', '2020-06-27 09:24:37');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `next_of_kin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nok_relationship` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lga` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `community` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_id` bigint(20) UNSIGNED DEFAULT NULL,
  `membership_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `poverty_index` double(8,2) DEFAULT NULL,
  `loanable` tinyint(1) NOT NULL DEFAULT 0,
  `on_loan` tinyint(1) NOT NULL DEFAULT 0,
  `loan_count` int(11) NOT NULL DEFAULT 0,
  `dormant` tinyint(1) NOT NULL DEFAULT 0,
  `passport_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signature_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `first_name`, `surname`, `other_name`, `gender`, `phone_number`, `email`, `account_number`, `next_of_kin`, `nok_relationship`, `state`, `lga`, `community`, `full_address`, `group_id`, `membership_date`, `poverty_index`, `loanable`, `on_loan`, `loan_count`, `dormant`, `passport_link`, `signature_link`, `staff_id`, `created_at`, `updated_at`) VALUES
(1, 'Day', 'Good', 'Nuel', 'male', '08045454545', 'upc4you@gmail.com', 'GD00001530', 'Jerome', 'father', 'Enugu', 'father', 'Community', 'Independent Layout Enugu, Enugu State', NULL, '2020-06-27 09:51:25', 23.00, 0, 0, 0, 0, '1592287455_goodday_1.png', NULL, 1, '2020-06-16 05:04:15', '2020-06-16 09:43:07'),
(2, 'Kate', 'Hamsa', 'Nuel', 'female', '08023232323', 'upc4u@gmail.com', 'GD00002747', 'Jerome', 'father', 'Enugu', 'father', 'Community', 'Independent Layout Enugu, Enugu State', NULL, '2020-06-16 06:20:41', 23.00, 0, 0, 0, 0, NULL, NULL, 1, '2020-06-16 05:20:41', '2020-06-16 05:20:41'),
(4, 'Mayor', 'Kute', 'Dika', 'male', '08045454541', 'hamsuper@gmail.com', 'GD00000813', 'Kenneth', 'husband', 'Enugu', 'father', 'Ugwuaji', 'Independent Layout Enugu, Enugu State', NULL, '2020-06-25 08:51:55', 23.00, 0, 0, 0, 0, NULL, NULL, 2, '2020-06-25 07:51:55', '2020-06-25 07:51:55'),
(5, 'Chijoke', 'Nwanne', 'Nuel', 'male', '08023232325', 'info@worthcentillion.com', 'GD00000808', 'Faitu', 'father', 'Enugu', 'father', 'Ugwuaji', 'Independent Layout Enugu, Enugu State', NULL, '2020-06-25 09:31:31', 34.00, 0, 0, 0, 0, '1593077491_goodday_5.png', NULL, 2, '2020-06-25 08:31:31', '2020-06-25 08:31:31');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `population` smallint(6) NOT NULL,
  `leader_id` bigint(20) UNSIGNED NOT NULL,
  `secretary_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `amount` double(8,2) NOT NULL,
  `repay_amount` double(8,2) NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `loan_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `repay_interval` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `repay_unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `application_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approval_date` timestamp NULL DEFAULT NULL,
  `same_count` smallint(6) NOT NULL DEFAULT 0,
  `disbursed` tinyint(1) NOT NULL DEFAULT 0,
  `disbursed_date` timestamp NULL DEFAULT NULL,
  `outstanding_amount` double(8,2) NOT NULL,
  `first_repay_date` timestamp NULL DEFAULT NULL,
  `last_repay_date` timestamp NULL DEFAULT NULL,
  `duration` smallint(20) NOT NULL,
  `loan_cleared` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `amount`, `repay_amount`, `customer_id`, `loan_type`, `repay_interval`, `repay_unit`, `application_date`, `approved_by`, `approval_date`, `same_count`, `disbursed`, `disbursed_date`, `outstanding_amount`, `first_repay_date`, `last_repay_date`, `duration`, `loan_cleared`, `created_at`, `updated_at`) VALUES
(36, 50000.00, 60000.00, 5, 'personal', 'monthly', '20000', '2020-06-25 12:06:36', 2, '2020-06-25 11:06:36', 0, 0, NULL, 60000.00, '2020-06-28 23:00:00', NULL, 90, 0, '2020-06-25 09:51:13', '2020-06-25 11:06:36');

-- --------------------------------------------------------

--
-- Table structure for table `loan_repayments`
--

CREATE TABLE `loan_repayments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `loan_id` bigint(20) UNSIGNED NOT NULL,
  `amount_repaid` int(11) NOT NULL,
  `install_number` smallint(6) NOT NULL,
  `due_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `repaid` tinyint(1) NOT NULL,
  `defaulted` tinyint(1) NOT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loan_repayments`
--

INSERT INTO `loan_repayments` (`id`, `loan_id`, `amount_repaid`, `install_number`, `due_date`, `repaid`, `defaulted`, `approved_by`, `created_at`, `updated_at`) VALUES
(5, 36, 20000, 1, '2020-06-25 14:34:40', 1, 0, 2, '2020-06-25 09:51:13', '2020-06-25 13:34:40'),
(6, 36, 20000, 2, '2020-07-28 23:00:00', 0, 0, NULL, '2020-06-25 09:51:13', '2020-06-25 09:51:13'),
(7, 36, 20000, 3, '2020-08-28 23:00:00', 0, 0, NULL, '2020-06-25 09:51:13', '2020-06-25 09:51:13');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(12, '2014_10_12_000000_create_users_table', 2),
(24, '2020_06_09_204911_create_customers_table', 3),
(25, '2020_06_09_205033_create_admins_table', 3),
(26, '2020_06_09_205059_create_loans_table', 3),
(27, '2020_06_09_205131_create_loan_repayments_table', 3),
(28, '2020_06_09_205151_create_savings_table', 3),
(29, '2020_06_09_205217_create_savings_collections_table', 3),
(30, '2020_06_09_205241_create_withdrawals_table', 3),
(31, '2020_06_09_205303_create_balance_table', 3),
(32, '2020_06_09_205328_create_transactions_table', 3),
(33, '2020_06_09_205401_create_groups_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('upc4c@gmail.com', '$2y$10$SuRm1aMcYShExXSNjAtIn.QmSp8kQoHGuYLfKJf6tOhvKksBIqZle', '2020-06-25 04:11:51');

-- --------------------------------------------------------

--
-- Table structure for table `savings`
--

CREATE TABLE `savings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `unit_amount` double(8,2) NOT NULL,
  `saving_interval` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `withdrawable_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `saving_cycle` smallint(6) NOT NULL DEFAULT 0,
  `saving_cycle_total` double NOT NULL DEFAULT 0,
  `cycle_complete` tinyint(1) NOT NULL DEFAULT 0,
  `collection_count` smallint(6) NOT NULL DEFAULT 0,
  `start_date` timestamp NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `savings`
--

INSERT INTO `savings` (`id`, `customer_id`, `unit_amount`, `saving_interval`, `withdrawable_amount`, `saving_cycle`, `saving_cycle_total`, `cycle_complete`, `collection_count`, `start_date`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 5, 200.00, 'daily', 1000.00, 1, 1200, 1, 6, '2020-06-26 11:10:50', 2, '2020-06-26 10:10:50', '2020-06-26 14:23:59');

-- --------------------------------------------------------

--
-- Table structure for table `savings_collections`
--

CREATE TABLE `savings_collections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `saving_id` bigint(20) UNSIGNED NOT NULL,
  `amount_saved` double(8,2) NOT NULL,
  `collected_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `savings_collections`
--

INSERT INTO `savings_collections` (`id`, `saving_id`, `amount_saved`, `collected_by`, `created_at`, `updated_at`) VALUES
(5, 1, 200.00, 2, '2020-06-26 10:52:32', '2020-06-26 10:52:32'),
(6, 1, 200.00, 2, '2020-06-26 10:57:51', '2020-06-26 10:57:51'),
(7, 1, 300.00, 2, '2020-06-26 11:05:20', '2020-06-26 11:05:20'),
(8, 1, 200.00, 2, '2020-06-26 12:10:28', '2020-06-26 12:10:28');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ref_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double(8,2) NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `ref_id`, `type`, `amount`, `comment`, `created_at`, `updated_at`) VALUES
(1, 'LNS1-ST1-0000001', 'loans', 5000.00, 'This is just a comment testing out the whole matter!', '2020-05-23 10:23:35', '2020-06-23 10:23:35'),
(2, 'LNS1-ST1-0000002', 'loans', 5000.00, 'This is just a comment testing out the whole matter!', '2020-06-23 10:36:20', '2020-06-23 10:36:20'),
(3, 'LNS1-ST1-0000003', 'loans', 5000.00, 'Hamsa Zobamto Loan Application of 5000 was received via Hamsa Mathew', '2020-06-23 10:36:51', '2020-06-23 10:36:51'),
(4, 'LNS1-ST1-0000004', 'loans', 5000.00, 'Hamsa Zobamto Loan Application of N5000 was received via Hamsa Mathew', '2020-06-23 10:38:43', '2020-06-23 10:38:43'),
(5, 'LNS1-ST1-0000005', 'loans', 2000.00, 'Hamsa Zobamto Loan Application of N2000 was received via Hamsa Mathew', '2020-06-13 11:41:55', '2020-06-23 11:41:55'),
(6, 'LNS1-ST1-0000006', 'loans', 2000.00, 'Hamsa Zobamto Loan Application of N2000 was received via Hamsa Mathew', '2020-06-23 11:44:56', '2020-06-23 11:44:56'),
(7, 'LNS1-ST1-0000007', 'loans', 1000.00, 'Hamsa Zobamto Loan Application of N1000 was received via Hamsa Mathew', '2020-06-24 05:29:01', '2020-06-24 05:29:01'),
(8, 'LNS1-ST1-0000008', 'loans', 1000.00, 'Hamsa Zobamto Loan Application of N1000 was received via Hamsa Mathew', '2020-06-24 05:30:25', '2020-06-24 05:30:25'),
(9, 'LNS1-ST1-0000009', 'loans', 1000.00, 'Hamsa Zobamto Loan Application of N1000 was received via Hamsa Mathew', '2020-06-24 05:33:23', '2020-06-24 05:33:23'),
(10, 'LNS1-ST1-0000010', 'loans', 1000.00, 'Hamsa Zobamto Loan Application of N1000 was received via Hamsa Mathew', '2020-06-24 05:41:47', '2020-06-24 05:41:47'),
(11, 'LNS1-ST1-0000011', 'loans', 1000.00, 'Hamsa Zobamto Loan Application of N1000 was received via Hamsa Mathew', '2020-06-24 05:44:14', '2020-06-24 05:44:14'),
(12, 'LNS1-ST1-0000012', 'loans', 1000.00, 'Hamsa Zobamto Loan Application of N1000 was received via Hamsa Mathew', '2020-06-24 05:47:08', '2020-06-24 05:47:08'),
(13, 'LNS1-ST1-0000013', 'loans', 1000.00, 'Hamsa Zobamto Loan Application of N1000 was received via Hamsa Mathew', '2020-06-24 05:49:17', '2020-06-24 05:49:17'),
(14, 'LNS1-ST1-0000014', 'loans', 1000.00, 'Hamsa Zobamto Loan Application of N1000 was received via Hamsa Mathew', '2020-06-24 05:49:52', '2020-06-24 05:49:52'),
(15, 'LNS1-ST1-0000015', 'loans', 1000.00, 'Hamsa Zobamto Loan Application of N1000 was received via Hamsa Mathew', '2020-06-24 05:51:49', '2020-06-24 05:51:49'),
(16, 'LNS1-ST1-0000016', 'loans', 1000.00, 'Hamsa Zobamto Loan Application of N1000 was received via Hamsa Mathew', '2020-06-24 05:53:59', '2020-06-24 05:53:59'),
(17, 'LNS1-ST1-0000017', 'loans', 1000.00, 'Hamsa Zobamto Loan Application of N1000 was received via Hamsa Mathew', '2020-06-24 05:58:00', '2020-06-24 05:58:00'),
(18, 'LNS1-ST1-0000018', 'loans', 1000.00, 'Hamsa Zobamto Loan Application of N1000 was received via Hamsa Mathew', '2020-06-24 05:58:20', '2020-06-24 05:58:20'),
(19, 'LNS1-ST1-0000019', 'loans', 1000.00, 'Hamsa Zobamto Loan Application of N1000 was received via Hamsa Mathew', '2020-06-24 05:59:39', '2020-06-24 05:59:39'),
(20, 'LNS1-ST1-0000020', 'loans', 1000.00, 'Hamsa Zobamto Loan Application of N1000 was received via Hamsa Mathew', '2020-06-24 05:59:47', '2020-06-24 05:59:47'),
(21, 'LNS1-ST1-0000021', 'loans', 1000.00, 'Hamsa Zobamto Loan Application of N1000 was received via Hamsa Mathew', '2020-06-24 06:01:02', '2020-06-24 06:01:02'),
(22, 'LNS1-ST1-0000022', 'loans', 1000.00, 'Hamsa Zobamto Loan Application of N1000 was received via Hamsa Mathew', '2020-06-24 06:01:45', '2020-06-24 06:01:45'),
(23, 'LNS1-ST1-0000023', 'loans', 1000.00, 'Hamsa Zobamto Loan Application of N1000 was received via Hamsa Mathew', '2020-06-24 06:02:30', '2020-06-24 06:02:30'),
(24, 'LNS1-ST1-0000024', 'loans', 1000.00, 'Hamsa Zobamto Loan Application of N1000 was received via Hamsa Mathew', '2020-06-24 06:03:54', '2020-06-24 06:03:54'),
(25, 'LNS1-ST1-0000025', 'loans', 1000.00, 'Hamsa Zobamto Loan Application of N1000 was received via Hamsa Mathew', '2020-06-24 06:05:50', '2020-06-24 06:05:50'),
(26, 'LNS1-ST1-0000026', 'loans', 1000.00, 'Hamsa Zobamto Loan Application of N1000 was received via Hamsa Mathew', '2020-06-24 06:09:58', '2020-06-24 06:09:58'),
(27, 'LNS1-ST1-0000027', 'loans', 1000.00, 'Hamsa Zobamto Loan Application of N1000 was received via Hamsa Mathew', '2020-06-24 06:12:13', '2020-06-24 06:12:13'),
(28, 'LNS1-ST1-0000028', 'loans', 1000.00, 'Hamsa Zobamto Loan Application of N1000 was received via Hamsa Mathew', '2020-06-24 06:13:07', '2020-06-24 06:13:07'),
(29, 'LNS1-ST1-0000029', 'loans', 35000.00, 'Hamsa Zobamto Loan Application of N35000 was received via Hamsa Mathew', '2020-06-24 06:15:29', '2020-06-24 06:15:29'),
(30, 'LNS1-ST1-0000030', 'loans', 50000.00, 'Hamsa Zobamto Loan Application of N50000 was received via Hamsa Mathew', '2020-06-24 06:56:09', '2020-06-24 06:56:09'),
(31, 'LNS1-ST1-0000031', 'loans', 50000.00, 'Hamsa Zobamto Loan Application of N50000 was received via Hamsa Mathew', '2020-06-24 07:16:38', '2020-06-24 07:16:38'),
(32, 'LNS1-ST2-0000032', 'loans', 120.00, 'Hamsa Zobamto Loan Application Fees of N120 was received via Ogbodo Esther', '2020-06-24 16:41:43', '2020-06-24 16:41:43'),
(33, 'LNS1-ST1-0000033', 'loans', 0.00, 'Transaction of 0 was recorded', '2020-06-25 03:34:01', '2020-06-25 03:34:01'),
(34, 'LNS1-ST1-0000034', 'loans', 0.00, 'Hamsa Zobamto Loan Application was approved by Hamsa Mathew', '2020-06-25 03:37:43', '2020-06-25 03:37:43'),
(35, 'CTM5-ST2-0000035', 'customers', 0.00, 'Nwanne Chijoke account was created by Ogbodo Esther', '2020-06-25 08:31:31', '2020-06-25 08:31:31'),
(36, 'LNS5-ST2-0000036', 'loans', 2000.00, 'Nwanne Chijoke Loan Application Fees of N2000 was received via Ogbodo Esther', '2020-06-25 09:51:13', '2020-06-25 09:51:13'),
(37, 'LNS5-ST2-0000037', 'loans', 0.00, 'Nwanne Chijoke Loan Application was approved by Ogbodo Esther', '2020-06-25 11:06:36', '2020-06-25 11:06:36'),
(38, 'LNS5-ST2-0000038', 'loans', 20000.00, 'Nwanne Chijoke paid N20000 for Loan Repayment and was collected by Ogbodo Esther', '2020-06-25 13:34:40', '2020-06-25 13:34:40'),
(39, 'SVS5-ST2-0000039', 'savings', 0.00, 'Nwanne Chijoke Started a new Saving Cycle via Ogbodo Esther', '2020-06-26 10:10:50', '2020-06-26 10:10:50'),
(40, 'SVS5-ST2-0000040', 'savings', 200.00, 'Transaction of 200 was recorded', '2020-06-26 10:52:32', '2020-06-26 10:52:32'),
(41, 'SVS5-ST2-0000041', 'savings', 200.00, 'Nwanne Chijoke saved 200 via Ogbodo Esther', '2020-06-26 10:57:52', '2020-06-26 10:57:52'),
(42, 'SVS5-ST2-0000042', 'savings', 300.00, 'Nwanne Chijoke saved 300 via Ogbodo Esther', '2020-06-26 11:05:20', '2020-06-26 11:05:20'),
(43, 'SVS5-ST2-0000043', 'savings', -200.00, 'Nwanne Chijoke withdraw the sum of -200 via Ogbodo Esther', '2020-06-26 11:54:27', '2020-06-26 11:54:27'),
(44, 'SVS5-ST2-0000044', 'savings', -50.00, 'Nwanne Chijoke withdrew the sum of N {abs(-50)} via Ogbodo Esther', '2020-06-26 12:00:50', '2020-06-26 12:00:50'),
(45, 'SVS5-ST2-0000045', 'savings', -50.00, 'Nwanne Chijoke withdrew the sum of N50 via Ogbodo Esther', '2020-06-26 12:04:39', '2020-06-26 12:04:39'),
(46, 'SVS5-ST2-0000046', 'savings', 200.00, 'Nwanne Chijoke saved 200 via Ogbodo Esther', '2020-06-26 12:10:28', '2020-06-26 12:10:28'),
(47, 'SVS5-ST2-0000047', 'savings', 0.00, 'Transaction of 0 was recorded', '2020-06-26 13:13:43', '2020-06-26 13:13:43'),
(48, 'SVS5-ST2-0000048', 'savings', 0.00, 'Transaction of 0 was recorded', '2020-06-26 13:13:43', '2020-06-26 13:13:43'),
(49, 'SVS1-ST2-0000049', 'savings', 0.00, 'Day Good Started a new Saving Cycle via Ogbodo Esther', '2020-06-26 14:00:28', '2020-06-26 14:00:28'),
(50, 'SVS5-ST2-0000050', 'savings', 0.00, 'Nwanne Chijoke Started a new Saving Cycle via Ogbodo Esther', '2020-06-26 14:21:29', '2020-06-26 14:21:29'),
(51, 'SVS5-ST2-0000051', 'savings', 500.00, 'Nwanne Chijoke saved 500 via Ogbodo Esther', '2020-06-26 14:23:10', '2020-06-26 14:23:10'),
(52, 'SVS5-ST2-0000052', 'savings', 500.00, 'Nwanne Chijoke saved 500 via Ogbodo Esther', '2020-06-26 14:24:00', '2020-06-26 14:24:00'),
(53, 'SVS5-ST2-0000053', 'savings', 0.00, 'Nwanne Chijoke Started a new Saving Cycle via Ogbodo Esther', '2020-06-27 04:52:43', '2020-06-27 04:52:43'),
(54, 'SVS5-ST2-0000054', 'savings', 0.00, 'Nwanne Chijoke Started a new Saving Cycle via Ogbodo Esther', '2020-06-27 05:09:55', '2020-06-27 05:09:55'),
(55, 'SVS5-ST2-0000055', 'savings', 0.00, 'Nwanne Chijoke Started a new Saving Cycle via Ogbodo Esther', '2020-06-27 05:31:49', '2020-06-27 05:31:49'),
(56, 'SVS5-ST2-0000056', 'savings', 200.00, 'Nwanne Chijoke saved 200 via Ogbodo Esther', '2020-06-27 05:32:02', '2020-06-27 05:32:02'),
(57, 'SVS5-ST2-0000057', 'savings', 200.00, 'Nwanne Chijoke saved 200 via Ogbodo Esther', '2020-06-27 05:40:23', '2020-06-27 05:40:23'),
(58, 'SVS5-ST2-0000058', 'savings', 200.00, 'Nwanne Chijoke saved 200 via Ogbodo Esther', '2020-06-27 05:40:30', '2020-06-27 05:40:30'),
(59, 'SVS5-ST2-0000059', 'savings', 200.00, 'Nwanne Chijoke saved 200 via Ogbodo Esther', '2020-06-27 05:40:35', '2020-06-27 05:40:35'),
(60, 'SVS5-ST2-0000060', 'savings', 200.00, 'Nwanne Chijoke saved 200 via Ogbodo Esther', '2020-06-27 05:40:39', '2020-06-27 05:40:39'),
(61, 'SVS5-ST2-0000061', 'savings', 0.00, 'Nwanne Chijoke closed saving cycle of N0 via Ogbodo Esther', '2020-06-27 05:42:32', '2020-06-27 05:42:32'),
(62, 'SVS1-ST2-0000062', 'savings', 200.00, 'Day Good saved 200 via Ogbodo Esther', '2020-06-27 05:42:32', '2020-06-27 05:42:32'),
(63, 'SVS5-ST2-0000063', 'savings', 0.00, 'Nwanne Chijoke Started a new Saving Cycle via Ogbodo Esther', '2020-06-27 06:50:47', '2020-06-27 06:50:47'),
(64, 'SVS5-ST2-0000064', 'savings', 500.00, 'Nwanne Chijoke saved 500 via Ogbodo Esther', '2020-06-27 08:11:24', '2020-06-27 08:11:24'),
(65, 'SVS5-ST2-0000065', 'savings', 500.00, 'Nwanne Chijoke saved 500 via Ogbodo Esther', '2020-06-27 08:42:43', '2020-06-27 08:42:43'),
(66, 'SVS5-ST2-0000066', 'savings', 500.00, 'Nwanne Chijoke saved 500 via Ogbodo Esther', '2020-06-27 08:43:17', '2020-06-27 08:43:17'),
(67, 'SVS5-ST2-0000067', 'savings', 500.00, 'Nwanne Chijoke saved 500 via Ogbodo Esther', '2020-06-27 09:23:21', '2020-06-27 09:23:21'),
(68, 'SVS5-ST2-0000068', 'savings', 0.00, 'Nwanne Chijoke closed saving cycle of N0 via Ogbodo Esther', '2020-06-27 09:24:37', '2020-06-27 09:24:37'),
(69, 'SVS1-ST2-0000069', 'savings', 500.00, 'Day Good saved 500 via Ogbodo Esther', '2020-06-27 09:24:37', '2020-06-27 09:24:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bvn` bigint(20) NOT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passport_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `surname`, `other_name`, `phone_number`, `email`, `bvn`, `designation`, `passport_link`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Mathew', 'Hamsa', 'Nuel', '08023232323', 'upc4u@yahoo.com', 1312131213, NULL, NULL, NULL, '$2y$10$8j48DG4bsWAqX1y3.2ps6uTR7edewxU1UKE64QOQJoa13a8LM0axa', NULL, '2020-06-11 05:51:23', '2020-06-11 05:51:23'),
(2, 'Esther', 'Ogbodo', 'Ene', '08023452345', 'upc4c@gmail.com', 2382345234234, NULL, NULL, NULL, '$2y$10$rBtPfbZYye86/Z4lVWy/WuQFrCg8ef2VPWgo2IgZJp4odeLYJ0QCu', NULL, '2020-06-24 16:36:25', '2020-06-25 04:23:04');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `amount_withdrawn` double(8,2) NOT NULL,
  `disbursed_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `withdrawals`
--

INSERT INTO `withdrawals` (`id`, `customer_id`, `amount_withdrawn`, `disbursed_by`, `created_at`, `updated_at`) VALUES
(3, 5, 200.00, 2, '2020-06-26 11:54:26', '2020-06-26 11:54:26'),
(4, 5, 50.00, 2, '2020-06-26 12:00:50', '2020-06-26 12:00:50'),
(5, 5, 50.00, 2, '2020-06-26 12:04:38', '2020-06-26 12:04:38'),
(6, 5, 400.00, 2, '2020-06-26 13:13:43', '2020-06-26 13:13:43'),
(7, 5, 800.00, 2, '2020-06-27 05:42:32', '2020-06-27 05:42:32'),
(8, 5, 1500.00, 2, '2020-06-27 09:24:37', '2020-06-27 09:24:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admins_staff_id_foreign` (`staff_id`),
  ADD KEY `admins_added_by_foreign` (`added_by`);

--
-- Indexes for table `balances`
--
ALTER TABLE `balances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `balance_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_phone_number_unique` (`phone_number`),
  ADD UNIQUE KEY `customers_account_number_unique` (`account_number`),
  ADD UNIQUE KEY `customers_email_unique` (`email`),
  ADD KEY `customers_staff_id_foreign` (`staff_id`),
  ADD KEY `customers_group_id_foreign` (`group_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groups_leader_id_foreign` (`leader_id`),
  ADD KEY `groups_secretary_id_foreign` (`secretary_id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loans_receiver_id_foreign` (`customer_id`),
  ADD KEY `loans_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `loan_repayments`
--
ALTER TABLE `loan_repayments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_repayments_loan_id_foreign` (`loan_id`),
  ADD KEY `loan_repayments_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `savings`
--
ALTER TABLE `savings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `savings_customer_id_foreign` (`customer_id`),
  ADD KEY `savings_created_by_foreign` (`created_by`);

--
-- Indexes for table `savings_collections`
--
ALTER TABLE `savings_collections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `savings_collections_collected_by_foreign` (`collected_by`),
  ADD KEY `savings_collections_saving_id_foreign` (`saving_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_phone_number_unique` (`phone_number`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `withdrawals_customer_id_foreign` (`customer_id`),
  ADD KEY `withdrawals_disbursed_by_foreign` (`disbursed_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `balances`
--
ALTER TABLE `balances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `loan_repayments`
--
ALTER TABLE `loan_repayments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `savings`
--
ALTER TABLE `savings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `savings_collections`
--
ALTER TABLE `savings_collections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `admins_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `balances`
--
ALTER TABLE `balances`
  ADD CONSTRAINT `balance_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_leader_id_foreign` FOREIGN KEY (`leader_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `groups_secretary_id_foreign` FOREIGN KEY (`secretary_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `loans_receiver_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `loan_repayments`
--
ALTER TABLE `loan_repayments`
  ADD CONSTRAINT `loan_repayments_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `loan_repayments_loan_id_foreign` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `savings`
--
ALTER TABLE `savings`
  ADD CONSTRAINT `savings_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `savings_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `savings_collections`
--
ALTER TABLE `savings_collections`
  ADD CONSTRAINT `savings_collections_collected_by_foreign` FOREIGN KEY (`collected_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `savings_collections_saving_id_foreign` FOREIGN KEY (`saving_id`) REFERENCES `savings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD CONSTRAINT `withdrawals_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `withdrawals_disbursed_by_foreign` FOREIGN KEY (`disbursed_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
