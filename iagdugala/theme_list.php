<?php
	/**
	 *	script theme_list.php
	 *
	 *	page principal des theme
	 *
	 */
	
	require('../inclusion/config.inc.php');
	require('../../dugala.inc.php');
	//verifier que l'utilisateur est logge
	redirect_invalid_user();
	$page_title = "Liste de mes thèmes";
	$_SESSION['menuid'] = 8;
	include('../inclusion/admintete.php');
	echo '<h2>Liste de mes thèmes</h2>';
	//nombre d'entrée par pages
	$display = 6;
	//nombre de pages
	if ((isset($_GET['p'])) && (is_numeric($_GET['p']))) {
		$pages = $_GET['p'];
	} else {
		//a determiner
		$q = "SELECT COUNT(id) FROM theme";
		$r = @mysqli_query($dbc, $q);
		$row = mysqli_fetch_array($r, MYSQLI_NUM);
		$records = $row[0];
		if ($records < 1) {
			//pas de commentaires
			echo "<p>Il n'y a aucun thème sur votre système.</p><p>Consultation impossible !</p>";
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
			$order_by = "dateCreer ASC";
			break;
		default :				
			$order_by = "themenom ASC";
			break;
	}
	//requete
	$q = "SELECT theme.id, themenom, DATE_FORMAT(theme.dateCreer, '%d/%m/%Y') AS ladate, HasSnow, heading, IsOn, imageFond FROM theme ORDER BY $order_by LIMIT $start, $display";
	$r = @mysqli_query($dbc, $q);
	echo "<p>Voici la liste des fonds d'écran sur votre site internet.</p>";
	echo '<table width="100%" border="0" cellpadding="0" cellspacing="1">
	<tr bgcolor="#7cf376" valign="top">
	<td width="15%"><b>Nom</b><a href="theme_list.php?sort=n" title="Cliquez ici pour afficher les thèmes par ordre alphab&eacute;tique"><img src="../images/arrdown.jpg" border="0" width="23" height="11" /></a></td>
	<td width="15%"><b>Date création</b><a href="theme_list.php?sort=d" title="Cliquez ici pour afficher les thèmes par ordre date de création"><img src="../images/arrdown.jpg" border="0" width="23" height="11" /></a></td>
	<td width="8%" align="center"><b>Neige</b></td>
	<td align="center"><b>Entête et fond</b></td><td width="8%" align="center"><b>Actif</b></td>
	<td width="8%" align="center"><b>Editer</b></td><td width="8%" align="center"><b>Suppr.</b></td></tr>';
	$bg = '#c8f7ee';
	//affichage des thèmes
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		$sql1 = 'SELECT nomfichier FROM photofond WHERE id = '. $row['imageFond'];
		$r1 = @mysqli_query($dbc, $sql1);
		$row1 = mysqli_fetch_array($r1, MYSQLI_ASSOC);
		if (!empty($row1)){
			$fnom = $row1['nomfichier'];
		}else{
			$fnom = '.jpg';
		}
		$bg = ($bg=='#c8f7ee' ? '#f6f7c8' : '#c8f7ee'); // change la couleur de fond
		echo '<tr bgcolor="' . $bg . '" valign="top">
		<td width="15%">' . $row['themenom'] .  '</td>
		<td width="15%">'. $row['ladate'] . '</td>
		<td width="8%" align="center">';
		if ($row['HasSnow']== 0){
			echo '<a href="addsnow.php?theid=' . $row['id'] . '&act=o" title="Cliquez ici pour activer la neige sur ce thème">Non</a>';
		}else{
			echo '<a href="addsnow.php?theid=' . $row['id'] . '&act=n" title="Cliquez ici pour désactiver la neige sur ce thème">Oui</a>';
		}
		echo '</td>';
		$photo = '../images/css/' . $row['heading'];
		$size = getimagesize($photo);
		echo '<td align="center" background="../images/css/chead' . $fnom .'"><img src="' . $photo . '" border="0" width ="' . round($size[0]/2.5) . '" height="' . round($size[1]/2.5) . '" title="Entête du thème ' . $row['themenom'] . '." alt="Entête du thème ' . $row['themenom']. '." /></td>';
		if ($row['IsOn'] == 1){
			echo '<td width="8%" align="center">Oui</a></td>';
		}else{
			echo '<td width="8%" align="center"><a href="theme_activ.php?theid=' . $row['id'] . '" title="Cliquez ici pour activer ce thème sur le site internet.">Non</a></td>';
		}
		if ($row['id'] !=1){
			echo '<td width="8%" align="center"><a href="theme_modifmain.php?theid=' . $row['id'] . '" title="Cliquez ici pour modifier ce thème.">Editer</a></td>';
			if ($row['IsOn'] != 1){
				//on ne peut pas enlever un fichier actif
				echo '<td width="8%" align="center"><a href="theme_del.php?theid=' . $row['id'] . '" title="Cliquez ici pour supprimer ce thème." onClick="if(confirm(\'Voulez-vous vraiment supprimer ce fond ?\')) return true; else return false;">Suppr.</a></td>';
			}else{
				echo '<td width="8%"></td>';
			}
		}else{
			echo '<td width="8%"></td>
			<td width="8%"></td>';
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
			echo '<a href="theme_list.php?s=' . ($start-$display) . '&p=' . $pages . '&sort=' . $sort . '">Pr&eacute;c&eacute;dent</a>&nbsp;&nbsp;&nbsp;';
		}
		for ($i=1; $i <= $pages; $i++) {
			if ($i != $current_page) {
				echo '<a href="theme_list.php?s=' . (($display*($i-1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a>&nbsp;&nbsp;&nbsp;';
			} else {
				echo $i . '&nbsp;&nbsp;&nbsp;';
			}
		}
		if ($current_page != $pages) {
			echo '<a href="theme_list.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">Suivant</a>';
		}
	}
	echo '<br />';
	include('../inclusion/adminpied.php');
?>