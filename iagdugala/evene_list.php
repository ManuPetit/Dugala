<?php
		/**
		 *	script evene_list.php
		 *
		 *	page listant l'ensemble des événements
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Liste de mes &eacute;v&eacute;nements";
		$_SESSION['menuid'] = 5;
		include('../inclusion/admintete.php');
		require('../../dugala.inc.php');
		echo '<h2>Liste de mes &eacute;v&eacute;nements</h2>';
		
		//faire la requête
		$q ="SELECT DISTINCT evenements.id, evenements.nom_fr AS evene, DATE_FORMAT(evenements.date_evenement,'%d-%m-%Y') AS jour, evenements.date_evenement, evenements.visible, menus.nom_fr as nom,";
		$q .= " menus.file_name AS lpdf FROM evenements LEFT JOIN menus ON evenements.menuid=menus.id WHERE menus.id OR menus.id IS NULL ORDER BY evenements.date_evenement";
		$r = @mysqli_query($dbc,$q);
		if (mysqli_num_rows($r) > 0) {
			//date du jour
			$aujour = time();
			$ladate = date('Y.m.d',$aujour);
			$au_day = date('d',$aujour);
			$au_month = date('m',$aujour);
			$au_year = date('Y',$aujour);
			$au_date = mktime(0,0,0,$au_month,$au_day,$au_year);
			echo '<p>Voici la liste de vos &eacute;v&eacute;nements pr&eacute;sents dans la base de donn&eacute;es.</p> 
			<table width="100%" border="0" cellpadding="3">
			<tr bgcolor="#7cf376"><td width="38%" align="left"><b>Nom de l\'&eacute;v&eacute;nement</b></td><td width="10%" align="center"><b>Date</b></td><td width="20%" align="left"><b>Lien menu</b></td>
			<td width="7%" align="center"><b>Visible</b></td><td width="10%" align="center"><b>Editer</b></td>
			<td width="15%" align="center"><b>Supprimer</b></td></tr>';
			$bg = '#c8f7ee';	
			while($row = mysqli_fetch_array($r,MYSQLI_ASSOC)) {
				$bg = ($bg=='#c8f7ee' ? '#f6f7c8' : '#c8f7ee'); // change la couleur de fond
				echo '<tr bgcolor="' . $bg . '"><td align="left">' . $row['evene'] . '</td>';
				echo '<td align="center">' . $row['jour'] . '</td>';
				if (is_null($row['nom'])) {
					echo '<td align="left">Aucun</td>';
				} else {
					echo '<td align="left"><a href="../menus/'. $row['lpdf'] .'" title="Cliquez ici pour afficher le fichier : ' . $row['lpdf'] . '." target="_new">'  .$row['nom'] .'</a></td>';
				}
				echo '<td align="center">' . $row['visible'] . '</td>';
				if (strtotime($row['date_evenement']) >= $au_date) {
					echo '<td align="center"><a href="evene_mod_main.php?eveneid=' . $row['id'] . '" title="Cliquez ici pour &eacute;diter cet &eacute;v&eacute;nement.">Editer</a></td>';
				} else {
					echo '<td></td>';
				}
				echo '<td align="center"><a href="evene_del_main.php?eveneid=' . $row['id'] . '" title="Cliquez ici pour supprimer cet &eacute;v&eacute;nement." onClick="if(confirm(\'Voulez-vous vraiment supprimer cet &eacute;v&eacute;nement ?\')) return true; else return false;">Supprimer</a></td></tr>';
			}
			echo '</table>';
			echo '<br /><p>Pour visualiser vos menus, vous pouvez vous devez avoir un logiciel capable de lire les fichiers PDF, install&eacute; sur votre ordinateur.</p>';
		} else {
			echo "<p>Il n'y a aucun &eacute;v&eacute;nement enregistr&eacute; dans la base donn&eacute;es.</p>";
		}
		mysqli_close($dbc);
		include('../inclusion/adminpied.php');
?>