<?php
		/**
		 *	script theme.php
		 *
		 *	page principal des theme
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Mes th&egrave;mes";
		$_SESSION['menuid'] = 8;
		include('../inclusion/admintete.php');
		echo '<h2>Mes th&egrave;mes</h2><p>Dans cette section, vous pouvez :<ul>
		<li>Voir le d&eacute;tail des th&egrave;mes que vous avez cr&eacute;&eacute;s, en supprimer, en activer, les modifier</li>
		<li>Ajouter un nouveau th&egrave;me</li>
		<li>Remettre en place le thème original du site (celà ne changera pas l\'image de fond)</li>
		<li>Voir la liste des fonds de tous les fond d\'écran, en supprimer, en activer</li>
		<li>Ajouter un nouveau fond d\'écran</li>
		<li>Remettre en place le fond d\'écran original du site (celà ne changera pas le thème du site)</li></ul></p>
		<p>Choisissez l\'action correspondante dans le menu de gauche.</p>';
		include('../inclusion/adminpied.php');
?>