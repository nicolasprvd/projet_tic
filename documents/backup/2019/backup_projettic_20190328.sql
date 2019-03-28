-- MySQL dump 10.13  Distrib 5.7.14, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: projettic
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
INSERT INTO `choix_temp` VALUES (19,7),(21,7),(21,12),(21,16);
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
INSERT INTO `document` VALUES (18,1,'Calendrier MIAGE M1-M2 2018-2019.pdf','CDC'),(19,1,'Calendrier MIAGE M1-M2 2018-2019.pdf','CDC'),(19,2,'relevÃƒÂ© de notes-14052018134631.pdf','GANTT'),(19,3,'Bouton5.zip','RF');
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evaluation`
--

LOCK TABLES `evaluation` WRITE;
/*!40000 ALTER TABLE `evaluation` DISABLE KEYS */;
INSERT INTO `evaluation` VALUES (1,18.00,15.00,16.00,15.83);
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
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groupe_temp`
--

LOCK TABLES `groupe_temp` WRITE;
/*!40000 ALTER TABLE `groupe_temp` DISABLE KEYS */;
INSERT INTO `groupe_temp` VALUES (16,48),(7,2),(12,11);
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
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personne`
--

LOCK TABLES `personne` WRITE;
/*!40000 ALTER TABLE `personne` DISABLE KEYS */;
INSERT INTO `personne` VALUES (1,NULL,NULL,1,NULL,'Zemmari','Akka','zemmari@labri.fr','$2y$10$dDpQ4pBiS2EWNdwf57X4r.vTFfi0Mm/BbVIfwamAiOPQ9APojpZg.'),(2,NULL,NULL,2,7,'Preveraud','Nicolas','nicolas.preveraud@gmail.com','$2y$10$GZhZ3G7L3VBIcy522AteX.sWMiRLhL7ZkWXZwHBj9KeLK9fsWGLRy'),(3,NULL,NULL,2,7,'Balat','Audrey','audrey.balat@gmail.com','$2y$10$B7jhAwSKVWX/G6w7cBO7D.Qu2KkZMwxJeo.NW3MVlfUF98n0eyFga'),(4,NULL,NULL,2,NULL,'Bureau','Tiffany','tiffany.bureau@gmail.com','$2y$10$zGy8LGXcac6a7Wj5zwy7PuC41silCspUbtbQKENMu8A2MJGbxOHCG'),(5,NULL,NULL,2,NULL,'Hubert','Stephanie','stephanie.hubert@gmail.com','$2y$10$DzelrkYjelRMFI806jepl.trTpZeq2GVAi03XURLSK.KkTdwlusqa'),(10,NULL,NULL,3,NULL,'Maillet','Christophe','maillet@labri.fr','$2y$10$evWr5FvrvhX/lPZFVB.R1uQ/CmMF8tvGO/5Qb0vfTKjzIcmsEP/sm'),(9,NULL,NULL,3,NULL,'Maabout','Sofian','maabout@labri.fr','$2y$10$iTj13F.gv3yzo/orRGCHnOnjAve0VrRXRmTZIUAxXlLS9XedFDqXO'),(11,NULL,NULL,2,12,'Monge','Maxime','maxime.monge@gmail.com','$2y$10$D3OJuI5/nszj8v1Ws7LRhupkB8wAEYPNQ9c4h.cGOeAcsua7fak1O'),(12,NULL,NULL,2,NULL,'Rakotoarijaona','Camille','camille.rakotoarijaona@gmail.com','$2y$10$5DFNWZf7yhcj9jVRLGREyechRZHTXY021WtYfUOAmTZTENpUYP29i'),(13,NULL,NULL,2,NULL,'Nait Amara','Lilia','lilia.naitamara@gmail.com','$2y$10$KSoAPe.KOiUdt6CrMkmJVuV26CXH9v1omLnYLJSO.Kyz2ikNpF9wG'),(14,NULL,NULL,2,NULL,'Aidara','Sifaye','sifaye.aidara@gmail.com','$2y$10$pW9Ftjidb0AsmCCYK8hX9OIQkZJbXR6QTfS/upqV9xk/fp9sAIXZC'),(15,NULL,NULL,2,NULL,'Herrera','Anna','anna.herrera@gmail.com','$2y$10$2btmcNqMnp1DAgazCnApIuWwnCAKja1Ec.GiCSYcdpeOySk9ivD9S'),(16,NULL,NULL,2,NULL,'Rudari','Labinot','labinot.rudari@gmail.com','$2y$10$Hi55k8sAkF.6Zz7wSZYG1OL6qlTD1/Ux8cDe32FiWXjb465iWMZTG'),(17,NULL,NULL,2,NULL,'Essaid','Maroua','maroua.essaid@gmail.com','$2y$10$KyOTyJtTdKL0XnZkcMA39OkA.hA1bQGF6PAzA8TbS2GbcRO5Vzq8u'),(18,NULL,NULL,2,NULL,'Renaud','Valentine','valentine.renaud@gmail.com','$2y$10$k.quKlx.PZHXPbM0wLanXuEn14yrqOLeZ78bQCsCo937QZO2bAK36'),(19,NULL,NULL,2,NULL,'Talon','Diane','diane.talon@gmail.com','$2y$10$CdYpr6qGn.9ecyEl7je1a.sEmAN5bGTsT.88O/ADtovXOsbhpoI4S'),(20,NULL,NULL,2,NULL,'Reviron','Mathieu','mathieu.reviron@gmail.com','$2y$10$spltlET3NEzOLKsxG1uY1eseiFQiNfK3QBn6PCYovVGD.gb2Dne5a'),(21,NULL,NULL,2,NULL,'Kibble','Edward','edward.kibble@gmail.com','$2y$10$MJpLET.z1hHuEjBeCeY3NO68/fVb7OkfUbslRoeoc6r9oTQC//G/m'),(22,NULL,NULL,2,NULL,'Cipolato','Joris','joris.cipolato@gmail.com','$2y$10$qRiJ7yp.wD4ipsFQ/l9equAoZJvAMLVyvCJ8v7MYyzwAG.euMn/sK'),(23,NULL,NULL,2,NULL,'Molia','Clara','clara.molia@gmail.com','$2y$10$37BMotv5fM1wcu9FiufgruhYJsi5TcMUyBtDescGSDeQ6IIqgyUiS'),(24,NULL,NULL,2,NULL,'Hivon','Marine','marine.hivon@gmail.com','$2y$10$YsH.ke/e2Q7kDYHsWPCZI.WUt/2CgFdcTB915gxGShwrbSm/JoWEa'),(25,NULL,NULL,2,NULL,'Denizot','Eléa','elea.denizot@gmail.com','$2y$10$VML5XHwMq94o/TY/QYKDU.DbQsHtYMxTUl3XlgFcopmXstHZsLXYe'),(26,NULL,NULL,2,NULL,'Yang','Shiyi','shiyi.yang@gmail.com','$2y$10$Xg./sQi.FVZqHHltRg5J1eot3mqcDkgBJ11oXa.dVD8ZZ0WoVmI6i'),(27,NULL,NULL,2,NULL,'Akbaraly','Zenabe','zenabe.akbaraly@gmail.com','$2y$10$0OLpmFganriBr9Lr2Xxki.Vvfv5WSq0erNuxb2rJ0HHiwVPiOGEm6'),(28,NULL,NULL,2,NULL,'Chamouleau','Ludwig','ludwig.chamouleau@gmail.com','$2y$10$GFc1ebs71LauiqW74IPA1eb4Jkiq3V9nhtZxD5tyj/Q88HCWSaKHG'),(29,NULL,NULL,2,NULL,'Shah','Oubeyy','oubeyy.shah@gmail.com','$2y$10$mqAGg4jILTg29nXhyXYKdeRdX5p/xcSOt1brjRF1CsENVuoR87uBa'),(30,NULL,NULL,2,NULL,'Hochet','Claire-Elise','claire-elise.hochet@gmail.com','$2y$10$on5KibZdBm0bm.fdRqSdd.kSmi3hSzGLY5jS4VOMv0VF0KyVuPM4O'),(31,NULL,NULL,3,NULL,'Catapoulé Kichenassamy','Agastya','agastya.catapoule@gmail.com','agastya'),(32,NULL,NULL,2,NULL,'Berrouet','Damien','damien.berrouet@gmail.com','$2y$10$.oSFT66BRRVXTqGPfF10f.NNuBq6.Op/CD0fajIVtLtlEXXWjYFT6'),(33,NULL,NULL,2,NULL,'Mari','Nathan','nathan.mari@gmail.com','$2y$10$.OZI3GucAoj/A2qYHOBvROe7Dq/e8iTJQUBjPqDTxusjLnvHqKJ0m'),(34,NULL,NULL,2,NULL,'Vanacker','Thibaut','thibaut.vanacker@gmail.com','$2y$10$9qIpk6Wayq0Wq.05TqDrterkFk5hbs2GZqkANw5BwH8z4ko.B9.Ui'),(35,NULL,NULL,2,NULL,'Yubero','Jerome','jerome.yubero@gmail.com','$2y$10$Yzh6pB3yl4d1mOmxAp9KQ.9ZKN1kiVynl2JCn/TIazWDVQ7jPKY5a'),(36,NULL,NULL,2,NULL,'Deguilhem','Amaury','amaury.deguilhem@gmail.com','$2y$10$OllJlJyv4y3N/gCL715OiOerPivojq54BQw/K0EAb7KOTtOEhiura'),(37,NULL,NULL,2,NULL,'Berwit','Yonnel','yonnel.berwit@gmail.com','$2y$10$kF9fgl/Lj2wJ5ST8wO/izemsyScE1IS6ga.ErBUYbrpycg37ihd/W'),(38,NULL,NULL,2,NULL,'Leothaud','Mathieu','mathieu.leothaud@gmail.com','$2y$10$WyJQy7t0pbDjUnuyjw8KbO8f7l9RW9RfkK.PGtfeT6MU5eIRdmT2y'),(39,NULL,NULL,2,16,'Lamoureux','Alban','alban.lamoureux@gmail.com','$2y$10$BD7SAIwThr/ELMmTJ2a4N.GIYFXAOAsVOXPXr9LyTiiDTdt7m73pe'),(40,NULL,NULL,2,NULL,'Chinour','Adrien','adrien.chinour@gmail.com','$2y$10$668xDUErNeyQMlcIJzF.aOkurKCvS5NziWKUdy6aQObJmL/5lFLUG'),(41,NULL,NULL,2,NULL,'El-Ouardani','Brahim','brahim.elouardani@gmail.com','$2y$10$4wpfx8/wIJBUHBkuWlDaE.rI6jA0u436paYQbBAezW4KV/21tb/YC'),(42,NULL,NULL,2,NULL,'Jacquit','Paul','paul.jacquit@gmail.com','$2y$10$9LG9HNlezqarIJ8L2SuhYeUYdHblJIoQYDJSqHYM3dNyuSWp96LDG'),(43,NULL,NULL,2,NULL,'Duluc','Julien','julien.duluc@gmail.com','$2y$10$xeCuz6VKhrq/8vr1K/EAe.LfbwssaEtsL00QkyOuaooQ.UAfTX9DS'),(44,NULL,NULL,2,NULL,'Prieto','Baptiste','baptiste.prieto@gmail.com','$2y$10$pSDb/ReulcrckdriMV06leeONnNDDwaNO5m.qt.mNHASF/c5amr3.'),(45,NULL,NULL,2,NULL,'Catagnede','Clément','clement.castagnede@gmail.com','$2y$10$EmSHcUN0BmllbSZGI/P/3utAT6AJvQRS.eYnCBHctOKoYHovFuk5y'),(46,NULL,NULL,2,NULL,'Labat','Anthony','anthony.labat@gmail.com','$2y$10$f0XQKu3UC02L130wDif3v.8HX25hWcQwShZTEWF.b59ff5EgSz7dS'),(47,NULL,NULL,2,NULL,'DePonton D\'amecourt','Gustave','gustave.depontondamecourt@gmail.com','$2y$10$FyMCg/HpaM8HAK18ZxZGO.3vLWfsX2uMHTXoqPzhEu6Nm/ccvnRiK'),(48,NULL,NULL,2,16,'Kirch','Florent','florent.kirch@gmail.com','$2y$10$LpAh9V6SwnoOkOORptMib.n7FNGyYAguPKgJf6XdgEIcvCNedLAjm'),(49,NULL,NULL,2,NULL,'Kadi','Mohamed','mohamed.kadi@gmail.com','$2y$10$3kMQAy7w279bBC37RtYULOlM4rpjXSNHkNCFqyJ/0N0aw5eSCrAuG'),(50,NULL,NULL,2,NULL,'Sal','Lamine','lamine.sal@gmail.com','$2y$10$pe4HcqAtRBq8xRRj66OB5.L56FywnaVeVt2JFVnu7wWnHRNjNwM2y'),(51,NULL,NULL,2,NULL,'Dauphole','Alexandre','alexandre.dauphole@gmail.com','$2y$10$YAAHwsAHatNriumENWmlI.9aE20ooVj4Vc8c/8Zyj3KB2ZGa2KgeS'),(52,NULL,NULL,2,NULL,'Sostac','Dylan','dylan.sostac@gmail.com','$2y$10$TwOWD5MU0MtuDHM6uXLhBurBPKwsObgK2wDmCySNx3XP3g.0f3any'),(53,NULL,NULL,2,NULL,'Admane','Selma','selma.admane@gmail.com','$2y$10$aERZ9rgkO5bc56mNrVKTeOUQhdHo3DQWSGNRk9W3prCj6DwhMB92S'),(54,NULL,NULL,2,NULL,'Ravaine','Aymeric','aymeric.ravaine@gmail.com','$2y$10$YU58Lrml0OjxMpF1T/s3POxO9ACwGI02fQbjgUfBB.TLVuVrMQrli'),(55,NULL,NULL,2,12,'Benattou','Adam','adam.benattou@gmail.com','$2y$10$n3S9oYhEJ.hgISrrt3ri8OStvP7oFQT7.0g59hhEe/OgI0AqAmqWK'),(56,NULL,NULL,3,NULL,'Melancon','Guy','guy.melancon@gmail.com','$2y$10$rbpRRX42xMlrer0Ni6IStel862KQ5vnijint6YkIJnSn375OOug5y'),(62,NULL,NULL,3,NULL,'je','suis','je.suis@gmail.com','$2y$10$a1Fi66N.tTSMJs8Uxn3K.OjMFcozHmjHFU2z7GB7qwXbtXQZAr/OC'),(63,NULL,NULL,2,NULL,'etu2','etu2','etu2@gmail.com','$2y$10$o13ESXDpC.//URT3cvpooetZOEXcYmRzka3kosmA3fFnpAyE7dMfa'),(64,NULL,NULL,2,NULL,'etu1','etu1','etu1@gmail.com','$2y$10$Vpkf7INXcsHtbVIMOQlR8eWdP2fLlxLMQKfwB9U.IrRHH.s4bD9ou'),(65,NULL,NULL,2,NULL,'etu3','etu3','etu3@gmail.com','$2y$10$u5LbTdixHEPodLppFzgpiew/XNa81T50E9Yl0hDpzF5B.AQg.R3dy'),(66,NULL,NULL,2,NULL,'etu4','etu4','etu4@gmail.com','$2y$10$sqzW12cdbQ.REy8l7QHv0OAaRGOfhY5zD4VSyLcXn10fFr7WqDOPm'),(67,NULL,NULL,2,NULL,'etu5','etu5','etu5@gmail.com','$2y$10$XLOE6h.tSZqrRgvGmUwsFOxO1htQiPuc6T/yEcT7n/EzIOtO2mpou'),(68,NULL,NULL,2,NULL,'etu6','etu6','etu6@gmail.com','$2y$10$kakIw4p0IXzfOkSw4jeaW.G6CloHQ1tydVn2m2YjsuWAoHSf/ojXy'),(69,NULL,NULL,2,NULL,'etu7','etu7','etu7@gmail.com','$2y$10$SB57UjphbbCoA875vuJo0.OA6weAxLMcg1UuMusxeSRwa9RDiy61u'),(70,NULL,NULL,2,NULL,'etu8','etu8','etu8@gmail.com','$2y$10$bMdKAwZI5UcnVCWIcByoguHjp2cpdZwTEkl4A4vrA99BY6P3tqEI6');
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
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projet`
--

