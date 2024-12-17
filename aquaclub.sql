-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2024 at 03:05 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aquaclub`
--

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `profile_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `LastUpdated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`profile_id`, `user_id`, `CreationDate`, `LastUpdated`) VALUES
(2, 3, '2024-12-16 09:11:15', '2024-12-16 09:37:51'),
(3, 1, '2024-12-16 09:22:10', '2024-12-16 17:00:26');

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `program_id` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `ImageURL` varchar(255) NOT NULL,
  `AltText` varchar(255) DEFAULT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`program_id`, `Title`, `Description`, `ImageURL`, `AltText`, `CreationDate`) VALUES
(1, 'Artistic Swimming', 'Introducing the very best of artistic swimming training program for the Tokyo tour', 'artistic.jpeg', 'art image', '2024-12-16 19:58:33');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `schedule_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `day` varchar(20) NOT NULL,
  `activity` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`schedule_id`, `user_id`, `day`, `activity`, `created_at`, `updated_at`) VALUES
(23, 1, 'Friday', 'Get some rest', '2024-12-16 11:56:38', '2024-12-16 11:56:38'),
(24, 1, 'Thursday', 'Meeting the team Doc', '2024-12-16 11:56:56', '2024-12-16 11:56:56'),
(26, 1, 'Wednesday', 'Master Diving', '2024-12-16 11:57:38', '2024-12-16 11:57:38'),
(28, 3, 'Wednesday', 'hjhh', '2024-12-16 12:12:12', '2024-12-16 12:53:13'),
(29, 3, 'Tuesday', 'Meeting the team Doc', '2024-12-16 12:12:41', '2024-12-16 12:12:41'),
(30, 3, 'Monday', 'Meeting the team Doc', '2024-12-16 12:34:32', '2024-12-16 12:34:32'),
(35, 3, 'Monday', 'going for  finals', '2024-12-16 12:58:05', '2024-12-16 12:58:05'),
(36, 1, 'Monday', 'Going for movies', '2024-12-16 16:21:45', '2024-12-16 16:21:45'),
(37, 1, 'Monday', 'Learn to glide', '2024-12-16 19:32:22', '2024-12-16 19:32:22');

-- --------------------------------------------------------

--
-- Table structure for table `userdashboard`
--

CREATE TABLE `userdashboard` (
  `dashboard_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `WelcomeMessage` varchar(255) NOT NULL,
  `profilepic_url` varchar(255) DEFAULT 'default-profile.png',
  `NewsTitle` varchar(255) DEFAULT NULL,
  `NewsContent` text DEFAULT NULL,
  `NewsImage` varchar(255) DEFAULT NULL,
  `NewsLink` varchar(255) DEFAULT NULL,
  `LastUpdated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userdashboard`
--

INSERT INTO `userdashboard` (`dashboard_id`, `user_id`, `WelcomeMessage`, `profilepic_url`, `NewsTitle`, `NewsContent`, `NewsImage`, `NewsLink`, `LastUpdated`) VALUES
(1, 1, 'Welcome to your Dashboard!', 'Fadzai.png', 'National Swimming Championships Announced', 'The 2024 National Swimming Championships will be held in July. Swimmers from across the country are gearing up for this exciting event.', 'champs.jpeg', '#', '2024-12-16 08:11:54'),
(2, 1, 'Welcome to your Dashboard!', 'Fadzai.png', 'New Training Techniques for Beginners', 'Coaches are introducing innovative methods to help beginner swimmers improve their strokes and boost confidence in the water.', 'training.jpeg', '#', '2024-12-16 08:11:54'),
(3, 1, 'Welcome to your Dashboard!', 'Fadzai.png', 'Top Swimmers to Watch in 2024', 'Experts highlight the top athletes to look out for this season, with promising talent emerging from regional competitions.', 'top.jpg', '#', '2024-12-16 08:11:54'),
(4, 3, 'Welcome to your Swimming Dashboard!!!!', 'default-profile.png', 'Trending Tricks ', 'Dr. Mahwenyiyi has discovered some really cool tricks for the relay team that could carry you a long way. Brace up and don\'t miss out on this!!', 'dash.jpg', '#', '2024-12-16 08:38:38'),
(5, 1, 'Get Started!!!!!!!!', '', 'Diving Skills', 'Dr. Sampah has come up with wonderful skills on how to safely dive and prolong the time underwater', 'dive.jpeg', '#', '2024-12-16 16:52:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('regular','admin') DEFAULT 'regular',
  `profilepic_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `fname`, `lname`, `email`, `password`, `role`, `profilepic_url`, `created_at`, `updated_at`) VALUES
(1, 'Far', 'Fadzo', 'Zara', 'fadzi@gmail.com', '$2y$10$CWcJuhvR1ZZYbUZ30vqrFOzAnshqbITJYnIhTYJBKhu7Po58Ib0wK', 'admin', '', '2024-12-15 09:16:47', '2024-12-16 21:44:42'),
(2, 'Kue', 'Kudzai', 'Zaranyika', 'kue@gmail.com', '$2y$10$qFLiqtKNtHOkMQqaRSvZu.ETVgHTLyeUksKebh1HfM2Nr3NHi61YO', 'admin', '', '2024-12-15 09:18:26', '2024-12-16 20:00:35'),
(3, 'Promie', 'Prom', 'Mahwenyiyi', 'prom@gmail.com', '$2y$10$eAYaDNHhIecCPx/7V8FaVOc66EBow.qrT4dgIBbgp4KR5t87aEFPi', 'admin', '', '2024-12-15 09:41:18', '2024-12-16 22:36:44');

-- --------------------------------------------------------

--
-- Table structure for table `user_progress`
--

CREATE TABLE `user_progress` (
  `progress_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `activity_name` varchar(100) NOT NULL,
  `progress_level` int(11) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_progress`
--

INSERT INTO `user_progress` (`progress_id`, `user_id`, `activity_name`, `progress_level`, `category`, `description`, `last_updated`) VALUES
(1, 3, 'Back-Stroke', 34, 'Swimming', 'More effort needed!!', '2024-12-16 13:14:55'),
(2, 3, 'Artistic Swimming', 10, 'Arts', 'You need to put more effort at this level', '2024-12-16 13:16:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`program_id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `userdashboard`
--
ALTER TABLE `userdashboard`
  ADD PRIMARY KEY (`dashboard_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_progress`
--
ALTER TABLE `user_progress`
  ADD PRIMARY KEY (`progress_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `program_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `userdashboard`
--
ALTER TABLE `userdashboard`
  MODIFY `dashboard_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_progress`
--
ALTER TABLE `user_progress`
  MODIFY `progress_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `userdashboard`
--
ALTER TABLE `userdashboard`
  ADD CONSTRAINT `userdashboard_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_progress`
--
ALTER TABLE `user_progress`
  ADD CONSTRAINT `user_progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
