<?php
		/**
		 *	script photo_del_main.php
		 *
		 *	ce fichier détruit une photode la base de données et son fichier image
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Suppression d'une photo";
		$_SESSION['menuid'] = 2;
		include('../inclusion/admintete.php');
		require('../../dugala.inc.php');
		echo "<h2>Suppression d'une photo</h2>";
		//faire la requete
		if ((isset($_GET['photoid'])) && (is_numeric($_GET['photoid']))) {
			$q = "SELECT nom_fr, fichier FROM photos WHERE id=" . $_GET['photoid'] . " LIMIT 1";
			$r = @mysqli_query($dbc,$q);
			if (mysqli_num_rows($r) == 1) {
				//on a un retour
				$row=mysqli_fetch_array($r, MYSQLI_ASSOC);
				$photo = $row['fichier'];
				$q = "DELETE FROM photos WHERE id=" . $_GET['photoid'] . " LIMIT 1";
				$r = @mysqli_query($dbc, $q);
				if (mysqli_affected_rows($dbc) == 1) {
					//creation fichier xml
					include('create_xml.php');
					echo "<p>La photo a &eacute;t&eacute; supprim&eacute;e de la base donn&eacute;es.</p>";
					$piece = explode('.',$photo);
					$file = '../images/' . $piece[0] . '_th.' . $piece[1];
					if (file_exists($file)) {
						unlink($file);
					}
				} else {
					echo "<p>La photo n'a pas pu &ecirc;tre supprim&eacute;e de la base de donn&eacute;es.</p><p>Veuillez recommencer. Si le probl&egrave;me persiste, contactez l'administrateur du syst&egrave;me.</p>";
				}
				//		FIN DE		if (mysqli_affected_rows($dbc) == 1) 
			} else {
				echo "<p>La photo que vous essayez de supprimer n'a pas &eacute;t&eacute; trouv&eacute;e dans la base de donn&eacute;es.</p><p>V&eacute;rifiez que la photo existe bien en allant sur la <a href=\"photo_list.php\" title=\"Cliquez ici pour afficher la liste de toutes vos photos.\">liste des photos</a>, pour confirmation.</p>";
			}
			//		FIN DE		if (mysqli_num_rows($r) == 1)
			mysqli_close($dbc);
		} else {
			echo "<p>Votre demande n'a pas pu aboutir.</p>";
		}
		//		FIN DE 		if (((isset($_GET['menuid'])) && (is_numeric($_GET['menuid'])))
		include('../inclusion/adminpied.php');
?>