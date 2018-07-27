<?php
		/**
		 *	script menu.php
		 *
		 *	page principal des menus et cartes
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Mes menus et cartes";
		$_SESSION['menuid'] = 4;
		include('../inclusion/admintete.php');
		echo '<h2>Mes menus et cartes</h2><p>Dans cette section, vous pouvez :<ul>
		<li>Voir les d&eacute;tails des menus et cartes que vous proposez actuellement</li>
		<li>Ajouter un nouveau menu ou une nouvelle carte</li>
		<li>Modifier une carte ou un menu existant</li>
		<li>Supprimer une carte ou un menu existant</li></ul></p>
		<p>Choisissez l\'action correspondante dans le menu de gauche.</p>';
		include('../inclusion/adminpied.php');
?>