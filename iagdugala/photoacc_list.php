<?php		
	//		photoacc_list.php
	//		list les images d'accueil sur le systeme
	
	require('../inclusion/config.inc.php');
	require('../../dugala.inc.php');
	//verifier que l'utilisateur est logge
	redirect_invalid_user();
	$page_title = "Liste des photos de la page d'accueil";
	$_SESSION['menuid'] = 2;
	include('../inclusion/admintete.php');
	echo '<h2>Liste des photos de la page d\'accueil</h2>';
	//nombre d'entrée par pages
	$display = 6;
	//nombre de pages
	if ((isset($_GET['p'])) && (is_numeric($_GET['p']))) {
		$pages = $_GET['p'];
	} else {
		//a determiner
		$q = "SELECT COUNT(id) FROM photoopen";
		$r = @mysqli_query($dbc, $q);
		$row = mysqli_fetch_array($r, MYSQLI_NUM);
		$records = $row[0];
		if ($records < 1) {
			//pas de commentaires
			echo "<p>Il n'y a aucune nouvelle image d'accueil sur votre système.</p><p>Consultation impossible !</p>";
			mysqli_close($dbc);
			include('../inclusion/adminpied.php');
			exit();
		} else {
			//calculer le nombre de page
			if ($records > $display) {
				//plus d'une page
				$pages = ceil($records/$display);
			} else {
				$pages = 1;
			}
		}
	}
	//		FIN DE		if ((isset($_GET['p'])) && (is_numeric($_GET['p']))
	//on regarde ou on commence dans la base de données
	if ((isset($_GET['s'])) && (is_numeric($_GET['s']))) {
		$start = $_GET['s'];
	} else {
		$start = 0;
	}
	//requete
	$q = "SELECT id, fichier, desc_fr, IsShowing, DATE_FORMAT(datecreer, '%d/%m/%Y') AS ladate FROM photoopen ORDER BY datecreer LIMIT $start, $display";
	$r = @mysqli_query($dbc, $q);
	echo "<p>Voici la liste des image de page d'accueil présentes dans la base de données.</p>";
	echo '<table width="100%" border="0" cellpadding="0" cellspacing="1">
	<tr bgcolor="#7cf376" valign="top">
	<td width="40%" align="left"><b>Nom</b></td>
	<td width="20%" align="center"><b>Image</b></td>
	<td width="10%" align="center"><b>Actif</b></td>
	<td width="20%" align="center"><b>Date créé</b></td>
	<td width="10%" align="center"><b>Suppr.</b></td>
	</tr>';
	$bg = '#c8f7ee';
	//affichage des fonds
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		$bg = ($bg=='#c8f7ee' ? '#f6f7c8' : '#c8f7ee'); // change la couleur de fond
		echo '<tr bgcolor="' . $bg . '" valign="top">
		<td width="40%" align="left">'. $row['desc_fr'] . '</td>
		<td width="20%" align="center">';
		$image = $row['fichier'];
		$piece = explode('.',$image);
		$photo = '../images/' . $piece[0] . '_th.' . $piece[1];
		$size = getimagesize($photo);
		echo '<img src="'.$photo.'" border="0" width ="' . round($size[0]/2) . '" height="' . round($size[1]/2) . '" /></td>
		<td width="10%" align="center">';
		if ($row['IsShowing'] == 1){
			echo 'Oui';
		}else{
			echo '<a href="actipacc.php?imgid=' . $row['id'] . '" title="Cliquez ici pour activer cette image sur votre page d\'accueil.">Non</a>';
		}
		echo '<td width="20%" align="center">'.$row['ladate'].'</td>
		<td width="10%" align="center">';
		if ($row['IsShowing'] == 0){
			echo '<a href="delpacc.php?imgid=' . $row['id'] . '" title="Cliquez ici pour supprimer définitevement cette image de votre site internet." onClick="if(confirm(\'Voulez-vous vraiment supprimer cette image ?\')) return true; else return false;">Suppr.</a>';
		}
		echo '</td>
		</tr>';
	}
	echo '</table>';
	include('../inclusion/adminpied.php');
?>