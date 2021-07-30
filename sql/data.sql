-- MySQL dump 10.13  Distrib 8.0.26, for Linux (x86_64)
--
-- Host: localhost    Database: example_app
-- ------------------------------------------------------
-- Server version	8.0.26

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `api_migrations`
--

DROP TABLE IF EXISTS `api_migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `api_migrations` (
  `version` bigint NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_migrations`
--

LOCK TABLES `api_migrations` WRITE;
/*!40000 ALTER TABLE `api_migrations` DISABLE KEYS */;
INSERT INTO `api_migrations` VALUES (20210730173537,'Apps','2021-07-30 18:26:00','2021-07-30 18:26:00',0),(20210730173548,'AppCredentials','2021-07-30 18:26:00','2021-07-30 18:26:00',0),(20210730173555,'Devices','2021-07-30 18:26:00','2021-07-30 18:26:00',0),(20210730173602,'DeviceApps','2021-07-30 18:26:00','2021-07-30 18:26:00',0),(20210730173608,'Subscriptions','2021-07-30 18:26:00','2021-07-30 18:26:01',0);
/*!40000 ALTER TABLE `api_migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_credentials`
--

DROP TABLE IF EXISTS `app_credentials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `app_credentials` (
  `acid` int NOT NULL AUTO_INCREMENT,
  `aid` int NOT NULL,
  `username` varchar(70) NOT NULL,
  `password` varchar(70) NOT NULL,
  `platform` enum('IOS','ANDROID') NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`acid`),
  UNIQUE KEY `acid_aid` (`aid`,`username`),
  CONSTRAINT `app_credentials_ibfk_1` FOREIGN KEY (`aid`) REFERENCES `apps` (`aid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_credentials`
--

LOCK TABLES `app_credentials` WRITE;
/*!40000 ALTER TABLE `app_credentials` DISABLE KEYS */;
INSERT INTO `app_credentials` VALUES (1,1,'app_one','2Xix7+LN/SH3wVqmCZgNIOdglYYv7sHkObwoWTA=','IOS','2021-07-30 18:26:01'),(2,2,'app_two','2Xix7+LN/SH3wVqmCZgNIOdglYYv7sHkObwoWTA=','IOS','2021-07-30 18:26:01'),(3,3,'app_three','2Xix7+LN/SH3wVqmCZgNIOdglYYv7sHkObwoWTA=','ANDROID','2021-07-30 18:26:01');
/*!40000 ALTER TABLE `app_credentials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apps`
--

DROP TABLE IF EXISTS `apps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apps` (
  `aid` int NOT NULL AUTO_INCREMENT,
  `app_id` varchar(70) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`aid`),
  UNIQUE KEY `aid_app_id` (`app_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apps`
--

LOCK TABLES `apps` WRITE;
/*!40000 ALTER TABLE `apps` DISABLE KEYS */;
INSERT INTO `apps` VALUES (1,'a96d6de3ed11b646545d74908788d54e','2021-07-30 18:26:01'),(2,'0cf0cf9bc1d6f20e66f465201210a883','2021-07-30 18:26:01'),(3,'bb2693916fa7f873fa45d9625073e916','2021-07-30 18:26:01');
/*!40000 ALTER TABLE `apps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `credentials`
--

DROP TABLE IF EXISTS `credentials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `credentials` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `password` varchar(120) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `credentials`
--

LOCK TABLES `credentials` WRITE;
/*!40000 ALTER TABLE `credentials` DISABLE KEYS */;
INSERT INTO `credentials` VALUES (1,'app_one','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(2,'app_two','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(3,'app_three','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(4,'vschulist','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(5,'koch.walton','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(6,'wuckert.crystal','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(7,'oconnell.brook','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(8,'cdamore','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(9,'carlie.hodkiewicz','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(10,'stamm.bria','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(11,'zstamm','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(12,'earnestine.corkery','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(13,'irenner','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(14,'lhackett','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(15,'zstamm','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(16,'dooley.ozella','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(17,'dhamill','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(18,'linda.jakubowski','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(19,'jose.jacobs','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(20,'raleigh94','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(21,'ethyl.mccullough','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(22,'loyal01','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(23,'myrtice37','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(24,'muriel.hudson','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(25,'madyson.bode','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(26,'willow56','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(27,'marcel47','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(28,'elsie.anderson','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(29,'declan.beer','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(30,'buckridge.mario','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(31,'aondricka','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(32,'dharris','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(33,'vmedhurst','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(34,'felton85','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(35,'gledner','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(36,'wortiz','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(37,'bethany.leuschke','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(38,'flatley.merle','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(39,'angela89','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(40,'rwaters','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(41,'zschmidt','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(42,'rae07','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(43,'kris05','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(44,'idickinson','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(45,'conn.davon','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(46,'justina39','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(47,'laverna86','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(48,'kailey59','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(49,'stremblay','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(50,'hschimmel','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(51,'tillman.maryse','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(52,'zechariah.greenholt','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(53,'elissa36','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(54,'yost.zachariah','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(55,'monroe.kshlerin','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(56,'schoen.brady','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(57,'norberto.hyatt','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(58,'kdeckow','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(59,'virgil22','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(60,'awitting','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(61,'shanahan.alvah','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(62,'ydouglas','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(63,'bridie.wilkinson','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(64,'fdare','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(65,'diego51','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(66,'wyman.colby','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(67,'ufeil','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(68,'treichert','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(69,'mnitzsche','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(70,'mparisian','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(71,'stanton.doyle','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(72,'rossie08','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(73,'barrows.christophe','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(74,'corbin89','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(75,'swisoky','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(76,'bechtelar.jerome','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(77,'zframi','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(78,'colton.homenick','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(79,'cconroy','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(80,'tkoch','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(81,'knienow','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(82,'julien.walsh','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(83,'angelo99','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(84,'iward','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(85,'jaylen89','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(86,'abbott.adele','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(87,'burley28','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(88,'wade.gislason','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(89,'feeney.beth','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(90,'marianna13','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(91,'emard.imani','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(92,'foconner','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(93,'lspencer','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(94,'mcglynn.adah','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(95,'joshuah38','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(96,'thompson.deon','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(97,'burdette50','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(98,'atorp','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(99,'ubogisich','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54'),(100,'xdamore','$2y$10$vQTT5LQNV4mPVblsgBZPmuJZgnpH0K3v18o5s7mvM2agLsq16BCqK','2021-07-30 18:25:54');
/*!40000 ALTER TABLE `credentials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `device_apps`
--

DROP TABLE IF EXISTS `device_apps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `device_apps` (
  `daid` int NOT NULL AUTO_INCREMENT,
  `did` int NOT NULL,
  `aid` int NOT NULL,
  `token` varchar(70) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`daid`),
  KEY `daid_did_aid` (`did`,`aid`),
  KEY `aid` (`aid`),
  CONSTRAINT `device_apps_ibfk_1` FOREIGN KEY (`did`) REFERENCES `devices` (`did`),
  CONSTRAINT `device_apps_ibfk_2` FOREIGN KEY (`aid`) REFERENCES `apps` (`aid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `device_apps`
--

LOCK TABLES `device_apps` WRITE;
/*!40000 ALTER TABLE `device_apps` DISABLE KEYS */;
/*!40000 ALTER TABLE `device_apps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `devices`
--

DROP TABLE IF EXISTS `devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `devices` (
  `did` int NOT NULL AUTO_INCREMENT,
  `uid` varchar(70) NOT NULL,
  `language` varchar(20) NOT NULL,
  `platform` enum('IOS','ANDROID') NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`did`),
  UNIQUE KEY `did_uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `devices`
--

LOCK TABLES `devices` WRITE;
/*!40000 ALTER TABLE `devices` DISABLE KEYS */;
/*!40000 ALTER TABLE `devices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mock_migrations`
--

DROP TABLE IF EXISTS `mock_migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mock_migrations` (
  `version` bigint NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mock_migrations`
--

LOCK TABLES `mock_migrations` WRITE;
/*!40000 ALTER TABLE `mock_migrations` DISABLE KEYS */;
INSERT INTO `mock_migrations` VALUES (20210723202833,'UserMigration','2021-07-30 18:25:54','2021-07-30 18:25:54',0);
/*!40000 ALTER TABLE `mock_migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subscriptions` (
  `sid` int NOT NULL AUTO_INCREMENT,
  `daid` int NOT NULL,
  `did` int NOT NULL,
  `aid` int NOT NULL,
  `receipt` varchar(70) NOT NULL,
  `status` tinyint DEFAULT NULL,
  `expire_date` datetime DEFAULT NULL,
  `event` enum('started','renewed','canceled') NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sid`),
  KEY `sid_daid` (`daid`),
  KEY `sid_did_aid` (`did`,`aid`),
  KEY `sid_receipt` (`receipt`),
  KEY `aid` (`aid`),
  CONSTRAINT `subscriptions_ibfk_1` FOREIGN KEY (`daid`) REFERENCES `device_apps` (`daid`),
  CONSTRAINT `subscriptions_ibfk_2` FOREIGN KEY (`did`) REFERENCES `devices` (`did`),
  CONSTRAINT `subscriptions_ibfk_3` FOREIGN KEY (`aid`) REFERENCES `apps` (`aid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscriptions`
--

LOCK TABLES `subscriptions` WRITE;
/*!40000 ALTER TABLE `subscriptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-07-30 18:31:19
