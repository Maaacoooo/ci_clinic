-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2017 at 09:20 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci_clinic`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('7r4deecp8h91p70kgtmqaskp7tnfg6mu', '::1', 1499841957, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439393834313935373b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('hjs37fsvo6gl0mmv2i0ujbf980e8eqjg', '::1', 1499842261, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439393834323236313b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('tnk8i3tgpnsofqs1qie6g6kom6ag4gu9', '::1', 1499843145, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439393834333134353b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d737563636573737c733a32313a22537563636573212055736572205570646174656421223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('cmbpfc6vraijgvhmgas4uqaaoq457dac', '::1', 1499843473, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439393834333437333b),
('j2khk25ac0m7f5sd7fqprgf1t75j9upm', '::1', 1499843906, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439393834333930363b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('ik01upgo11svljo9arpcf3hcgbnvtoq8', '::1', 1499843906, 0x5f5f63695f6c6173745f726567656e65726174657c693a313439393834333930363b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `usertype` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `name`, `usertype`, `img`, `created_at`, `updated_at`) VALUES
('hehe', '$2y$10$T54kmF5IaVPy4VGpVXisKuWx92q/yZM61X49WIrPKj6vvIchGg6gy', 'hehesss', 'Administrator', '', '2017-07-12 14:51:06', '2017-07-12 06:51:06'),
('maco', '$2y$10$yXXbqfWB.Xi0yZ1QSXoMQeP1vtcwQmafC8ImZ0xE2haP/4SIz7fie', 'Maco Cortes', 'Administrator', '4be6e3777d7ec3f425bfe66bb0c68647.jpg', '2017-07-12 00:27:12', '2017-07-11 16:27:12');

-- --------------------------------------------------------

--
-- Table structure for table `usertypes`
--

CREATE TABLE `usertypes` (
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usertypes`
--

INSERT INTO `usertypes` (`title`) VALUES
('Administrator');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD KEY `FKusertype` (`usertype`);

--
-- Indexes for table `usertypes`
--
ALTER TABLE `usertypes`
  ADD PRIMARY KEY (`title`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
