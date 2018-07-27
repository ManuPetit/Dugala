<?php
		/**
		 *	script evene_del.php
		 *
		 *	ce fichier permet de selectionner le menu a supprimer
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		require('../../dugala.inc.php');
		
		if (isset($_POST['submitted'])) {
			//rediriger
			$url = BASE_ADMIN . 'evene_del_main.php?eveneid=' . $_POST['evene'];
			header("Location: $url");
			exit();//quitter le script
		}
		
		$page_title = "Suppression d'un &eacute;v&eacute;nement";
		$_SESSION['menuid'] = 5;
		include('../inclusion/admintete.php');
		
		//requête
		$q = "SELECT id, DATE_FORMAT(date_evenement,'%d-%m-%Y') AS jour, nom_fr FROM evenements ORDER BY date_evenement";
		$r = @mysqli_query($dbc,$q);
		if (mysqli_num_rows($r) >0) {
			$menu=array();
			$nom=array();
			$ddate=array();
			while($row=mysqli_fetch_array($r, MYSQLI_ASSOC)) {
				$menu[] = $row['id'];
				$nom[] = $row['nom_fr'];
				$ddate[] = $row['jour'];
			}
		} else {
			echo "<h2>Suppression d'un &eacute;v&eacute;nement</h2><p>Il n'y a aucun &eacute;v&eacute;nement dans la base donn&eacute;es.</p><p>Suppression impossible !</p>";
			mysqli_close($dbc);
			include('../inclusion/adminpied.php');
			exit();
		}
		//		FIN DE		if (mysqli_num_rows($r) >0)
		mysqli_close($dbc);
?>
<h2>Suppression d'un &eacute;v&eacute;nement</h2>
<fieldset><legend>Choisissez l'&eacute;v&eacute;nement &agrave; supprimer dans votre liste de vos &eacute;v&eacute;nements : </legend>
<form action="evene_del.php" method="post" style="padding-left:100px" onSubmit="if(confirm('Voulez-vous vraiment supprimer cet &eacute;v&eacute;nement ?')) return true; else return false;" >
<p><label for="menu"><strong>Selectionnez l'&eacute;v&eacute;nement :</strong></label><br />
<select name="evene">
<?php
	for ($i=0; $i<count($menu); $i++) {
		echo '<option value="' . $menu[$i] . '">Le ' . $ddate[$i] . ' : '. $nom[$i] . '</option>';
	}
?>
</select>
</p>
<input type="submit" name="submit" value="Supprimer cet &eacute;v&eacute;nement" />
<input type="hidden" name="submitted" value="TRUE" />
</form>
</fieldset>
<br />
<?php
	include('../inclusion/adminpied.php');
?>
		
		
