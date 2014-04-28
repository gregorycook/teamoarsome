-- phpMyAdmin SQL Dump
-- version 3.3.10.4
-- http://www.phpmyadmin.net
--
-- Host: teamoarsome.cakewood.net
-- Generation Time: Apr 27, 2014 at 10:12 PM
-- Server version: 5.1.56
-- PHP Version: 5.3.27

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `teamoarsome`
--

-- --------------------------------------------------------

--
-- Table structure for table `athlete`
--

DROP TABLE IF EXISTS `athlete`;
CREATE TABLE `athlete` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Gender` char(1) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `athlete`
--

INSERT INTO `athlete` (`Id`, `Name`, `Gender`) VALUES
(1, 'Gregory', 'M'),
(2, 'Arlene', 'F'),
(3, '', 'M'),
(4, 'Dave C', 'M'),
(5, 'Adrian', 'M'),
(6, 'Rocky', 'M'),
(7, 'Andy B', 'M'),
(8, 'Larry', 'M'),
(9, 'Kay', 'F');

-- --------------------------------------------------------

--
-- Table structure for table `attempt`
--

DROP TABLE IF EXISTS `attempt`;
CREATE TABLE `attempt` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `AthleteId` int(11) NOT NULL,
  `ChallengeId` int(11) NOT NULL,
  `Distance` int(11) NOT NULL,
  `Time` decimal(6,1) NOT NULL,
  `Weight` enum('L','H') NOT NULL,
  `Entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `SPM` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `attempt`
--

INSERT INTO `attempt` (`Id`, `AthleteId`, `ChallengeId`, `Distance`, `Time`, `Weight`, `Entered`, `SPM`) VALUES
(1, 2, 15, 9874, 0.0, 'L', '2014-04-16 22:04:46', 0),
(2, 2, 15, 4321, 370.1, 'L', '2014-04-19 10:50:04', 0),
(3, 1, 15, 12324, 7576.1, 'L', '2014-04-19 10:54:52', 0),
(4, 2, 15, 5432, 3600.0, 'L', '2014-04-19 10:57:33', 0),
(5, 1, 15, 5000, 1428.1, 'L', '2014-04-19 11:14:18', 0),
(6, 2, 15, 5000, 1222.1, 'L', '2014-04-19 11:14:50', 0),
(7, 1, 15, 5000, 1111.0, 'L', '2014-04-19 11:15:15', 0),
(21, 5, 17, 15000, 3953.0, 'H', '2014-04-24 06:34:19', 24),
(22, 2, 16, 7007, 1800.0, 'L', '2014-04-26 18:38:27', 26),
(20, 6, 17, 15000, 3327.1, 'H', '2014-04-24 06:32:53', 22),
(11, 4, 16, 8300, 1800.0, 'H', '2014-04-20 11:59:59', 31),
(12, 6, 16, 8345, 1800.0, 'H', '2014-04-21 11:57:28', 24),
(19, 1, 16, 8213, 1800.0, 'L', '2014-04-24 06:31:26', 26),
(14, 7, 16, 8138, 1800.0, 'H', '2014-04-22 02:32:57', 25),
(15, 8, 16, 8195, 1800.0, 'H', '2014-04-22 02:33:10', 27),
(16, 9, 16, 6766, 1800.0, 'H', '2014-04-23 04:18:03', 28),
(17, 4, 17, 15000, 3318.0, 'H', '2014-04-24 06:28:42', 25),
(18, 9, 17, 15000, 4210.1, 'H', '2014-04-24 06:30:21', 27),
(23, 4, 18, 8456, 1800.0, 'H', '2014-04-27 21:41:33', 27),
(24, 9, 18, 6799, 1800.0, 'H', '2014-04-27 21:41:54', 27),
(25, 6, 18, 8554, 1800.0, 'H', '2014-04-27 21:42:17', 24),
(26, 5, 18, 6997, 1800.0, 'H', '2014-04-27 21:43:09', 24),
(27, 7, 18, 8377, 1800.0, 'H', '2014-04-27 21:43:29', 27),
(28, 4, 19, 10000, 2191.1, 'H', '2014-04-27 21:44:27', 25),
(29, 9, 19, 10000, 2842.0, 'H', '2014-04-27 21:45:02', 27),
(30, 5, 19, 10000, 2364.0, 'H', '2014-04-27 21:45:44', 25),
(31, 3, 20, 5031, 1020.0, 'H', '2014-04-27 21:46:36', 27),
(32, 4, 20, 5031, 1020.0, 'H', '2014-04-27 21:46:52', 27),
(33, 9, 20, 4003, 1020.0, 'H', '2014-04-27 21:48:03', 29),
(34, 6, 20, 5050, 1020.0, 'H', '2014-04-27 21:49:30', 24),
(36, 7, 20, 4972, 1020.0, 'H', '2014-04-27 21:51:02', 30),
(37, 4, 21, 6000, 1278.0, 'H', '2014-04-27 21:51:46', 30),
(38, 9, 21, 6000, 1654.1, 'H', '2014-04-27 21:52:39', 25),
(39, 6, 21, 6000, 1275.0, 'H', '2014-04-27 21:53:08', 24),
(40, 5, 21, 6000, 1439.1, 'H', '2014-04-27 21:53:42', 20),
(41, 7, 21, 6000, 1383.1, 'H', '2014-04-27 21:54:13', 20),
(42, 4, 22, 5192, 600.0, 'H', '2014-04-27 21:54:40', 28),
(43, 9, 22, 2525, 600.0, 'H', '2014-04-27 21:55:00', 33),
(44, 5, 22, 2891, 600.0, 'H', '2014-04-27 21:55:23', 28),
(45, 4, 23, 3000, 610.0, 'H', '2014-04-27 21:56:50', 29),
(46, 9, 23, 3000, 755.1, 'H', '2014-04-27 21:58:32', 29),
(47, 5, 23, 3000, 648.0, 'H', '2014-04-27 21:59:04', 28),
(48, 7, 23, 3000, 604.0, 'H', '2014-04-27 21:59:33', 30),
(49, 4, 24, 7959, 1800.0, 'H', '2014-04-27 22:00:03', 20),
(52, 4, 25, 4000, 88.0, 'H', '2014-04-27 22:01:39', 45);

