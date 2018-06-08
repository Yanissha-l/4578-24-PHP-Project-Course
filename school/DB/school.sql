-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2018 at 02:38 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

CREATE TABLE `administrators` (
  `name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`name`, `role`, `phone`, `email`, `password`, `id`, `updated_at`, `created_at`, `image`) VALUES
('yanis', 'owner', '052-656-7897', 'yanis@gmail.com', '$2y$10$VD0oXQ.Qm5x6ac9YsNPnOus6zlJ/lit7bc80TAkhfgsX.sRfr/54G', 13, '2018-05-14 21:06:19', '2018-05-13 07:29:12', '635ddd6f60ec4836.jpg'),
('sale', 'sale', '052', 'sale@gmail.com', '$2y$10$zxJvlpGRhedPa7YD4kk84e4ppLy3guQ1fliG2wnOCcjaarcRZFapm', 14, '2018-05-13 07:30:28', '2018-05-13 07:30:28', 'c09052549806b6f2.jpg'),
('manager', 'manager', '052', 'manager@gmail.com', '$2y$10$nCW5r7nvOORB1Or0hL15Xe9DisDL6JZeLyCzCUNXR.54iofGrjplm', 15, '2018-05-13 07:31:21', '2018-05-13 07:31:21', '480341a25ebeb7f2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`name`, `description`, `image`, `id`, `updated_at`, `created_at`) VALUES
('JS', 'JavaScript course', '02a734a18ea810cb.png', 10, '2018-05-15 22:38:21', '2018-05-13 09:17:06'),
('PHP', 'PHP Course', 'fadb98cdfbd25045.jpg', 11, '2018-05-13 09:19:09', '2018-05-13 09:19:09');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`name`, `phone`, `email`, `image`, `id`, `created_at`, `updated_at`) VALUES
('Lev landau', '03-456-4584', 'lev@gmail.com', 'ad4b0d96f827a8b9.jpg', 1002, '2018-05-13 09:57:48', '2018-05-15 20:36:01'),
('Albert Einstein', '052', 'albert@gmail.com', 'd5039a11dc2e09fa.jpg', 1003, '2018-05-13 09:58:52', '2018-05-13 09:58:52'),
('Isaac Newton', '052', 'isaac@gmail.com', '80763ce0c1b4d12f.jpg', 1004, '2018-05-13 09:59:24', '2018-05-13 09:59:24');

-- --------------------------------------------------------

--
-- Table structure for table `study`
--

CREATE TABLE `study` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `study`
--

INSERT INTO `study` (`id`, `student_id`, `course_id`, `created_at`, `updated_at`) VALUES
(56, 1003, 11, '2018-05-13 09:59:52', '2018-05-13 09:59:52'),
(57, 1004, 11, '2018-05-13 10:00:00', '2018-05-13 10:00:00'),
(59, 1003, 10, '2018-05-14 17:16:39', '2018-05-14 17:16:39'),
(60, 1002, 10, '2018-05-14 19:23:34', '2018-05-14 19:23:34'),
(63, 1002, 11, '2018-05-15 21:35:27', '2018-05-15 21:35:27');

-- --------------------------------------------------------

--
-- Stand-in structure for view `study_plan`
-- (See below for the actual view)
--
CREATE TABLE `study_plan` (
`id` int(11)
,`student_id` int(11)
,`student_name` varchar(255)
,`course_id` int(11)
,`course_name` varchar(255)
);

-- --------------------------------------------------------

--
-- Structure for view `study_plan`
--
DROP TABLE IF EXISTS `study_plan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `study_plan`  AS  select `stu`.`id` AS `id`,`st`.`id` AS `student_id`,`st`.`name` AS `student_name`,`cr`.`id` AS `course_id`,`cr`.`name` AS `course_name` from ((`study` `stu` join `students` `st` on((`stu`.`student_id` = `st`.`id`))) join `course` `cr` on((`stu`.`course_id` = `cr`.`id`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `study`
--
ALTER TABLE `study`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrators`
--
ALTER TABLE `administrators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1005;

--
-- AUTO_INCREMENT for table `study`
--
ALTER TABLE `study`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
