-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 29, 2025 at 06:25 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel-interview`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2024_02_11_145141_create_prizes_table', 1),
(2, '2025_01_29_050740_add_awarded_count_to_prizes_table', 2),
(3, '2025_01_29_051208_create_prize_results_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prizes`
--

DROP TABLE IF EXISTS `prizes`;
CREATE TABLE IF NOT EXISTS `prizes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `probability` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `awarded_count` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prizes`
--

INSERT INTO `prizes` (`id`, `title`, `probability`, `created_at`, `updated_at`, `awarded_count`) VALUES
(13, 'bike', 25.00, '2025-01-28 23:55:16', '2025-01-29 00:48:58', 0),
(12, 'tv', 15.00, '2025-01-28 23:54:56', '2025-01-29 00:48:58', 0),
(11, 'car', 20.00, '2025-01-28 23:54:34', '2025-01-29 00:48:58', 0),
(14, 'fridge', 12.00, '2025-01-29 00:23:59', '2025-01-29 00:48:58', 0);

-- --------------------------------------------------------

--
-- Table structure for table `prize_results`
--

DROP TABLE IF EXISTS `prize_results`;
CREATE TABLE IF NOT EXISTS `prize_results` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `prize_id` bigint UNSIGNED NOT NULL,
  `awarded_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prize_results_prize_id_foreign` (`prize_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prize_results`
--

INSERT INTO `prize_results` (`id`, `prize_id`, `awarded_at`, `created_at`, `updated_at`) VALUES
(1, 12, '2025-01-29 00:48:33', '2025-01-29 00:48:33', '2025-01-29 00:48:33'),
(2, 11, '2025-01-29 00:48:33', '2025-01-29 00:48:33', '2025-01-29 00:48:33'),
(3, 13, '2025-01-29 00:48:33', '2025-01-29 00:48:33', '2025-01-29 00:48:33'),
(4, 11, '2025-01-29 00:48:33', '2025-01-29 00:48:33', '2025-01-29 00:48:33'),
(5, 12, '2025-01-29 00:48:33', '2025-01-29 00:48:33', '2025-01-29 00:48:33'),
(6, 13, '2025-01-29 00:48:33', '2025-01-29 00:48:33', '2025-01-29 00:48:33'),
(7, 11, '2025-01-29 00:48:33', '2025-01-29 00:48:33', '2025-01-29 00:48:33'),
(8, 11, '2025-01-29 00:48:33', '2025-01-29 00:48:33', '2025-01-29 00:48:33'),
(9, 14, '2025-01-29 00:48:33', '2025-01-29 00:48:33', '2025-01-29 00:48:33'),
(10, 13, '2025-01-29 00:48:33', '2025-01-29 00:48:33', '2025-01-29 00:48:33'),
(11, 14, '2025-01-29 00:48:33', '2025-01-29 00:48:33', '2025-01-29 00:48:33');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
