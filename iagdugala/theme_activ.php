<?php		
	//		theme_activ.php
	//		ajoute ou retire de la neige à un thème
	
	require('../inclusion/config.inc.php');
	require('../../dugala.inc.php');
	//verifier que l'utilisateur est logge
	redirect_invalid_user();
	if (($_SERVER['REQUEST_METHOD'] == 'GET') &&(isset($_GET['theid'])) && (is_numeric($_GET['theid']))) {
		$id=(int)$_GET['theid'];
		//vérifier que le theme existe dans la base de données
		$sql ='SELECT themenom, imageFond FROM theme WHERE IsOn = 0 AND id = ' . $id . ' LIMIT 1';
		$r = @mysqli_query($dbc, $sql);
		$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
		if (!empty($row)){
			//mettre à zero tous les thèmes			
			$sql = 'UPDATE theme SET IsOn = 0';
			$r = @mysqli_query($dbc, $sql);
			//on active le theme concerné
			$sql = 'UPDATE theme SET IsOn = 1 WHERE ID = ' . $id;
			$r = @mysqli_query($dbc, $sql);
			//on retrouve la photo associée au theme
			$sql = 'SELECT id, nomfichier FROM photofond WHERE id = ' . $row['imageFond'] . ' LIMIT 1';
			$r = @mysqli_query($dbc, $sql);
			$row1 = mysqli_fetch_array($r, MYSQLI_ASSOC);
			if (!empty($row1)){
				$pid = $row1['id'];
				$pnom = $row1['nomfichier'];
			}else{
				//si elle n'existe pas on prend l'original
				$pid = 1;
				$pnom = '.jpg';
			}
			//création du fichier css photo
			$mes ='@charset "utf-8";
/* CSS Document */
#entere {
	background-image:url(../images/css/chead'.$pnom.');
	background-repeat:no-repeat;
}
#wrapper {
	background-image:url(../images/css/ccorps'.$pnom.');
	background-repeat:repeat-y;
}';
			$myccs="../css/photo.css";
			if ($fh = fopen($myccs, 'w')){
				fwrite($fh,$mes);
				fclose($fh);
				//mise à jour de la base de données photofond
				//on remet tous les images à zero dans bdd
				$sql = 'UPDATE photofond SET IsActive = 0';
				$r = @mysqli_query($dbc, $sql);
				$sql = 'UPDATE photofond SET IsActive = 1 WHERE id='.$pid;
				$r = @mysqli_query($dbc, $sql);	
			}
			mysqli_close($dbc);
		}
	}
	$url='theme_list.php';
	header("Location: $url");
	exit();
?>