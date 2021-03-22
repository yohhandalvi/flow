-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2020 at 01:42 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flow`
--
CREATE DATABASE IF NOT EXISTS `flow` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `flow`;

-- --------------------------------------------------------

--
-- Table structure for table `flows`
--

DROP TABLE IF EXISTS `flows`;
CREATE TABLE IF NOT EXISTS `flows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization_id` int(11) NOT NULL,
  `hash` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `summary` longtext DEFAULT NULL,
  `flow_type_id` int(11) NOT NULL,
  `flow_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT 0,
  `deleted` tinyint(4) NOT NULL DEFAULT 0,
  `created_by_user_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `flows`
--

INSERT INTO `flows` (`id`, `organization_id`, `hash`, `name`, `summary`, `flow_type_id`, `flow_date`, `start_time`, `end_time`, `inactive`, `deleted`, `created_by_user_id`, `created_on`, `updated_on`) VALUES
(1, 1, 'fdsgdgfd', 'Test', '<p>fdsdfsf</p>', 2, NULL, NULL, NULL, 0, 1, 1, '2020-05-07 11:29:44', '2020-05-11 13:01:31'),
(2, 1, 'bcvbcgfd', 'Quiz ABC', '<p>fsdfsd</p>', 1, NULL, '00:00:00', '00:00:00', 0, 0, 0, '2020-05-07 12:13:19', '2020-05-11 15:14:43'),
(3, 1, 'tkx9ipwyec87dgfn', 'Test', '<p>dfsfsfs</p><p>fd</p><p>f</p><p>s</p><p>dgbg</p><p>h</p><p>d</p><p>fhfg</p>', 2, '0000-00-00', '00:00:00', '00:00:00', 0, 0, 0, '2020-05-11 13:34:03', '2020-05-11 13:34:16');

-- --------------------------------------------------------

--
-- Table structure for table `flow_options`
--

DROP TABLE IF EXISTS `flow_options`;
CREATE TABLE IF NOT EXISTS `flow_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flow_question_id` int(11) NOT NULL,
  `type` enum('text','image') NOT NULL DEFAULT 'text',
  `answer` text NOT NULL,
  `right_answer` tinyint(4) NOT NULL DEFAULT 0,
  `inactive` tinyint(4) NOT NULL DEFAULT 0,
  `deleted` tinyint(4) NOT NULL DEFAULT 0,
  `created_by_user_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `flow_options`
--

