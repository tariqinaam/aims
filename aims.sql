-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.5.27 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2013-07-12 17:34:42
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for table feedback.answer
CREATE TABLE IF NOT EXISTS `answer` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `questionId` int(11) NOT NULL,
  `answer` text NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=latin1;

-- Dumping data for table feedback.answer: ~73 rows (approximately)
DELETE FROM `answer`;
/*!40000 ALTER TABLE `answer` DISABLE KEYS */;
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
/*!40000 ALTER TABLE `answer` ENABLE KEYS */;


-- Dumping structure for table feedback.jamaat
CREATE TABLE IF NOT EXISTS `jamaat` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `jamaat_name` varchar(100) NOT NULL,
  `is_active` tinyint(10) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table feedback.jamaat: ~2 rows (approximately)
DELETE FROM `jamaat`;
/*!40000 ALTER TABLE `jamaat` DISABLE KEYS */;
INSERT INTO `jamaat` (`ID`, `jamaat_name`, `is_active`) VALUES
	(1, 'Tema', 1),
	(2, 'Akra', 1);
/*!40000 ALTER TABLE `jamaat` ENABLE KEYS */;


-- Dumping structure for table feedback.member
CREATE TABLE IF NOT EXISTS `member` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `jamaat_id` int(10) NOT NULL,
  `age` int(10) NOT NULL,
  `tajneed` varchar(50) NOT NULL,
  `is_active` tinyint(10) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table feedback.member: ~1 rows (approximately)
DELETE FROM `member`;
/*!40000 ALTER TABLE `member` DISABLE KEYS */;
INSERT INTO `member` (`ID`, `first_name`, `last_name`, `jamaat_id`, `age`, `tajneed`, `is_active`) VALUES
	(1, 'raghib', 'ziaul', 1, 40, 'Ansaar', 1);
/*!40000 ALTER TABLE `member` ENABLE KEYS */;


-- Dumping structure for table feedback.question
CREATE TABLE IF NOT EXISTS `question` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `questionType` int(11) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- Dumping data for table feedback.question: ~15 rows (approximately)
DELETE FROM `question`;
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
INSERT INTO `question` (`Id`, `question`, `questionType`, `isActive`) VALUES
	(1, 'How much have your skills improved because of the training at the Forum?', 0, 1),
	(2, 'Overall, were you satisfied with the Forum, neither satisfied nor dissatisfied with it, or dissatisfied with it?', 0, 1),
	(3, 'Was the Forum better than what you expected, worse than what you expected, or about what you expected?', 0, 1),
	(4, 'How useful was the information presented at the Forum?', 0, 1),
	(7, 'How organized was the information presented at the Forum?', 0, 1),
	(8, 'How comfortable did you feel asking questions at the Forum?', 0, 1),
	(9, 'How many of the objectives of the Forum were met?', 0, 1),
	(10, 'Did the presenter allow too much time for discussion, too little time, or about the right amount of time?', 0, 1),
	(11, 'How skilled in the subject were the presenters?', 0, 1),
	(12, 'How organized was the Forum?', 0, 1),
	(13, 'How would you rate the venue/location?', 0, 1),
	(14, 'How would you rate the food?', 0, 1),
	(15, 'Is there anything else you’d like to share about the Forum?', 1, 1),
	(16, 'What was the most beneficial aspect of the Forum?', 1, 1),
	(17, 'What other topics or themes are of interest to you for a Forum?', 1, 1);
/*!40000 ALTER TABLE `question` ENABLE KEYS */;


-- Dumping structure for table feedback.receipt_meta
CREATE TABLE IF NOT EXISTS `receipt_meta` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `receipt_no` int(50) NOT NULL,
  `receipt_type` varchar(100) NOT NULL,
  `value` double NOT NULL,
  `year` int(10) NOT NULL,
  `is_active` tinyint(10) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=latin1;

