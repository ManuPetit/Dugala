<?php
	//		delpacc.php
	//		active une nouvelle image de la page d'accueil
	require('../inclusion/config.inc.php');
	require('../../dugala.inc.php');
	//verifier que l'utilisateur est logge
	redirect_invalid_user();
	if (($_SERVER['REQUEST_METHOD'] == 'GET') &&(isset($_GET['imgid'])) && (is_numeric($_GET['imgid']))) {
		$id=(int)$_GET['imgid'];
		//on enlève la photo
		$sqal = 'SELECT fichier FROM photoopen WHERE id = '.$id;
		$ra = @mysqli_query($dbc, $sqal);
		$img = mysqli_fetch_array($ra,MYSQLI_ASSOC);
		$image = $img['fichier'];
		$piece = explode('.',$image);
		$photo = '../images/' . $piece[0] . '_th.' . $piece[1];
		if (file_exists($photo)){
			unlink($photo);
		}
		//on active le theme concerné
		$sql = 'DELETE FROM photoopen WHERE ID = ' . $id;
		$r = @mysqli_query($dbc, $sql);
		mysqli_close($dbc);		
	}
	$url='photoacc_list.php';
	header("Location: $url");
	exit();
?>