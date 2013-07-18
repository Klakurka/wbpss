-- MySQL dump 10.13  Distrib 5.1.58, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: ps_user
-- ------------------------------------------------------
-- Server version	5.1.58-1ubuntu1

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
-- Current Database: `ps_user`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `ps_user` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `ps_user`;

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_sessions`
--

LOCK TABLES `ci_sessions` WRITE;
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
INSERT INTO `ci_sessions` VALUES ('9eb242e66baffce81f78fbe98fa8f274','24.69.71.239','Mozilla/5.0 (Windows NT 6.1; WOW64; rv:14.0) Gecko/20100101 Firefox/14.0.1',1345458275,'a:3:{s:9:\"user_data\";s:0:\"\";s:19:\"flash:old:last_page\";s:43:\"http://mazda.frosted-pixels.ca/pricesheets/\";s:17:\"flash:old:warning\";s:26:\"Please login to view page.\";}'),('a0b05f328d91dbe5ad71a9ce16a4251c','24.108.18.206','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.79 Safari/537.1',1345462086,'a:5:{s:9:\"user_data\";s:0:\"\";s:7:\"user_id\";s:2:\"15\";s:12:\"accessrights\";s:1:\"1\";s:10:\"dealership\";s:13:\"Pacific Mazda\";s:9:\"logged_in\";b:1;}');
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblAccessRights`
--

DROP TABLE IF EXISTS `tblAccessRights`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblAccessRights` (
  `intAccessRightsID` int(11) NOT NULL AUTO_INCREMENT,
  `strAccessRightsDescription` varchar(45) NOT NULL,
  `intMasterAccessRightsID` int(11) DEFAULT NULL,
  PRIMARY KEY (`intAccessRightsID`),
  KEY `fk_tblAccessRights_tblAccessRights1` (`intMasterAccessRightsID`),
  CONSTRAINT `fk_tblAccessRights_tblAccessRights1` FOREIGN KEY (`intMasterAccessRightsID`) REFERENCES `tblAccessRights` (`intAccessRightsID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblAccessRights`
--

LOCK TABLES `tblAccessRights` WRITE;
/*!40000 ALTER TABLE `tblAccessRights` DISABLE KEYS */;
INSERT INTO `tblAccessRights` VALUES (1,'master_admin',NULL),(2,'local_admin',1),(3,'dealer',2);
/*!40000 ALTER TABLE `tblAccessRights` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblContactMechanism`
--

DROP TABLE IF EXISTS `tblContactMechanism`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblContactMechanism` (
  `intContactMechanismID` int(11) NOT NULL AUTO_INCREMENT,
  `intGeographicBoundaryID` int(11) DEFAULT NULL,
  `strAddressLine1` varchar(64) NOT NULL,
  `strAddressLine2` varchar(45) DEFAULT NULL,
  `strPostalCode` varchar(6) NOT NULL,
  PRIMARY KEY (`intContactMechanismID`),
  KEY `fk_tblContactMechanism_tblGeographicBoundary1` (`intGeographicBoundaryID`),
  CONSTRAINT `fk_tblContactMechanism_tblGeographicBoundary10` FOREIGN KEY (`intGeographicBoundaryID`) REFERENCES `tblGeographicBoundary` (`intGeographicBoundaryID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblContactMechanism`
--

LOCK TABLES `tblContactMechanism` WRITE;
/*!40000 ALTER TABLE `tblContactMechanism` DISABLE KEYS */;
INSERT INTO `tblContactMechanism` VALUES (1,6,'','',''),(2,8,'2276 Bellamy rd','','V9B3M4'),(3,9,'gg','aa','ASDF'),(4,6,'','',''),(5,6,'','',''),(6,6,'','','');
/*!40000 ALTER TABLE `tblContactMechanism` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblDealership`
--

DROP TABLE IF EXISTS `tblDealership`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblDealership` (
  `intPartyID` int(11) NOT NULL AUTO_INCREMENT,
  `strDealershipName` varchar(45) NOT NULL,
  PRIMARY KEY (`intPartyID`),
  CONSTRAINT `fk_tblDealership_tblParty10` FOREIGN KEY (`intPartyID`) REFERENCES `tblParty` (`intPartyID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblDealership`
--

LOCK TABLES `tblDealership` WRITE;
/*!40000 ALTER TABLE `tblDealership` DISABLE KEYS */;
INSERT INTO `tblDealership` VALUES (30,'Pacific Mazda'),(38,'Suburban Ford'),(54,'Pacific Mazda'),(56,'Blumberg\'s Car Mart'),(59,'Blumberg\'s Car Mart'),(60,'Blumberg\'s Car Mart'),(61,'Wibbly Wobbly Drivy Wivy'),(62,'Blumberg\'s Car Mart'),(63,'Blumberg\'s Car Mart'),(64,'Blumberg\'s Car Mart'),(65,'Pacific Mazda'),(67,'Dealership B');
/*!40000 ALTER TABLE `tblDealership` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblGeographicBoundary`
--

