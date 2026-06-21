-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 21, 2026 at 02:03 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proyek-si-spk-rpl-ksi-transformasi-digital`
--

-- --------------------------------------------------------

--
-- Table structure for table `bukti_pengirimans`
--

CREATE TABLE `bukti_pengirimans` (
  `bukti_pengiriman_id` bigint UNSIGNED NOT NULL,
  `pengiriman_id` bigint UNSIGNED NOT NULL,
  `tanggal_bukti` date NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `uploaded_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bukti_pengirimans`
--

INSERT INTO `bukti_pengirimans` (`bukti_pengiriman_id`, `pengiriman_id`, `tanggal_bukti`, `gambar`, `deskripsi`, `uploaded_by`, `created_at`, `updated_at`) VALUES
(4, 7, '2026-05-05', 'bukti_pengiriman/bukti_1777996460_69fa12ac03120.png', 'fefefefeffe', 'driver2', '2026-05-05 08:54:20', '2026-05-05 08:54:20'),
(5, 18, '2026-05-25', 'bukti_pengiriman/bukti_1779711923_6a143fb3d5146.png', 'sudah sampai', 'driver10', '2026-05-25 05:25:23', '2026-05-25 05:25:23'),
(6, 15, '2026-05-25', 'bukti_pengiriman/bukti_1779712030_6a14401e681a2.png', 'sudah selesai', 'driver1', '2026-05-25 05:27:10', '2026-05-25 05:27:10'),
(7, 5, '2026-05-25', 'bukti_pengiriman/bukti_1779712096_6a1440601f7b6.png', 'sudah selesai', 'driver3', '2026-05-25 05:28:16', '2026-05-25 05:28:16'),
(8, 19, '2026-05-25', 'bukti_pengiriman/bukti_1779722249_6a14680987025.png', 'selesai', 'driver11', '2026-05-25 08:17:29', '2026-05-25 08:17:29'),
(10, 20, '2026-05-25', 'bukti_pengiriman/bukti_1779723157_6a146b957e48c.png', 'selesai', 'driver11', '2026-05-25 08:32:37', '2026-05-25 08:32:37'),
(11, 24, '2026-05-25', 'bukti_pengiriman/bukti_1779725796_6a1475e4e6783.png', 'selesai', 'driver12', '2026-05-25 09:16:36', '2026-05-25 09:16:36'),
(12, 25, '2026-05-25', 'bukti_pengiriman/bukti_1779725964_6a14768cd9a91.png', 'selesai', 'driver12', '2026-05-25 09:19:24', '2026-05-25 09:19:24'),
(13, 26, '2026-05-25', 'bukti_pengiriman/bukti_1779726114_6a147722c7fb2.png', 'selesai', 'driver12', '2026-05-25 09:21:54', '2026-05-25 09:21:54'),
(14, 32, '2026-05-31', 'bukti_pengiriman/bukti_1780229505_6a1c2581a77bc.png', 'sudah', 'driver13', '2026-05-31 05:11:45', '2026-05-31 05:11:45'),
(15, 31, '2026-05-31', 'bukti_pengiriman/bukti_1780229580_6a1c25ccdb88c.png', 'sudah', 'driver13', '2026-05-31 05:13:00', '2026-05-31 05:13:00'),
(16, 36, '2026-05-31', 'bukti_pengiriman/bukti_1780229798_6a1c26a6e64ed.png', 'sudah', 'driver14', '2026-05-31 05:16:38', '2026-05-31 05:16:38'),
(17, 35, '2026-05-31', 'bukti_pengiriman/bukti_1780229839_6a1c26cf2133d.png', 'sudah', 'driver14', '2026-05-31 05:17:19', '2026-05-31 05:17:19'),
(18, 39, '2026-05-31', 'bukti_pengiriman/bukti_1780234008_6a1c3718ab454.png', 'sudah', 'driver15', '2026-05-31 06:26:48', '2026-05-31 06:26:48'),
(19, 38, '2026-05-31', 'bukti_pengiriman/bukti_1780234807_6a1c3a3761e25.png', 'suda', 'driver15', '2026-05-31 06:40:07', '2026-05-31 06:40:07'),
(20, 41, '2026-05-31', 'bukti_pengiriman/bukti_1780234980_6a1c3ae451779.png', 'sudah', 'driver16', '2026-05-31 06:43:00', '2026-05-31 06:43:00'),
(22, 44, '2026-06-14', 'bukti_pengiriman/bukti_1781405413_6a2e16e58c5c9.jpeg', 'sudah', 'driver4', '2026-06-13 19:50:13', '2026-06-13 19:50:13'),
(23, 45, '2026-06-14', 'bukti_pengiriman/bukti_1781406349_6a2e1a8d2a7c1.jpeg', 'sudah', 'driver20', '2026-06-13 20:05:49', '2026-06-13 20:05:49');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-reset_password_email_budi@gmail.com', 'i:1;', 1781165822),
('laravel-cache-reset_password_ip_127.0.0.1', 'i:1;', 1781163122);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` bigint UNSIGNED NOT NULL,
  `sender_id` bigint UNSIGNED NOT NULL,
  `receiver_id` bigint UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `sender_id`, `receiver_id`, `message`, `file_path`, `file_type`, `file_name`, `file_size`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES
