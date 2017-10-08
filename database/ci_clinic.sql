-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2017 at 07:32 PM
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `billing_items`
--

CREATE TABLE `billing_items` (
  `id` int(11) NOT NULL,
  `billing_id` int(11) DEFAULT NULL,
  `service` varchar(255) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `is_clinic` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `billing_payments`
--

CREATE TABLE `billing_payments` (
  `id` int(11) NOT NULL,
  `billing_id` int(11) DEFAULT NULL,
  `payee` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `balance` decimal(10,2) NOT NULL,
  `remarks` text,
  `user` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

CREATE TABLE `cases` (
  `id` int(11) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `weight` double DEFAULT NULL,
  `height` double DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

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

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `lab_report_values`
--

CREATE TABLE `lab_report_values` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `labreq_id` int(11) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pathologist` varchar(255) DEFAULT NULL,
  `medtech` varchar(255) DEFAULT NULL,
  `report_no` varchar(255) DEFAULT NULL,
  `specimen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `patients_contacts`
--

CREATE TABLE `patients_contacts` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `tag` int(11) NOT NULL COMMENT '0 = mobile; 1 = email',
  `details` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

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
  `is_deleted` int(11) DEFAULT '0',
  `is_constant` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `service_cat`, `title`, `description`, `code`, `amount`, `is_deleted`, `is_constant`) VALUES
(1, 'laboratory', 'Blood Chemistry', '', '', '100.00', 0, 1),
(2, 'laboratory', 'Hematology', '', '', '600.00', 0, 1),
(3, 'laboratory', 'Urinalysis', '', '', '100.00', 0, 1),
(4, 'laboratory', 'Hepatitis / WIDAL / VDRL', '', '', '100.00', 0, NULL),
(5, 'laboratory', 'Blood Testing', 'Lorem Ipsum Dolor', '1001-101-13', '100.00', 0, NULL),
(6, 'laboratory', 'Urine Testing', 'Nahh', '1001-111-23', '200.00', 0, NULL),
(7, 'immunization', 'Anti HEpa Immu\r\n', 'asdasdasd', 'asdasd4412', '101.00', 0, NULL),
(8, 'immunization', 'Anti Depressant \r\n', 'asdasdasd', 'asdasd4412', '2.00', 0, NULL),
(9, 'clinic', 'Doctor\'s Fee', '', '111-22', '500.00', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `services_cat`
--

CREATE TABLE `services_cat` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `services_cat`
--

INSERT INTO `services_cat` (`id`, `title`) VALUES
(3, 'clinic'),
(1, 'immunization'),
(2, 'laboratory');

-- --------------------------------------------------------

--
-- Table structure for table `service_examinations`
--

CREATE TABLE `service_examinations` (
  `id` int(11) NOT NULL,
  `service` varchar(255) NOT NULL,
  `service_exam_cat` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `normal_values` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service_examinations`
--

INSERT INTO `service_examinations` (`id`, `service`, `service_exam_cat`, `title`, `normal_values`) VALUES
(1, 'Blood Chemistry', NULL, 'Fasting Blood Sugar', '75-115 mg/dl'),
(3, 'Blood Chemistry', NULL, 'Blood Urea Nitrogen', '10-50 mg/dl'),
(4, 'Blood Chemistry', NULL, 'Cholesterol', '150-250 mg/dl'),
(5, 'Blood Chemistry', NULL, 'Creatinine', 'Male: 0.7-1.2 mg/dl <br/>\r\nFemale: 0.5-1.0 mg/dl'),
(6, 'Blood Chemistry', NULL, 'Triglycerides', 'up to 170 mg/dl'),
(7, 'Blood Chemistry', NULL, 'Blood Uric Acid', 'Male: 3.4-7.0 mg/dl <br/>\r\nFemale: 2.4-5.7 mg/dl'),
(8, 'Blood Chemistry', NULL, 'Biliburin', 'Total up to 1.0 mg/dl'),
(9, 'Blood Chemistry', NULL, 'Total Protein', NULL),
(10, 'Blood Chemistry', NULL, 'Albumin', NULL),
(11, 'Blood Chemistry', NULL, 'Globulin', NULL),
(12, 'Blood Chemistry', NULL, 'Albulin / Globulin Ratio', NULL),
(13, 'Blood Chemistry', NULL, 'Amylase 22-100 u/l', NULL),
(14, 'Blood Chemistry', NULL, 'SGOT', '0-40 u/l'),
(15, 'Blood Chemistry', NULL, 'SGPT', '0-40 u/l'),
(16, 'Blood Chemistry', NULL, 'CPK', ''),
(18, 'Blood Chemistry', NULL, 'LDL', '0-100 mg/dl'),
(19, 'Blood Chemistry', NULL, 'HDL', '0-35 mg/dl'),
(20, 'Blood Chemistry', NULL, 'HGT', '70-170 mg/dl'),
(21, 'Blood Chemistry', NULL, 'Phosphates', ''),
(22, 'Blood Chemistry', NULL, 'Acid', ''),
(23, 'Blood Chemistry', NULL, 'Alkaline', NULL),
(24, 'Blood Chemistry', NULL, 'Prothrombin', NULL),
(28, 'Hematology', NULL, 'Erythrocyte Count', '4.5 -5.5 x 10.12/L'),
(29, 'Hematology', NULL, 'Leucocyte Count', '5-10 x 10.9/l'),
(30, 'Hematology', NULL, 'Erythrocyte Volume', 'Male: 0.40-0.50'),
(31, 'Hematology', NULL, 'Fraction (Hematocrit)', 'Female: 0.37-0.43'),
(32, 'Hematology', NULL, 'Hemoglobin MassConc.', 'Male: 140-170 g/l <br/>Female: 120-140 g/l'),
(33, 'Hematology', NULL, 'Leucocyte No. Fraction', NULL),
(34, 'Hematology', NULL, 'Segmenters', '0.55-0.65'),
(35, 'Hematology', NULL, 'Lymphocytes', '0.25-0.35'),
(36, 'Hematology', NULL, 'Eosinophils', '0.02-0.94'),
(37, 'Hematology', NULL, 'Stabs', '0.02-0.06'),
(38, 'Hematology', NULL, 'Monocytes', '0.03-0.6'),
(39, 'Hematology', NULL, 'Thromobocytes', '150-350 x 10.9l'),
(40, 'Hematology', NULL, 'Platelet Count', NULL),
(41, 'Hematology', NULL, 'Reticulocycles No. Conc', NULL),
(42, 'Hematology', NULL, 'Clotting Time', '2-6 minutes'),
(43, 'Hematology', NULL, 'Bleeding Time', '1-6 minutes'),
(44, 'Hematology', NULL, 'Erythocyle', 'Male: 0-9 mm/hr'),
(45, 'Hematology', NULL, 'Sedimentation Rate', 'Female: 0-20mm/hr'),
(46, 'Hematology', NULL, 'Blood Typing', ''),
(47, 'Hematology', NULL, 'Malarial Smear', ''),
(48, 'Hematology', NULL, 'LE Cells', NULL),
(49, 'Hematology', NULL, 'Others', NULL),
(50, 'Urinalysis', NULL, 'Color', ''),
(51, 'Urinalysis', NULL, 'Transparency', ''),
(52, 'Urinalysis', NULL, 'Specific Gravity', ''),
(53, 'Urinalysis', NULL, 'Ph', NULL),
(54, 'Urinalysis', NULL, 'Protein', ''),
(55, 'Urinalysis', NULL, 'Sugar', ''),
(56, 'Urinalysis', 'Microscopic Cells', 'Pus Cells', ''),
(57, 'Urinalysis', 'Microscopic Cells', 'RBC', ''),
(58, 'Urinalysis', 'Microscopic Cells', 'Epithelial Cells', ''),
(59, 'Urinalysis', 'Crystal', 'Amorphous Urates', ''),
(60, 'Urinalysis', 'Crystal', 'Uric Acid', NULL),
(61, 'Urinalysis', 'Crystal', 'Mucus Threads', NULL),
(62, 'Urinalysis', 'Crystal', 'Amorphous Phosphate', ''),
(63, 'Urinalysis', 'Casts', 'Hyaline Cast', ''),
(64, 'Urinalysis', 'Casts', 'RBC Cast', ''),
(65, 'Urinalysis', 'Casts', 'WBC Cast', ''),
(66, 'Urinalysis', 'Casts', 'Fine Granular Cast', ''),
(67, 'Urinalysis', 'Casts', 'Coarse Granular Cast', ''),
(68, 'Urinalysis', 'Others\r\n', 'Pregnancy Test', NULL),
(70, 'Urinalysis', 'Others\r\n', 'Bacteria', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_exam_cat`
--

CREATE TABLE `service_exam_cat` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `service` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service_exam_cat`
--

INSERT INTO `service_exam_cat` (`id`, `title`, `service`) VALUES
(1, 'Microscopic Cells', 'Urinalysis'),
(2, 'Crystal', 'Urinalysis'),
(3, 'Casts', 'Urinalysis'),
(5, 'Others\r\n', 'Urinalysis');

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
('maco', '$2y$10$eU26l3XWhzGhoo.lTfc93ubmrgxCFHptum4mn1rZWLf14/beyBrj2', 'Administrator', '11212-145', 'Doctor', '4be6e3777d7ec3f425bfe66bb0c68647.jpg', '2017-10-09 01:30:11', '2017-10-08 17:30:11');

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
  ADD KEY `FKBillingUser` (`user`) USING BTREE;

--
-- Indexes for table `billing_items`
--
ALTER TABLE `billing_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKBillItemBillingID` (`billing_id`) USING BTREE,
  ADD KEY `FKBillItemsService` (`service`) USING BTREE;

--
-- Indexes for table `billing_payments`
--
ALTER TABLE `billing_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKPaymentBillingID` (`billing_id`) USING BTREE,
  ADD KEY `FKPaymentUser` (`user`) USING BTREE;

--
-- Indexes for table `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `title` (`title`) USING BTREE,
  ADD KEY `FKCasePatient` (`patient_id`) USING BTREE;

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
  ADD KEY `FKImmService` (`service`) USING BTREE,
  ADD KEY `FKImmCase` (`case_id`) USING BTREE,
  ADD KEY `FKImmUser` (`user`) USING BTREE;

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`title`);

--
-- Indexes for table `lab_report_values`
--
ALTER TABLE `lab_report_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKLabExam` (`exam_id`),
  ADD KEY `FKLabReport` (`labreq_id`);

--
-- Indexes for table `lab_request`
--
ALTER TABLE `lab_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKLabreqCase` (`case_id`) USING BTREE,
  ADD KEY `FKLabreqUser` (`user`) USING BTREE,
  ADD KEY `FKLabreqService` (`service`) USING BTREE;

--
-- Indexes for table `lab_request_files`
--
ALTER TABLE `lab_request_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKlabreqFiles` (`labreq_id`) USING BTREE;

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKUserlogs` (`user`);

--
-- Indexes for table `medical_cert`
--
ALTER TABLE `medical_cert`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKmedcertDoc` (`doctor`) USING BTREE,
  ADD KEY `FKmedcertCase` (`case_id`) USING BTREE;

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKNoteUser` (`user`) USING BTREE;

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients_address`
--
ALTER TABLE `patients_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKPatientAddress` (`patient_id`);

--
-- Indexes for table `patients_contacts`
--
ALTER TABLE `patients_contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKPatientContacts` (`patient_id`) USING BTREE;

--
-- Indexes for table `prescription`
--
ALTER TABLE `prescription`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKCasePrescription` (`case_id`) USING BTREE;

--
-- Indexes for table `prescription_items`
--
ALTER TABLE `prescription_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKPrescription` (`prescription_id`) USING BTREE,
  ADD KEY `FKItems` (`item`) USING BTREE;

--
-- Indexes for table `queues`
--
ALTER TABLE `queues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKCaseQueue` (`case_id`) USING BTREE;

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKServicesCat` (`service_cat`) USING BTREE,
  ADD KEY `title` (`title`) USING BTREE;

--
-- Indexes for table `services_cat`
--
ALTER TABLE `services_cat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `title` (`title`) USING BTREE;

--
-- Indexes for table `service_examinations`
--
ALTER TABLE `service_examinations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKExamService` (`service`),
  ADD KEY `FKExamCat` (`service_exam_cat`);

--
-- Indexes for table `service_exam_cat`
--
ALTER TABLE `service_exam_cat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKExamServiceCat` (`service`),
  ADD KEY `title` (`title`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD KEY `FKUsertype` (`usertype`) USING BTREE,
  ADD KEY `name` (`name`) USING BTREE;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `billing_items`
--
ALTER TABLE `billing_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `billing_payments`
--
ALTER TABLE `billing_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cases`
--
ALTER TABLE `cases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `immunizations`
--
ALTER TABLE `immunizations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lab_report_values`
--
ALTER TABLE `lab_report_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lab_request`
--
ALTER TABLE `lab_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lab_request_files`
--
ALTER TABLE `lab_request_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `medical_cert`
--
ALTER TABLE `medical_cert`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `patients_address`
--
ALTER TABLE `patients_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `patients_contacts`
--
ALTER TABLE `patients_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `prescription`
--
ALTER TABLE `prescription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `prescription_items`
--
ALTER TABLE `prescription_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `queues`
--
ALTER TABLE `queues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `services_cat`
--
ALTER TABLE `services_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `service_examinations`
--
ALTER TABLE `service_examinations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
--
-- AUTO_INCREMENT for table `service_exam_cat`
--
ALTER TABLE `service_exam_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
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
-- Constraints for table `lab_report_values`
--
ALTER TABLE `lab_report_values`
  ADD CONSTRAINT `FKLabExam` FOREIGN KEY (`exam_id`) REFERENCES `service_examinations` (`id`),
  ADD CONSTRAINT `FKLabReport` FOREIGN KEY (`labreq_id`) REFERENCES `lab_request` (`id`);

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
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `FKUserlogs` FOREIGN KEY (`user`) REFERENCES `users` (`username`);

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
-- Constraints for table `patients_address`
--
ALTER TABLE `patients_address`
  ADD CONSTRAINT `FKPatientAddress` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`);

--
-- Constraints for table `patients_contacts`
--
ALTER TABLE `patients_contacts`
  ADD CONSTRAINT `FKPatientContacts` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`);

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
-- Constraints for table `service_examinations`
--
ALTER TABLE `service_examinations`
  ADD CONSTRAINT `FKExamCat` FOREIGN KEY (`service_exam_cat`) REFERENCES `service_exam_cat` (`title`),
  ADD CONSTRAINT `FKExamService` FOREIGN KEY (`service`) REFERENCES `services` (`title`) ON UPDATE CASCADE;

--
-- Constraints for table `service_exam_cat`
--
ALTER TABLE `service_exam_cat`
  ADD CONSTRAINT `FKExamServiceCat` FOREIGN KEY (`service`) REFERENCES `services` (`title`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FKUsertype` FOREIGN KEY (`usertype`) REFERENCES `usertypes` (`title`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