DROP TABLE IF EXISTS `tblGeographicBoundary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblGeographicBoundary` (
  `intGeographicBoundaryID` int(11) NOT NULL AUTO_INCREMENT,
  `strCityName` varchar(45) NOT NULL,
  `strProvName` varchar(45) DEFAULT NULL,
  `strCountryName` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`intGeographicBoundaryID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblGeographicBoundary`
--

LOCK TABLES `tblGeographicBoundary` WRITE;
/*!40000 ALTER TABLE `tblGeographicBoundary` DISABLE KEYS */;
INSERT INTO `tblGeographicBoundary` VALUES (6,'','',''),(8,'Victoria','British Columbia','Canada'),(9,'asdf','asdf','asdf');
/*!40000 ALTER TABLE `tblGeographicBoundary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblParty`
--

DROP TABLE IF EXISTS `tblParty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblParty` (
  `intPartyID` int(11) NOT NULL AUTO_INCREMENT,
  `tmCreationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `intCreatedByPartyID` int(11) DEFAULT NULL,
  PRIMARY KEY (`intPartyID`),
  KEY `fk_tblParty_intPartyID` (`intCreatedByPartyID`),
  CONSTRAINT `fk_tblParty_intPartyID0` FOREIGN KEY (`intCreatedByPartyID`) REFERENCES `tblParty` (`intPartyID`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblParty`
--

LOCK TABLES `tblParty` WRITE;
/*!40000 ALTER TABLE `tblParty` DISABLE KEYS */;
INSERT INTO `tblParty` VALUES (29,'2012-06-21 05:55:59',NULL),(30,'2012-06-21 05:56:00',29),(33,'2012-06-25 00:41:21',29),(38,'2012-06-25 18:18:01',29),(53,'2012-07-27 01:42:08',29),(54,'2012-07-27 01:42:08',29),(56,'2012-07-28 20:25:46',29),(59,'2012-08-01 21:04:55',29),(60,'2012-08-01 21:05:03',29),(61,'2012-08-01 21:05:26',29),(62,'2012-08-02 01:01:54',29),(63,'2012-08-16 19:27:51',29),(64,'2012-08-16 19:27:56',29),(65,'2012-08-16 19:28:02',29),(66,'2012-08-17 20:50:45',29),(67,'2012-08-17 20:50:45',29);
/*!40000 ALTER TABLE `tblParty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblPartyContactMechanism`
--

DROP TABLE IF EXISTS `tblPartyContactMechanism`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblPartyContactMechanism` (
  `intPartyContactMechanismID` int(11) NOT NULL AUTO_INCREMENT,
  `intContactMechanismID` int(11) DEFAULT NULL,
  `intPartyID` int(11) NOT NULL,
  `intRoleID` int(11) NOT NULL,
  `strPhoneNumber` varchar(15) DEFAULT NULL,
  `strEmail` varchar(256) NOT NULL,
  PRIMARY KEY (`intPartyContactMechanismID`),
  KEY `fk_tblContact_tblParty1` (`intPartyID`),
  KEY `fk_tblPartyContactMechanism_tblRole1` (`intRoleID`),
  KEY `fk_tblPartyContactMechanism_tblContactMechanism1` (`intContactMechanismID`),
  CONSTRAINT `fk_tblPartyContactMechanism_tblContactMechanism10` FOREIGN KEY (`intContactMechanismID`) REFERENCES `tblContactMechanism` (`intContactMechanismID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_tblContact_tblParty10` FOREIGN KEY (`intPartyID`) REFERENCES `tblParty` (`intPartyID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_tblPartyContactMechanism_tblRole10` FOREIGN KEY (`intRoleID`) REFERENCES `tblRole` (`intRoleID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblPartyContactMechanism`
--

LOCK TABLES `tblPartyContactMechanism` WRITE;
/*!40000 ALTER TABLE `tblPartyContactMechanism` DISABLE KEYS */;
INSERT INTO `tblPartyContactMechanism` VALUES (1,2,29,1,'',''),(2,3,33,1,'',''),(5,6,53,1,'','');
/*!40000 ALTER TABLE `tblPartyContactMechanism` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblPartyRole`
--

DROP TABLE IF EXISTS `tblPartyRole`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblPartyRole` (
  `intPartyRoleID` int(11) NOT NULL AUTO_INCREMENT,
  `intRoleID` int(11) NOT NULL,
  `intPartyID` int(11) NOT NULL,
  PRIMARY KEY (`intPartyRoleID`),
  KEY `fk_tblPartyRole_tblRole1` (`intRoleID`),
  KEY `fk_tblPartyRole_tblParty1` (`intPartyID`),
  CONSTRAINT `fk_tblPartyRole_tblParty10` FOREIGN KEY (`intPartyID`) REFERENCES `tblParty` (`intPartyID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_tblPartyRole_tblRole10` FOREIGN KEY (`intRoleID`) REFERENCES `tblRole` (`intRoleID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblPartyRole`
--

LOCK TABLES `tblPartyRole` WRITE;
/*!40000 ALTER TABLE `tblPartyRole` DISABLE KEYS */;
INSERT INTO `tblPartyRole` VALUES (15,1,29),(18,1,33),(29,1,53),(32,1,66);
/*!40000 ALTER TABLE `tblPartyRole` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblPerson`
--

DROP TABLE IF EXISTS `tblPerson`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblPerson` (
  `intPartyID` int(11) NOT NULL AUTO_INCREMENT,
  `strFirstName` varchar(45) NOT NULL,
  `strLastName` varchar(45) NOT NULL,
  PRIMARY KEY (`intPartyID`),
  CONSTRAINT `fk_tblPerson_tblParty0` FOREIGN KEY (`intPartyID`) REFERENCES `tblParty` (`intPartyID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblPerson`
--

LOCK TABLES `tblPerson` WRITE;
/*!40000 ALTER TABLE `tblPerson` DISABLE KEYS */;
INSERT INTO `tblPerson` VALUES (29,'Joseph','Woolfrey'),(33,'David','Klakurka'),(53,'Tylor','Goudie'),(66,'a','a');
/*!40000 ALTER TABLE `tblPerson` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblRole`
--

DROP TABLE IF EXISTS `tblRole`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblRole` (
  `intRoleID` int(11) NOT NULL AUTO_INCREMENT,
  `strRoleDescription` varchar(45) NOT NULL,
  PRIMARY KEY (`intRoleID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblRole`
--

LOCK TABLES `tblRole` WRITE;
/*!40000 ALTER TABLE `tblRole` DISABLE KEYS */;
INSERT INTO `tblRole` VALUES (1,'user');
/*!40000 ALTER TABLE `tblRole` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblUser`
--

DROP TABLE IF EXISTS `tblUser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblUser` (
  `intPartyRoleID` int(11) NOT NULL AUTO_INCREMENT,
  `strUserName` varchar(45) NOT NULL,
  `strUserPass` varchar(128) NOT NULL,
  `intAccessRightsID` int(11) NOT NULL,
  `intDealershipID` int(11) NOT NULL,
  PRIMARY KEY (`intPartyRoleID`),
  UNIQUE KEY `strUserName_UNIQUE` (`strUserName`),
  KEY `fk_tblUser_tblAccessRights1` (`intAccessRightsID`),
  KEY `fk_tblUser_tblDealership1` (`intDealershipID`),
  CONSTRAINT `fk_tblUser_tblAccessRights10` FOREIGN KEY (`intAccessRightsID`) REFERENCES `tblAccessRights` (`intAccessRightsID`) ON UPDATE CASCADE,
  CONSTRAINT `fk_tblUser_tblDealership10` FOREIGN KEY (`intDealershipID`) REFERENCES `tblDealership` (`intPartyID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_tblUser_tblPartyRole10` FOREIGN KEY (`intPartyRoleID`) REFERENCES `tblPartyRole` (`intPartyRoleID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblUser`
--

LOCK TABLES `tblUser` WRITE;
/*!40000 ALTER TABLE `tblUser` DISABLE KEYS */;
INSERT INTO `tblUser` VALUES (15,'Frosted','$6$R2PCyGVW$zbe1RyIQywy6efbTVl7JtMlmodq7.l85ckIBZL1Ipmx4ZmKv5hl7qBjnTyIHEXm7SfJQGQZKDZG1GG9syL5lH/',1,30),(18,'Klakurka','$6$Wf8n8oks$KZtuEhHM1nMpQBKRapPMCpDtS.EKGK9L4jdu9XJdKgGM4238P1wq4T4VkG/webo.EOFdwjf6MVDvu651SNbFx/',2,65),(29,'FyreIsAwesome','$6$gTsb6/G9$R6/rrhq5d8bs8WPALsFbKhVn7IpYGnx1rS1Kni7dMs12bu.xkplS4jL9wZZAZx0CW/pUrOEeT49S9jZih254y0',3,59),(32,'dealerTest','$6$4PG3rYV2$iForr.0290VKERO5LJhVWm9zam6A9MklhbeCXtMoFfHig0LjiMu7ximg3uBmYTYPPxeXNWmoJHA1CN3CngsKl0',2,67);
/*!40000 ALTER TABLE `tblUser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `vContact`
--

DROP TABLE IF EXISTS `vContact`;
/*!50001 DROP VIEW IF EXISTS `vContact`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vContact` (
  `strUserName` varchar(45),
  `strRoleDescription` varchar(45),
  `strPhoneNumber` varchar(15),
  `strEmail` varchar(256),
  `strAddressLine1` varchar(64),
  `strAddressLine2` varchar(45),
  `strCityName` varchar(45),
  `strProvName` varchar(45),
  `strCountryName` varchar(45),
  `strPostalCode` varchar(6)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vUser`
--

DROP TABLE IF EXISTS `vUser`;
/*!50001 DROP VIEW IF EXISTS `vUser`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vUser` (
  `intPartyID` int(11),
  `strUserName` varchar(45),
  `strUserPass` varchar(128),
  `intAccessRightsID` int(11),
  `strAccessRightsDescription` varchar(45),
  `strDealershipName` varchar(45),
  `strFirstName` varchar(45),
  `strLastName` varchar(45)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vUserHierarchy`
--

DROP TABLE IF EXISTS `vUserHierarchy`;
/*!50001 DROP VIEW IF EXISTS `vUserHierarchy`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vUserHierarchy` (
  `intAccessRightsID` int(11),
  `strAccessRightsDescription` varchar(45),
  `master` varchar(45)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Current Database: `ps_accessory`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `ps_accessory` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `ps_accessory`;

--
-- Table structure for table `tblAccessory`
--

DROP TABLE IF EXISTS `tblAccessory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblAccessory` (
  `intAccessoryID` int(11) NOT NULL AUTO_INCREMENT,
  `strAccessoryName` varchar(64) NOT NULL,
  PRIMARY KEY (`intAccessoryID`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblAccessory`
--

LOCK TABLES `tblAccessory` WRITE;
/*!40000 ALTER TABLE `tblAccessory` DISABLE KEYS */;
INSERT INTO `tblAccessory` VALUES (41,'Item'),(47,'Cost Reduction'),(48,'White Pearl Paint');
/*!40000 ALTER TABLE `tblAccessory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblAccessoryPackage`
--

DROP TABLE IF EXISTS `tblAccessoryPackage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblAccessoryPackage` (
  `intAccessoryID` int(11) NOT NULL,
  `intPricesheetID` int(11) NOT NULL,
  PRIMARY KEY (`intAccessoryID`,`intPricesheetID`),
  KEY `fk_tblAccessoryPackage_tblPricesheet1` (`intPricesheetID`),
  CONSTRAINT `fk_tblAccessoryPackage_tblAccessory00` FOREIGN KEY (`intAccessoryID`) REFERENCES `tblAccessory` (`intAccessoryID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tblAccessoryPackage_tblPricesheet100` FOREIGN KEY (`intPricesheetID`) REFERENCES `tblPricesheet` (`intPricesheetID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblAccessoryPackage`
--

LOCK TABLES `tblAccessoryPackage` WRITE;
/*!40000 ALTER TABLE `tblAccessoryPackage` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblAccessoryPackage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblModelAccessory`
--

DROP TABLE IF EXISTS `tblModelAccessory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblModelAccessory` (
  `intAccessoryID` int(11) NOT NULL,
  `strModelCode` varchar(8) NOT NULL,
  `numAccessoryPrice` float NOT NULL,
  PRIMARY KEY (`intAccessoryID`,`strModelCode`),
  KEY `fk_tblModelAccessory_tblAccessory1` (`intAccessoryID`),
  CONSTRAINT `fk_tblModelAccessory_tblAccessory1` FOREIGN KEY (`intAccessoryID`) REFERENCES `tblAccessory` (`intAccessoryID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblModelAccessory`
--

LOCK TABLES `tblModelAccessory` WRITE;
/*!40000 ALTER TABLE `tblModelAccessory` DISABLE KEYS */;
INSERT INTO `tblModelAccessory` VALUES (41,'098',12),(41,'12asas',150),(41,'1L3E3E7T',9000),(41,'555',12),(41,'W007',9001),(47,'555ASD',-900),(47,'A44LF',-500),(48,'D4SK63',500),(48,'M4A456',700);
/*!40000 ALTER TABLE `tblModelAccessory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblPricesheet`
--

DROP TABLE IF EXISTS `tblPricesheet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblPricesheet` (
  `intPricesheetID` int(11) NOT NULL AUTO_INCREMENT,
  `strModelCode` varchar(10) NOT NULL,
  `strOptionCode` varchar(10) NOT NULL,
  PRIMARY KEY (`intPricesheetID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblPricesheet`
--

LOCK TABLES `tblPricesheet` WRITE;
/*!40000 ALTER TABLE `tblPricesheet` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblPricesheet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Current Database: `ps_vehicle`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `ps_vehicle` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `ps_vehicle`;

--
-- Table structure for table `tblBrake`
--

DROP TABLE IF EXISTS `tblBrake`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblBrake` (
  `intBrakeID` int(11) NOT NULL AUTO_INCREMENT,
  `strBrakeName` varchar(45) NOT NULL,
  PRIMARY KEY (`intBrakeID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblBrake`
--

LOCK TABLES `tblBrake` WRITE;
/*!40000 ALTER TABLE `tblBrake` DISABLE KEYS */;
INSERT INTO `tblBrake` VALUES (3,'C'),(4,'asdf'),(5,'A');
/*!40000 ALTER TABLE `tblBrake` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblColour`
--

DROP TABLE IF EXISTS `tblColour`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblColour` (
  `intColourID` int(11) NOT NULL AUTO_INCREMENT,
  `strColourCode` varchar(6) NOT NULL,
  `strColourName` varchar(45) NOT NULL,
  PRIMARY KEY (`intColourID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblColour`
--

LOCK TABLES `tblColour` WRITE;
/*!40000 ALTER TABLE `tblColour` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblColour` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblEngine`
--

DROP TABLE IF EXISTS `tblEngine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblEngine` (
  `intEngineID` int(11) NOT NULL AUTO_INCREMENT,
  `strEngineName` varchar(45) NOT NULL,
  `intHorsePower` int(11) DEFAULT NULL,
  `intHorsePowerRPM` int(11) DEFAULT NULL,
  `intTorque` int(11) DEFAULT NULL,
  `intTorqueRPM` int(11) DEFAULT NULL,
  PRIMARY KEY (`intEngineID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblEngine`
--

LOCK TABLES `tblEngine` WRITE;
/*!40000 ALTER TABLE `tblEngine` DISABLE KEYS */;
INSERT INTO `tblEngine` VALUES (4,'A',200,300,200,300),(5,'asdf',1,1,1,1);
/*!40000 ALTER TABLE `tblEngine` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblEngineeringFeature`
--

DROP TABLE IF EXISTS `tblEngineeringFeature`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblEngineeringFeature` (
  `intEngineeringFeatureID` int(11) NOT NULL AUTO_INCREMENT,
  `intBrakeID` int(11) NOT NULL,
  `intTransmissionID` int(11) NOT NULL,
  `intEngineID` int(11) NOT NULL,
  `intSteeringID` int(11) NOT NULL,
  `numFuelCapacity` float NOT NULL,
  `numLitresPer100km_City` float NOT NULL,
  `numLitresPer100km_Hwy` float NOT NULL,
  PRIMARY KEY (`intEngineeringFeatureID`),
  KEY `fk_tblEngineeringFeature_tblBrake1` (`intBrakeID`),
  KEY `fk_tblEngineeringFeature_tblTransmission1` (`intTransmissionID`),
  KEY `fk_tblEngineeringFeature_tblEngine1` (`intEngineID`),
  KEY `fk_tblEngineeringFeature_tblSteering1` (`intSteeringID`),
  CONSTRAINT `fk_tblEngineeringFeature_tblBrake1` FOREIGN KEY (`intBrakeID`) REFERENCES `tblBrake` (`intBrakeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tblEngineeringFeature_tblEngine1` FOREIGN KEY (`intEngineID`) REFERENCES `tblEngine` (`intEngineID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tblEngineeringFeature_tblSteering1` FOREIGN KEY (`intSteeringID`) REFERENCES `tblSteering` (`intSteeringID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tblEngineeringFeature_tblTransmission1` FOREIGN KEY (`intTransmissionID`) REFERENCES `tblTransmission` (`intTransmissionID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblEngineeringFeature`
--

LOCK TABLES `tblEngineeringFeature` WRITE;
/*!40000 ALTER TABLE `tblEngineeringFeature` DISABLE KEYS */;
INSERT INTO `tblEngineeringFeature` VALUES (3,3,6,4,2,10,200,300),(4,4,7,5,3,120,12,12),(5,5,8,5,4,3,3,3),(6,5,8,4,4,1,1,1),(7,5,8,4,5,1,1,1);
/*!40000 ALTER TABLE `tblEngineeringFeature` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblFeature`
--

DROP TABLE IF EXISTS `tblFeature`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblFeature` (
  `intFeatureID` int(11) NOT NULL AUTO_INCREMENT,
  `strFeatureName` varchar(128) NOT NULL,
  PRIMARY KEY (`intFeatureID`)
) ENGINE=InnoDB AUTO_INCREMENT=182 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblFeature`
--

LOCK TABLES `tblFeature` WRITE;
/*!40000 ALTER TABLE `tblFeature` DISABLE KEYS */;
INSERT INTO `tblFeature` VALUES (177,'External Door Handle - Body Coloured'),(179,'Black Grille w/ Matte Finish Grille Bar'),(180,'Don\'t show up');
/*!40000 ALTER TABLE `tblFeature` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblMake`
--

DROP TABLE IF EXISTS `tblMake`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblMake` (
  `intMakeID` int(11) NOT NULL AUTO_INCREMENT,
  `strMakeName` varchar(45) NOT NULL,
  PRIMARY KEY (`intMakeID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblMake`
--

LOCK TABLES `tblMake` WRITE;
/*!40000 ALTER TABLE `tblMake` DISABLE KEYS */;
INSERT INTO `tblMake` VALUES (2,'Mazda');
/*!40000 ALTER TABLE `tblMake` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblModel`
--

DROP TABLE IF EXISTS `tblModel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblModel` (
  `intModelID` int(11) NOT NULL AUTO_INCREMENT,
  `strModelCode` varchar(10) NOT NULL,
  `strModelName` varchar(45) NOT NULL,
  `intYear` int(11) NOT NULL,
  `strModelSlogan` varchar(64) DEFAULT NULL,
  `intTrimID` int(11) NOT NULL,
  `intMakeID` int(11) NOT NULL,
  `intEngineeringFeatureID` int(11) NOT NULL,
  PRIMARY KEY (`intModelID`),
  KEY `fk_tblModel_tblTrim1` (`intTrimID`),
  KEY `fk_tblModel_tblMake1` (`intMakeID`),
  KEY `fk_tblModel_tblEngineeringFeature1` (`intEngineeringFeatureID`),
  CONSTRAINT `fk_tblModel_tblEngineeringFeature1` FOREIGN KEY (`intEngineeringFeatureID`) REFERENCES `tblEngineeringFeature` (`intEngineeringFeatureID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tblModel_tblMake1` FOREIGN KEY (`intMakeID`) REFERENCES `tblMake` (`intMakeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tblModel_tblTrim1` FOREIGN KEY (`intTrimID`) REFERENCES `tblTrim` (`intTrimID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblModel`
--

LOCK TABLES `tblModel` WRITE;
/*!40000 ALTER TABLE `tblModel` DISABLE KEYS */;
INSERT INTO `tblModel` VALUES (3,'ASDF','Derp-mobile',2012,'',9,2,3),(4,'M4A456','Mazda3 Sport',2013,'',8,2,4),(5,'ASDFSADF','asdfsadf',2012,'',6,2,5),(6,'ASDFF','ASDFF',2012,'',9,2,3),(7,'A','a',2012,'',6,2,6),(8,'M4A479','asdf',2012,'',6,2,7);
/*!40000 ALTER TABLE `tblModel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblModelColour`
--

DROP TABLE IF EXISTS `tblModelColour`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblModelColour` (
  `intModelColourID` int(11) NOT NULL AUTO_INCREMENT,
  `intModelID` int(11) NOT NULL,
  `intInteriorColourID` int(11) NOT NULL,
  `intExteriorColourID` int(11) NOT NULL,
  `intLowerColourID` int(11) NOT NULL,
  PRIMARY KEY (`intModelColourID`),
  KEY `fk_tblModelColour_tblModel1` (`intModelID`),
  KEY `fk_tblModelColour_tblColour1` (`intInteriorColourID`),
  KEY `fk_tblModelColour_tblColour2` (`intExteriorColourID`),
  KEY `fk_tblModelColour_tblColour3` (`intLowerColourID`),
  CONSTRAINT `fk_tblModelColour_tblColour3` FOREIGN KEY (`intLowerColourID`) REFERENCES `tblColour` (`intColourID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tblModelColour_tblColour1` FOREIGN KEY (`intInteriorColourID`) REFERENCES `tblColour` (`intColourID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tblModelColour_tblColour2` FOREIGN KEY (`intExteriorColourID`) REFERENCES `tblColour` (`intColourID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tblModelColour_tblModel1` FOREIGN KEY (`intModelID`) REFERENCES `tblModel` (`intModelID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblModelColour`
--

LOCK TABLES `tblModelColour` WRITE;
/*!40000 ALTER TABLE `tblModelColour` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblModelColour` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblModelFeature`
--

DROP TABLE IF EXISTS `tblModelFeature`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblModelFeature` (
  `intFeatureID` int(11) NOT NULL,
  `strModelCode` varchar(8) NOT NULL,
  PRIMARY KEY (`intFeatureID`,`strModelCode`),
  CONSTRAINT `fk_tblModelFeature_tblFeature1` FOREIGN KEY (`intFeatureID`) REFERENCES `tblFeature` (`intFeatureID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblModelFeature`
--

LOCK TABLES `tblModelFeature` WRITE;
/*!40000 ALTER TABLE `tblModelFeature` DISABLE KEYS */;
INSERT INTO `tblModelFeature` VALUES (177,'D4SK63'),(177,'D4TY63'),(177,'D4XS53'),(179,'D4SK63'),(179,'D4XS53'),(180,'asdf3as3'),(180,'asdfasdf');
/*!40000 ALTER TABLE `tblModelFeature` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblOption`
--

DROP TABLE IF EXISTS `tblOption`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblOption` (
  `intOptionID` int(11) NOT NULL AUTO_INCREMENT,
  `strOptionCode` varchar(10) NOT NULL,
  `strOptionName` varchar(45) DEFAULT NULL,
  `intModelID` int(11) NOT NULL,
  `intTrimID` int(11) NOT NULL,
  `intDealerNet` int(11) DEFAULT NULL,
  `intMSRP` int(11) DEFAULT NULL,
  PRIMARY KEY (`intOptionID`),
  KEY `fk_tblOption_tblModel1` (`intModelID`),
  KEY `fk_tblOption_tblTrim1` (`intTrimID`),
  CONSTRAINT `fk_tblOption_tblModel1` FOREIGN KEY (`intModelID`) REFERENCES `tblModel` (`intModelID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tblOption_tblTrim1` FOREIGN KEY (`intTrimID`) REFERENCES `tblTrim` (`intTrimID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblOption`
--

LOCK TABLES `tblOption` WRITE;
/*!40000 ALTER TABLE `tblOption` DISABLE KEYS */;
INSERT INTO `tblOption` VALUES (5,'ASDFFF',NULL,6,9,0,0),(6,'A12',NULL,5,6,0,0),(7,'A13',NULL,5,6,0,0);
/*!40000 ALTER TABLE `tblOption` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblOptionFeature`
--

DROP TABLE IF EXISTS `tblOptionFeature`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblOptionFeature` (
  `intOptionID` int(11) NOT NULL,
  `intFeatureID` int(11) NOT NULL,
  PRIMARY KEY (`intOptionID`,`intFeatureID`),
  KEY `fk_tblOptionFeature_tblFeature1` (`intFeatureID`),
  CONSTRAINT `fk_tblOptionFeature_tblOption` FOREIGN KEY (`intOptionID`) REFERENCES `tblOption` (`intOptionID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tblOptionFeature_tblFeature1` FOREIGN KEY (`intFeatureID`) REFERENCES `tblFeature` (`intFeatureID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblOptionFeature`
--

LOCK TABLES `tblOptionFeature` WRITE;
/*!40000 ALTER TABLE `tblOptionFeature` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblOptionFeature` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblSteering`
--

DROP TABLE IF EXISTS `tblSteering`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblSteering` (
  `intSteeringID` int(11) NOT NULL AUTO_INCREMENT,
  `strSteeringName` varchar(64) NOT NULL,
  PRIMARY KEY (`intSteeringID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblSteering`
--

LOCK TABLES `tblSteering` WRITE;
/*!40000 ALTER TABLE `tblSteering` DISABLE KEYS */;
INSERT INTO `tblSteering` VALUES (2,'D'),(3,'asdf'),(4,'A'),(5,'asfd');
/*!40000 ALTER TABLE `tblSteering` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblTransmission`
--

DROP TABLE IF EXISTS `tblTransmission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblTransmission` (
  `intTransmissionID` int(11) NOT NULL AUTO_INCREMENT,
  `strTransmissionName` varchar(45) NOT NULL,
  PRIMARY KEY (`intTransmissionID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblTransmission`
--

LOCK TABLES `tblTransmission` WRITE;
/*!40000 ALTER TABLE `tblTransmission` DISABLE KEYS */;
INSERT INTO `tblTransmission` VALUES (6,'B'),(7,'asdf'),(8,'A');
/*!40000 ALTER TABLE `tblTransmission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblTrim`
--

DROP TABLE IF EXISTS `tblTrim`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblTrim` (
  `intTrimID` int(11) NOT NULL AUTO_INCREMENT,
  `strTrimName` varchar(45) NOT NULL,
  PRIMARY KEY (`intTrimID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblTrim`
--

LOCK TABLES `tblTrim` WRITE;
/*!40000 ALTER TABLE `tblTrim` DISABLE KEYS */;
INSERT INTO `tblTrim` VALUES (6,'GX'),(7,'GS'),(8,'GT'),(9,'GS-SKY'),(10,'GX w/ AC');
/*!40000 ALTER TABLE `tblTrim` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `vVehicleDigest`
--

DROP TABLE IF EXISTS `vVehicleDigest`;
/*!50001 DROP VIEW IF EXISTS `vVehicleDigest`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vVehicleDigest` (
  `strModelName` varchar(45),
  `strTrimName` varchar(45),
  `strModelCode` varchar(10),
  `strOptionCode` varchar(10),
  `strOptionName` varchar(45),
  `intDealerNet` int(11),
  `intMSRP` int(11)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Current Database: `ps_user`
--

USE `ps_user`;

--
-- Final view structure for view `vContact`
--

/*!50001 DROP TABLE IF EXISTS `vContact`*/;
/*!50001 DROP VIEW IF EXISTS `vContact`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`melissa`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vContact` AS select `u`.`strUserName` AS `strUserName`,`r`.`strRoleDescription` AS `strRoleDescription`,`pc`.`strPhoneNumber` AS `strPhoneNumber`,`pc`.`strEmail` AS `strEmail`,`cm`.`strAddressLine1` AS `strAddressLine1`,`cm`.`strAddressLine2` AS `strAddressLine2`,`gb`.`strCityName` AS `strCityName`,`gb`.`strProvName` AS `strProvName`,`gb`.`strCountryName` AS `strCountryName`,`cm`.`strPostalCode` AS `strPostalCode` from ((((((`tblParty` `p` join `tblPartyRole` `pr` on((`p`.`intPartyID` = `pr`.`intPartyID`))) join `tblRole` `r` on((`r`.`intRoleID` = `pr`.`intRoleID`))) join `tblUser` `u` on((`pr`.`intPartyRoleID` = `u`.`intPartyRoleID`))) left join `tblPartyContactMechanism` `pc` on(((`pc`.`intPartyID` = `p`.`intPartyID`) and (`pc`.`intRoleID` = `r`.`intRoleID`)))) left join `tblContactMechanism` `cm` on((`cm`.`intContactMechanismID` = `pc`.`intContactMechanismID`))) left join `tblGeographicBoundary` `gb` on((`gb`.`intGeographicBoundaryID` = `cm`.`intGeographicBoundaryID`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vUser`
--

/*!50001 DROP TABLE IF EXISTS `vUser`*/;
/*!50001 DROP VIEW IF EXISTS `vUser`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`melissa`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vUser` AS (select `pt`.`intPartyID` AS `intPartyID`,`us`.`strUserName` AS `strUserName`,`us`.`strUserPass` AS `strUserPass`,`ar`.`intAccessRightsID` AS `intAccessRightsID`,`ar`.`strAccessRightsDescription` AS `strAccessRightsDescription`,`ds`.`strDealershipName` AS `strDealershipName`,`ps`.`strFirstName` AS `strFirstName`,`ps`.`strLastName` AS `strLastName` from (((((`tblParty` `pt` join `tblPartyRole` `pr` on((`pt`.`intPartyID` = `pr`.`intPartyID`))) join `tblUser` `us` on((`pr`.`intPartyRoleID` = `us`.`intPartyRoleID`))) join `tblAccessRights` `ar` on((`ar`.`intAccessRightsID` = `us`.`intAccessRightsID`))) join `tblPerson` `ps` on((`ps`.`intPartyID` = `pt`.`intPartyID`))) join `tblDealership` `ds` on((`us`.`intDealershipID` = `ds`.`intPartyID`)))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vUserHierarchy`
--

/*!50001 DROP TABLE IF EXISTS `vUserHierarchy`*/;
/*!50001 DROP VIEW IF EXISTS `vUserHierarchy`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`melissa`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vUserHierarchy` AS select `s`.`intAccessRightsID` AS `intAccessRightsID`,`s`.`strAccessRightsDescription` AS `strAccessRightsDescription`,`m`.`strAccessRightsDescription` AS `master` from (`tblAccessRights` `s` left join `tblAccessRights` `m` on((`s`.`intMasterAccessRightsID` = `m`.`intAccessRightsID`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Current Database: `ps_accessory`
--

USE `ps_accessory`;

--
-- Current Database: `ps_vehicle`
--

USE `ps_vehicle`;

--
-- Final view structure for view `vVehicleDigest`
--

/*!50001 DROP TABLE IF EXISTS `vVehicleDigest`*/;
/*!50001 DROP VIEW IF EXISTS `vVehicleDigest`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`melissa`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vVehicleDigest` AS select `md`.`strModelName` AS `strModelName`,`tr`.`strTrimName` AS `strTrimName`,`md`.`strModelCode` AS `strModelCode`,`op`.`strOptionCode` AS `strOptionCode`,`op`.`strOptionName` AS `strOptionName`,`op`.`intDealerNet` AS `intDealerNet`,`op`.`intMSRP` AS `intMSRP` from (((`tblModel` `md` join `tblMake` `mk` on((`md`.`intMakeID` = `mk`.`intMakeID`))) join `tblTrim` `tr` on((`md`.`intTrimID` = `tr`.`intTrimID`))) join `tblOption` `op` on((`md`.`intModelID` = `op`.`intModelID`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-08-20 17:09:33
