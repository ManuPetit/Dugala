<?php
		/**
		 *	script profil.php
		 *
		 *	page principal Mon profil
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Mon profil";
		$_SESSION['menuid'] = 1;
		include('../inclusion/admintete.php');
		echo '<h2>Mon profil</h2><p>Dans cette section, vous pouvez :<ul>
		<li>Editer les d&eacute;tails de votre profil</li>
		<li>Changer votre mot de passe</li></ul></p>
		<p>Choisissez l\'action correspondante dans le menu de gauche.</p>';
		include('../inclusion/adminpied.php');
?>