(1, 10, 8, 'halo', NULL, NULL, NULL, NULL, 1, '2026-05-21 09:53:09', '2026-05-03 21:13:44', '2026-05-21 09:53:09'),
(2, 5, 10, 'halo', NULL, NULL, NULL, NULL, 1, '2026-05-04 01:12:39', '2026-05-04 01:12:19', '2026-05-04 01:12:39'),
(3, 10, 8, 'dfhfdh', NULL, NULL, NULL, NULL, 1, '2026-05-21 09:53:09', '2026-05-05 11:44:52', '2026-05-21 09:53:09'),
(4, 4, 10, 'halo', NULL, NULL, NULL, NULL, 1, '2026-05-05 14:41:54', '2026-05-05 13:57:41', '2026-05-05 14:41:54'),
(5, 4, 10, 'halo', NULL, NULL, NULL, NULL, 1, '2026-05-05 14:41:54', '2026-05-05 14:13:51', '2026-05-05 14:41:54'),
(6, 4, 10, 'halo', NULL, NULL, NULL, NULL, 1, '2026-05-05 14:41:54', '2026-05-05 14:37:20', '2026-05-05 14:41:54'),
(7, 10, 4, 'halo juga', NULL, NULL, NULL, NULL, 1, '2026-05-05 14:57:06', '2026-05-05 14:42:00', '2026-05-05 14:57:06'),
(8, 10, 4, 'halo', NULL, NULL, NULL, NULL, 1, '2026-05-05 15:11:26', '2026-05-05 14:58:01', '2026-05-05 15:11:26'),
(9, 4, 10, 'halo ka', NULL, NULL, NULL, NULL, 1, '2026-05-05 17:50:24', '2026-05-05 15:11:30', '2026-05-05 17:50:24'),
(10, 4, 10, 'halo', NULL, NULL, NULL, NULL, 1, '2026-05-05 17:50:24', '2026-05-05 17:28:16', '2026-05-05 17:50:24'),
(11, 11, 10, 'halo', NULL, NULL, NULL, NULL, 1, '2026-05-05 17:30:51', '2026-05-05 17:30:27', '2026-05-05 17:30:51'),
(12, 10, 11, 'halo gimana?', NULL, NULL, NULL, NULL, 0, NULL, '2026-05-05 17:31:15', '2026-05-05 17:31:15'),
(13, 10, 11, 'halo', NULL, NULL, NULL, NULL, 0, NULL, '2026-05-05 17:31:56', '2026-05-05 17:31:56'),
(14, 10, 4, 'oi', NULL, NULL, NULL, NULL, 1, '2026-05-05 17:52:12', '2026-05-05 17:50:30', '2026-05-05 17:52:12'),
(15, 10, 4, 'oi', NULL, NULL, NULL, NULL, 1, '2026-05-05 18:08:55', '2026-05-05 17:53:27', '2026-05-05 18:08:55'),
(16, 10, 4, 'oi', NULL, NULL, NULL, NULL, 1, '2026-05-05 18:08:55', '2026-05-05 17:59:49', '2026-05-05 18:08:55'),
(17, 10, 4, 'hallo', NULL, NULL, NULL, NULL, 1, '2026-05-05 18:08:55', '2026-05-05 18:06:29', '2026-05-05 18:08:55'),
(18, 10, 4, 'ddd', NULL, NULL, NULL, NULL, 1, '2026-05-05 18:08:55', '2026-05-05 18:08:18', '2026-05-05 18:08:55'),
(19, 4, 10, 'halo', NULL, NULL, NULL, NULL, 1, '2026-05-05 18:18:18', '2026-05-05 18:09:10', '2026-05-05 18:18:18'),
(20, 4, 10, 'oo', NULL, NULL, NULL, NULL, 1, '2026-05-05 18:18:18', '2026-05-05 18:11:26', '2026-05-05 18:18:18'),
(21, 10, 4, 'ooi', NULL, NULL, NULL, NULL, 1, '2026-05-07 05:48:38', '2026-05-05 18:18:23', '2026-05-07 05:48:38'),
(22, 10, 4, 'halo', NULL, NULL, NULL, NULL, 1, '2026-05-07 05:48:38', '2026-05-05 18:30:08', '2026-05-07 05:48:38'),
(23, 10, 4, 'oi', NULL, NULL, NULL, NULL, 1, '2026-05-07 05:48:38', '2026-05-05 18:33:27', '2026-05-07 05:48:38'),
(24, 10, 4, 'ok', NULL, NULL, NULL, NULL, 1, '2026-05-07 05:48:38', '2026-05-05 18:34:14', '2026-05-07 05:48:38'),
(25, 4, 10, 'halo', NULL, NULL, NULL, NULL, 1, '2026-05-12 17:45:45', '2026-05-07 05:49:18', '2026-05-12 17:45:45'),
(26, 4, 10, 'halo', NULL, NULL, NULL, NULL, 1, '2026-05-12 17:45:45', '2026-05-07 05:51:24', '2026-05-12 17:45:45'),
(27, 4, 1, 'ew', NULL, NULL, NULL, NULL, 0, NULL, '2026-05-12 13:49:27', '2026-05-12 13:49:27'),
(28, 5, 8, 'halo', NULL, NULL, NULL, NULL, 0, NULL, '2026-05-12 17:24:08', '2026-05-12 17:24:08'),
(29, 4, 5, 'halo', NULL, NULL, NULL, NULL, 1, '2026-05-12 17:34:27', '2026-05-12 17:30:50', '2026-05-12 17:34:27'),
(30, 5, 4, 'oi', NULL, NULL, NULL, NULL, 1, '2026-05-12 17:49:10', '2026-05-12 17:34:47', '2026-05-12 17:49:10'),
(31, 10, 8, 'halo', NULL, NULL, NULL, NULL, 1, '2026-05-21 09:53:09', '2026-05-12 17:44:56', '2026-05-21 09:53:09'),
(32, 10, 4, 'halo', NULL, NULL, NULL, NULL, 1, '2026-05-12 17:48:16', '2026-05-12 17:45:53', '2026-05-12 17:48:16'),
(33, 4, 1, 'halo', NULL, NULL, NULL, NULL, 0, NULL, '2026-05-12 17:50:56', '2026-05-12 17:50:56'),
(34, 4, 10, 'halo', NULL, NULL, NULL, NULL, 1, '2026-05-12 18:26:34', '2026-05-12 17:53:38', '2026-05-12 18:26:34'),
(35, 4, 5, 'oi', NULL, NULL, NULL, NULL, 1, '2026-05-12 18:05:39', '2026-05-12 18:05:19', '2026-05-12 18:05:39'),
(36, 5, 4, 'halo', NULL, NULL, NULL, NULL, 1, '2026-05-12 18:16:12', '2026-05-12 18:05:59', '2026-05-12 18:16:12'),
(37, 4, 5, 'halo apa kabar', NULL, NULL, NULL, NULL, 1, '2026-05-21 09:24:23', '2026-05-12 18:16:43', '2026-05-21 09:24:23'),
(38, 4, 5, 'apa kabar', NULL, NULL, NULL, NULL, 1, '2026-05-21 09:24:23', '2026-05-12 18:20:18', '2026-05-21 09:24:23'),
(39, 10, 4, 'apa', NULL, NULL, NULL, NULL, 1, '2026-05-12 20:14:46', '2026-05-12 18:29:46', '2026-05-12 20:14:46'),
(40, 4, 5, '4rh44wth4gtw', NULL, NULL, NULL, NULL, 1, '2026-05-21 09:24:23', '2026-05-12 19:27:44', '2026-05-21 09:24:23'),
(41, 4, 5, 'halo', NULL, NULL, NULL, NULL, 1, '2026-05-21 09:24:23', '2026-05-12 20:14:36', '2026-05-21 09:24:23'),
(42, 4, 10, 'halo', NULL, NULL, NULL, NULL, 1, '2026-05-21 09:48:54', '2026-05-12 20:15:08', '2026-05-21 09:48:54'),
(43, 10, 8, 'halo', NULL, NULL, NULL, NULL, 1, '2026-05-21 09:55:47', '2026-05-21 09:54:16', '2026-05-21 09:55:47'),
(44, 10, 8, 'halo', NULL, NULL, NULL, NULL, 1, '2026-05-21 09:55:47', '2026-05-21 09:55:21', '2026-05-21 09:55:47'),
(45, 8, 10, 'halo', NULL, NULL, NULL, NULL, 1, '2026-05-21 09:59:38', '2026-05-21 09:55:54', '2026-05-21 09:59:38'),
(46, 10, 8, 'halo', NULL, NULL, NULL, NULL, 1, '2026-05-21 10:00:12', '2026-05-21 09:59:41', '2026-05-21 10:00:12'),
(47, 10, 8, 'halo', NULL, NULL, NULL, NULL, 1, '2026-05-21 10:00:12', '2026-05-21 09:59:49', '2026-05-21 10:00:12'),
(48, 8, 4, 'halo', NULL, NULL, NULL, NULL, 1, '2026-05-21 10:28:28', '2026-05-21 10:05:10', '2026-05-21 10:28:28'),
(49, 10, 8, 'bujang inam', NULL, NULL, NULL, NULL, 1, '2026-05-21 10:07:23', '2026-05-21 10:07:17', '2026-05-21 10:07:23'),
(50, 8, 10, 'jang', NULL, NULL, NULL, NULL, 1, '2026-05-21 11:25:56', '2026-05-21 10:21:21', '2026-05-21 11:25:56'),
(51, 8, 4, 'aaajdrd', NULL, NULL, NULL, NULL, 1, '2026-05-21 10:28:28', '2026-05-21 10:27:04', '2026-05-21 10:28:28'),
(52, 8, 4, 'go', NULL, NULL, NULL, NULL, 1, '2026-05-21 10:28:28', '2026-05-21 10:27:40', '2026-05-21 10:28:28'),
(53, 8, 4, 'go', NULL, NULL, NULL, NULL, 1, '2026-05-21 10:28:28', '2026-05-21 10:28:02', '2026-05-21 10:28:28'),
(54, 4, 8, 'go', NULL, NULL, NULL, NULL, 0, NULL, '2026-05-21 10:28:30', '2026-05-21 10:28:30'),
(55, 4, 5, 'halo', NULL, NULL, NULL, NULL, 1, '2026-05-21 10:57:31', '2026-05-21 10:56:27', '2026-05-21 10:57:31'),
(56, 5, 4, 'hao', NULL, NULL, NULL, NULL, 1, '2026-05-21 11:16:36', '2026-05-21 10:57:41', '2026-05-21 11:16:36'),
(57, 4, 10, 'oi', NULL, NULL, NULL, NULL, 1, '2026-05-21 11:36:41', '2026-05-21 11:05:43', '2026-05-21 11:36:41'),
(58, 4, 10, 'yu', NULL, NULL, NULL, NULL, 1, '2026-05-21 11:36:41', '2026-05-21 11:13:22', '2026-05-21 11:36:41'),
(59, 8, 10, 'yu', NULL, NULL, NULL, NULL, 1, '2026-05-21 11:25:56', '2026-05-21 11:15:22', '2026-05-21 11:25:56'),
(60, 4, 10, 'ok', NULL, NULL, NULL, NULL, 1, '2026-05-21 11:36:41', '2026-05-21 11:16:26', '2026-05-21 11:36:41'),
(61, 4, 5, 'yu', NULL, NULL, NULL, NULL, 0, NULL, '2026-05-21 11:16:39', '2026-05-21 11:16:39'),
(62, 8, 10, 'u', NULL, NULL, NULL, NULL, 1, '2026-05-21 11:25:56', '2026-05-21 11:19:11', '2026-05-21 11:25:56'),
(63, 8, 10, 'a', NULL, NULL, NULL, NULL, 1, '2026-05-21 11:25:56', '2026-05-21 11:23:16', '2026-05-21 11:25:56'),
(64, 10, 8, 'aa', NULL, NULL, NULL, NULL, 1, '2026-05-21 11:37:32', '2026-05-21 11:26:01', '2026-05-21 11:37:32'),
(65, 10, 8, 'b', NULL, NULL, NULL, NULL, 1, '2026-05-21 11:37:32', '2026-05-21 11:26:54', '2026-05-21 11:37:32'),
(66, 4, 10, 'halo bang', NULL, NULL, NULL, NULL, 1, '2026-05-21 11:36:41', '2026-05-21 11:33:50', '2026-05-21 11:36:41'),
(67, 4, 8, 'halo bang', NULL, NULL, NULL, NULL, 0, NULL, '2026-05-21 11:34:05', '2026-05-21 11:34:05'),
(68, 8, 10, 'oi', NULL, NULL, NULL, NULL, 1, '2026-05-21 11:38:34', '2026-05-21 11:37:38', '2026-05-21 11:38:34'),
(69, 10, 8, 'oi juga', NULL, NULL, NULL, NULL, 0, NULL, '2026-05-21 11:38:40', '2026-05-21 11:38:40'),
(70, 4, 5, 'salam', NULL, NULL, NULL, NULL, 0, NULL, '2026-05-21 11:42:11', '2026-05-21 11:42:11'),
(71, 6, 10, 'halo pak', NULL, NULL, NULL, NULL, 0, NULL, '2026-06-09 13:47:52', '2026-06-09 13:47:52');

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` bigint UNSIGNED NOT NULL,
  `user_one` bigint UNSIGNED NOT NULL,
  `user_two` bigint UNSIGNED NOT NULL,
  `last_message` text COLLATE utf8mb4_unicode_ci,
  `last_message_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` bigint UNSIGNED NOT NULL,
  `nama_perusahaan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_kontak` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `nama_perusahaan`, `alamat`, `nomor_kontak`, `email`, `pic`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'PT Alkesindo', 'Jl.Sembrono no 8', '08953453534', 'sumbrono@gmail.com', 'Sumbrono', 'gkglsfafa', '2026-05-01 12:15:28', '2026-05-01 12:15:28'),
(2, 'PT Mayora Indah TBK', 'Jl.Cikupa No 19,industri Jakate', '087646328776', 'mayoraindahtbk@gmail.com', 'Indah', 'Good', '2026-05-07 12:09:27', '2026-05-07 12:09:27'),
(3, 'Paragon Corp', 'Jl.Cikupa Mas No 24,industri Jakate', '085463626355', 'paragoncorp@gmail.com', 'ririn', 'Good', '2026-05-07 12:10:37', '2026-05-07 12:10:37'),
(4, 'PT.Yupi', 'Jl.Jatake 4', '08543236262', 'yupi@gmail.com', 'Yudi', 'opsional', '2026-06-13 20:00:50', '2026-06-13 20:00:50');

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `driver_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_sim` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_rek` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_kontak` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`driver_id`, `user_id`, `nama`, `no_sim`, `nik`, `no_rek`, `nomor_kontak`, `alamat`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 'Budi Gerung', '989693283209', '486938963794', '67858484854484', '08953453534', 'jl.magga iigoo 2 no9', 'aktif', '2026-05-01 12:12:36', '2026-06-06 06:00:34'),
(2, 4, 'Angga Prasetyo', '86589457546363', '4573734674343', '575474747474', '74574747474', 'jl.manggot', 'aktif', '2026-05-01 13:04:40', '2026-06-06 06:04:35'),
(3, 5, 'Mulyono Siregar', '647638499839', '486948376373', '86585645463', '08436267352', 'jl.sungkam', 'aktif', '2026-05-01 13:06:39', '2026-06-06 05:59:40'),
(4, 11, 'Laksono Putra Sinaga', '74735363636535', '473473473733', '747544u44y4474', '0898664544564', 'Jl.Anggrek', 'aktif', '2026-05-04 01:16:59', '2026-06-06 06:05:53'),
(5, 12, 'Barges Termul Sitorus', '895739345', '6439239823', '78353543762', '086573235622', 'Jl.Mangga Besar', 'aktif', '2026-05-25 08:05:47', '2026-06-06 06:07:46'),
(6, 13, 'Bryan Dycal', '573332923852', '37832352232', '3456873452', '08764523423', 'Jl.Apel No.18', 'aktif', '2026-05-25 08:07:10', '2026-06-06 06:08:33'),
(7, 14, 'Gonggom Nasution', '82727389394', '46372324642', '6794324637373', '089653423242', 'Jl.Mdrasah 6', 'aktif', '2026-05-31 04:29:02', '2026-06-06 06:09:10'),
(8, 15, 'Pratama Bayu', '873948739829874', '1244325342325', '43465463533', '085673454322', 'Jl.Narogong 15', 'aktif', '2026-05-31 04:29:42', '2026-06-06 06:09:51'),
(9, 16, 'Dimas Longgom', '9548792842', '45748535722', '634533735733', '08754663453', 'Jl.Sambilan Gunung', 'aktif', '2026-05-31 06:07:22', '2026-06-06 06:18:47'),
(10, 17, 'Reza', '85738929387897', '547337383833', '346732343235', '084543284876', 'Jl.Margonda 7', 'aktif', '2026-05-31 06:07:59', '2026-06-06 06:18:20'),
(27, 6, 'driver4', '838476934936', '457423453', '4354252', '0845643532', 'Jl.Penggaronggong', 'aktif', '2026-06-13 19:43:22', '2026-06-13 19:43:22'),
(28, 21, 'driver20', '874533453', '576373452', '834253463', '0899343263', 'Jl.Jakjaksel', 'aktif', '2026-06-13 19:57:36', '2026-06-13 19:57:36');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kriterias`
--

