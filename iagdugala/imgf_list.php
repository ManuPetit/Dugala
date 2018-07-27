<?php		
	//		imgf_list.php
	//		list les images de fond sur le systeme
	
	require('../inclusion/config.inc.php');
	require('../../dugala.inc.php');
	//verifier que l'utilisateur est logge
	redirect_invalid_user();
	$page_title = "Liste des images de fond";
	$_SESSION['menuid'] = 8;
	//retrouver les différents fond d'écran
	include('../inclusion/admintete.php');
	echo '<h2>Liste des images de fond</h2>';
	//nombre d'entrée par pages
	$display = 6;
	//nombre de pages
	if ((isset($_GET['p'])) && (is_numeric($_GET['p']))) {
		$pages = $_GET['p'];
	} else {
		//a determiner
		$q = "SELECT COUNT(id) FROM photofond";
		$r = @mysqli_query($dbc, $q);
		$row = mysqli_fetch_array($r, MYSQLI_NUM);
		$records = $row[0];
		if ($records < 1) {
			//pas de commentaires
			echo "<p>Il n'y a aucun fond d'écran sur votre système.</p><p>Consultation impossible !</p>";
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
	//preparation du sort
	//par default c'est la date
	$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'n';
	//faire le sorting
	switch($sort){
		case 'd':
			$order_by = "datecreer ASC";
			break;
		default :				
			$order_by = "nom ASC";
			break;
	}
	//requete
	$q = "SELECT id, nom, DATE_FORMAT(datecreer, '%d/%m/%Y') AS ladate, IsActive,nomThumb FROM photofond ORDER BY $order_by LIMIT $start, $display";
	$r = @mysqli_query($dbc, $q);
	echo "<p>Voici la liste des fonds d'écran sur votre site internet.</p>";
	echo '<table width="100%" border="0" cellpadding="0" cellspacing="1">
	<tr bgcolor="#7cf376" valign="top">
	<td width="28%" align="left"><b>Nom</b><a href="imgf_list.php?sort=n" title="Cliquez ici pour afficher les fonds par ordre alphab&eacute;tique"><img src="../images/arrdown.jpg" border="0" width="23" height="11" /></a>
	<td width="20%" align="left"><b>Date création</b><a href="imgf_list.php?sort=d" title="Cliquez ici pour afficher les fonds par ordre date de création"><img src="../images/arrdown.jpg" border="0" width="23" height="11" /></a>
	<td width="10%" align="center"><b>Actif</b></td>
	<td align="center"><b>Image</td>
	<td width="12%" align="center"><b>Suppr.</b></td>
	</tr>';
	$bg = '#c8f7ee';
	//affichage des fonds
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		$bg = ($bg=='#c8f7ee' ? '#f6f7c8' : '#c8f7ee'); // change la couleur de fond
		echo '<tr bgcolor="' . $bg . '" valign="top">
		<td width="28%">' . $row['nom'] . '</td>
		<td width="20%">' . $row['ladate'] . '</td>
		<td width="10%" align="center">';
		if ($row['IsActive'] == 0){
			echo '<a href="actiimgf.php?imgid=' . $row['id'] . '" title="Cliquez ici pour activer ce fond d\'écran sur le site internet.">Non</a>';
		}else{
			echo 'Oui';
		}
		$image = $row['nomThumb'];
		$piece = explode('.',$image);
		$photo = '../images/' . $piece[0] . '_th.' . $piece[1];
		$size = getimagesize($photo);
		echo '<td align="center"><img src="' . $photo . '" border="0" width ="' . round($size[0]/2) . '" height="' . round($size[1]/2) . '" title="fond d\'écran : ' . $row['nom'] . '." alt="fond d\'écran : ' . $row['nom'] . '." /></td>';
		if (($row['IsActive'] == 0) && ($row['id'] != 1)){
			echo '<td width="12%" align="center"><a href="delimgf.php?imgid=' . $row['id'] . '" title="Cliquez ici pour supprimer définitevement ce fond d\'écran de votre site internet." onClick="if(confirm(\'Voulez-vous vraiment supprimer ce fond ?\')) return true; else return false;">Suppr.</a></td>';
		}else{
			echo '<td width="12%"></td>';
		}
		echo '</tr>';
	}
	
	echo '</table>';
		mysqli_close($dbc);
		//faire les liens vers les autres pages
		if ($pages > 1) {
			echo '<br /><p>';
			$current_page = ($start/$display)+1;
			if ($current_page != 1) {
				echo '<a href="imgf_list.php?s=' . ($start-$display) . '&p=' . $pages . '&sort=' . $sort . '">Pr&eacute;c&eacute;dent</a>&nbsp;&nbsp;&nbsp;';
			}
			for ($i=1; $i <= $pages; $i++) {
				if ($i != $current_page) {
					echo '<a href="imgf_list.php?s=' . (($display*($i-1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a>&nbsp;&nbsp;&nbsp;';
				} else {
					echo $i . '&nbsp;&nbsp;&nbsp;';
				}
			}
			if ($current_page != $pages) {
				echo '<a href="imgf_list.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">Suivant</a>';
			}
		}
		echo '<br />';
		include('../inclusion/adminpied.php');
?>