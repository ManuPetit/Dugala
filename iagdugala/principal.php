<?php
		/**
		 *	script principal.php
		 *
		 *	fichier principal de l'interface de gestion adminsitrative
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Menu principal";
		$_SESSION['menuid'] = 0;
		include('../inclusion/admintete.php');
		//afficher les message selon ladate de dernière connexion
		echo '<h2>Bienvenue, ' . $_SESSION['memnom'] . '.</h2>';
		if (isset($_SESSION['derconnex'])) {
			if ($_SESSION['derconnex'] == 'first') {//premiere connexion
				echo "<p>C'est la premi&egrave;re fois que vous vous connectez &agrave; l'interface administrative de mise &agrave; jour.</p>
				<p>Nous vous conseillons de changer votre mot de passe en cliquant <a href=\"profil_mdp.php\" title=\"Cliquez ici pour changer votre mot de passe.\">ce lien</a> pour le remplacer par un mot de passe qui vous conviendra mieux.</p>";
			} else {
				echo "Vous vous &ecirc;tes connect&eacute; pour la derni&egrave;re fois, le " . $_SESSION['derconnex'] . ".";
			}
			//vider $_SESSION['derconnex']
			$_SESSION['derconnex']=NULL;
		}
		echo "<p>Veuillez choisir une action dans le menu de gauche...<br /><br /><br /></p>";
		
		include('../inclusion/adminpied.php');
?>