-- Dumping data for table feedback.receipt_meta: ~14 rows (approximately)
DELETE FROM `receipt_meta`;
/*!40000 ALTER TABLE `receipt_meta` DISABLE KEYS */;
INSERT INTO `receipt_meta` (`ID`, `user_id`, `receipt_no`, `receipt_type`, `value`, `year`, `is_active`) VALUES
	(1, 1, 10001, 'Wassiyyat', 20, 2012, 1),
	(2, 1, 10002, 'Wassiyyat', 15, 2013, 1),
	(15, 1, 10011, 'Wassiyyat', 43, 2012, 1),
	(16, 1, 10011, 'Jalsa Salana', 2, 2012, 1),
	(17, 1, 10011, 'Waqf-e-Jadid', 10, 2012, 1),
	(18, 1, 10013, 'Wassiyyat', 10, 2013, 1),
	(19, 1, 10013, 'Aam', 15, 2013, 1),
	(20, 1, 10013, 'Jalsa Salana', 20, 2013, 1),
	(21, 1, 10013, 'Waqf-e-Jadid', 25, 2013, 1),
	(22, 1, 10013, 'Wassiyyat', 10, 2013, 1),
	(23, 1, 10014, 'Wassiyyat', 10, 2013, 1),
	(24, 1, 10015, 'Wassiyyat', 10, 2013, 1),
	(25, 1, 10015, 'Aam', 15, 2013, 1),
	(26, 1, 10015, 'Jalsa Salana', 20, 2013, 1),
	(27, 1, 10015, 'Waqf-e-Jadid', 25, 2013, 1),
	(28, 1, 10016, 'Wassiyyat', 10, 2013, 1),
	(29, 1, 10016, 'Aam', 5, 2013, 1),
	(30, 1, 10016, 'Jalsa Salana', 4, 2013, 1),
	(31, 1, 10016, 'Waqf-e-Jadid', 3, 2013, 1),
	(32, 1, 10017, 'Wassiyyat', 10, 2013, 1),
	(33, 1, 10017, 'Aam', 5, 2013, 1),
	(34, 1, 10017, 'Jalsa Salana', 4, 2013, 1),
	(35, 1, 10017, 'Waqf-e-Jadid', 3, 2013, 1),
	(36, 1, 10020, 'Wassiyyat', 2, 2013, 1),
	(37, 1, 10020, 'Wassiyyat', 2, 2013, 1),
	(38, 1, 10020, 'Wassiyyat', 2, 2013, 1),
	(39, 1, 10021, 'Wassiyyat', 10, 2013, 1),
	(40, 1, 10021, 'Wassiyyat', 10, 2013, 1),
	(41, 1, 10021, 'Wassiyyat', 10, 2013, 1),
	(42, 1, 10022, 'Wassiyyat', 23, 2013, 1),
	(43, 1, 10023, 'Wassiyyat', 3, 2013, 1),
	(44, 1, 10023, 'Aam', 4, 2013, 1),
	(45, 1, 10025, 'Fitrana', 23, 2013, 1),
	(46, 1, 10028, 'Wassiyyat', 12.23, 2013, 1),
	(47, 1, 10028, 'Aam', 34, 2013, 1),
	(48, 1, 10030, 'Wassiyyat', 34, 2013, 1),
	(49, 1, 10030, 'Aam', 34, 2013, 1),
	(50, 1, 10036, 'Wassiyyat', 10, 2013, 1),
	(51, 1, 10036, 'Jalsa Salana', 5, 2013, 1),
	(52, 1, 10036, 'Waqf-e-Jadid', 5, 2013, 1),
	(53, 1, 10036, 'Tehrik-e-Jadid', 5, 2013, 1),
	(54, 1, 10036, 'Sadqa', 5, 2013, 1),
	(55, 1, 10036, 'Fitrana', 2, 2013, 1),
	(56, 1, 10036, 'Ansar', 20, 2013, 1);
/*!40000 ALTER TABLE `receipt_meta` ENABLE KEYS */;


-- Dumping structure for table feedback.receipt_type
CREATE TABLE IF NOT EXISTS `receipt_type` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `receipt_name` varchar(50) NOT NULL,
  `is_active` tinyint(10) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- Dumping data for table feedback.receipt_type: ~11 rows (approximately)
DELETE FROM `receipt_type`;
/*!40000 ALTER TABLE `receipt_type` DISABLE KEYS */;
INSERT INTO `receipt_type` (`ID`, `receipt_name`, `is_active`) VALUES
	(1, 'Wassiyyat', 1),
	(2, 'Aam', 1),
	(3, 'Jalsa Salana', 1),
	(4, 'Waqf-e-Jadid', 1),
	(5, 'Tehrik-e-Jadid', 1),
	(6, 'Sadqa', 1),
	(7, 'Fitrana', 1),
	(8, 'Eid fund', 1),
	(9, 'Khuddam', 1),
	(10, 'Lajna', 1),
	(11, 'Ansar', 1);
/*!40000 ALTER TABLE `receipt_type` ENABLE KEYS */;


-- Dumping structure for table feedback.user
CREATE TABLE IF NOT EXISTS `user` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(25) NOT NULL,
  `lname` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `password` varchar(50) NOT NULL,
  `acl_role` varchar(25) NOT NULL,
  `country` varchar(10) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table feedback.user: ~1 rows (approximately)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`ID`, `fname`, `lname`, `email`, `password`, `acl_role`, `country`) VALUES
	(1, 'tariq', 'inam', 'tariq.inaam@gmail.com', '29336aba0bf285488b854e382d01add6', 'dev', 'UK');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;


-- Dumping structure for table feedback.user-answer
CREATE TABLE IF NOT EXISTS `user-answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `questionId` int(11) NOT NULL,
  `answerId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table feedback.user-answer: ~0 rows (approximately)
DELETE FROM `user-answer`;
/*!40000 ALTER TABLE `user-answer` DISABLE KEYS */;
/*!40000 ALTER TABLE `user-answer` ENABLE KEYS */;


-- Dumping structure for table feedback.year
CREATE TABLE IF NOT EXISTS `year` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `year` int(10) NOT NULL,
  `is_active` tinyint(10) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table feedback.year: ~2 rows (approximately)
DELETE FROM `year`;
/*!40000 ALTER TABLE `year` DISABLE KEYS */;
INSERT INTO `year` (`ID`, `year`, `is_active`) VALUES
	(1, 2012, 1),
	(2, 2013, 1);
/*!40000 ALTER TABLE `year` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
