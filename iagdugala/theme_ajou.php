<?php
	/**
	 *	script theme_ajou.php
	 *
	 *	page de création des thèmes
	 *
	 */
	
	require('../inclusion/config.inc.php');
	require('../../dugala.inc.php');
	//verifier que l'utilisateur est logge
	redirect_invalid_user();
	$page_title = "Ajouter un nouveau thème";
	$_SESSION['menuid'] = 8;
	include('../inclusion/admintete.php');
	echo '<h2>Ajouter un nouveau thème</h2>';
	
	if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['fond'])) && (isset($_POST['entete'])) && (isset($_POST['submitcss']))){
		//on atteint la derniere page du thème et on fait les verification
		include ('verif_css.php');
	}else if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['fond'])) && (isset($_POST['entete']))){
		//on atteint la derniere page du thème et on fait les verification
		include ('create_css.php');
	}else if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['fond'])) &&(is_numeric($_POST['fond']))){
		//on affiche le choix de l'entete
		include ('create_entete.php');
	}else{
		//on affiche le choix de fond	
		echo '<p>Suivez les instructions pour créer votre nouveau thème...</p>';
		include ('create_fond.php');
	}
	
	include('../inclusion/adminpied.php');
?>