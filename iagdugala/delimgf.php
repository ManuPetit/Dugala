<?php		
	//		delimgf.php
	//		supprime une image de fond sur le systeme
	
	require('../inclusion/config.inc.php');
	require('../../dugala.inc.php');
	//verifier que l'utilisateur est logge
	redirect_invalid_user();
	if (($_SERVER['REQUEST_METHOD'] == 'GET') &&(isset($_GET['imgid'])) && (is_numeric($_GET['imgid']))) {
		$id = (int)$_GET['imgid'];
		//vérifier que le fond existe dans la base de données
		$sql ='SELECT nomFichier, nomThumb FROM photofond WHERE id = ' . $id . ' LIMIT 1';
		$r = @mysqli_query($dbc, $sql);
		$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
		if (!empty($row)){
			//on a une image
			//on enlève l'image du fichier
			$imgh = '../images/css/chead' . $row['nomFichier'];
			$imgc = '../images/css/ccorps' . $row['nomFichier'];
			$imghm = '../images/css/chmini' . $row['nomFichier'];
			$imgcm = '../images/css/ccmini' . $row['nomFichier'];
			//on supprime l'image original
			$image = $row['nomThumb'];
			$piece = explode('.',$image);
			$thumb = '../images/' . $piece[0] . '_th.' . $piece[1];
			$original = '../images/' . $row['nomThumb'];
			if (file_exists($imgh)){
				unlink($imgh);
			}
			if (file_exists($imgc)){
				unlink($imgc);
			}
			if (file_exists($imghm)){
				unlink($imghm);
			}
			if (file_exists($imgcm)){
				unlink($imgcm);
			}
			if (file_exists($thumb)){
				unlink($thumb);
			}
			if (file_exists($original)){
				unlink($original);
			}
			$sql ='DELETE FROM photofond WHERE id = ' . $id . ' LIMIT 1';
			$r = @mysqli_query($dbc, $sql);
		}
		mysqli_close($dbc);
	}
	$url = 'imgf_list.php';
	header("Location: $url");
	exit();
?>