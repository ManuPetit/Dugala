<?php
		/**
		 *	script evene_del_main.php
		 *
		 *	ce fichier détruit le menu de la base de données et son fichier pdf
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Suppression d'un &eacute;v&eacute;nement";
		$_SESSION['menuid'] = 5;
		include('../inclusion/admintete.php');
		require('../../dugala.inc.php');
		echo "<h2>Suppression d'un &eacute;v&eacute;nement</h2>";//faire la requete
		if ((isset($_GET['eveneid'])) && (is_numeric($_GET['eveneid']))) {
			//on a une id numerique
			$q = "SELECT nom_fr, DATE_FORMAT( evenements.date_evenement, '%d-%m-%Y' ) AS jour FROM evenements WHERE id=" . $_GET['eveneid'] . " LIMIT 1";
			$r = @mysqli_query($dbc,$q);
			if (mysqli_num_rows($r) == 1) {
				//on a un retour
				$row = mysqli_fetch_array($r,MYSQLI_ASSOC);
				$nom = $row['nom_fr'];
				$date = $row['jour'];
				$q = "DELETE FROM evenements WHERE id=" . $_GET['eveneid'] . " LIMIT 1";
				$r = @mysqli_query($dbc,$q);
				if (mysqli_affected_rows($dbc) == 1) {
					echo "<p>L'&eacute;v&eacute;nement : <strong>" . $nom . "</strong> du " . $date . " a &eacute;t&eacute; supprim&eacute; d&eacute;finitevement de la base de donn&eacute;es.</p>";
				} else {
					echo "<p>L'&eacute;v&eacute;nement : <strong>" . $nom . "</strong> du " . $date . " n'a pas pu &ecirc;tre supprim&eacute; de la base de donn&eacute;es.</p><p>Veuillez recommencer. Si le probl&egrave;me persiste, contactez l'administrateur du syst&egrave;me.</p>";
				}
			} else {
				echo "<p>L'&eacute;v&eacute;nement que vous essayez de supprimer n'a pas &eacute;t&eacute; trouv&eacute; dans la base de donn&eacute;es.</p><p>V&eacute;rifiez que l'&eacute;v&eacute;nement existe bien en allant sur la <a href=\"evene_list.php\" title=\"Cliquez ici pour afficher la liste des &eacute;v&eacute;nements.\">liste des &eacute;v&eacute;nements</a>, pour confirmation.</p>";
			}
			//		FIN DE		if (mysqli_num_rows($r) == 1)
			mysqli_close($dbc);
		} else {
			echo "<p>Votre demande n'a pas pu aboutir.</p>";
		}
		//		FIN DE 		if (((isset($_GET['menuid'])) && (is_numeric($_GET['menuid'])))
		include('../inclusion/adminpied.php');
?>
			
