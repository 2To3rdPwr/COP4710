-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 11, 2018 at 08:11 PM
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
-- Database: `databasesclass`
--

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
  `date` datetime NOT NULL,
  `privacy` int(1) NOT NULL COMMENT '0 = public, 1 = university only, 2 = RSO only',
  `approved` tinyint(1) NOT NULL,
  PRIMARY KEY (`event_id`),
  UNIQUE KEY `no_two_same_time_place` (`location`(50),`date`),
  KEY `at_university` (`university_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `event_attendence`
--

DROP TABLE IF EXISTS `event_attendence`;
CREATE TABLE IF NOT EXISTS `event_attendence` (
  `event_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  UNIQUE KEY `no_duplicate_attendence` (`event_id`,`user_id`),
  KEY `user_id` (`user_id`),
  KEY `attends_event` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `host_event`
--

DROP TABLE IF EXISTS `host_event`;
CREATE TABLE IF NOT EXISTS `host_event` (
  `event_id` int(10) NOT NULL,
  `rso_id` int(10) NOT NULL,
  UNIQUE KEY `dont_host_twice` (`event_id`,`rso_id`),
  KEY `rso_id` (`rso_id`),
  KEY `event_hosted` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `membership` int(10) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `website` tinytext,
  PRIMARY KEY (`rso_id`),
  KEY `with_university` (`university_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rso_membership`
--

DROP TABLE IF EXISTS `rso_membership`;
CREATE TABLE IF NOT EXISTS `rso_membership` (
  `rso_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  UNIQUE KEY `no_duplicates` (`rso_id`,`user_id`),
  KEY `user_id` (`user_id`),
  KEY `member_of_rso` (`rso_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Pairs users to the RSOs they are members of and Admin status';

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `university`
--

INSERT INTO `university` (`university_id`, `name`, `description`, `location`, `population`, `website`) VALUES
(1, 'University of Central Florida', 'Best College', 'Here', 5, NULL),
(2, 'USFf', 'We\'re not as cool as UCF.', 'yeeeee', 1, 'e');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `university_id` int(10) NOT NULL,
  `email` tinytext NOT NULL,
  `password` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  `permission_level` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = user. 1 = Super Admin',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`(50)),
  KEY `attends_university` (`university_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='table for users with accounts';

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `university_id`, `email`, `password`, `name`, `permission_level`) VALUES
(1, 1, 'e.mail@email.mail', '12345', 'Joseph Test', 0),
(2, 1, 'email@e.mail', '23456', 'Jonny Test', 0);

-- --------------------------------------------------------

--
-- Table structure for table `writes_comment_on`
--

DROP TABLE IF EXISTS `writes_comment_on`;
CREATE TABLE IF NOT EXISTS `writes_comment_on` (
  `comment_id` int(10) NOT NULL AUTO_INCREMENT,
  `event_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `title` tinytext NOT NULL,
  `body` text NOT NULL,
  `rating` int(1) NOT NULL COMMENT '0-5',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`),
  KEY `event_id` (`event_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Comments users write on events';

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `university_id` FOREIGN KEY (`university_id`) REFERENCES `university` (`university_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_attendence`
--
ALTER TABLE `event_attendence`
  ADD CONSTRAINT `event_id` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `host_event`
--
ALTER TABLE `host_event`
  ADD CONSTRAINT `hosts_event_id` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rso_hosts` FOREIGN KEY (`rso_id`) REFERENCES `rso` (`rso_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rso`
--
ALTER TABLE `rso`
  ADD CONSTRAINT `at_university` FOREIGN KEY (`university_id`) REFERENCES `university` (`university_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rso_membership`
--
ALTER TABLE `rso_membership`
  ADD CONSTRAINT `member_of_rso` FOREIGN KEY (`rso_id`) REFERENCES `rso` (`rso_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_member_of` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_attends_university` FOREIGN KEY (`university_id`) REFERENCES `university` (`university_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `writes_comment_on`
--
ALTER TABLE `writes_comment_on`
  ADD CONSTRAINT `user_writes_comment` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `writes_comment_on_event` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
