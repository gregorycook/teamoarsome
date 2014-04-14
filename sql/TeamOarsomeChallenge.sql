-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 13, 2014 at 10:19 PM
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attempt`
--


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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `challenge`
--

INSERT INTO `challenge` (`Id`, `Name`, `Month`, `Year`, `Type`, `Description`, `Distance`, `Time`) VALUES
(2, '5K', 5, 2014, 'D', 'A 5K', 5000, '0.0');

-- --------------------------------------------------------

--
-- Table structure for table `current`
--

DROP TABLE IF EXISTS `current`;
CREATE TABLE `current` (
  `ChallengeId` int(11) NOT NULL,
  `StartActive` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `EndActive` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ChallengeId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `current`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
