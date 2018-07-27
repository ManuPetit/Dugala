-- phpMyAdmin SQL Dump
-- version 2.6.4-pl3
-- http://www.phpmyadmin.net
-- 
-- Serveur: db3048.1and1.fr
-- Généré le : Jeudi 24 Novembre 2011 à 09:55
-- Version du serveur: 5.0.91
-- Version de PHP: 5.3.3-7+squeeze3
-- 
-- Base de données: `db356269083`
-- 

USE dugala;

-- --------------------------------------------------------

-- 
-- Structure de la table `evenements`
-- 

DROP TABLE IF EXISTS `evenements`;
CREATE TABLE `evenements` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nom_fr` varchar(80) NOT NULL,
  `nom_gb` varchar(80) NOT NULL,
  `date_evenement` date NOT NULL,
  `description_fr` text NOT NULL,
  `description_gb` text NOT NULL,
  `visible` enum('Oui','Non') NOT NULL,
  `menuid` int(10) unsigned NOT NULL default '0',
  `date_creation` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

-- 
-- Contenu de la table `evenements`
-- 

INSERT INTO `evenements` (`id`, `nom_fr`, `nom_gb`, `date_evenement`, `description_fr`, `description_gb`, `visible`, `menuid`, `date_creation`) VALUES (15, 'Fête des Mères', 'French Mother''s Day', '2011-05-29', 'Pour une fête des mères exeptionelle, un repas raffinée dans un cadre idyllique, au coeur de la vielle ville de Nyons.', 'Pour une fête des mères exeptionelle, un repas raffinée dans un cadre idyllique, au coeur de la vielle ville de Nyons.', 'Oui', 0, '2011-05-02 10:02:51');

-- --------------------------------------------------------

-- 
-- Structure de la table `livres`
-- 

DROP TABLE IF EXISTS `livres`;
CREATE TABLE `livres` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `prenom` varchar(30) NOT NULL,
  `nom` varchar(40) NOT NULL,
  `email` varchar(88) NOT NULL,
  `commentaire` text NOT NULL,
  `ville` varchar(80) NOT NULL default '0a',
  `pays` varchar(80) NOT NULL default '0a',
  `telephone` varchar(15) NOT NULL default 'x',
  `export` enum('A','B','C') NOT NULL,
  `date_created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

-- 
-- Contenu de la table `livres`
-- 

