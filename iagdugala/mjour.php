<?php
		/**
		 *	script mjour.php
		 *
		 *	page principal du menu du jour
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Mon menu du jour";
		$_SESSION['menuid'] = 3;
		include('../inclusion/admintete.php');
		echo '<h2>Mon menu du jour</h2><p>Dans cette section, vous pouvez :<ul>
		<li>Voir les d&eacute;tails actuels de votre menu du jour</li>
		<li>Modifier les plats de votre menu du jour</li>
		<li>Modifier les prix de votre menu du jour</li></ul></p>
		<p>Choisissez l\'action correspondante dans le menu de gauche.</p>';
		include('../inclusion/adminpied.php');
?>