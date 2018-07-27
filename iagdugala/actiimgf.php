<?php		
	//		actiimgf.php
	//		active une image de fond sur le systeme
	
	require('../inclusion/config.inc.php');
	require('../../dugala.inc.php');
	//verifier que l'utilisateur est logge
	redirect_invalid_user();
	if (($_SERVER['REQUEST_METHOD'] == 'GET') &&(isset($_GET['imgid'])) && (is_numeric($_GET['imgid']))) {
		$id = (int)$_GET['imgid'];
		//vérifier que le fond existe dans la base de données
		$sql ='SELECT nomFichier FROM photofond WHERE IsActive = 0 AND id = ' . $id . ' LIMIT 1';
		$r = @mysqli_query($dbc, $sql);
		$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
		if (!empty($row)){
			//on met tous les fond en non active			
			$sql = 'UPDATE photofond SET IsActive = 0';
			$r = @mysqli_query($dbc, $sql);
			//on active le fond concerné
			$sql = 'UPDATE photofond SET IsActive = 1 WHERE ID = ' . $id;
			$r = @mysqli_query($dbc, $sql);
			if (mysqli_affected_rows($dbc) == 1) {
				//ca a marche on crée le nouveau fichier
				$mes ='@charset "utf-8";
/* CSS Document */
#entere {
	background-image:url(../images/css/chead'.$row['nomFichier'].');
	background-repeat:no-repeat;
}
#wrapper {
	background-image:url(../images/css/ccorps'.$row['nomFichier'].');
	background-repeat:repeat-y;
}';
				$myccs="../css/photo.css";
				if ($fh = fopen($myccs, 'w')){
					fwrite($fh,$mes);
					fclose($fh);
				}
			}
		}
		mysqli_close($dbc);
	}
	
	$url = 'imgf_list.php';
	header("Location: $url");
	exit();
?>