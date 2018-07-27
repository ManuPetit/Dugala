<?php
		/**
		 *	script part_del.php
		 *
		 *	ce fichier permet de selectionner le partenaire a supprimer
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		require('../../dugala.inc.php');
		
		if (isset($_POST['submitted'])) {
			//rediriger
			$url = BASE_ADMIN . 'part_del_main.php?partid=' . $_POST['part'];
			header("Location: $url");
			exit();//quitter le script
		}
		
		$page_title = "Suppression d'un partenaire";
		$_SESSION['menuid'] = 6;
		include('../inclusion/admintete.php');
		
		//requête
		$q = "SELECT id, nom_fr FROM partenaires ORDER BY nom_fr ASC";
		$r = @mysqli_query($dbc,$q);
		if (mysqli_num_rows($r) >0) {
			$menu=array();
			$nom=array();
			while($row=mysqli_fetch_array($r, MYSQLI_ASSOC)) {
				$menu[] = $row['id'];
				$nom[] = $row['nom_fr'];
			}
		} else {
			echo "<h2>Suppression d'un partenaire</h2><p>Il n'y a aucun partenaire enregistr&eacute; dans la base donn&eacute;es.</p><p>Suppression impossible !</p>";
			mysqli_close($dbc);
			include('../inclusion/adminpied.php');
			exit();
		}
		//		FIN DE		if (mysqli_num_rows($r) >0)
		mysqli_close($dbc);
?>
<h2>Suppression d'un partenaire</h2>
<fieldset><legend>Choisissez le partenaire &agrave; supprimer dans votre liste de partenaires : </legend>
<form action="part_del.php" method="post" style="padding-left:100px" onSubmit="if(confirm('Voulez-vous vraiment supprimer ce partenaire ?')) return true; else return false;" >
<p><label for="part"><strong>S&eacute;lectionnez le partenaire :</strong></label><br />
<select name="part">
<?php
	for ($i=0; $i<count($menu); $i++) {
		echo '<option value="' . $menu[$i] . '">' . $nom[$i] . '</option>';
	}
?>
</select>
</p>
<input type="submit" name="submit" value="Supprimer ce partenaire" />
<input type="hidden" name="submitted" value="TRUE" />
</form>
</fieldset>
<br />
<?php
	include('../inclusion/adminpied.php');
?>
		
		