<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
	$lapage = basename($_SERVER['PHP_SELF']);
	if ($lapage == 'theme_ajou.php'){
		echo '<link rel="stylesheet" media="screen" type="text/css" href="../css/colorpicker.css" />
		<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="../js/colorpicker.js"></script>
		<script type="text/javascript" src="../js/admin.js"></script>
		<script type="text/javascript" src="../js/jquery.validate.js"></script>';
	}
	if ($lapage == 'theme_modifmain.php'){
		echo '<link rel="stylesheet" media="screen" type="text/css" href="../css/colorpicker.css" />
		<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="../js/colorpicker.js"></script>
		<script type="text/javascript" src="../js/tempjs.js"></script>';	
	}
?>
<title>
<?php
	if (isset($page_title)) {
		echo $page_title;
	} else {
		echo 'Interface administrative de mise &agrave; jour';
	}
?>
</title>
<link rel="stylesheet" type="text/css" href="../css/admin.css" />
</head>

<body>
<div id="global">
  <div id="entete">
    <h1> Interface administrative de mise &agrave; jour </h1>
    <p class="sous-titre"> Restaurant<strong> D'un Gout &agrave; l'Autre</strong> </p>
  </div>
  <!-- #entete -->
  <div id="navigation">
    <ul>
    <?php
		//Creation du menu selon la page ou l'on se trouve
		if ($_SESSION['menuid'] == 0) {
			echo '<li>Menu principal</li><br />
			<li><a href="profil.php" title="Cliquez ici pour modifier les d&eacute;tails de votre profil et de votre mot de passe.">Mon Profil</a></li>
      		<li><a href="photo.php" title="Cliquez ici pour ajouter, modifier ou supprimer des photos de vos r&eacute;alisations.">Mes Photos</a></li>
			<li><a href="mjour.php" title="Cliquez ici pour modifier les plats de votre menu du jour, et son prix.">Mon menu du Jour</a></li>
			<li><a href="menu.php" title="Cliquez ici pour t&eacute;l&eacute;charger vos menus(fichiers PDF), les mettre &agrave; jour ou les supprimer.">Mes menus et cartes</a></li>
			<li><a href="evene.php" title="Cliquez ici pour cr&eacute;er, modifier ou supprimer vos &eacute;v&eacute;nements.">Mes &eacute;v&eacute;nements</a></li>
			<li><a href="part.php" title="Cliquez ici pour cr&eacute;er, modifier ou supprimer vos liens avec vos partenaire.">Mes partenaires</a></li>
			<li><a href="livre.php" title="Cliquez ici pour consulter votre livre d\'or.">Mon livre d\'or</a></li>
			<li><a href="theme.php" title="Cliquez ici pour modifier le look de votre site internet">Mon thème</a></li><br />
			<li><a href="logout.php" title="Cliquez ici pour vous d&eacute;connecter de l\'interface administrative de mise &agrave; jour.">D&eacute;connexion</a></li>';
		} else if ($_SESSION['menuid'] == 1) {
			echo '<li>Mon profil</li><br />';
			$lapage = basename($_SERVER['PHP_SELF']);
			echo '<li><a href="profil_mod.php" title="Cliquez ici pour modifier les d&eacute;tails de votre profil."';
			if ($lapage == 'profil_mod.php') {
				echo ' class="selection"';
			}
			echo '>Editer Profil</a></li>
			<li><a href="profil_mdp.php" title="Cliquez ici pour modifier votre mot de passe."';
			if ($lapage == 'profil_mdp.php') {
				echo ' class="selection"';
			}
			echo '>Changer mot de passe</a></li><br />
			<li><a href="principal.php" title="Cliquez ici pour retourner au menu principal.">Menu principal</a></li>
			<li><a href="logout.php" title="Cliquez ici pour vous d&eacute;connecter de l\'interface administrative de mise &agrave; jour.">D&eacute;connexion</a></li>';
		} else if ($_SESSION['menuid'] == 2) {
			echo '<li>Mes photos</li><br />';
			$lapage = basename($_SERVER['PHP_SELF']);
			$cetpage = array(
				'0' => array(
					'p1' => 'photo_list.php',
					'p2' => '',
					'ti' => 'voir toutes les photos de votre site',
					'no' => 'Liste des photos'
				),
				'1' => array(
					'p1' => 'photo_ajou.php',
					'p2' => '',
					'ti' => 'ajouter une nouvelle photo',
					'no' => 'Ajouter photo'
				),
				'2' => array(
					'p1' => 'photo_mod.php',
					'p2' => 'photo_mod_main.php',
					'ti' => 'modifier une photo',
					'no' => 'Modifier photo'
				),
				'3' => array(
					'p1' => 'photo_del.php',
					'p2' => 'photo_del_main.php',
					'ti' => 'suprimer une photo',
					'no' => 'Supprimer photo'
				),
				'4' => array(
					'p1' => 'photoacc_list.php',
					'p2' => '',
					'ti' => 'voir la liste des photos de la page d\'accueil',
					'no' => 'Liste photo accueil'
				),
				'5' => array(
					'p1' => 'photoacc_ajou.php',
					'p2' => '',
					'ti' => 'ajouter une photo pour la page d\'accueil',
					'no' => 'Ajouter photo accueil'
				)
			);
			for ($i=0; $i<6; $i++) {
				echo '<li><a href="' . $cetpage[$i]['p1'] . '" title="Cliquez ici pour ' . $cetpage[$i]['ti'] .'."';
				if (($cetpage[$i]['p1'] == $lapage) || ($cetpage[$i]['p2'] == $lapage)) {
					echo ' class="selection"';
				}
				echo '">' . $cetpage[$i]['no'] . '</a></li>';
			}
			echo '<br /><li><a href="principal.php" title="Cliquez ici pour retourner au menu principal.">Menu principal</a></li>
			<li><a href="logout.php" title="Cliquez ici pour vous d&eacute;connecter de l\'interface administrative de mise &agrave; jour.">D&eacute;connexion</a></li>';
		} else if ($_SESSION['menuid'] == 3) {
			echo '<li>Mon menu du jour</li><br />';
			$lapage = basename($_SERVER['PHP_SELF']);
			$cetpage = array(
				'0' => array(
					'p1' => 'mjou_list.php',
					'p2' => '',
					'ti' => 'voir tous les plats et les prix de votre menu du jour actuel',
					'no' => 'D&eacute;tails du menu'
				),
				'1' => array(
					'p1' => 'mjou_changeplat.php',
					'p2' => '',
					'ti' => 'changer les plats de votre menu du jour',
					'no' => 'Changer les plats'
				),
				'2' => array(
					'p1' => 'mjou_changeprix.php',
					'p2' => '',
					'ti' => 'changer les prix de votre menu du jour',
					'no' => 'Changer les prix'
				)
			);
			for ($i=0; $i<3; $i++) {
				echo '<li><a href="' . $cetpage[$i]['p1'] . '" title="Cliquez ici pour ' . $cetpage[$i]['ti'] .'."';
				if (($cetpage[$i]['p1'] == $lapage) || ($cetpage[$i]['p2'] == $lapage)) {
					echo ' class="selection"';
				}
				echo '">' . $cetpage[$i]['no'] . '</a></li>';
			}
			echo '<br /><li><a href="principal.php" title="Cliquez ici pour retourner au menu principal.">Menu principal</a></li>
			<li><a href="logout.php" title="Cliquez ici pour vous d&eacute;connecter de l\'interface administrative de mise &agrave; jour.">D&eacute;connexion</a></li>';
		} else if ($_SESSION['menuid'] == 4) {
			echo '<li>Mes menus et cartes</li><br />';
			$lapage = basename($_SERVER['PHP_SELF']);
			$cetpage = array(
				'0' => array(
					'p1' => 'menu_list.php',
					'p2' => '',
					'ti' => 'voir tous mes menus et cartes',
					'no' => 'Liste des menus'
				),
				'1' => array(
					'p1' => 'menu_ajou.php',
					'p2' => '',
					'ti' => 'ajouter un nouveau menu ou une nouvelle carte',
					'no' => 'Ajouter un menu'
				),
				'2' => array(
					'p1' => 'menu_mod.php',
					'p2' => 'menu_mod_main.php',
					'ti' => 'modifier un menu ou une carte',
					'no' => 'Modifier un menu'
				),
				'3' => array(
					'p1' => 'menu_del.php',
					'p2' => 'menu_del_main.php',
					'ti' => 'supprimer un menu ou une carte',
					'no' => 'Supprimer un menu'
				)
			);
			for ($i=0; $i<4; $i++) {
				echo '<li><a href="' . $cetpage[$i]['p1'] . '" title="Cliquez ici pour ' . $cetpage[$i]['ti'] .'."';
				if (($cetpage[$i]['p1'] == $lapage) || ($cetpage[$i]['p2'] == $lapage)) {
					echo ' class="selection"';
				}
				echo '">' . $cetpage[$i]['no'] . '</a></li>';
			}
			echo '<br /><li><a href="principal.php" title="Cliquez ici pour retourner au menu principal.">Menu principal</a></li>
			<li><a href="logout.php" title="Cliquez ici pour vous d&eacute;connecter de l\'interface administrative de mise &agrave; jour.">D&eacute;connexion</a></li>';
		} else if ($_SESSION['menuid'] == 5) {
			echo '<li>Mes &eacute;v&eacute;nements</li><br />';
			$lapage = basename($_SERVER['PHP_SELF']);
			$cetpage = array(
				'0' => array(
					'p1' => 'evene_list.php',
					'p2' => '',
					'ti' => 'voir tous vos &eacute;v&eacute;nements',
					'no' => 'Liste &eacute;v&eacute;nements'
				),
				'1' => array(
					'p1' => 'evene_ajou.php',
					'p2' => 'evene_ajou_main.php',
					'ti' => 'ajouter un nouvel &eacute;v&eacute;nement',
					'no' => 'Ajouter &eacute;v&eacute;nement'
				),
				'2' => array(
					'p1' => 'evene_mod.php',
					'p2' => 'evene_mod_main.php',
					'ti' => 'modifier un &eacute;v&eacute;nement',
					'no' => 'Modifier &eacute;v&eacute;nement'
				),
				'3' => array(
					'p1' => 'evene_del.php',
					'p2' => 'evene_del_main.php',
					'ti' => 'supprimer un &eacute;v&eacute;nement',
					'no' => 'Supprimer &eacute;v&eacute;nement'
				)
			);
			for ($i=0; $i<4; $i++) {
				echo '<li><a href="' . $cetpage[$i]['p1'] . '" title="Cliquez ici pour ' . $cetpage[$i]['ti'] .'."';
				if (($cetpage[$i]['p1'] == $lapage) || ($cetpage[$i]['p2'] == $lapage)) {
					echo ' class="selection"';
				}
				echo '">' . $cetpage[$i]['no'] . '</a></li>';
			}
			echo '<br /><li><a href="principal.php" title="Cliquez ici pour retourner au menu principal.">Menu principal</a></li>
			<li><a href="logout.php" title="Cliquez ici pour vous d&eacute;connecter de l\'interface administrative de mise &agrave; jour.">D&eacute;connexion</a></li>';
		} else if ($_SESSION['menuid'] == 6) {
			echo '<li>Mes partenaires</li><br />';
			$lapage = basename($_SERVER['PHP_SELF']);
			$cetpage = array(
				'0' => array(
					'p1' => 'part_list.php',
					'p2' => '',
					'ti' => 'voir tous vos partenaires',
					'no' => 'Liste partenaires'
				),
				'1' => array(
					'p1' => 'part_ajou.php',
					'p2' => '',
					'ti' => 'ajouter un nouveau partenaire',
					'no' => 'Ajouter partenaire'
				),
				'2' => array(
					'p1' => 'part_mod.php',
					'p2' => 'part_mod_main.php',
					'ti' => 'modifier un partenaire',
					'no' => 'Modifier partenaire'
				),
				'3' => array(
					'p1' => 'part_del.php',
					'p2' => 'part_del_main.php',
					'ti' => 'supprimer un partenaire',
					'no' => 'Supprimer partenaire'
				)
			);
			for ($i=0; $i<4; $i++) {
				echo '<li><a href="' . $cetpage[$i]['p1'] . '" title="Cliquez ici pour ' . $cetpage[$i]['ti'] .'."';
				if (($cetpage[$i]['p1'] == $lapage) || ($cetpage[$i]['p2'] == $lapage)) {
					echo ' class="selection"';
				}
				echo '">' . $cetpage[$i]['no'] . '</a></li>';
			}
			echo '<br /><a href="principal.php" title="Cliquez ici pour retourner au menu principal.">Menu principal</a></li>
			<li><a href="logout.php" title="Cliquez ici pour vous d&eacute;connecter de l\'interface administrative de mise &agrave; jour.">D&eacute;connexion</a></li>';
		} else if ($_SESSION['menuid'] == 8) {
			echo '<li>Mon thème</li><br />';
			$lapage = basename($_SERVER['PHP_SELF']);
			$cetpage = array(
				'0' => array(
					'p1' => 'theme_list.php',
					'p2' => '',
					'ti' => 'voir tous mes thèmes',
					'no' => 'Liste thèmes'
				),
				'1' => array(
					'p1' => 'theme_ajou.php',
					'p2' => '',
					'ti' => 'ajouter un nouveau thème',
					'no' => 'Ajouter thème'
				),
				'2' => array(
					'p1' => 'theme_modif.php',
					'p2' => 'theme_modifmain.php',
					'ti' => 'modifier un nouveau thème',
					'no' => 'Modifier thème'
				),
				'3' => array(
					'p1' => 'theme_def.php',
					'p2' => '',
					'ti' => 'activer le thème original du site',
					'no' => 'Activer thème original'
				),
				'4' => array(
					'p1' => 'imgf_list.php',
					'p2' => '',
					'ti' => 'voir toutes les images de fond d\'écran',
					'no' => 'Liste fonds écran'
				),
				'5' => array(
					'p1' => 'imgf_ajou.php',
					'p2' => '',
					'ti' => 'ajouter une image de fond d\'écran',
					'no' => 'Ajout fond écran'
				),
				'6' => array(
					'p1' => 'imgf_def.php',
					'p2' => '',
					'ti' => 'activer l\'image de fond d\'écran original du site',
					'no' => 'Activer fond original'
				)
			);
			for ($i=0; $i<7; $i++) {
				echo '<li><a href="' . $cetpage[$i]['p1'] . '" title="Cliquez ici pour ' . $cetpage[$i]['ti'] .'."';
				if (($cetpage[$i]['p1'] == $lapage) || ($cetpage[$i]['p2'] == $lapage)) {
					echo ' class="selection"';
				}
				echo '">' . $cetpage[$i]['no'] . '</a></li>';
			}
			echo '<br /><a href="principal.php" title="Cliquez ici pour retourner au menu principal.">Menu principal</a></li>
			<li><a href="logout.php" title="Cliquez ici pour vous d&eacute;connecter de l\'interface administrative de mise &agrave; jour.">D&eacute;connexion</a></li>';
		}else if ($_SESSION['menuid'] == 7) {
			echo '<li>Mon livre d\'or</li><br />';
			$lapage = basename($_SERVER['PHP_SELF']);
			$cetpage = array(
				'0' => array(
					'p1' => 'livre_list.php',
					'p2' => '',
					'ti' => 'voir tous les commentaires sur votre livre d\'or',
					'no' => 'Liste commentaires'
				),
				'1' => array(
					'p1' => 'livre_del.php',
					'p2' => 'livre_del_main.php',
					'ti' => 'supprimer un commentaire',
					'no' => 'Supprimer commentaire'
				),
				'2' => array(
					'p1' => 'livre_fil.php',
					'p2' => '',
					'ti' => 'g&eacute;n&eacute;rer un fichier d\'adresses pour importer dans Gmail',
					'no' => 'G&eacute;n&eacute;rer fichier'
				)
			);
			for ($i=0; $i<3; $i++) {
				echo '<li><a href="' . $cetpage[$i]['p1'] . '" title="Cliquez ici pour ' . $cetpage[$i]['ti'] .'."';
				if (($cetpage[$i]['p1'] == $lapage) || ($cetpage[$i]['p2'] == $lapage)) {
					echo ' class="selection"';
				}
				echo '">' . $cetpage[$i]['no'] . '</a></li>';
			}
			echo '<br /><a href="principal.php" title="Cliquez ici pour retourner au menu principal.">Menu principal</a></li>
			<li><a href="logout.php" title="Cliquez ici pour vous d&eacute;connecter de l\'interface administrative de mise &agrave; jour.">D&eacute;connexion</a></li>';
		}
		?>	  
    </ul>
  </div>
  <!-- #navigation -->
  <div id="contenu">