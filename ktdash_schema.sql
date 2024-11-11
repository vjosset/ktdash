-- MySQL dump 10.13  Distrib 8.0.39, for Linux (x86_64)
--
-- Host: localhost    Database: killteam
-- ------------------------------------------------------
-- Server version	8.0.39-0ubuntu0.20.04.1

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
-- Table structure for table `Ability`
--

DROP TABLE IF EXISTS `Ability`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Ability` (
  `factionid` varchar(10) NOT NULL,
  `killteamid` varchar(50) NOT NULL,
  `fireteamid` varchar(50) NOT NULL,
  `opid` varchar(50) NOT NULL,
  `abilityid` varchar(50) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text,
  PRIMARY KEY (`killteamid`,`fireteamid`,`opid`,`abilityid`,`factionid`),
  KEY `FK_Ability_Operative_idx` (`factionid`,`killteamid`,`fireteamid`,`opid`),
  CONSTRAINT `FK_Ability_Operative` FOREIGN KEY (`factionid`, `killteamid`, `fireteamid`, `opid`) REFERENCES `Operative` (`factionid`, `killteamid`, `fireteamid`, `opid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Equipment`
--

DROP TABLE IF EXISTS `Equipment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Equipment` (
  `factionid` varchar(10) NOT NULL,
  `killteamid` varchar(50) NOT NULL,
  `fireteamid` varchar(50) DEFAULT '',
  `opid` varchar(50) DEFAULT '',
  `eqid` varchar(50) NOT NULL,
  `eqseq` int DEFAULT '0',
  `eqpts` varchar(10) DEFAULT NULL,
  `eqname` varchar(250) DEFAULT NULL,
  `eqdescription` text,
  `eqtype` varchar(45) DEFAULT NULL,
  `eqvar1` varchar(45) DEFAULT NULL,
  `eqvar2` varchar(45) DEFAULT NULL,
  `eqvar3` varchar(45) DEFAULT NULL,
  `eqvar4` varchar(45) DEFAULT NULL,
  `eqcategory` varchar(200) DEFAULT 'Equipment',
  PRIMARY KEY (`factionid`,`killteamid`,`eqid`),
  KEY `FK_Equipment_Killteam_idx` (`factionid`,`killteamid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Event`
--

DROP TABLE IF EXISTS `Event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Event` (
  `eventid` int NOT NULL AUTO_INCREMENT,
  `datestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  `sessiontype` varchar(50) DEFAULT '',
  `userid` varchar(45) DEFAULT NULL,
  `eventtype` varchar(50) DEFAULT NULL,
  `action` varchar(45) DEFAULT NULL,
  `label` varchar(45) DEFAULT NULL,
  `var1` varchar(45) DEFAULT NULL,
  `var2` varchar(45) DEFAULT NULL,
  `var3` varchar(45) DEFAULT NULL,
  `url` varchar(500) DEFAULT '',
  `userip` varchar(250) DEFAULT '',
  `useragent` varchar(500) DEFAULT '',
  `referrer` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`eventid`),
  KEY `IX_TAL` (`userid`,`eventtype`,`action`,`label`) /*!80000 INVISIBLE */,
  KEY `IX_VAR1` (`var1`,`eventtype`,`action`,`label`),
  KEY `IX_datestamp` (`datestamp`)
) ENGINE=InnoDB AUTO_INCREMENT=16061420 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary view structure for view `EventLogView`
--

