<?php
	//	theme_def.php
	//	active le thème par défaut sur le site internet ainsi que l'image par défaut
	
	require('../inclusion/config.inc.php');
	require('../../dugala.inc.php');
	//verifier que l'utilisateur est logge
	redirect_invalid_user();
	$page_title = "Activer le thème original du site";
	$_SESSION['menuid'] = 8;
	include('../inclusion/admintete.php');
	echo '<h2>Activer le thème original du site</h2>';
	//mettre tous les thèmes à zéro
	$sql = 'UPDATE theme SET IsOn = 0';
	$r = @mysqli_query($dbc, $sql);
	//activer le thème original
	$sql = 'UPDATE theme SET IsOn = 1, HasSnow = 0 WHERE id=1';
	$r = @mysqli_query($dbc, $sql);
	//activer l'image par défaut
		$mes ='@charset "utf-8";
/* CSS Document */
#entere {
	background-image:url(../images/css/chead.jpg);
	background-repeat:no-repeat;
}
#wrapper {
	background-image:url(../images/css/ccorps.jpg);
	background-repeat:repeat-y;
}';
	echo '<p>Le thème original a été activé sur le site internet.</p>';
	$myccs="../css/photo.css";
	if ($fh = fopen($myccs, 'w')){
		fwrite($fh,$mes);
		fclose($fh);
		echo '<p>Le fond d\'écran du site est de nouveau le fond original.</p>';
		//on remet tous les images à zero dans bdd
		$sql = 'UPDATE photofond SET IsActive = 0';
		$r = @mysqli_query($dbc, $sql);
		$sql = 'UPDATE photofond SET IsActive = 1 WHERE id=1';
		$r = @mysqli_query($dbc, $sql);
	}else{
		echo '<h2>Erreur</h2><p>Le fond d\'écran d\'origine n\'a pu être remis en place. Veuillez contacter le webmaster du site.</p>';
	}	
		include('../inclusion/adminpied.php');
?>	