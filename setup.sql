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

-- Dumping structure for table _covid19.appointments
CREATE TABLE IF NOT EXISTS `appointments` (
  `appointment_id` int(11) NOT NULL AUTO_INCREMENT,
  `hospital_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `type` varchar(50) DEFAULT 'normal',
  `status` varchar(50) DEFAULT 'pending',
  `booking_time` datetime DEFAULT NULL,
  `appointment_time` datetime DEFAULT NULL,
  PRIMARY KEY (`appointment_id`),
  KEY `hospital_id` (`hospital_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `hospital_id` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`hospital_id`),
  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table _covid19.appointments: ~3 rows (approximately)
DELETE FROM `appointments`;
INSERT INTO `appointments` (`appointment_id`, `hospital_id`, `user_id`, `type`, `status`, `booking_time`, `appointment_time`) VALUES
	(17, 6, 6, 'normal', 'visited', '2023-09-10 09:58:26', '2023-09-12 15:00:00'),
	(18, 5, 6, 'normal', 'rejected', '2023-09-10 10:05:20', '2023-09-20 13:05:00'),
	(19, 8, 6, 'normal', 'visited', '2023-09-10 19:54:00', '2023-09-13 22:54:00');

-- Dumping structure for table _covid19.available_test
CREATE TABLE IF NOT EXISTS `available_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hospital_id` int(11) DEFAULT 0,
  `test_type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hospital_id_available_test` (`hospital_id`),
  CONSTRAINT `hospital_id_available_test` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`hospital_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table _covid19.available_test: ~11 rows (approximately)
DELETE FROM `available_test`;
INSERT INTO `available_test` (`id`, `hospital_id`, `test_type`) VALUES
	(8, 6, 'PCR (Polymerase Chain Reaction)'),
	(9, 6, 'Saliva Test'),
	(10, 6, 'Rapid Antigen'),
	(11, 5, 'Antibody Test'),
	(13, 7, 'Rapid Antigen'),
	(14, 7, 'PCR (Polymerase Chain Reaction)'),
	(15, 7, 'Saliva Test'),
	(16, 8, 'LAMP (Loop-mediated Isothermal Amplification)'),
	(17, 8, 'Saliva Test'),
	(18, 9, 'PCR (Polymerase Chain Reaction)'),
	(19, 9, 'Rapid Antigen'),
	(20, 9, 'Antibody'),
	(21, 9, 'Saliva');

-- Dumping structure for table _covid19.available_vaccine
CREATE TABLE IF NOT EXISTS `available_vaccine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hospital_id` int(11) DEFAULT 0,
  `vaccine_type` varchar(50) DEFAULT NULL,
  `vaccine_quantity` int(11) DEFAULT 0,
  `vaccine_color` varchar(50) DEFAULT 'primary',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `hospital_id_available_vaccine` (`hospital_id`) USING BTREE,
  CONSTRAINT `hospital_id_available_vaccine` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`hospital_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table _covid19.available_vaccine: ~9 rows (approximately)
DELETE FROM `available_vaccine`;
INSERT INTO `available_vaccine` (`id`, `hospital_id`, `vaccine_type`, `vaccine_quantity`, `vaccine_color`) VALUES
	(8, 6, 'Pfizer-BioNTech', 49, 'primary'),
	(9, 6, 'Sinopharm', 30, 'danger'),
	(10, 6, 'Sinovac', 14, 'danger'),
	(11, 5, 'Novavax', 10, 'success'),
	(12, 7, 'Sputnik V', 10, 'custom'),
	(13, 7, 'Covaxin', 10, 'dark'),
	(14, 8, 'Pfizer-BioNTech', 10, 'primary'),
	(15, 8, 'Moderna', 10, 'warning'),
	(16, 9, 'Sinopharm', 10, 'danger'),
	(17, 9, 'Sinovac', 10, 'danger'),
	(18, 9, 'Covaxin', 10, 'dark');

-- Dumping structure for table _covid19.codes
CREATE TABLE IF NOT EXISTS `codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(255) NOT NULL DEFAULT '0',
  `type` varchar(50) NOT NULL DEFAULT '0',
  `code` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table _covid19.codes: ~0 rows (approximately)
DELETE FROM `codes`;

-- Dumping structure for table _covid19.hospitals
CREATE TABLE IF NOT EXISTS `hospitals` (
  `hospital_id` int(11) NOT NULL AUTO_INCREMENT,
  `hospital_name` varchar(50) NOT NULL DEFAULT 'No Name Specified',
  `timing` varchar(50) NOT NULL DEFAULT 'No Timing Specified',
  `area` varchar(50) NOT NULL DEFAULT 'No City Specified',
  `city` varchar(50) NOT NULL DEFAULT 'No Area Specified',
  PRIMARY KEY (`hospital_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table _covid19.hospitals: ~4 rows (approximately)