INSERT INTO `livres` (`id`, `prenom`, `nom`, `email`, `commentaire`, `ville`, `pays`, `telephone`, `export`, `date_created`) VALUES (27, 'marie france', 'VALLA', 'valla_family@yahoo.fr', 'Nous avons bien mangé dans votre restaurant, l''accueil est très chaleureux\r\nNous avons été bien conseillés pour les vins\r\nLe carré d''agneau était cuisiné à point; avec un agneau de votre région quand ce sera le moment sera parfait Marie France', 'ST DONAT', 'FRANCE', 'x', 'C', '2011-02-14 08:18:59');
INSERT INTO `livres` (`id`, `prenom`, `nom`, `email`, `commentaire`, `ville`, `pays`, `telephone`, `export`, `date_created`) VALUES (28, 'sandrine', 'Di''Luna', 'gakatelo@orange.fr', 'si vous avez envie de réveiller vos papilles venez chez eux: l''accueil est super et le menu nous de plus en plus étonnant et goûteux. C''est TROP BON!!!!!\r\nj''ai fêté mon anniversaire et la St Valentin je sais de quoi je parle miam miammmmm bisous à vous deux Sandrdine', 'NYONS', 'France', 'x', 'C', '2011-02-24 16:41:19');
INSERT INTO `livres` (`id`, `prenom`, `nom`, `email`, `commentaire`, `ville`, `pays`, `telephone`, `export`, `date_created`) VALUES (29, 'Elyane et Jean-Claude', 'Naneix', 'elyane.naneix@orange.fr', 'Mercredi dernier, un petit vent frisquet taquinait les touristes de Nyons à la recherche d''un restaurant...Christophe nous a accueillis avé la chaleur du sud, et ce n''est pas un , mais deux puis trois couples qui ont pris place dans ce lieu charmant, convivial,aux couleurs douces, choisies avec  soin par Sandrine.D''un bout à l''autre du dîner tout était délicieux, original et inventif.On s''est tous laissé prendre au jeu de cette cuisine savoureuse et nous sommes partis à regret... pour mieux revenir le lendemain à midi !!!Attention ce jeune couple a de l''avenir, il ne faut pas passer son chemin!', 'LIMOGES', 'FRANCE', 'x', 'A', '2011-03-05 11:28:33');
INSERT INTO `livres` (`id`, `prenom`, `nom`, `email`, `commentaire`, `ville`, `pays`, `telephone`, `export`, `date_created`) VALUES (30, 'Alice', 'Bernigaud', 'alice.bernigaud@laposte.net', 'Visite de Nyons fin Janvier, Une jolie petite ville, un petit restaurant parfait.\r\nun joli decor, une belle carte et une tres bonne ambiance creee par Isabelle et Christophe.\r\nJe recommande ce restaurant pour tout le monde, repas rapide le midi, d''affaire, en famille ou amoureux.\r\nJ''y retournerais bien une fois par semaine si je n''etais pas si loin.', 'Newcastle', 'Angleterre', 'x', 'A', '2011-03-16 16:07:40');
INSERT INTO `livres` (`id`, `prenom`, `nom`, `email`, `commentaire`, `ville`, `pays`, `telephone`, `export`, `date_created`) VALUES (31, 'Claude', 'PAULIN', 'claudius28.05.1966@hotmail.fr', 'LORS DE NOTRE VISITE DE NYONS NOUS AVONS ETE AGREABLEMENT SURPRIS PAR L''ACCUEIL ET LE REPAS QUI A REVEILLE NOS PAPILLES ET PUPILLES PAR CE PETIT RESTAURANT. REMERCI CE JEUNE COUPLE POUR LEUR CONSEIL SUR LES BEAUX ENDROIT ET LES BONNES CHOSE DE LA REGION.', 'Mazingarbe', 'FRANCE', '0630142067', 'A', '2011-03-17 19:02:52');
INSERT INTO `livres` (`id`, `prenom`, `nom`, `email`, `commentaire`, `ville`, `pays`, `telephone`, `export`, `date_created`) VALUES (32, 'Sylvie', 'LEFEBVRE', 'sylvie62670@hotmail.fr', 'Nous avons passés un agréable séjour su NIONS.\r\nDurant celui-ci nous sommes allés manger au Restaurant D''un Goût à l''autre.\r\nNous avons été acceuillis par Isabelle l''hôtesse de celui-ci. Elle nous a agréablement conseillé sur notre repas.\r\nA l''arrivé de notre menu, nos papilles se sont émoussées.\r\nLe dessert (souvenir d''enfance) est un très bon choix, je vous le conseil.\r\nNous avons fait la connaissance de Christophe le cuisinier qui lui aussi est très sympathique.\r\nNous espérons y retourner en Juin.', 'TOURCOING', 'FRANCE', 'x', 'A', '2011-03-17 19:17:25');
INSERT INTO `livres` (`id`, `prenom`, `nom`, `email`, `commentaire`, `ville`, `pays`, `telephone`, `export`, `date_created`) VALUES (33, 'Patrick et Elisabeth', 'Rispaud', 'patrick.rispaud@orange.fr', 'Merci pour ce délicieux moment ! Un régal d''accueil, de palais et de papilles. On ressent dans l''assiette tout le plaisir et l''invention d''un passionné de la cuisine assisté d''une passionnée des vins et de l''accueil ! Des mariages surprenants pour des saveurs exquises ! Un petit apéro à base de truffe et d''huile d''olive.... a goûter absolument ! Des produits frais du terroir frais et qu''on redécouvre... Franchement l''un des meilleurs restaurants que nous connaissons. Un endroit magique et sympa où il faut absolument que l''on revienne et où les amis que l''on y invite saurons combien ils sont précieux.... Ce restaurant est véritablement une adresse qu''il faut conserver précieusement pour le plaisir et le meilleur !\r\nMerci encore pour ce beau moment ! Un vrai coup de coeur !', 'Gap', 'France', 'x', 'A', '2011-04-04 23:01:25');
INSERT INTO `livres` (`id`, `prenom`, `nom`, `email`, `commentaire`, `ville`, `pays`, `telephone`, `export`, `date_created`) VALUES (34, 'Laurence et Josette', 'Garey', 'l.garey@sunrise.ch', 'Un plaisir de vous rencontrer hier soir. Merci pour votre accueil et votre gastronomie. A la prochaine fois!', 'Nyons', '0a', 'x', 'A', '2011-06-25 15:59:15');
INSERT INTO `livres` (`id`, `prenom`, `nom`, `email`, `commentaire`, `ville`, `pays`, `telephone`, `export`, `date_created`) VALUES (35, 'Laurence et Damien', 'Festor', 'Laurence@festor.com', 'Merci pour ce fabuleux repas ! Des melanges etonnants et svoureux, un vin delicieux et des hotes tres accueillants !', 'Lyon', '0a', 'x', 'A', '2011-07-02 19:29:05');
INSERT INTO `livres` (`id`, `prenom`, `nom`, `email`, `commentaire`, `ville`, `pays`, `telephone`, `export`, `date_created`) VALUES (36, 'Greg', 'Verbrugghe', 'gregory.verbrugghe@laposte.net', 'Une très bonne table\r\nNous voulions visiter Nyons, pour les olives,la scourtinerie, la vieille ville... de notre journée nous retiendrons surtout un p''tit resto avec un accueil sobre et très convivial, un menu très équilibré, des goûts harmonieux, une explosion dans la bouche. Même nos enfants ont fini leur assiette... alors allez y en couple, en famille, entre amis mais allez y.\r\nPuis faites comme nous, conseillez cette super adresse à vos proches!\r\nMessage perso: bien le bonjour au chti et à Nico de Rubrouck...', 'Douai', 'France', 'x', 'A', '2011-07-28 10:34:32');

