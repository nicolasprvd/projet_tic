-- MySQL dump 10.16  Distrib 10.1.37-MariaDB, for Win32 (AMD64)
--
-- Host: 127.0.0.1    Database: projettic
-- ------------------------------------------------------
-- Server version	10.1.37-MariaDB

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
  `iddoc` int(3) NOT NULL AUTO_INCREMENT,
  `idprojet` int(2) NOT NULL,
  `chemindoc` char(255) NOT NULL,
  `typedoc` char(255) NOT NULL,
  PRIMARY KEY (`iddoc`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document`
--

LOCK TABLES `document` WRITE;
/*!40000 ALTER TABLE `document` DISABLE KEYS */;
INSERT INTO `document` VALUES (4,27,'Cahier des charges-Gestion des projets TIC.pdf','CDC'),(5,27,'Bouton5.zip','RF'),(6,27,'Ecriture.pdf','GANTT'),(7,26,'Cover letter structure  rules LSE.docx','CDC'),(8,41,'CDC_RENAUD_REVIRON_2018-2019.pdf','CDC'),(9,41,'CDC_RENAUD_REVIRON_2018-2019.pdf','CDC'),(10,41,'Chapitre-1.pdf','GANTT'),(11,41,'Bouton5 (1).zip','RF'),(12,41,'Bouton5 (1).zip','RF');
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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evaluation`
--

LOCK TABLES `evaluation` WRITE;
/*!40000 ALTER TABLE `evaluation` DISABLE KEYS */;
INSERT INTO `evaluation` VALUES (1,18.50,20.00,19.00,19.25),(2,17.00,16.00,15.00,15.83);
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
INSERT INTO `groupe` VALUES (11,27,3),(13,25,4),(14,24,12),(12,26,2),(29,30,18),(31,32,21),(30,31,15),(50,34,25),(49,33,23),(51,35,29),(52,36,31),(54,39,36),(53,38,34),(55,41,41),(56,42,44);
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
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;
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
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personne`
--

LOCK TABLES `personne` WRITE;
/*!40000 ALTER TABLE `personne` DISABLE KEYS */;
INSERT INTO `personne` VALUES (1,NULL,NULL,1,NULL,'Zemmari','Akka','zemmari@labri.fr','$2y$10$yveT1eUA5S3NKE8veQT59eEIjH.NrYbD8wBKvQ3ptocKK4Zl0R.3i'),(2,12,NULL,2,12,'Preveraud','Nicolas','nicolas.preveraud@gmail.com','$2y$10$GZhZ3G7L3VBIcy522AteX.sWMiRLhL7ZkWXZwHBj9KeLK9fsWGLRy'),(3,11,1,2,11,'Balat','Audrey','audrey.balat@gmail.com','$2y$10$B7jhAwSKVWX/G6w7cBO7D.Qu2KkZMwxJeo.NW3MVlfUF98n0eyFga'),(4,13,NULL,2,13,'Bureau','Tiffany','tiffany.bureau@gmail.com','$2y$10$zGy8LGXcac6a7Wj5zwy7PuC41silCspUbtbQKENMu8A2MJGbxOHCG'),(5,14,NULL,2,14,'Hubert','Stephanie','stephanie.hubert@gmail.com','$2y$10$DzelrkYjelRMFI806jepl.trTpZeq2GVAi03XURLSK.KkTdwlusqa'),(17,30,NULL,2,30,'bouaziz','sarah','sarah.bouaziz@gmail.com','$2y$10$S7exWTqrCvUhubbOgZDJuuEh0ew5amrt5YiWCojdcyNnADiuTpTQK'),(7,NULL,NULL,3,NULL,'BALAT','Sandra','sandra.balat@gmail.com','$2y$10$I0pJa5k0XzCnnYoI7IBxeO.ex./PomqFdgDFDkYqEZGnqc/u9J5Le'),(8,NULL,NULL,3,NULL,'GALA','GALA','gala.gala@gmail.com','$2y$10$8Ma.mzjTmVkJ/hG.IBtgbOrS22Uk/2SYgQQVETy9vu.afp.4wji96'),(9,11,1,2,11,'BALAT','Cyril','cyril.balat@gmail.com','$2y$10$rdWmUCr6bL9S1jEfEuJpbeudo7Lxp9rorOiuTUf9eNS4CQVEmUhWW'),(10,12,NULL,2,12,'SACHOT','Pierre','pierre.sachot@gmail.com','$2y$10$hIa/e0P8rLebfBjZ7HT/huiMVW/MKdFnzUrxbVQ7mXPzJ3IbdXDMu'),(11,13,NULL,2,13,'MONGE','Maxime','maxime.monge@gmail.com','$2y$10$kZjb8CKKP343wc.ft0VyjO/H8q2K33sWJeDNGiEvsqdZbt.ymGBqq'),(12,14,NULL,2,14,'Baccou','Laura','laura.baccou@gmail.com','$2y$10$ZDQo/i6oN9HkUCR5U3VnV.rsZ3DHbROAOd3ODP1U0fiN7ChrpaaXG'),(15,30,NULL,2,30,'Rey','Manon','manon.ray@gmail.com','$2y$10$cWZj87EEXHRXMo2viXaF7uDv4ctbztO2.nPcZvDvLkigzDZ5WA88G'),(16,29,NULL,2,29,'Fauconnier','Charlotte','charlotte.fauconnier@gmail.com','$2y$10$v/QWb7TkX2SzxpB0hDMfO.fP7liHUbZR6X9Fk0XldF3gabfqzSYyK'),(18,29,NULL,2,29,'Duval','Helene','helene.duval@gmail.com','$2y$10$0xw7aCGfagJ70qVN2I6jPegDqPmb5XUKPLxGPnw8H7a45lqUyW8Re'),(19,NULL,NULL,3,NULL,'Ratinahirana','ando','ando.ratinahirana@gmail.com','$2y$10$A7oCq8Z2pgGfDmiR.LH2QeEO0otKbxCOtFb160WgBC/zMoGdnJaQy'),(20,31,NULL,2,31,'Bon','Jean','jean.bon@gmail.com','$2y$10$VrayIMpbP8L5dWstMBQfPeOC.rg521sfUQylkysL0awUlX6SHWGpu'),(21,31,NULL,2,31,'Bang','Carlito','carlito.bang@gmail.com','$2y$10$JYLpjTnq79W4dT2DwFLaLONbh9rmWZSxdaeZXeVBqXI58xzgQ1C06'),(22,NULL,NULL,3,NULL,'MIOT','Eric','eric.miot@gmail.com','$2y$10$8jYpV0hV8B5i1n6Wd9TjPe7b.aWMOwOBjsSYAhRaEmHT7YfaJky2q'),(23,49,NULL,2,49,'un','un','un.un@gmail.com','$2y$10$UaFMjyd6Wcoi4zLZI3FPCeEC4I3AghGeCUMwy1.jRcxOOJezGAaKK'),(24,49,NULL,2,49,'deux','deux','deux.deux@gmail.com','$2y$10$Vc1KmLVC2DyvA1KPfSWMv.fPFn4ws6ukaDKQFIMdgd6yGSWOT/Cv6'),(25,50,NULL,2,50,'trois','trois','trois.trois@gmail.com','$2y$10$rlfKfcqcclI/LU/PKVdRS.qYw5Rzkah5sZb6dL22irkcBDhNuB29u'),(26,50,NULL,2,50,'quatre','quatre','quatre.quatre@gmail.com','$2y$10$49Nyh9dt1Mby3H0D6HQKzOGpgXM30PTN6hXYxW3ztaPXnqYN30kT2'),(27,NULL,NULL,3,NULL,'ici','labas','ici.laba@gmail.com','$2y$10$Aoi.ZKeX8lZTN0XO8fAnsOBtkoWmz44NDFKC1eB0pu62m2EvaPX1e'),(28,51,NULL,2,51,'moi','moilabest','moi.moilabest@gmail.com','$2y$10$TRFJFvpco9pjZcj8jjY3NOU.E1UtkBg93tK/Eg6NcQ2JNl4CR8lzO'),(29,51,NULL,2,51,'je','suis','je.suis@gmail.com','$2y$10$j/GndLWeURwGXQ0NfaMfseKOeAy5cZ0pUP/B6wNdyizePgzJCDxkm'),(30,52,NULL,2,52,'bjr','bjr','bjr.bjr@gmail.com','$2y$10$Y61ujNowk652fqx2hGxoiuCDpq55BZVc3Xu3desznmqSAdx4GSWwW'),(31,52,NULL,2,52,'aur','aur','aur.aur@gmail.com','$2y$10$B.z13YZTwI0rJ1lYvYSUdOoP8CO6UZzGTUdeQDtAyCrBiDCckq24a'),(32,NULL,NULL,3,NULL,'p','s','p.s@gmail.com','$2y$10$evEjx/bmiQBVjSY3CHh0GeOV6TPzB9zTSI95bhRIyBYf1AVO3q8CS'),(33,53,NULL,2,53,'pp','ss','pp.ss@gmail.com','$2y$10$gF21TkRSqMWkLMyg1Z1eo.8oFmlqG.vvMssmM/InfUmqHP3BJXMbu'),(34,53,NULL,2,53,'ppp','sss','ppp.sss@gmail.com','$2y$10$TEV1iWfS8FPrI8AVCrAEeOEajcdM8ZLyuP0g.uH5/oDHirlzU1lly'),(35,54,NULL,2,54,'ss','pp','ss.pp@gmail.com','$2y$10$at/JNavAhUI8pXGpFhwMJOiu/dKH8H.yJYW3Ks4JiWImRro2qXX9K'),(36,54,NULL,2,54,'sss','ppp','sss.ppp@gmail.com','$2y$10$DWU2AbMsMy9ddwEhVSwCJurCIkiHAw1BSmcX9tg.Ld76czs86xVFG'),(37,NULL,NULL,2,NULL,'mia','mia','mia.mia@gmail.com','$2y$10$YtLOwgLvTwB8zkuTIdZEm.HYuaJMa8mBvPT707Sfv2vqCEtTGF6xa'),(38,NULL,NULL,3,NULL,'CATAPOULE','Agastya','agastya.catapoule@labri.fr','$2y$10$mq7TsiWIaJtt822vsBdS/OI2I1maIR1sQEml6dgcvtbVq/qpdD5sq'),(39,NULL,NULL,3,NULL,'MAILLET','Christophe','christophe.maillet@labri.fr','$2y$10$0zZB5nMKLwMqRME8C06F6OLBzhUV41wPM.sPmB5Kjw8rBfdX/H2Nm'),(40,NULL,NULL,3,NULL,'MAABOUT','sofian','sofian.maabout@gmail.com','$2y$10$bFRYOo1lA5ChDvPHIrdQAuRyV6rj6/l4rj/5tua72EDUx6LhIPqBi'),(41,55,2,2,55,'Renaud','Valentine','valentine.renaud@gmail.com','$2y$10$TY/7dNZm.eeUIpGg3kUW9OGqd4F4zeb3AE/IMleS356M9amqOeIDe'),(42,55,2,2,55,'Reviron','Mathieu','mathieu.reviron@gmail.com','$2y$10$.UWjlu3ASlyjaMrdBb/uk.Egt/HcWK0DCkIY8A6YdsTVvISPFeNKC'),(43,56,NULL,2,56,'Berrouet','Damien','damien.berrouet@gmail.com','$2y$10$aAofGjv7dMIHnuNUH55gHeOXGLQpfsEt8699/cFH1f5dlB5dcnIlW'),(44,56,NULL,2,56,'Kirch','Florent','florent.kirch@gmail.com','$2y$10$XKGxW6uZ7U6zXXuZUs6QV.MHIfuK0bpA3a96dUV76NwWJAwDreT1a');
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
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projet`
--

LOCK TABLES `projet` WRITE;
/*!40000 ALTER TABLE `projet` DISABLE KEYS */;
INSERT INTO `projet` VALUES (26,1,'robotique et ecologie','Vous devrez au cours de se projet être inovant pour liée écologie et robotique',NULL,2,1),(27,7,'Attrib manuel','Projet qui s\'attribut manuellement',NULL,2,0),(24,7,'Bonjour','Je suis la soeur d\'Audrey','Calendrier MIAGE M1-M2 2018-2019.pdf',2,1),(25,8,'GALA','Vous devrez organiser le gala de la miage','relevé de notes-14052018134631.pdf',2,0),(31,19,'Ratina','ratina alalal',NULL,2,1),(30,19,'Ando','le meilleur',NULL,2,1),(32,19,'audrey','alternante',NULL,2,1),(33,22,'GPBC','Gestion previsionnelle des besoins en compétences',NULL,2,1),(34,22,'GPBC manuel','Gestion des bz prev manuelle',NULL,2,0),(35,27,'labas ici','ici ou labas',NULL,2,0),(36,19,'Mon meilleur','Meilleur projet du monde',NULL,2,1),(38,32,'ps post','post scriptum tqt',NULL,2,1),(39,32,'ps scriptum','post crum test',NULL,2,0),(41,38,'Gala','Le projet Gala consiste à trouver un thème, un lieu, un traiteur... pour créer LA soirée dont les diplômés attendent depuis l\'annonce de leur réussite à la MIAGE de Bordeaux','gala.pdf',2,0),(42,38,'Développement d\'un GANTT Project collaboratif','Développement d\'un GANTT collaboratif Web',NULL,2,1),(43,39,'Evolution d\'un applicatif de gestion de note de frais symfony','Reprise d\'un existant.\r\nGérer la gestion de note de frais sous le framework symfony',NULL,2,1),(44,40,'Implémentation de jointure','Vous devrez implémenter des jointures pour qu\'elles soient le plus optimisé possible',NULL,2,1);
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

-- Dump completed on 2019-03-28 22:31:56
