<?php
		/**
		 *	script menu_mod.php
		 *
		 *	ce fichier permet de selectionner le menu a modifier
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		require('../../dugala.inc.php');
		
		if (isset($_POST['submitted'])) {
			//rediriger
			$url = BASE_ADMIN . 'menu_mod_main.php?menuid=' . $_POST['imenu'];
			header("Location: $url");
			exit();//quitter le script
		}
		
		$page_title = "Modifier un menu";
		$_SESSION['menuid'] = 4;
		include('../inclusion/admintete.php');
		echo '<h2>Modifier un menu</h2>';
		
		//requête
		$q = "SELECT id, nom_fr FROM menus ORDER BY nom_fr ASC";
		$r = @mysqli_query($dbc,$q);
		if (mysqli_num_rows($r) >0) {
			$menu=array();
			$nom=array();
			while($row=mysqli_fetch_array($r, MYSQLI_ASSOC)) {
				$menu[] = $row['id'];
				$nom[] = $row['nom_fr'];
			}
		} else {
			echo "<p>Il n'y a aucun menu dans la base donn&eacute;es.</p><p>Modification impossible !</p>";
			mysqli_close($dbc);
			include('../inclusion/adminpied.php');
			exit();
		}
		//		FIN DE		if (mysqli_num_rows($r) >0)
		mysqli_close($dbc);
?>

<fieldset><legend>Choisissez le menu &agrave; modifier dans votre liste de menus et cartes : </legend>
<form action="menu_mod.php" method="post" style="padding-left:100px">
<p><label for="menu"><strong>Selectionnez le menu :</strong></label><br />
<select name="imenu">
<?php
	for ($i=0; $i<count($menu); $i++) {
		echo '<option value="' . $menu[$i] . '">' . $nom[$i] . '</option>';
	}
?>
</select>
</p>
<input type="submit" name="submit" value="Modifier ce menu" />
<input type="hidden" name="submitted" value="TRUE" />
</form>
</fieldset>
<br />
<?php
	include('../inclusion/adminpied.php');
?>
		
