-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2025 at 09:23 AM
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
-- Database: `db_jogjalensa`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `booking_code` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `duration_extra` int(11) DEFAULT 0,
  `location_note` text NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','paid','confirmed','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `booking_code`, `user_id`, `vendor_id`, `package_id`, `booking_date`, `booking_time`, `duration_extra`, `location_note`, `total_price`, `status`, `created_at`) VALUES
(7, 'INV-1763959204', 7, 5, 7, '0222-02-22', '14:22:00', 0, 'aaa', 500000.00, 'completed', '2025-11-24 04:40:04'),
(8, 'INV-1763965983', 7, 4, 8, '2005-08-29', '00:00:00', 0, 'asu', 15000.00, 'completed', '2025-11-24 06:33:03'),
(9, 'INV-1763966506', 7, 4, 8, '2222-02-22', '14:22:00', 0, '222', 15000.00, 'completed', '2025-11-24 06:41:46'),
(10, 'INV-1763966624', 7, 4, 8, '2222-02-22', '14:22:00', 0, '2', 15000.00, 'completed', '2025-11-24 06:43:44'),
(11, 'INV-1763966861', 7, 4, 9, '2222-02-22', '14:22:00', 0, '1', 50000.00, 'completed', '2025-11-24 06:47:41');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration_hours` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `vendor_id`, `name`, `description`, `price`, `duration_hours`) VALUES
(8, 4, 'Es Pertalite Oplos', 'Pertalite bonus ethanol', 15000.00, 1),
(9, 4, 'ASUUU', 'Asu', 50000.00, 2),
(10, 5, 'Ijazah', 'Asli coy', 50000.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `packages_history`
--

CREATE TABLE `packages_history` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration_hours` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `packages_history`
--

INSERT INTO `packages_history` (`id`, `vendor_id`, `name`, `description`, `price`, `duration_hours`) VALUES
(7, 5, 'anjay', 'buset', 500000.00, 2),
(8, 4, 'Es Pertalite Oplos', 'Pertalite bonus ethanol', 15000.00, 1),
(9, 4, 'ASUUU', 'Asu', 50000.00, 2),
(10, 5, 'Ijazah', 'Asli coy', 50000.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `portofolio`
--

CREATE TABLE `portofolio` (
  `id` int(11) NOT NULL,
  `id_vendor` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `portofolio`
--

INSERT INTO `portofolio` (`id`, `id_vendor`, `nama`, `description`, `link`, `photo`, `created_at`) VALUES
(2, 4, 'A', 'a', NULL, 'uploads/portofolio/portofolio_4_1763972563.png', '2025-11-24 08:22:43');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `rating` int(1) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `booking_id`, `rating`, `comment`, `created_at`) VALUES
(1, 11, 5, 'cabul', '2025-11-24 07:22:01'),
(2, 10, 5, 'cabul', '2025-11-24 07:25:30'),
(3, 9, 1, 'tititnya keliatan', '2025-11-24 07:36:24'),
(4, 8, 3, 'tt nya kecil', '2025-11-24 07:57:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('client','vendor','admin') NOT NULL DEFAULT 'client',
  `profile_img` varchar(255) DEFAULT 'default_profile.jpg',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `role`, `profile_img`, `created_at`) VALUES
(7, 'prayaAbhi', 'abdillahabhi12@gmail.com', '$2y$10$RAyFUWcpaEV4JfUanf3bw.zBNPKTuUPwhHzllvdhC1G3RGNNV6nEW', 'client', 'https://encrypted-tbn0.gstatic.com/licensed-image?q=tbn:ANd9GcR7fm7OqF-PXJlnAZJksqrKKIU4uzJtB1VAa1Ew2D2d2awEcTDuUTAiuHmWtEgvka4UNZ62RNwLtzIab6YZj8T5PRUhgMheuoioNRtMnVkhHnuZHJy0SJrRPwf3tC2PQSPefM_Q02JluAgh&amp;s=19', '2025-11-24 03:36:07'),
(8, 'Saha Eta', 'ujicobasajax@gmail.com', '$2y$10$geaVP84mi7WNnm5Pik1YEezxIcITYXeiNIh/jCUAsbILH.HHDqLmm', 'client', 'default_profile.jpg', '2025-11-24 03:44:16'),
(9, 'Saha Eta Saha Eta', 'ujicobasaja@gmail.com', '$2y$10$SX79SLnU9ccFv6vZBr97R.EczXQTN5Pw.7zAwEBg060qPnu2zSkNu', 'vendor', 'default_profile.jpg', '2025-11-24 03:45:37'),
(10, 'Saha Eta Saha Eta', 'ujicobasaja1@gmail.com', '$2y$10$SX79SLnU9ccFv6vZBr97R.EczXQTN5Pw.7zAwEBg060qPnu2zSkNu', 'vendor', 'default_profile.jpg', '2025-11-24 03:46:33');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `brand_name` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `profile_img` varchar(255) DEFAULT 'default_profile.jpg',
  `cover_img` varchar(255) DEFAULT 'default_cover.jpg',
  `instagram` varchar(100) DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `equipment` text DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `user_id`, `brand_name`, `category`, `location`, `description`, `profile_img`, `cover_img`, `instagram`, `skills`, `equipment`, `is_verified`) VALUES
(4, 9, 'Windah Payudara', 'Wisuda', 'Sleman', 'anjay', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS9w81ejEZJqC6H1I2FU_b8nOWN6MOKedKAIIks4td8-ERbmaSf9ONpY-QDCcc2CJ_QaZ5wH8JUINqA2zdzTlnC7qizsle0xW7xyspkY93G&amp;s=10', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS9w81ejEZJqC6H1I2FU_b8nOWN6MOKedKAIIks4td8-ERbmaSf9ONpY-QDCcc2CJ_QaZ5wH8JUINqA2zdzTlnC7qizsle0xW7xyspkY93G&amp;s=10', 'windah', NULL, NULL, 0),
(5, 10, 'Jock Owi', 'Wedding', 'Bantul', '', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcShVxHvxUNq4t601vdzPTthGNgRpzybzv_qkgWjMlctEisWdFjGULkwhraYYV3QS9seY67H3jCKrKi4qBK-Jn9377gf70g6RWD7EXnFWhk&amp;s=10', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcShVxHvxUNq4t601vdzPTthGNgRpzybzv_qkgWjMlctEisWdFjGULkwhraYYV3QS9seY67H3jCKrKi4qBK-Jn9377gf70g6RWD7EXnFWhk&amp;s=10', 'jojokowi', NULL, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `packages_history`
--
ALTER TABLE `packages_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `portofolio`
--
ALTER TABLE `portofolio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_vendor` (`id_vendor`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `portofolio`
--
ALTER TABLE `portofolio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`);

--
-- Constraints for table `packages`
--
ALTER TABLE `packages`
  ADD CONSTRAINT `packages_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `portofolio`
--
ALTER TABLE `portofolio`
  ADD CONSTRAINT `fk_portofolio_vendor` FOREIGN KEY (`id_vendor`) REFERENCES `vendors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`);

--
-- Constraints for table `vendors`
--
ALTER TABLE `vendors`
  ADD CONSTRAINT `vendors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
