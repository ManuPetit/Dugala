-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Jeu 01 Décembre 2011 à 16:09
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
-- Structure de la table `theme`
--

CREATE TABLE IF NOT EXISTS `theme` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `themeNom` varchar(65) NOT NULL,
  `fichierNom` varchar(45) NOT NULL,
  `dateCreer` datetime NOT NULL,
  `HasSnow` tinyint(3) unsigned NOT NULL,
  `heading` varchar(65) NOT NULL,
  `bouton` varchar(45) NOT NULL,
  `imageFond` int(11) NOT NULL,
  `IsOn` tinyint(4) NOT NULL,
  `fond` varchar(7) NOT NULL,
  `fondBoite` varchar(7) NOT NULL,
  `police` varchar(7) NOT NULL,
  `titreCadre` varchar(7) NOT NULL,
  `fondBoiteDeux` varchar(7) NOT NULL,
  `date` varchar(7) NOT NULL,
  `titreBoiteDeux` varchar(7) NOT NULL,
  `lienVisible` varchar(7) NOT NULL,
  `lienSurvol` varchar(7) NOT NULL,
  `lienPiedVisible` varchar(7) NOT NULL,
  `lienPiedSurvol` varchar(7) NOT NULL,
  `lienNavVisible` varchar(7) NOT NULL,
  `lienNavSurvol` varchar(7) NOT NULL,
  `navHautVisible` varchar(7) NOT NULL,
  `navBasVisible` varchar(7) NOT NULL,
  `navHautActif` varchar(7) NOT NULL,
  `navBasActif` varchar(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `theme`
--

INSERT INTO `theme` (`id`, `themeNom`, `fichierNom`, `dateCreer`, `HasSnow`, `heading`, `bouton`, `imageFond`, `IsOn`, `fond`, `fondBoite`, `police`, `titreCadre`, `fondBoiteDeux`, `date`, `titreBoiteDeux`, `lienVisible`, `lienSurvol`, `lienPiedVisible`, `lienPiedSurvol`, `lienNavVisible`, `lienNavSurvol`, `navHautVisible`, `navBasVisible`, `navHautActif`, `navBasActif`) VALUES
(1, 'original', 'default', '2011-02-04 17:27:32', 0, 'entetetitre.png', 'menuBut.png', 1, 1, '#d4be8d', '#a7a2a2', '#000', '#600', '#c2bcba', '#630', '#C30', '#C30', '#00F', '#600', '#C30', '#000', '#ea890b', '#c2bcba', '#716c6b', '#3f0b04', '#791c08');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
