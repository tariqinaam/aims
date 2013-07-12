-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2013 at 06:39 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `feedback`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE IF NOT EXISTS `answer` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `questionId` int(11) NOT NULL,
  `answer` text NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=74 ;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`Id`, `questionId`, `answer`) VALUES
(1, 1, 'A great deal'),
(2, 1, 'A lot'),
(3, 1, 'A moderate amount'),
(4, 1, 'A little'),
(5, 1, 'None at all'),
(6, 2, 'Extremely satisfied\r\n'),
(7, 2, 'Moderately satisfied'),
(8, 2, 'Slightly satisfied\r\n'),
(9, 2, 'Neither satisfied nor dissatisfied'),
(10, 2, 'Slightly dissatisfied\r\n'),
(11, 2, 'Moderately dissatisfied'),
(12, 2, 'Extremely dissatisfied'),
(13, 3, 'Much better'),
(14, 3, 'Somewhat better'),
(15, 3, 'Slightly better'),
(16, 3, 'About what was expected'),
(17, 3, 'Slightly worse'),
(18, 3, 'Somewhat worse'),
(19, 3, 'Much worse'),
(20, 4, 'Extremely useful'),
(21, 4, 'Very useful'),
(22, 4, 'Moderately useful'),
(23, 4, 'Slightly useful'),
(24, 4, 'Not at all useful'),
(25, 7, 'Extremely organized'),
(26, 7, 'Very organized'),
(27, 7, 'Moderately organized'),
(28, 7, 'Slightly organized'),
(29, 7, 'Not at all organized'),
(30, 8, '  Extremely comfortable'),
(31, 8, 'Very comfortable'),
(32, 8, 'Moderately comfortable'),
(33, 8, 'Slightly comfortable'),
(34, 8, 'Not at all comfortable'),
(35, 9, 'All of them'),
(36, 9, 'Most of them'),
(37, 9, 'About half of them'),
(38, 9, 'Some of them'),
(39, 9, 'None of them'),
(40, 10, 'Much too much'),
(41, 10, 'Somewhat too much'),
(42, 10, 'Slightly too much'),
(43, 10, 'About the right amount'),
(44, 10, 'Slightly too little'),
(45, 10, 'Somewhat too little'),
(46, 10, 'Much too little'),
(47, 11, 'Extremely skilled'),
(48, 11, 'Very skilled'),
(49, 11, 'Moderately skilled'),
(50, 11, 'Slightly skilled'),
(51, 11, 'Not at all skilled'),
(52, 12, 'Extremely organized'),
(53, 12, 'Very organized'),
(54, 12, 'Moderately organized'),
(55, 12, 'Slightly organized'),
(56, 12, 'Not at all organized'),
(57, 13, 'Extremely good'),
(58, 13, 'Very good'),
(59, 13, 'Somewhat good'),
(60, 13, 'Neither good nor poor'),
(61, 13, 'Somewhat poor'),
(62, 13, 'Very poor'),
(63, 13, 'Extremely poor'),
(64, 14, 'Extremely good\r\n'),
(65, 14, 'Very good'),
(66, 14, 'Somewhat good'),
(67, 14, 'Neither good nor poor'),
(68, 14, 'Somewhat poor'),
(69, 14, 'Very poor'),
(70, 14, 'Extremely poor'),
(71, 15, ''),
(72, 16, ''),
(73, 17, '');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `questionType` varchar(10) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`Id`, `question`, `questionType`, `isActive`) VALUES
(1, 'How much have your skills improved because of the training at the Forum?', 'skills', 1),
(2, 'Overall, were you satisfied with the Forum, neither satisfied nor dissatisfied with it, or dissatisfied with it?', 'satisfacti', 1),
(3, 'Was the Forum better than what you expected, worse than what you expected, or about what you expected?', 'expectatio', 1),
(4, 'How useful was the information presented at the Forum?', 'usefull', 1),
(7, 'How organized was the information presented at the Forum?', 'organized', 1),
(8, 'How comfortable did you feel asking questions at the Forum?', 'confort', 1),
(9, 'How many of the objectives of the Forum were met?', 'objective', 1),
(10, 'Did the presenter allow too much time for discussion, too little time, or about the right amount of time?', 'time-manag', 1),
(11, 'How skilled in the subject were the presenters?', 'presenter-', 1),
(12, 'How organized was the Forum?', 'forum-orga', 1),
(13, 'How would you rate the venue/location?', 'venue', 1),
(14, 'How would you rate the food?', 'food', 1),
(15, 'Is there anything else you’d like to share about the Forum?', 'anything-t', 1),
(16, 'What was the most beneficial aspect of the Forum?', 'benefit', 1),
(17, 'What other topics or themes are of interest to you for a Forum?', 'other', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(25) NOT NULL,
  `lname` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `address` varchar(50) NOT NULL,
  `address1` varchar(25) NOT NULL,
  `country` varchar(10) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user-answer`
--

CREATE TABLE IF NOT EXISTS `user-answer` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `answerId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
