-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Jun 11, 2016 at 04:28 PM
-- Server version: 5.5.38
-- PHP Version: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sushi_norregade`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE `bookings` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(300) DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  `number_guests` tinyint(2) DEFAULT NULL,
  `time_booking` datetime DEFAULT NULL,
  `id_table` int(11) DEFAULT NULL,
  `observations` text
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `name`, `email`, `phone`, `number_guests`, `time_booking`, `id_table`, `observations`) VALUES
(1, 'nadia', 'nadia@nadia.com', 123456, 2, '2016-06-14 17:30:00', 32, ''),
(2, 'Waiter Reservation', '', 0, 1, '2016-06-11 14:41:37', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL DEFAULT '0',
  `name_dk` varchar(45) DEFAULT NULL,
  `name_en` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name_dk`, `name_en`) VALUES
(1, 'Forretter', 'Starters'),
(2, 'Salater', 'Salads'),
(9, 'Kaburi', 'Topped maki'),
(10, 'Rispapir Ruller', 'Ricepaper rolls'),
(11, 'Uramaki', 'Medium Maki - Inside out'),
(12, 'Stor maki - Inside out', 'Medium maki - Inside out'),
(13, 'Stor maki', 'Big maki');

-- --------------------------------------------------------

--
-- Table structure for table `food_items`
--

