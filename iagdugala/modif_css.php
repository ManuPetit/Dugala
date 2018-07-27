<?php
	//		create_css.php
	include('../inclusion/admintete.php');
	echo '<h2>Modification d\'un thème</h2>';
	echo '<h4>Etape 3 : Modification des couleurs du thème</h4><p>Choisissez les couleurs que vous souhaitez voir sur votre site internet.</p><p>Les couleurs présentées dans le modèle ci dessous, sont les couleurs originales du site internet.</p><p><b>Selection des couleurs :<br /></b>Cliquez sur la vignette colorée. Une boite de sélection apparaît. Choisissez la couleur en utilisant votre souris dans la boite gauche, et/ou sur l\'échelle des couleurs. Vous pouvez également entrer directement des valeurs dans les champs de droite. Les éléments changes de couleur sur le modèle en temps réel. Pour sélectionner votre couleur, cliquez à l\'extérieur de la boite de sélection.</p><p>Le modèle se met à jour en temps réel.</p><br />';
	$id = (int)$_POST['fond'];
	$entete = $_POST['entete'];	
	if (!isset($tid)){
		$tid=$_POST['theid'];
	}
	$sqla = 'SELECT * FROM theme WHERE id = ' . $tid;
	$ra = @mysqli_query($dbc, $sqla);
	$tdet=mysqli_fetch_array($ra, MYSQLI_ASSOC);
	include ('tempsjs.php');
	$img = '../images/css/'.$entete;
	$size = getimagesize($img);
	$sql = 'SELECT nomfichier FROM photofond WHERE id = ' . $id . ' LIMIT 1';
	$r = @mysqli_query($dbc, $sql);
	$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
	$ch = '../images/css/chead'.$row['nomfichier'];
	$cc = '../images/css/ccorps'.$row['nomfichier'];
	echo '<fieldset><legend>Modifiez vos couleurs :</legend>
	<form action="theme_modifmain.php" id="cmxform" method="post" accept-charset="utf-8">';
	echo '<input type="hidden" name="fond" value="'.$id.'" />
	<input type="hidden" name="entete" value="'.$entete.'" />
	<input type="hidden" name="theid" value="'.$tid.'" />';
	echo '<table width="100%" border="0" cellspacing="2px">
	<tr><td align="center"><b>Propriétés des couleurs</b></td><td width="500px" align="center"><b>Modèle</b></td></tr>';
	echo "\n";
	echo '<tr><td>
		<table width="100%" border="0" cellspacing="2px">
		<tr><td width="75%" align="right">Couleur de fond de la page</td><td width="25%" align="center"><div id="colorSelector10"><div style="background-color: '.$tdet['fond'].'"></div></div></td></tr>
		<tr><td width="75%" align="right">Couleur de fond des colonnes</td><td width="25%" align="center"><div id="colorSelector11"><div style="background-color: '.$tdet['fondBoite'].'"></div></div></td></tr>
		<tr><td width="75%" align="right">Couleur de la police de caractères</td><td width="25%" align="center"><div id="colorSelector12"><div style="background-color: '.$tdet['police'].'"></div></div></td></tr>
		<tr><td width="75%" align="right">Couleur des titres et cadres</td><td width="25%" align="center"><div id="colorSelector13"><div style="background-color: '.$tdet['titreCadre'].'"></div></div></td></tr>
		<tr><td width="75%" align="right">Couleur de fond des boites</td><td width="25%" align="center"><div id="colorSelector14"><div style="background-color: '.$tdet['fondBoiteDeux'].'"></div></div></td></tr>
		<tr><td width="75%" align="right">Couleur date événement</td><td width="25%" align="center"><div id="colorSelector15"><div style="background-color: '.$tdet['date'].'"></div></div></td></tr>
		<tr><td width="75%" align="right">Couleur titre des boites</td><td width="25%" align="center"><div id="colorSelector16"><div style="background-color: '.$tdet['titreBoiteDeux'].'"></div></div></td></tr>
		<tr><td width="75%" align="right">Couleur liens visibles</td><td width="25%" align="center"><div id="colorSelector17"><div style="background-color: '.$tdet['lienVisible'].'"></div></div></td></tr>
		<tr><td width="75%" align="right">Couleur liens actifs</td><td width="25%" align="center"><div id="colorSelector18"><div style="background-color: '.$tdet['lienSurvol'].'"></div></div></td></tr>
		<tr><td width="75%" align="right">Couleur liens pied de page visibles</td><td width="25%" align="center"><div id="colorSelector19"><div style="background-color: '.$tdet['lienPiedVisible'].'"></div></div></td></tr>
		<tr><td width="75%" align="right">Couleur liens pied de page actifs</td><td width="25%" align="center"><div id="colorSelector20"><div style="background-color: '.$tdet['lienPiedSurvol'].'"></div></div></td></tr>
		<tr><td colspan="2" align="center"><b>Bouton Navigation</b></td></tr>
		<tr><td width="75%" align="right">Couleur de haut du bouton visible</td><td width="25%" align="center"><div id="colorSelector21"><div style="background-color: '.$tdet['navHautVisible'].'"></div></div></td></tr>
		<tr><td width="75%" align="right">Couleur de bas du bouton visible</td><td width="25%" align="center"><div id="colorSelector22"><div style="background-color: '.$tdet['navBasVisible'].'"></div></div></td></tr>
		<tr><td width="75%" align="right">Couleur du texte du bouton visible</td><td width="25%" align="center"><div id="colorSelector23"><div style="background-color: '.$tdet['lienNavVisible'].'"></div></div></td></tr>
		<tr><td width="75%" align="right">Couleur de haut du bouton actif</td><td width="25%" align="center"><div id="colorSelector24"><div style="background-color: '.$tdet['navHautActif'].'"></div></div></td></tr>
		<tr><td width="75%" align="right">Couleur de bas du bouton actif</td><td width="25%" align="center"><div id="colorSelector25"><div style="background-color: '.$tdet['navBasActif'].'"></div></div></td></tr>
		<tr><td width="75%" align="right">Couleur du texte du bouton visible</td><td width="25%" align="center"><div id="colorSelector26"><div style="background-color: '.$tdet['lienNavSurvol'].'"></div></div></td></tr>
		</table>
		</td><td valign="top">
		<table width="100%" border="0" cellpadding="0px" cellspacing="0px">
		<tr><td width="50px" class="g1" style="background-color: '.$tdet['fond'].'"></td>
			<td>
			<table width="100%" border="0" cellpadding="0px" cellspacing="0px">
				<tr><td align="center" background="../images/css/chmini' . $row['nomfichier'] .'" ><img src="' . $img . '" border="0" width ="' . round($size[0]/2) . '" height="' . round($size[1]/2) . '"  /></td></tr>
				<tr><td align="center" background="../images/css/ccmini' . $row['nomfichier'] .'">
					<table width="200px" border="0" cellspacing="5px">
					<tr><td width="100px" class="btOff" style="background-image: linear-gradient(bottom, '.$tdet['navBasVisible'].' 20%, '.$tdet['navHautVisible'].' 100%);background-image: -o-linear-gradient(bottom, '.$tdet['navBasVisible'].' 20%, '.$tdet['navHautVisible'].' 100%);background-image: -moz-linear-gradient(bottom, '.$tdet['navBasVisible'].' 20%, '.$tdet['navHautVisible'].' 100%);background-image: -webkit-linear-gradient(bottom, '.$tdet['navBasVisible'].' 20%, '.$tdet['navHautVisible'].' 100%);background-image: -ms-linear-gradient(bottom, '.$tdet['navBasVisible'].' 20%, '.$tdet['navHautVisible'].' 100%);"><h4 class="nlv" style="color:'.$tdet['lienNavVisible'].';text-align:center">Lien Visible</h4></td>
					<td width="100px" class="btOn" style="background-image: linear-gradient(bottom, '.$tdet['navBasActif'].' 20%, '.$tdet['navHautActif'].' 100%);background-image: -o-linear-gradient(bottom, '.$tdet['navBasActif'].' 20%, '.$tdet['navHautActif'].' 100%);background-image: -moz-linear-gradient(bottom, '.$tdet['navBasActif'].' 20%, '.$tdet['navHautActif'].' 100%);background-image: -webkit-linear-gradient(bottom, '.$tdet['navBasActif'].' 20%, '.$tdet['navHautActif'].' 100%);background-image: -ms-linear-gradient(bottom, '.$tdet['navBasActif'].' 20%, '.$tdet['navHautActif'].' 100%);"><h4 class="nla" style="color:'.$tdet['lienNavSurvol'].';text-align:center">Lien Actif</h4></td></tr>
					</table>
					<table width="95%" style="margin:10px;" border="0" cellspacing="15px">
						<tr valign="top"><td width="100px" class="col" style="background-color: '.$tdet['fondBoite'].';margin:15px;"><h4 class="t1" style="color:'.$tdet['titreCadre'].'">Titre</h4><div class="txt" style="color:'.$tdet['police'].'">Le texte de la colonne gauche.</div><div class="lv" style="color:'.$tdet['lienVisible'].'">Lien visible</div><div class="la" style="color:'.$tdet['lienSurvol'].'">Lien actif</div></td><td width="250px" class="col" style="background-color: '.$tdet['fondBoite'].'"><h4 class="t1" style="color:'.$tdet['titreCadre'].'">Titre</h4><div class="txt" style="color:'.$tdet['police'].'">Le texte de la partie principale du site internet.</div></td></tr>
						<tr><td></td><td width="250px" class="col" style="background-color: '.$tdet['fondBoite'].'"><h4 class="t1" style="color:'.$tdet['titreCadre'].'">Titre</h4><div class="txt" style="color:'.$tdet['police'].'">Le texte de la partie principale du site internet.</div>
						<div class="bx" style="background-color: '.$tdet['fondBoiteDeux'].';margin:12px;padding:5px;border:3px solid;border-color: '.$tdet['titreCadre'].'">
						<h5 class="t2" style="color: '.$tdet['titreBoiteDeux'].'">Titre boite</h5>
						<div class="dt" style="color: '.$tdet['date'].'">le 15 avril date événement</div>
						<div class="txt" style="color:'.$tdet['police'].'">Encore du texte dans une boite du site internet.</div>
						<div class="lv" style="color:'.$tdet['lienVisible'].'">Lien visible</div>
						<div class="la" style="color:'.$tdet['lienSurvol'].'">Lien actif</div>
						</td></tr>
						<tr><td colspan="2" align="center"><span class="pv" style="color:'.$tdet['lienPiedVisible'].'">Lien pied visible</span>&nbsp;&nbsp;<span class="txt" style="color:'.$tdet['police'].'">|</span>&nbsp;&nbsp;<span class="pa" style="color:'.$tdet['lienPiedSurvol'].'">Lien pied actif</span></td></tr>
					</table>
				</td></tr>';
			echo '</table>
			</td>
		</td></tr>
		<tr><td colspan="2" class="g1" style="background-color: '.$tdet['fond'].';height:40px;"></td></tr>		
		<table width="100%" border="0" cellspacing="5px">
		<tr><td colspan="2" style="height:40px;"></td></tr>
		<tr><td colspan="2" align="center"><b>Options du thème</b></td></tr>
		<tr><td align="right">Souhaitez vous activer la neige sur ce thème ?</td><td>
			<select name="neige">';
			if ($tdet['HasSnow'] == 0) {
				echo '<option selected="selected" value="0">Non</option><option value="1">Oui</option>';
			}else{
				echo '<option value="0">Non</option><option selected="selected" value="1">Oui</option>';				
			}			
			echo '</select></td></tr>
		<tr><td align="right">Souhaitez vous activer ce thème maintenant ?</td><td>
			<select name="activer">';
			if ($tdet['IsOn'] == 0) {
				echo '<option selected="selected" value="0">Non</option><option value="1">Oui</option>';
			}else{
				echo '<option value="0">Non</option><option selected="selected" value="1">Oui</option>';				
			}			
			echo '</select></td></tr>
		<tr valign="top"><td align="right">Nom du thème</td><td><b>' . $tdet['themeNom'] .'</b></td></tr>
		</table>
		</td></tr>
	<tr><td colspan="2" align="center"><input type="submit" name="submit" value="Enregistrer mon thème" title="cliquez ici pour enregistrer votre thème personnalisé" /></td></tr>
	</table>
	<input type="hidden" name="c1" value="'.$tdet['fond'].'" id="c1" />
	<input type="hidden" name="c2" value="'.$tdet['fondBoite'].'" id="c2" />
	<input type="hidden" name="c3" value="'.$tdet['police'].'" id="c3" />
	<input type="hidden" name="c4" value="'.$tdet['titreCadre'].'" id="c4" />
	<input type="hidden" name="c5" value="'.$tdet['fondBoiteDeux'].'" id="c5" />
	<input type="hidden" name="c6" value="'.$tdet['date'].'" id="c6" />
	<input type="hidden" name="c7" value="'.$tdet['titreBoiteDeux'].'" id="c7" />
	<input type="hidden" name="c8" value="'.$tdet['lienVisible'].'" id="c8" />
	<input type="hidden" name="c9" value="'.$tdet['lienSurvol'].'" id="c9" />
	<input type="hidden" name="c10" value="'.$tdet['lienPiedVisible'].'" id="c10" />
	<input type="hidden" name="c11" value="'.$tdet['lienPiedSurvol'].'" id="c11" />
	<input type="hidden" name="b1" value="'.$tdet['navHautVisible'].'" id="b1" />
	<input type="hidden" name="b2" value="'.$tdet['navBasVisible'].'" id="b2" />
	<input type="hidden" name="b3" value="'.$tdet['lienNavVisible'].'" id="b3" />
	<input type="hidden" name="b4" value="'.$tdet['navHautActif'].'" id="b4" />
	<input type="hidden" name="b5" value="'.$tdet['navBasActif'].'" id="b5" />
	<input type="hidden" name="b6" value="'.$tdet['lienNavSurvol'].'" id="b6" />
	<input type="hidden" value="'.$tdet['themeNom'].'" name="name" />
	<input type="hidden" name="submitcss" value="TRUE" />
	</form>
	</fieldset>';	
?>