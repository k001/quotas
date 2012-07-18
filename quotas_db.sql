-- MySQL dump 10.11
--
-- Host: localhost    Database: quotas_db
-- ------------------------------------------------------
-- Server version	5.0.77

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
-- Table structure for table `quotas_user`
--

DROP TABLE IF EXISTS `quotas_user`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `quotas_user` (
  `id` int(11) NOT NULL auto_increment,
  `form_id` int(11) NOT NULL,
  `1h` varchar(45) NOT NULL default '0',
  `1m` varchar(45) NOT NULL default '0',
  `2h` varchar(45) NOT NULL default '0',
  `2m` varchar(45) NOT NULL default '0',
  `3h` varchar(45) NOT NULL default '0',
  `3m` varchar(45) NOT NULL default '0',
  `4h` varchar(45) NOT NULL default '0',
  `4m` varchar(45) NOT NULL default '0',
  `5h` varchar(45) NOT NULL default '0',
  `5m` varchar(45) NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '0',
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `quotas_user`
--

LOCK TABLES `quotas_user` WRITE;
/*!40000 ALTER TABLE `quotas_user` DISABLE KEYS */;
INSERT INTO `quotas_user` VALUES (1,4,'90','70','80','180','70','170','60','160','50','150',0,'2012-07-14 00:15:10'),(2,1,'10','11','15','16','17','18','19','90','0','99',0,'2012-07-13 21:36:12');
/*!40000 ALTER TABLE `quotas_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-07-17 17:39:33
