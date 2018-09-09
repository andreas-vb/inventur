-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 29. Sep 2013 um 10:57
-- Server Version: 5.5.16
-- PHP-Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `todolist`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `todo`
--

CREATE TABLE IF NOT EXISTS `todo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `notes` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `created_date` date NOT NULL,
  `due_date` date NOT NULL,
  `author` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `todo`
--

INSERT INTO `todo` (`id`, `title`, `notes`, `created_date`, `due_date`, `author`) VALUES
(1, 'Dies', 'Dies ist noch zu tun', '2018-04-08', '2018-10-04', 'Marc'),
(2, 'Das', 'Das ist noch zu tun', '2018-04-08', '2018-11-17', 'Patric'),
(3, 'Jenes', 'Jenes ist noch zu tun', '2018-04-08', '2018-12-21', 'Marc'),
(4, 'Darüber hinaus noch etwas', 'Darüber hinaus ist noch etwas zu tun', '2018-04-08', '2018-10-03', 'Marc'),
(5, 'Auch das noch', 'Auch das ist noch zu tun', '2018-04-08', '2018-08-03', 'Sebastian'),
(6, 'Noch mehr', 'Noch mehr ist zu tun', '2018-04-08', '2018-10-23', 'Sebastian'),
(7, 'Hier das noch <besonders wichtig>', 'Hier das ist noch zu tun', '2018-04-08', '2018-10-10', 'Marc');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
