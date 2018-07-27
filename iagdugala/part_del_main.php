<?php
		/**
		 *	script part_del_main.php
		 *
		 *	ce fichier détruit un partenaire de la base de données et son fichier image
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Suppression d'un partenaire";
		$_SESSION['menuid'] = 6;
		include('../inclusion/admintete.php');
		require('../../dugala.inc.php');
		echo "<h2>Suppression d'un partenaire</h2>";
		//faire la requete
		if ((isset($_GET['partid'])) && (is_numeric($_GET['partid']))) {
			//on a une id numerique
			$q = "SELECT nom_fr, photo FROM partenaires WHERE id=" . $_GET['partid'] . " LIMIT 1";
			$r = @mysqli_query($dbc,$q);
			if (mysqli_num_rows($r) == 1) {
				//on a un retour
				$row = mysqli_fetch_array($r,MYSQLI_ASSOC);
				$nom = $row['nom_fr'];
				$photo = $row['photo'];
				$q = "DELETE FROM partenaires WHERE id=" . $_GET['partid'] . " LIMIT 1";
				$r = @mysqli_query($dbc,$q);
				if (mysqli_affected_rows($dbc) == 1) {
					//fichier detruit de la base de données
					//on enleve le fichier image
					if ($photo != 'A') {
						$piece = explode('.',$photo);
						$file = '../images/' . $piece[0] . '_th.' . $piece[1];
						if (file_exists($file)) {
							unlink($file);
						}
					}
					echo "<p>Le partenaire &quot;" . $nom . "&quot; a &eacute;t&eacute; supprim&eacute; d&eacute;finitevement de la base de donn&eacute;es.</p>";
				} else {
					//suppression n'ont réalisé
					echo "<p>Le partenaire n'a pas pu &ecirc;tre supprim&eacute; de la base de donn&eacute;es.</p><p>Veuillez recommencer. Si le probl&egrave;me persiste, contactez l'administrateur du syst&egrave;me.</p>";
				}
				//		FIN DE		if (mysqli_affected_rows($dbc) == 1) 
			} else {
				echo "<p>Le partenaire que vous essayez de supprimer n'a pas &eacute;t&eacute; trouv&eacute; dans la base de donn&eacute;es.</p><p>V&eacute;rifiez que le partenaire existe bien en allant sur la <a href=\"part_list.php\" title=\"Cliquez ici pour afficher la liste de tous vos partenaires.\">liste des partenaires</a>, pour confirmation.</p>";
			}
			//		FIN DE		if (mysqli_num_rows($r) == 1)
			mysqli_close($dbc);
		} else {
			echo "<p>Votre demande n'a pas pu aboutir.</p>";
		}
		//		FIN DE 		if (((isset($_GET['menuid'])) && (is_numeric($_GET['menuid'])))
		include('../inclusion/adminpied.php');
?>
			