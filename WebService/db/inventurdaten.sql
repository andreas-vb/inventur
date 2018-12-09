-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 28. Dez 2013 um 14:06
-- Server Version: 5.5.34
-- PHP-Version: 5.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `inventur`
--
CREATE DATABASE IF NOT EXISTS `inventur` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `inventur`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `inventur`
--

DROP TABLE IF EXISTS `inventur`;
CREATE TABLE IF NOT EXISTS `inventur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `notes` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `inventur_date` date NOT NULL,
  `farbe` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `bestand` int(11),
  `preis` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `inventur`
--


INSERT INTO `inventur` (`id`, `title`, `notes`, `inventur_date`, `farbe`, `bestand`, `preis`) VALUES
(1, 'Airbag', 'neu', '2018-03-10', 'schwarz', '4', '50'),
(2, 'Lenkrad', 'beheizt, Leder', '2018-03-11', 'braun', '5', '51'),
(3, 'Bremsscheibe', '2er Set vorne', '2018-03-12', 'keine', '6', '52'),
(4, 'Kofferraumabdeckung', 'für Kombi', '2018-03-13', 'hellgrau', '7', '53'),
(5, 'Motorhaube', 'unlackiert', '2018-03-14', 'keine', '8', '54');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
