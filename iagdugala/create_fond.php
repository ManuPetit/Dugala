<?php
	//		create_fond.php
	echo '<h4>Etape 1 : choisissez votre fond d\'écran pour ce thème</h4>
	<p>Notez bien que vous avez la possiblité de changer le fond d\'écran de ce thème en activant une autre image dans la liste des fonds. Lorsque vous changez de thème, et si plus tard vous décider de reprendre ce thème, l\'image que vous avez utilisée lors de la création du thème sera reprise. Sauf si cette dernière à été supprimée, et dans ce cas, il s\'agira alors de l\'image d\'origine du site internet qui sera prise en compte.</p><p>Si ces explications ne sont pas assez claires, n\'hésitez pas à contacter votre webmaster.</p>';
	echo '<fieldset><legend>Fond d\'écran du site :</legend>';
	echo '<form action="theme_ajou.php" method="post" accept-charset="utf-8">';
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
		echo '<td width="60%"><input type="radio" name="fond" value="'.$row['id'].'">Sélectionnez le fond d\'écran : ' . $row['nom'] . '</input>';
		echo '</tr>';
	}
	echo '<tr><td colspan="2" align="right"><input type="submit" name="submit" value="Passez à l\'étape suivante" /></td></tr>';
	echo '</table>
	</fieldset>
	</form>';
?>