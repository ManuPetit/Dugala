<?php
	//		modif_fond.php
	include('../inclusion/admintete.php');
	echo '<h2>Modification d\'un thème</h2><p>Suivez les instructions pour modifier votre thème</p><h4>Etape 1 : modifiez votre fond d\'écran pour ce thème</h4>';
	echo '<fieldset><legend>Fond d\'écran du site :</legend>';
	if (!isset($tid)){
		$tid=$_POST['theid'];
	}
	echo '<form action="theme_modifmain.php" method="post" accept-charset="utf-8">';
	$sql1='SELECT imageFond FROM theme WHERE id = ' . $tid;
	$r1=  @mysqli_query($dbc, $sql1);
	$img = mysqli_fetch_array($r1, MYSQLI_ASSOC);
	$sql = 'SELECT id, nom, nomThumb FROM photofond ORDER BY nom';
	$r = @mysqli_query($dbc, $sql);
	echo '<table width="90%" border="0px" cellpadding="5px">';
	//affichage des thèmes
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		echo '<tr><td width="40%" align="center">';
		$image = $row['nomThumb'];
		$piece = explode('.',$image);
		$photo = '../images/' . $piece[0] . '_th.' . $piece[1];
		$size = getimagesize($photo);
		echo '<img src="' . $photo . '" border="0" width ="' . round($size[0]/1.5) . '" height="' . round($size[1]/1.5) . '" title="Fond d\'écran : ' . $row['nom'] . '." alt="Fond d\'écran : ' . $row['nom'] . '." /></td>';
		echo '<td width="60%"><input type="radio" name="fond" value="'.$row['id'].'"';
		if ($row['id'] == $img['imageFond']){
			echo ' checked';
		}
		echo '>Sélectionnez le fond d\'écran : ' . $row['nom'] . '</input>';
		echo '</tr>';
	}
	echo '<tr><td colspan="2" align="right"><input type="submit" name="submit" value="Passez à l\'étape suivante" /></td></tr>
	<input type="hidden" name="theid" value="'.$tid. '" />';
	echo '</table>
	</fieldset>
	</form>';
?>