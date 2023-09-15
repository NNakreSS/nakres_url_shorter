-- --------------------------------------------------------
-- Sunucu:                       127.0.0.1
-- Sunucu sürümü:                10.4.24-MariaDB - mariadb.org binary distribution
-- Sunucu İşletim Sistemi:       Win64
-- HeidiSQL Sürüm:               12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL DEFAULT '0',
  `user_password` varchar(255) COLLATE utf8mb4_turkish_ci NOT NULL DEFAULT '0',
  `isAdmin` int(1) DEFAULT NULL,
  `user_id` varchar(6) COLLATE utf8mb4_turkish_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO `users` (`id`, `user_name`, `user_password`, `isAdmin`, `user_id`) VALUES
	(1, 'admin', '$2y$10$kDsJe4M7cyajOVjf8rgo5ui/pgCaGlFGjKiBDaK1JINkGpTEP0SiC', 1, '5fc7e4');
  
CREATE TABLE IF NOT EXISTS `urls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `long_url` varchar(1000) COLLATE utf8mb4_turkish_ci NOT NULL DEFAULT '',
  `short_url` varchar(200) COLLATE utf8mb4_turkish_ci NOT NULL DEFAULT '',
  `click` int(255) NOT NULL DEFAULT 0,
  `owner_id` varchar(6) COLLATE utf8mb4_turkish_ci NOT NULL DEFAULT '',
  `create_date` varchar(255) COLLATE utf8mb4_turkish_ci NOT NULL DEFAULT '',
  `owner_name` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_urls_users` (`owner_id`) USING BTREE,
  KEY `FK_urls_users_2` (`owner_name`),
  CONSTRAINT `FK_urls_users` FOREIGN KEY (`owner_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_urls_users_2` FOREIGN KEY (`owner_name`) REFERENCES `users` (`user_name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;



/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
