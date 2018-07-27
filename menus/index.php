<?php
		//fichier de redirection au cas ou on essai de visualiser le dossier
		
		require('../inclusion/config.inc.php');
		$url = BASE_URL_FR . 'index.php';
	 	header("Location:$url");
	 	exit();
?>