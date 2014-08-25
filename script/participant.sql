-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Jeu 21 Août 2014 à 19:26
-- Version du serveur: 5.6.12-log
-- Version de PHP: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `piquenique`
--

-- --------------------------------------------------------

--
-- Structure de la table `participant`
--

CREATE TABLE IF NOT EXISTS `participant` (
  `civilite` varchar(4) DEFAULT NULL COMMENT 'Civilité de l''inscrit',
  `nom` varchar(25) NOT NULL COMMENT 'Nom de famille',
  `nomAuBts` varchar(25) DEFAULT NULL COMMENT 'Nom de famille au moment du bts',
  `prenom` varchar(25) NOT NULL COMMENT 'Prénom',
  `mail` varchar(50) NOT NULL COMMENT 'E-Mail de l''inscrit',
  `password` char(32) DEFAULT NULL COMMENT 'Mot de passe de l''inscrit',
  `section` varchar(20) DEFAULT NULL COMMENT 'Section effectuée au BTS',
  `anneeSorti` varchar(4) DEFAULT NULL COMMENT 'Année de sortie du BTS',
  `participation` varchar(3) NOT NULL COMMENT 'Si l’inscrit participe ou pas',
  `nbParticipants` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Nombre de participants',
  `fonction` varchar(50) DEFAULT NULL COMMENT 'Fonction de l''inscrit dans son entreprise',
  `nomEise` varchar(50) DEFAULT NULL COMMENT 'Nom de l''entreprise de l''inscrit',
  `adresseEise1` varchar(50) DEFAULT NULL COMMENT 'Adresse de l''entreprise de l’inscrit',
  `adresseEise2` varchar(50) DEFAULT NULL COMMENT 'Adresse complémentaire de l''entrerprise ',
  `codePostal` varchar(5) DEFAULT NULL COMMENT 'Code Postal de l''entreprise',
  `ville` varchar(25) DEFAULT NULL COMMENT 'Ville de l''entreprise',
  PRIMARY KEY (`mail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
