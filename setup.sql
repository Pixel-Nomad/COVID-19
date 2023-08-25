-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.27-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for _covid19
CREATE DATABASE IF NOT EXISTS `_covid19` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `_covid19`;

-- Dumping structure for table _covid19.codes
CREATE TABLE IF NOT EXISTS `codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(255) NOT NULL DEFAULT '0',
  `type` varchar(50) NOT NULL DEFAULT '0',
  `code` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table _covid19.codes: ~0 rows (approximately)
DELETE FROM `codes`;

-- Dumping structure for table _covid19.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `postal` varchar(50) DEFAULT NULL,
  `country` varchar(5) DEFAULT NULL,
  `verified` varchar(5) DEFAULT 'false',
  `role` varchar(10) DEFAULT 'user',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table _covid19.users: ~2 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`user_id`, `fname`, `lname`, `email`, `contact`, `password`, `address`, `city`, `state`, `postal`, `country`, `verified`, `role`) VALUES
	(1, 'Tayyab', 'Naseem', 'mr.tgamer247797703@gmail.com', '01321561561', '00ea1da4192a2030f9ae023de3b3143ed647bbab', 'address 1', 'Karachi', 'asdasdasd', '1561561', 'BS', 'false', 'user'),
	(2, 'Tayyab', 'Naseem', 'mr.tgamer247797704@gmail.com', '123456', '00ea1da4192a2030f9ae023de3b3143ed647bbab', 'address 1', 'Karachi', 'sindh', '16456', 'BH', 'false', 'user'),
	(3, 'Tayyab', 'Naseem', 'mr.tgamer2477977@gmail.com', '123456789', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'address 1', 'Karachi', 'sindh', '123456789', 'AT', 'true', 'user');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
