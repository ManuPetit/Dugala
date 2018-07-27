<?php
	//		verif_css.php
	//		fichier qui enregistre le nouveau thème
	$t=getdate();
	$nomfile = 'theme' . $t[0];
	//création du nouveau fichier css
	$mes ='@charset "utf-8";
/* CSS Document */
body {
	background-color:'. $_POST['c1'] .';
}
#contenu {
	background-color:'. $_POST['c2'] .';
}
#gauche {
	background-color:'. $_POST['c2'] .';
}
#uncol {
	background-color:'. $_POST['c2'] .';
}
#uncol p, #contenu p {
	color:'. $_POST['c3'] .';
}
#uncol h3, #contenu h3, .nmenu {
	color:'. $_POST['c4'] .';
}
img.part {
	border:3px solid '. $_POST['c4'] .';
}
#gauche h3 {
	color:'. $_POST['c4'] .';
}
img.imgDroit {
	border:3px solid '. $_POST['c4'] .';
}
#flashContent {
	border:3px '. $_POST['c4'] .' solid;
}
.evene {
	background-color:'. $_POST['c5'] .';
	border: 1px solid '. $_POST['c4'] .';
}
#gauche span.ladate {
	color:'. $_POST['c6'] .';
}
#gauche span.titre {
	color:'. $_POST['c7'] .';
}
#uncol td span.nom {
	color:'. $_POST['c7'] .';
}
td.part {
	background-color:'. $_POST['c5'] .';
	border: 1px solid '. $_POST['c4'] .';
}
#uncol table tr td.part a:link, #uncol table tr td.part a:visited, #uncol table tr td.part a:active {
	color:'. $_POST['c8'] .';
}
#uncol table tr td.part a:hover {
	color:'. $_POST['c9'] .';
}
#gauche p, #uncol table td.part {
	color:'. $_POST['c3'] .'
}
#uncol a:link, #uncol a:visited, #uncol a:active {
	color:'. $_POST['c8'] .';
}
#uncol a:hover {
	color:'. $_POST['c9'] .';
}
#contenu a:link, #contenu a:visited, #contenu a:active {
	color:'. $_POST['c8'] .';
	text-decoration:none;
}
#contenu a:hover {
	color:'. $_POST['c9'] .';
}
#gauche a:link, #gauche a:visited, #gauche a:active {
	color:'. $_POST['c8'] .';
}
#gauche a:hover {
	color:'. $_POST['c9'] .';
}
fieldset {
	border-color:'. $_POST['c4'] .';
	color:'. $_POST['c3'] .';
}
.mygrad {
	color:'. $_POST['b3'] .';
	background:'. $_POST['b2'] .';
	background: -webkit-gradient(linear, left top, left bottom, from('. $_POST['b1'] .'), to('. $_POST['b2'] .'));
	background: -moz-linear-gradient(top,  '. $_POST['b1'] .',  '. $_POST['b2'] .');
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr=\''. $_POST['b1'] .'\', endColorstr=\''. $_POST['b2'] .'\');
}
.mygrad:hover {
	color:'. $_POST['b6'] .';
	background:'. $_POST['b4'] .';
	background: -webkit-gradient(linear, left top, left bottom, from('. $_POST['b4'] .'), to('. $_POST['b5'] .'));
	background: -moz-linear-gradient(top,  '. $_POST['b4'] .',  '. $_POST['b5'] .');
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr=\''. $_POST['b4'] .'\', endColorstr=\''. $_POST['b5'] .'\');
}
.mygrad:active, .mygradsel {
	color:'. $_POST['b6'] .';
	background:'. $_POST['b4'] .';
	background: -webkit-gradient(linear, left top, left bottom, from('. $_POST['b4'] .'), to('. $_POST['b5'] .'));
	background: -moz-linear-gradient(top,  '. $_POST['b4'] .',  '. $_POST['b5'] .');
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr=\''. $_POST['b4'] .'\', endColorstr=\''. $_POST['b5'] .'\');
}
#pied a:link, #pied a:visited, #pied a:active {
	color:'. $_POST['c10'] .';
	text-decoration:none;
}
#pied a:hover, #pied a.selection {
	text-decoration:none;
	color:'. $_POST['c11'] .';
}';
	$myccs='../css/'.$nomfile.'.css';
	if ($fh = fopen($myccs, 'w')){
		fwrite($fh,$mes);
		fclose($fh);
		echo '<p>Le fichier de style du nouveau thème a été créé avec succès sur le serveur.</p>';
		$name=escape_data($_POST['name']);
		//on ecrit le thème dans la base de données
		$sql = 'INSERT INTO theme (themeNom, FichierNom, dateCreer, HasSnow, heading, bouton, imageFond, IsOn, fond, fondBoite, police, titreCadre, fondBoiteDeux, date, titreBoiteDeux, lienVisible, lienSurvol, lienPiedVisible, lienPiedSurvol, lienNavVisible, lienNavSurvol, navHautVisible, navBasVisible, navHautActif, navBasActif) VALUES(';
		$sql .= '\'' . $name . '\', \'' . $nomfile . '\', NOW(), ' . $_POST['neige'] . ', \'' . $_POST['entete'] . '\', \'menuBut.png\', ' . $_POST['fond'] . ', '. $_POST['activer'] . ', ';
		for ($c=1;$c<12;$c++){
			$g = 'c' . $c;
			$sql .= '\'' . $_POST[$g] . '\', ';
		}
		$sql .= '\'' . $_POST['b3'] . '\', \'' . $_POST['b6'] .'\', \''. $_POST['b1'] .'\', \''. $_POST['b2'] .'\', \''. $_POST['b4'] .'\', \''. $_POST['b5'] .'\')';
		$r = @mysqli_query($dbc, $sql);
		if (mysqli_affected_rows($dbc) == 1) {
			echo '<p>La base de données a été mise à jour avec le nouveau thème.</p>';
			//verifier si on doit activer le theme et dans ce cas mettre à jour l'image de fond
			if ($_POST['activer']==1){
				//on met tous les autre thème en non actif
				$sql = 'UPDATE theme SET IsOn = 0 WHERE fichierNom <> \'' . $nomfile .'\'';
				$r = @mysqli_query($dbc, $sql);
				//on met tous les fond en non active			
				$sql = 'UPDATE photofond SET IsActive = 0';
				$r = @mysqli_query($dbc, $sql);
				//on active le fond concerné
				$sql = 'UPDATE photofond SET IsActive = 1 WHERE ID = ' .  $_POST['fond'];
				$r = @mysqli_query($dbc, $sql);
				if (mysqli_affected_rows($dbc) == 1) {
					$sql ='SELECT nomFichier FROM photofond WHERE IsActive = 1 AND id = ' . $_POST['fond'] . ' LIMIT 1';
					$r = @mysqli_query($dbc, $sql);
					$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
					if (!empty($row)){
						$mes ='@charset "utf-8";
/* CSS Document */
#entere {
background-image:url(../images/css/chead'.$row['nomFichier'].');
background-repeat:no-repeat;
}
#wrapper {
background-image:url(../images/css/ccorps'.$row['nomFichier'].');
background-repeat:repeat-y;
}';
						$myccs="../css/photo.css";
						if ($fh = fopen($myccs, 'w')){
							fwrite($fh,$mes);
							fclose($fh);
						}//fin de if ($fh = fopen($myccs, 'w')){	
						echo '<p>L\'image de fond du thème a été activée.</p>';
					}// fin de if (!empty($row)){
				}//fin de if (mysqli_affected_rows($dbc) == 1) {
				echo '<p>Le thème est maintenant actif sur le site internet.</p>';
			}else{
				echo '<p>Vous pourrez activer ce thème lorsque vous le souhaiter directement à partir de menu Liste thèmes.</p>';
			}//fin de if ($_POST['activer']==1){
		}else{
			echo '<p>Une erreur s\'est produite lors de la mise à jour de la base de données. Veuillez recommencer l\'opération.<br />Si l\'erreur persiste, contactez votre webmaster.</p>';
		}// fin de if (mysqli_affected_rows($dbc) == 1) {
	}// fin de if ($fh = fopen($myccs, 'w')){
?>