DROP TABLE IF EXISTS `EventLogView`;
/*!50001 DROP VIEW IF EXISTS `EventLogView`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `EventLogView` AS SELECT 
 1 AS `eventid`,
 1 AS `datestamp`,
 1 AS `ActionLog`,
 1 AS `userid`,
 1 AS `userip`,
 1 AS `eventtype`,
 1 AS `action`,
 1 AS `label`,
 1 AS `var1`,
 1 AS `var2`,
 1 AS `var3`,
 1 AS `username`,
 1 AS `rostername`,
 1 AS `opname`,
 1 AS `optype`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `Event_BKP_20240720`
--

DROP TABLE IF EXISTS `Event_BKP_20240720`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Event_BKP_20240720` (
  `eventid` int NOT NULL AUTO_INCREMENT,
  `datestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  `sessiontype` varchar(50) DEFAULT '',
  `userid` varchar(45) DEFAULT NULL,
  `eventtype` varchar(50) DEFAULT NULL,
  `action` varchar(45) DEFAULT NULL,
  `label` varchar(45) DEFAULT NULL,
  `var1` varchar(45) DEFAULT NULL,
  `var2` varchar(45) DEFAULT NULL,
  `var3` varchar(45) DEFAULT NULL,
  `url` varchar(500) DEFAULT '',
  `userip` varchar(250) DEFAULT '',
  `useragent` varchar(500) DEFAULT '',
  `referrer` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`eventid`),
  KEY `IX_TAL` (`userid`,`eventtype`,`action`,`label`) /*!80000 INVISIBLE */,
  KEY `IX_VAR1` (`var1`,`eventtype`,`action`,`label`),
  KEY `IX_datestamp` (`datestamp`)
) ENGINE=InnoDB AUTO_INCREMENT=14186874 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Faction`
--

DROP TABLE IF EXISTS `Faction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Faction` (
  `factionid` varchar(10) NOT NULL,
  `seq` int DEFAULT NULL,
  `factionname` varchar(250) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`factionid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Fireteam`
--

DROP TABLE IF EXISTS `Fireteam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Fireteam` (
  `factionid` varchar(10) NOT NULL,
  `killteamid` varchar(50) NOT NULL,
  `fireteamid` varchar(200) NOT NULL,
  `seq` int DEFAULT '0',
  `description` text,
  `killteammax` int DEFAULT NULL,
  `fireteamname` varchar(200) DEFAULT NULL,
  `archetype` varchar(250) DEFAULT NULL,
  `fireteamcomp` text,
  PRIMARY KEY (`factionid`,`killteamid`,`fireteamid`),
  KEY `FK_Fireteam_Killteam_idx` (`factionid`,`killteamid`),
  CONSTRAINT `FK_Fireteam_Killteam` FOREIGN KEY (`factionid`, `killteamid`) REFERENCES `Killteam` (`factionid`, `killteamid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `HomebrewKillteam`
--

