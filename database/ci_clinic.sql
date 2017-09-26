-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2017 at 02:43 AM
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
-- Table structure for table `billing`
--

CREATE TABLE `billing` (
  `id` int(11) NOT NULL,
  `case_id` int(11) DEFAULT NULL,
  `remarks` text,
  `status` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `user` varchar(255) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `billing`
--

INSERT INTO `billing` (`id`, `case_id`, `remarks`, `status`, `created_at`, `updated_at`, `user`, `is_deleted`) VALUES
(1, 1, NULL, 0, '2017-09-25 21:59:59', '2017-09-25 23:00:27', 'assist', 0),
(2, 2, NULL, 0, '2017-09-25 23:10:09', NULL, 'assist', 0);

-- --------------------------------------------------------

--
-- Table structure for table `billing_items`
--

CREATE TABLE `billing_items` (
  `id` int(11) NOT NULL,
  `billing_id` int(11) DEFAULT NULL,
  `service` varchar(255) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `billing_items`
--

INSERT INTO `billing_items` (`id`, `billing_id`, `service`, `qty`, `discount`, `remarks`) VALUES
(1, 1, 'Blood Testing', 1, NULL, NULL),
(2, 2, 'Urine Testing', 1, NULL, NULL),
(3, 2, 'Blood Testing', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `billing_payments`
--

CREATE TABLE `billing_payments` (
  `id` int(11) NOT NULL,
  `billing_id` int(11) DEFAULT NULL,
  `payee` varchar(255) DEFAULT NULL,
  `amount` double(10,2) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `billing_payments`
--

INSERT INTO `billing_payments` (`id`, `billing_id`, `payee`, `amount`, `remarks`, `user`, `created_at`) VALUES
(1, 1, 'Maco', 50.00, NULL, 'maco', '2017-09-25 23:02:17'),
(2, 1, 'Maco', 50.00, NULL, 'maco', '2017-09-25 23:02:17'),
(3, 2, 'Nah', 50.00, NULL, 'maco', '2017-09-25 23:02:17');

-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

CREATE TABLE `cases` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `weight` double DEFAULT NULL,
  `height` double DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cases`
--

INSERT INTO `cases` (`id`, `patient_id`, `title`, `description`, `weight`, `height`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'High Fever', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repudiandae eligendi laudantium culpa debitis quis accusantium, perspiciatis aspernatur rerum animi, sunt quibusdam nobis quaerat temporibus officia dolor. Est qui deserunt officia quae iste soluta, odit consequuntur at inventore non pariatur nihil illum omnis dolores ipsa dignissimos eos veniam! Enim adipisci esse id ullam illo odio placeat consequatur quia non reiciendis ut molestias facere assumenda dignissimos dolores beatae tenetur itaque dolorum voluptatibus harum hic, ratione atque recusandae fugiat. Sint quibusdam inventore vero ipsum tempore ad sequi consequuntur beatae sed laboriosam at placeat aliquid doloremque perspiciatis totam minus, ea voluptatem, cum nisi reprehenderit.</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repudiandae eligendi laudantium culpa debitis quis accusantium, perspiciatis aspernatur rerum animi, sunt quibusdam nobis quaerat temporibus officia dolor. Est qui deserunt officia quae iste soluta, odit consequuntur at inventore non pariatur nihil illum omnis dolores ipsa dignissimos eos veniam! Enim adipisci esse id ullam illo odio placeat consequatur quia non reiciendis ut molestias facere assumenda dignissimos dolores beatae tenetur itaque dolorum voluptatibus harum hic, ratione atque recusandae fugiat. Sint quibusdam inventore vero ipsum tempore ad sequi consequuntur beatae sed laboriosam at placeat aliquid doloremque perspiciatis totam minus, ea voluptatem, cum nisi reprehenderit.</p>', 60, 165, 0, '2017-09-25 21:59:59', '2017-09-25 13:59:59'),
(2, 2, 'Vomitting', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Placeat, error. Vero sed corporis eius at tempore velit aliquid odio, sunt placeat dolor. Iure assumenda deleniti consectetur sint doloribus sequi, animi. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Placeat, error. Vero sed corporis eius at tempore velit aliquid odio, sunt placeat dolor. Iure assumenda deleniti consectetur sint doloribus sequi, animi.&nbsp;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Placeat, error. Vero sed corporis eius at tempore velit aliquid odio, sunt placeat dolor. Iure assumenda deleniti consectetur sint doloribus sequi, animi.<br /><br />Lorem ipsum dolor sit amet, consectetur adipisicing elit. Placeat, error. Vero sed corporis eius at tempore velit aliquid odio, sunt placeat dolor. Iure assumenda deleniti consectetur sint doloribus sequi, animi.</p>', 85, 174, 0, '2017-09-25 23:10:09', '2017-09-25 15:10:09');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('bv02tccs3nusfqt1g9uhnfs5cflagnhj', '::1', 1506340268, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363334303236383b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('9p0285hb44nircevt01tbkg61c5i5heb', '::1', 1506340748, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363334303734383b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('1djggcanfjepv75jq3665fuf7g3b0ta7', '::1', 1506341070, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363334313037303b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('bvjv0pcei7umoblr4ghm6j904ri5blc6', '::1', 1506341745, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363334313734353b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('g9l764pmak81534g12uul9ok9qvk3je3', '::1', 1506342080, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363334323038303b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('bm4c1581cgaj9go7fb3bkh2viecfh1rb', '::1', 1506342408, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363334323430383b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('kuadsjih246nhrkldajgq6arno458hgc', '::1', 1506342752, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363334323735323b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('u3i60gbpae15cr7ajbmji0stiil63qop', '::1', 1506343108, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363334333130383b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('hvul9mjuug3rckr6ghv862jg8tbn8fg9', '::1', 1506343587, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363334333538373b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('s9j79a5f13iujjpn6s986c0mr9q1qfr8', '::1', 1506343975, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363334333937353b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('f33si48fgmsb53o9g1s3tcrsgvv2a19e', '::1', 1506344331, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363334343333313b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('h1p0m39lh1iuvkead48k6nktdpim5phu', '::1', 1506344660, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363334343636303b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('507f3g354jl1fooi5gll6cgrq77f83ei', '::1', 1506345051, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363334353035313b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('mp0jp9e72fkd97uggvggjngab8pgaos1', '::1', 1506345352, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363334353335323b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('dqmr3hj4ho82gq8vs4jjedmqvvqfm881', '::1', 1506345921, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363334353932313b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('dt244a5oqh5fq6fkf489ntulpgvhg480', '::1', 1506346244, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363334363234343b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('alan033i6hn0tuq9jqs8n4totl12r96h', '::1', 1506346559, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363334363535393b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('nml6ur9svp93ltdbpt8459otan4r2j3v', '::1', 1506346860, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363334363836303b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('gcpdl0mfclnervmfuha72es03gpalifj', '::1', 1506347183, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363334373138333b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('a0uuqdlukbc0d9m2cod62a9q7l7dv8fh', '::1', 1506347574, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363334373537343b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('1oiqn62s0nj3iv6sug6vsvfu58lrmbgs', '::1', 1506348011, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363334383031313b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d737563636573737c733a32393a2250617373776f726420526573657474656420746f2044656661756c7421223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('5qkfukco6f30snnjesmec9rt1uktvfp9', '::1', 1506347999, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363334373939393b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a363a22617373697374223b7d),
('s0rk74uoak2u54vpc967d02prk1sbo8t', '::1', 1506348319, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363334383331393b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a363a22617373697374223b7d737563636573737c733a33303a224465736372697074696f6e202f2052656d61726b73205570646174656421223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('f7thjvncn549p2jtid3bla9fatv0bidc', '::1', 1506348379, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363334383337393b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d737563636573737c733a33373a22496d6d756e697a6174696f6e20536572766963652052657175657374204372656174656421223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('8v3n0a5io43u8rtedffrd6cr4qlnk6vc', '::1', 1506350026, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363335303032363b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a363a22617373697374223b7d737563636573737c733a33303a224465736372697074696f6e202f2052656d61726b73205570646174656421223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('pa55hdoqce68ctii7i48nk957qsvmv5k', '::1', 1506349902, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363334393930323b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('vbuup9arbe2ar4j06pob2nldt64lj0l2', '::1', 1506350344, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363335303334343b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d6572726f727c733a32313a22416e204572726f7220686173204f63637572656421223b5f5f63695f766172737c613a313a7b733a353a226572726f72223b733a333a226f6c64223b7d),
('364gedobd6rrjeqlebs8pi21cna6m7ga', '::1', 1506350510, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363335303531303b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a363a22617373697374223b7d),
('u4lc7kq2uqa0k4fbpe0otgp4voo3mb81', '::1', 1506351071, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363335313037313b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('9hhjh2agr5ebu0vgg16ckskv138bativ', '::1', 1506352091, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363335323039313b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a363a22617373697374223b7d),
('db0nmht8g8jc4glscr4h5k707adgc3bq', '::1', 1506351374, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363335313337343b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('io4eq88ioof49aaqr006sa8f9661sefc', '::1', 1506351706, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363335313730363b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('ottl4eijrnac91t6e2qi75rme61sphfl', '::1', 1506352012, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363335323031323b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('8d2e3v54omlocaevk02m55dsqulq7ccd', '::1', 1506352323, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363335323332333b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d737563636573737c733a33343a224c61626f7261746f7279205265717565737420537461747573205570646174656421223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('qr49038hg2m910dfcij0lmotk557p0cv', '::1', 1506352291, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363335323039313b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a363a22617373697374223b7d),
('7eb2jq32bqbbs5a0d0abfi808l5pb4is', '::1', 1506352907, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363335323930373b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('npu123e4avlbol4jvl7kub982lt7seus', '::1', 1506353220, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363335333232303b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('t65g28c533gakima18jqkptpeuqtchpa', '::1', 1506353528, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363335333532383b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d),
('034ohaiv47fsvikvdkbvrfmak7ooqj4e', '::1', 1506353709, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530363335333532383b61646d696e5f6c6f676765645f696e7c613a313a7b733a383a22757365726e616d65223b733a343a226d61636f223b7d);

-- --------------------------------------------------------

--
-- Table structure for table `immunizations`
--

CREATE TABLE `immunizations` (
  `id` int(11) NOT NULL,
  `service` varchar(255) DEFAULT NULL,
  `case_id` int(11) DEFAULT NULL,
  `description` text NOT NULL,
  `status` int(11) DEFAULT '0',
  `user` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `immunizations`
--

INSERT INTO `immunizations` (`id`, `service`, `case_id`, `description`, `status`, `user`, `created_at`, `updated_at`) VALUES
(1, 'HEPA A ', 1, '', 0, 'maco', '2017-09-25 22:03:52', '2017-09-25 22:03:52'),
(2, 'Anti Depressant \r\n', 1, '', 0, 'maco', '2017-09-25 22:03:55', '2017-09-25 22:03:55');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`title`) VALUES
('COOL SHIT'),
('Paracetamol Alvedon 500'),
('Paracetamol Biogesic 500'),
('WTF');

-- --------------------------------------------------------

--
-- Table structure for table `lab_request`
--

CREATE TABLE `lab_request` (
  `id` int(11) NOT NULL,
  `service` varchar(255) DEFAULT NULL,
  `case_id` int(11) DEFAULT NULL,
  `description` text,
  `status` int(255) DEFAULT '0',
  `user` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lab_request`
--

INSERT INTO `lab_request` (`id`, `service`, `case_id`, `description`, `status`, `user`, `created_at`, `updated_at`) VALUES
(1, 'Urine Testing', 1, NULL, 0, 'maco', '2017-09-25 22:02:48', '2017-09-25 22:02:48'),
(2, 'Blood Testing', 1, '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est rem vero praesentium deserunt aspernatur incidunt autem eveniet. Placeat nemo libero tempora excepturi eveniet dolorem, explicabo sed possimus, odit neque ducimus.Lorem ipsum dolor sit amet,&nbsp;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est rem vero praesentium deserunt aspernatur incidunt autem eveniet. Placeat nemo libero tempora excepturi eveniet dolorem, explicabo sed possimus, odit neque ducimus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est rem vero praesentium deserunt aspernatur incidunt autem eveniet. Placeat nemo libero tempora excepturi eveniet dolorem, explicabo sed possimus, odit neque ducimus.&nbsp;</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est rem vero praesentium deserunt aspernatur incidunt autem eveniet. Placeat nemo libero tempora excepturi eveniet dolorem, explicabo sed possimus, odit neque ducimus.</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est rem vero praesentium deserunt aspernatur incidunt autem eveniet. Placeat nemo libero tempora excepturi eveniet dolorem, explicabo sed possimus, odit neque ducimus.</p>', 1, 'maco', '2017-09-25 22:02:56', '2017-09-25 22:31:42'),
(3, 'Urine Testing', 2, NULL, 1, 'maco', '2017-09-25 23:10:46', '2017-09-25 23:10:57'),
(4, 'Blood Testing', 2, NULL, 1, 'maco', '2017-09-25 23:10:52', '2017-09-25 23:11:03');

-- --------------------------------------------------------

--
-- Table structure for table `lab_request_files`
--

CREATE TABLE `lab_request_files` (
  `id` int(11) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `labreq_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `user` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lab_request_files`
--

INSERT INTO `lab_request_files` (`id`, `link`, `labreq_id`, `title`, `description`, `user`, `created_at`, `updated_at`) VALUES
(1, 'Result_of_Lab_Request_00002_Blood_Testing.pdf', 2, 'Result of Lab Request #00002: Blood Testing', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est rem vero praesentium deserunt aspernatur incidunt autem eveniet. Placeat nemo libero tempora excepturi eveniet dolorem, explicabo sed possimus, odit neque ducimus.&nbsp;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est rem vero praesentium deserunt aspernatur incidunt autem eveniet. Placeat nemo libero tempora excepturi eveniet dolorem, explicabo sed possimus, odit neque ducimus.&nbsp;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est rem vero praesentium deserunt aspernatur incidunt autem eveniet. Placeat nemo libero tempora excepturi eveniet dolorem, explicabo sed possimus, odit neque ducimus.</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est rem vero praesentium deserunt aspernatur incidunt autem eveniet. Placeat nemo libero tempora excepturi eveniet dolorem, explicabo sed possimus, odit neque ducimus.</p>', 'assist', '2017-09-25 22:04:37', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user` varchar(255) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `tag_id` varchar(225) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user`, `tag`, `tag_id`, `action`, `date_time`) VALUES
(1, 'assist', 'patient', '1', 'Patient Registered', '2017-09-25 13:59:59'),
(2, 'assist', 'case', '1', 'Case Added', '2017-09-25 13:59:59'),
(3, 'assist', 'patient', '1', 'Added New Case : `High Fever`', '2017-09-25 13:59:59'),
(4, 'maco', 'case', '1', 'Added New Prescription : ``', '2017-09-25 14:01:22'),
(5, 'maco', 'prescription', '1', 'Prescription Added', '2017-09-25 14:01:22'),
(6, 'maco', 'prescription', '1', 'Added an Item: Paracetamol Alvedon 500', '2017-09-25 14:01:35'),
(7, 'maco', 'prescription', '1', 'Updated Prescription Items', '2017-09-25 14:01:42'),
(8, 'maco', 'prescription', '1', 'Updated Prescription Items', '2017-09-25 14:01:45'),
(9, 'maco', 'prescription', '1', 'Updated Prescription Items', '2017-09-25 14:01:58'),
(10, 'maco', 'prescription', '1', 'Added an Item: Paracetamol Biogesic 500', '2017-09-25 14:02:17'),
(11, 'maco', 'prescription', '1', 'Updated Prescription Items', '2017-09-25 14:02:22'),
(12, 'maco', 'prescription', '1', 'Updated Prescription Items', '2017-09-25 14:02:28'),
(13, 'maco', 'case', '1', 'Requested a Laboratory Service : `#00006 -- Urine Testing - 1001-111-23`', '2017-09-25 14:02:48'),
(14, 'maco', 'laboratory', '1', 'Request Created', '2017-09-25 14:02:48'),
(15, 'maco', 'case', '1', 'Requested a Laboratory Service : `#00005 -- Blood Testing - 1001-101-13`', '2017-09-25 14:02:56'),
(16, 'maco', 'laboratory', '2', 'Request Created', '2017-09-25 14:02:56'),
(17, 'maco', 'case', '1', 'Requested an Immunization Service : `#00004 -- HEPA A  - asdasd4412`', '2017-09-25 14:03:52'),
(18, 'maco', 'immunization', '1', 'Request Created', '2017-09-25 14:03:52'),
(19, 'maco', 'case', '1', 'Requested an Immunization Service : `#00008 -- Anti Depressant  - asdasd4412`', '2017-09-25 14:03:55'),
(20, 'maco', 'immunization', '2', 'Request Created', '2017-09-25 14:03:55'),
(21, 'assist', 'laboratory', '2', 'Attached a Result : `Result of Lab Request #00002: Blood Testing`', '2017-09-25 14:04:37'),
(22, 'assist', 'laboratory', '2', 'Updated Description', '2017-09-25 14:04:47'),
(23, 'assist', 'laboratory', '2', 'Updated Description', '2017-09-25 14:05:19'),
(24, 'maco', 'billing', '1', 'Added Service - Blood Testing', '2017-09-25 14:31:42'),
(25, 'maco', 'laboratory', '2', 'Updated a Laboratory Request Status', '2017-09-25 14:31:42'),
(26, 'maco', 'case', '1', 'Updated a Laboratory Request Status #00002 - Blood Testing', '2017-09-25 14:31:42'),
(27, 'maco', 'case', '1', 'Issued Medical Certificate #00001', '2017-09-25 14:39:53'),
(28, 'maco', 'patient', '1', 'Issued Medical Certificate from CASE 00001 - High Fever', '2017-09-25 14:39:53'),
(29, 'assist', 'patient', '2', 'Patient Registered', '2017-09-25 15:10:09'),
(30, 'assist', 'case', '2', 'Case Added', '2017-09-25 15:10:09'),
(31, 'assist', 'patient', '2', 'Added New Case : `Vomitting`', '2017-09-25 15:10:09'),
(32, 'maco', 'case', '1', 'Updated the Case Status', '2017-09-25 15:10:36'),
(33, 'maco', 'case', '2', 'Requested a Laboratory Service : `#00006 -- Urine Testing - 1001-111-23`', '2017-09-25 15:10:46'),
(34, 'maco', 'laboratory', '3', 'Request Created', '2017-09-25 15:10:46'),
(35, 'maco', 'case', '2', 'Requested a Laboratory Service : `#00005 -- Blood Testing - 1001-101-13`', '2017-09-25 15:10:52'),
(36, 'maco', 'laboratory', '4', 'Request Created', '2017-09-25 15:10:52'),
(37, 'maco', 'billing', '2', 'Added Service - Urine Testing', '2017-09-25 15:10:57'),
(38, 'maco', 'laboratory', '3', 'Updated a Laboratory Request Status', '2017-09-25 15:10:57'),
(39, 'maco', 'case', '2', 'Updated a Laboratory Request Status #00003 - Urine Testing', '2017-09-25 15:10:57'),
(40, 'maco', 'billing', '2', 'Added Service - Blood Testing', '2017-09-25 15:11:03'),
(41, 'maco', 'laboratory', '4', 'Updated a Laboratory Request Status', '2017-09-25 15:11:03'),
(42, 'maco', 'case', '2', 'Updated a Laboratory Request Status #00004 - Blood Testing', '2017-09-25 15:11:03');

-- --------------------------------------------------------

--
-- Table structure for table `medical_cert`
--

CREATE TABLE `medical_cert` (
  `id` int(11) NOT NULL,
  `case_id` int(11) DEFAULT NULL,
  `doctor` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `remarks` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(255) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `medical_cert`
--

INSERT INTO `medical_cert` (`id`, `case_id`, `doctor`, `title`, `remarks`, `created_at`, `status`) VALUES
(1, 1, 'Maco Cortes', 'Typhoid Fever', '<ol><li>Sleep 8 Hours a Day</li><li>Take Meds as Prescribed&nbsp;</li></ol>', '2017-09-25 22:39:53', 0);

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `sex` int(11) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `fullname`, `middlename`, `lastname`, `sex`, `birthdate`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, 'Jomar', 'Lorem', 'Soriano', 1, '1994-04-22', '2017-09-25 13:59:59', '2017-09-25 21:59:59', 0),
(2, 'June', 'Rado', 'Demontaño', 1, '1993-05-25', '2017-09-25 15:10:09', '2017-09-25 23:10:09', 0);

-- --------------------------------------------------------

--
-- Table structure for table `patients_address`
--

CREATE TABLE `patients_address` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `tag` int(11) NOT NULL DEFAULT '1' COMMENT '0 = bplace; 1 = address',
  `building` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patients_address`
--

INSERT INTO `patients_address` (`id`, `patient_id`, `tag`, `building`, `street`, `barangay`, `city`, `province`, `zip`, `country`) VALUES
(1, 1, 0, 'RM 04, Juan Jose Bldg., Blck 4.', 'Campaner St.', 'Alano', 'General Santos', 'Davao del Sur', '7412', 'Philippines'),
(2, 1, 1, 'RM 04, Juan Jose Bldg., Blck 4.', 'Campaner St.', 'Alano', 'General Santos', 'Davao del Sur', '7412', 'Philippines'),
(3, 2, 0, 'Test', 'test', 'test', 'test', 'test', '7441', 'Philippines'),
(4, 2, 1, 'test', 'test', 'test', 'test', 'test', '7441', 'Philippines');

-- --------------------------------------------------------

--
-- Table structure for table `patients_contacts`
--

CREATE TABLE `patients_contacts` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `tag` int(11) NOT NULL COMMENT '0 = mobile; 1 = email',
  `details` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patients_contacts`
--

INSERT INTO `patients_contacts` (`id`, `patient_id`, `tag`, `details`) VALUES
(1, 1, 1, 'jomarsoriano@gmail.com'),
(2, 1, 0, '09095124563'),
(3, 2, 1, 'asd@asd.com'),
(4, 2, 0, '56456456');

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

CREATE TABLE `prescription` (
  `id` int(11) NOT NULL,
  `case_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `remarks` text,
  `created_by` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prescription`
--

INSERT INTO `prescription` (`id`, `case_id`, `title`, `description`, `remarks`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, '', '<p>Take the necessary meds on time. Up to <strong>Oct 31, 2017</strong></p>', NULL, 'maco', '2017-09-25 22:01:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `prescription_items`
--

CREATE TABLE `prescription_items` (
  `id` int(11) NOT NULL,
  `prescription_id` int(11) DEFAULT NULL,
  `item` varchar(255) DEFAULT NULL,
  `qty` double(10,0) DEFAULT NULL,
  `remark` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prescription_items`
--

INSERT INTO `prescription_items` (`id`, `prescription_id`, `item`, `qty`, `remark`) VALUES
(1, 1, 'Paracetamol Alvedon 500', 30, 'Thrice a day; every 8 hours'),
(2, 1, 'Paracetamol Biogesic 500', 10, 'Once a Day');

-- --------------------------------------------------------

--
-- Table structure for table `queues`
--

CREATE TABLE `queues` (
  `id` int(11) NOT NULL,
  `case_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '0' COMMENT '0 = pending; 1 = serving; ',
  `date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `department` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `queues`
--

INSERT INTO `queues` (`id`, `case_id`, `status`, `date_time`, `department`) VALUES
(2, 2, 1, '2017-09-25 23:10:09', 0);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `service_cat` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `service_cat`, `title`, `description`, `code`, `amount`, `is_deleted`) VALUES
(1, 'clinic', 'itemasdasdsa', '', '111010121-10', '10.00', 0),
(2, 'clinic', 'WTFSsssssss', 'NICEsss', '12121aaa', '600.00', 0),
(3, 'clinic', 'Coolersss', 'wow', '2112', '100.00', 0),
(4, 'immunization', 'HEPA A ', 'asdasdasd', 'asdasd4412', '101.00', 0),
(5, 'laboratory', 'Blood Testing', 'Lorem Ipsum Dolor', '1001-101-13', '100.00', 0),
(6, 'laboratory', 'Urine Testing', 'Nahh', '1001-111-23', '200.00', 0),
(7, 'immunization', 'Anti HEpa Immu\r\n', 'asdasdasd', 'asdasd4412', '101.00', 0),
(8, 'immunization', 'Anti Depressant \r\n', 'asdasdasd', 'asdasd4412', '2.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `services_cat`
--

CREATE TABLE `services_cat` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `services_cat`
--

INSERT INTO `services_cat` (`id`, `title`) VALUES
(3, 'clinic'),
(1, 'immunization'),
(2, 'laboratory');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `lic_no` varchar(255) NOT NULL,
  `usertype` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `name`, `lic_no`, `usertype`, `img`, `created_at`, `updated_at`) VALUES
('assist', '$2y$10$2AEbAB.lyP8rGh2InmJqxunxpRQDdtq1yVlmAzlq0Paq5lUHyO/vW', 'Prototype', '', 'Assistant', '', '2017-09-25 21:54:32', '2017-09-25 13:54:32'),
('maco', '$2y$10$eU26l3XWhzGhoo.lTfc93ubmrgxCFHptum4mn1rZWLf14/beyBrj2', 'Maco Cortes', '11212-145', 'Doctor', '4be6e3777d7ec3f425bfe66bb0c68647.jpg', '2017-09-21 12:56:12', '2017-09-21 04:56:12'),
('test', '$2y$10$fYvnXMjlg.XuGyzHpmY5LOkFgcfDiJ7TaLfb/DcCbXu6AJXbPmWbW', 'Testing Assistant', '', 'Assistant', 'eeb6cd52081de995740457192ca9a4db.jpg', '2017-08-07 20:45:30', '2017-08-07 12:45:30');

-- --------------------------------------------------------

--
-- Table structure for table `usertypes`
--

CREATE TABLE `usertypes` (
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `usertypes`
--

INSERT INTO `usertypes` (`title`) VALUES
('Assistant'),
('Doctor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `BillingCase` (`case_id`) USING BTREE,
  ADD KEY `FKBillingUser` (`user`);

--
-- Indexes for table `billing_items`
--
ALTER TABLE `billing_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKBillItemBillingID` (`billing_id`),
  ADD KEY `FKBillItemsService` (`service`);

--
-- Indexes for table `billing_payments`
--
ALTER TABLE `billing_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKPaymentBillingID` (`billing_id`),
  ADD KEY `FKPaymentUser` (`user`);

--
-- Indexes for table `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `title` (`title`),
  ADD KEY `FKCasePatient` (`patient_id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`) USING BTREE;

--
-- Indexes for table `immunizations`
--
ALTER TABLE `immunizations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKImmService` (`service`),
  ADD KEY `FKImmCase` (`case_id`),
  ADD KEY `FKImmUser` (`user`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`title`);

--
-- Indexes for table `lab_request`
--
ALTER TABLE `lab_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKLabreqCase` (`case_id`),
  ADD KEY `FKLabreqUser` (`user`),
  ADD KEY `FKLabreqService` (`service`);

--
-- Indexes for table `lab_request_files`
--
ALTER TABLE `lab_request_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKlabreqFiles` (`labreq_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medical_cert`
--
ALTER TABLE `medical_cert`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKmedcertDoc` (`doctor`),
  ADD KEY `FKmedcertCase` (`case_id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKNoteUser` (`user`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients_address`
--
ALTER TABLE `patients_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients_contacts`
--
ALTER TABLE `patients_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prescription`
--
ALTER TABLE `prescription`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKCasePrescription` (`case_id`);

--
-- Indexes for table `prescription_items`
--
ALTER TABLE `prescription_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKPrescription` (`prescription_id`),
  ADD KEY `FKItems` (`item`);

--
-- Indexes for table `queues`
--
ALTER TABLE `queues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKCaseQueue` (`case_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKServicesCat` (`service_cat`),
  ADD KEY `title` (`title`);

--
-- Indexes for table `services_cat`
--
ALTER TABLE `services_cat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `title` (`title`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD KEY `FKUsertype` (`usertype`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `usertypes`
--
ALTER TABLE `usertypes`
  ADD PRIMARY KEY (`title`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `billing`
--
ALTER TABLE `billing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `billing_items`
--
ALTER TABLE `billing_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `billing_payments`
--
ALTER TABLE `billing_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `cases`
--
ALTER TABLE `cases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `immunizations`
--
ALTER TABLE `immunizations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `lab_request`
--
ALTER TABLE `lab_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `lab_request_files`
--
ALTER TABLE `lab_request_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `medical_cert`
--
ALTER TABLE `medical_cert`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `patients_address`
--
ALTER TABLE `patients_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `patients_contacts`
--
ALTER TABLE `patients_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `prescription`
--
ALTER TABLE `prescription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `prescription_items`
--
ALTER TABLE `prescription_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `queues`
--
ALTER TABLE `queues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `services_cat`
--
ALTER TABLE `services_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `billing`
--
ALTER TABLE `billing`
  ADD CONSTRAINT `FKBillingCase` FOREIGN KEY (`case_id`) REFERENCES `cases` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FKBillingUser` FOREIGN KEY (`user`) REFERENCES `users` (`username`) ON UPDATE CASCADE;

--
-- Constraints for table `billing_items`
--
ALTER TABLE `billing_items`
  ADD CONSTRAINT `FKBillItemBillingID` FOREIGN KEY (`billing_id`) REFERENCES `billing` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FKBillItemsService` FOREIGN KEY (`service`) REFERENCES `services` (`title`) ON UPDATE CASCADE;

--
-- Constraints for table `billing_payments`
--
ALTER TABLE `billing_payments`
  ADD CONSTRAINT `FKPaymentBillingID` FOREIGN KEY (`billing_id`) REFERENCES `billing` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FKPaymentUser` FOREIGN KEY (`user`) REFERENCES `users` (`username`) ON UPDATE CASCADE;

--
-- Constraints for table `cases`
--
ALTER TABLE `cases`
  ADD CONSTRAINT `FKCasePatient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`);

--
-- Constraints for table `immunizations`
--
ALTER TABLE `immunizations`
  ADD CONSTRAINT `FKImmCase` FOREIGN KEY (`case_id`) REFERENCES `cases` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FKImmService` FOREIGN KEY (`service`) REFERENCES `services` (`title`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FKImmUser` FOREIGN KEY (`user`) REFERENCES `users` (`username`) ON UPDATE CASCADE;

--
-- Constraints for table `lab_request`
--
ALTER TABLE `lab_request`
  ADD CONSTRAINT `FKLabreqCase` FOREIGN KEY (`case_id`) REFERENCES `cases` (`id`),
  ADD CONSTRAINT `FKLabreqService` FOREIGN KEY (`service`) REFERENCES `services` (`title`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FKLabreqUser` FOREIGN KEY (`user`) REFERENCES `users` (`username`) ON UPDATE CASCADE;

--
-- Constraints for table `lab_request_files`
--
ALTER TABLE `lab_request_files`
  ADD CONSTRAINT `FKlabreqFiles` FOREIGN KEY (`labreq_id`) REFERENCES `lab_request` (`id`);

--
-- Constraints for table `medical_cert`
--
ALTER TABLE `medical_cert`
  ADD CONSTRAINT `FKmedcertCase` FOREIGN KEY (`case_id`) REFERENCES `cases` (`id`),
  ADD CONSTRAINT `FKmedcertDoc` FOREIGN KEY (`doctor`) REFERENCES `users` (`name`) ON UPDATE CASCADE;

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `FKNoteUser` FOREIGN KEY (`user`) REFERENCES `users` (`username`) ON UPDATE CASCADE;

--
-- Constraints for table `prescription`
--
ALTER TABLE `prescription`
  ADD CONSTRAINT `FKCasePrescription` FOREIGN KEY (`case_id`) REFERENCES `cases` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prescription_items`
--
ALTER TABLE `prescription_items`
  ADD CONSTRAINT `FKPrescription` FOREIGN KEY (`prescription_id`) REFERENCES `prescription` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `queues`
--
ALTER TABLE `queues`
  ADD CONSTRAINT `FKCaseQueue` FOREIGN KEY (`case_id`) REFERENCES `cases` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `FKServicesCat` FOREIGN KEY (`service_cat`) REFERENCES `services_cat` (`title`) ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FKUsertype` FOREIGN KEY (`usertype`) REFERENCES `usertypes` (`title`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
