<?php
		/**
		 *	script menu_del.php
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
			$url = BASE_ADMIN . 'menu_del_main.php?menuid=' . $_POST['imenu'];
			header("Location: $url");
			exit();//quitter le script
		}
		
		$page_title = "Suppression d'un menu";
		$_SESSION['menuid'] = 4;
		include('../inclusion/admintete.php');
		
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
			echo "<h2>Suppression d'un menu</h2><p>Il n'y a aucun menu dans la base donn&eacute;es.</p><p>Suppression impossible !</p>";
			mysqli_close($dbc);
			include('../inclusion/adminpied.php');
			exit();
		}
		//		FIN DE		if (mysqli_num_rows($r) >0)
		mysqli_close($dbc);
?>
<h2>Suppression d'un menu</h2>
<fieldset><legend>Choisissez le menu &agrave; supprimer dans votre liste de menus et cartes : </legend>
<form action="menu_del.php" method="post" style="padding-left:100px" onSubmit="if(confirm('Voulez-vous vraiment supprimer ce menu ?')) return true; else return false;" >
<p><label for="menu"><strong>Selectionnez le menu :</strong></label><br />
<select name="imenu">
<?php
	for ($i=0; $i<count($menu); $i++) {
		echo '<option value="' . $menu[$i] . '">' . $nom[$i] . '</option>';
	}
?>
</select>
</p>
<input type="submit" name="submit" value="Supprimer ce menu" />
<input type="hidden" name="submitted" value="TRUE" />
</form>
</fieldset>
<br />
<?php
	include('../inclusion/adminpied.php');
?>
		
		