<?php
		/**
		 *
		 *	script livre_list.php
		 *
		 *	liste tous les commentaires du livre d'or
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Liste des commentaires de mon livre d'or";
		$_SESSION['menuid'] = 7;
		include('../inclusion/admintete.php');
		require('../../dugala.inc.php');
		echo '<h2>Liste des commentaires de mon livre d\'or</h2>';
		
		//nombre d'entrée par pages
		$display = 6;
		//nombre de pages
		if ((isset($_GET['p'])) && (is_numeric($_GET['p']))) {
			$pages = $_GET['p'];
		} else {
			//a determiner
			$q = "SELECT COUNT(id) FROM livres";
			$r = @mysqli_query($dbc, $q);
			$row = mysqli_fetch_array($r, MYSQLI_NUM);
			$records = $row[0];
			if ($records < 1) {
				//pas de commentaires
				echo "<p>Il n'y a aucun commentaire dans votre livre d'or.</p><p>Consultation impossible !</p>";
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
		$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'rd';
		
		//faire le sorting
		switch ($sort) {
			case 'pra' :
				$order_by = "prenom ASC";
				break;
			case 'prd' :
				$order_by = "prenom DESC";
				break;
			case 'noa' :
				$order_by = "nom ASC";
				break;
			case 'nod' :
				$order_by = "nom DESC";
				break;
			case 'daa' :
				$order_by = "date_created ASC";
				break;
			case 'dad' :
				$order_by = "date_created DESC";
				break;
			default :
				$order_by = "date_created ASC";
				break;
		}
		//requete
		$q = "SELECT id, prenom, nom, email, commentaire, ville, pays, telephone, DATE_FORMAT(date_created, '%d/%m/%Y') as ladate FROM livres ORDER BY $order_by LIMIT $start, $display";
		$r = @mysqli_query($dbc, $q);
		echo "<p>Voici la liste des commentaires de votre livre d'or.</p>";
		echo '<table width="100%" border="0" cellpadding="0" cellspacing="1">
		<tr bgcolor="#7cf376">
		<td width="13%" align="left"><b>Pr&eacute;nom</b><a href="livre_list.php?sort=prd" title="Cliquez ici pour afficher les pr&eacute;noms par ordre alphab&eacute;tique invers&eacute;."><img src="../images/arrdown.jpg" border="0" width="23" height="11" /></a>
		<a href="livre_list.php?sort=pra" title="Cliquez ici pour afficher les pr&eacute;noms par ordre alphab&eacute;tique."><img src="../images/arrup.jpg" border="0" width="23" height="11" /></a></td>
		<td width="13%" align="left"><b>Nom</b><a href="livre_list.php?sort=nod" title="Cliquez ici pour afficher les noms par ordre alphab&eacute;tique invers&eacute;."><img src="../images/arrdown.jpg" border="0" width="23" height="11" /></a>
		<a href="livre_list.php?sort=noa" title="Cliquez ici pour afficher les noms par ordre alphab&eacute;tique."><img src="../images/arrup.jpg" border="0" width="23" height="11" /></a></td>
		<td width="15%" align="left"><b>Email</b></td>
		<td align="left"><b>Commentaires</b></td>
		<td width="11%" align="left"><b>Localisation</b></td>
		<td width="10%" align="center"><b>Date</b><a href="livre_list.php?sort=dad" title="Cliquez ici pour classer les commentaires en partant du plus r&eacute;cent."><img src="../images/arrdown.jpg" border="0" width="23" height="11" /></a>
		<a href="livre_list.php?sort=daa" title="Cliquez ici pour pour classer les commentaires en partant du plus ancien."><img src="../images/arrup.jpg" border="0" width="23" height="11" /></a></td>
		<td width="10%" align="center"><b>Supprimer</b></td></tr>';
		$bg = '#c8f7ee';
		//affichage des commentaires
		while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
			$bg = ($bg=='#c8f7ee' ? '#f6f7c8' : '#c8f7ee'); // change la couleur de fond
			echo '<tr bgcolor="' . $bg . '">
			<td align="left" valign="top">' . $row['prenom'] . '</td>
			<td align="left" valign="top">' . $row['nom'] . '</td>
			<td align="left" valign="top">' . $row['email'] . '</td>
			<td align="left" valign="top">';
			//faire racourci commentaire si nécessaire
			if (strlen($row['commentaire']) > 120) {
				$com = substr($row['commentaire'],0,120) . '...<br />';
				$lien = '<a href="#" onclick="window.open(\'com_com.php?comid=' . $row['id'] .'\',\'Commentaire\',\'top=0,left=0,width=630,height=620,toolbar=no,menubar=no,location=no,directories=no,scrollbars=yes,resizable=yes\');window.event.cancelBubble=true;window.event.returnValue=false;" title="Cliquez ici pour voir le commentaire en entier">Lire la suite...</a>';
				$com .= $lien;
			} else {
				$com = $row['commentaire'];
			}
			echo $com . '</td>';
			//vérification du  lieu
			$lieu = NULL;
			if ($row['ville'] != '0a') {
				$lieu = $row['ville'];
			}
			if ($row['pays'] != '0a') {
				if (isset($lieu)) {
					$lieu .= '(' . $row['pays'] . ')';
				} else {
					$lieu = $row['pays'];
				}
			} else {
				$lieu = 'Inconnue';
			}
			if ($row['telephone'] != 'x') {
				$lieu .= '<br />' . $row['telephone'];
			}
			echo '<td align="left" valign="top">' . $lieu . '</td>
			<td align="center" valign="top">' . $row['ladate'] . '</td>
			<td align="center" valign="top"><a href="livre_del_main.php?comid=' . $row['id'] . '" title="Cliquez ici pour supprimer ce commentaire." onClick="if(confirm(\'Voulez-vous vraiment supprimer ce commentaire ?\')) return true; else return false;">Supprimer</a></td></tr>';
		}
		//		FIN DE		while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))
		echo '</table>';
		mysqli_close($dbc);
		//faire les liens vers les autres pages
		if ($pages > 1) {
			echo '<br /><p>';
			$current_page = ($start/$display)+1;
			if ($current_page != 1) {
				echo '<a href="livre_list.php?s=' . ($start-$display) . '&p=' . $pages . '&sort=' . $sort . '">Pr&eacute;c&eacute;dent</a>&nbsp;&nbsp;&nbsp;';
			}
			for ($i=1; $i <= $pages; $i++) {
				if ($i != $current_page) {
					echo '<a href="livre_list.php?s=' . (($display*($i-1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a>&nbsp;&nbsp;&nbsp;';
				} else {
					echo $i . '&nbsp;&nbsp;&nbsp;';
				}
			}
			if ($current_page != $pages) {
				echo '<a href="livre_list.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">Suivant</a>';
			}
		}
		echo '<br />';
		include('../inclusion/adminpied.php');
?>