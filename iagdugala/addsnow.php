<?php		
	//		addsnow.php
	//		ajoute ou retire de la neige à un thème
	
	require('../inclusion/config.inc.php');
	require('../../dugala.inc.php');
	//verifier que l'utilisateur est logge
	redirect_invalid_user();
	if (($_SERVER['REQUEST_METHOD'] == 'GET') &&(isset($_GET['theid'])) && (is_numeric($_GET['theid'])) &&(isset($_GET['act']))) {
		$id = (int)$_GET['theid'];
		if ($_GET['act'] == 'o'){
			$act = 1;
		}else{
			$act = 0;
		}
		$sql = 'UPDATE theme SET HasSnow = ' . $act . ' WHERE id = ' . $id;
		$r = @mysqli_query($dbc, $sql);	
		mysqli_close($dbc);	
	}
	$url = 'theme_list.php';
	header("Location: $url");
	exit();
?>
	