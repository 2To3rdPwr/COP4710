-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 16, 2018 at 04:58 PM
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
  `rso_id` int(1) DEFAULT NULL,
  `approved` tinyint(1) DEFAULT NULL,
  `privacy` int(11) NOT NULL COMMENT '0 = public, 1 = university only, 2 = RSO only',
  PRIMARY KEY (`event_id`,`university_id`),
  KEY `FK_University_ID` (`university_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`event_id`, `university_id`, `name`, `location`, `description`, `date`, `rso_id`, `approved`, `privacy`) VALUES
(1, 1, 'Guest Speaker - Virgil Abloh', 'UCF Pegasus Ballroom', 'Come hear Virgil\'s lecture about design, streetwear, etc...', '2018-07-12 00:00:00', NULL, NULL, 0),
(2, 1, 'Testing RSOs', 'UCF', 'test', '2018-07-19 00:00:00', 1, 1, 0),
(3, 1, 'Testing RSO Again', 'UCF', 'Testing again', '2018-07-30 00:00:00', 1, 1, 0),
(4, 1, 'Testing RSO OR', 'UCF', 'Testing again boiii', '2018-07-31 00:00:00', NULL, 1, 0),
(5, 1, 'Testing RSO 10', 'UCF', 'rso 10', '2018-08-01 00:00:00', 10, 1, 0),
(6, 2, 'Testing RSO 2', 'UCF', 'testing rso 2', '2018-10-01 00:00:00', 2, 1, 0),
(7, 1, 'Testing Unapproved', 'UCF', 'unapproved', '2018-07-15 00:00:00', 1, NULL, 0),
(8, 1, 'asdf', 'aasdf', 'asdf', '2018-07-11 23:30:00', NULL, 1, 0),
(9, 1, 'Casa Wave Dance', 'Ballroom', 'dancing!', '2018-07-26 19:30:00', 4, 1, 2),
(10, 1, 'public event', 'wew', 'everyone should see this event', '2018-07-24 00:00:00', NULL, 1, 0),
(11, 1, 'Private Event', 'wew', 'Only those attending university 1 may see this event.', '2018-07-17 00:00:00', NULL, 1, 1),
(12, 1, 'RSO 1 Only', 'wew', 'Only members of RSO 1 mas see this event', '2018-07-18 00:00:00', 1, 1, 2),
(13, 1, 'unapproved event', 'wew', 'this event is not approved, and as such, should not be visible', '2018-07-17 00:00:00', NULL, 0, 0);

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
  `active` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`rso_id`,`university_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rso`
--

INSERT INTO `rso` (`rso_id`, `university_id`, `name`, `description`, `website`, `active`) VALUES
(1, 1, 'testing', 'this is a test', NULL, 1),
(2, 1, 'Brian Huang', 'An rso dedicated to brian', NULL, 0),
(3, 1, 'Chinese Club', 'A club where dedicated to celebrating Chinese cutlure!', NULL, 0),
(4, 1, 'Casa Wave', 'Chinese Dancing Club', NULL, 1),
(9, 1, 'aa', 'aa', NULL, 0),
(10, 1, 'aaaaa', 'aaa', NULL, 0),
(11, 3, 'Inactive', 'should not be active', NULL, 1);

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rso_membership`
--

INSERT INTO `rso_membership` (`rso_id`, `user_id`, `admin`) VALUES
(10, 1, 1),
(1, 1, 1),
(2, 1, 1),
(4, 1, 1),
(9, 1, 0),
(4, 4, 0),
(1, 9, 0),
(11, 1, 0),
(11, 3, 0),
(11, 2, 0),
(11, 4, 0),
(11, 5, 1);

--
-- Triggers `rso_membership`
--
DROP TRIGGER IF EXISTS `UdateRSOStatusJoin`;
DELIMITER $$
CREATE TRIGGER `UdateRSOStatusJoin` AFTER INSERT ON `rso_membership` FOR EACH ROW BEGIN
    	if((SELECT COUNT(*) FROM rso_membership WHERE rso_membership.rso_id = NEW.rso_id) > 4)
        THEN
        UPDATE rso SET active = 1 where rso.rso_id = NEW.rso_id;
        END IF;
        END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `UdateRSOStatusLeave`;
DELIMITER $$
CREATE TRIGGER `UdateRSOStatusLeave` AFTER DELETE ON `rso_membership` FOR EACH ROW BEGIN if((SELECT COUNT(*) FROM rso_membership WHERE rso_membership.rso_id = OLD.rso_id) < 5) THEN UPDATE rso SET active = 0 where rso.rso_id = OLD.rso_id; END IF; END
$$
DELIMITER ;

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

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
  `permission_level` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = user. 1 = Super Admin 2 = rso_admin',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`(50)),
  KEY `attends_university` (`university_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `university_id`, `email`, `password`, `firstname`, `lastname`, `permission_level`) VALUES
(1, 1, 'brianhuang12@gmail.com', '$2y$10$qSrxRrAPlLMFnXPprwqoCuCsCe02V942cr5IpNXfa1Cyq9hbuXD9G', 'Brian', 'Huang', 1),
(2, NULL, 'kerryhuang@comcast.net', '$2y$10$LahGVf.BRa4RcAT4j2BzA.8./Ln3.rAaD9fKjWJuSj6LtqDv.xZtm', 'Kerry', 'Huang', 0),
(3, NULL, 'monicasung2@comcast.net', '$2y$10$xel.3BoRzw3Pt0KqN3H7SeuByXZMVK6pMmt1U26LraxRXVKeyVu.a', 'Monica', 'Sung', 0),
(4, 1, 'brianhuang065@gmail.com', '$2y$10$Og/dX66ei1jMcfbMoHtPYO2kYoPeJaywpqBEe4H8Cu/ZBf3URFMTy', 'Brian', 'Huang', 0),
(5, 2, 'brianhuang11@gmail.com', '$2y$10$xyqCqzIsP.eGXeD51WGq.uIcrFZGQkhnmofXhPjmDsHCRefXpM0Dy', 'brian', 'huang', 0),
(6, NULL, 'kevinhuang@gmail.com', '$2y$10$.qgoYG564AxqwHT7lP84lOAaADd8o23dktlDTn1jLUXkY9PtKZQWi', 'Kevin', 'Huang', 0),
(8, 1, 'U1@mail.com', '$2y$10$22ZlEHSRsJvXVI0KI0osdOjtogGPMvU23Ki034Ob2fY/7Kr1d2XF2', 'a', 'a', 0),
(9, NULL, 'U1R1@mail.com', '$2y$10$22ZlEHSRsJvXVI0KI0osdOjtogGPMvU23Ki034Ob2fY/7Kr1d2XF2', '1', '1', 0),
(10, 2, 'NU1@mail.com', '$2y$10$22ZlEHSRsJvXVI0KI0osdOjtogGPMvU23Ki034Ob2fY/7Kr1d2XF2', 'a', 'a', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
