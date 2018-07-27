<?php
		/**
		 *	script evene.php
		 *
		 *	page principal des événements
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Mon livre d'or";
		$_SESSION['menuid'] = 7;
		include('../inclusion/admintete.php');
		echo '<h2>Mon livre d\'or</h2><p>Dans cette section, vous pouvez :<ul>
		<li>Voir le d&eacute;tail des commentaires sur votre livre d\'or</li>
		<li>Supprimer un commentaire existant</li></ul></p>
		<p>Choisissez l\'action correspondante dans le menu de gauche.</p>';
		include('../inclusion/adminpied.php');
?>