-- --------------------------------------------------------

--
-- Table structure for table `challenge`
--

DROP TABLE IF EXISTS `challenge`;
CREATE TABLE `challenge` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Month` int(11) NOT NULL,
  `Year` int(11) NOT NULL,
  `Type` enum('D','T') NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Distance` int(11) DEFAULT NULL,
  `Time` decimal(6,1) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `challenge`
--

INSERT INTO `challenge` (`Id`, `Name`, `Month`, `Year`, `Type`, `Description`, `Distance`, `Time`) VALUES
(16, 'April Challenge:  30 minutes, unrestricted', 4, 2014, 'T', 'Row as many meters as you can in 30 minutes with no rate restrictions!', 0, 1800.0),
(17, '3 x 5K, 5'' rest', 5, 2013, 'D', '3 x 5K, 5'' rest', 15000, 0.0),
(18, '6 x 5'', 2'' rest', 6, 2013, 'T', '6 x 5'', 2'' rest (Enter the meters you rowed in 30'')', NULL, 1800.0),
(19, '10K', 7, 2013, 'D', '10K', 10000, 0.0),
(20, '1''-2''-3''-2''-1''-2''-3''-2''-1'',  R1', 8, 2013, 'T', '1''-2''-3''-2''-1''-2''-3''-2''-1'',  R1  (Enter total meters rowed in 17 minutes.)', NULL, 1020.0),
(21, '6K', 9, 2013, 'D', '6K', 6000, NULL),
(22, '20 x 30", 30" rest', 10, 2013, 'T', '20 x 30", 30" rest', NULL, 600.0),
(23, '4 x 750, 2'' rest', 11, 2013, 'D', '4 x 750, 2'' rest', 3000, NULL),
(24, '30r20', 12, 2013, 'T', '30r20', NULL, 1800.0),
(25, '8 x 500, 2'' rest', 1, 2014, 'D', '8 x 500, 2'' rest', 4000, NULL),
(26, '2K', 2, 2014, 'D', '2K', 2000, NULL),
(27, '500 meters', 3, 2014, 'D', '500 meters', 500, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `current`
--

DROP TABLE IF EXISTS `current`;
CREATE TABLE `current` (
  `ChallengeId` int(11) NOT NULL,
  `StartActive` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `EndActive` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `current`
--

INSERT INTO `current` (`ChallengeId`, `StartActive`, `EndActive`) VALUES
(16, '2014-04-19 20:57:57', NULL);
