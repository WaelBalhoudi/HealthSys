-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 11, 2026 at 08:03 AM
-- Server version: 5.7.33
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `healthsys`
--
CREATE DATABASE IF NOT EXISTS `healthsys` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `healthsys`;

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `date_time` datetime NOT NULL,
  `duration` int(11) NOT NULL DEFAULT '30',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'consultation',
  `reason` text COLLATE utf8mb4_unicode_ci,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `reminder_sent` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `patient_id`, `doctor_id`, `date_time`, `duration`, `status`, `type`, `reason`, `notes`, `reminder_sent`, `created_at`, `updated_at`) VALUES
(7, 2, 2, '2026-04-05 10:00:00', 30, 'scheduled', 'consultation', 'Checkup', 'N/A', 0, '2026-04-03 17:46:40', '2026-04-03 17:46:40'),
(8, 2, 2, '2026-04-06 14:30:00', 45, 'completed', 'follow-up', 'Blood pressure', 'Stable', 1, '2026-04-03 17:46:40', '2026-04-03 17:46:40'),
(9, 3, 2, '2026-04-07 09:15:00', 20, 'cancelled', 'consultation', 'Headache', 'Patient cancelled', 0, '2026-04-03 17:46:40', '2026-04-03 17:46:40'),
(10, 2, 2, '2026-04-05 10:00:00', 30, 'scheduled', 'consultation', 'Checkup', 'N/A', 0, '2026-04-03 17:49:32', '2026-04-03 17:49:32'),
(11, 2, 2, '2026-04-06 14:30:00', 45, 'completed', 'follow-up', 'Blood pressure', 'Stable', 1, '2026-04-03 17:49:32', '2026-04-03 17:49:32'),
(12, 3, 2, '2026-04-07 09:15:00', 20, 'cancelled', 'consultation', 'Headache', 'Patient cancelled', 0, '2026-04-03 17:49:32', '2026-04-03 17:49:32'),
(37, 2, 2, '2026-04-05 10:00:00', 30, 'scheduled', 'consultation', 'Checkup', 'N/A', 0, '2026-04-03 17:46:40', '2026-04-03 17:46:40'),
(38, 2, 2, '2026-05-06 14:30:00', 45, 'completed', 'follow-up', 'Blood pressure', 'Stable', 1, '2026-04-03 17:46:40', '2026-04-03 17:46:40'),
(39, 3, 2, '2026-03-07 09:15:00', 20, 'cancelled', 'consultation', 'Headache', 'Patient cancelled', 0, '2026-04-03 17:46:40', '2026-04-03 17:46:40'),
(40, 2, 2, '2026-04-05 10:00:00', 30, 'scheduled', 'consultation', 'Checkup', 'N/A', 0, '2026-04-03 17:49:32', '2026-04-03 17:49:32'),
(41, 2, 2, '2026-08-06 14:30:00', 45, 'completed', 'follow-up', 'Blood pressure', 'Stable', 1, '2026-04-03 17:49:32', '2026-04-03 17:49:32'),
(42, 3, 2, '2026-04-07 09:15:00', 20, 'cancelled', 'consultation', 'Headache', 'Patient cancelled', 0, '2026-04-03 17:49:32', '2026-04-03 17:49:32'),
(43, 2, 2, '2026-04-05 10:00:00', 30, 'scheduled', 'consultation', 'Checkup', 'N/A', 0, '2026-04-03 17:46:40', '2026-04-03 17:46:40'),
(44, 2, 2, '2026-05-06 14:30:00', 45, 'completed', 'follow-up', 'Blood pressure', 'Stable', 1, '2026-04-03 17:46:40', '2026-04-03 17:46:40'),
(45, 3, 2, '2026-03-07 09:15:00', 20, 'cancelled', 'consultation', 'Headache', 'Patient cancelled', 0, '2026-04-03 17:46:40', '2026-04-03 17:46:40'),
(46, 2, 2, '2026-04-05 10:00:00', 30, 'scheduled', 'consultation', 'Checkup', 'N/A', 0, '2026-04-03 17:49:32', '2026-04-03 17:49:32'),
(47, 2, 2, '2026-08-06 14:30:00', 45, 'completed', 'follow-up', 'Blood pressure', 'Stable', 1, '2026-04-03 17:49:32', '2026-04-03 17:49:32'),
(48, 3, 2, '2026-04-07 09:15:00', 20, 'cancelled', 'consultation', 'Headache', 'Patient cancelled', 0, '2026-04-03 17:49:32', '2026-04-03 17:49:32'),
(49, 2, 2, '2026-04-05 10:00:00', 30, 'scheduled', 'consultation', 'Checkup', 'N/A', 0, '2026-04-03 17:46:40', '2026-04-03 17:46:40'),
(50, 2, 2, '2026-05-06 14:30:00', 45, 'completed', 'follow-up', 'Blood pressure', 'Stable', 1, '2026-04-03 17:46:40', '2026-04-03 17:46:40'),
(51, 3, 2, '2026-05-07 09:15:00', 20, 'cancelled', 'consultation', 'Headache', 'Patient cancelled', 0, '2026-04-03 17:46:40', '2026-04-03 17:46:40'),
(52, 2, 2, '2026-05-05 10:00:00', 30, 'scheduled', 'consultation', 'Checkup', 'N/A', 0, '2026-04-03 17:49:32', '2026-04-03 17:49:32'),
(53, 2, 2, '2026-02-06 14:30:00', 45, 'completed', 'follow-up', 'Blood pressure', 'Stable', 1, '2026-04-03 17:49:32', '2026-04-03 17:49:32'),
(54, 3, 2, '2026-03-07 09:15:00', 20, 'cancelled', 'consultation', 'Headache', 'Patient cancelled', 0, '2026-04-03 17:49:32', '2026-04-03 17:49:32'),
(55, 2, 2, '2026-04-05 10:00:00', 30, 'scheduled', 'consultation', 'Checkup', 'N/A', 0, '2026-04-03 17:46:40', '2026-04-03 17:46:40'),
(56, 2, 2, '2026-05-06 14:30:00', 45, 'completed', 'follow-up', 'Blood pressure', 'Stable', 1, '2026-04-03 17:46:40', '2026-04-03 17:46:40'),
(57, 3, 2, '2026-03-07 09:15:00', 20, 'cancelled', 'consultation', 'Headache', 'Patient cancelled', 0, '2026-04-03 17:46:40', '2026-04-03 17:46:40'),
(58, 2, 2, '2026-04-05 10:00:00', 30, 'scheduled', 'consultation', 'Checkup', 'N/A', 0, '2026-04-03 17:49:32', '2026-04-03 17:49:32'),
(59, 2, 2, '2026-08-06 14:30:00', 45, 'completed', 'follow-up', 'Blood pressure', 'Stable', 1, '2026-04-03 17:49:32', '2026-04-03 17:49:32'),
(60, 3, 2, '2026-04-07 09:15:00', 20, 'cancelled', 'consultation', 'Headache', 'Patient cancelled', 0, '2026-04-03 17:49:32', '2026-04-03 17:49:32'),
(61, 5, 3, '2026-04-23 00:00:00', 30, 'pending', 'general', 'hello', NULL, 0, '2026-04-04 12:11:52', '2026-04-04 12:11:52'),
(62, 2, 2, '2026-04-05 10:00:00', 30, 'scheduled', 'consultation', 'Checkup', 'N/A', 0, '2026-04-03 17:46:40', '2026-04-03 17:46:40'),
(63, 2, 2, '2026-05-06 14:30:00', 45, 'completed', 'follow-up', 'Blood pressure', 'Stable', 1, '2026-04-03 17:46:40', '2026-04-03 17:46:40'),
(64, 3, 2, '2026-03-07 09:15:00', 20, 'cancelled', 'consultation', 'Headache', 'Patient cancelled', 0, '2026-04-03 17:46:40', '2026-04-03 17:46:40'),
(65, 2, 2, '2026-04-05 10:00:00', 30, 'scheduled', 'consultation', 'Checkup', 'N/A', 0, '2026-04-03 17:49:32', '2026-04-03 17:49:32'),
(66, 2, 2, '2026-08-06 14:30:00', 45, 'completed', 'follow-up', 'Blood pressure', 'Stable', 1, '2026-04-03 17:49:32', '2026-04-03 17:49:32'),
(67, 3, 2, '2026-07-07 09:15:00', 20, 'cancelled', 'consultation', 'Headache', 'Patient cancelled', 0, '2026-04-03 17:49:32', '2026-04-03 17:49:32');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `consultations`
--

