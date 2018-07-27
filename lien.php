<?php
		/**
		 *
		 *		script lien.php
		 *
		 *		page de liens
		 *
		 */
		 
		 $menuid = 3;
		 $lang = '_fr'; 
		 include('inclusion/config.inc.php');
		 include('inclusion/sitetete.php');
?>
<div id="uncol"><h3>Nos partenaires</h3>

<?php
		//faire la requête
		$q = "SELECT nom_fr, description_fr, lien, photo FROM partenaires WHERE visible='Oui' ORDER BY nom_fr";
		$r = @mysqli_query($dbc, $q);
		if (mysqli_num_rows($r) > 0) {
			echo '<p><p>Nous sommes heureux de vous pr&eacute;senter sur cette page nos partenaires locaux.</p><p>N\'h&eacute;sitez pas &agrave; consulter leurs sites internet...</p>
<br />';
			echo '<table width="100%" align="center" border="0" cellspacing="10"><tr>';
			$count = 1;
			while ($row = mysqli_fetch_array($r,MYSQLI_ASSOC)) {
				echo '<td width="50%" class="part" valign="top">';
				echo '<p><span class="nom">' . $row['nom_fr'] . '<span></p><p>';
				if ($row['photo'] != 'A') {
					//on a une photo
					$piece = explode('.',$row['photo']);
					$lfile = '../images/' . $piece[0] . '_th.' . $piece[1];
					$photo = 'images/' . $lfile;
					$size = getimagesize($photo);
					echo '<img src="' . $photo . '" width="' . $size[0] . '" height="' . $size[1] . '" alt="Image de ' . $row['nom_fr'] . '." title="Image de ' . $row['nom_fr'] . '." class="part"/>';
				}
				echo nl2br($row['description_fr']) . '</p>';
				echo '<a href="http://' . $row['lien'] . '" title="Cliquez ici pour aller sur ' . $row['lien'] .'." target="_new">Allez &agrave; ' . $row['lien'] . '...</a><br /><br /></td>';
				if (($count%2)==0){
					echo "</tr>\n<tr>";
					$count=0;
					$flag=true;
				} else {
					$flag=false;
				}
				$count++;
			}
			if ($flag==false){
				if ($count==2)
				{
					echo '<td width="50%"></td></tr>';
				}
				else
				{
					echo '</tr>';
				}
			}
			echo '</table><br />';
		} else {
			echo '<p>Nous n\'avons pas encore fait de liens vers nos partenaires...</p><br />';
		}		
?>
</div>
<?php
		include('inclusion/sitepied.php');
?>