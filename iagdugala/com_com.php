<?php
		/**
		 *
		 *	script com_com.php
		 *
		 *	présente un commentaire complet
		 *
		 */
		
		require('../inclusion/config.inc.php');
		require('../../dugala.inc.php');
		
		
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		if ((isset($_GET['comid'])) && (is_numeric($_GET['comid']))) {
			$q = "SELECT CONCAT(prenom , ' ', nom) as nom, commentaire FROM livres WHERE id=" . $_GET['comid'] . " LIMIT 1";
			$r = @mysqli_query($dbc, $q);
			if (mysqli_num_rows($r) == 1) {
				$row=mysqli_fetch_array($r,MYSQLI_ASSOC);
				$title = "Commentaire de " . $row['nom'];
				$corp = '<h3>' . $title . '</h3><p>' . $row['commentaire'] . '</p>';
			} else {
				$title = "Erreur";
				$corp = '<h3>Erreur</h3><p>Le commentaire que vous essayez de lire n\'existe pas...</p>';
			}
			mysqli_close($dbc);
		} else {
			$title = "Erreur";
			$corp = '<h3>Erreur</h3><p>Cette page a &eacute;t&eacute; acc&eacute;d&eacute;e par erreur...</p>';
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>
</head>

<body style="background-color:#2c2f22;color:#fff">
<?php echo $corp; ?>
</body>
</html>

	