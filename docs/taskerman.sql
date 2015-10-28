-- MySQL dump 10.13  Distrib 5.5.44, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: taskerman
-- ------------------------------------------------------
-- Server version	5.5.44-0+deb8u1

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
-- Table structure for table `steps`
--

DROP TABLE IF EXISTS `steps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `title` mediumtext,
  `comment` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=211 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `steps`
--

LOCK TABLES `steps` WRITE;
/*!40000 ALTER TABLE `steps` DISABLE KEYS */;
INSERT INTO `steps` VALUES (1,1,'Step #1','Not done yet, sorry'),(2,1,'Step #2','Not done yet, sorry'),(3,1,'Step #3','Not done yet, sorry'),(4,2,'Step #1','Not done yet, sorry'),(5,2,'Step #2','Not done yet, sorry'),(6,2,'Step #3','Not done yet, sorry'),(7,3,'Step #1','Not done yet, sorry'),(8,3,'Step #2','Not done yet, sorry'),(9,4,'Step #1','Not done yet, sorry'),(10,4,'Step #2','Not done yet, sorry'),(11,4,'Step #3','Not done yet, sorry'),(12,5,'Step #1','Not done yet, sorry'),(13,6,'Step #1','Not done yet, sorry'),(14,7,'Step #1','Not done yet, sorry'),(15,8,'Step #1','Not done yet, sorry'),(16,8,'Step #2','Not done yet, sorry'),(17,9,'Step #1','Not done yet, sorry'),(18,9,'Step #2','Not done yet, sorry'),(19,10,'Step #1','Not done yet, sorry'),(20,11,'Step #1','Not done yet, sorry'),(21,11,'Step #2','Not done yet, sorry'),(22,11,'Step #3','Not done yet, sorry'),(23,12,'Step #1','Not done yet, sorry'),(24,12,'Step #2','Not done yet, sorry'),(25,12,'Step #3','Not done yet, sorry'),(26,13,'Step #1','Not done yet, sorry'),(27,14,'Step #1','Not done yet, sorry'),(28,14,'Step #2','Not done yet, sorry'),(29,15,'Step #1','Not done yet, sorry'),(30,15,'Step #2','Not done yet, sorry'),(31,16,'Step #1','Not done yet, sorry'),(32,16,'Step #2','Not done yet, sorry'),(33,16,'Step #3','Not done yet, sorry'),(34,17,'Step #1','Not done yet, sorry'),(35,17,'Step #2','Not done yet, sorry'),(36,17,'Step #3','Not done yet, sorry'),(37,18,'Step #1','Not done yet, sorry'),(38,19,'Step #1','Not done yet, sorry'),(39,19,'Step #2','Not done yet, sorry'),(40,20,'Step #1','Not done yet, sorry'),(41,21,'Step #1','Not done yet, sorry'),(42,21,'Step #2','Not done yet, sorry'),(43,21,'Step #3','Not done yet, sorry'),(44,22,'Step #1','Not done yet, sorry'),(45,23,'Step #1','Not done yet, sorry'),(46,24,'Step #1','Not done yet, sorry'),(47,25,'Step #1','Not done yet, sorry'),(48,25,'Step #2','Not done yet, sorry'),(49,26,'Step #1','Not done yet, sorry'),(50,26,'Step #2','Not done yet, sorry'),(51,26,'Step #3','Not done yet, sorry'),(52,27,'Step #1','Not done yet, sorry'),(53,27,'Step #2','Not done yet, sorry'),(54,28,'Step #1','Not done yet, sorry'),(55,28,'Step #2','Not done yet, sorry'),(56,29,'Step #1','Not done yet, sorry'),(57,30,'Step #1','Not done yet, sorry'),(58,30,'Step #2','Not done yet, sorry'),(59,31,'Step #1','Not done yet, sorry'),(60,31,'Step #2','Not done yet, sorry'),(61,32,'Step #1','Not done yet, sorry'),(62,32,'Step #2','Not done yet, sorry'),(63,32,'Step #3','Not done yet, sorry'),(64,33,'Step #1','Not done yet, sorry'),(65,33,'Step #2','Not done yet, sorry'),(66,33,'Step #3','Not done yet, sorry'),(67,34,'Step #1','Not done yet, sorry'),(68,35,'Step #1','Not done yet, sorry'),(69,35,'Step #2','Not done yet, sorry'),(70,36,'Step #1','Not done yet, sorry'),(71,37,'Step #1','Not done yet, sorry'),(72,37,'Step #2','Not done yet, sorry'),(73,37,'Step #3','Not done yet, sorry'),(74,38,'Step #1','Not done yet, sorry'),(75,38,'Step #2','Not done yet, sorry'),(76,38,'Step #3','Not done yet, sorry'),(77,39,'Step #1','Not done yet, sorry'),(78,39,'Step #2','Not done yet, sorry'),(79,40,'Step #1','Not done yet, sorry'),(80,41,'Step #1','Not done yet, sorry'),(81,41,'Step #2','Not done yet, sorry'),(82,42,'Step #1','Not done yet, sorry'),(83,42,'Step #2','Not done yet, sorry'),(84,42,'Step #3','Not done yet, sorry'),(85,43,'Step #1','Not done yet, sorry'),(86,43,'Step #2','Not done yet, sorry'),(87,43,'Step #3','Not done yet, sorry'),(88,44,'Step #1','Not done yet, sorry'),(89,44,'Step #2','Not done yet, sorry'),(90,45,'Step #1','Not done yet, sorry'),(91,46,'Step #1','Not done yet, sorry'),(92,46,'Step #2','Not done yet, sorry'),(93,46,'Step #3','Not done yet, sorry'),(94,47,'Step #1','Not done yet, sorry'),(95,47,'Step #2','Not done yet, sorry'),(96,48,'Step #1','Not done yet, sorry'),(97,48,'Step #2','Not done yet, sorry'),(98,48,'Step #3','Not done yet, sorry'),(99,49,'Step #1','Not done yet, sorry'),(100,50,'Step #1','Not done yet, sorry'),(101,50,'Step #2','Not done yet, sorry'),(102,50,'Step #3','Not done yet, sorry'),(103,51,'Step #1','Not done yet, sorry'),(104,52,'Step #1','Not done yet, sorry'),(105,52,'Step #2','Not done yet, sorry'),(106,53,'Step #1','Not done yet, sorry'),(107,54,'Step #1','Not done yet, sorry'),(108,54,'Step #2','Not done yet, sorry'),(109,55,'Step #1','Not done yet, sorry'),(110,55,'Step #2','Not done yet, sorry'),(111,55,'Step #3','Not done yet, sorry'),(112,56,'Step #1','Not done yet, sorry'),(113,56,'Step #2','Not done yet, sorry'),(114,56,'Step #3','Not done yet, sorry'),(115,57,'Step #1','Not done yet, sorry'),(116,58,'Step #1','Not done yet, sorry'),(117,58,'Step #2','Not done yet, sorry'),(118,58,'Step #3','Not done yet, sorry'),(119,59,'Step #1','Not done yet, sorry'),(120,59,'Step #2','Not done yet, sorry'),(121,59,'Step #3','Not done yet, sorry'),(122,60,'Step #1','Not done yet, sorry'),(123,60,'Step #2','Not done yet, sorry'),(124,60,'Step #3','Not done yet, sorry'),(125,61,'Step #1','Not done yet, sorry'),(126,62,'Step #1','Not done yet, sorry'),(127,63,'Step #1','Not done yet, sorry'),(128,64,'Step #1','Not done yet, sorry'),(129,64,'Step #2','Not done yet, sorry'),(130,65,'Step #1','Not done yet, sorry'),(131,66,'Step #1','Not done yet, sorry'),(132,66,'Step #2','Not done yet, sorry'),(133,67,'Step #1','Not done yet, sorry'),(134,67,'Step #2','Not done yet, sorry'),(135,67,'Step #3','Not done yet, sorry'),(136,68,'Step #1','Not done yet, sorry'),(137,68,'Step #2','Not done yet, sorry'),(138,69,'Step #1','Not done yet, sorry'),(139,69,'Step #2','Not done yet, sorry'),(140,69,'Step #3','Not done yet, sorry'),(141,70,'Step #1','Not done yet, sorry'),(142,70,'Step #2','Not done yet, sorry'),(143,71,'Step #1','Not done yet, sorry'),(144,71,'Step #2','Not done yet, sorry'),(145,71,'Step #3','Not done yet, sorry'),(146,72,'Step #1','Not done yet, sorry'),(147,72,'Step #2','Not done yet, sorry'),(148,72,'Step #3','Not done yet, sorry'),(149,73,'Step #1','Not done yet, sorry'),(150,73,'Step #2','Not done yet, sorry'),(151,74,'Step #1','Not done yet, sorry'),(152,74,'Step #2','Not done yet, sorry'),(153,74,'Step #3','Not done yet, sorry'),(154,75,'Step #1','Not done yet, sorry'),(155,75,'Step #2','Not done yet, sorry'),(156,76,'Step #1','Not done yet, sorry'),(157,76,'Step #2','Not done yet, sorry'),(158,76,'Step #3','Not done yet, sorry'),(159,77,'Step #1','Not done yet, sorry'),(160,78,'Step #1','Not done yet, sorry'),(161,78,'Step #2','Not done yet, sorry'),(162,78,'Step #3','Not done yet, sorry'),(163,79,'Step #1','Not done yet, sorry'),(164,79,'Step #2','Not done yet, sorry'),(165,79,'Step #3','Not done yet, sorry'),(166,80,'Step #1','Not done yet, sorry'),(167,81,'Step #1','Not done yet, sorry'),(168,81,'Step #2','Not done yet, sorry'),(169,82,'Step #1','Not done yet, sorry'),(170,82,'Step #2','Not done yet, sorry'),(171,83,'Step #1','Not done yet, sorry'),(172,83,'Step #2','Not done yet, sorry'),(173,83,'Step #3','Not done yet, sorry'),(174,84,'Step #1','Not done yet, sorry'),(175,84,'Step #2','Not done yet, sorry'),(176,85,'Step #1','Not done yet, sorry'),(177,85,'Step #2','Not done yet, sorry'),(178,85,'Step #3','Not done yet, sorry'),(179,86,'Step #1','Not done yet, sorry'),(180,87,'Step #1','Not done yet, sorry'),(181,87,'Step #2','Not done yet, sorry'),(182,87,'Step #3','Not done yet, sorry'),(183,88,'Step #1','Not done yet, sorry'),(184,88,'Step #2','Not done yet, sorry'),(185,88,'Step #3','Not done yet, sorry'),(186,89,'Step #1','Not done yet, sorry'),(187,90,'Step #1','Not done yet, sorry'),(188,90,'Step #2','Not done yet, sorry'),(189,90,'Step #3','Not done yet, sorry'),(190,91,'Step #1','Not done yet, sorry'),(191,91,'Step #2','Not done yet, sorry'),(192,91,'Step #3','Not done yet, sorry'),(193,92,'Step #1','Not done yet, sorry'),(194,93,'Step #1','Not done yet, sorry'),(195,93,'Step #2','Not done yet, sorry'),(196,93,'Step #3','Not done yet, sorry'),(197,94,'Step #1','Not done yet, sorry'),(198,95,'Step #1','Not done yet, sorry'),(199,96,'Step #1','Not done yet, sorry'),(200,96,'Step #2','Not done yet, sorry'),(201,97,'Step #1','Not done yet, sorry'),(202,97,'Step #2','Not done yet, sorry'),(203,98,'Step #1','Not done yet, sorry'),(204,98,'Step #2','Not done yet, sorry'),(205,98,'Step #3','Not done yet, sorry'),(206,99,'Step #1','Not done yet, sorry'),(207,99,'Step #2','Not done yet, sorry'),(208,99,'Step #3','Not done yet, sorry'),(209,100,'Step #1','Not done yet, sorry'),(210,100,'Step #2','Not done yet, sorry');
/*!40000 ALTER TABLE `steps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_uid` int(11) NOT NULL,
  `created_time` datetime NOT NULL,
  `assignee_uid` int(11) NOT NULL,
  `due_by` datetime DEFAULT NULL,
  `completed_time` datetime DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `title` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` VALUES (1,1,'2015-10-26 23:06:56',1,'2015-11-20 12:39:52','0000-00-00 00:00:00',1,'Fix the beer'),(2,1,'2015-10-26 23:06:56',1,'2015-12-16 13:00:39','0000-00-00 00:00:00',1,'Test the beer'),(3,1,'2015-10-26 23:06:56',1,'2015-11-15 22:55:56','2015-11-14 04:21:37',2,'Test the pasta'),(4,1,'2015-10-26 23:06:56',1,'2015-12-02 22:36:54','2015-12-09 07:38:52',2,'Confirm the meeting'),(5,1,'2015-10-26 23:06:56',1,'2015-11-25 09:57:58','2015-12-09 21:43:22',2,'Code the Java'),(6,1,'2015-10-26 23:06:56',1,'2015-12-02 00:24:07','2015-10-29 23:36:52',2,'Test the meeting'),(7,1,'2015-10-26 23:06:56',1,'2015-11-02 11:41:44','0000-00-00 00:00:00',1,'Paint the pizza'),(8,1,'2015-10-26 23:06:56',1,'2015-12-24 07:23:31','2015-12-13 22:19:59',2,'Drink the pasta'),(9,1,'2015-10-26 23:06:56',1,'2015-11-13 14:53:03','0000-00-00 00:00:00',1,'Test the PHP'),(10,1,'2015-10-26 23:06:56',1,'2015-11-30 18:31:27','2015-12-12 12:39:06',2,'Fix the user interface'),(11,1,'2015-10-26 23:06:56',1,'2015-11-20 09:50:56','0000-00-00 00:00:00',1,'Test the Jack Reed'),(12,1,'2015-10-26 23:06:56',1,'2015-12-01 00:34:39','2015-11-23 17:09:41',2,'Code the meeting'),(13,1,'2015-10-26 23:06:56',1,'2015-10-27 07:18:56','0000-00-00 00:00:00',1,'Paint the PHP'),(14,1,'2015-10-26 23:06:56',1,'2015-12-23 20:22:38','2015-11-24 09:36:55',2,'Fix the coffee'),(15,1,'2015-10-26 23:06:56',1,'2015-11-19 10:00:19','0000-00-00 00:00:00',1,'Confirm the Jack Reed'),(16,1,'2015-10-26 23:06:56',1,'2015-12-05 06:04:10','2015-11-03 09:44:15',2,'Test the beer'),(17,1,'2015-10-26 23:06:56',1,'2015-10-29 05:11:05','2015-12-23 08:36:31',2,'Confirm the pasta'),(18,1,'2015-10-26 23:06:56',1,'2015-12-03 05:10:07','2015-12-07 20:02:18',2,'Create the desktop application'),(19,1,'2015-10-26 23:06:56',1,'2015-12-01 22:22:20','0000-00-00 00:00:00',1,'Fix the beer'),(20,1,'2015-10-26 23:06:56',1,'2015-12-02 10:57:31','0000-00-00 00:00:00',1,'Paint the desktop application'),(21,1,'2015-10-26 23:06:56',1,'2015-10-27 18:19:13','2015-12-21 15:54:59',2,'Eat the Jack Reed'),(22,1,'2015-10-26 23:06:56',1,'2015-12-26 19:46:35','2015-11-28 03:28:49',2,'Code the user interface'),(23,1,'2015-10-26 23:06:56',1,'2015-12-11 11:25:42','2015-12-16 19:10:06',2,'Code the PHP'),(24,1,'2015-10-26 23:06:56',1,'2015-11-27 23:53:22','0000-00-00 00:00:00',1,'Paint the burgers'),(25,1,'2015-10-26 23:06:56',1,'2015-12-07 09:19:40','0000-00-00 00:00:00',1,'Confirm the Java'),(26,1,'2015-10-26 23:06:56',1,'2015-10-27 19:42:42','2015-11-28 02:39:25',2,'Test the Jack Reed'),(27,1,'2015-10-26 23:06:56',1,'2015-11-16 12:53:38','2015-11-08 22:47:41',2,'Confirm the user interface'),(28,1,'2015-10-26 23:06:56',1,'2015-11-06 15:08:00','0000-00-00 00:00:00',1,'Eat the coffee'),(29,1,'2015-10-26 23:06:56',1,'2015-11-03 02:58:00','0000-00-00 00:00:00',1,'Test the PHP'),(30,1,'2015-10-26 23:06:56',1,'2015-12-12 11:07:57','0000-00-00 00:00:00',1,'Fix the coffee'),(31,1,'2015-10-26 23:06:56',1,'2015-11-30 05:52:35','2015-11-07 22:37:37',2,'Eat the burgers'),(32,1,'2015-10-26 23:06:56',1,'2015-12-08 14:16:54','0000-00-00 00:00:00',1,'Drink the burgers'),(33,1,'2015-10-26 23:06:56',1,'2015-10-27 19:38:02','0000-00-00 00:00:00',1,'Code the PHP'),(34,1,'2015-10-26 23:06:56',1,'2015-12-21 15:30:39','2015-11-06 11:23:50',2,'Fix the user interface'),(35,1,'2015-10-26 23:06:56',1,'2015-11-23 03:36:34','2015-11-05 20:32:57',2,'Code the pasta'),(36,1,'2015-10-26 23:06:56',1,'2015-10-28 21:30:51','0000-00-00 00:00:00',1,'Create the coffee'),(37,1,'2015-10-26 23:06:56',1,'2015-10-27 15:42:11','0000-00-00 00:00:00',1,'Paint the user interface'),(38,1,'2015-10-26 23:06:56',1,'2015-11-10 18:37:34','0000-00-00 00:00:00',1,'Test the beer'),(39,1,'2015-10-26 23:06:56',1,'2015-11-26 11:37:58','2015-11-15 01:19:31',2,'Create the Jack Reed'),(40,1,'2015-10-26 23:06:56',1,'2015-11-14 06:36:59','0000-00-00 00:00:00',1,'Fix the Jack Reed'),(41,1,'2015-10-26 23:06:56',1,'2015-12-25 14:21:56','0000-00-00 00:00:00',1,'Code the pizza'),(42,1,'2015-10-26 23:06:56',1,'2015-11-20 16:36:08','0000-00-00 00:00:00',1,'Eat the pasta'),(43,1,'2015-10-26 23:06:56',1,'2015-11-04 23:09:52','0000-00-00 00:00:00',1,'Paint the pasta'),(44,1,'2015-10-26 23:06:56',1,'2015-12-14 16:30:13','0000-00-00 00:00:00',1,'Eat the desktop application'),(45,1,'2015-10-26 23:06:56',1,'2015-11-22 22:00:04','2015-12-14 12:37:09',2,'Test the meeting'),(46,1,'2015-10-26 23:06:56',1,'2015-12-18 01:45:59','2015-11-03 23:14:24',2,'Create the meeting'),(47,1,'2015-10-26 23:06:56',1,'2015-11-01 02:26:19','2015-11-29 14:32:59',2,'Confirm the pizza'),(48,1,'2015-10-26 23:06:56',1,'2015-11-07 14:27:52','2015-12-01 17:29:56',2,'Test the beer'),(49,1,'2015-10-26 23:06:56',1,'2015-11-19 14:27:13','2015-11-05 01:15:45',2,'Test the pasta'),(50,1,'2015-10-26 23:06:56',1,'2015-12-01 11:04:30','0000-00-00 00:00:00',1,'Create the beer'),(51,1,'2015-10-26 23:06:56',1,'2015-12-16 05:29:07','2015-11-08 11:23:01',2,'Drink the code'),(52,1,'2015-10-26 23:06:56',1,'2015-12-26 14:49:51','2015-12-11 12:51:01',2,'Code the code'),(53,1,'2015-10-26 23:06:56',1,'2015-12-24 23:02:40','0000-00-00 00:00:00',1,'Paint the beer'),(54,1,'2015-10-26 23:06:56',1,'2015-12-17 04:18:22','2015-11-15 23:50:45',2,'Paint the desktop application'),(55,1,'2015-10-26 23:06:56',1,'2015-11-03 10:02:24','0000-00-00 00:00:00',1,'Confirm the coffee'),(56,1,'2015-10-26 23:06:56',1,'2015-12-07 08:13:19','2015-12-06 14:07:58',2,'Create the user interface'),(57,1,'2015-10-26 23:06:56',1,'2015-11-04 01:37:25','0000-00-00 00:00:00',1,'Code the PHP'),(58,1,'2015-10-26 23:06:56',1,'2015-12-21 05:12:22','2015-11-30 02:09:55',2,'Eat the burgers'),(59,1,'2015-10-26 23:06:56',1,'2015-11-13 17:52:43','2015-10-27 01:17:19',2,'Paint the coffee'),(60,1,'2015-10-26 23:06:56',1,'2015-12-13 07:45:01','0000-00-00 00:00:00',1,'Create the coffee'),(61,1,'2015-10-26 23:06:56',1,'2015-11-29 11:05:50','0000-00-00 00:00:00',1,'Confirm the user interface'),(62,1,'2015-10-26 23:06:56',1,'2015-12-01 19:06:43','2015-11-25 22:01:26',2,'Create the PHP'),(63,1,'2015-10-26 23:06:56',1,'2015-11-28 23:25:25','2015-12-10 18:35:42',2,'Drink the code'),(64,1,'2015-10-26 23:06:56',1,'2015-12-21 07:54:51','2015-12-21 18:05:47',2,'Eat the burgers'),(65,1,'2015-10-26 23:06:56',1,'2015-11-29 23:45:39','2015-12-15 01:59:44',2,'Eat the code'),(66,1,'2015-10-26 23:06:56',1,'2015-12-06 09:35:59','0000-00-00 00:00:00',1,'Drink the PHP'),(67,1,'2015-10-26 23:06:56',1,'2015-12-16 10:44:25','0000-00-00 00:00:00',1,'Eat the user interface'),(68,1,'2015-10-26 23:06:56',1,'2015-12-13 14:23:27','0000-00-00 00:00:00',1,'Code the code'),(69,1,'2015-10-26 23:06:56',1,'2015-11-28 07:12:55','0000-00-00 00:00:00',1,'Test the meeting'),(70,1,'2015-10-26 23:06:56',1,'2015-11-20 04:21:44','2015-11-15 18:09:06',2,'Test the code'),(71,1,'2015-10-26 23:06:56',1,'2015-12-01 13:52:37','0000-00-00 00:00:00',1,'Fix the burgers'),(72,1,'2015-10-26 23:06:56',1,'2015-11-22 23:28:56','2015-11-14 21:02:24',2,'Confirm the user interface'),(73,1,'2015-10-26 23:06:56',1,'2015-10-30 13:55:59','0000-00-00 00:00:00',1,'Test the coffee'),(74,1,'2015-10-26 23:06:56',1,'2015-11-03 19:05:45','2015-11-23 10:55:27',2,'Drink the user interface'),(75,1,'2015-10-26 23:06:56',1,'2015-12-20 17:36:29','0000-00-00 00:00:00',1,'Fix the Java'),(76,1,'2015-10-26 23:06:56',1,'2015-10-28 02:13:39','2015-10-28 11:30:27',2,'Create the desktop application'),(77,1,'2015-10-26 23:06:56',1,'2015-11-10 18:57:14','0000-00-00 00:00:00',1,'Fix the meeting'),(78,1,'2015-10-26 23:06:56',1,'2015-12-18 06:07:31','2015-11-20 01:59:22',2,'Test the user interface'),(79,1,'2015-10-26 23:06:56',1,'2015-12-03 17:21:43','0000-00-00 00:00:00',1,'Create the PHP'),(80,1,'2015-10-26 23:06:56',1,'2015-11-14 17:29:30','2015-11-20 11:03:47',2,'Confirm the burgers'),(81,1,'2015-10-26 23:06:56',1,'2015-12-06 09:10:00','2015-12-15 11:31:45',2,'Create the burgers'),(82,1,'2015-10-26 23:06:56',1,'2015-12-20 08:01:59','2015-12-20 00:50:57',2,'Drink the coffee'),(83,1,'2015-10-26 23:06:56',1,'2015-12-21 08:44:01','2015-12-03 00:02:33',2,'Eat the Java'),(84,1,'2015-10-26 23:06:56',1,'2015-12-14 22:18:10','2015-11-17 13:41:03',2,'Code the pizza'),(85,1,'2015-10-26 23:06:56',1,'2015-11-29 20:09:43','0000-00-00 00:00:00',1,'Fix the pizza'),(86,1,'2015-10-26 23:06:56',1,'2015-10-31 22:23:41','0000-00-00 00:00:00',1,'Code the Java'),(87,1,'2015-10-26 23:06:56',1,'2015-12-18 08:31:16','0000-00-00 00:00:00',1,'Test the Java'),(88,1,'2015-10-26 23:06:56',1,'2015-11-17 15:32:38','0000-00-00 00:00:00',1,'Fix the PHP'),(89,1,'2015-10-26 23:06:56',1,'2015-11-03 00:58:52','2015-11-18 08:40:33',2,'Fix the Java'),(90,1,'2015-10-26 23:06:56',1,'2015-12-06 10:19:47','2015-12-09 08:45:28',2,'Create the PHP'),(91,1,'2015-10-26 23:06:56',1,'2015-12-02 17:49:29','0000-00-00 00:00:00',1,'Fix the desktop application'),(92,1,'2015-10-26 23:06:56',1,'2015-11-30 01:54:21','2015-11-29 18:55:32',2,'Drink the code'),(93,1,'2015-10-26 23:06:56',1,'2015-12-10 16:59:10','2015-12-16 13:10:33',2,'Create the meeting'),(94,1,'2015-10-26 23:06:56',1,'2015-11-09 17:07:57','2015-11-06 16:58:56',2,'Eat the pasta'),(95,1,'2015-10-26 23:06:56',1,'2015-12-08 12:44:56','2015-12-24 23:14:25',2,'Paint the desktop application'),(96,1,'2015-10-26 23:06:56',1,'2015-12-06 15:10:48','0000-00-00 00:00:00',1,'Code the Jack Reed'),(97,1,'2015-10-26 23:06:56',1,'2015-12-04 13:41:14','2015-11-25 12:11:14',2,'Code the beer'),(98,1,'2015-10-26 23:06:56',1,'2015-11-13 14:24:38','2015-12-05 00:00:49',2,'Paint the code'),(99,1,'2015-10-26 23:06:56',1,'2015-12-03 23:09:40','2015-11-03 20:16:16',2,'Drink the beer'),(100,1,'2015-10-26 23:06:56',1,'2015-12-20 21:57:18','2015-11-14 23:23:18',2,'Paint the Java');
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(300) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin` int(1) NOT NULL DEFAULT '0',
  `api_token` varchar(73) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'dkm2@aber.ac.uk','Daniel Monaghan','$2y$10$4s8rrPg6K4.BsoW.DJ9Pv.i0DRRTXeGpKKcvKq7XA1HwA3Li2Axyu',1,'332A775A-B13C-48E3-B1A9-BDD8CEFAFE3D-14B53F63-8A34-43E6-AD5A-B8265D6A4199');
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

-- Dump completed on 2015-10-28 17:39:09
