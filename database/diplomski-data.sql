-- MySQL dump 10.13  Distrib 5.1.49, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: diplomski
-- ------------------------------------------------------
-- Server version	5.1.49-1ubuntu8.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Restoran',0,'2011-05-22 12:03:46','2011-05-22 12:03:46'),(2,'Riblji restoran',0,'2011-05-22 12:03:58','2011-05-22 12:03:58'),(3,'Italijanska kuhinja',0,'2011-05-22 12:04:07','2011-05-22 12:04:07'),(4,'Kineska kuhinja',0,'2011-05-22 12:04:15','2011-05-22 12:04:15'),(5,'Palačinkarnica',0,'2011-05-22 12:04:40','2011-05-22 12:04:40'),(6,'Pekara',0,'2011-05-22 12:04:46','2011-05-22 12:04:46'),(7,'Ćevapdžinica',0,'2011-05-22 12:05:00','2011-05-22 12:05:00'),(8,'Kafana',0,'2011-05-22 12:05:13','2011-05-22 12:05:13'),(9,'Brza hrana',0,'2011-05-22 12:05:26','2011-05-22 12:05:26'),(10,'Picerija',0,'2011-05-22 16:35:55','2011-05-22 16:35:55');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories_pins`
--

DROP TABLE IF EXISTS `categories_pins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories_pins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `pin_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories_pins`
--

LOCK TABLES `categories_pins` WRITE;
/*!40000 ALTER TABLE `categories_pins` DISABLE KEYS */;
INSERT INTO `categories_pins` VALUES (1,5,1),(2,3,2),(3,8,3),(4,7,4),(5,6,5),(6,6,6),(7,1,7),(8,7,8),(9,6,9),(10,6,10),(11,8,11),(13,2,12),(15,10,13),(17,9,14),(18,6,15),(19,6,16),(20,6,17),(21,6,18);
/*!40000 ALTER TABLE `categories_pins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(255) NOT NULL,
  `latitude` float(9,6) NOT NULL,
  `longitude` float(9,6) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,'Tekst',43.307350,21.904238,'2011-09-01 12:17:34','2011-09-01 12:17:34'),(3,'Test poruka',43.307392,21.904222,'2011-09-01 13:14:09','2011-09-01 13:14:09'),(4,'Test poruka 1',43.307392,21.904222,'2011-09-01 13:16:36','2011-09-01 13:16:36'),(5,'Test poruka 2',43.307392,21.904222,'2011-09-01 13:18:30','2011-09-01 13:18:30'),(6,'Test poruka 3',43.307392,21.904222,'2011-09-01 13:19:00','2011-09-01 13:19:00');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pins`
--

DROP TABLE IF EXISTS `pins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `latitude` float(9,6) NOT NULL,
  `longitude` float(9,6) NOT NULL,
  `telephone` varchar(45) NOT NULL,
  `work_hours` varchar(45) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pins`
--

LOCK TABLES `pins` WRITE;
/*!40000 ALTER TABLE `pins` DISABLE KEYS */;
INSERT INTO `pins` VALUES (1,'Kluzo','',43.317791,21.900000,'','08-24','2011-05-22 16:35:19','2011-05-22 16:35:19'),(2,'Casa di Pasta','',43.317894,21.899561,'','08-24','2011-05-22 16:36:43','2011-05-22 16:36:43'),(3,'Stara Srbija','',43.317348,21.896610,'','08-24','2011-05-22 16:37:01','2011-05-22 16:37:01'),(4,'Mali Vikend','',43.317924,21.899902,'','08-24','2011-05-22 16:37:20','2011-05-22 16:37:20'),(5,'MBN','',43.318020,21.894861,'','08-24','2011-05-22 16:37:38','2011-05-22 16:37:38'),(6,'Pekara Branković','',43.317440,21.893391,'','08-24','2011-05-22 16:38:03','2011-05-22 16:38:03'),(7,'Mc Donald\'s','',43.321079,21.895279,'','08-24','2011-05-22 16:38:38','2011-05-22 16:38:38'),(8,'Laf','',43.320267,21.901962,'','08-24','2011-05-22 16:39:19','2011-05-22 16:39:19'),(9,'Mićko','',43.320194,21.902533,'','08-24','2011-05-22 16:39:39','2011-05-22 16:39:39'),(10,'Hleb i Pecivo','',43.318542,21.892094,'','08-24','2011-05-22 16:40:23','2011-05-22 16:40:23'),(11,'Nišlijska Mehana','',43.325722,21.898659,'','08-24','2011-05-22 16:41:55','2011-05-22 16:41:55'),(12,'Gusar','',43.323669,21.896898,'','08-24','2011-05-22 16:42:11','2011-05-22 16:42:11'),(13,'Picerija Gogo','',43.320206,21.893831,'','08-24','2011-05-22 16:42:59','2011-05-22 16:42:59'),(14,'Mr King','',43.320999,21.894817,'','08-24','2011-05-22 16:43:39','2011-05-22 16:43:39'),(15,'Bata Bane','',43.317783,21.889893,'','08-24','2011-05-22 16:44:03','2011-05-22 16:44:03'),(16,'Pekara Čair 2','',43.314732,21.899076,'','08-24','2011-05-22 16:45:18','2011-05-22 16:45:18'),(17,'Pekara Čair 1','',43.311710,21.911598,'','08-24','2011-05-22 16:45:48','2011-05-22 16:45:48'),(18,'MBN','',43.318863,21.909559,'','08-24','2011-05-22 16:46:25','2011-05-22 16:46:25');
/*!40000 ALTER TABLE `pins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `role` enum('USER','ADMIN') DEFAULT 'USER',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'mirko','2d53f844fef8292159b43d1e13b058616a5e2593','ADMIN','2011-05-05 20:26:27','2011-05-05 20:26:27');
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

-- Dump completed on 2011-09-01 14:13:03
