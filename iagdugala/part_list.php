<?php
		/**
		 *	script part_list.php
		 *
		 *	page listant l'ensemble des partenaires
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Liste de mes partenaires";
		$_SESSION['menuid'] = 6;
		include('../inclusion/admintete.php');
		require('../../dugala.inc.php');
		echo '<h2>Liste de mes partenaires</h2>';
		
		//faire la requete
		$q = "SELECT id, nom_fr, lien, photo, visible FROM partenaires ORDER BY nom_fr ASC";
		$r = @mysqli_query($dbc, $q);
		if (mysqli_num_rows($r) > 0) {
			echo '<p><p>Voici la liste de vos partenaires pr&eacute;sents dans la base de donn&eacute;es.</p> 
			<table width="100%" border="0" cellpadding="3">
			<tr bgcolor="#7cf376"><td width="25%" align="left"><b>Nom du partenaire</b></td><td width="31%" align="left"><b>Lien</b></td><td width="12%" align="center"><b>Photo</b></td>
			<td width="7%" align="center"><b>Visible</b></td><td width="10%" align="center"><b>Editer</b></td>
			<td width="15%" align="center"><b>Supprimer</b></td></tr>';
			$bg = '#c8f7ee';	
			while ($row=mysqli_fetch_array($r, MYSQLI_ASSOC)) {
				$bg = ($bg=='#c8f7ee' ? '#f6f7c8' : '#c8f7ee'); // change la couleur de fond
				echo '<tr bgcolor="' . $bg . '"><td align="left" valign="top">' . $row['nom_fr'] . '</td>';
				echo '<td align="left" valign="top"><a href="http://' . $row['lien'] . '" title="Cliquez ici pour aller sur le site &quot;http://' . $row['lien'] . '&quot;." target="_blank">' . $row['lien'] . '</a></td>';
				if ($row['photo'] == 'A') {
					echo '<td align="center" valign="top">Aucune</td>';
				} else {
					$image = $row['photo'];
					$piece = explode('.',$image);
					$file = '../images/' . $piece[0] . '_th.' . $piece[1];
					if (file_exists($file)) {
						$size = getimagesize ($file);
						echo '<td align="center"><img src="' . $file . '" alt="image du site : ' . $row['lien'] . '." title="image du site : ' . $row['lien'] . '." border="0" width="' . $size[0]/2 . '" height="' . $size[1]/2 . '" /></td>';
					} else {
						echo '<td align="center" valign="top">Image non pr&eacute;sente sur le serveur</td>';
					}
				}
				//		FIN DE		if ($row['photo'] == 'A')
				echo '<td align="center" valign="top">' . $row['visible'] . '</td>';
				echo '<td align="center" valign="top"><a href="part_mod_main.php?partid=' . $row['id'] . '" title="Cliquez ici pour &eacute;diter ce partenaire.">Editer</a></td>';
				echo '<td align="center" valign="top"><a href="part_del_main.php?partid=' . $row['id'] . '" title="Cliquez ici pour supprimer ce partenaire." onClick="if(confirm(\'Voulez-vous vraiment supprimer ce partenaire ?\')) return true; else return false;">Supprimer</a></td></tr>';
			}
			echo '</table><br />';
		} else {
			echo "<p>Il n'y a aucun partenaire enregistr&eacute; dans la base donn&eacute;es.</p>";
		}
		mysqli_close($dbc);
		include('../inclusion/adminpied.php');
?>