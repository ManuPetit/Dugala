<?php
		/**
		 *
		 *		script link.php
		 *
		 *		page de lien anglais
		 *
		 */
		 
		 $menuid = 3;
		 $lang = '_gb'; 
		 include('inclusion/config.inc.php');
		 include('inclusion/sitetete.php');
?>
<div id="uncol"><h3>Our partners</h3>

<?php
		//faire la requête
		$q = "SELECT nom_gb, description_gb, lien, photo FROM partenaires WHERE visible='Oui' ORDER BY nom_gb";
		$r = @mysqli_query($dbc, $q);
		if (mysqli_num_rows($r) > 0) {
			echo '<p><p>We are pleased to present you on this page, the different local partners we work with.</p><p>Feel free to go and visit their web site...</p>
<br />';
			echo '<table width="100%" align="center" border="0" cellspacing="10"><tr>';
			$count = 1;
			while ($row = mysqli_fetch_array($r,MYSQLI_ASSOC)) {
				echo '<td width="50%" class="part" valign="top">';
				echo '<p><span class="nom">' . $row['nom_gb'] . '<span></p><p>';
				if ($row['photo'] != 'A') {
					//on a une photo
					$piece = explode('.',$row['photo']);
					$lfile = '../images/' . $piece[0] . '_th.' . $piece[1];
					$photo = 'images/' . $lfile;
					$size = getimagesize($photo);
					echo '<img src="' . $photo . '" width="' . $size[0] . '" height="' . $size[1] . '" alt="Picture from ' . $row['nom_gb'] . '." title="Picture from ' . $row['nom_gb'] . '." class="part"/>';
				}
				echo $row['description_gb'] . '</p>';
				echo '<a href="http://' . $row['lien'] . '" title="Click here to go to ' . $row['lien'] .'." target="_new">Go to ' . $row['lien'] . '...</a><br /><br /></td>';
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
			echo '<p>We have not linked any partner as yet...</p><br />';
		}		
?>
</div>
<?php
		include('inclusion/sitepied.php');
?>