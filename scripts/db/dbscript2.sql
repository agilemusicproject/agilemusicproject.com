-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2014 at 04:49 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `amp`
--
CREATE DATABASE IF NOT EXISTS `amp` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `amp`;

-- --------------------------------------------------------

--
-- Table structure for table `band_members`
--

CREATE TABLE IF NOT EXISTS `band_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` tinytext NOT NULL,
  `last_name` tinytext NOT NULL,
  `roles` tinytext NOT NULL,
  `photo_filename` tinytext,
  `bio` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `band_members`
--

INSERT INTO `band_members` (`id`, `first_name`, `last_name`, `roles`, `photo_filename`, `bio`) VALUES
(1, 'Test', 'Jones', 'tester', NULL, NULL),
(2, 'Test2', 'Jane', 'tester2', NULL, 'This is just a test bio.');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
