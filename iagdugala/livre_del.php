<?php
		/**
		 *	script livre_del.php
		 *
		 *	ce fichier permet de selectionner le commentaire a supprimer
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		require('../../dugala.inc.php');
		
		if (isset($_POST['submitted'])) {
			//rediriger
			$url = BASE_ADMIN . 'livre_del_main.php?comid=' . $_POST['icom'];
			header("Location: $url");
			exit();//quitter le script
		}
		
		$page_title = "Suppression d'un commentaire";
		$_SESSION['menuid'] = 7;
		include('../inclusion/admintete.php');
		
		//requête
		$q = "SELECT id, CONCAT(prenom, ' ', nom) as nom, DATE_FORMAT(date_created, '%d/%m/%Y') as ladate FROM livres ORDER BY date_created ASC";
		$r = @mysqli_query($dbc,$q);
		if (mysqli_num_rows($r) >0) {
			$menu=array();
			$nom=array();
			while($row=mysqli_fetch_array($r, MYSQLI_ASSOC)) {
				$menu[] = $row['id'];
				$nom[] = $row['nom'];
				$ladate[] = $row['ladate'];
			}
		} else {
			echo "<h2>Suppression d'un commentaire</h2><p>Il n'y a aucun commentaire dans la base donn&eacute;es.</p><p>Suppression impossible !</p>";
			mysqli_close($dbc);
			include('../inclusion/adminpied.php');
			exit();
		}
		//		FIN DE		if (mysqli_num_rows($r) >0)
		mysqli_close($dbc);
?>
<h2>Suppression d'un commentaire</h2>
<fieldset><legend>Choisissez le commentaire &agrave; supprimer de votre livre d'or : </legend>
<form action="livre_del.php" method="post" style="padding-left:100px" onSubmit="if(confirm('Voulez-vous vraiment supprimer ce commentaire ?')) return true; else return false;" >
<p><label for="menu"><strong>Selectionnez le commentaire :</strong></label><br />
<select name="icom">
<?php
	for ($i=0; $i<count($menu); $i++) {
		$mes = 'Commentaire de ' . $nom[$i] . ' du ' . $ladate[$i];
		echo '<option value="' . $menu[$i] . '">' . $mes. '</option>';
	}
?>
</select>
</p>
<input type="submit" name="submit" value="Supprimer ce commentaire" />
<input type="hidden" name="submitted" value="TRUE" />
</form>
</fieldset>
<br />
<?php
	include('../inclusion/adminpied.php');
?>