CREATE TABLE `consultations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `doctor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `consultation_date` date DEFAULT NULL,
  `symptoms` text COLLATE utf8mb4_unicode_ci,
  `diagnosis` text COLLATE utf8mb4_unicode_ci,
  `treatment` text COLLATE utf8mb4_unicode_ci,
  `weight` decimal(5,2) DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `blood_pressure` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `temperature` decimal(4,1) DEFAULT NULL,
  `heart_rate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departements`
--

CREATE TABLE `departements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departements`
--

INSERT INTO `departements` (`id`, `nom`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Accueil', NULL, '2026-04-02 12:08:49', '2026-04-02 12:08:49'),
(2, 'Consultations', NULL, '2026-04-02 12:08:49', '2026-04-02 12:08:49'),
(3, 'Urgences', NULL, '2026-04-02 12:08:49', '2026-04-02 12:08:49'),
(4, 'Hospitalisation', NULL, '2026-04-02 12:08:49', '2026-04-02 12:08:49'),
(5, 'Laboratoire', NULL, '2026-04-02 12:08:49', '2026-04-02 12:08:49'),
(6, 'Radiologie', NULL, '2026-04-02 12:08:49', '2026-04-02 12:08:49'),
(7, 'Pharmacie', NULL, '2026-04-02 12:08:49', '2026-04-02 12:08:49'),
(8, 'Administration', NULL, '2026-04-02 12:08:49', '2026-04-02 12:08:49'),
(9, 'Accueil', NULL, '2026-04-02 17:06:42', '2026-04-02 17:06:42'),
(10, 'Consultations', NULL, '2026-04-02 17:06:42', '2026-04-02 17:06:42'),
(11, 'Urgences', NULL, '2026-04-02 17:06:42', '2026-04-02 17:06:42'),
(12, 'Administration', NULL, '2026-04-02 17:06:42', '2026-04-02 17:06:42');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `specialty` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registration_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `consultation_fee` decimal(8,2) NOT NULL,
  `diploma` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cabinet_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `schedule` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `user_id`, `specialty`, `registration_number`, `consultation_fee`, `diploma`, `cabinet_phone`, `schedule`, `created_at`, `updated_at`) VALUES