DROP TABLE IF EXISTS `HomebrewKillteam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `HomebrewKillteam` (
  `userid` varchar(50) NOT NULL,
  `seq` int DEFAULT '0',
  `killteamid` varchar(50) NOT NULL,
  `killteamname` varchar(250) DEFAULT NULL,
  `content` longtext,
  PRIMARY KEY (`userid`,`killteamid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Killteam`
--

DROP TABLE IF EXISTS `Killteam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Killteam` (
  `factionid` varchar(10) NOT NULL,
  `killteamid` varchar(50) NOT NULL,
  `edition` varchar(45) DEFAULT 'kt24',
  `killteamname` varchar(250) DEFAULT NULL,
  `description` text,
  `killteamcomp` text,
  `customkeyword` varchar(250) DEFAULT '',
  PRIMARY KEY (`factionid`,`killteamid`),
  KEY `FK_Killteam_Faction_idx` (`factionid`),
  CONSTRAINT `FK_Killteam_Faction` FOREIGN KEY (`factionid`) REFERENCES `Faction` (`factionid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Operative`
--

DROP TABLE IF EXISTS `Operative`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Operative` (
  `factionid` varchar(10) NOT NULL,
  `killteamid` varchar(50) NOT NULL,
  `fireteamid` varchar(250) NOT NULL,
  `opseq` int DEFAULT '0',
  `opid` varchar(50) NOT NULL,
  `opname` varchar(250) DEFAULT NULL,
  `description` text,
  `edition` varchar(45) DEFAULT 'kt24',
  `M` varchar(15) DEFAULT NULL,
  `APL` varchar(15) DEFAULT NULL,
  `GA` varchar(15) DEFAULT NULL,
  `DF` varchar(15) DEFAULT NULL,
  `SV` varchar(15) DEFAULT NULL,
  `W` varchar(15) DEFAULT NULL,
  `keywords` varchar(4000) DEFAULT NULL,
  `basesize` int DEFAULT '32',
  `fireteammax` int DEFAULT '0',
  `specialisms` varchar(50) DEFAULT '',
  PRIMARY KEY (`factionid`,`killteamid`,`fireteamid`,`opid`),
  KEY `IX_Operative_FactionIdKillTeamIdFireTeamID` (`factionid`,`killteamid`,`fireteamid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Ploy`
--

DROP TABLE IF EXISTS `Ploy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Ploy` (
  `factionid` varchar(10) NOT NULL,
  `killteamid` varchar(10) NOT NULL,
  `ploytype` varchar(250) NOT NULL,
  `ployid` varchar(50) NOT NULL,
  `ployname` varchar(250) DEFAULT NULL,
  `CP` varchar(10) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`factionid`,`killteamid`,`ploytype`,`ployid`),
  CONSTRAINT `FK_Ploy_Killteam` FOREIGN KEY (`factionid`, `killteamid`) REFERENCES `Killteam` (`factionid`, `killteamid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Roster`
--

DROP TABLE IF EXISTS `Roster`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Roster` (
  `userid` varchar(50) NOT NULL,
  `rosterid` varchar(50) NOT NULL,
  `seq` int DEFAULT NULL,
  `rostername` varchar(250) DEFAULT NULL,
  `factionid` varchar(50) DEFAULT NULL,
  `killteamid` varchar(50) DEFAULT NULL,
  `notes` varchar(2000) DEFAULT '',
  `keyword` varchar(250) DEFAULT '',
  `TP` int DEFAULT '1',
  `CP` int DEFAULT '2',
  `VP` int DEFAULT '2',
  `RP` int DEFAULT '0',
  `spotlight` int DEFAULT '0',
  `hascustomportrait` int DEFAULT '0',
  `portraitcopyok` int DEFAULT '0',
  `viewcount` int DEFAULT '0',
  `importcount` int DEFAULT '0',
  `eqids` varchar(250) DEFAULT '',
  `ployids` varchar(250) DEFAULT NULL,
  `tacopids` varchar(250) DEFAULT NULL,
  `reqpts` int DEFAULT '0',
  `stratnotes` text,
  `eqnotes` text,
  `specopnotes` text,
  `createddate` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`userid`,`rosterid`),
  UNIQUE KEY `rosterid_UNIQUE` (`rosterid`),
  KEY `IX_Roster_rosterid` (`rosterid`),
  CONSTRAINT `FK_Roster_User` FOREIGN KEY (`userid`) REFERENCES `User` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `RosterEquipment`
--

DROP TABLE IF EXISTS `RosterEquipment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `RosterEquipment` (
  `userid` varchar(50) NOT NULL,
  `rosterid` varchar(50) NOT NULL,
  `eqfactionid` varchar(50) NOT NULL,
  `eqkillteamid` varchar(50) NOT NULL,
  `eqid` varchar(50) NOT NULL,
  PRIMARY KEY (`userid`,`rosterid`,`eqfactionid`,`eqkillteamid`,`eqid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `RosterOperative`
--

DROP TABLE IF EXISTS `RosterOperative`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `RosterOperative` (
  `userid` varchar(50) NOT NULL,
  `rosterid` varchar(50) NOT NULL,
  `rosteropid` varchar(50) NOT NULL,
  `seq` int DEFAULT NULL,
  `opname` varchar(250) DEFAULT NULL,
  `factionid` varchar(50) DEFAULT NULL,
  `killteamid` varchar(50) DEFAULT NULL,
  `fireteamid` varchar(50) DEFAULT NULL,
  `opid` varchar(50) DEFAULT NULL,
  `wepids` varchar(250) DEFAULT NULL,
  `eqids` varchar(250) DEFAULT NULL,
  `curW` int DEFAULT NULL,
  `notes` varchar(2000) DEFAULT NULL,
  `activated` tinyint DEFAULT '0',
  `hidden` tinyint DEFAULT '0',
  `xp` int DEFAULT '0',
  `oporder` varchar(45) DEFAULT 'conceal',
  `hascustomportrait` int DEFAULT '0',
  `specialism` varchar(50) DEFAULT '',
  `isinjured` tinyint DEFAULT '0',
  `rested` int DEFAULT '0',
  `custom` text,
  PRIMARY KEY (`userid`,`rosterid`,`rosteropid`),
  UNIQUE KEY `rosteropid_UNIQUE` (`rosteropid`),
  KEY `IX_RosterOperative_rosteropid` (`rosteropid`),
  CONSTRAINT `FK_RosterOperative_Roster` FOREIGN KEY (`userid`, `rosterid`) REFERENCES `Roster` (`userid`, `rosterid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary view structure for view `RosterOperativeView`
--

DROP TABLE IF EXISTS `RosterOperativeView`;
/*!50001 DROP VIEW IF EXISTS `RosterOperativeView`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `RosterOperativeView` AS SELECT 
 1 AS `userid`,
 1 AS `rosterid`,
 1 AS `rosteropid`,
 1 AS `seq`,
 1 AS `opname`,
 1 AS `factionid`,
 1 AS `killteamid`,
 1 AS `fireteamid`,
 1 AS `opid`,
 1 AS `hascustomportrait`,
 1 AS `specialism`,
 1 AS `isinjured`,
 1 AS `rested`,
 1 AS `M`,
 1 AS `APL`,
 1 AS `GA`,
 1 AS `DF`,
 1 AS `SV`,
 1 AS `W`,
 1 AS `keywords`,
 1 AS `basesize`,
 1 AS `specialisms`,
 1 AS `curW`,
 1 AS `activated`,
 1 AS `oporder`,
 1 AS `hidden`,
 1 AS `wepids`,
 1 AS `eqids`,
 1 AS `notes`,
 1 AS `xp`,
 1 AS `username`,
 1 AS `rostername`,
 1 AS `factionname`,
 1 AS `killteamname`,
 1 AS `edition`,
 1 AS `fireteamname`,
 1 AS `archetype`,
 1 AS `optype`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `RosterTacOp`
--

DROP TABLE IF EXISTS `RosterTacOp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `RosterTacOp` (
  `userid` varchar(50) NOT NULL,
  `rosterid` varchar(50) NOT NULL,
  `tacopid` varchar(50) NOT NULL,
  `revealed` tinyint DEFAULT '0',
  `VP1` tinyint DEFAULT '0',
  `VP2` tinyint DEFAULT '0',
  PRIMARY KEY (`userid`,`rosterid`,`tacopid`),
  KEY `FK_RosterTacOp_TacOp_idx` (`tacopid`),
  KEY `FK_RosterTacOp_User_idx` (`userid`),
  KEY `FK_RosterTacOp_Roster_idx` (`userid`,`rosterid`),
  CONSTRAINT `FK_RosterTacOp_Roster` FOREIGN KEY (`userid`, `rosterid`) REFERENCES `Roster` (`userid`, `rosterid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_RosterTacOp_TacOp` FOREIGN KEY (`tacopid`) REFERENCES `TacOp` (`tacopid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_RosterTacOp_User` FOREIGN KEY (`userid`) REFERENCES `User` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary view structure for view `RosterView`
--

DROP TABLE IF EXISTS `RosterView`;
/*!50001 DROP VIEW IF EXISTS `RosterView`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `RosterView` AS SELECT 
 1 AS `userid`,
 1 AS `username`,
 1 AS `rosterid`,
 1 AS `seq`,
 1 AS `rostername`,
 1 AS `notes`,
 1 AS `factionid`,
 1 AS `killteamid`,
 1 AS `hascustomportrait`,
 1 AS `keyword`,
 1 AS `portraitcopyok`,
 1 AS `eqids`,
 1 AS `TP`,
 1 AS `CP`,
 1 AS `VP`,
 1 AS `RP`,
 1 AS `ployids`,
 1 AS `tacopids`,
 1 AS `spotlight`,
 1 AS `factionname`,
 1 AS `killteamname`,
 1 AS `edition`,
 1 AS `killteamcustomkeyword`,
 1 AS `killteamdescription`,
 1 AS `oplist`,
 1 AS `viewcount`,
 1 AS `importcount`,
 1 AS `reqpts`,
 1 AS `stratnotes`,
 1 AS `eqnotes`,
 1 AS `specopnotes`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `RosterView_Orig`
--

DROP TABLE IF EXISTS `RosterView_Orig`;
/*!50001 DROP VIEW IF EXISTS `RosterView_Orig`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `RosterView_Orig` AS SELECT 
 1 AS `userid`,
 1 AS `username`,
 1 AS `rosterid`,
 1 AS `seq`,
 1 AS `rostername`,
 1 AS `notes`,
 1 AS `factionid`,
 1 AS `killteamid`,
 1 AS `hascustomportrait`,
 1 AS `TP`,
 1 AS `CP`,
 1 AS `VP`,
 1 AS `RP`,
 1 AS `ployids`,
 1 AS `tacopids`,
 1 AS `spotlight`,
 1 AS `factionname`,
 1 AS `killteamname`,
 1 AS `killteamdescription`,
 1 AS `oplist`,
 1 AS `viewcount`,
 1 AS `importcount`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `Session`
--

DROP TABLE IF EXISTS `Session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Session` (
  `sessionid` varchar(50) NOT NULL,
  `userid` varchar(50) DEFAULT NULL,
  `lastactivity` datetime DEFAULT NULL,
  PRIMARY KEY (`sessionid`),
  KEY `FK_Session_Player_idx` (`userid`),
  CONSTRAINT `FK_Session_User` FOREIGN KEY (`userid`) REFERENCES `User` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TacOp`
--

DROP TABLE IF EXISTS `TacOp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TacOp` (
  `tacopid` varchar(50) NOT NULL,
  `edition` varchar(45) DEFAULT 'kt21',
  `archetype` varchar(50) DEFAULT NULL,
  `tacopseq` int DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `description` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`tacopid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `UniqueAction`
--

DROP TABLE IF EXISTS `UniqueAction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `UniqueAction` (
  `factionid` varchar(10) NOT NULL,
  `killteamid` varchar(50) NOT NULL,
  `fireteamid` varchar(50) NOT NULL,
  `opid` varchar(50) NOT NULL,
  `uniqueactionid` varchar(50) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `AP` int DEFAULT '1',
  `description` text,
  PRIMARY KEY (`factionid`,`killteamid`,`fireteamid`,`opid`,`uniqueactionid`),
  CONSTRAINT `FK_UniqueActions_Operative` FOREIGN KEY (`factionid`, `killteamid`, `fireteamid`, `opid`) REFERENCES `Operative` (`factionid`, `killteamid`, `fireteamid`, `opid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `User` (
  `userid` varchar(50) NOT NULL,
  `username` varchar(250) DEFAULT NULL,
  `passhash` varchar(500) DEFAULT NULL,
  `createddate` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`userid`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `UserSetting`
--

DROP TABLE IF EXISTS `UserSetting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `UserSetting` (
  `userid` varchar(50) NOT NULL,
  `key` varchar(50) NOT NULL,
  `value` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`userid`,`key`),
  CONSTRAINT `FK_Setting_User` FOREIGN KEY (`userid`) REFERENCES `User` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Weapon`
--

DROP TABLE IF EXISTS `Weapon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Weapon` (
  `factionid` varchar(10) NOT NULL,
  `killteamid` varchar(50) NOT NULL,
  `fireteamid` varchar(50) NOT NULL,
  `opid` varchar(50) NOT NULL,
  `wepid` varchar(50) NOT NULL,
  `wepseq` int DEFAULT '0',
  `wepname` varchar(250) DEFAULT NULL,
  `weptype` varchar(1) DEFAULT NULL,
  `isdefault` smallint DEFAULT '0',
  PRIMARY KEY (`factionid`,`killteamid`,`fireteamid`,`opid`,`wepid`),
  KEY `FK_weapon_operative_idx` (`killteamid`,`fireteamid`,`opid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `WeaponProfile`
--

DROP TABLE IF EXISTS `WeaponProfile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `WeaponProfile` (
  `factionid` varchar(10) NOT NULL,
  `killteamid` varchar(50) NOT NULL,
  `fireteamid` varchar(50) NOT NULL,
  `opid` varchar(50) NOT NULL,
  `wepid` varchar(50) NOT NULL,
  `profileid` varchar(200) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `A` varchar(5) DEFAULT NULL,
  `BS` varchar(5) DEFAULT NULL,
  `D` varchar(5) DEFAULT NULL,
  `SR` varchar(4000) DEFAULT NULL,
  PRIMARY KEY (`factionid`,`killteamid`,`fireteamid`,`opid`,`wepid`,`profileid`),
  CONSTRAINT `FK_WeaponProfile_Weapon` FOREIGN KEY (`factionid`, `killteamid`, `fireteamid`, `opid`, `wepid`) REFERENCES `Weapon` (`factionid`, `killteamid`, `fireteamid`, `opid`, `wepid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Final view structure for view `EventLogView`
--

/*!50001 DROP VIEW IF EXISTS `EventLogView`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`vince`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `EventLogView` AS select `E`.`eventid` AS `eventid`,`E`.`datestamp` AS `datestamp`,(case concat(`E`.`eventtype`,'|',`E`.`action`) when 'page|view' then concat(ifnull(concat('<a href="/u/',`U`.`userid`,'">',`U`.`username`,'</a>'),'[Anon]'),' viewed page <a href="',`E`.`url`,'">',`E`.`url`,'</a>') when 'roster|addop' then concat('<a href="/u/',`U`.`userid`,'">',`U`.`username`,'</a> added ',`O`.`opname`,' "',`RO`.`opname`,'" to <a href="/fa/',`K`.`factionid`,'/kt/',`K`.`killteamid`,'">',`K`.`killteamname`,'</a> roster <a href="/r/',`R`.`rosterid`,'">',`R`.`rostername`,'</a>') when 'roster|create' then concat('<a href="/u/',`U`.`userid`,'">',`U`.`username`,'</a> created new <a href="/fa/',`K`.`factionid`,'/kt/',`K`.`killteamid`,'">',`K`.`killteamname`,'</a> roster <a href="/r/',`R`.`rosterid`,'">',`R`.`rostername`,'</a>') when 'roster|importv1' then concat('<a href="/u/',`U`.`userid`,'">',`U`.`username`,'</a> imported a v1 roster') when 'roster|gettext' then concat('<a href="/u/',`U`.`userid`,'">',`U`.`username`,'</a> viewed roster <a href="/r/',`R`.`rosterid`,'">',`R`.`rostername`,'</a>','\'s text description') when 'roster|cloneop' then concat('<a href="/u/',`U`.`userid`,'">',`U`.`username`,'</a> cloned a new operative into roster <a href="/r/',`R`.`rosterid`,'">',`R`.`rostername`,'</a>') when 'dashboard|TP' then concat('<a href="/u/',`U`.`userid`,'">',`U`.`username`,'</a>\'s ',' roster <a href="/r/',`R`.`rosterid`,'">',`R`.`rostername`,'</a>',(case when (`E`.`var2` = 1) then ' moved to the next TP' else ' went back to the previous TP' end)) when 'session|signup' then concat('<a href="/u/',`U`.`userid`,'">',`U`.`username`,'</a> signed up') when 'dashboard|W' then concat(`RO`.`opname`,' of ','<a href="/u/',`U`.`userid`,'">',`U`.`username`,'</a>\'s ',' roster <a href="/r/',`R`.`rosterid`,'">',`R`.`rostername`,'</a>',' ',(case when (`E`.`var2` = 1) then 'gained' else 'lost' end),' 1 Wound') when 'dashboard|CP' then concat('<a href="/u/',`U`.`userid`,'">',`U`.`username`,'</a>\'s ',' roster <a href="/r/',`R`.`rosterid`,'">',`R`.`rostername`,'</a>',' ',(case when (`E`.`var2` = 1) then 'gained' else 'used' end),' 1 CP') when 'dashboard|VP' then concat('<a href="/u/',`U`.`userid`,'">',`U`.`username`,'</a>\'s ',' roster <a href="/r/',`R`.`rosterid`,'">',`R`.`rostername`,'</a>',' ',(case when (`E`.`var2` = 1) then 'gained' else 'lost' end),' 1 VP') when 'dashboard|RP' then concat('<a href="/u/',`U`.`userid`,'">',`U`.`username`,'</a>\'s ',' roster <a href="/r/',`R`.`rosterid`,'">',`R`.`rostername`,'</a>',' ',(case when (`E`.`var2` = 1) then 'gained' else 'lost' end),' 1 RP') when 'roster|print' then concat('<a href="/u/',`U`.`userid`,'">',`U`.`username`,'</a> printed their "',(case `E`.`label` when 'roster' then `R`.`rostername` else `RO`.`opname` end),(case `E`.`label` when 'roster' then '" roster' else '" operative' end)) when 'roster|opportrait' then concat('<a href="/u/',`U`.`userid`,'">',`U`.`username`,'</a> added a new ',(case when (`E`.`label` = 'custom') then 'custom' else 'default' end),' portrait for "',`RO`.`opname`,'" of ',' roster <a href="/r/',`R`.`rosterid`,'">',`R`.`rostername`,'</a>') else '' end) AS `ActionLog`,`E`.`userid` AS `userid`,`E`.`userip` AS `userip`,`E`.`eventtype` AS `eventtype`,`E`.`action` AS `action`,`E`.`label` AS `label`,`E`.`var1` AS `var1`,`E`.`var2` AS `var2`,`E`.`var3` AS `var3`,`U`.`username` AS `username`,`R`.`rostername` AS `rostername`,`RO`.`opname` AS `opname`,`O`.`opname` AS `optype` from (((((`Event` `E` left join `User` `U` on((`U`.`userid` = `E`.`userid`))) left join `Roster` `R` on((`R`.`rosterid` = `E`.`var1`))) left join `Killteam` `K` on(((`K`.`factionid` = `R`.`factionid`) and (`K`.`killteamid` = `R`.`killteamid`)))) left join `RosterOperative` `RO` on(((`RO`.`rosterid` = `E`.`var1`) and (`RO`.`rosteropid` = `E`.`var2`)))) left join `Operative` `O` on(((`O`.`factionid` = `RO`.`factionid`) and (`O`.`killteamid` = `RO`.`killteamid`) and (`O`.`fireteamid` = `RO`.`fireteamid`) and (`O`.`opid` = `RO`.`opid`)))) where ((`E`.`eventtype` not in ('compendium','pwa','opname')) and (concat(`E`.`eventtype`,'|',`E`.`action`) not in ('dashboard|selectroster','dashboard|reset','settings|view','roster|edit','settings|set','session|login','roster|view','roster|editop','roster|delop','dashboard|init','rosters|view','roster|killteamcomp','roster|delete','roster|gallery'))) order by `E`.`eventid` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `RosterOperativeView`
--

/*!50001 DROP VIEW IF EXISTS `RosterOperativeView`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`vince`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `RosterOperativeView` AS select `RO`.`userid` AS `userid`,`RO`.`rosterid` AS `rosterid`,`RO`.`rosteropid` AS `rosteropid`,`RO`.`seq` AS `seq`,`RO`.`opname` AS `opname`,`RO`.`factionid` AS `factionid`,`RO`.`killteamid` AS `killteamid`,`RO`.`fireteamid` AS `fireteamid`,`RO`.`opid` AS `opid`,`RO`.`hascustomportrait` AS `hascustomportrait`,`RO`.`specialism` AS `specialism`,`RO`.`isinjured` AS `isinjured`,`RO`.`rested` AS `rested`,`O`.`M` AS `M`,`O`.`APL` AS `APL`,`O`.`GA` AS `GA`,`O`.`DF` AS `DF`,`O`.`SV` AS `SV`,`O`.`W` AS `W`,(case when (`R`.`keyword` <> '') then replace(`O`.`keywords`,`K`.`customkeyword`,concat('<',`R`.`keyword`,'>')) else `O`.`keywords` end) AS `keywords`,`O`.`basesize` AS `basesize`,`O`.`specialisms` AS `specialisms`,`RO`.`curW` AS `curW`,`RO`.`activated` AS `activated`,`RO`.`oporder` AS `oporder`,`RO`.`hidden` AS `hidden`,`RO`.`wepids` AS `wepids`,`RO`.`eqids` AS `eqids`,`RO`.`notes` AS `notes`,`RO`.`xp` AS `xp`,`U`.`username` AS `username`,`R`.`rostername` AS `rostername`,`F`.`factionname` AS `factionname`,`K`.`killteamname` AS `killteamname`,`K`.`edition` AS `edition`,`FT`.`fireteamname` AS `fireteamname`,`FT`.`archetype` AS `archetype`,`O`.`opname` AS `optype` from ((((((`RosterOperative` `RO` join `User` `U` on((`U`.`userid` = `RO`.`userid`))) join `Roster` `R` on(((`R`.`userid` = `RO`.`userid`) and (`R`.`rosterid` = `RO`.`rosterid`)))) left join `Faction` `F` on((`F`.`factionid` = `RO`.`factionid`))) left join `Killteam` `K` on(((`K`.`factionid` = `RO`.`factionid`) and (`K`.`killteamid` = `RO`.`killteamid`)))) left join `Fireteam` `FT` on(((`FT`.`factionid` = `RO`.`factionid`) and (`FT`.`killteamid` = `RO`.`killteamid`) and (`FT`.`fireteamid` = `RO`.`fireteamid`)))) left join `Operative` `O` on(((`O`.`factionid` = `RO`.`factionid`) and (`O`.`killteamid` = `RO`.`killteamid`) and (`O`.`fireteamid` = `RO`.`fireteamid`) and (`O`.`opid` = `RO`.`opid`)))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `RosterView`
--

/*!50001 DROP VIEW IF EXISTS `RosterView`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`vince`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `RosterView` AS select `R`.`userid` AS `userid`,`U`.`username` AS `username`,`R`.`rosterid` AS `rosterid`,`R`.`seq` AS `seq`,`R`.`rostername` AS `rostername`,`R`.`notes` AS `notes`,`R`.`factionid` AS `factionid`,`R`.`killteamid` AS `killteamid`,`R`.`hascustomportrait` AS `hascustomportrait`,`R`.`keyword` AS `keyword`,`R`.`portraitcopyok` AS `portraitcopyok`,`R`.`eqids` AS `eqids`,`R`.`TP` AS `TP`,`R`.`CP` AS `CP`,`R`.`VP` AS `VP`,`R`.`RP` AS `RP`,`R`.`ployids` AS `ployids`,`R`.`tacopids` AS `tacopids`,`R`.`spotlight` AS `spotlight`,`F`.`factionname` AS `factionname`,`K`.`killteamname` AS `killteamname`,`K`.`edition` AS `edition`,`K`.`customkeyword` AS `killteamcustomkeyword`,`K`.`description` AS `killteamdescription`,group_concat(distinct `O`.`opname` order by `RO`.`seq` ASC separator ', ') AS `oplist`,`R`.`viewcount` AS `viewcount`,`R`.`importcount` AS `importcount`,`R`.`reqpts` AS `reqpts`,`R`.`stratnotes` AS `stratnotes`,`R`.`eqnotes` AS `eqnotes`,`R`.`specopnotes` AS `specopnotes` from (((((`Roster` `R` join `User` `U` on((`U`.`userid` = `R`.`userid`))) left join `Faction` `F` on((`F`.`factionid` = `R`.`factionid`))) left join `Killteam` `K` on(((`K`.`factionid` = `R`.`factionid`) and (`K`.`killteamid` = `R`.`killteamid`)))) left join `RosterOperative` `RO` on(((`RO`.`userid` = `R`.`userid`) and (`RO`.`rosterid` = `R`.`rosterid`)))) left join `Operative` `O` on(((`O`.`factionid` = `RO`.`factionid`) and (`O`.`killteamid` = `RO`.`killteamid`) and (`O`.`fireteamid` = `RO`.`fireteamid`) and (`O`.`opid` = `RO`.`opid`)))) group by `R`.`userid`,`U`.`username`,`R`.`rosterid`,`R`.`seq`,`R`.`rostername`,`R`.`factionid`,`R`.`killteamid`,`R`.`hascustomportrait`,`R`.`eqids`,`R`.`TP`,`R`.`CP`,`R`.`VP`,`R`.`RP`,`R`.`ployids`,`R`.`tacopids`,`R`.`spotlight`,`F`.`factionname`,`K`.`killteamname`,`K`.`edition`,`K`.`description` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `RosterView_Orig`
--

/*!50001 DROP VIEW IF EXISTS `RosterView_Orig`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`vince`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `RosterView_Orig` AS select `R`.`userid` AS `userid`,`U`.`username` AS `username`,`R`.`rosterid` AS `rosterid`,`R`.`seq` AS `seq`,`R`.`rostername` AS `rostername`,`R`.`notes` AS `notes`,`R`.`factionid` AS `factionid`,`R`.`killteamid` AS `killteamid`,`R`.`hascustomportrait` AS `hascustomportrait`,`R`.`TP` AS `TP`,`R`.`CP` AS `CP`,`R`.`VP` AS `VP`,`R`.`RP` AS `RP`,`R`.`ployids` AS `ployids`,`R`.`tacopids` AS `tacopids`,`R`.`spotlight` AS `spotlight`,`F`.`factionname` AS `factionname`,`K`.`killteamname` AS `killteamname`,`K`.`description` AS `killteamdescription`,group_concat(distinct (case `RO`.`opcount` when 1 then `RO`.`optype` else concat(`RO`.`opcount`,' ',`RO`.`optype`) end) order by `RO`.`firstseq` ASC separator ', ') AS `oplist`,`R`.`viewcount` AS `viewcount`,`R`.`importcount` AS `importcount` from ((((`Roster` `R` join `User` `U` on((`U`.`userid` = `R`.`userid`))) join `Faction` `F` on((`F`.`factionid` = `R`.`factionid`))) join `Killteam` `K` on(((`K`.`factionid` = `R`.`factionid`) and (`K`.`killteamid` = `R`.`killteamid`)))) left join (select `RosterOperative`.`userid` AS `userid`,`RosterOperative`.`rosterid` AS `rosterid`,`Operative`.`opname` AS `optype`,count(0) AS `opcount`,min(`RosterOperative`.`seq`) AS `firstseq` from (`RosterOperative` join `Operative` on(((`Operative`.`factionid` = `RosterOperative`.`factionid`) and (`Operative`.`killteamid` = `RosterOperative`.`killteamid`) and (`Operative`.`fireteamid` = `RosterOperative`.`fireteamid`) and (`Operative`.`opid` = `RosterOperative`.`opid`)))) group by `RosterOperative`.`userid`,`RosterOperative`.`rosterid`,`Operative`.`opname`) `RO` on(((`RO`.`userid` = `R`.`userid`) and (`R`.`rosterid` = `RO`.`rosterid`)))) group by `R`.`userid`,`U`.`username`,`R`.`rosterid`,`R`.`seq`,`R`.`rostername`,`R`.`factionid`,`R`.`killteamid`,`R`.`hascustomportrait`,`R`.`TP`,`R`.`CP`,`R`.`VP`,`R`.`RP`,`R`.`ployids`,`R`.`tacopids`,`R`.`spotlight`,`F`.`factionname`,`K`.`killteamname`,`K`.`description` */;
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

-- Dump completed on 2024-11-10 13:05:21