DELETE FROM `hospitals`;
INSERT INTO `hospitals` (`hospital_id`, `hospital_name`, `timing`, `area`, `city`) VALUES
	(5, 'Ziauddin Hospital', '09:00 - 02:00', 'Clifton', 'Karachi'),
	(6, 'Liaquat National Hospital', '09:00 - 02:00', 'Stadium Road', 'Karachi'),
	(7, 'Agha Khan Hospital', '08:00 - 12:00', 'Stadium Road', 'Karachi'),
	(8, 'South City Hospital', '08:00 - 12:00', 'Clifton', 'Karachi'),
	(9, 'OMI Hospital', '10:00 - 03:00', 'M.A Jinnah Road', 'Karachi');

-- Dumping structure for table _covid19.hospital_users
CREATE TABLE IF NOT EXISTS `hospital_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `hospital_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `approved` varchar(50) DEFAULT 'false',
  PRIMARY KEY (`user_id`),
  KEY `hospital_id_users` (`hospital_id`),
  CONSTRAINT `hospital_id_users` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`hospital_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table _covid19.hospital_users: ~5 rows (approximately)
DELETE FROM `hospital_users`;
INSERT INTO `hospital_users` (`user_id`, `hospital_id`, `name`, `email`, `password`, `approved`) VALUES
	(4, 6, 'Tayyab Naseem', 'mr.tgamer247797703@gmail.com', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'true'),
	(5, 5, 'Tayyab Naseem', 'mr.tgamer247797703@gmail.com', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'true'),
	(6, 7, 'Tayyab Naseem', 'mr.tgamer247797703@gmail.com', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'true'),
	(7, 9, 'Tayyab Naseem', 'mr.tgamer247797703@gmail.com', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'true'),
	(8, 8, 'Tayyab Naseem', 'mr.tgamer247797703@gmail.com', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'true');

-- Dumping structure for table _covid19.reports
CREATE TABLE IF NOT EXISTS `reports` (
  `report_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `hospital_id` int(11) NOT NULL DEFAULT 0,
  `report_timing` datetime DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `test_type` varchar(50) DEFAULT NULL,
  `vaccine_type` varchar(50) DEFAULT NULL,
  `test_result` varchar(50) DEFAULT NULL,
  `vaccine_status` varchar(50) DEFAULT 'Not Taken',
  PRIMARY KEY (`report_id`),
  KEY `user_id_report` (`user_id`),
  KEY `hospital_id_report` (`hospital_id`),
  CONSTRAINT `hospital_id_report` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`hospital_id`),
  CONSTRAINT `user_id_report` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table _covid19.reports: ~5 rows (approximately)
DELETE FROM `reports`;
INSERT INTO `reports` (`report_id`, `user_id`, `hospital_id`, `report_timing`, `type`, `test_type`, `vaccine_type`, `test_result`, `vaccine_status`) VALUES
	(13, 6, 6, '2023-09-10 16:24:39', 'test', 'Saliva Test', NULL, 'Negetive', 'Not Taken'),
	(14, 6, 6, '2023-09-10 16:24:39', 'test', 'PCR (Polymerase Chain Reaction)', NULL, 'Positive', 'Not Taken'),
	(15, 6, 6, '2023-09-10 16:24:39', 'vaccine', NULL, 'Pfizer-BioNTech', NULL, 'Taken'),
	(16, 6, 6, NULL, 'vaccine', NULL, 'Sinopharm', NULL, 'Not Taken'),
	(17, 6, 8, '2023-09-10 22:54:00', 'test', 'Saliva Test', NULL, 'Negetive', 'Not Taken');

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table _covid19.users: ~2 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`user_id`, `fname`, `lname`, `email`, `contact`, `password`, `address`, `city`, `state`, `postal`, `country`, `verified`, `role`) VALUES
	(5, 'Aliza', 'Ghulam', 'aleezaghulam0077@gmail.com', '03122499117', '4d7efd8e73d3c646a7eabb84647ed205b8acfbfc', 'Zamzama Commercial Lane gizri ', 'Karachi', 'Sindh', '75600', 'Pakistan', 'true', 'user'),
	(6, 'Tayyab', 'Naseem', 'mr.tgamer247797703@gmail.com', '03082838448', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'd28/1, block 8, area scheme 5, clifton', 'Karachi', 'sindh', '75600', 'Pakistan', 'true', 'master'),
	(7, 'Tayyab', 'Naseem', 'mr.tgamer247797704@gmail.com', '03082838448', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'd28/1, block 8, area scheme 5, clifton', 'Karachi', 'sindh', '75600', 'Pakistan', 'true', 'user');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
