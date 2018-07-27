<?php
		/**
		 *	script photo.php
		 *
		 *	page principal des photos
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Mes photos";
		$_SESSION['menuid'] = 2;
		include('../inclusion/admintete.php');
		echo '<h2>Mes photos</h2><p>Dans cette section, vous pouvez :<ul>
		<li>Voir la liste de vos photos de plats, pr&eacute;sent&eacute;es sur la page menu</li>
		<li>Ajouter une nouvelle photo</li>
		<li>Modifier une photo</li>
		<li>Supprimer une photo</li>
		<li>Voir la liste des photos de la page d\'accueil, les supprimer, les activer</li>
		<li>Ajouter une photo pour la page d\'accueil</li></ul></p>
		<p>Choisissez l\'action correspondante dans le menu de gauche.</p>';
		include('../inclusion/adminpied.php');
?>