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
		$page_title = "Mes &eacute;v&eacute;nements";
		$_SESSION['menuid'] = 5;
		include('../inclusion/admintete.php');
		echo '<h2>Mes &eacute;v&eacute;nements</h2><p>Dans cette section, vous pouvez :<ul>
		<li>Voir le d&eacute;tail des &eacute;v&eacute;nements que vous proposez actuellement</li>
		<li>Ajouter un nouvel &eacute;v&eacute;nement</li>
		<li>Modifier un &eacute;v&eacute;nement existant</li>
		<li>Supprimer un &eacute;v&eacute;nement existant</li></ul></p>
		<p>Choisissez l\'action correspondante dans le menu de gauche.</p>';
		include('../inclusion/adminpied.php');
?>