(2, 11, 'Cardiologue', 'MED12345', 300.00, NULL, NULL, NULL, '2026-04-02 17:06:42', '2026-04-02 17:06:42'),
(3, 17, 'Cardiologue', 'test', 1200.00, 'hello test', NULL, NULL, '2026-04-03 18:05:26', '2026-04-03 18:05:26');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` int(11) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `consultation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `paid_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `issue_date` date NOT NULL,
  `due_date` date NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_31_150658_create_patients_table', 1),
(5, '2026_04_01_132207_create_doctors_table', 1),
(6, '2026_04_01_143821_add_role_to_users_table', 1),
(7, '2026_04_01_145559_create_appointments_table', 1),
(8, '2026_04_01_145643_add_foreign_keys_to_appointments_table', 1),
(9, '2026_04_01_150910_create_sessions_table', 2),
(10, '2026_04_01_153756_add_missing_columns_to_users_table', 3),
(11, '2026_04_01_161353_create_waiting_rooms_table', 4),
(12, '2026_04_02_093524_add_missing_columns_to_waiting_rooms_table', 5),
(13, '2026_04_02_094036_add_missing_columns_to_prescriptions_table', 5),
(14, '2026_04_02_101620_create_notifications_table', 6),
(15, '2026_04_02_102403_add_medical_history_to_patients_table', 7),
(16, '2026_04_02_104654_create_documents_table', 8),
(17, '2026_04_02_140018_create_specialites_table', 9),
(18, '2026_04_02_140130_create_departements_table', 9),
(19, '2026_04_02_140204_add_specialite_departement_to_users_table', 9),
(20, '2026_04_02_163630_create_password_reset_tokens_table', 10),
(21, '2026_04_02_164800_create_consultations_table', 11),
(22, '2026_04_02_164801_create_invoices_table', 11),
(23, '2026_04_02_164802_create_payments_table', 11),
(24, '2026_04_02_164803_create_messages_table', 11),
(25, '2026_04_02_175600_create_failed_jobs_table', 12),
(26, '2026_04_02_193136_add_all_columns_to_invoices_table', 13),
(27, '2026_04_02_205452_add_doctor_id_to_consultations_table', 13),
(28, '2026_04_02_210949_add_missing_columns_to_consultations_table', 14),
(29, '2026_04_02_213116_add_patient_id_to_consultations_table', 15),
(30, '2026_04_04_095036_add_avatar_to_users_table', 16);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `insurance_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `insurance_company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allergies` text COLLATE utf8mb4_unicode_ci,
  `medical_history` text COLLATE utf8mb4_unicode_ci,
  `blood_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `user_id`, `insurance_number`, `insurance_company`, `emergency_contact`, `emergency_phone`, `allergies`, `medical_history`, `blood_type`, `weight`, `height`, `created_at`, `updated_at`) VALUES
(2, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-01 13:49:07', '2026-04-01 13:49:07'),
(3, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-02 08:32:47', '2026-04-02 08:32:47'),
(4, 12, 'INS123456', 'CNSS', NULL, NULL, NULL, NULL, 'O+', NULL, NULL, '2026-04-02 17:06:43', '2026-04-02 17:06:43'),
(5, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-02 19:26:25', '2026-04-02 19:26:25');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `consultation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `medications` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `instructions` text COLLATE utf8mb4_unicode_ci,
  `prescription_date` date NOT NULL,
  `valid_until` date DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prescriptions`
--

INSERT INTO `prescriptions` (`id`, `consultation_id`, `patient_id`, `doctor_id`, `medications`, `instructions`, `prescription_date`, `valid_until`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 2, 1, '[{\"name\":\"www\",\"dosage\":\"555\",\"duration\":\"55\"}]', NULL, '2026-04-01', '2026-04-03', 'active', '2026-04-01 14:50:11', '2026-04-01 14:50:11');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('bnj87PtWZhkAODL3WQ3CDjTxo5ZzffngDEEL0bOM', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.115.0 Chrome/142.0.7444.265 Electron/39.8.5 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY1FsTHpMWHhhbkdOaGkzV1dkSlhDcE5GSUpuRmpPV044YW5ZOUNzaiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo3OiJ3ZWxjb21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1775769415),
('GtcOdx7KbS873k8r0XhBpFINSDJ3uQfa9eAvfiid', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNlBpd0l1QjlTaXV4REpyTUhWZWlKNjR6bGtxRmttbjVwaWxaeVVOWCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo3OiJ3ZWxjb21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1775803261),
('l5Ymqe2vLc7OxzY4j4gjh9esXOFA0sQmUNrPstbQ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.115.0 Chrome/142.0.7444.265 Electron/39.8.5 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVFN1RjhkdGZ5ZExsTUhTQ2dDYTNDWGgwOFZNMnNDMnI5YmRJOXNJWSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo3OiJ3ZWxjb21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1775769275),
('pZ4ddVToey8PcjcxdqPt3prkEq1AUsfDW2Mh2765', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.115.0 Chrome/142.0.7444.265 Electron/39.8.5 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieGt5Zk1VRExjYm1wOEdCVU1kVmhrS1J1RnIyM2ZKc3V4aUdNdkI2aiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo3OiJ3ZWxjb21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1775803261),
('zrOFKdByvogE1yxWNt9qov5gg9kTe6TcwP9Q23zl', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibE9TQW90TlNPTHVqU0xUNEJLSkVnZWFZaDJLVHFvczB0RzVtdHV5ZiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo3OiJ3ZWxjb21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1775769225);

-- --------------------------------------------------------

--
-- Table structure for table `specialites`
--

CREATE TABLE `specialites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `specialites`
--

