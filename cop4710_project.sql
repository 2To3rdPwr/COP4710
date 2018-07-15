-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 15, 2018 at 06:51 PM
-- Server version: 5.7.21
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cop4710_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendence`
--

DROP TABLE IF EXISTS `attendence`;
CREATE TABLE IF NOT EXISTS `attendence` (
  `user_id` int(10) NOT NULL,
  `event_id` int(10) NOT NULL,
  UNIQUE KEY `no_duplicates` (`user_id`,`event_id`),
  KEY `user_id` (`user_id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `comment_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `event_id` int(10) NOT NULL,
  `rating` int(1) NOT NULL COMMENT '0-5 stars',
  `title` tinytext NOT NULL,
  `body` text NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`),
  KEY `user_id` (`user_id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `event_id` int(10) NOT NULL AUTO_INCREMENT,
  `university_id` int(10) NOT NULL,
  `name` tinytext NOT NULL,
  `location` text NOT NULL COMMENT 'Location Data stored as string for now',
  `description` text NOT NULL,
  `date` date NOT NULL,
  `rso_id` int(10) DEFAULT NULL COMMENT '0 = public, 1 = university only, 2 = RSO only',
  `approved` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`event_id`,`university_id`),
  KEY `FK_University_ID` (`university_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`event_id`, `university_id`, `name`, `location`, `description`, `date`, `rso_id`, `approved`) VALUES
(1, 1, 'Guest Speaker - Virgil Abloh', 'UCF Pegasus Ballroom', 'Come hear Virgil\'s lecture about design, streetwear, etc...', '2018-07-12', NULL, NULL),
(2, 1, 'Testing RSOs', 'UCF', 'test', '2018-07-19', 1, 1),
(3, 1, 'Testing RSO Again', 'UCF', 'Testing again', '2018-07-30', 1, 1),
(4, 1, 'Testing RSO OR', 'UCF', 'Testing again 1', '2018-07-31', NULL, 1),
(5, 1, 'Testing RSO 10', 'UCF', 'rso 10', '2018-08-01', 10, 1),
(6, 2, 'Testing RSO 2', 'UCF', 'testing rso 2', '2018-10-01', 2, 1),
(7, 1, 'Testing Unapproved', 'UCF', 'unapproved', '2018-07-15', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rso`
--

DROP TABLE IF EXISTS `rso`;
CREATE TABLE IF NOT EXISTS `rso` (
  `rso_id` int(10) NOT NULL AUTO_INCREMENT,
  `university_id` int(10) NOT NULL,
  `name` tinytext NOT NULL,
  `description` text NOT NULL,
  `website` tinytext,
  `active` int(1) DEFAULT '0',
  PRIMARY KEY (`rso_id`,`university_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rso`
--

INSERT INTO `rso` (`rso_id`, `university_id`, `name`, `description`, `website`, `active`) VALUES
(1, 1, 'testing', 'this is a test', NULL, 0),
(2, 1, 'Brian Huang', 'An rso', NULL, 0),
(3, 1, 'Chinese Club', 'A club where dedicated to celebrating Chinese cutlure!', NULL, 0),
(4, 1, 'Casa Wave', 'Chinese Dancing Club', NULL, 1),
(9, 1, 'aa', 'aa', NULL, 0),
(10, 1, 'aaaaa', 'aaa', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `rso_membership`
--

DROP TABLE IF EXISTS `rso_membership`;
CREATE TABLE IF NOT EXISTS `rso_membership` (
  `rso_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`rso_id`,`user_id`),
  KEY `user_id` (`user_id`),
  KEY `member_of_rso` (`rso_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rso_membership`
--

INSERT INTO `rso_membership` (`rso_id`, `user_id`, `admin`) VALUES
(1, 1, 1),
(2, 1, 1),
(10, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `university`
--

DROP TABLE IF EXISTS `university`;
CREATE TABLE IF NOT EXISTS `university` (
  `university_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `location` text COMMENT 'We''ll store the location data as a string for now',
  `population` int(10) DEFAULT NULL,
  `website` tinytext,
  PRIMARY KEY (`university_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `university`
--

INSERT INTO `university` (`university_id`, `name`, `description`, `location`, `population`, `website`) VALUES
(1, 'University of Central Florida', 'Located in Central Florida.\r\nHome of the Knights', '4000 Central Florida Blvd, Orlando, FL 32816', NULL, 'www.ucf.edu'),
(2, 'University of South Florida', 'Located in South Florida.', '4202 E Fowler Ave, Tampa, FL 33620', NULL, 'www.usf.edu'),
(3, 'University of Florida', 'Located in Gainesville.', 'Gainesville, FL, 32611', NULL, 'www.ufl.edu');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `university_id` int(10) DEFAULT NULL,
  `email` tinytext NOT NULL,
  `password` tinytext NOT NULL,
  `firstname` tinytext NOT NULL,
  `lastname` tinytext NOT NULL,
  `permission_level` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = user. 1 = Super Admin',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`(50)),
  KEY `attends_university` (`university_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `university_id`, `email`, `password`, `firstname`, `lastname`, `permission_level`) VALUES
(1, 1, 'brianhuang12@gmail.com', '$2y$10$K1IpLDhbn0NqeyszXNHomON53UQ7icnwMMuu5uDxTNEK.qkajRBbi', 'Brian', 'Huang', 1),
(2, NULL, 'kerryhuang@comcast.net', '$2y$10$LahGVf.BRa4RcAT4j2BzA.8./Ln3.rAaD9fKjWJuSj6LtqDv.xZtm', 'Kerry', 'Huang', 0),
(3, NULL, 'monicasung2@comcast.net', '$2y$10$xel.3BoRzw3Pt0KqN3H7SeuByXZMVK6pMmt1U26LraxRXVKeyVu.a', 'Monica', 'Sung', 0),
(4, 1, 'brianhuang065@gmail.com', '$2y$10$Og/dX66ei1jMcfbMoHtPYO2kYoPeJaywpqBEe4H8Cu/ZBf3URFMTy', 'Brian', 'Huang', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendence`
--
ALTER TABLE `attendence`
  ADD CONSTRAINT `attendence_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendence_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`university_id`) REFERENCES `university` (`university_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
