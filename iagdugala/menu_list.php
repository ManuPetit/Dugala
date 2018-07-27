<?php
		/**
		 *	script menu_list.php
		 *
		 *	page listant l'ensemble des menus et cartes
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Liste de mes menus et cartes";
		$_SESSION['menuid'] = 4;
		include('../inclusion/admintete.php');
		require('../../dugala.inc.php');
		echo '<h2>Liste de mes menus et cartes</h2>';
		
		//retrouver l'ensemble des menus et cartes sur le système
		$q = "SELECT id, nom_fr, file_name, visible, groupe FROM menus ORDER BY groupe ASC, nom_fr ASC";
		$r = @mysqli_query($dbc,$q);
		if (mysqli_num_rows($r) > 0) {
			echo '<p>Voici l\'ensemble des menus pr&eacute;sents dans la base de données : </p>';
			echo '<table width="100%" border="0" cellpadding="3">
			<tr bgcolor="#7cf376"><td width="38%" align="left"><b>Nom du menu</b></td><td width="10%" align="left"><b>Groupe</b></td><td width="20%" align="left"><b>Fichier PDF</b></td>
			<td width="7%" align="center"><b>Visible</b></td><td width="10%" align="center"><b>Editer</b></td>
			<td width="15%" align="center"><b>Supprimer</b></td></tr>';
			$bg = '#c8f7ee';
			while ($row = mysqli_fetch_array($r,MYSQLI_ASSOC)) {
				$bg = ($bg=='#c8f7ee' ? '#f6f7c8' : '#c8f7ee'); // change la couleur de fond
				echo '<tr bgcolor="' . $bg . '"><td align="left">' . $row['nom_fr'] . '</td>';
				echo '<td align="left">';
				if ($row['groupe'] == 'Me') {
					echo 'Menu';
				} else if ($row['groupe'] == 'Ms') {
					echo 'Sp&eacute;ciaux';
				} else if ($row['groupe'] == 'Ca') {
					echo 'Carte';
				} else if ($row['groupe'] == 'Cb') {
					echo 'Boissons';
				}
				echo '</td>';
				echo '<td align="left"><a href="../menus/'. $row['file_name'] .'" title="Cliquez ici pour afficher le fichier : ' . $row['file_name'] . '." target="_new">'  .$row['file_name'] .'</a></td>';
				echo '<td align="center">' . $row['visible'] . '</td>';
				echo '<td align="center"><a href="menu_mod_main.php?menuid=' . $row['id'] . '" title="Cliquez ici pour &eacute;diter ce menu.">Editer</a></td>';
				echo '<td align="center"><a href="menu_del_main.php?menuid=' . $row['id'] . '" title="Cliquez ici pour supprimer ce menu." onClick="if(confirm(\'Voulez-vous vraiment supprimer ce menu ?\')) return true; else return false;">Supprimer</a></td></tr>';
			}
			echo '</table>';
			echo '<br /><p>Pour visualiser vos menus, vous pouvez vous devez avoir un logiciel capable de lire les fichiers PDF, install&eacute; sur votre ordinateur.</p>';
		} else {
			echo "<p>Il n'y a aucun menu dans la base donn&eacute;es.</p>";
		}
		mysqli_close($dbc);
		include('../inclusion/adminpied.php');
?>
				
				