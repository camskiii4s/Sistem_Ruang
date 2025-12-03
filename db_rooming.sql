-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 25, 2024 at 03:57 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_rooming`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking_lists`
--

CREATE TABLE `booking_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `purpose` varchar(100) NOT NULL,
  `status` enum('PENDING','DISETUJUI','DIGUNAKAN','DITOLAK','EXPIRED','BATAL','SELESAI') NOT NULL DEFAULT 'PENDING',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_lists`
--

INSERT INTO `booking_lists` (`id`, `room_id`, `user_id`, `date`, `start_time`, `end_time`, `purpose`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2024-12-26', '08:00:00', '10:30:00', 'Rapat Umum', 'DISETUJUI', NULL, '2024-12-25 12:32:36', '2024-12-25 12:34:34');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"fee45cbc-c7ff-40c5-b3ab-7798af40b09d\",\"displayName\":\"App\\\\Jobs\\\\SendEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmail\",\"command\":\"O:18:\\\"App\\\\Jobs\\\\SendEmail\\\":21:{s:14:\\\"receiver_email\\\";s:13:\\\"user@user.com\\\";s:9:\\\"user_name\\\";s:4:\\\"User\\\";s:9:\\\"room_name\\\";s:9:\\\"Meeting 1\\\";s:4:\\\"date\\\";s:10:\\\"2024-12-26\\\";s:10:\\\"start_time\\\";s:5:\\\"08:00\\\";s:8:\\\"end_time\\\";s:5:\\\"10:30\\\";s:7:\\\"purpose\\\";s:10:\\\"Rapat Umum\\\";s:7:\\\"to_role\\\";s:4:\\\"USER\\\";s:13:\\\"receiver_name\\\";s:4:\\\"User\\\";s:3:\\\"url\\\";s:18:\\\"https:\\/\\/google.com\\\";s:6:\\\"status\\\";s:6:\\\"DIBUAT\\\";s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1735129957, 1735129957),
(2, 'default', '{\"uuid\":\"453434a6-d568-4734-a32f-7c796401bf30\",\"displayName\":\"App\\\\Jobs\\\\SendEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmail\",\"command\":\"O:18:\\\"App\\\\Jobs\\\\SendEmail\\\":21:{s:14:\\\"receiver_email\\\";s:15:\\\"admin@admin.com\\\";s:9:\\\"user_name\\\";s:4:\\\"User\\\";s:9:\\\"room_name\\\";s:9:\\\"Meeting 1\\\";s:4:\\\"date\\\";s:10:\\\"2024-12-26\\\";s:10:\\\"start_time\\\";s:5:\\\"08:00\\\";s:8:\\\"end_time\\\";s:5:\\\"10:30\\\";s:7:\\\"purpose\\\";s:10:\\\"Rapat Umum\\\";s:7:\\\"to_role\\\";s:5:\\\"ADMIN\\\";s:13:\\\"receiver_name\\\";s:5:\\\"Admin\\\";s:3:\\\"url\\\";s:18:\\\"https:\\/\\/google.com\\\";s:6:\\\"status\\\";s:6:\\\"DIBUAT\\\";s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1735129957, 1735129957),
(3, 'default', '{\"uuid\":\"8c09e6a0-cca5-413b-b4cb-d54fdad163e2\",\"displayName\":\"App\\\\Jobs\\\\SendEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmail\",\"command\":\"O:18:\\\"App\\\\Jobs\\\\SendEmail\\\":21:{s:14:\\\"receiver_email\\\";s:13:\\\"user@user.com\\\";s:9:\\\"user_name\\\";s:4:\\\"User\\\";s:9:\\\"room_name\\\";s:9:\\\"Meeting 1\\\";s:4:\\\"date\\\";s:10:\\\"2024-12-26\\\";s:10:\\\"start_time\\\";s:8:\\\"08:00:00\\\";s:8:\\\"end_time\\\";s:8:\\\"10:30:00\\\";s:7:\\\"purpose\\\";s:10:\\\"Rapat Umum\\\";s:7:\\\"to_role\\\";s:4:\\\"USER\\\";s:13:\\\"receiver_name\\\";s:4:\\\"User\\\";s:3:\\\"url\\\";s:18:\\\"https:\\/\\/google.com\\\";s:6:\\\"status\\\";s:9:\\\"DISETUJUI\\\";s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1735130074, 1735130074),
(4, 'default', '{\"uuid\":\"8e03cbd1-de16-420e-b1d5-17555f977c88\",\"displayName\":\"App\\\\Jobs\\\\SendEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendEmail\",\"command\":\"O:18:\\\"App\\\\Jobs\\\\SendEmail\\\":21:{s:14:\\\"receiver_email\\\";s:15:\\\"admin@admin.com\\\";s:9:\\\"user_name\\\";s:4:\\\"User\\\";s:9:\\\"room_name\\\";s:9:\\\"Meeting 1\\\";s:4:\\\"date\\\";s:10:\\\"2024-12-26\\\";s:10:\\\"start_time\\\";s:8:\\\"08:00:00\\\";s:8:\\\"end_time\\\";s:8:\\\"10:30:00\\\";s:7:\\\"purpose\\\";s:10:\\\"Rapat Umum\\\";s:7:\\\"to_role\\\";s:5:\\\"ADMIN\\\";s:13:\\\"receiver_name\\\";s:5:\\\"Admin\\\";s:3:\\\"url\\\";s:18:\\\"https:\\/\\/google.com\\\";s:6:\\\"status\\\";s:9:\\\"DISETUJUI\\\";s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1735130074, 1735130074);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_12_30_021429_create_rooms_table', 1),
(5, '2020_12_30_021543_create_booking_lists_table', 1),
(6, '2021_01_20_062644_add_email_to_users_table', 1),
(7, '2021_01_21_201940_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `photo` varchar(191) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `description`, `capacity`, `photo`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Meeting 1', 'Ruang meeting Dyeing atas', 20, NULL, NULL, '2023-02-21 10:36:32', '2023-02-21 10:36:32'),
(2, 'Meeting 2', 'Ruang meeting Dyeing sebelah Meeting 1', 15, NULL, NULL, '2023-02-21 10:36:32', '2023-02-21 10:36:32'),
(3, 'Meeting 3', 'Ruang meeting di Office bawah', 15, NULL, NULL, '2023-02-21 10:36:32', '2023-02-21 10:36:32'),
(4, 'Meeting 4', 'Ruang meeting di Weaving', 15, NULL, NULL, '2023-02-21 10:36:32', '2023-02-21 10:36:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(191) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(20) DEFAULT NULL,
  `role` enum('USER','ADMIN') NOT NULL DEFAULT 'USER',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `description`, `role`, `deleted_at`, `remember_token`, `created_at`, `updated_at`, `email`) VALUES
(1, 'admin', '$2y$10$og2LZiVomhrunx9eg3puwed3UJ8t/IURtFCqillfNeDc5FxFTArmS', 'Admin', NULL, 'ADMIN', NULL, NULL, '2023-02-21 10:36:31', '2023-02-21 10:36:31', 'admin@admin.com'),
(2, 'user', '$2y$10$PhXgT0/FoY1fE1zOC6situ7tDY.aCFpCnEHkXBF.pe2NK.YTgyMOm', 'User', 'Accounting Staff', 'USER', NULL, NULL, '2023-02-21 10:36:31', '2023-02-21 10:36:31', 'user@user.com'),
(3, 'fajar', '$2y$10$aqNuWxjatNP4uBqvP.biNOqRynxPIESnZEyfn5M0oen.zZp6aNDt2', 'Fajarwz', 'IT Staff', 'USER', NULL, NULL, '2023-02-21 10:36:32', '2023-02-21 10:36:32', 'fajar@gmail.com'),
(4, 'foo', '$2y$10$F1YKNr9MOEZDgRsQsMx3vu1KE.5wXaOZbGSBaA4XBVHnejmhTxJzm', 'Foo', NULL, 'USER', NULL, NULL, '2023-02-21 10:36:32', '2023-02-21 10:36:32', 'foo@gmail.com'),
(5, 'bar', '$2y$10$SvNoZYAMXvY/Yila8//HoueYXqT5yA2LO5WWAT3FYrUX8rc7sgW.G', 'Bar', NULL, 'USER', NULL, NULL, '2023-02-21 10:36:32', '2023-02-21 10:36:32', 'bar@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking_lists`
--
ALTER TABLE `booking_lists`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_username_email_unique` (`username`,`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking_lists`
--
ALTER TABLE `booking_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
