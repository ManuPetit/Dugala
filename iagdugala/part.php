<?php
		/**
		 *	script part.php
		 *
		 *	page principal des partenaires
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Mes partenaires";
		$_SESSION['menuid'] = 6;
		include('../inclusion/admintete.php');
		echo '<h2>Mes partenaires</h2><p>Dans cette section, vous pouvez :<ul>
		<li>Voir les d&eacute;tails de vos partenaires propos&eacute;s en tant que liens sur votre site</li>
		<li>Ajouter un nouveau partenaires</li>
		<li>Modifier un partenaires</li>
		<li>Supprimer un partenaires</li></ul></p>
		<p>Choisissez l\'action correspondante dans le menu de gauche.</p>';
		include('../inclusion/adminpied.php');
?>