DROP TABLE IF EXISTS `food_items`;
CREATE TABLE `food_items` (
`id` int(11) NOT NULL,
  `name_dk` varchar(45) DEFAULT NULL,
  `name_en` varchar(45) DEFAULT NULL,
  `ingredients_dk` text,
  `ingredients_en` text,
  `price` double(5,2) DEFAULT NULL,
  `image` char(32) DEFAULT NULL,
  `quantity` tinyint(3) DEFAULT '0',
  `id_category` tinyint(4) NOT NULL,
  `in_stock` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `food_items`
--

INSERT INTO `food_items` (`id`, `name_dk`, `name_en`, `ingredients_dk`, `ingredients_en`, `price`, `image`, `quantity`, `id_category`, `in_stock`) VALUES
(1, 'Miso suppe', 'Miso soup', 'Tang, tofu, springløg', 'Seaweed, tofu, spring onion', 30.00, 'IMG_8471.jpg', 0, 1, 1),
(2, 'Tang Salat', 'Tang Salad', 'Japansk tangsalat med sesam og chili', 'Japanese seaweed salad with sesame and chili', 45.00, 'IMG_8468.jpg', 0, 1, 1),
(3, 'Edamame', '', 'Varme soya bønner', 'Warm soya beans', 35.00, 'IMG_8465.jpg', 0, 1, 1),
(4, 'Spicy Edamame', '', 'Varme soya bønner med stærk chili sauce', 'Warm soya beans with spicy chili sauce', 45.00, 'IMG_0180.jpg', 0, 1, 1),
(5, 'Gai satay', '', 'Marineret kyllingekød på grillspyd med jordnøddesauce', 'Marinated chicken on grill spear with peanuts sauce', 49.00, 'IMG_8525.jpg', 2, 1, 1),
(6, 'Forårsruller', 'Spring rolls', 'Kylling, jordnødder, glasnudler, grøntsager med sød chili sauce', 'Chicken, peanuts, noodles, vegetables with sweet chili sauce', 49.00, 'IMG_8518.jpg', 2, 1, 1),
(7, 'Ebi Furai', '', 'Dybtstegte rejer med japansk raps med tonkatzu sauce', 'Deep fried shrimps with Japanese rape with tonkatzu sauce', 59.00, 'IMG_8507.jpg', 2, 1, 1),
(8, 'Hvidkål Salat', 'Cabbage salad', '', '', 30.00, 'IMG_0172.jpg', 0, 1, 1),
(9, 'Krebsehaler Salat', 'Crayfish tails salad', 'Salat mix med krebsehaler, avocado, agurk, tomat og dressing', 'Mixed salad with crayfish tails, avocado, cucumber, tomato and dressing', 75.00, 'IMG_6138.jpg', 0, 2, 1),
(10, 'Laks Tataki Salat', 'Salmon Tataki Salad', 'Salat mix med laks tataki, avocado, agurk, tomat og dressing', 'Mixed salad with salmon tataki, avocado, cucumber, tomato and dressing', 75.00, 'IMG_6162.jpg', 0, 2, 1),
(11, 'Tun Tataki Salat', 'Tuna Tataki Salad', 'Salat mix med tun tataki, avocado, agurk, tomat og dressing', 'Mixed salad with tuna tataki, avocado, cucumber, tomato and dressing', 85.00, 'IMG_6183.jpg', 0, 2, 1),
(12, 'Rainbow Rolls', '', 'Crabsticks, avocado, agurk toppet m. laks, tun, rejer, kingfish, avocado', 'Crabsticks, avocado, cucumber topped w. salmon, tuna, prawns, kingfish, avocado', 120.00, 'IMG_1018.jpg', 8, 9, 1),
(13, 'Ebi Tempura Rolls', '', 'Stegte rejser, avocado, spicy sauce toppet m. tun', 'Fried shrimps, avocado spicy sauce topped w. tuna', 110.00, 'IMG_1021.jpg', 8, 9, 1),
(14, 'Ebi Furai Rolls', '', 'Dybstegte rejer, rucola salat toppet m. avocado og sesam', 'Shrimps, rucola salad topped w. avocado and sesame', 110.00, 'IMG_1004.jpg', 8, 9, 1),
(15, 'Kaburi Avocado Rolls', '', 'Stegt tun, basilikum, spicy sauce toppet m. avocado', 'Fried tuna, basil, spicy sauce topped w. avocado', 110.00, 'IMG_1028.jpg', 8, 9, 1),
(16, 'Kaburi Shake Rolls', '', 'Laks, avocado toppet m. laks', 'Salmon, avocado topped w. salmon', 110.00, 'IMG_1025.jpg', 8, 9, 1),
(17, 'Kaburi Magoru Rolls', '', 'Tun, avocado toppet m. tun', 'Tuna, avocado topped w. tuna', 110.00, 'IMG_1013.jpg', 8, 9, 1),
(18, 'Kaburi Vegetar Rolls', '', 'Avocado, agurk, tofu toppet m. avocado', 'Avocado cucumber, tofu topped w. avocado', 110.00, 'IMG_1045.jpg', 8, 9, 1),
(19, 'Rispapir Rulle - Laks', 'Ricepaper Rolls - Salmon', 'Rispapir, laks, salat, avocado, agurk, basilikum, koriander, goma dressing', 'Ricepaper, salmon, salad, avocado, cucumber, basil, coriander, goma dressing', 75.00, 'IMG_7989.jpg', 6, 10, 1),
(20, 'Rispapir Rulle - Tun', 'Ricepaper Rolls - Tuna', 'Rispapir, tun, salat, avocado, agurk , basilikum, koriander, goma dressing', 'Ricepaper, tuna, salad, avocado, cucumber, basil, coriander, goma dressing', 75.00, 'IMG_7989.jpg', 6, 10, 1),
(21, 'Rispapir Rulle - Kylling', 'Ricepaper Rolls - Chicken', 'Rispapir, kylling, salat, avocado, agurk, basilikum, koriander, goma dressing', 'Ricepaper, chicken, salad, avocado, cucumber, basil, coriander, goma dressing', 75.00, 'IMG_8001.jpg', 6, 10, 1),
(22, 'Rispapir Rulle - Krebsehaler', 'Ricepaper Rolls - Crabs', 'Rispapir, krebsehaler, agurk, salat, avocado, basilikum, koriander, goma dressing', 'Rispaper, crayfish tails, salad, avocado, cucumber, basil, coriander, goma dressing', 75.00, 'IMG_7989.jpg', 6, 10, 1),
(23, 'Rispapir Rulle - Ebi Furai ', 'Ricepaper Rolls - Ebi Furai ', 'Rispapir, dybstegte rejer, salat, avocado, agurk, basilikum, koriander, goma dressing', 'Ricepaper, fried shrimps, salad, avocado, cucumber, basil, Coriander, goma dressing', 75.00, 'IMG_8001.jpg', 6, 10, 1),
(24, 'Rispapir Rulle - Vegetar', 'Ricepaper Rolls - Vegetarian', 'Rispapir, salat, asparges, avocado, agurk, basilikum, koriander, goma dressing', 'Ricepaper, salad, asparagus, avocado, cucumber, basil, Coriander goma dressing', 70.00, 'IMG_8001.jpg', 6, 10, 1),
(25, 'Laks med hvidløg', 'Salmon with garlic', 'Laks, hvidløg, forårsløg', 'Salmon, garlic, spring onion', 60.00, 'IMG_1062.jpg', 8, 11, 1),
(26, 'Ebi Rolls', '', 'Rejer, avocado', 'Prawns, avocado', 60.00, 'IMG_1091.jpg', 8, 11, 1),
(27, 'Unagi Rolls', '', 'Grillet ål, avocado, unagi sauce', 'Grilled eel, avocado, unagi sauce', 75.00, 'IMG_1096.jpg', 8, 11, 1),
(28, 'Spicy Laks', 'Spicy Salmon', 'Laks, avocado, agurk, chili mayo', 'Salmon, avocado, cucumber, chili mayo', 65.00, 'IMG_1072.jpg', 8, 11, 1),
(29, 'Laks med avocado', 'Salmon with avocado', 'Laks, avocado', 'Salmon, avocado', 60.00, 'IMG_1103.jpg', 8, 11, 1),
(30, 'Spicy Tun', 'Spicy Tuna', 'Tun, forårsløg, agurk, spicy sauce', 'Tuna, spring onion, cucumber, spicy sauce', 60.00, 'IMG_1136.jpg', 8, 11, 1),
(31, 'Alaska', '', 'Laks, avocado, masagorogn', 'Salmon, avocado, masago roe', 65.00, 'IMG_1124.jpg', 8, 11, 1),
(32, 'Hamachi Rolls', '', 'Kingfish, forårsløg og tobikorogn', 'Kingfish, spring onion and tobiko roe', 65.00, 'IMG_1112.jpg', 8, 11, 1),
(33, 'Stegt Tun Inside-Out', 'Fried Tuna Inside-Out', 'Stegt tun, forårsløg, basilikum, spicy sauce', 'Fried tuna, spring onion, basil, spicy sauce', 60.00, 'IMG_1109.jpg', 8, 11, 1),
(34, 'Osaka Rolls', '', 'Kammusling, laks, masagorogn', 'Scallop, salmon, masago roe', 70.00, 'IMG_1114.jpg', 8, 11, 1),
(35, 'Tun med avocado', 'Tuna with avocado', 'Tun, avocado', 'Tuna, avocado', 60.00, 'IMG_1078.jpg', 8, 11, 1),
(36, 'San Francisco Rolls', '', 'Laks, flødeost, avocado, agurk, Sesam, lakesrogn', 'Salmon, avocado, cream cheese, cucumber, sesame, salmon roe', 70.00, 'IMG_1178.jpg', 8, 11, 1),
(37, 'Spicy Ebi Rolls', '', 'Rejer, avocado, agurk, chili mayo', 'Shrimps, avocado, cucumber, chili mayo', 60.00, 'IMG_1131.jpg', 8, 11, 1),
(38, 'Hawaii Rolls', '', 'Tun, avocado, teriyaki sauce, cashew nødder', 'Tuna, avocado, G teriyaki sauce, cashew nuts', 70.00, 'IMG_1169.jpg', 8, 11, 1),
(39, 'California', '', 'Crabstick, avocado, agurk, mayonnaise', 'Crabstick, avocado, Cucumber, mayonnaise', 75.00, 'IMG_0922.jpg', 5, 13, 1),
(40, 'Stor Laks', '', 'Laks, agurk, avocado', 'Salmon, cucumber, avocado', 77.00, 'IMG_0918.jpg', 5, 13, 1),
(41, 'Ebi Hot', '', 'Rejer, agurk, avocado, spicy sauce ', 'Prawns, cucumber, avocado, spicy sauce', 77.00, 'IMG_0927.jpg', 5, 13, 1),
(42, 'Nørregades Maki', '', 'Dybtstegte crabsticks, omelet, syltede kinaradiser', 'Deep fried crabsticks, omelette, Chinese radish', 80.00, 'IMG_0951.jpg', 5, 13, 1),
(43, 'Manhatten', '', 'Laks, agurk, salat, flødeost', 'Salmon, cucumber, cream cheese, salad', 77.00, 'IMG_0913.jpg', 5, 13, 1),
(44, 'California Inside Out', '', 'Crabsticks, agurk, avocado, omelet, mayonnaise', 'Crabsticks, cucumber, avocado, omelette, mayonnaise', 77.00, 'IMG_0976.jpg', 5, 12, 1),
(45, 'Crispy Ebi Inside Out', '', 'Dybstegte rejer, avocado, ruccola salat, forårsløg, spicy sauce', 'Deep fried shrimps avocado, ruccola salad, spring onion, spicy sauce', 85.00, 'IMG_0974.jpg', 5, 12, 1),
(46, 'Stor Tun - Inside Out', '', 'Tun, agurk, avocado', 'Tuna, cucumber, avocado', 77.00, 'IMG_0989.jpg', 5, 12, 1),
(47, 'Super California Inside Out', '', 'Krabsehaler, avocado, masagorogn, mayonnaise ', 'Crayfish tails, avocado, masago roe, mayonnaise', 85.00, 'IMG_0978.jpg', 5, 12, 1),
(48, 'Futomaki Inside Out', '', 'Agurk, avocado, masagorogn, crabstick, gulerødder, forårsløg, mayonnaise', 'Cucumber, avocado, masago roe, crabstick, carrots, spring onion, mayonnaise', 80.00, 'IMG_0999.jpg', 5, 12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
`id` int(11) NOT NULL,
  `id_table` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_all_you_can_eat` tinyint(1) NOT NULL DEFAULT '0',
  `comments` text,
  `status` varchar(10) NOT NULL DEFAULT 'ordered'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `id_table`, `created`, `is_all_you_can_eat`, `comments`, `status`) VALUES
(1, 1, '2016-06-10 20:37:47', 0, '', 'prepared');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
`id` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `id_food_item` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `name_dk` varchar(45) NOT NULL,
  `name_en` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `id_order`, `id_food_item`, `quantity`, `price`, `name_dk`, `name_en`) VALUES
(1, 1, 1, 2, 30, 'Miso suppe', 'Miso soup'),
(2, 1, 2, 3, 45, 'Tang Salat', 'Tang Salad');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_tables`
--

DROP TABLE IF EXISTS `restaurant_tables`;
CREATE TABLE `restaurant_tables` (
`id` int(11) NOT NULL,
  `number_people` tinyint(3) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `restaurant_tables`
--

INSERT INTO `restaurant_tables` (`id`, `number_people`) VALUES
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 4),
(17, 4),
(18, 2),
(19, 2),
(20, 2),
(21, 2),
(22, 2),
(23, 2),
(24, 2),
(25, 2),
(26, 2),
(27, 2),
(28, 2),
(29, 2),
(30, 2),
(31, 2),
(32, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sensitivities`
--

DROP TABLE IF EXISTS `sensitivities`;
CREATE TABLE `sensitivities` (
`id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sensitivities`
--

INSERT INTO `sensitivities` (`id`, `name`) VALUES
(1, 'lactose'),
(2, 'nuts');

-- --------------------------------------------------------

--
-- Table structure for table `sensitivities_food`
--

DROP TABLE IF EXISTS `sensitivities_food`;
CREATE TABLE `sensitivities_food` (
  `id_food` int(11) DEFAULT NULL,
  `id_sensitivity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sensitivities_food`
--

INSERT INTO `sensitivities_food` (`id_food`, `id_sensitivity`) VALUES
(5, 2),
(6, 2),
(36, 1),
(38, 1),
(43, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
`id` int(11) NOT NULL,
  `username` varchar(46) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(128) NOT NULL,
  `newsletter` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `newsletter`) VALUES
(1, 'nadia', 'nadia@nadia.com', '3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2', 0),
(2, 'cfilipe84@gmail.com', 'cfilipe84@gmail.com', '3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `waiter_calls`
--

DROP TABLE IF EXISTS `waiter_calls`;
CREATE TABLE `waiter_calls` (
`id` int(11) NOT NULL,
  `id_table` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `processed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `waiter_calls`
--

INSERT INTO `waiter_calls` (`id`, `id_table`, `created`, `processed`) VALUES
(1, 1, '2016-06-11 13:43:39', 1),
(2, 1, '2016-06-11 14:43:39', 1),
(3, 1, '2016-06-11 14:25:50', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `food_items`
--
ALTER TABLE `food_items`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_tables`
--
ALTER TABLE `restaurant_tables`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `sensitivities`
--
ALTER TABLE `sensitivities`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `waiter_calls`
--
ALTER TABLE `waiter_calls`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `food_items`
--
ALTER TABLE `food_items`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `restaurant_tables`
--
ALTER TABLE `restaurant_tables`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `sensitivities`
--
ALTER TABLE `sensitivities`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `waiter_calls`
--
ALTER TABLE `waiter_calls`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
