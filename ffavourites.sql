-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 16, 2011 at 11:14 PM
-- Server version: 5.5.9
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ffavourites`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

DROP TABLE IF EXISTS `bookmarks`;
CREATE TABLE `bookmarks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `url` varchar(256) DEFAULT NULL,
  `favourites` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `bookmarks`
--

INSERT INTO `bookmarks` VALUES(1, 'Ottawa (Kanata - OrlÃ©ans), Ontario - 7 Day Forecast - Environment Canada', 'http://www.weatheroffice.gc.ca/city/pages/on-118_metric_e.html', NULL);
INSERT INTO `bookmarks` VALUES(2, 'theTitle', 'http://theURL', NULL);
INSERT INTO `bookmarks` VALUES(3, 'the third bookmark', 'http://www.bookmarkland.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(128) DEFAULT NULL,
  `username` varchar(64) DEFAULT NULL,
  `salt` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` VALUES(1, '1d80cb301251237696d24c43df11eff261e5fb3ab4e4bd31a4eebbe0a562513e72111a57a218303d335ff5460d42a25ae226d1b5457dccaab0306d0bad954510', 'hot', 'c1fe14ef');

-- --------------------------------------------------------

--
-- Table structure for table `user_bookmarks`
--

DROP TABLE IF EXISTS `user_bookmarks`;
CREATE TABLE `user_bookmarks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bookmark_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `note` varchar(512) DEFAULT NULL,
  `favourite` bit(1) DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `bookmark_id` (`bookmark_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `user_bookmarks`
--

INSERT INTO `user_bookmarks` VALUES(5, 1, 1, 'hello world', '\0');
INSERT INTO `user_bookmarks` VALUES(8, 3, 1, NULL, '\0');
