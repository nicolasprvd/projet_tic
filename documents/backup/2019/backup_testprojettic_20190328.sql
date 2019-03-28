-- MySQL dump 10.13  Distrib 5.7.14, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: testprojettic
-- ------------------------------------------------------
-- Server version	5.7.14

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
-- Table structure for table `choix_temp`
--

DROP TABLE IF EXISTS `choix_temp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `choix_temp` (
  `idprojet` int(2) NOT NULL,
  `idgroupe` int(2) NOT NULL,
  PRIMARY KEY (`idprojet`,`idgroupe`),
  KEY `fk_choix_temp_groupe_temp` (`idgroupe`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `choix_temp`
--

LOCK TABLES `choix_temp` WRITE;
/*!40000 ALTER TABLE `choix_temp` DISABLE KEYS */;
/*!40000 ALTER TABLE `choix_temp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `document`
--

DROP TABLE IF EXISTS `document`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `document` (
  `idprojet` int(11) NOT NULL,
  `iddoc` int(11) NOT NULL AUTO_INCREMENT,
  `chemindoc` char(255) NOT NULL,
  `typedoc` char(255) NOT NULL,
  PRIMARY KEY (`idprojet`,`iddoc`),
  KEY `fk_document_projet` (`idprojet`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document`
--

LOCK TABLES `document` WRITE;
/*!40000 ALTER TABLE `document` DISABLE KEYS */;
/*!40000 ALTER TABLE `document` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evaluation`
--

DROP TABLE IF EXISTS `evaluation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evaluation` (
  `idevaluation` int(2) NOT NULL AUTO_INCREMENT,
  `notecdc` decimal(10,2) DEFAULT NULL,
  `notesoutenance` decimal(10,2) DEFAULT NULL,
  `noterendu` decimal(10,2) DEFAULT NULL,
  `notefinale` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`idevaluation`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evaluation`
--

LOCK TABLES `evaluation` WRITE;
/*!40000 ALTER TABLE `evaluation` DISABLE KEYS */;
/*!40000 ALTER TABLE `evaluation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groupe`
--

DROP TABLE IF EXISTS `groupe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groupe` (
  `idgroupe` int(2) NOT NULL,
  `idprojet` int(2) NOT NULL,
  `idpersonnechef` int(2) NOT NULL,
  PRIMARY KEY (`idgroupe`),
  KEY `fk_groupe_projet` (`idprojet`),
  KEY `fk_groupe_personne` (`idpersonnechef`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groupe`
--

LOCK TABLES `groupe` WRITE;
/*!40000 ALTER TABLE `groupe` DISABLE KEYS */;
/*!40000 ALTER TABLE `groupe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groupe_temp`
--

DROP TABLE IF EXISTS `groupe_temp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groupe_temp` (
  `idgroupe` int(2) NOT NULL AUTO_INCREMENT,
  `idpersonnechef` int(2) NOT NULL,
  PRIMARY KEY (`idgroupe`),
  KEY `fk_groupe_temp_personne` (`idpersonnechef`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groupe_temp`
--

LOCK TABLES `groupe_temp` WRITE;
/*!40000 ALTER TABLE `groupe_temp` DISABLE KEYS */;
/*!40000 ALTER TABLE `groupe_temp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personne`
--

DROP TABLE IF EXISTS `personne`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personne` (
  `idpersonne` int(2) NOT NULL AUTO_INCREMENT,
  `idgroupe` int(2) DEFAULT NULL,
  `idevaluation` int(2) DEFAULT NULL,
  `idstatut` int(2) NOT NULL,
  `idgroupetemp` int(2) DEFAULT NULL,
  `nompersonne` char(255) DEFAULT NULL,
  `prenompersonne` char(255) DEFAULT NULL,
  `mailpersonne` char(255) DEFAULT NULL,
  `password` char(255) DEFAULT NULL,
  PRIMARY KEY (`idpersonne`),
  KEY `fk_personne_groupe` (`idgroupe`),
  KEY `fk_personne_evaluation` (`idevaluation`),
  KEY `fk_personne_statut` (`idstatut`),
  KEY `fk_personne_groupe_temp` (`idgroupetemp`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personne`
--

LOCK TABLES `personne` WRITE;
/*!40000 ALTER TABLE `personne` DISABLE KEYS */;
INSERT INTO `personne` VALUES (1,NULL,NULL,1,NULL,'Zemmari','Akka','zemmari@labri.fr','$2y$10$dDpQ4pBiS2EWNdwf57X4r.vTFfi0Mm/BbVIfwamAiOPQ9APojpZg.');
/*!40000 ALTER TABLE `personne` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projet`
--

DROP TABLE IF EXISTS `projet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projet` (
  `idprojet` int(2) NOT NULL AUTO_INCREMENT,
  `idpersonneresp` int(2) NOT NULL,
  `nomprojet` char(255) DEFAULT NULL,
  `descriptiftexte` text,
  `descriptifpdf` char(255) DEFAULT NULL,
  `nbEtudiants` int(11) NOT NULL,
  `automatique` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idprojet`),
  KEY `fk_projet_personne` (`idpersonneresp`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projet`
--

LOCK TABLES `projet` WRITE;
/*!40000 ALTER TABLE `projet` DISABLE KEYS */;
/*!40000 ALTER TABLE `projet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statut`
--

DROP TABLE IF EXISTS `statut`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statut` (
  `idstatut` int(2) NOT NULL AUTO_INCREMENT,
  `libelle` char(255) DEFAULT NULL,
  PRIMARY KEY (`idstatut`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statut`
--

LOCK TABLES `statut` WRITE;
/*!40000 ALTER TABLE `statut` DISABLE KEYS */;
INSERT INTO `statut` VALUES (1,'Administrateur'),(2,'Etudiant'),(3,'Responsable projet');
/*!40000 ALTER TABLE `statut` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-03-28 20:17:39
