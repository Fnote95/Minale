-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 10, 2020 at 05:58 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `res_automation`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) NOT NULL,
  `kit_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `category_ibfk_1` (`kit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `cat_name`, `kit_id`) VALUES
(30, 'pizza', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customize`
--

DROP TABLE IF EXISTS `customize`;
CREATE TABLE IF NOT EXISTS `customize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `composition` varchar(255) NOT NULL,
  `item_id` varchar(255) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customize`
--

INSERT INTO `customize` (`id`, `composition`, `item_id`, `order_id`) VALUES
(3, '[{\"comp\":\"beef\",\"quantity\":\"2\"},{\"comp\":\"cheese\",\"quantity\":\"2\"}]', '1', NULL),
(4, '[{\"comp\":\"beef\",\"quantity\":\"2\"},{\"comp\":\"cheese\",\"quantity\":\"2\"}]', '1', NULL),
(5, '[{\"comp\":\"beef\",\"quantity\":\"2\"},{\"comp\":\"cheese\",\"quantity\":\"2\"}]', '1', NULL),
(6, '[{\"comp\":\"beef\",\"quantity\":\"2\"},{\"comp\":\"cheese\",\"quantity\":\"2\"}]', '1', NULL),
(7, '[{\"comp\":\"beef\",\"quantity\":\"2\"},{\"comp\":\"cheese\",\"quantity\":\"2\"}]', '1', NULL),
(8, '[{\"comp\":\"beef\",\"quantity\":\"2\"},{\"comp\":\"cheese\",\"quantity\":\"2\"}]', '1', NULL),
(9, '[{\"comp\":\"beef\",\"quantity\":\"2\"},{\"comp\":\"cheese\",\"quantity\":\"2\"}]', '1', NULL),
(10, '[{\"comp\":\"beef\",\"quantity\":\"2\"},{\"comp\":\"cheese\",\"quantity\":\"2\"}]', '1', NULL),
(11, '[{\"comp\":\"beef\",\"quantity\":\"2\"},{\"comp\":\"cheese\",\"quantity\":\"2\"}]', '1', NULL),
(12, '[{\"comp\":\"beef\",\"quantity\":\"8\"},{\"comp\":\"cheese\",\"quantity\":\"5\"}]', '1', NULL),
(13, '[{\"comp\":\"beef\",\"quantity\":\"5\"},{\"comp\":\"cheese\",\"quantity\":\"8\"}]', '1', NULL),
(14, '[{\"comp\":\"beef\",\"quantity\":\"2\"},{\"comp\":\"cheese\",\"quantity\":\"6\"}]', '1', NULL),
(15, '[{\"comp\":\"beef\",\"quantity\":\"2\"},{\"comp\":\"cheese\",\"quantity\":\"4\"}]', '1', NULL),
(16, '[{\"comp\":\"beef\",\"quantity\":\"2\"},{\"comp\":\"cheese\",\"quantity\":\"6\"}]', '1', NULL),
(17, '[{\"comp\":\"beef\",\"quantity\":\"2\"},{\"comp\":\"cheese\",\"quantity\":\"7\"}]', '1', NULL),
(18, '[{\"comp\":\"beef\",\"quantity\":\"2\"},{\"comp\":\"cheese\",\"quantity\":\"2\"}]', '1', NULL),
(19, '[{\"comp\":\"beef\",\"quantity\":\"2\"},{\"comp\":\"cheese\",\"quantity\":\"5\"}]', '1', NULL),
(20, '[{\"comp\":\"beef\",\"quantity\":\"2\"},{\"comp\":\"cheese\",\"quantity\":\"2\"}]', '1', NULL),
(21, '[{\"comp\":\"beef\",\"quantity\":\"2\"},{\"comp\":\"cheese\",\"quantity\":\"8\"}]', '1', NULL),
(22, '[{\"comp\":\"beef\",\"quantity\":\"6\"},{\"comp\":\"cheese\",\"quantity\":\"89\"}]', '1', NULL),
(23, '[{\"comp\":\"beef\",\"quantity\":\"2\"},{\"comp\":\"cheese\",\"quantity\":\"2\"}]', '1', NULL),
(24, '[{\"comp\":\"beef\",\"quantity\":\"2\"},{\"comp\":\"cheese\",\"quantity\":\"2\"}]', '1', NULL),
(25, '[{\"comp\":\"beef\",\"quantity\":\"3\"},{\"comp\":\"cheese\",\"quantity\":\"2\"}]', '1', NULL),
(26, '[{\"comp\":\"beef\",\"quantity\":\"3\"},{\"comp\":\"cheese\",\"quantity\":\"2\"}]', '1', NULL),
(27, '[{\"comp\":\"beef\",\"quantity\":\"3\"},{\"comp\":\"cheese\",\"quantity\":\"2\"}]', '1', NULL),
(28, '[{\"comp\":\"beef\",\"quantity\":\"5\"},{\"comp\":\"cheese\",\"quantity\":\"2\"}]', '2', NULL),
(29, '[{\"comp\":\"beef\",\"quantity\":\"2\"},{\"comp\":\"cheese\",\"quantity\":\"2\"}]', '1', NULL),
(30, '[{\"comp\":\"beef\",\"quantity\":\"1\"},{\"comp\":\"cheese\",\"quantity\":\"2\"}]', '1', NULL),
(31, '[{\"comp\":\"sdfasdf\",\"quantity\":\"4\"}]', '4', NULL),
(32, '[{\"comp\":\"beef\",\"quantity\":\"3\"},{\"comp\":\"cheese\",\"quantity\":\"4\"}]', '1', NULL),
(33, '[{\"comp\":\"cheese\",\"quantity\":\"4\"},{\"comp\":\"beef\",\"quantity\":\"2\"}]', '7', NULL),
(34, '[{\"comp\":\"cheese\",\"quantity\":\"2\"},{\"comp\":\"beef\",\"quantity\":\"2\"}]', '7', NULL),
(35, '[{\"comp\":\"beef\",\"quantity\":\"3\"},{\"comp\":\"cheese\",\"quantity\":\"2\"}]', '1', NULL),
(36, '[{\"comp\":\"beef\",\"quantity\":\"3\"},{\"comp\":\"cheese\",\"quantity\":\"3\"}]', '2', NULL),
(37, '[{\"comp\":\"beef\",\"quantity\":\"3\"},{\"comp\":\"cheese\",\"quantity\":\"2\"}]', '2', NULL),
(38, '[{\"comp\":\"beef\",\"quantity\":\"2\"},{\"comp\":\"cheese\",\"quantity\":\"2\"}]', '1', NULL),
(39, '[{\"comp\":\"beef\",\"quantity\":\"2\"},{\"comp\":\"cheese\",\"quantity\":\"2\"}]', '1', NULL),
(40, '[{\"comp\":\"beef\",\"quantity\":\"2\"},{\"comp\":\"cheese\",\"quantity\":\"3\"}]', '1', NULL),
(41, '[{\"comp\":\"beef\",\"quantity\":\"4\"},{\"comp\":\"cheese\",\"quantity\":\"2\"}]', '2', NULL),
(42, '[{\"comp\":\"beef\",\"quantity\":\"2\"},{\"comp\":\"cheese\",\"quantity\":\"2\"}]', '1', NULL),
(43, '[{\"comp\":\"rice\",\"quantity\":\"1\"},{\"comp\":\"chicken\",\"quantity\":\"3\"},{\"comp\":\"chicken\",\"quantity\":\"3\"},{\"comp\":\"chicken\",\"quantity\":\"3\"}]', '8', NULL),
(44, '[{\"comp\":\"beef\",\"quantity\":\"3\"},{\"comp\":\"cheese\",\"quantity\":\"1\"}]', '1', NULL),
(45, '[{\"comp\":\"beef\",\"quantity\":\"3\"},{\"comp\":\"cheese\",\"quantity\":\"3\"}]', '2', NULL),
(46, '[{\"comp\":\"rice\",\"quantity\":\"3\"},{\"comp\":\"chicken\",\"quantity\":\"4\"},{\"comp\":\"chicken\",\"quantity\":\"4\"},{\"comp\":\"chicken\",\"quantity\":\"4\"}]', '8', NULL),
(47, '[{\"comp\":\"cheese\",\"quantity\":\"3\"},{\"comp\":\"beef\",\"quantity\":\"1\"}]', '7', NULL),
(48, '[{\"comp\":\"rice\",\"quantity\":\"4\"},{\"comp\":\"chicken\",\"quantity\":\"4\"},{\"comp\":\"chicken\",\"quantity\":\"4\"},{\"comp\":\"chicken\",\"quantity\":\"4\"}]', '8', NULL),
(49, '[{\"comp\":\"cheese\",\"quantity\":\"3\"},{\"comp\":\"beef\",\"quantity\":\"2\"}]', '7', NULL),
(50, '[{\"comp\":\"cheese\",\"quantity\":\"2\"},{\"comp\":\"beef\",\"quantity\":\"1\"}]', '7', NULL),
(51, '[{\"comp\":\"beef\",\"quantity\":\"2\"},{\"comp\":\"cheese\",\"quantity\":\"2\"}]', '1', NULL),
(52, '[{\"comp\":\"beef\",\"quantity\":\"3\"},{\"comp\":\"cheese\",\"quantity\":\"2\"}]', '1', NULL),
(53, '[{\"comp\":\"cheese\",\"quantity\":\"3\"},{\"comp\":\"beef\",\"quantity\":\"1\"}]', '7', NULL),
(55, '[{\"comp\":\"rice\",\"quantity\":\"2\"},{\"comp\":\"chicken\",\"quantity\":\"4\"},{\"comp\":\"chicken\",\"quantity\":\"4\"},{\"comp\":\"chicken\",\"quantity\":\"4\"}]', '8', NULL),
(56, '[{\"comp\":\"rice\",\"quantity\":\"2\"},{\"comp\":\"chicken\",\"quantity\":\"4\"},{\"comp\":\"chicken\",\"quantity\":\"4\"},{\"comp\":\"chicken\",\"quantity\":\"4\"}]', '8', NULL),
(57, '[{\"comp\":\"beef\",\"quantity\":\"2\"},{\"comp\":\"cheese \",\"quantity\":null}]', '1', NULL),
(63, '[{\"comp\":\"beef\",\"quantity\":\"2\"},{\"comp\":\"cheese \",\"quantity\":null}]', '1', NULL),
(72, '[{\"comp\":\"beef\",\"quantity\":\"2\"},{\"comp\":\"cheese\",\"quantity\":\"3\"}]', '1', NULL),
(73, '[{\"comp\":\"beef\",\"quantity\":\"2\"},{\"comp\":\"cheese\",\"quantity\":\"3\"}]', '1', NULL),
(74, '[{\"comp\":\"beef\",\"quantity\":\"1\"},{\"comp\":\"cheese\",\"quantity\":\"1\"}]', '9', NULL),
(79, '[{\"comp\":\"beef\",\"quantity\":\"3\"},{\"comp\":\"cheese\",\"quantity\":\"3\"}]', '1', NULL),
(80, '[{\"comp\":\"beef\",\"quantity\":\"3\"},{\"comp\":\"cheese\",\"quantity\":\"3\"}]', '1', NULL),
(81, '[{\"comp\":\"beef\",\"quantity\":\"3\"},{\"comp\":\"cheese\",\"quantity\":\"3\"}]', '1', NULL),
(86, '[{\"comp\":\"asdfa\",\"needed\":\"true\"},{\"comp\":\"adsf\",\"needed\":\"false\"},{\"comp\":\"asdf\",\"needed\":\"true\"}]', '18', NULL),
(87, '[{\"comp\":\"asdfa\",\"needed\":\"false\"},{\"comp\":\"adsf\",\"needed\":\"false\"},{\"comp\":\"asdf\",\"needed\":\"true\"}]', '18', NULL),
(88, '[{\"comp\":\"asdfa\",\"needed\":\"true\"},{\"comp\":\"adsf\",\"needed\":\"false\"},{\"comp\":\"asdf\",\"needed\":\"true\"}]', '18', NULL),
(92, 'asdfasdfasdffffffffff', '17', NULL),
(103, '[{\"comp\":\"sdfasdf\",\"quantity\":\"1\"}]', '4', NULL),
(110, '[{\"comp\":\"asdfa\",\"needed\":\"false\"},{\"comp\":\"adsf\",\"needed\":\"false\"},{\"comp\":\"asdf\",\"needed\":\"false\"}]', '18', NULL),
(111, '[{\"comp\":\"cheese\",\"quantity\":\"2\"},{\"comp\":\"beef\",\"quantity\":\"1\"}]', '7', NULL),
(112, '[{\"comp\":\"asdfa\",\"needed\":\"false\"},{\"comp\":\"adsf\",\"needed\":\"false\"},{\"comp\":\"asdf\",\"needed\":\"false\"}]', '18', NULL),
(116, '[{\"comp\":\"cheese\",\"quantity\":\"6\"},{\"comp\":\"beef\",\"quantity\":\"5\"}]', '9', NULL),
(117, '[{\"comp\":\"sdfasdf\",\"quantity\":\"4\"}]', '4', NULL),
(118, '[{\"comp\":\"Chicken\",\"quantity\":\"3\"},{\"comp\":\"sauce\",\"quantity\":\"2\"}]', '14', NULL),
(119, '[{\"comp\":\"chicken\",\"quantity\":\"2\"},{\"comp\":\"stuffing\",\"quantity\":\"2\"}]', '13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kitchens`
--

DROP TABLE IF EXISTS `kitchens`;
CREATE TABLE IF NOT EXISTS `kitchens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kit_name` varchar(255) NOT NULL,
  `admin` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `admin` (`admin`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kitchens`
--

INSERT INTO `kitchens` (`id`, `kit_name`, `admin`) VALUES
(1, 'pizzaaaa', 7),
(2, 'pastry', 2),
(3, 'main', 3);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) NOT NULL,
  `item_pic` varchar(255) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `ing_type` tinyint(4) NOT NULL,
  `composition` text NOT NULL,
  `price` int(11) NOT NULL,
  `featured` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `cat_id` (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `item_name`, `item_pic`, `cat_id`, `ing_type`, `composition`, `price`, `featured`) VALUES
(25, 'Margherita', 'images/item_image/26645f4f46137642dc3f7aa2e0287602.jpg', 30, 2, '[{\"comp\":\"tomato sauce\",\"quantity\":\"NA\"},{\"comp\":\"mozzarella\",\"quantity\":\"NA\"}]', 110, 1),
(26, 'beef ham pizza', 'images/item_image/1ba022ff9d6a639027294e32f81d2dab.jpg', 30, 2, '[{\"comp\":\"beef\",\"quantity\":\"NA\"},{\"comp\":\"ham\",\"quantity\":\"NA\"},{\"comp\":\"tomato sauce\",\"quantity\":\"NA\"},{\"comp\":\"mozzarella\",\"quantity\":\"NA\"}]', 180, 1),
(27, 'Mushroom beef olive', 'images/item_image/f213c827608cd0ad3b9468be5396ab1c.jpg', 30, 2, '[{\"comp\":\"mushroom\",\"quantity\":\"NA\"},{\"comp\":\"beef\",\"quantity\":\"NA\"},{\"comp\":\"olive\",\"quantity\":\"NA\"},{\"comp\":\"tomato sauce\",\"quantity\":\"NA\"},{\"comp\":\"mozzarella\",\"quantity\":\"NA\"}]', 180, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `items` varchar(10000) NOT NULL DEFAULT '""',
  `takeout_items` varchar(255) NOT NULL DEFAULT '""',
  `order_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_status` tinyint(4) NOT NULL DEFAULT '3',
  `takeout_status` tinyint(4) NOT NULL DEFAULT '3',
  `session_id` varchar(255) NOT NULL,
  `table_no` int(11) NOT NULL DEFAULT '0',
  `wait_time` varchar(1255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `items`, `takeout_items`, `order_date`, `order_status`, `takeout_status`, `session_id`, `table_no`, `wait_time`) VALUES
(1, '[{\"item_id\":\"25\",\"quantity\":\"3\",\"custom_id\":\"none\",\"mini_status\":0}]', '\"\"', '2019-11-14 09:14:52', 2, 2, 'ifs26k5m3318bp16vojl5qim1q', 12, '0'),
(2, '[{\"item_id\":\"25\",\"quantity\":\"1\",\"custom_id\":\"none\",\"mini_status\":0}]', '\"\"', '2019-11-14 09:23:14', 2, 2, 'ifs26k5m3318bp16vojl5qim1q', 12, '0'),
(3, '[{\"item_id\":\"26\",\"quantity\":\"1\",\"custom_id\":\"none\",\"mini_status\":0}]', '\"\"', '2019-11-14 09:26:09', 2, 2, 'ifs26k5m3318bp16vojl5qim1q', 10, '0'),
(4, '[{\"item_id\":\"26\",\"quantity\":\"2\",\"custom_id\":\"none\",\"mini_status\":0}]', '\"\"', '2019-11-14 09:27:43', 2, 2, 'ifs26k5m3318bp16vojl5qim1q', 15, '0'),
(5, '[{\"item_id\":\"26\",\"quantity\":\"2\",\"custom_id\":\"none\",\"mini_status\":0}]', '\"\"', '2019-11-14 09:44:28', 1, 3, 'k16gsmd7og2khp1ntn0os0ilf5', 13, '0'),
(6, '[{\"item_id\":\"27\",\"quantity\":\"1\",\"custom_id\":\"none\",\"mini_status\":0}]', '\"\"', '2019-11-14 09:47:19', 1, 3, 'k16gsmd7og2khp1ntn0os0ilf5', 15, '0'),
(7, '[{\"item_id\":\"26\",\"quantity\":\"2\",\"custom_id\":\"none\",\"mini_status\":0}]', '\"\"', '2019-11-14 09:51:30', 1, 3, 'k16gsmd7og2khp1ntn0os0ilf5', 10, '0'),
(8, '[{\"item_id\":\"25\",\"quantity\":\"1\",\"custom_id\":\"none\",\"mini_status\":0}]', '\"\"', '2019-11-15 10:17:15', 1, 3, 'jm93234oqjnid5ui79abeoh9af', 12, '0'),
(9, '[{\"item_id\":\"25\",\"quantity\":\"1\",\"custom_id\":\"none\",\"mini_status\":0}]', '\"\"', '2019-11-15 10:42:18', 1, 3, '3dqvp9tmhqkt8ml69tr6pr2nt5', 13, '0'),
(10, '[{\"item_id\":\"25\",\"quantity\":\"2\",\"custom_id\":\"none\",\"mini_status\":0}]', '\"\"', '2019-11-15 10:44:42', 1, 3, '3dqvp9tmhqkt8ml69tr6pr2nt5', 15, '0'),
(11, '[{\"item_id\":\"25\",\"quantity\":\"1\",\"custom_id\":\"none\",\"mini_status\":0}]', '\"\"', '2019-11-15 11:58:12', 3, 3, 'cf4v9iks1pc7lk141m462tmqn9', 0, '0'),
(12, '[{\"item_id\":\"25\",\"quantity\":\"2\",\"custom_id\":\"none\",\"mini_status\":0}]', '\"\"', '2019-11-16 16:33:22', 1, 3, 'idokm1e5hth7noqdkcrlvs1cq5', 12, '0'),
(13, '[{\"item_id\":\"25\",\"quantity\":\"1\",\"custom_id\":\"none\",\"mini_status\":0}]', '\"\"', '2019-11-16 17:00:53', 1, 3, 'idokm1e5hth7noqdkcrlvs1cq5', 12, '0'),
(14, '[{\"item_id\":\"25\",\"quantity\":\"1\",\"custom_id\":\"none\",\"mini_status\":0}]', '\"\"', '2019-11-16 17:50:55', 1, 3, '9f4hffclm710nc6ndpv25632au', 12, '0'),
(15, '[{\"item_id\":\"25\",\"quantity\":\"1\",\"custom_id\":\"none\",\"mini_status\":0}]', '\"\"', '2019-11-16 18:35:40', 1, 3, '9f4hffclm710nc6ndpv25632au', 13, '0'),
(16, '[{\"item_id\":\"25\",\"quantity\":\"1\",\"custom_id\":\"none\",\"mini_status\":0}]', '\"\"', '2019-11-16 19:08:00', 1, 3, '9f4hffclm710nc6ndpv25632au', 12, '0'),
(17, '[{\"item_id\":\"25\",\"quantity\":\"1\",\"custom_id\":\"none\",\"mini_status\":0}]', '[{\"item_id\":\"26\",\"quantity\":\"1\",\"custom_id\":\"none\",\"mini_status\":0}]', '2019-11-16 19:14:18', 1, 3, '9f4hffclm710nc6ndpv25632au', 12, '0'),
(18, '[{\"item_id\":\"26\",\"quantity\":\"1\",\"custom_id\":\"none\",\"mini_status\":0}]', '\"\"', '2019-11-17 21:35:06', 3, 3, 'chjvenkm2ua9p6dv8mnuvadm86', 0, '0'),
(19, '[{\"item_id\":\"26\",\"quantity\":\"1\",\"custom_id\":\"none\",\"mini_status\":0}]', '\"\"', '2019-11-18 09:20:46', 1, 3, 'ff1rlvdsemnbi3eqq9rfub07st', 15, '0'),
(20, '[{\"item_id\":\"25\",\"quantity\":\"1\",\"custom_id\":\"none\",\"mini_status\":0}]', '\"\"', '2019-11-18 10:01:27', 1, 3, 'ff1rlvdsemnbi3eqq9rfub07st', 15, '0'),
(21, '[{\"item_id\":\"26\",\"quantity\":\"1\",\"custom_id\":\"none\",\"mini_status\":0}]', '\"\"', '2019-11-18 10:03:36', 1, 3, 'ff1rlvdsemnbi3eqq9rfub07st', 15, '0'),
(22, '[{\"item_id\":\"27\",\"quantity\":\"2\",\"custom_id\":\"none\",\"mini_status\":0}]', '\"\"', '2019-11-18 10:04:58', 1, 3, 'ff1rlvdsemnbi3eqq9rfub07st', 19, '0'),
(23, '[{\"item_id\":\"25\",\"quantity\":\"1\",\"custom_id\":\"none\",\"mini_status\":0}]', '\"\"', '2019-11-18 11:30:34', 1, 3, 'jrikne4nldpn9hha34tc3hjkc1', 16, '0'),
(24, '[{\"item_id\":\"25\",\"quantity\":\"1\",\"custom_id\":\"none\",\"mini_status\":0},{\"item_id\":\"26\",\"quantity\":\"1\",\"custom_id\":\"none\",\"mini_status\":0}]', '\"\"', '2019-11-18 11:49:39', 1, 3, '3dg8bt4ctlbshgnoraiadqqkrs', 6, '0'),
(25, '[{\"item_id\":\"27\",\"quantity\":\"1\",\"custom_id\":\"none\",\"mini_status\":0},{\"item_id\":\"27\",\"quantity\":\"2\",\"custom_id\":\"none\",\"mini_status\":0}]', '\"\"', '2019-11-18 11:54:36', 1, 3, '3dg8bt4ctlbshgnoraiadqqkrs', 2, '0'),
(26, '\"\"', '[{\"item_id\":\"26\",\"quantity\":\"1\",\"custom_id\":\"none\",\"mini_status\":0}]', '2019-11-18 11:55:48', 0, 3, '3dg8bt4ctlbshgnoraiadqqkrs', 1, '0'),
(27, '[{\"item_id\":\"25\",\"quantity\":\"1\",\"custom_id\":\"none\",\"mini_status\":0}]', '\"\"', '2019-11-20 08:58:53', 1, 3, '71su5k6tdks36i4qgr8rknggrg', 10, '0'),
(28, '[{\"item_id\":\"26\",\"quantity\":\"1\",\"custom_id\":\"none\",\"mini_status\":0}]', '\"\"', '2019-12-23 16:41:43', 1, 3, '9c0eo2fsqr3amgn5jv8oqubliq', 6, '0'),
(29, '[{\"item_id\":\"25\",\"quantity\":\"2\",\"custom_id\":\"none\",\"mini_status\":0},{\"item_id\":\"26\",\"quantity\":\"1\",\"custom_id\":\"none\",\"mini_status\":0}]', '\"\"', '2020-01-11 13:59:22', 1, 3, '6tj5prqqpv1a5a5ur9ecqlg3bm', 12, '0');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

DROP TABLE IF EXISTS `requests`;
CREATE TABLE IF NOT EXISTS `requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_type` varchar(255) NOT NULL,
  `table_no` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `request_type`, `table_no`) VALUES
(2, 'waiter', 12),
(3, 'waiter', 14),
(4, 'waiter', 14),
(5, 'bill', 15),
(6, 'waiter', 26);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(2225) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `customize` tinyint(4) NOT NULL DEFAULT '1',
  `no_of_tables` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `company_name`, `logo`, `customize`, `no_of_tables`) VALUES
(4, 'Angla', 'images/fdc8a2a933fa3dc8bc89a8dc602d365e.jpg', 1, 13);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `joined_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime NOT NULL DEFAULT '0001-01-01 00:00:00',
  `permission` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `joined_date`, `last_login`, `permission`, `img`) VALUES
(1, 'Fnote Mehari', 'fnote.md@gmail.com', '$2y$10$cz7kKbNqJrK5BJLjmVNl/eBjivG6uzSnY.7wjedm4P.h9GGdsWLv2', '2019-10-06 10:04:06', '2020-02-10 05:50:19', 'Owner,Admin', 'images/profile_pic/85780690c79d83581eaba00be09d1552.png'),
(2, 'Helina Kiros ', 'helina@helina.com', '$2y$10$dYxJDy4HktLskIXOILrBi.53DCQLUOxxJfwWR4/eo0LNgLkvvCEVe', '2019-10-08 14:28:49', '2019-10-23 17:31:33', 'Chef', 'images/profile_pic/2f827b123f6bf1ef3fedec8ab88f3960.png'),
(3, 'Fisha Wubshet', 'fish@fish.com', '$2y$10$Z5KXYsm77b9bogg4726pY.zGIZe8Lw77PMrN5mmVDZWtIRKEEljgy', '2019-10-08 14:29:36', '2019-10-25 10:42:22', 'Chef,Admin', 'images/profile_pic/85780690c79d83581eaba00be09d1552.png'),
(4, 'Amare Engdawork', 'amare@amare.com', '$2y$10$Zve.hAQ79XO0SoS7zqTnmu4qkZSa3P0WMyeRDovrNIoQlBEiBGo/O', '2019-10-09 15:28:24', '2019-10-30 13:33:16', 'Cashier,Admin', 'images/profile_pic/b895422580276d218bf0295aa2375721.png'),
(6, 'Kiya gebru', 'kiya@kiya.com', '$2y$10$hHJHkgttaIALBe4fOmDyMexLssJS9E23zSGMvYJ8jiLRVTVa.QQoa', '2019-10-22 09:43:38', '2019-10-23 11:26:58', 'Waiter', 'images/profile_pic/e4a01656dee8b1099c8689b066b7fa03.png'),
(7, 'pizza chef', 'pizza@pizza.com', '$2y$10$UTIsLBL6kMGjLdBWrHtUweGZUtBNsmOpZ8GwTeYpb1wTNAMZc/iDS', '2019-10-24 08:13:10', '2019-10-29 11:14:00', 'Chef', 'images/profile_pic/83ea273b04351985eca5e14d2d670c9c.png'),
(8, 'chicken chef', 'chicken@chicken.com', '$2y$10$85g5QDjiL7iU.qgTvvoOy.HSq4vUynHCUq0Zus5x9vbRG5r26bYb.', '2019-10-24 08:14:36', '2019-10-30 07:49:12', 'Chef', 'images/profile_pic/e4e5ccf72d71b4ee1f5dd9a257c7404f.png'),
(9, 'Simon Mulugeta', 'simon@simon.com', '$2y$10$6JrjP.Us7fwfgksUTxWbyu2O7FOPJVTRZ4yMp6FI8HYWm77mlsiYG', '2019-10-30 16:29:30', '2019-10-30 13:31:50', 'Waiter', 'images/profile_pic/753205de6e824c62da98ac1a8b4fdd5c.png');

-- --------------------------------------------------------

--
-- Table structure for table `waiters`
--

DROP TABLE IF EXISTS `waiters`;
CREATE TABLE IF NOT EXISTS `waiters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `resp_table` varchar(255) NOT NULL DEFAULT 'none',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `waiters`
--

INSERT INTO `waiters` (`id`, `user_id`, `resp_table`) VALUES
(1, 9, '41-45');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `category_ibfk_1` FOREIGN KEY (`kit_id`) REFERENCES `kitchens` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `customize`
--
ALTER TABLE `customize`
  ADD CONSTRAINT `customize_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kitchens`
--
ALTER TABLE `kitchens`
  ADD CONSTRAINT `kitchens_ibfk_1` FOREIGN KEY (`admin`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `waiters`
--
ALTER TABLE `waiters`
  ADD CONSTRAINT `waiters_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
