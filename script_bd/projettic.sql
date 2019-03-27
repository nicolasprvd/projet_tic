-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mer 27 Mars 2019 à 20:01
-- Version du serveur :  5.7.14
-- Version de PHP :  7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projettic`
--

-- --------------------------------------------------------

--
-- Structure de la table `choix_temp`
--

CREATE TABLE `choix_temp` (
  `idprojet` int(2) NOT NULL,
  `idgroupe` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `document`
--

CREATE TABLE `document` (
  `idprojet` int(11) NOT NULL,
  `iddoc` int(11) NOT NULL,
  `chemindoc` char(255) NOT NULL,
  `typedoc` char(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `evaluation`
--

CREATE TABLE `evaluation` (
  `idevaluation` int(2) NOT NULL,
  `notecdc` decimal(10,2) DEFAULT NULL,
  `notesoutenance` decimal(10,2) DEFAULT NULL,
  `noterendu` decimal(10,2) DEFAULT NULL,
  `notefinale` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

CREATE TABLE `groupe` (
  `idgroupe` int(2) NOT NULL,
  `idprojet` int(2) NOT NULL,
  `idpersonnechef` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `groupe_temp`
--

CREATE TABLE `groupe_temp` (
  `idgroupe` int(2) NOT NULL,
  `idpersonnechef` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

CREATE TABLE `personne` (
  `idpersonne` int(2) NOT NULL,
  `idgroupe` int(2) DEFAULT NULL,
  `idevaluation` int(2) DEFAULT NULL,
  `idstatut` int(2) NOT NULL,
  `idgroupetemp` int(2) DEFAULT NULL,
  `nompersonne` char(255) DEFAULT NULL,
  `prenompersonne` char(255) DEFAULT NULL,
  `mailpersonne` char(255) DEFAULT NULL,
  `password` char(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `personne`
--

INSERT INTO `personne` (`idpersonne`, `idgroupe`, `idevaluation`, `idstatut`, `idgroupetemp`, `nompersonne`, `prenompersonne`, `mailpersonne`, `password`) VALUES
(1, NULL, NULL, 1, NULL, 'Zemmari', 'Akka', 'zemmari@labri.fr', '$2y$10$dDpQ4pBiS2EWNdwf57X4r.vTFfi0Mm/BbVIfwamAiOPQ9APojpZg.');

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

CREATE TABLE `projet` (
  `idprojet` int(2) NOT NULL,
  `idpersonneresp` int(2) NOT NULL,
  `nomprojet` char(255) DEFAULT NULL,
  `descriptiftexte` text,
  `descriptifpdf` char(255) DEFAULT NULL,
  `nbEtudiants` int(11) NOT NULL,
  `automatique` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Structure de la table `statut`
--

CREATE TABLE `statut` (
  `idstatut` int(2) NOT NULL,
  `libelle` char(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `statut`
--

INSERT INTO `statut` (`idstatut`, `libelle`) VALUES
(1, 'Administrateur'),
(2, 'Etudiant'),
(3, 'Responsable projet');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `choix_temp`
--
ALTER TABLE `choix_temp`
  ADD PRIMARY KEY (`idprojet`,`idgroupe`),
  ADD KEY `fk_choix_temp_groupe_temp` (`idgroupe`);

--
-- Index pour la table `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`idprojet`,`iddoc`),
  ADD KEY `fk_document_projet` (`idprojet`);

--
-- Index pour la table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`idevaluation`);

--
-- Index pour la table `groupe`
--
ALTER TABLE `groupe`
  ADD PRIMARY KEY (`idgroupe`),
  ADD KEY `fk_groupe_projet` (`idprojet`),
  ADD KEY `fk_groupe_personne` (`idpersonnechef`);

--
-- Index pour la table `groupe_temp`
--
ALTER TABLE `groupe_temp`
  ADD PRIMARY KEY (`idgroupe`),
  ADD KEY `fk_groupe_temp_personne` (`idpersonnechef`);

--
-- Index pour la table `personne`
--
ALTER TABLE `personne`
  ADD PRIMARY KEY (`idpersonne`),
  ADD KEY `fk_personne_groupe` (`idgroupe`),
  ADD KEY `fk_personne_evaluation` (`idevaluation`),
  ADD KEY `fk_personne_statut` (`idstatut`),
  ADD KEY `fk_personne_groupe_temp` (`idgroupetemp`);

--
-- Index pour la table `projet`
--
ALTER TABLE `projet`
  ADD PRIMARY KEY (`idprojet`),
  ADD KEY `fk_projet_personne` (`idpersonneresp`);

--
-- Index pour la table `statut`
--
ALTER TABLE `statut`
  ADD PRIMARY KEY (`idstatut`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `personne`
--
ALTER TABLE `personne`
  MODIFY `idpersonne` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
