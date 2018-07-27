<?php
	//		theme_modif.php
	// fichier permettant la sélection du fichier theme à modifier
	
	require('../inclusion/config.inc.php');
	require('../../dugala.inc.php');
	//verifier que l'utilisateur est logge
	redirect_invalid_user();
	$page_title = "Modifier un thème";
	$_SESSION['menuid'] = 8;
	
	if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['tsub']))) {
		$url = BASE_ADMIN . 'theme_modifmain.php?theid=' . $_POST['theme'];
		header("Location: $url");
		exit();//quitter le script
	}
	include('../inclusion/admintete.php');
	$sql ='SELECT id, themeNom FROM theme WHERE id <> 1 ORDER BY themeNom';
	$r = @mysqli_query($dbc, $sql);
	if (mysqli_num_rows($r) >0) {
		$tid=array();
		$tnom=array();
		while($row=mysqli_fetch_array($r, MYSQLI_ASSOC)) {
			$tid[] = $row['id'];
			$tnom[] = $row['themeNom'];
		}
	} else {
		echo "<h2>Modifier un thème</h2><p>Il n'y a aucun thème modifiable enregistr&eacute; dans la base donn&eacute;es.</p><p>Modification impossible !</p>";
		mysqli_close($dbc);
		include('../inclusion/adminpied.php');
		exit();
	}
	//		FIN DE		if (mysqli_num_rows($r) >0)
	mysqli_close($dbc);
	echo '<h2>Modifier un thème</h2><p>Choisissez le thème que vous souhaitez modifier.</p>
	<fieldset><legend>Thème à modifier : </legend>
	<form action="theme_modif.php" method="post" style="padding-left:100px">
	<p><label for="theme"><strong>Thème choisi : </strong>';
	echo '<select name="theme">';
	for ($i=0;$i<count($tid);$i++){
		echo '<option value="'.$tid[$i].'">'.$tnom[$i].'</option>';
	}
	echo '</select>
	<div align="center"><input type="submit" name="submit" value="Choisir ce thème" /></div>
	<input type="hidden" name="tsub" value="TRUE" />
	</form>
	</fieldset>';
	include('../inclusion/adminpied.php');
?>