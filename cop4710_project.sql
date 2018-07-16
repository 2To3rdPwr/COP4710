-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 16, 2018 at 10:31 PM
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
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE IF NOT EXISTS `attendance` (
  `user_id` int(10) NOT NULL,
  `event_id` int(10) NOT NULL,
  UNIQUE KEY `no_duplicates` (`user_id`,`event_id`),
  KEY `user_id` (`user_id`),
  KEY `event_id` (`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`user_id`, `event_id`) VALUES
(11, 5);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `comment_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `event_id` int(10) NOT NULL,
  `body` text NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`),
  KEY `user_id` (`user_id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `user_id`, `event_id`, `body`, `date`) VALUES
(1, 1, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus hendrerit fringilla lacus, at aliquet purus sodales vel. Suspendisse vitae ex pretium, bibendum lectus in, ullamcorper ante.', '2018-07-16 14:55:06'),
(5, 12, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus hendrerit fringilla lacus, at aliquet purus sodales vel. Suspendisse vitae ex pretium, bibendum lectus in, ullamcorper ante.', '2018-07-16 18:15:30'),
(6, 3, 1, 'Mauris a aliquet neque, quis consequat justo. Curabitur vel dolor sed nisi posuere feugiat. Nam id nulla nec eros pretium pharetra sit amet quis sem.', '2018-07-15 06:31:16'),
(7, 11, 5, 'Nam ultrices enim eu quam luctus pellentesque.', '2018-07-16 17:00:00');

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
(1, 1, 'Guest Speaker - Virgil Abloh', 'UCF Pegasus Ballroom', 'Come hear Virgil\'s lecture about design, streetwear, etc...', '2018-07-12 00:00:00', NULL, 1, 0),
(2, 1, 'Super Fun Event', 'UCF', 'Get ready to have some fun!', '2018-07-19 00:00:00', 1, 1, 0),
(3, 1, 'Mauris a aliquet neque', 'UCF', 'Maecenas posuere leo sagittis lacus venenatis vestibulum a ut nulla. Fusce tellus magna, porttitor quis libero ac, lacinia suscipit nisi. Praesent maximus ullamcorper purus id eleifend. In nisi tortor, dictum ut ligula sed, gravida fringilla metus.', '2018-07-30 00:00:00', 1, 1, 0),
(4, 1, 'Nam ultrices enim', 'UCF', 'Nam ultrices enim eu quam luctus pellentesque. Sed sit amet vestibulum lorem. In vel pulvinar risus. Mauris auctor, eros vel blandit feugiat, erat est accumsan urna, nec rhoncus dolor lectus at enim. Suspendisse gravida, enim quis posuere commodo, ante urna ultricies nisi, in convallis sapien metus et lectus.', '2018-07-31 00:00:00', NULL, 1, 0),
(5, 1, 'Lorem ipsum dolor sit amet', 'UCF', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus hendrerit fringilla lacus, at aliquet purus sodales vel. Suspendisse vitae ex pretium, bibendum lectus in, ullamcorper ante. Integer ante metus, egestas eu orci ut, consequat porttitor eros. Quisque congue consequat ipsum, varius rutrum lectus semper eget. Sed urna turpis, ullamcorper semper ex ut, maximus malesuada massa. Pellentesque laoreet imperdiet mi vel volutpat. Etiam in neque vel ligula dictum sodales a nec enim. Maecenas dolor quam, porta et sollicitudin et, pulvinar sed orci. Nulla augue odio, tristique non auctor a, convallis in eros. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec malesuada nec justo in gravida. Donec scelerisque nunc quis pulvinar faucibus. ', '2018-08-01 00:00:00', 10, 1, 0),
(6, 2, 'Aenean et ullamcorper', 'UCF', 'Aliquam pulvinar faucibus purus, ac pharetra augue vehicula id. Aenean et ullamcorper tortor. Vivamus molestie, neque sit amet porta imperdiet, risus ipsum porta risus, in ullamcorper est arcu et libero. Nulla sit amet porttitor elit. Phasellus mauris augue, finibus eu tincidunt vel, laoreet lacinia diam. Duis varius neque elementum metus bibendum sollicitudin blandit ut sapien. Sed pharetra lacus at massa blandit, vel finibus lorem aliquet. Etiam varius, nunc ut sodales gravida, massa massa porta justo, vestibulum ornare lacus leo quis leo. ', '2018-10-01 00:00:00', 2, 1, 0),
(8, 1, 'Ut nec faucibus elit', 'UCF', 'Ut nec faucibus elit. Nulla sem magna, hendrerit laoreet risus a, laoreet rhoncus risus.', '2018-07-11 23:30:00', NULL, 1, 0),
(9, 1, 'Casa Wave Dance', 'Ballroom', 'dancing!', '2018-07-26 19:30:00', 4, 1, 2),
(10, 1, 'public event', 'wew', 'everyone should see this event', '2018-07-24 00:00:00', NULL, 1, 0),
(11, 1, 'Private Event', 'wew', 'Only those attending university 1 may see this event.', '2018-07-17 00:00:00', NULL, 1, 1),
(12, 1, 'RSO 1 Only', 'wew', 'Only members of RSO 1 may see this event', '2018-07-18 00:00:00', 1, 1, 2),
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
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rso`
--

INSERT INTO `rso` (`rso_id`, `university_id`, `name`, `description`, `website`, `active`) VALUES
(1, 1, 'Donec interdum', 'Maecenas leo felis, hendrerit non ornare vitae, laoreet a nunc. Phasellus eget efficitur ante. ', NULL, 1),
(2, 1, 'Brian Huang', 'An rso dedicated to brian', NULL, 0),
(3, 1, 'Chinese Club', 'A club where dedicated to celebrating Chinese cutlure!', NULL, 0),
(4, 1, 'Casa Wave', 'Chinese Dancing Club', NULL, 1),
(9, 1, 'Integer ante metus', 'Sed urna turpis, ullamcorper semper ex ut, maximus malesuada massa. Pellentesque laoreet imperdiet mi vel volutpat. Etiam in neque vel ligula dictum sodales a nec enim. Maecenas dolor quam, porta et sollicitudin et, pulvinar sed orci. Nulla augue odio, tristique non auctor a, convallis in eros.', NULL, 0),
(10, 1, 'Curabitur vel dolor', 'Integer sollicitudin sapien enim, at faucibus purus ullamcorper nec. Aenean a massa rutrum, efficitur odio ut, luctus sapien.', NULL, 0),
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
(11, 5, 1),
(4, 11, 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

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
(9, 1, 'U1R1@mail.com', '$2y$10$pk4xNfeebk0Lj4ws7ZqIBO7XsM/6mbHHvsG9poXTtPbCpXHsKY.jK', 'Brian', 'Huang', 0),
(10, 2, 'NU1@mail.com', '$2y$10$22ZlEHSRsJvXVI0KI0osdOjtogGPMvU23Ki034Ob2fY/7Kr1d2XF2', 'a', 'a', 0),
(11, 1, 'jsage@gmail.com', '$2y$10$tTd1TQ4PgKS2mzgYl275.uLTEess0HfRVPU.S5IoUtQYD/KXJBiUC', 'Jake', 'Sage', 0),
(12, 1, 'brianhuang12@mail.com', '$2y$10$TbpBV3jeawr5Bve2YyuLMOrunxvDOSTQcx.wJuU1rE9ElppRKDVgS', 'Brian', 'Huang', 0),
(13, 1, 'imdumb@mail.com', '$2y$10$PdAkPQzlZjRVUfMf/jYNf.zB76TCiDDFLnYAmYwr4iw2V.PbSfBBa', 'im', 'dumb', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
