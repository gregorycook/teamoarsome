-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 19, 2014 at 11:22 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `teamoarsomechallenge`
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `athlete`
--

INSERT INTO `athlete` (`Id`, `Name`, `Gender`) VALUES
(1, 'Gregory', 'M'),
(2, 'Arlene', 'F');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `attempt`
--

INSERT INTO `attempt` (`Id`, `AthleteId`, `ChallengeId`, `Distance`, `Time`, `Weight`, `Entered`, `SPM`) VALUES
(1, 2, 15, 9874, '0.0', 'L', '2014-04-16 22:04:46', 0),
(2, 2, 15, 4321, '370.1', 'L', '2014-04-19 10:50:04', 0),
(3, 1, 15, 12324, '7576.1', 'L', '2014-04-19 10:54:52', 0),
(4, 2, 15, 5432, '3600.0', 'L', '2014-04-19 10:57:33', 0),
(5, 1, 15, 5000, '1428.1', 'L', '2014-04-19 11:14:18', 0),
(6, 2, 15, 5000, '1222.1', 'L', '2014-04-19 11:14:50', 0),
(7, 1, 15, 5000, '1111.0', 'L', '2014-04-19 11:15:15', 0),
(8, 1, 16, 8000, '1800.0', 'L', '2014-04-19 21:00:14', 0),
(9, 2, 16, 6675, '1800.0', 'L', '2014-04-19 21:01:37', 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `challenge`
--

INSERT INTO `challenge` (`Id`, `Name`, `Month`, `Year`, `Type`, `Description`, `Distance`, `Time`) VALUES
(16, '30 minutes, no restriction', 6, 2014, 'T', 'A KK', 0, '1800.0');

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