LOCK TABLES `projet` WRITE;
/*!40000 ALTER TABLE `projet` DISABLE KEYS */;
INSERT INTO `projet` VALUES (21,9,'Retrouvez teddy','mais ou est teddy?',NULL,2,1),(2,10,'Journée entreprises','Ce projet a pour but d\'organiser la journée entreprise de la MIAGE afin décrocher un stage, une alternance et d\'entretenir son réseau professionnel. Bien entendu, le petit déjeuner doit être pris en charge par les étudiants affectés au projet',NULL,4,1),(8,1,'Atos IT Challenge','Voir https://www.atositchallenge.net, l\'IA en aide pour les personnes âgées',NULL,4,1),(7,31,'Développement d\'un GANTT collaboratif web','Développement d\'un GANTT collaboratif web dans le cadre des projets TIC de la MIAGE',NULL,4,1),(9,1,'Un webservice pour la détection de mallwares','Description : webservice pour la détection de mallwares',NULL,4,1),(10,56,'Etude de cas: système d\'information UB, cartographie et documentation','Description ',NULL,2,1),(12,31,'Réfrigérateur intelligent','Développement d\'une application permettant de suggérer des recettes à partir du contenu du frigo et en fonction des dates de péremption',NULL,4,1),(13,31,'Gestion pharmacopée avec QR Code v2','Application permettant de gérer sa pharmacie personnelle',NULL,4,1),(14,31,'Outil de suivi pour les stages MIAGE','Développement Web pour le suivi des objectifs des stages / alternances',NULL,4,1),(15,31,'POC avec IBM Watson','Création d\'un cas usage illustrant les capacités et limites du produit édité par IBM',NULL,4,1),(16,31,'Développement d\'un outil de gestion de centre de formation','Audit de l\'application et développement de modules complémentaires',NULL,4,1),(17,10,'Evolution d\'un applicatif de gestion de note de frais en symfony','Description : blabla',NULL,4,1),(20,9,'retrouver mon doudou','s\'il vous plait mon doudou',NULL,2,1),(18,62,'la meilleure','Faite le meilleur projet du monde ',NULL,2,0),(19,62,'la plus belle','je suis trop belle','relevÃ© de notes-14052018134631.pdf',2,1);
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

-- Dump completed on 2019-03-28 18:15:45