INSERT INTO `flow_options` (`id`, `flow_question_id`, `type`, `answer`, `right_answer`, `inactive`, `deleted`, `created_by_user_id`, `created_on`, `updated_on`) VALUES
(1, 1, 'text', 'fdsfs', 0, 0, 0, 0, '2020-05-11 13:33:36', NULL),
(2, 1, 'text', 'gdfgd', 0, 0, 0, 0, '2020-05-11 13:33:36', NULL),
(3, 1, 'text', 'gdfgdf', 1, 0, 0, 0, '2020-05-11 13:33:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `flow_questions`
--

DROP TABLE IF EXISTS `flow_questions`;
CREATE TABLE IF NOT EXISTS `flow_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flow_step_id` int(11) NOT NULL,
  `type` enum('text','image') DEFAULT 'text',
  `question` text DEFAULT NULL,
  `has_options` tinyint(4) NOT NULL DEFAULT 0,
  `inactive` tinyint(4) NOT NULL DEFAULT 0,
  `deleted` tinyint(4) NOT NULL DEFAULT 0,
  `created_by_user_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `flow_questions`
--

INSERT INTO `flow_questions` (`id`, `flow_step_id`, `type`, `question`, `has_options`, `inactive`, `deleted`, `created_by_user_id`, `created_on`, `updated_on`) VALUES
(1, 1, 'text', 'fdsfs 123', 1, 0, 0, 0, '2020-05-11 13:20:54', '2020-05-11 13:33:36');

-- --------------------------------------------------------

--
-- Table structure for table `flow_steps`
--

DROP TABLE IF EXISTS `flow_steps`;
CREATE TABLE IF NOT EXISTS `flow_steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flow_id` int(11) NOT NULL,
  `step` varchar(255) DEFAULT NULL,
  `position` int(11) NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT 0,
  `deleted` tinyint(4) DEFAULT 0,
  `created_by_user_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `flow_steps`
--

INSERT INTO `flow_steps` (`id`, `flow_id`, `step`, `position`, `inactive`, `deleted`, `created_by_user_id`, `created_on`, `updated_on`) VALUES
(1, 2, 'Test 1', 1, 0, 0, 0, '2020-05-07 13:47:30', '2020-05-11 15:28:57'),
(2, 2, 'Test 2', 2, 0, 0, 0, '2020-05-07 13:48:31', '2020-05-11 15:28:59');

-- --------------------------------------------------------

--
-- Table structure for table `flow_types`
--

DROP TABLE IF EXISTS `flow_types`;
CREATE TABLE IF NOT EXISTS `flow_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `flow_types`
--

INSERT INTO `flow_types` (`id`, `type`) VALUES
(1, 'Quiz'),
(2, 'Survey');

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

DROP TABLE IF EXISTS `organizations`;
CREATE TABLE IF NOT EXISTS `organizations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `domain` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `organization_type_id` int(11) NOT NULL,
  `organization_size_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `name`, `domain`, `logo`, `organization_type_id`, `organization_size_id`, `created_on`, `updated_on`) VALUES
(1, 'The Lazy Baboons', 'thelazybaboons', NULL, 0, 0, '2020-05-05 13:32:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `organization_sizes`
--

DROP TABLE IF EXISTS `organization_sizes`;
CREATE TABLE IF NOT EXISTS `organization_sizes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `size` varchar(255) NOT NULL,
  `order_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `organization_sizes`
--

INSERT INTO `organization_sizes` (`id`, `size`, `order_id`, `created_on`, `updated_on`) VALUES
(1, '1-10', 1, '2018-05-06 15:24:20', NULL),
(2, '11-50', 2, '2018-05-06 15:24:20', NULL),
(3, '51-100', 3, '2018-05-06 15:24:32', NULL),
(4, '101-250', 4, '2018-05-06 15:24:32', NULL),
(5, '251-500', 5, '2018-05-06 15:24:45', NULL),
(6, '501-1000', 6, '2018-05-06 15:24:45', NULL),
(7, '1001-5000', 7, '2018-05-06 15:24:57', NULL),
(8, '5001 or more', 8, '2018-05-06 15:24:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `organization_types`
--

DROP TABLE IF EXISTS `organization_types`;
CREATE TABLE IF NOT EXISTS `organization_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `order_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `organization_types`
--

INSERT INTO `organization_types` (`id`, `title`, `order_id`, `created_on`, `updated_on`) VALUES
(1, 'Agency', 1, '2018-05-06 15:20:42', NULL),
(2, 'Healthcare / Pharmaceutical', 2, '2018-05-06 15:20:42', NULL),
(3, 'Conference', 3, '2018-05-06 15:20:52', NULL),
(4, 'Technology', 4, '2018-05-06 15:20:52', NULL),
(5, 'Non-profit', 5, '2018-05-06 15:21:13', NULL),
(6, 'Government', 6, '2018-05-06 15:21:13', NULL),
(7, 'Other', 7, '2018-05-06 15:21:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  `order_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `order_id`, `created_on`, `updated_on`) VALUES
(1, 'Administrative', 1, '2018-05-06 15:26:43', NULL),
(2, 'Accounting', 2, '2018-05-06 15:26:43', NULL),
(3, 'Business Development', 3, '2018-05-06 15:26:53', NULL),
(4, 'Business Owner', 4, '2018-05-06 15:26:53', NULL),
(5, 'Customer Support', 5, '2018-05-06 15:27:07', NULL),
(6, 'Business Intelligence', 6, '2018-05-06 15:27:07', NULL),
(7, 'Design', 7, '2018-05-06 15:27:19', NULL),
(8, 'Engineering (Software)', 8, '2018-05-06 15:27:19', NULL),
(9, 'Marketing', 9, '2018-05-06 15:27:32', NULL),
(10, 'Media', 10, '2018-05-06 15:27:32', NULL),
(11, 'Operations', 11, '2018-05-06 15:27:43', NULL),
(12, 'Product Management', 12, '2018-05-06 15:27:43', NULL),
(13, 'Project Management', 13, '2018-05-06 15:27:57', NULL),
(14, 'Research', 14, '2018-05-06 15:27:57', NULL),
(15, 'Sales', 15, '2018-05-06 15:28:14', NULL),
(16, 'Other', 16, '2018-05-06 15:28:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

DROP TABLE IF EXISTS `submissions`;
CREATE TABLE IF NOT EXISTS `submissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flow_id` int(11) NOT NULL,
  `hash` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `completed` tinyint(4) NOT NULL DEFAULT 0,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (`id`, `flow_id`, `hash`, `name`, `email`, `start_time`, `end_time`, `completed`, `created_on`, `updated_on`) VALUES
(1, 2, NULL, 'Test', 'dfsfsd@dsda.com', '12:17:25', NULL, 0, '2020-05-11 15:47:25', NULL),
(2, 2, NULL, 'fdsfs', 'fdsfs@dsada.com', '12:20:25', NULL, 0, '2020-05-11 15:50:25', NULL),
(3, 2, NULL, 'fsdfs', 'vbc@dsada.com', '12:21:01', NULL, 0, '2020-05-11 15:51:01', NULL),
(4, 2, NULL, 'fsdfs', 'vbc@dsada.com', '12:21:53', NULL, 0, '2020-05-11 15:51:53', NULL),
(5, 2, NULL, 'fsdfs', 'vbc@dsada.com', '12:22:12', '12:35:54', 1, '2020-05-11 15:52:12', '2020-05-11 16:05:54'),
(6, 2, 'gx7dkpuwojbii3xs', 'gfdgfd', 'dsvxcv@dasda.com', '12:43:11', '12:43:14', 1, '2020-05-11 16:13:11', '2020-05-11 16:13:14');

-- --------------------------------------------------------

--
-- Table structure for table `submission_answers`
--

DROP TABLE IF EXISTS `submission_answers`;
CREATE TABLE IF NOT EXISTS `submission_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `submission_id` int(11) NOT NULL DEFAULT 0,
  `flow_question_id` int(11) NOT NULL,
  `answer` text DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `submission_answers`
--

INSERT INTO `submission_answers` (`id`, `submission_id`, `flow_question_id`, `answer`, `created_on`, `updated_on`) VALUES
(1, 2, 1, '2', '2020-05-11 16:05:06', NULL),
(2, 2, 1, '1', '2020-05-11 16:05:54', NULL),
(3, 6, 1, '3', '2020-05-11 16:13:14', '2020-05-11 16:19:41');

-- --------------------------------------------------------

--
-- Table structure for table `temp_users`
--

DROP TABLE IF EXISTS `temp_users`;
CREATE TABLE IF NOT EXISTS `temp_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `confirmation_code` int(11) DEFAULT NULL,
  `completion_percentage` float NOT NULL DEFAULT 0,
  `data` text DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization_id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `superadmin` tinyint(4) NOT NULL DEFAULT 0,
  `forgot_password_key` varchar(255) DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `organization_id`, `first_name`, `last_name`, `email`, `username`, `password`, `superadmin`, `forgot_password_key`, `created_on`, `updated_on`) VALUES
(1, 1, 'Yohhan', 'Dalvi', 'yohhan@techcetra.com', 'yohhan', '0b4e7a0e5fe84ad35fb5f95b9ceeac79', 1, 'Df60XdposUPje5ZH', '2020-05-05 13:33:27', '2020-05-11 14:46:40'),
(2, 1, 'Karan', 'Shah', 'karan@techcetra.com', 'karan007', '0b4e7a0e5fe84ad35fb5f95b9ceeac79', 0, NULL, '2020-05-05 13:33:27', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