CREATE TABLE `kriterias` (
  `kriteria_id` bigint UNSIGNED NOT NULL,
  `kode_kriteria` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kriteria` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis` enum('benefit','cost') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'benefit',
  `bobot` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kriterias`
--

INSERT INTO `kriterias` (`kriteria_id`, `kode_kriteria`, `nama_kriteria`, `jenis`, `bobot`, `created_at`, `updated_at`) VALUES
(9, 'C1', 'Jumlah Pengiriman Selesai', 'benefit', '0.35', '2026-05-20 07:30:49', '2026-05-20 08:34:38'),
(10, 'C2', 'Kecepatan Upload Bukti', 'benefit', '0.25', '2026-05-20 07:30:49', '2026-05-20 08:35:02'),
(11, 'C3', 'Pengiriman Tertunda', 'cost', '0.20', '2026-05-20 07:30:49', '2026-05-20 08:35:10'),
(12, 'C4', 'Rating Driver', 'benefit', '0.20', '2026-05-20 07:30:49', '2026-05-20 08:35:18');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_19_195726_create_password_resets_table', 1),
(5, '2026_04_23_213133_create_chats_table', 1),
(6, '2026_04_23_213222_create_conversations_table', 1),
(7, '2026_04_27_182022_create_drivers_table', 1),
(8, '2026_04_27_210358_create_mobils_table', 1),
(9, '2026_04_27_212516_create_customers_table', 1),
(10, '2026_04_27_214912_create_pengajuans_table', 1),
(11, '2026_04_27_215655_add_status_to_drivers_table', 1),
(12, '2026_04_27_222620_create_pengirimans_table', 1),
(13, '2026_04_27_224557_create_bukti_pengirimans_table', 1),
(14, '2026_05_01_004747_add_customer_id_to_pengajuans_table', 1),
(15, '2026_05_01_125201_create_kriterias_table', 1),
(16, '2026_05_01_125203_create_penilaians_table', 1),
(17, '2026_05_05_190941_create_notifications_table', 2),
(18, '2026_05_20_144859_change_bobot_column_type_in_kriterias_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `mobils`
--

CREATE TABLE `mobils` (
  `mobil_id` bigint UNSIGNED NOT NULL,
  `no_plat` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_mobil` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pajak_stnk` date DEFAULT NULL,
  `pajak_plat` date DEFAULT NULL,
  `kir` date DEFAULT NULL,
  `status` enum('aktif','perbaikan','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mobils`
--

INSERT INTO `mobils` (`mobil_id`, `no_plat`, `merk`, `jenis_mobil`, `pajak_stnk`, `pajak_plat`, `kir`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, '65765865858', 'honda', 'truck', '2026-05-02', '2026-05-02', '2026-05-02', 'aktif', 'asfsafsa', '2026-05-01 12:13:34', '2026-05-01 12:13:34'),
(2, '0683536363', 'yamaha', 'sedan', '2026-05-02', '2026-05-02', '2026-05-02', 'aktif', 'sfasfsafaa', '2026-05-01 12:14:08', '2026-05-01 12:14:08'),
(3, '0564454474474', 'yamaha', 'derek', '2026-05-05', '2026-05-05', '2026-05-05', 'aktif', NULL, '2026-05-04 19:37:08', '2026-05-04 19:37:08'),
(4, '673245245622', 'suzuki', 'Bulldozer', '2026-06-14', '2026-06-14', '2026-06-30', 'aktif', 'opsional', '2026-06-13 19:59:32', '2026-06-13 19:59:32');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `type` enum('chat','pengiriman','pengajuan','sistem') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sistem',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `role` enum('superadmin','admin','driver') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source_id` bigint UNSIGNED DEFAULT NULL,
  `source_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `title`, `message`, `link`, `user_id`, `role`, `source_id`, `source_type`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES
(74, 'chat', '💬 Pesan dari Driver', 'Driver driver4: halo pak', '/chat?room=71', 10, NULL, NULL, NULL, 1, '2026-06-09 13:48:49', '2026-06-09 13:47:52', '2026-06-09 13:48:49');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expires_at` timestamp NOT NULL,
  `is_used` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `ip_address`, `user_agent`, `expires_at`, `is_used`, `created_at`, `updated_at`) VALUES
