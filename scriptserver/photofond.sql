-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Jeu 01 Décembre 2011 à 16:08
-- Version du serveur: 5.1.41
-- Version de PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `dugala`
--

-- --------------------------------------------------------

--
-- Structure de la table `photofond`
--

CREATE TABLE IF NOT EXISTS `photofond` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  `datecreer` datetime NOT NULL,
  `nomfichier` varchar(45) NOT NULL,
  `IsActive` tinyint(4) NOT NULL DEFAULT '0',
  `nomThumb` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Contenu de la table `photofond`
--

INSERT INTO `photofond` (`id`, `nom`, `datecreer`, `nomfichier`, `IsActive`, `nomThumb`) VALUES
(1, 'original', '2011-02-04 13:36:10', '.jpg', 1, 'original.jpg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