INSERT INTO `specialites` (`id`, `nom`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Cardiologue', NULL, '2026-04-02 12:08:48', '2026-04-02 12:08:48'),
(2, 'Dermatologue', NULL, '2026-04-02 12:08:48', '2026-04-02 12:08:48'),
(3, 'Pédiatre', NULL, '2026-04-02 12:08:48', '2026-04-02 12:08:48'),
(4, 'Gynécologue', NULL, '2026-04-02 12:08:48', '2026-04-02 12:08:48'),
(5, 'Ophtalmologue', NULL, '2026-04-02 12:08:48', '2026-04-02 12:08:48'),
(6, 'Dentiste', NULL, '2026-04-02 12:08:48', '2026-04-02 12:08:48'),
(7, 'Orthopédiste', NULL, '2026-04-02 12:08:48', '2026-04-02 12:08:48'),
(8, 'Neurologue', NULL, '2026-04-02 12:08:48', '2026-04-02 12:08:48'),
(9, 'Psychiatre', NULL, '2026-04-02 12:08:48', '2026-04-02 12:08:48'),
(10, 'Généraliste', NULL, '2026-04-02 12:08:48', '2026-04-02 12:08:48'),
(11, 'Cardiologue', NULL, '2026-04-02 17:06:42', '2026-04-02 17:06:42'),
(12, 'Dermatologue', NULL, '2026-04-02 17:06:42', '2026-04-02 17:06:42'),
(13, 'Pédiatre', NULL, '2026-04-02 17:06:42', '2026-04-02 17:06:42'),
(14, 'Gynécologue', NULL, '2026-04-02 17:06:42', '2026-04-02 17:06:42'),
(15, 'Généraliste', NULL, '2026-04-02 17:06:42', '2026-04-02 17:06:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'patient',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `birth_date` date DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `specialite_id` bigint(20) UNSIGNED DEFAULT NULL,
  `departement_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `avatar`, `role`, `phone`, `address`, `birth_date`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `specialite_id`, `departement_id`) VALUES
(1, 'Anissa', 'rahalianissa9@gmail.com', NULL, 'patient', NULL, NULL, NULL, NULL, '$2y$12$epdLJ37ps0RKhndXz01f4eBfoObZ4QRopeoZwS5Ftr1vxBgzEpeUm', NULL, '2026-04-01 13:28:07', '2026-04-01 13:28:07', NULL, NULL),
(4, 'rahali', 'anissa9@gmail.com', NULL, 'patient', '22233345', NULL, '2004-04-30', NULL, '$2y$12$136CuUYuwlhnCoRCwXwZhec4hAU6SrEPPEpqdOpsjPnj.c2te5.Oq', NULL, '2026-04-01 13:49:07', '2026-04-01 13:49:07', NULL, NULL),
(5, 'ayadd', 'hh@gmail.com', NULL, 'patient', '55667788', NULL, '2019-02-13', NULL, '$2y$12$ickR5SEFwBFsd8DSrdD07uQVQAGXA6zlBGJe9iBlFqoBEA/q9x4/y', NULL, '2026-04-02 08:22:48', '2026-04-02 08:22:48', NULL, NULL),
(6, 'ayadd', 'aayaaa@gmail.com', NULL, 'patient', '55667788', NULL, '2019-02-13', NULL, '$2y$12$9ogipuKKrXvMwQv/PDIxqOL8HDRgi.bzOE0zui6ITnxoESjiNOxve', NULL, '2026-04-02 08:32:47', '2026-04-02 08:32:47', NULL, NULL),
(8, 'Rahali Anissa 2', 'dr.rahali@healthsys.com', 'avatars/uUVzZyWCx7Bp2iHF2gEfvOzY6DXD5OY7BBIgiJti.png', 'chef_medecine', '0612345678', 'sidibouzid', '2004-04-30', NULL, '$2y$12$C/O1Y1u9LcMplMVKJB7NV.y/BybLbn4U1Xk/J5YGTDWpUTYiIAqk.', NULL, '2026-04-02 13:09:42', '2026-04-04 10:14:06', NULL, NULL),
(10, 'mira', 'amira@gmail.com', NULL, 'patient', NULL, NULL, NULL, NULL, '$2y$12$AzJ6e97rJakv1BLCiI/TR.URIJgK8BiONvDj1UwsmFNkHDUlSs5LG', NULL, '2026-04-02 16:10:38', '2026-04-02 16:10:38', NULL, NULL),
(11, 'Dr Ahmed Benali', 'doctor@healthsys.com', NULL, 'doctor', '0612345678', NULL, '1975-06-15', NULL, '$2y$12$.QZF/8R1uxWdDKM10AqIY.QheEEMUuRpWlUB3AiUMPwk9bkhYVjXa', NULL, '2026-04-02 17:06:42', '2026-04-02 19:51:53', NULL, NULL),
(12, 'Karim Alaoui', 'patient@healthsys.com', NULL, 'patient', '0698765432', 'Rabat', '1990-03-20', NULL, '$2y$12$hFtqpCkrbYKh/YJLTsIvO.kz0YMnUjWw5jvIrglPWVYDnonEQhQLm', NULL, '2026-04-02 17:06:43', '2026-04-02 17:06:43', NULL, NULL),
(14, 'qwerty', 'ww@gmail.com', NULL, 'secretaire', '12345678', NULL, NULL, NULL, '$2y$12$vJ/vuMOP7t7xgHUbUazKQO9H4/jT4k7H0HNLp11Wm/cfC1kiIkiVa', NULL, '2026-04-02 18:43:12', '2026-04-02 18:49:04', NULL, 11),
(15, 'wael balhouid', 'wael balhoudi@gmail.com', NULL, 'patient', '54213094', 'sidi bouzid', '2024-04-09', NULL, '$2y$12$Sk0N/fhTQLWpLr5FX7Z7m./.Libwb6l0KEwQejKhD2l8JFnu236Da', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2025-12-09 07:56:40', '2026-04-03 07:09:48', NULL, NULL),
(16, 'test', 'test@gmail.com', NULL, 'patient', '12345698', 'sidi bouzid', '2026-01-14', NULL, '$2y$12$WFUHOEFH.NL.gR/nbEyVZOF7ivkzoq8wefYWQ3m0.RR31wNkzIC.G', NULL, NULL, '2026-04-03 07:12:07', NULL, NULL),
(17, 'wael balhoudi', 'waelbalhoudi@gmail.com', 'avatars/0piNABCzDL9Tq5COW8pJwxWtEk7ctiIciLBpxbpv.png', 'doctor', '54213094', 'test', '2003-04-20', NULL, '$2y$12$Fqq.PI9vkHybl/JAJIv.ie1b3n/I9YKsTRJLvFh8aFtF83X6ZVPr.', NULL, '2026-04-03 18:05:26', '2026-04-04 10:20:44', NULL, NULL),
(18, 'test', 'zaki@gmail.com', NULL, 'secretaire', '54213094', 'test', NULL, NULL, '$2y$12$a/aZwC22WZb0l9ne0nub7O5oU.7lQalaDrE7b83.OynpO4bOvFPyW', NULL, '2026-04-04 12:41:58', '2026-04-04 12:41:58', NULL, 11);

-- --------------------------------------------------------

--
-- Table structure for table `waiting_rooms`
--

CREATE TABLE `waiting_rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `appointment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `arrival_time` datetime NOT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `estimated_duration` int(11) NOT NULL DEFAULT '30',
  `priority` int(11) NOT NULL DEFAULT '0',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointments_patient_id_index` (`patient_id`),
  ADD KEY `appointments_doctor_id_index` (`doctor_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `consultations`
--
ALTER TABLE `consultations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultations_doctor_id_foreign` (`doctor_id`),
  ADD KEY `consultations_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `departements`
--
ALTER TABLE `departements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `doctors_registration_number_unique` (`registration_number`),
  ADD KEY `doctors_user_id_foreign` (`user_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoices_patient_id_foreign` (`patient_id`),
  ADD KEY `invoices_consultation_id_foreign` (`consultation_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patients_user_id_foreign` (`user_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `specialites`
--
ALTER TABLE `specialites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_specialite_id_foreign` (`specialite_id`),
  ADD KEY `users_departement_id_foreign` (`departement_id`);

--
-- Indexes for table `waiting_rooms`
--
ALTER TABLE `waiting_rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `waiting_rooms_appointment_id_foreign` (`appointment_id`),
  ADD KEY `waiting_rooms_patient_id_foreign` (`patient_id`),
  ADD KEY `waiting_rooms_doctor_id_foreign` (`doctor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `consultations`
--
ALTER TABLE `consultations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departements`
--
ALTER TABLE `departements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `specialites`
--
ALTER TABLE `specialites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `waiting_rooms`
--
ALTER TABLE `waiting_rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `consultations`
--
ALTER TABLE `consultations`
  ADD CONSTRAINT `consultations_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `consultations_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_consultation_id_foreign` FOREIGN KEY (`consultation_id`) REFERENCES `consultations` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `invoices_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_departement_id_foreign` FOREIGN KEY (`departement_id`) REFERENCES `departements` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_specialite_id_foreign` FOREIGN KEY (`specialite_id`) REFERENCES `specialites` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `waiting_rooms`
--
ALTER TABLE `waiting_rooms`
  ADD CONSTRAINT `waiting_rooms_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `waiting_rooms_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `waiting_rooms_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
