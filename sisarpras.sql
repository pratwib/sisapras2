-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2023 at 05:58 AM
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
-- Database: `sisarpras`
--

-- --------------------------------------------------------

--
-- Table structure for table `borrows`
--

CREATE TABLE `borrows` (
  `borrow_id` int(11) NOT NULL,
  `location_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `lend_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `return_date` date NOT NULL,
  `lend_quantity` int(11) NOT NULL,
  `lend_detail` text NOT NULL,
  `lend_photo` varchar(255) NOT NULL,
  `lend_status` enum('requested','approved','declined','canceled','borrowed','returned','overdue') NOT NULL DEFAULT 'requested'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrows`
--

INSERT INTO `borrows` (`borrow_id`, `location_id`, `item_id`, `user_id`, `lend_date`, `return_date`, `lend_quantity`, `lend_detail`, `lend_photo`, `lend_status`) VALUES
(27, 16, 15, 62, '2023-08-06 06:17:29', '2023-08-07', 1, 'abcde', '230806061729.jpg', 'canceled'),
(28, 16, 15, 62, '2023-08-06 06:19:29', '2023-08-05', 1, 'abcde', '230806061929.jpg', 'declined'),
(29, 17, 18, 62, '2023-08-06 06:21:28', '2023-08-08', 2, 'abcde', '230806062128.jpg', 'declined'),
(30, 16, 16, 63, '2023-08-06 06:23:26', '2023-08-10', 2, 'abcde', '230806062326.jpg', 'returned'),
(31, 16, 16, 63, '2023-08-06 06:23:34', '2023-08-10', 2, 'abcde', '230806062334.jpg', 'canceled'),
(32, 17, 18, 63, '2023-08-06 06:24:32', '2023-08-05', 3, 'abcde', '230806062432.jpg', 'returned');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `location_id` int(11) DEFAULT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_quantity` int(11) NOT NULL DEFAULT 0,
  `item_desc` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `location_id`, `item_name`, `item_quantity`, `item_desc`, `deleted_at`) VALUES
(15, 16, 'Speaker', 24, 'Sebuah speaker samsung', NULL),
(16, 16, 'Infocus', 6, NULL, NULL),
(17, 16, 'Pointer', 12, 'Pointer merk logitech, jarak 4 meter', NULL),
(18, 17, 'Kabel USB', 17, 'Kabel usb type A panjang 2 meter', NULL),
(19, 17, 'Laptop Asus', 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `location_id` int(11) NOT NULL,
  `location_name` varchar(100) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`location_id`, `location_name`, `deleted_at`) VALUES
(15, 'Teknik Kimia', NULL),
(16, 'Teknik Komputer', NULL),
(17, 'SIFT', NULL),
(18, 'Teknik Geodesi', NULL),
(19, 'Teknik Mesin', NULL),
(20, 'Teknik Sipil', NULL);

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
(1, '2014_10_12_100000_create_password_reset_tokens_table', 1);

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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `location_id` int(11) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `reg_number` varchar(255) DEFAULT NULL,
  `hp_number` varchar(20) NOT NULL,
  `department` varchar(255) DEFAULT NULL,
  `role` enum('user','admin','superadmin') NOT NULL DEFAULT 'user',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `location_id`, `password`, `name`, `email`, `reg_number`, `hp_number`, `department`, `role`, `deleted_at`) VALUES
(59, NULL, '$2y$10$FUAj2w2nTqmZfdsYL7yZuu6JOcmP5pcShHRLG5VwZB1gMDShBYe/O', 'Super Admin', 'superadmin@gmail.com', NULL, '082111111111', NULL, 'superadmin', NULL),
(60, 17, '$2y$10$ANM4ClOiZkmi41kMxZvnXOt7SNe9FKvZrRt4WK4aqkR8FRM6Hk5nS', 'Admin SIFT', 'adminsift@gmail.com', NULL, '083111111111', NULL, 'admin', NULL),
(61, 16, '$2y$10$lBhvKafI/iEm2/t28yYqVu0htDnwHylghIIVrW3DQQbTVIMszU0tO', 'Admin Tekkom', 'admintekkom@gmail.com', NULL, '083222222222', NULL, 'admin', NULL),
(62, NULL, '$2y$10$Y4uG85Jmv0KnVN1ByVd76OxgnjYkHb0WcbydM0Md0629hFtLa9cNm', 'User 1', 'user1@gmail.com', '21120119130111', '085111111111', 'Teknik Komputer', 'user', NULL),
(63, NULL, '$2y$10$TknEiApdVGIoytzpsw3le.bwJ8Hm9OIUwoMFyluaC5yt/yBVHBbE6', 'User 2', 'user2@gmail.com', '21120119130222', '085222222222', 'Psikologi', 'user', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `borrows`
--
ALTER TABLE `borrows`
  ADD PRIMARY KEY (`borrow_id`),
  ADD KEY `location_id` (`location_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `location_id` (`location_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`location_id`),
  ADD UNIQUE KEY `location_name` (`location_name`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `location_id` (`location_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `borrows`
--
ALTER TABLE `borrows`
  MODIFY `borrow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrows`
--
ALTER TABLE `borrows`
  ADD CONSTRAINT `borrows_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`location_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `borrows_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `borrows_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`location_id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`location_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
