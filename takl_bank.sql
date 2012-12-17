-- phpMyAdmin SQL Dump
-- version 3.5.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 17, 2012 at 08:00 PM
-- Server version: 5.5.25
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `takl_bank`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `id_account` bigint(20) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `id_owner` int(8) unsigned zerofill NOT NULL,
  `account-type` int(3) unsigned zerofill NOT NULL,
  `openingDate` date NOT NULL,
  `balance` bigint(20) NOT NULL,
  `overdraft` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_account`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id_account`, `id_owner`, `account-type`, `openingDate`, `balance`, `overdraft`) VALUES
(00000000000000000001, 00000001, 001, '2012-12-06', 874, 500),
(00000000000000000002, 00000001, 001, '2012-12-06', -475, 1500);

-- --------------------------------------------------------

--
-- Table structure for table `accounts-type`
--

CREATE TABLE IF NOT EXISTS `accounts-type` (
  `id_account-type` int(3) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `documentsRequired` text NOT NULL,
  PRIMARY KEY (`id_account-type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `accounts-type`
--

INSERT INTO `accounts-type` (`id_account-type`, `name`, `documentsRequired`) VALUES
(001, 'testAccountType', 'none');

-- --------------------------------------------------------

--
-- Table structure for table `agenda`
--

CREATE TABLE IF NOT EXISTS `agenda` (
  `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `id_client` int(8) unsigned zerofill NOT NULL,
  `id_employee` int(8) unsigned zerofill NOT NULL,
  `startingDate` date NOT NULL,
  `startingTime` time NOT NULL,
  `motif` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

--
-- Dumping data for table `agenda`
--

INSERT INTO `agenda` (`id`, `id_client`, `id_employee`, `startingDate`, `startingTime`, `motif`) VALUES
(00000000049, 00000001, 00000002, '2012-12-10', '08:00:00', 'openAccount-testAccountType'),
(00000000050, 00000001, 00000002, '2012-12-17', '08:00:00', 'openAccount-testAccountType'),
(00000000051, 00000001, 00000002, '2012-12-17', '10:00:00', 'openAccount-testAccountType'),
(00000000052, 00000001, 00000002, '2012-12-31', '08:00:00', 'openAccount-testAccountType'),
(00000000053, 00000001, 00000002, '2012-12-31', '11:00:00', 'openAccount-testAccountType'),
(00000000054, 00000001, 00000002, '2012-12-17', '13:00:00', 'openAccount-testAccountType'),
(00000000055, 00000001, 00000002, '2012-12-17', '14:00:00', 'openAccount-testAccountType'),
(00000000056, 00000001, 00000002, '2012-12-17', '16:00:00', 'openAccount-testAccountType'),
(00000000057, 00000001, 00000002, '2012-12-17', '09:00:00', 'openAccount-testAccountType'),
(00000000058, 00000001, 00000002, '2012-12-18', '08:00:00', 'openAccount-testAccountType'),
(00000000059, 00000001, 00000002, '2012-12-31', '09:00:00', 'openAccount-testAccountType'),
(00000000060, 00000001, 00000009, '2012-12-18', '08:00:00', 'openAccount-testAccountType'),
(00000000061, 00000001, 00000009, '2012-12-17', '09:00:00', 'openAccount-testAccountType'),
(00000000062, 00000001, 00000009, '2012-12-18', '09:00:00', 'openAccount-testAccountType');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id_client` int(8) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `id_employee` int(8) unsigned zerofill NOT NULL,
  `lastName` varchar(40) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `secondName` varchar(30) NOT NULL,
  `thirdName` varchar(30) NOT NULL,
  `birthDate` date NOT NULL,
  `gender` char(1) NOT NULL,
  `job` varchar(30) NOT NULL,
  `civilStatus` varchar(2) NOT NULL,
  `address_location` varchar(255) NOT NULL,
  `address_city` varchar(255) NOT NULL,
  `address_zipcode` varchar(10) NOT NULL,
  `address_state` varchar(100) NOT NULL,
  `phone_home` varchar(20) NOT NULL,
  `phone_mobile` varchar(20) NOT NULL,
  `email` varchar(254) NOT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id_client`, `id_employee`, `lastName`, `firstName`, `secondName`, `thirdName`, `birthDate`, `gender`, `job`, `civilStatus`, `address_location`, `address_city`, `address_zipcode`, `address_state`, `phone_home`, `phone_mobile`, `email`) VALUES
(00000001, 00000001, 'efze', 'azdf', 'azds', 'yuiop', '1912-11-10', 'm', 'none', 's', '56 azertyui', 'qsdfgh', '34567', 'sdfghjkk', '0987654321', '0687654321', 'azert.zert@dfghjkl.com'),
(00000002, 00000001, 'ghjk', 'qsdfg', 'wxcvb', 'yuiop', '1912-11-10', 'm', 'none', 's', '56 azertyui', 'qsdfgh', '34567', 'sdfghjkk', '255', '255', 'azert.zert@dfghjkl.com');

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE IF NOT EXISTS `contracts` (
  `id_contract` bigint(20) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `id_owner` int(8) unsigned zerofill NOT NULL,
  `contract-type` int(3) unsigned zerofill NOT NULL,
  `openingDate` date NOT NULL,
  PRIMARY KEY (`id_contract`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `contracts`
--

INSERT INTO `contracts` (`id_contract`, `id_owner`, `contract-type`, `openingDate`) VALUES
(00000000000000000001, 00000001, 001, '2012-12-06'),
(00000000000000000002, 00000001, 001, '2012-12-06');

-- --------------------------------------------------------

--
-- Table structure for table `contracts-type`
--

CREATE TABLE IF NOT EXISTS `contracts-type` (
  `id_contract-type` int(3) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `monthlyCost` int(10) unsigned NOT NULL,
  `documentsRequired` text NOT NULL,
  PRIMARY KEY (`id_contract-type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `contracts-type`
--

INSERT INTO `contracts-type` (`id_contract-type`, `name`, `monthlyCost`, `documentsRequired`) VALUES
(001, 'test', 200, 'none');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `id_employee` int(8) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `login` varchar(71) NOT NULL,
  `hPasswd` varchar(255) NOT NULL,
  `category` varchar(1) NOT NULL,
  `lastName` varchar(40) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  PRIMARY KEY (`id_employee`),
  KEY `name` (`lastName`,`firstName`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id_employee`, `login`, `hPasswd`, `category`, `lastName`, `firstName`) VALUES
(00000001, 'lavie.alexis', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'D', 'Lavie', 'Alexis'),
(00000002, 'kolubako.tennessy', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'C', 'Kolubako', 'Tennessy'),
(00000008, 'operiol-gerbal.nicolas', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'A', 'Operiol-Gerbal', 'Nicolas'),
(00000009, 'wijkhuisen.chloe', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'C', 'Wijkhuisen', 'ChloÃ©'),
(00000010, 'fiaud.nicolas', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'C', 'Fiaud', 'Nicolas'),
(00000011, 'boufatah.amine', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'A', 'Amine', 'Boufatah');

-- --------------------------------------------------------

--
-- Table structure for table `unavailability`
--

CREATE TABLE IF NOT EXISTS `unavailability` (
  `id` int(8) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `id_employee` int(8) unsigned zerofill NOT NULL,
  `startingDate` date NOT NULL,
  `starting_time` time NOT NULL,
  `ending_time` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `unavailability`
--

INSERT INTO `unavailability` (`id`, `id_employee`, `startingDate`, `starting_time`, `ending_time`) VALUES
(00000012, 00000002, '2012-12-17', '09:00:00', '10:00:00'),
(00000013, 00000002, '2012-12-24', '08:00:00', '09:00:00'),
(00000014, 00000002, '2012-12-24', '09:00:00', '10:00:00'),
(00000015, 00000002, '2012-12-24', '10:00:00', '11:00:00'),
(00000016, 00000002, '2012-12-31', '10:00:00', '11:00:00'),
(00000017, 00000002, '2012-12-31', '13:00:00', '14:00:00'),
(00000018, 00000002, '2012-12-17', '15:00:00', '16:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
