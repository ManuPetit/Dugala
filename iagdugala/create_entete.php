<?php
	//		create_entete.php
	echo '<h4>Etape 2 : choisissez l\'entête de ce thème</h4>';
	$id = (int)$_POST['fond'];
	$sql = 'SELECT nomfichier FROM photofond WHERE id = ' . $id . ' LIMIT 1';
	$r = @mysqli_query($dbc, $sql);
	 if (mysqli_num_rows($r)== 0) {
		 echo '<p>Une erreur s\'est produite. Le fond d\'écran n\'a pas pu être récupérer sur le système.</p>';
	 }else{		
	 	$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
		echo '<fieldset><legend>Entête du site :</legend>';
		echo '<form action="theme_ajou.php" method="post" accept-charset="utf-8">';		 
		 echo '<table width="830px" border="0px" cellpadding="5px" align="center">';
		 $filecount=0;
		 $filepath= '../images/css/';
		 $dir = opendir($filepath);
		 $t=0;
		 $files=array();
		 while ($file=readdir($dir)){
			 $pos = strpos($file, 'entete');
			 $fic = strpos($file,'.png');
			 if (($fic !== false) && ($pos !== false)){
				 $files[]=$file;
				 $t++;
			 }
		 }
		 for ($i=0;$i<count($files);$i++){				 
			 echo '<tr valign="top"><td width="400px" style="background: url(../images/css/chead' . $row['nomfichier'] .');background-size:100%"><img src="../images/css/'.$files[$i].'" width="400" height="50" /></td>';
			 if ($i+1 != count($files)) {
				echo '<td width="400px" style="background: url(../images/css/chead' . $row['nomfichier'] .');background-size:100%"><img src="../images/css/'.$files[$i+1].'" width="400" height="50" /></td></tr>';
			 }else{
				 echo '<td width="300px"></td></tr>';
			 }
			 echo '<tr><td align="center"><input type="radio" name="entete" value="'.$files[$i].'">Cliquez ici pour choisir cet entête : '.$files[$i].' </input></td>';
			 if ($i+1 != count($files)) {
				echo '<td  width="400px" align="center"><input type="radio" name="entete" value="'.$files[$i+1].'">Cliquez ici pour choisir cet entête : '.$files[$i+1].' </input></td></tr>';
			 }else{
				 echo '<td width="400px"></td></tr>';
			 }
			 echo "\n";
			 $i++;
		 }
	
		 echo '<tr><td colspan="2" align="right"><input type="submit" name="submit" value="Passez à l\'étape suivante" /></td></tr>';
		 echo '</table>';
		 echo '<input type="hidden" name="fond" value="'.$id.'" />
		 </form>';
	 }
?>
