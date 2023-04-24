-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour bubbletea
DROP DATABASE IF EXISTS `bubbletea`;
CREATE DATABASE IF NOT EXISTS `bubbletea` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `bubbletea`;

-- Listage de la structure de table bubbletea. doctrine_migration_versions
DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table bubbletea.doctrine_migration_versions : ~3 rows (environ)
DELETE FROM `doctrine_migration_versions`;
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20230418125446', '2023-04-18 12:55:01', 524),
	('DoctrineMigrations\\Version20230419094217', '2023-04-19 09:42:30', 27),
	('DoctrineMigrations\\Version20230419103903', '2023-04-19 10:44:35', 65),
	('DoctrineMigrations\\Version20230419205316', '2023-04-19 20:56:07', 101);

-- Listage de la structure de table bubbletea. drink
DROP TABLE IF EXISTS `drink`;
CREATE TABLE IF NOT EXISTS `drink` (
  `id` int NOT NULL AUTO_INCREMENT,
  `flavour` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int NOT NULL,
  `is_on_menu` tinyint(1) NOT NULL,
  `sugar_quantity` int NOT NULL,
  `is_part_of_menu` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table bubbletea.drink : ~12 rows (environ)
DELETE FROM `drink`;
INSERT INTO `drink` (`id`, `flavour`, `name`, `price`, `is_on_menu`, `sugar_quantity`, `is_part_of_menu`) VALUES
	(60, 'Jasmin', 'Thé', 5, 1, 1, 1),
	(61, 'Fraise', 'Thé', 5, 1, 1, 1),
	(62, 'Rose', 'Thé', 5, 1, 1, 1),
	(63, 'Litchi', 'Thé', 5, 1, 1, 1),
	(64, 'Mangue', 'Thé', 5, 1, 1, 1),
	(65, 'Pêche', 'Thé', 5, 1, 1, 1),
	(66, 'Pastèque', 'Thé', 5, 0, 1, 1);

-- Listage de la structure de table bubbletea. drink_popping
DROP TABLE IF EXISTS `drink_popping`;
CREATE TABLE IF NOT EXISTS `drink_popping` (
  `drink_id` int NOT NULL,
  `popping_id` int NOT NULL,
  PRIMARY KEY (`drink_id`,`popping_id`),
  KEY `IDX_5741E4C636AA4BB4` (`drink_id`),
  KEY `IDX_5741E4C6E029A606` (`popping_id`),
  CONSTRAINT `FK_5741E4C636AA4BB4` FOREIGN KEY (`drink_id`) REFERENCES `drink` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_5741E4C6E029A606` FOREIGN KEY (`popping_id`) REFERENCES `popping` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table bubbletea.drink_popping : ~17 rows (environ)
DELETE FROM `drink_popping`;
INSERT INTO `drink_popping` (`drink_id`, `popping_id`) VALUES
	(60, 44),
	(61, 44),
	(62, 44),
	(63, 44),
	(64, 44),
	(65, 44),
	(66, 44);

-- Listage de la structure de table bubbletea. messenger_messages
DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table bubbletea.messenger_messages : ~0 rows (environ)
DELETE FROM `messenger_messages`;

-- Listage de la structure de table bubbletea. order
DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_user_id` int NOT NULL,
  `total` double NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_F529939851147ADE` (`order_user_id`),
  CONSTRAINT `FK_F529939851147ADE` FOREIGN KEY (`order_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table bubbletea.order : ~4 rows (environ)
DELETE FROM `order`;

-- Listage de la structure de table bubbletea. order_drink
DROP TABLE IF EXISTS `order_drink`;
CREATE TABLE IF NOT EXISTS `order_drink` (
  `order_id` int NOT NULL,
  `drink_id` int NOT NULL,
  PRIMARY KEY (`order_id`,`drink_id`),
  KEY `IDX_8E20342C8D9F6D38` (`order_id`),
  KEY `IDX_8E20342C36AA4BB4` (`drink_id`),
  CONSTRAINT `FK_8E20342C36AA4BB4` FOREIGN KEY (`drink_id`) REFERENCES `drink` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_8E20342C8D9F6D38` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table bubbletea.order_drink : ~7 rows (environ)
DELETE FROM `order_drink`;

-- Listage de la structure de table bubbletea. popping
DROP TABLE IF EXISTS `popping`;
CREATE TABLE IF NOT EXISTS `popping` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table bubbletea.popping : ~6 rows (environ)
DELETE FROM `popping`;
INSERT INTO `popping` (`id`, `name`, `slug`) VALUES
	(44, 'Tapioca', 'tapioca'),
	(45, 'Litchi', 'litchi'),
	(46, 'Pêche', 'peche'),
	(47, 'Mangue', 'mangue'),
	(48, 'Framboise', 'framboise'),
	(49, 'Passion', 'passion');

-- Listage de la structure de table bubbletea. user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table bubbletea.user : ~2 rows (environ)
DELETE FROM `user`;
INSERT INTO `user` (`id`, `email`, `roles`, `password`, `first_name`, `last_name`, `created_at`, `updated_at`) VALUES
	(12, 'mathilde@bbtea.com', '["ROLE_ADMIN"]', '$2y$13$hRaqCjVguRB3CHX8CTT1x.040ExULg0gTu5BdMdiDFTtBTHX8J0me', 'Mathilde', 'Turra', '2023-04-24 08:24:14', NULL),
	(13, 'jane@user.com', '["ROLE_USER"]', '$2y$13$HGoh8BfeboojvPXnIejdWugMyhkWhGMPCOooDEolSJCf/udLtewCu', 'Jane', 'Austen', '2023-04-24 08:24:14', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