-- --------------------------------------------------------

-- 
-- Structure de la table `membres`
-- 

DROP TABLE IF EXISTS `membres`;
CREATE TABLE `membres` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `identifiant` varchar(30) NOT NULL,
  `email` varchar(80) NOT NULL,
  `mdpass` varbinary(32) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `nom` varchar(40) NOT NULL,
  `date_connexion` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `identifiant` (`identifiant`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- 
-- Contenu de la table `membres`
-- 

INSERT INTO `membres` (`id`, `identifiant`, `email`, `mdpass`, `prenom`, `nom`, `date_connexion`) VALUES (7, 'chatdenuit', 'epetit@iiidees.com', 0xc9a8c3787b3107067ebb0f6fbc1283092b854cbd1a3700de34ac862c927d14b3, 'Emmanuel', 'Petit', '2011-11-22 13:38:05');
INSERT INTO `membres` (`id`, `identifiant`, `email`, `mdpass`, `prenom`, `nom`, `date_connexion`) VALUES (9, 'restaurant', 'christophe_malet@orange.fr', 0x7dc06dad970ff1062931beefa6b16ec12974c5821435be6dfbb28648d67d772c, 'Christophe', 'Malet', '2011-05-02 09:44:38');

-- --------------------------------------------------------

-- 
-- Structure de la table `menujour`
-- 

DROP TABLE IF EXISTS `menujour`;
CREATE TABLE `menujour` (
  `entre1` varchar(120) NOT NULL,
  `entre2` varchar(120) NOT NULL,
  `plat1` varchar(120) NOT NULL,
  `plat2` varchar(120) NOT NULL,
  `dessert1` varchar(120) NOT NULL,
  `dessert2` varchar(120) NOT NULL,
  `prix2` float NOT NULL,
  `prix3` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Contenu de la table `menujour`
-- 

INSERT INTO `menujour` (`entre1`, `entre2`, `plat1`, `plat2`, `dessert1`, `dessert2`, `prix2`, `prix3`) VALUES ('Tartare de Saumon Fumé a ma Facon', 'Tagliatelle de legumes au chevre, Jeunes pousse a l''Huile de Noisette.', 'Suprême de Volaille au Jambon Cru, Pommes Grenailles Rôties au Thym.', 'Filet de Poisson du Jour, Risotto Crémeux a l''Encre de Seiche.', 'Fondant  au Chocolat, Glace au Miel de lavande', 'Carpaccio d''Ananas Frais, Sorbet selon mon Humeur', 17.5, 19.9);

-- --------------------------------------------------------

-- 
-- Structure de la table `menus`
-- 

DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nom_fr` varchar(80) NOT NULL,
  `nom_gb` varchar(80) NOT NULL,
  `file_name` varchar(60) NOT NULL,
  `date_telecharge` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `visible` enum('Oui','Non') NOT NULL,
  `groupe` enum('Me','Ms','Ca','Cb') character set ucs2 NOT NULL,
  `taille` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

-- 
-- Contenu de la table `menus`
-- 

INSERT INTO `menus` (`id`, `nom_fr`, `nom_gb`, `file_name`, `date_telecharge`, `visible`, `groupe`, `taille`) VALUES (46, 'Entrées Printemps 2011', 'Starters Spring 2011', 'EntreesPrintemps2011.pdf', '2011-03-04 17:18:55', 'Oui', 'Me', 99);
INSERT INTO `menus` (`id`, `nom_fr`, `nom_gb`, `file_name`, `date_telecharge`, `visible`, `groupe`, `taille`) VALUES (47, 'Plats Printemps 2011', 'Main Courses Spring 2011', 'PlatsPrintemps2011.pdf', '2011-03-04 17:20:01', 'Oui', 'Me', 99);
INSERT INTO `menus` (`id`, `nom_fr`, `nom_gb`, `file_name`, `date_telecharge`, `visible`, `groupe`, `taille`) VALUES (48, 'Desserts Printemps 2011', 'Deserts Spring 2011', 'DessertsPrintemps2011.pdf', '2011-03-04 17:21:20', 'Oui', 'Me', 98);

-- --------------------------------------------------------

-- 
-- Structure de la table `menusite`
-- 

DROP TABLE IF EXISTS `menusite`;
CREATE TABLE `menusite` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nom_fr` varchar(20) NOT NULL,
  `nom_gb` varchar(20) NOT NULL,
  `title_fr` varchar(100) NOT NULL,
  `title_gb` varchar(100) NOT NULL,
  `pageid` int(10) unsigned NOT NULL,
  `ordre` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- 
-- Contenu de la table `menusite`
-- 

INSERT INTO `menusite` (`id`, `nom_fr`, `nom_gb`, `title_fr`, `title_gb`, `pageid`, `ordre`) VALUES (1, 'Accueil', 'Home', 'aller sur notre page d''accueil', 'go to our homepage', 1, 1);
INSERT INTO `menusite` (`id`, `nom_fr`, `nom_gb`, `title_fr`, `title_gb`, `pageid`, `ordre`) VALUES (2, 'Menus', 'Menus', 'voir les menus que nous vous proposons', 'see the menus we offer', 2, 2);
INSERT INTO `menusite` (`id`, `nom_fr`, `nom_gb`, `title_fr`, `title_gb`, `pageid`, `ordre`) VALUES (3, 'Partenaires', 'Partners', 'découvrir nos partenaires', 'discover our partners', 3, 3);
INSERT INTO `menusite` (`id`, `nom_fr`, `nom_gb`, `title_fr`, `title_gb`, `pageid`, `ordre`) VALUES (4, 'Accès', 'Find us', 'localiser notre restaurant', 'localise our restaurant', 4, 4);
INSERT INTO `menusite` (`id`, `nom_fr`, `nom_gb`, `title_fr`, `title_gb`, `pageid`, `ordre`) VALUES (5, 'Contact', 'Contact us', 'nous envoyer un message', 'send us a message', 5, 5);
INSERT INTO `menusite` (`id`, `nom_fr`, `nom_gb`, `title_fr`, `title_gb`, `pageid`, `ordre`) VALUES (6, 'Livre d''Or', 'Guestbook', 'signer notre livre d''or', 'sign our guestbook', 6, 6);

-- --------------------------------------------------------

-- 
-- Structure de la table `pagesite`
-- 

DROP TABLE IF EXISTS `pagesite`;
CREATE TABLE `pagesite` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `titre_fr` varchar(100) NOT NULL,
  `titre_gb` varchar(100) NOT NULL,
  `metakey_fr` varchar(100) NOT NULL,
  `metakey_gb` varchar(100) NOT NULL,
  `metadesc_fr` varchar(150) NOT NULL,
  `metadesc_gb` varchar(150) NOT NULL,
  `page_fr` varchar(15) NOT NULL,
  `page_gb` varchar(15) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- 
-- Contenu de la table `pagesite`
-- 

INSERT INTO `pagesite` (`id`, `titre_fr`, `titre_gb`, `metakey_fr`, `metakey_gb`, `metadesc_fr`, `metadesc_gb`, `page_fr`, `page_gb`) VALUES (1, 'D''un Gout à l''Autre vous souhaite la bienvenue', 'Welcome to D''un Gout à l''Autre', 'gout, autre, d''un gout à l''autre, restaurant, nyons, drome, provence', 'gout, autre, d''un gout à l''autre, restaurant, nyons, drome, provence', 'Bienvenue sur le site du restaurant D''un Gout à l''Autre à Nyons dans la Drôme Provençale.', 'Welcome to the restaurant D''un Gout à l''Autre, located in Provencal Drôme (France).', 'index', 'home');
INSERT INTO `pagesite` (`id`, `titre_fr`, `titre_gb`, `metakey_fr`, `metakey_gb`, `metadesc_fr`, `metadesc_gb`, `page_fr`, `page_gb`) VALUES (2, 'Découvrez nos menus', 'Find out about our menus', 'gout, autre, d''un gout à l''autre, menu, carte, restaurant, nyons', 'gout, autre, d''un gout à l''autre, menu, carte, restaurant, nyons', 'Le restaurant D''un Gout à l''Autre vous propose plusieurs menus. A découvrir...', 'The restaurant D''un Gout à l''Autre offers different menus. Find more about them', 'menus', 'carte');
INSERT INTO `pagesite` (`id`, `titre_fr`, `titre_gb`, `metakey_fr`, `metakey_gb`, `metadesc_fr`, `metadesc_gb`, `page_fr`, `page_gb`) VALUES (3, 'Découvrez nos partenaires', 'Find more about our partners', 'gout, autre, d''un gout à l''autre, partenaires, liens, restaurant, nyons,', 'gout, autre, d''un gout à l''autre, partners, link, restaurant, nyons', 'D''un Gout à l''autre est associé avec différents partenaires locaux. Découvrez les...', 'D''un Gout à l''Autre is associated with many different local partners. Find more about them...', 'lien', 'link');
INSERT INTO `pagesite` (`id`, `titre_fr`, `titre_gb`, `metakey_fr`, `metakey_gb`, `metadesc_fr`, `metadesc_gb`, `page_fr`, `page_gb`) VALUES (4, 'Comment trouver D''un Gout à l''Autre ?', 'How to find D''un Gout à l''Autre?', 'gout, autre, d''un gout à l''autre, accès, direction, restaurant, nyons', 'gout, autre d''un gout à l''autre, access, direction, restaurant, nyons', 'L''accès à D''un Gout à l''Autre est très facile.', 'Finding D''un Gout à l''Autre is very easy.', 'acces', 'findus');
INSERT INTO `pagesite` (`id`, `titre_fr`, `titre_gb`, `metakey_fr`, `metakey_gb`, `metadesc_fr`, `metadesc_gb`, `page_fr`, `page_gb`) VALUES (5, 'Contactez D''un Gout à l''Autre', 'Contact D''un Gout à l''Autre', 'gout, autre, d''un gout à l''autre, contact, email, téléphone, adresse, écrire, restaurant, nyons, dro', 'gout, autre, d''un gout à l''autre, contact, address, email, telephone, restaurant, nyons, drome, prov', 'Contactez le restaurant D''un Gout à l''Autre, à Nyons dans la Drome Provençale par téléphone, courrier ou laissez-nous un message.', 'Contact D''un Gout à l''autre in Nyons Provencal Drome by mail, phone or leave us a message.', 'contact', 'contactus');
INSERT INTO `pagesite` (`id`, `titre_fr`, `titre_gb`, `metakey_fr`, `metakey_gb`, `metadesc_fr`, `metadesc_gb`, `page_fr`, `page_gb`) VALUES (6, 'Signez le Livre d''Or du restaurant D''un Gout à l''Autre', 'Leave a message in D''un Gout à l''Autre''s Guestbook', 'gout, autre, d''un gout à l''autre, livre, or, message, restaurant, nyons', 'gout, autre, d''un gout à l''autre, guestbook, message, restaurant, nyons', 'Laissez un message dans le livre d''or du restaurant D''un Gout à l''Autre.', 'Leave a message in D''un Gout à l''Autre''s guestbook.', 'livredor', 'guestbook');

-- --------------------------------------------------------

-- 
-- Structure de la table `partenaires`
-- 

DROP TABLE IF EXISTS `partenaires`;
CREATE TABLE `partenaires` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nom_fr` varchar(100) NOT NULL,
  `nom_gb` varchar(100) NOT NULL,
  `description_fr` text NOT NULL,
  `description_gb` text NOT NULL,
  `lien` varchar(150) NOT NULL,
  `photo` varchar(45) NOT NULL default 'A',
  `visible` enum('Oui','Non') NOT NULL,
  `date_creation` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- 
-- Contenu de la table `partenaires`
-- 

INSERT INTO `partenaires` (`id`, `nom_fr`, `nom_gb`, `description_fr`, `description_gb`, `lien`, `photo`, `visible`, `date_creation`) VALUES (10, 'Promenade Gourmande', 'Promenade Gourmande', 'Guide des bonnes adresses dans la Drôme.... Restaurants, Caves, Olives etc...', 'This local Web site is talking about good food, wines and local produce......', 'www.promenade-gourmande.fr', '645e5f5884c23c58f5660f6a9e5ae42b1659ac57.jpg', 'Oui', '2011-03-04 17:30:02');
INSERT INTO `partenaires` (`id`, `nom_fr`, `nom_gb`, `description_fr`, `description_gb`, `lien`, `photo`, `visible`, `date_creation`) VALUES (11, 'La Baronnie', 'La Baronnie', 'Fanny et Fabien Vermandelle vous accueillent à La Baronnie au sein de leur chambre d''hôte à la Baronnie. Leur domaine est situé entre la Drôme et le Vaucluse et se compose de 5 chambres d''hôte qui vous séduiront par leur charme et leur cadre intime. Face au Mont Ventoux à proximité d''un petit village séculaire, la notion de chambre avec vue prend ici tout son sens.', 'Fanny et Fabien Vermandelle vous accueillent à La Baronnie au sein de leur chambre d''hôte à la Baronnie. Leur domaine est situé entre la Drôme et le Vaucluse et se compose de 5 chambres d''hôte qui vous séduiront par leur charme et leur cadre intime. Face au Mont Ventoux à proximité d''un petit village séculaire, la notion de chambre avec vue prend ici tout son sens.', 'www.labaronnie.net', 'A', 'Oui', '2011-03-21 11:11:27');

-- --------------------------------------------------------

-- 
-- Structure de la table `photos`
-- 

DROP TABLE IF EXISTS `photos`;
CREATE TABLE `photos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nom_fr` varchar(50) NOT NULL,
  `nom_gb` varchar(50) NOT NULL,
  `fichier` varchar(45) NOT NULL,
  `date_telecharge` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `visible` enum('Oui','Non') NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

-- 
-- Contenu de la table `photos`
-- 

INSERT INTO `photos` (`id`, `nom_fr`, `nom_gb`, `fichier`, `date_telecharge`, `visible`) VALUES (17, 'Ballotine de Volaille aux mini legumes', 'Ballotine de Volaille aux mini legumes', 'e68b70ed9d8a98b3d5f0f4145a9937f66ba69ef3.jpg', '2011-03-22 17:18:02', 'Oui');
INSERT INTO `photos` (`id`, `nom_fr`, `nom_gb`, `fichier`, `date_telecharge`, `visible`) VALUES (18, 'Mille feuille d''aubergine, mousse de picodon AOC', 'Mille feuille d''aubergine, mousse de picodon AOC', 'fe94aee82d90f827400ec2e94616a613ba69e668.jpg', '2011-03-22 17:19:35', 'Oui');
INSERT INTO `photos` (`id`, `nom_fr`, `nom_gb`, `fichier`, `date_telecharge`, `visible`) VALUES (19, 'le dressage par le chef', 'le dressage par le chef', '2e8083558b56f7f81482200e4a0931cee5182187.jpg', '2011-03-22 17:20:04', 'Oui');
