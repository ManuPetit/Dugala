<?php
		/**
		 *	script menu_del_main.php
		 *
		 *	ce fichier détruit le menu de la base de données et son fichier pdf
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Suppression d'un menu";
		$_SESSION['menuid'] = 4;
		include('../inclusion/admintete.php');
		require('../../dugala.inc.php');
		echo "<h2>Suppression d'un menu</h2>";
		//faire la requete
		if ((isset($_GET['menuid'])) && (is_numeric($_GET['menuid']))) {
			//on a une id numerique
			$q = "SELECT nom_fr, file_name FROM menus WHERE id=" . $_GET['menuid'] . " LIMIT 1";
			$r = @mysqli_query($dbc,$q);
			if (mysqli_num_rows($r) == 1) {
				//on a un retour
				$row = mysqli_fetch_array($r,MYSQLI_ASSOC);
				$file = PDF_DIR . $row['file_name'];
				$nom = $row['nom_fr'];
				//creation de la requête de suppresion
				$q = "DELETE FROM menus WHERE id=" . $_GET['menuid'] . " LIMIT 1";
				$r = @mysqli_query($dbc,$q);
				if (mysqli_affected_rows($dbc) == 1) {
					//fichier detruit de la base de données
					//on enleve le fichier pdf
					if (file_exists($file)) {
						unlink($file);
					}
					echo "<p>Le menu &quot;" . $nom . "&quot; a &eacute;t&eacute; supprim&eacute; d&eacute;finitevement de la base de donn&eacute;es.</p>";
				} else {
					//suppression n'ont réalisé
					echo "<p>Le menu n'a pas pu &ecirc;tre supprim&eacute; de la base de donn&eacute;es.</p><p>Veuillez recommencer. Si le probl&egrave;me persiste, contactez l'administrateur du syst&egrave;me.</p>";
				}
				//		FIN DE		if (mysqli_affected_rows($dbc) == 1) 
			} else {
				echo "<p>Le menu que vous essayez de supprimer n'a pas &eacute;t&eacute; trouv&eacute; dans la base de donn&eacute;es.</p><p>V&eacute;rifiez que le menu existe bien en allant sur la <a href=\"menu_list.php\" title=\"Cliquez ici pour afficher la liste des menus et cartes.\">liste des menus et cartes</a>, pour confirmation.</p>";
			}
			//		FIN DE		if (mysqli_num_rows($r) == 1)
			mysqli_close($dbc);
		} else {
			echo "<p>Votre demande n'a pas pu aboutir.</p>";
		}
		//		FIN DE 		if (((isset($_GET['menuid'])) && (is_numeric($_GET['menuid'])))
		include('../inclusion/adminpied.php');
?>
			