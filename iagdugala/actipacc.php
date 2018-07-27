<?php
	//		actipacc.php
	//		active une nouvelle image de la page d'accueil
	require('../inclusion/config.inc.php');
	require('../../dugala.inc.php');
	//verifier que l'utilisateur est logge
	redirect_invalid_user();
	if (($_SERVER['REQUEST_METHOD'] == 'GET') &&(isset($_GET['imgid'])) && (is_numeric($_GET['imgid']))) {
		$id=(int)$_GET['imgid'];
		//on active le theme concerné
		$sql = 'UPDATE photoopen SET IsShowing = 0';
		$r = @mysqli_query($dbc, $sql);
		//on active le theme concerné
		$sql = 'UPDATE photoopen SET IsShowing = 1 WHERE ID = ' . $id;
		$r = @mysqli_query($dbc, $sql);
		mysqli_close($dbc);		
	}
	$url='photoacc_list.php';
	header("Location: $url");
	exit();
?>