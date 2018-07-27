<?php
		/**
		 *	script theme_del.php
		 *
		 *	ce fichier détruit le theme de la base de données, son fichier css
		 *
		 */
		
	require('../inclusion/config.inc.php');
	require('../../dugala.inc.php');
	//verifier que l'utilisateur est logge
	redirect_invalid_user();
	if (($_SERVER['REQUEST_METHOD'] == 'GET') &&(isset($_GET['theid'])) && (is_numeric($_GET['theid']))) {
		$id=(int)$_GET['theid'];
		//on retrouve le nom du fichier css et l'image bouton
		$sql = 'SELECT fichiernom, bouton FROM theme WHERE id = ' .$id . ' LIMIT 1';
		$r = @mysqli_query($dbc, $sql);
		$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
		if (!empty($row)){
			if (isset($row['fichiernom'])){
				$css = '../css/' . $row['fichiernom'] . '.css';
				if (file_exists($css)){
					unlink($css);
				}
			}
			//on enleve le data de la base de données
			$sql = 'DELETE FROM theme WHERE id = ' . $id . ' LIMIT 1';
			$r = @mysqli_query($dbc, $sql);
		}
		mysqli_close($dbc);
	}
	$url = 'theme_list.php';
	header("Location: $url");
	exit();
?>
		
			
				
		
		