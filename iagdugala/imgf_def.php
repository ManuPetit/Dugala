<?php
		/**
		 *	script imgd_def.php
		 *
		 *	remet le fond prinipal
		 *
		 */
		
		require('../inclusion/config.inc.php');
		require('../../dugala.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Activer fond original";
		$_SESSION['menuid'] = 8;
		include('../inclusion/admintete.php');
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
		$myccs="../css/photo.css";
		if ($fh = fopen($myccs, 'w')){
			fwrite($fh,$mes);
			fclose($fh);
			echo '<h2>Activer fond original</h2><p>Le fond d\'écran du site est de nouveau le fond original</p>';
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
		