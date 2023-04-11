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


-- Listage de la structure de la base pour dbsymfonyapp
CREATE DATABASE IF NOT EXISTS `dbsymfonyapp` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `dbsymfonyapp`;

-- Listage de la structure de table dbsymfonyapp. category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table dbsymfonyapp.category : ~2 rows (environ)
INSERT INTO `category` (`id`, `type`) VALUES
	(1, 'office'),
	(2, 'Programation');

-- Listage de la structure de table dbsymfonyapp. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table dbsymfonyapp.doctrine_migration_versions : ~0 rows (environ)
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20230404130838', '2023-04-04 15:10:53', 4424);

-- Listage de la structure de table dbsymfonyapp. formation
CREATE TABLE IF NOT EXISTS `formation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table dbsymfonyapp.formation : ~3 rows (environ)
INSERT INTO `formation` (`id`, `titre`) VALUES
	(1, 'developpeur web et web mobile'),
	(2, 'office'),
	(3, 'Technicien Electrique');

-- Listage de la structure de table dbsymfonyapp. messenger_messages
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

-- Listage des données de la table dbsymfonyapp.messenger_messages : ~0 rows (environ)

-- Listage de la structure de table dbsymfonyapp. module
CREATE TABLE IF NOT EXISTS `module` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C24262812469DE2` (`category_id`),
  CONSTRAINT `FK_C24262812469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table dbsymfonyapp.module : ~3 rows (environ)
INSERT INTO `module` (`id`, `category_id`, `nom`) VALUES
	(1, 1, 'word'),
	(2, 1, 'Excel'),
	(3, 1, 'powepoint'),
	(4, 2, 'c++'),
	(5, 1, 'java'),
	(6, 1, 'php'),
	(7, 2, 'cobol'),
	(8, 2, 'doctrine'),
	(9, 2, 'doctrine'),
	(10, 2, 'sql'),
	(11, 2, 'symfony 6');

-- Listage de la structure de table dbsymfonyapp. modules_details
CREATE TABLE IF NOT EXISTS `modules_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `session_id` int NOT NULL,
  `module_id` int NOT NULL,
  `nbrjours` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_66B48BE613FECDF` (`session_id`),
  KEY `IDX_66B48BEAFC2B591` (`module_id`),
  CONSTRAINT `FK_66B48BE613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`),
  CONSTRAINT `FK_66B48BEAFC2B591` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table dbsymfonyapp.modules_details : ~4 rows (environ)
INSERT INTO `modules_details` (`id`, `session_id`, `module_id`, `nbrjours`) VALUES
	(2, 1, 3, 3),
	(4, 2, 2, 2),
	(5, 2, 1, 2),
	(13, 1, 1, 5);

-- Listage de la structure de table dbsymfonyapp. session
CREATE TABLE IF NOT EXISTS `session` (
  `id` int NOT NULL AUTO_INCREMENT,
  `formation_id` int DEFAULT NULL,
  `nombre_places` int NOT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D044D5D45200282E` (`formation_id`),
  CONSTRAINT `FK_D044D5D45200282E` FOREIGN KEY (`formation_id`) REFERENCES `formation` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table dbsymfonyapp.session : ~2 rows (environ)
INSERT INTO `session` (`id`, `formation_id`, `nombre_places`, `date_debut`, `date_fin`) VALUES
	(1, 1, 10, '2023-04-05 09:53:51', '2023-10-05 09:53:56'),
	(2, 2, 10, '2023-04-05 09:54:27', '2023-10-05 09:54:33'),
	(3, 1, 5, '2023-04-11 00:00:00', '2023-04-18 00:00:00'),
	(4, 1, 5, '2023-04-11 00:00:00', '2023-04-12 00:00:00'),
	(5, 1, 4, '2023-04-11 00:00:00', '2023-04-13 00:00:00'),
	(6, 1, 5, '2023-04-11 00:00:00', '2023-04-13 00:00:00'),
	(7, 1, 5, '2023-04-11 00:00:00', '2023-04-13 00:00:00');

-- Listage de la structure de table dbsymfonyapp. stagiaire
CREATE TABLE IF NOT EXISTS `stagiaire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table dbsymfonyapp.stagiaire : ~3 rows (environ)
INSERT INTO `stagiaire` (`id`, `nom`, `prenom`, `email`) VALUES
	(1, 'kayal', 'georges', 'georgeskayal2014@gmail.com'),
	(2, 'kayal', 'tony', 'tonykayal2023@gmail.com'),
	(4, 'kayal', 'maria', 'georgeskayal2014@gmail.com'),
	(5, 'kayal', 'Gabriella', 'georgeskayal2014@gmail.com');

-- Listage de la structure de table dbsymfonyapp. stagiaire_session
CREATE TABLE IF NOT EXISTS `stagiaire_session` (
  `stagiaire_id` int NOT NULL,
  `session_id` int NOT NULL,
  PRIMARY KEY (`stagiaire_id`,`session_id`),
  KEY `IDX_D32D02D4BBA93DD6` (`stagiaire_id`),
  KEY `IDX_D32D02D4613FECDF` (`session_id`),
  CONSTRAINT `FK_D32D02D4613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_D32D02D4BBA93DD6` FOREIGN KEY (`stagiaire_id`) REFERENCES `stagiaire` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table dbsymfonyapp.stagiaire_session : ~3 rows (environ)
INSERT INTO `stagiaire_session` (`stagiaire_id`, `session_id`) VALUES
	(1, 1),
	(1, 2),
	(2, 2);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
