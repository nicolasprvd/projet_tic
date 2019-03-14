-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Dim 10 Mars 2019 à 18:07
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

--
-- Contenu de la table `document`
--

INSERT INTO `document` (`idprojet`, `iddoc`, `chemindoc`, `typedoc`) VALUES
(1, 1, 'Cahier des charges-Gestion des projets TIC.pdf', 'CDC'),
(1, 2, 'Ecriture.pdf', 'GANTT'),
(1, 3, 'Bouton5.zip', 'RF');

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

--
-- Contenu de la table `evaluation`
--

INSERT INTO `evaluation` (`idevaluation`, `notecdc`, `notesoutenance`, `noterendu`, `notefinale`) VALUES
(16, '2.00', '4.00', '7.00', '4.50');

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

CREATE TABLE `groupe` (
  `idgroupe` int(2) NOT NULL,
  `idprojet` int(2) NOT NULL,
  `idpersonnechef` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `groupe`
--

INSERT INTO `groupe` (`idgroupe`, `idprojet`, `idpersonnechef`) VALUES
(18, 1, 2);

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
(1, NULL, NULL, 1, NULL, 'Zemmari', 'Akka', 'zemmari@labri.fr', '$2y$10$yveT1eUA5S3NKE8veQT59eEIjH.NrYbD8wBKvQ3ptocKK4Zl0R.3i'),
(2, 18, 16, 2, 18, 'Preveraud', 'Nicolas', 'nicolas.preveraud@gmail.com', '$2y$10$GZhZ3G7L3VBIcy522AteX.sWMiRLhL7ZkWXZwHBj9KeLK9fsWGLRy'),
(3, 18, 16, 2, 18, 'Balat', 'Audrey', 'audrey.balat@gmail.com', '$2y$10$B7jhAwSKVWX/G6w7cBO7D.Qu2KkZMwxJeo.NW3MVlfUF98n0eyFga'),
(4, 18, 16, 2, 18, 'Bureau', 'Tiffany', 'tiffany.bureau@gmail.com', '$2y$10$zGy8LGXcac6a7Wj5zwy7PuC41silCspUbtbQKENMu8A2MJGbxOHCG'),
(5, 18, 16, 2, 18, 'Hubert', 'Stephanie', 'stephanie.hubert@gmail.com', '$2y$10$DzelrkYjelRMFI806jepl.trTpZeq2GVAi03XURLSK.KkTdwlusqa'),
(10, NULL, NULL, 3, NULL, 'Maillet', 'Christophe', 'maillet@labri.fr', '$2y$10$evWr5FvrvhX/lPZFVB.R1uQ/CmMF8tvGO/5Qb0vfTKjzIcmsEP/sm'),
(9, NULL, NULL, 3, NULL, 'Maabout', 'Sofian', 'maabout@labri.fr', '$2y$10$iTj13F.gv3yzo/orRGCHnOnjAve0VrRXRmTZIUAxXlLS9XedFDqXO'),
(11, NULL, NULL, 2, NULL, 'Monge', 'Maxime', 'maxime.monge@gmail.com', '$2y$10$D3OJuI5/nszj8v1Ws7LRhupkB8wAEYPNQ9c4h.cGOeAcsua7fak1O'),
(12, NULL, NULL, 2, NULL, 'Rakotoarijaona', 'Camille', 'camille.rakotoarijaona@gmail.com', '$2y$10$5DFNWZf7yhcj9jVRLGREyechRZHTXY021WtYfUOAmTZTENpUYP29i'),
(13, NULL, NULL, 2, NULL, 'Nait Amara', 'Lilia', 'lilia.naitamara@gmail.com', '$2y$10$KSoAPe.KOiUdt6CrMkmJVuV26CXH9v1omLnYLJSO.Kyz2ikNpF9wG'),
(14, NULL, NULL, 2, NULL, 'Aidara', 'Sifaye', 'sifaye.aidara@gmail.com', '$2y$10$pW9Ftjidb0AsmCCYK8hX9OIQkZJbXR6QTfS/upqV9xk/fp9sAIXZC'),
(15, NULL, NULL, 2, NULL, 'Herrera', 'Anna', 'anna.herrera@gmail.com', '$2y$10$2btmcNqMnp1DAgazCnApIuWwnCAKja1Ec.GiCSYcdpeOySk9ivD9S'),
(16, NULL, NULL, 2, NULL, 'Rudari', 'Labinot', 'labinot.rudari@gmail.com', '$2y$10$Hi55k8sAkF.6Zz7wSZYG1OL6qlTD1/Ux8cDe32FiWXjb465iWMZTG'),
(17, NULL, NULL, 2, NULL, 'Essaid', 'Maroua', 'maroua.essaid@gmail.com', '$2y$10$KyOTyJtTdKL0XnZkcMA39OkA.hA1bQGF6PAzA8TbS2GbcRO5Vzq8u'),
(18, NULL, NULL, 2, NULL, 'Renaud', 'Valentine', 'valentine.renaud@gmail.com', '$2y$10$k.quKlx.PZHXPbM0wLanXuEn14yrqOLeZ78bQCsCo937QZO2bAK36'),
(19, NULL, NULL, 2, NULL, 'Talon', 'Diane', 'diane.talon@gmail.com', '$2y$10$CdYpr6qGn.9ecyEl7je1a.sEmAN5bGTsT.88O/ADtovXOsbhpoI4S'),
(20, NULL, NULL, 2, NULL, 'Reviron', 'Mathieu', 'mathieu.reviron@gmail.com', '$2y$10$spltlET3NEzOLKsxG1uY1eseiFQiNfK3QBn6PCYovVGD.gb2Dne5a'),
(21, NULL, NULL, 2, NULL, 'Kibble', 'Edward', 'edward.kibble@gmail.com', '$2y$10$MJpLET.z1hHuEjBeCeY3NO68/fVb7OkfUbslRoeoc6r9oTQC//G/m'),
(22, NULL, NULL, 2, NULL, 'Cipolato', 'Joris', 'joris.cipolato@gmail.com', '$2y$10$qRiJ7yp.wD4ipsFQ/l9equAoZJvAMLVyvCJ8v7MYyzwAG.euMn/sK'),
(23, NULL, NULL, 2, NULL, 'Molia', 'Clara', 'clara.molia@gmail.com', '$2y$10$37BMotv5fM1wcu9FiufgruhYJsi5TcMUyBtDescGSDeQ6IIqgyUiS'),
(24, NULL, NULL, 2, NULL, 'Hivon', 'Marine', 'marine.hivon@gmail.com', '$2y$10$YsH.ke/e2Q7kDYHsWPCZI.WUt/2CgFdcTB915gxGShwrbSm/JoWEa'),
(25, NULL, NULL, 2, NULL, 'Denizot', 'Eléa', 'elea.denizot@gmail.com', '$2y$10$VML5XHwMq94o/TY/QYKDU.DbQsHtYMxTUl3XlgFcopmXstHZsLXYe'),
(26, NULL, NULL, 2, NULL, 'Yang', 'Shiyi', 'shiyi.yang@gmail.com', '$2y$10$Xg./sQi.FVZqHHltRg5J1eot3mqcDkgBJ11oXa.dVD8ZZ0WoVmI6i'),
(27, NULL, NULL, 2, NULL, 'Akbaraly', 'Zenabe', 'zenabe.akbaraly@gmail.com', '$2y$10$0OLpmFganriBr9Lr2Xxki.Vvfv5WSq0erNuxb2rJ0HHiwVPiOGEm6'),
(28, NULL, NULL, 2, NULL, 'Chamouleau', 'Ludwig', 'ludwig.chamouleau@gmail.com', '$2y$10$GFc1ebs71LauiqW74IPA1eb4Jkiq3V9nhtZxD5tyj/Q88HCWSaKHG'),
(29, NULL, NULL, 2, NULL, 'Shah', 'Oubeyy', 'oubeyy.shah@gmail.com', '$2y$10$mqAGg4jILTg29nXhyXYKdeRdX5p/xcSOt1brjRF1CsENVuoR87uBa'),
(30, NULL, NULL, 2, NULL, 'Hochet', 'Claire-Elise', 'claire-elise.hochet@gmail.com', '$2y$10$on5KibZdBm0bm.fdRqSdd.kSmi3hSzGLY5jS4VOMv0VF0KyVuPM4O'),
(31, NULL, NULL, 3, NULL, 'Catapoulé Kichenassamy', 'Agastya', 'agastya.catapoule@gmail.com', '$2y$10$rKiuCFezLEtu0Dy7mDTAZeRy9jCp1mTUV4bi5zPIwW0j.IOh9G.I.');

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
-- Contenu de la table `projet`
--

INSERT INTO `projet` (`idprojet`, `idpersonneresp`, `nomprojet`, `descriptiftexte`, `descriptifpdf`, `nbEtudiants`, `automatique`) VALUES
(1, 9, 'Implémentation de jointures', 'Ce projet a pour but d\'implémenter des jointures', NULL, 4, 0),
(2, 10, 'Journée entreprises', 'Ce projet a pour but d\'organiser la journée entreprise de la MIAGE afin décrocher un stage, une alternance et d\'entretenir son réseau professionnel. Bien entendu, le petit déjeuner doit être pris en charge par les étudiants affectés au projet', NULL, 3, 1),
(3, 1, 'Outil pour la gestion des projets TIC', 'L’application de gestion des projets TIC doit permettre d’informatiser l’ensemble des informations décrivant les projets. Elle doit être accessible à tous les étudiants miagistes de l’université de Bordeaux et aux différents responsables de projet. En outre, elle doit pouvoir proposer des projets et les affecter à chaque groupe d’étudiants afin d’établir un processus de suivi.', '', 4, 1),
(7, 31, 'Développement d\'un GANTT collaboratif web', 'Développement d\'un GANTT collaboratif web dans le cadre des projets TIC de la MIAGE', NULL, 4, 1);

-- --------------------------------------------------------

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
-- AUTO_INCREMENT pour la table `document`
--
ALTER TABLE `document`
  MODIFY `iddoc` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `idevaluation` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT pour la table `groupe_temp`
--
ALTER TABLE `groupe_temp`
  MODIFY `idgroupe` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT pour la table `personne`
--
ALTER TABLE `personne`
  MODIFY `idpersonne` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT pour la table `projet`
--
ALTER TABLE `projet`
  MODIFY `idprojet` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `statut`
--
ALTER TABLE `statut`
  MODIFY `idstatut` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
