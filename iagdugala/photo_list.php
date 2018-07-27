<?php
		/**
		 *	script photo_list.php
		 *
		 *	page listant l'ensemble des photos
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Liste de mes photos";
		$_SESSION['menuid'] = 2;
		include('../inclusion/admintete.php');
		require('../../dugala.inc.php');
		echo '<h2>Liste de mes photos</h2>';
		
		//requete
		$q = "SELECT id, nom_fr, fichier, visible FROM photos ORDER BY nom_fr ASC";
		$r = @mysqli_query($dbc,$q);
		if (mysqli_num_rows($r) > 0) {
			echo '<p><p>Voici la liste de vos photos pr&eacute;sentes dans la base de donn&eacute;es.</p> 
			<table width="100%" border="0" cellpadding="3">
			<tr bgcolor="#7cf376"><td width="45%" align="left"><b>L&eacute;gende de la photo</b></td><td width="20%" align="center"><b>Photo</b></td>
			<td width="10%" align="center"><b>Visible</b></td><td width="10%" align="center"><b>Editer</b></td>
			<td width="15%" align="center"><b>Supprimer</b></td></tr>';
			$bg = '#c8f7ee';	
			while ($row=mysqli_fetch_array($r, MYSQLI_ASSOC)) {
				$bg = ($bg=='#c8f7ee' ? '#f6f7c8' : '#c8f7ee'); // change la couleur de fond
				echo '<tr bgcolor="' . $bg . '"><td align="left" valign="top">';
				if ($row['nom_fr'] == 'Photo_Aucune') {
					echo 'Sans l&eacute;gende';
				} else {
					echo $row['nom_fr'];
				}
				echo '</td>';
				$image = $row['fichier'];
				$piece = explode('.',$image);
				$photo = '../images/' . $piece[0] . '_th.' . $piece[1];
				$size = getimagesize($photo);
				echo '<td align="center"><img src="' . $photo . '" border="0" width ="' . round($size[0]/3) . '" height="' . round($size[1]/3) . '" title="Photo num&eacute;ro : ' . $row['id'] . '." alt="Photo num&eacute;ro : ' . $row['id'] . '." /></td>';
				echo '<td align="center" valign="top">' . $row['visible'] . '</td>';
				echo '<td align="center" valign="top"><a href="photo_mod_main.php?photoid=' . $row['id'] . '" title="Cliquez ici pour &eacute;diter cette photo.">Editer</a></td>';
				echo '<td align="center" valign="top"><a href="photo_del_main.php?photoid=' . $row['id'] . '" title="Cliquez ici pour supprimer cette photo." onClick="if(confirm(\'Voulez-vous vraiment supprimer cette photo ?\')) return true; else return false;">Supprimer</a></td></tr>';
			}
			echo '</table><br />';
		} else {
			echo "<p>Il n'y a aucune photo dans la base de donn&eacute;es.</p>";
		}
		include('../inclusion/adminpied.php');
?>
			
