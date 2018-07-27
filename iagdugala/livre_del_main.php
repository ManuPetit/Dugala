<?php
		/**
		 *	script livre_del_main.php
		 *
		 *	ce fichier supprime un commentaire du livre d'or
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Suppression d'un commentaire";
		$_SESSION['menuid'] = 7;
		include('../inclusion/admintete.php');
		require('../../dugala.inc.php');
		echo "<h2>Suppression d'un commentaire</h2>";
		
		//faire la requete
		if ((isset($_GET['comid'])) && (is_numeric($_GET['comid']))) {
			//on a une id numerique
			$q = "SELECT CONCAT(prenom, ' ',nom) as nom, DATE_FORMAT(date_created, '%d/%m/%Y') as ladate FROM livres WHERE id=" . $_GET['comid'] . " LIMIT 1";
			$r = @mysqli_query($dbc,$q);
			if (mysqli_num_rows($r) == 1) {
				//on a un retour
				$row = mysqli_fetch_array($r,MYSQLI_ASSOC);
				$nom = $row['nom'];
				$ladate = $row['ladate'];
				//creation de la requête de suppresion
				$q = "DELETE FROM livres WHERE id=" . $_GET['comid'] . " LIMIT 1";
				$r = @mysqli_query($dbc,$q);
				if (mysqli_affected_rows($dbc) == 1) {
					echo "<p>Le commentaire de &quot;" . $nom . "&quot; en date du " . $ladate . " a &eacute;t&eacute; supprim&eacute; d&eacute;finitevement de la base de donn&eacute;es.</p>";
				} else {
					//suppression n'ont réalisé
					echo "<p>Le commentaire n'a pas pu &ecirc;tre supprim&eacute; de la base de donn&eacute;es.</p><p>Veuillez recommencer. Si le probl&egrave;me persiste, contactez l'administrateur du syst&egrave;me.</p>";
				}
				//		FIN DE		if (mysqli_affected_rows($dbc) == 1) 
			} else {
				echo "<p>Le commentaire que vous essayez de supprimer n'a pas &eacute;t&eacute; trouv&eacute; dans la base de donn&eacute;es.</p><p>V&eacute;rifiez que le commentaire existe bien en allant sur la <a href=\"livre_list.php\" title=\"Cliquez ici pour afficher la liste des commentaire de mon livre d'or.\">liste des commentaires du livre d'or</a>, pour confirmation.</p>";
			}
			//		FIN DE		if (mysqli_num_rows($r) == 1)
			mysqli_close($dbc);
		} else {
			echo "<p>Votre demande n'a pas pu aboutir.</p>";
		}
		//		FIN DE 		if (((isset($_GET['menuid'])) && (is_numeric($_GET['menuid'])))
		include('../inclusion/adminpied.php');
?>
			