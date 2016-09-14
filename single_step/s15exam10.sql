-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: srv01.keaweb.dk:3306
-- Generation Time: Jun 05, 2015 at 02:08 AM
-- Server version: 5.5.33
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `s15exam10`
--

-- --------------------------------------------------------

--
-- Table structure for table `singlestep_gallery`
--

CREATE TABLE IF NOT EXISTS `singlestep_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8_bin NOT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `location` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=22 ;

--
-- Dumping data for table `singlestep_gallery`
--

INSERT INTO `singlestep_gallery` (`id`, `image`, `title`, `location`, `description`) VALUES
(10, 'images/gallery_sunset.jpg', 'Colorful sunset', 'Adriatic', 'Integer et porta tortor, non suscipit quam. In malesuada diam non erat euismod vehicula. Sed sit amet eros sollicitudin, mattis ut, efficitur neque.'),
(11, 'images/gallery_dubrovnik.jpg', 'Evening on the walls', 'Dubrovnik', 'Integer et porta tortor, non suscipit quam. In malesuada diam non erat euismod vehicula. Sed sit amet eros sollicitudin, mattis ut, efficitur neque.'),
(12, 'images/gallery_dubrovniksunset.jpg', 'Colorful skies', 'Dubrovnik', 'icula. Sed sit amet eros sollicitudin, mattis ut, efficitur neque.'),
(13, 'images/gallery_vestibul.jpg', 'Klapa Vestibul', 'Split', 'Traditional a capella singing in Dalmatia, performed by klapa Vestibul.'),
(14, 'images/gallery_sibenik.jpg', 'Rosetta', 'Sibenik', 'Qui ut nihil decore probatus, mundi conceptam philosophia ex pro, est detraxit principes gubergren id. Eum eu saperet theophrastus, sea no dolorum argumentum.'),
(15, 'images/gallery_dinner.jpg', 'Cosy dinner spot', 'Dubrovnik', 'Integer et porta tortor, non suscipit quam. In malesuada diam non erat euismod vehicula. Sed sit amet eros sollicitudin, mattis ut, efficitur neque.');

-- --------------------------------------------------------

--
-- Table structure for table `singlestep_postcards`
--

CREATE TABLE IF NOT EXISTS `singlestep_postcards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL,
  `caption_text` varchar(255) NOT NULL,
  `caption_position` varchar(255) NOT NULL,
  `caption_font` varchar(100) NOT NULL,
  `caption_font_color` varchar(7) NOT NULL,
  `border_type` varchar(10) NOT NULL,
  `border_color` varchar(7) NOT NULL,
  `message` varchar(255) NOT NULL,
  `signature` varchar(50) NOT NULL,
  `address1` varchar(50) NOT NULL,
  `address2` varchar(50) NOT NULL,
  `address3` varchar(50) NOT NULL,
  `message_font` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `singlestep_postcards`
--

INSERT INTO `singlestep_postcards` (`id`, `image`, `caption_text`, `caption_position`, `caption_font`, `caption_font_color`, `border_type`, `border_color`, `message`, `signature`, `address1`, `address2`, `address3`, `message_font`) VALUES
(1, 'pc_image_kornati', 'caption', 'caption_lower_left', 'font_geomanist_book', '#7afa5b', '0.5em', '#eb4674', 'message', 'adad', '1', '2', '3', 'architects_daughter'),
(2, 'pc_image_dubrovnik', 'caption', 'caption_lower_left', 'font_geomanist_ultra', '#54ecff', '0.5em', '#eb4674', 'message', 'adad', '1', '2', '3', 'architects_daughter'),
(3, 'pc_image_kornati', 'Hello from Kornati', 'caption_upper_right', 'font_geomanist_bold', '#b7ffff', '1em', '#012465', 'hello hello', 'dani', 'asdasd', 'asdasd', 'sadsad', 'walter_turncoat'),
(4, 'pc_image_vis', 'zfdgzdfg', 'caption_lower_right', 'font_geomanist_ultra', '#8080ff', '1em', '#ff80c0', 'oihgoihg', 'zfhdhfzd', 'zdfzdfh', 'zhfzdfh', 'zfhzdfh', 'architects_daughter'),
(5, 'pc_image_kornati', 'Hello there', 'caption_lower_right', 'font_geomanist_book', '#fffaf5', '1em', '#001024', 'This is nice', 'Hello', 'o', 'o', 'o', 'walter_turncoat'),
(6, 'pc_image_kornati', 'wetyuikolhgfd', 'caption_upper_left', 'font_geomanist_ultra', '#e10431', '1em', '#66a86f', 'qeyhjnhdf', 'zdhfhxf', 'xfxn', 'rhsrhs', 'rrrr', 'architects_daughter');

-- --------------------------------------------------------

--
-- Table structure for table `singlestep_profiles`
--

CREATE TABLE IF NOT EXISTS `singlestep_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `singlestep_profiles`
--

