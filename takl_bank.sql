-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Mar 04 Décembre 2012 à 20:54
-- Version du serveur: 5.5.28
-- Version de PHP: 5.3.10-1ubuntu3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `takl_bank`
--

-- --------------------------------------------------------

--
-- Structure de la table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `id_account` bigint(20) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `id_owner` int(8) unsigned zerofill NOT NULL,
  `account-type` int(3) unsigned zerofill NOT NULL,
  `openingDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `balance` bigint(20) NOT NULL,
  `overdraft` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_account`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `accounts-type`
--

CREATE TABLE IF NOT EXISTS `accounts-type` (
  `id_account-type` int(3) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `documentsRequired` text NOT NULL,
  PRIMARY KEY (`id_account-type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `agenda`
--

CREATE TABLE IF NOT EXISTS `agenda` (
  `trucàfaire` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`trucàfaire`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `clients`
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
  `phone_home` tinyint(20) unsigned NOT NULL,
  `phone_mobile` tinyint(20) unsigned NOT NULL,
  `email` varchar(254) NOT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `contracts`
--

CREATE TABLE IF NOT EXISTS `contracts` (
  `id_contract` bigint(20) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `id_owner` int(8) unsigned zerofill NOT NULL,
  `contract-type` int(3) unsigned zerofill NOT NULL,
  `openingDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_contract`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `contracts-type`
--

CREATE TABLE IF NOT EXISTS `contracts-type` (
  `id_contract-type` int(3) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `monthlyCost` int(10) unsigned NOT NULL,
  `documentsRequired` text NOT NULL,
  PRIMARY KEY (`id_contract-type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `employees`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `employees`
--

INSERT INTO `employees` (`id_employee`, `login`, `hPasswd`, `category`, `lastName`, `firstName`) VALUES
(00000001, 'lavie.alexis', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'D', 'Lavie', 'Alexis'),
(00000002, 'kolubako.tennessy', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'C', 'Kolubako', 'Tennessy'),
(00000003, 'lin.shunyan', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'A', 'Lin', 'Shunyan'),
(00000004, 'lin.shunyan', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'C', 'Lin', 'Shunyan'),
(00000005, 'lin.shunyan', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'A', 'Lin', 'Shunyan'),
(00000006, 'kolubako.tennessy', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'C', 'Kolubako', 'Tennessy'),
(00000007, 'kolubako.tennessy', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'C', 'Kolubako', 'Tennessy');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
