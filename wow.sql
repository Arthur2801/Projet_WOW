-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 04 mai 2021 à 22:08
-- Version du serveur :  5.7.24
-- Version de PHP : 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `wow`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `idCom` int(11) NOT NULL,
  `commenta` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`idCom`, `commenta`) VALUES
(1, 'Ce site est incroyable !'),
(2, 'Cool !'),
(3, 'Très utile pour un joueur comme moi.');

-- --------------------------------------------------------

--
-- Structure de la table `import`
--

CREATE TABLE `import` (
  `timestamp` int(6) NOT NULL,
  `playersNumber` int(11) NOT NULL,
  `teamComp` varchar(255) NOT NULL,
  `ennemyComp` varchar(255) NOT NULL,
  `victory` tinyint(1) NOT NULL,
  `ratingChange` int(10) NOT NULL,
  `ennemyMMR` int(50) NOT NULL,
  `isRated` tinyint(1) NOT NULL,
  `idMap` int(50) NOT NULL,
  `idUser` int(255) NOT NULL,
  `specialization` varchar(30) NOT NULL,
  `Date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `maps`
--

CREATE TABLE `maps` (
  `idMap` int(244) NOT NULL,
  `Nom` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `maps`
--

INSERT INTO `maps` (`idMap`, `Nom`) VALUES
(572, 'Ruins of Lordaeron'),
(617, 'Dalaran Arena'),
(980, 'Tol\'Viron Arena'),
(1134, 'Tiger\'s Peak'),
(1504, 'BlackrookHoldArena'),
(1505, 'Nagrand Arena'),
(1552, 'Valsharah Arena'),
(1672, 'Blade\'s Edge Arena'),
(1825, 'KulTiras Arena'),
(1911, 'Zandalari Arena'),
(2167, 'The Robodrome'),
(2373, 'Empyrean Domain');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `idUser` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`idUser`, `username`, `password`) VALUES
(1, 'ssss', 'qq'),
(2, 'test', 'ee'),
(3, 'zzz', 'dd'),
(7, 'haha', 'opop'),
(8, 'gg', '12');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`idCom`);

--
-- Index pour la table `import`
--
ALTER TABLE `import`
  ADD PRIMARY KEY (`timestamp`),
  ADD KEY `import_ibfk_1` (`idMap`),
  ADD KEY `import_ibfk_2` (`idUser`);

--
-- Index pour la table `maps`
--
ALTER TABLE `maps`
  ADD PRIMARY KEY (`idMap`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `idCom` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `import`
--
ALTER TABLE `import`
  ADD CONSTRAINT `import_ibfk_1` FOREIGN KEY (`idMap`) REFERENCES `maps` (`idMap`),
  ADD CONSTRAINT `import_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