(1, 'driver15@gmail.com', 'TnYdVv3KVZGBV85OtDqZHFtFraMCn50FLdJ3cC2ZesFaelByZTGBOSIo6ne0M1Kp', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-31 07:00:11', 0, '2026-05-31 06:59:11', '2026-05-31 06:59:11'),
(2, 'budi@gmail.com', 'n4RwDaXX8ZOEda4vJu1RDqP8zrgzAsz7S2xzzjUYZHjSj5QoryP1bTC75m1OIEzb', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', '2026-06-11 00:18:02', 0, '2026-06-11 00:17:02', '2026-06-11 00:17:02');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengajuans`
--

CREATE TABLE `pengajuans` (
  `pengajuan_id` bigint UNSIGNED NOT NULL,
  `driver_id` bigint UNSIGNED NOT NULL,
  `mobil_id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `status` enum('pending','disetujui','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `disetujui_oleh` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_pengajuan` date NOT NULL,
  `tanggal_disetujui` date DEFAULT NULL,
  `bukti_struk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengajuans`
--

INSERT INTO `pengajuans` (`pengajuan_id`, `driver_id`, `mobil_id`, `customer_id`, `status`, `disetujui_oleh`, `tanggal_pengajuan`, `tanggal_disetujui`, `bukti_struk`, `keterangan`, `created_at`, `updated_at`) VALUES
(4, 2, 2, 1, 'disetujui', 'adminsaja', '2026-05-01', '2026-05-01', NULL, 'fgweffw', '2026-05-01 13:39:42', '2026-05-01 13:39:46'),
(5, 3, 1, 1, 'disetujui', 'Glensius', '2026-05-04', '2026-05-04', NULL, 'edqwdqwq', '2026-05-04 01:13:30', '2026-05-04 01:13:33'),
(7, 4, 2, 1, 'disetujui', 'Glensius', '2026-05-04', '2026-05-05', NULL, 'sdgsgsgs', '2026-05-04 03:42:33', '2026-05-04 19:16:16'),
(8, 2, 2, 1, 'disetujui', 'Glensius', '2026-05-04', '2026-05-04', NULL, 'egteew', '2026-05-04 03:43:48', '2026-05-04 03:43:54'),
(10, 1, 1, 1, 'disetujui', 'Glensius', '2026-05-05', '2026-05-05', NULL, 'fhfheef', '2026-05-04 18:50:03', '2026-05-04 18:50:08'),
(11, 2, 1, 2, 'disetujui', 'Glensius', '2026-05-25', '2026-05-25', NULL, 'opsional', '2026-05-25 05:12:57', '2026-05-25 05:13:09'),
(12, 4, 2, 1, 'disetujui', 'Glensius', '2026-05-25', '2026-05-25', NULL, 'opsional', '2026-05-25 05:20:03', '2026-05-25 05:20:20'),
(13, 5, 3, 1, 'disetujui', 'Glensius', '2026-05-25', '2026-05-25', NULL, 'opsional', '2026-05-25 08:09:16', '2026-05-25 08:09:25'),
(14, 5, 3, 1, 'disetujui', 'Glensius', '2026-05-25', '2026-05-25', 'pengajuans/struk/struk_1779721995_6a14670b6da5a.png', 'opsional', '2026-05-25 08:13:15', '2026-05-25 08:13:59'),
(15, 5, 3, 2, 'disetujui', 'Glensius', '2026-05-25', '2026-05-25', NULL, 'opsioanal', '2026-05-25 08:23:46', '2026-05-25 09:25:46'),
(17, 6, 1, 2, 'disetujui', 'Glensius', '2026-05-25', '2026-05-25', NULL, 'opsional', '2026-05-25 09:13:43', '2026-05-25 09:13:54'),
(18, 6, 2, 2, 'disetujui', 'Glensius', '2026-05-25', '2026-05-25', NULL, 'opsional', '2026-05-25 09:18:24', '2026-05-25 09:18:28'),
(19, 6, 2, 2, 'disetujui', 'Glensius', '2026-05-25', '2026-05-25', NULL, 'opsional', '2026-05-25 09:20:04', '2026-05-25 09:20:08'),
(20, 7, 1, 2, 'disetujui', 'Glensius', '2026-05-31', '2026-05-31', NULL, NULL, '2026-05-31 04:30:41', '2026-05-31 04:30:46'),
(21, 7, 1, 2, 'disetujui', 'Glensius', '2026-05-31', '2026-05-31', NULL, NULL, '2026-05-31 04:33:19', '2026-05-31 04:33:26'),
(22, 7, 1, 2, 'disetujui', 'Glensius', '2026-05-31', '2026-05-31', NULL, NULL, '2026-05-31 04:36:00', '2026-05-31 04:36:05'),
(23, 7, 1, 2, 'disetujui', 'Glensius', '2026-05-31', '2026-05-31', NULL, NULL, '2026-05-31 04:36:28', '2026-05-31 04:36:33'),
(24, 7, 1, 2, 'disetujui', 'Glensius', '2026-05-31', '2026-05-31', NULL, NULL, '2026-05-31 04:40:31', '2026-05-31 04:40:36'),
(25, 8, 1, 2, 'disetujui', 'Glensius', '2026-05-31', '2026-05-31', NULL, NULL, '2026-05-31 04:42:23', '2026-05-31 04:42:28'),
(26, 8, 1, 2, 'disetujui', 'Glensius', '2026-05-31', '2026-05-31', NULL, NULL, '2026-05-31 04:42:39', '2026-05-31 04:42:43'),
(27, 8, 1, 2, 'disetujui', 'Glensius', '2026-05-31', '2026-05-31', NULL, NULL, '2026-05-31 04:42:54', '2026-05-31 04:43:16'),
(28, 8, 1, 2, 'disetujui', 'Glensius', '2026-05-31', '2026-05-31', NULL, NULL, '2026-05-31 04:43:06', '2026-05-31 04:43:11'),
(29, 9, 1, 2, 'disetujui', 'Glensius', '2026-05-31', '2026-05-31', NULL, NULL, '2026-05-31 06:10:46', '2026-05-31 06:19:54'),
(30, 9, 1, 2, 'disetujui', 'Glensius', '2026-05-31', '2026-05-31', NULL, NULL, '2026-05-31 06:10:59', '2026-05-31 06:19:50'),
(31, 9, 1, 2, 'disetujui', 'Glensius', '2026-05-31', '2026-05-31', NULL, NULL, '2026-05-31 06:15:04', '2026-05-31 06:19:46'),
(32, 10, 1, 2, 'disetujui', 'Glensius', '2026-05-31', '2026-05-31', NULL, NULL, '2026-05-31 06:20:10', '2026-05-31 06:21:05'),
(33, 10, 1, 2, 'disetujui', 'Glensius', '2026-05-31', '2026-05-31', NULL, NULL, '2026-05-31 06:20:25', '2026-05-31 06:20:58'),
(39, 27, 1, 2, 'disetujui', 'Glensius', '2026-06-10', '2026-06-14', NULL, NULL, '2026-06-13 19:48:10', '2026-06-13 19:48:15'),
(40, 28, 4, 4, 'disetujui', 'Glensius', '2026-06-14', '2026-06-14', NULL, 'opsional', '2026-06-13 20:02:06', '2026-06-13 20:02:14');

-- --------------------------------------------------------

--
-- Table structure for table `pengirimans`
--

CREATE TABLE `pengirimans` (
  `pengiriman_id` bigint UNSIGNED NOT NULL,
  `pengajuan_id` bigint UNSIGNED NOT NULL,
  `nomor_surat_jalan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('proses','dikirim','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'proses',
  `tanggal_pengiriman` date NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengirimans`
--

INSERT INTO `pengirimans` (`pengiriman_id`, `pengajuan_id`, `nomor_surat_jalan`, `status`, `tanggal_pengiriman`, `deskripsi`, `gambar`, `catatan`, `created_at`, `updated_at`) VALUES
(5, 5, 'SJ/2026/05/0005', 'selesai', '2026-05-05', 'wsq', NULL, 'edqqdeqdq', '2026-05-04 01:13:52', '2026-05-04 17:55:27'),
(7, 8, 'SJ/2026/05/0007', 'selesai', '2026-05-05', 'shgdgsgsgsg', NULL, 'sggwgwgwg', '2026-05-04 03:45:10', '2026-05-05 08:53:56'),
(15, 10, 'SJ/2026/05/0009', 'selesai', '2026-05-15', 'wdgeewgwgwge', 'pengirimans/pengiriman_1778816705_6a0696c1238bb.png', 'gwgewgw', '2026-05-04 18:52:20', '2026-05-14 20:45:05'),
(17, 11, 'SJ/2026/05/0010', 'selesai', '2026-05-25', 'opsional', NULL, 'opsi', '2026-05-25 05:14:00', '2026-05-25 05:16:04'),
(18, 12, 'SJ/2026/05/0011', 'selesai', '2026-05-25', 'opsional', NULL, 'opsional', '2026-05-25 05:21:28', '2026-05-25 05:22:36'),
(19, 13, 'SJ/2026/05/0012', 'selesai', '2026-05-25', 'opsional', NULL, 'opsional', '2026-05-25 08:10:35', '2026-05-25 08:10:56'),
(20, 14, 'SJ/2026/05/0013', 'selesai', '2026-05-25', 'opsional', NULL, 'opsional', '2026-05-25 08:14:38', '2026-05-25 08:23:23'),
(24, 17, 'SJ/2026/05/0015', 'selesai', '2026-05-25', 'opsional', NULL, 'opsional', '2026-05-25 09:14:16', '2026-05-25 09:16:06'),
(25, 18, 'SJ/2026/05/0016', 'selesai', '2026-05-25', 'opsional', NULL, 'opsional', '2026-05-25 09:18:56', '2026-05-25 09:19:09'),
(26, 19, 'SJ/2026/05/0017', 'selesai', '2026-05-25', 'opsional', NULL, 'opsional', '2026-05-25 09:20:34', '2026-05-25 09:20:45'),
(27, 15, 'SJ/2026/05/0018', 'proses', '2026-05-25', 'opsional', NULL, 'opsional', '2026-05-25 09:26:05', '2026-05-25 09:26:05'),
(28, 20, 'SJ/2026/05/0019', 'selesai', '2026-05-31', 'opsional', NULL, 'opsional', '2026-05-31 04:31:44', '2026-05-31 05:08:58'),
(29, 21, 'SJ/2026/05/0020', 'selesai', '2026-05-31', 'opsional', NULL, 'opsional', '2026-05-31 04:34:35', '2026-05-31 04:34:51'),
(30, 22, 'SJ/2026/05/0021', 'selesai', '2026-05-31', 'opsional', NULL, 'opsional', '2026-05-31 04:37:00', '2026-05-31 04:38:39'),
(31, 23, 'SJ/2026/05/0022', 'selesai', '2026-05-31', 'opsional', NULL, 'opsional', '2026-05-31 04:39:17', '2026-05-31 04:39:44'),
(32, 24, 'SJ/2026/05/0023', 'selesai', '2026-05-31', 'opsional', NULL, 'opsional', '2026-05-31 04:41:01', '2026-05-31 05:11:59'),
(33, 25, 'SJ/2026/05/0024', 'selesai', '2026-05-31', 'opsional', NULL, 'opsional', '2026-05-31 04:43:46', '2026-05-31 04:44:19'),
(34, 26, 'SJ/2026/05/0025', 'selesai', '2026-05-31', 'opsional', NULL, 'opsional', '2026-05-31 04:44:35', '2026-05-31 04:44:52'),
(35, 27, 'SJ/2026/05/0026', 'selesai', '2026-05-31', 'opsional', NULL, 'opsional', '2026-05-31 04:45:12', '2026-05-31 04:53:29'),
(36, 28, 'SJ/2026/05/0027', 'selesai', '2026-05-31', 'opsional', NULL, 'opsional', '2026-05-31 04:45:43', '2026-05-31 04:53:00'),
(37, 29, 'SJ/2026/05/0028', 'selesai', '2026-05-31', 'opsional', NULL, 'opsional', '2026-05-31 06:22:07', '2026-05-31 06:22:21'),
(38, 30, 'SJ/2026/05/0029', 'selesai', '2026-05-31', 'opsional', NULL, 'opsional', '2026-05-31 06:22:37', '2026-05-31 06:22:50'),
(39, 31, 'SJ/2026/05/0030', 'selesai', '2026-05-31', 'opsional', NULL, 'opsional', '2026-05-31 06:23:10', '2026-05-31 06:23:25'),
(40, 32, 'SJ/2026/05/0031', 'selesai', '2026-05-31', 'opsional', NULL, 'opsional', '2026-05-31 06:23:48', '2026-05-31 06:24:01'),
(41, 33, 'SJ/2026/05/0032', 'selesai', '2026-05-31', 'opsional', NULL, 'opsional', '2026-05-31 06:24:21', '2026-05-31 06:24:34'),
(44, 39, 'SJ/2026/06/0001', 'selesai', '2026-06-10', 'opsional', NULL, 'opsional', '2026-06-13 19:48:44', '2026-06-13 19:49:22'),
(45, 40, 'SJ/2026/06/0002', 'selesai', '2026-06-14', 'opsional', NULL, 'opsional', '2026-06-13 20:03:41', '2026-06-13 20:06:04');

-- --------------------------------------------------------

--
-- Table structure for table `penilaians`
--

CREATE TABLE `penilaians` (
  `penilaian_id` bigint UNSIGNED NOT NULL,
  `driver_id` bigint UNSIGNED NOT NULL,
  `kriteria_id` bigint UNSIGNED NOT NULL,
  `nilai` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penilaians`
--

INSERT INTO `penilaians` (`penilaian_id`, `driver_id`, `kriteria_id`, `nilai`, `created_at`, `updated_at`) VALUES
(22, 1, 12, 100, '2026-05-20 08:02:32', '2026-05-20 08:26:04'),
(24, 2, 12, 80, '2026-05-20 08:02:32', '2026-05-20 08:19:46'),
(26, 3, 12, 67, '2026-05-20 08:02:32', '2026-05-20 08:02:32'),
(28, 4, 12, 100, '2026-05-20 08:02:32', '2026-05-20 08:57:24'),
(30, 5, 12, 70, '2026-05-25 08:11:45', '2026-05-25 08:11:45'),
(31, 6, 12, 40, '2026-05-25 08:11:45', '2026-05-25 08:11:54'),
(32, 7, 12, 50, '2026-05-31 04:48:30', '2026-05-31 04:48:30'),
(33, 8, 12, 65, '2026-05-31 04:48:30', '2026-05-31 04:48:30'),
(34, 9, 12, 73, '2026-05-31 06:08:43', '2026-05-31 06:08:43'),
(35, 10, 12, 43, '2026-05-31 06:08:43', '2026-05-31 06:08:43'),
(37, 27, 12, 56, '2026-06-13 19:46:46', '2026-06-13 19:46:46');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('superadmin','admin','driver') COLLATE utf8mb4_unicode_ci NOT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_superadmin_fixed` tinyint(1) NOT NULL DEFAULT '0',
  `is_online` tinyint(1) NOT NULL DEFAULT '0',
  `last_seen` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `nama`, `email`, `password`, `role`, `google_id`, `avatar`, `is_superadmin_fixed`, `is_online`, `last_seen`, `created_at`, `updated_at`) VALUES
(1, 'Glenn sius Manurung', 'glensiusmanurung@gmail.com', '$2y$12$Eo0yXDDnBSNS.XA/AOZLLeVrkbDNqh6cb8Vn2wHAGYtx2cJjv3ybS', 'superadmin', NULL, NULL, 0, 0, NULL, '2026-05-01 12:06:40', '2026-05-01 12:10:58'),
(2, 'adminsaja', 'adminsaja@gmail.com', '$2y$12$cWtNDT5fxp/A4P/p6wpJku7tFzqE9smQ.1vuHZupZYWCIs2bShuNW', 'admin', NULL, NULL, 0, 0, NULL, '2026-05-01 12:07:18', '2026-05-21 11:01:59'),
(3, 'driver1', 'driver1@gmail.com', '$2y$12$bVsR4KKUai4xvx5UOepX4.dmSgPztfn7CkYoiiLRR3mcdLQAOFFb.', 'driver', NULL, NULL, 0, 0, NULL, '2026-05-01 12:07:56', '2026-06-19 12:10:44'),
(4, 'driver2', 'driver2@gmail.com', '$2y$12$swfukxFDcD4zItMxdzxUjOzYbxC8A.CcTpe3FlOFHVThrjivEPUdS', 'driver', NULL, 'profile_photos/1778629386_4.png', 0, 0, NULL, '2026-05-01 12:09:00', '2026-06-06 13:45:27'),
(5, 'driver3', 'driver3@gmail.com', '$2y$12$3rp7FmwvU6fNyD/wo7OH1ucS02yg5.Sf0HZuUfM65nUtTC1ngRMRK', 'driver', NULL, NULL, 0, 0, NULL, '2026-05-01 12:09:26', '2026-05-25 05:28:45'),
(6, 'driver4', 'driver4@gmail.com', '$2y$12$9QIZ6ABhi5QN9kJXgEKhbOxlnxu8qDhL5UPtjo/rzq.AZcL7kMbka', 'driver', NULL, NULL, 0, 0, NULL, '2026-05-01 12:09:51', '2026-06-13 20:02:48'),
(8, 'admin2', 'admin2@gmail.com', '$2y$12$Y.9zObSr4dBS/yZP5iR.3utZ2Lx9GvksKSrZenY00j.i0PavzkqBa', 'admin', NULL, NULL, 0, 0, NULL, '2026-05-01 12:10:42', '2026-05-21 11:41:39'),
(10, 'Glensius', 'budi@gmail.com', '$2y$12$vH3S3PLaWlE7qUwt0UxMC.hGbp6FJJz9CWGGdEwm4xCKdUdCUNTIm', 'admin', NULL, 'profile_photos/1777868338_10.jpeg', 0, 1, NULL, '2026-05-03 17:00:00', '2026-06-20 00:55:24'),
(11, 'driver10', 'driver10@gmail.com', '$2y$12$XVHgT8dSSeQxZWZ/ceE9eeMTl5qIMOr2o52hUWZeeAozBJuFfzY26', 'driver', NULL, NULL, 0, 0, NULL, '2026-05-03 17:00:00', '2026-06-10 23:50:54'),
(12, 'driver11', 'driver11@gmail.com', '$2y$12$TRR9glNfPwI/dB7zhjO0T.A/TGCirWn78F6yEHxQ3spcpXPLRXG3K', 'driver', NULL, NULL, 0, 0, NULL, '2026-05-03 17:00:00', '2026-05-25 09:07:06'),
(13, 'driver12', 'driver12@gmail.com', '$2y$12$MBi3y0g25M9g7miA3npAqefkN4Z9bgPhEPYRHBZJj0Z2Qz2JauY.6', 'driver', NULL, NULL, 0, 0, NULL, '2026-05-03 17:00:00', '2026-06-01 22:56:21'),
(14, 'driver13', 'driver13@gmail.com', '$2y$12$TJjwIq3YZXR4IWS0h/0xZ.BP2o5E7v7sG4qJ9sfky/iIBvo7QZ3MC', 'driver', NULL, NULL, 0, 0, NULL, '2026-05-03 17:00:00', '2026-06-08 05:34:01'),
(15, 'driver14', 'driver14@gmail.com', '$2y$12$/Q/AsnRy3gSYtYGMl3yDk.0u3ZMoAvk81PIsE0po.kr/JPzEW6bSO', 'driver', NULL, NULL, 0, 0, NULL, '2026-05-03 17:00:00', '2026-06-10 01:34:46'),
(16, 'driver15', 'driver15@gmail.com', '$2y$12$3.hvgRFgj3a7vTAq2PqFLOITCkyK/S4imB/AkmeufDsNjFiqF3UyK', 'driver', NULL, NULL, 0, 0, NULL, '2026-05-03 17:00:00', '2026-05-31 06:42:07'),
(17, 'driver16', 'driver16@gmail.com', '$2y$12$fyX.tpwnl/mXHhtd7EU6WO4eLOAXAcE3l6vRsqjUz.Ya/uqwAV2EO', 'driver', NULL, NULL, 0, 0, NULL, '2026-05-03 17:00:00', '2026-05-31 09:00:32'),
(18, 'driver17', 'driver17@gmail.com', '12345678', 'driver', NULL, NULL, 0, 0, NULL, '2026-05-03 17:00:00', NULL),
(20, 'Zaki', 'zaki@gmail.com', '$2y$12$6Px6n885Fn/0RPDQq7HmSOhdwnd2/lzPRTkAvT1zftdx9XCcdfpGm', 'driver', NULL, NULL, 0, 0, NULL, '2026-06-11 05:22:52', '2026-06-11 05:24:05'),
(21, 'driver20', 'driver20@gmail.com', '$2y$12$tu0zaVt8qIJBCf61b5PW8efw7IqetxXliwmGodvG0UCpsdEydoVIG', 'driver', NULL, NULL, 0, 0, NULL, '2026-06-13 19:56:01', '2026-06-13 20:07:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bukti_pengirimans`
--
ALTER TABLE `bukti_pengirimans`
  ADD PRIMARY KEY (`bukti_pengiriman_id`),
  ADD KEY `bukti_pengirimans_pengiriman_id_index` (`pengiriman_id`),
  ADD KEY `bukti_pengirimans_tanggal_bukti_index` (`tanggal_bukti`);

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
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chats_sender_id_receiver_id_index` (`sender_id`,`receiver_id`),
  ADD KEY `chats_receiver_id_is_read_index` (`receiver_id`,`is_read`),
  ADD KEY `chats_created_at_index` (`created_at`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `conversations_user_one_user_two_unique` (`user_one`,`user_two`),
  ADD KEY `conversations_user_two_foreign` (`user_two`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `customers_nama_perusahaan_index` (`nama_perusahaan`),
  ADD KEY `customers_nomor_kontak_index` (`nomor_kontak`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`driver_id`),
  ADD UNIQUE KEY `drivers_no_sim_unique` (`no_sim`),
  ADD UNIQUE KEY `drivers_nik_unique` (`nik`),
  ADD KEY `drivers_user_id_index` (`user_id`),
  ADD KEY `drivers_no_sim_index` (`no_sim`),
  ADD KEY `drivers_nik_index` (`nik`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `kriterias`
--
ALTER TABLE `kriterias`
  ADD PRIMARY KEY (`kriteria_id`),
  ADD UNIQUE KEY `kriterias_kode_kriteria_unique` (`kode_kriteria`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mobils`
--
ALTER TABLE `mobils`
  ADD PRIMARY KEY (`mobil_id`),
  ADD UNIQUE KEY `mobils_no_plat_unique` (`no_plat`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_is_read_index` (`user_id`,`is_read`),
  ADD KEY `notifications_role_is_read_index` (`role`,`is_read`),
  ADD KEY `notifications_created_at_index` (`created_at`),
  ADD KEY `notifications_user_id_role_index` (`user_id`,`role`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `password_resets_token_unique` (`token`),
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pengajuans`
--
ALTER TABLE `pengajuans`
  ADD PRIMARY KEY (`pengajuan_id`),
  ADD KEY `pengajuans_driver_id_index` (`driver_id`),
  ADD KEY `pengajuans_mobil_id_index` (`mobil_id`),
  ADD KEY `pengajuans_status_index` (`status`),
  ADD KEY `pengajuans_tanggal_pengajuan_index` (`tanggal_pengajuan`),
  ADD KEY `pengajuans_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `pengirimans`
--
ALTER TABLE `pengirimans`
  ADD PRIMARY KEY (`pengiriman_id`),
  ADD UNIQUE KEY `pengirimans_nomor_surat_jalan_unique` (`nomor_surat_jalan`),
  ADD KEY `pengirimans_pengajuan_id_index` (`pengajuan_id`),
  ADD KEY `pengirimans_nomor_surat_jalan_index` (`nomor_surat_jalan`),
  ADD KEY `pengirimans_status_index` (`status`),
  ADD KEY `pengirimans_tanggal_pengiriman_index` (`tanggal_pengiriman`);

--
-- Indexes for table `penilaians`
--
ALTER TABLE `penilaians`
  ADD PRIMARY KEY (`penilaian_id`),
  ADD UNIQUE KEY `penilaians_driver_id_kriteria_id_unique` (`driver_id`,`kriteria_id`),
  ADD KEY `penilaians_kriteria_id_foreign` (`kriteria_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_google_id_unique` (`google_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bukti_pengirimans`
--
ALTER TABLE `bukti_pengirimans`
  MODIFY `bukti_pengiriman_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `driver_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kriterias`
--
ALTER TABLE `kriterias`
  MODIFY `kriteria_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `mobils`
--
ALTER TABLE `mobils`
  MODIFY `mobil_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengajuans`
--
ALTER TABLE `pengajuans`
  MODIFY `pengajuan_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `pengirimans`
--
ALTER TABLE `pengirimans`
  MODIFY `pengiriman_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `penilaians`
--
ALTER TABLE `penilaians`
  MODIFY `penilaian_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bukti_pengirimans`
--
ALTER TABLE `bukti_pengirimans`
  ADD CONSTRAINT `bukti_pengirimans_pengiriman_id_foreign` FOREIGN KEY (`pengiriman_id`) REFERENCES `pengirimans` (`pengiriman_id`) ON DELETE CASCADE;

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chats_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `conversations`
--
ALTER TABLE `conversations`
  ADD CONSTRAINT `conversations_user_one_foreign` FOREIGN KEY (`user_one`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `conversations_user_two_foreign` FOREIGN KEY (`user_two`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `drivers`
--
ALTER TABLE `drivers`
  ADD CONSTRAINT `drivers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `pengajuans`
--
ALTER TABLE `pengajuans`
  ADD CONSTRAINT `pengajuans_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pengajuans_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`driver_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pengajuans_mobil_id_foreign` FOREIGN KEY (`mobil_id`) REFERENCES `mobils` (`mobil_id`) ON DELETE CASCADE;

--
-- Constraints for table `pengirimans`
--
ALTER TABLE `pengirimans`
  ADD CONSTRAINT `pengirimans_pengajuan_id_foreign` FOREIGN KEY (`pengajuan_id`) REFERENCES `pengajuans` (`pengajuan_id`) ON DELETE CASCADE;

--
-- Constraints for table `penilaians`
--
ALTER TABLE `penilaians`
  ADD CONSTRAINT `penilaians_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`driver_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `penilaians_kriteria_id_foreign` FOREIGN KEY (`kriteria_id`) REFERENCES `kriterias` (`kriteria_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
