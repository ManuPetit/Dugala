<?php
		/**
		 *	script theme_modifmain.php
		 *
		 *	ce fichier permet la modification d'un thème
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Modification d'un thème";
		$_SESSION['menuid'] = 8;
		require('../../dugala.inc.php');
		//faire la requete
		if (($_SERVER['REQUEST_METHOD'] == 'GET') && (isset($_GET['theid'])) && (is_numeric($_GET['theid']))) {
			$tid = $_GET['theid'];
			include ('modif_fond.php');
		}else if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['theid'])) && (isset($_POST['fond'])) && (isset($_POST['entete'])) && (isset($_POST['submitcss']))){
		//on atteint la derniere page du thème et on fait les verification
			include ('modifverif_css.php');
		}else if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['theid'])) && (isset($_POST['fond'])) && (isset($_POST['entete']))){
			//on atteint la derniere page du thème et on fait les verification
			include ('modif_css.php');
		}else if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['theid'])) && (isset($_POST['fond'])) &&(is_numeric($_POST['fond']))){
			//on affiche le choix de l'entete
			include ('modif_entete.php');
		}else if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['theid']))){
			//on affiche le choix de fond	
			echo '<p>Suivez les instructions pour créer votre nouveau thème...</p>';
			include ('modif_fond.php');
		}else{
			//on a une erreur on va donc à la liste des thème
			$url = 'theme_list.php';
			header("Location: $url");
			exit();
		}
		
	include('../inclusion/adminpied.php');
?>
