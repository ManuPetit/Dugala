<?php
		/**
		 *	script part_mod.php
		 *
		 *	ce fichier permet de selectionner le partenaire a modifier
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		require('../../dugala.inc.php');
		
		if (isset($_POST['submitted'])) {
			//rediriger
			$url = BASE_ADMIN . 'part_mod_main.php?partid=' . $_POST['part'];
			header("Location: $url");
			exit();//quitter le script
		}
		
		$page_title = "Modifier un partenaire";
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
			echo "<h2>Modifier un partenaire</h2><p>Il n'y a aucun partenaire enregistr&eacute; dans la base donn&eacute;es.</p><p>Modification impossible !</p>";
			mysqli_close($dbc);
			include('../inclusion/adminpied.php');
			exit();
		}
		//		FIN DE		if (mysqli_num_rows($r) >0)
		mysqli_close($dbc);
?>
<h2>Modifier un partenaire</h2>
<fieldset><legend>Choisissez le partenaire &agrave; modifier dans votre liste de partenaires : </legend>
<form action="part_mod.php" method="post" style="padding-left:100px">
<p><label for="part"><strong>S&eacute;lectionnez le partenaire :</strong></label><br />
<select name="part">
<?php
	for ($i=0; $i<count($menu); $i++) {
		echo '<option value="' . $menu[$i] . '">' . $nom[$i] . '</option>';
	}
?>
</select>
</p>
<input type="submit" name="submit" value="Modifier ce partenaire" />
<input type="hidden" name="submitted" value="TRUE" />
</form>
</fieldset>
<br />
<?php
	include('../inclusion/adminpied.php');
?>