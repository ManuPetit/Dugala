<?php
		/**
		 *	script photo_del.php
		 *
		 *	ce fichier permet de selectionner la photo a supprimer
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		require('../../dugala.inc.php');
			
		$page_title = "Suppression d'une photo";
		$_SESSION['menuid'] = 2;
		include('../inclusion/admintete.php');
		
		//requête
		$q = "SELECT id, fichier FROM photos ORDER BY nom_fr ASC";
		$r = @mysqli_query($dbc,$q);
		if (mysqli_num_rows($r) >0) {
			$menu=array();
			$nom=array();
			while($row=mysqli_fetch_array($r, MYSQLI_ASSOC)) {
				$lid[] = $row['id'];
				$piece = explode('.',$row['fichier']);
				$file[] = '../images/' . $piece[0] . '_th.' . $piece[1];
			}
		} else {
			echo "<h2>Suppression d'une photo</h2><p>Il n'y a aucune photo enregistr&eacute;e dans la base donn&eacute;es.</p><p>Suppression impossible !</p>";
			mysqli_close($dbc);
			include('../inclusion/adminpied.php');
			exit();
		}
		//		FIN DE		if (mysqli_num_rows($r) >0)
		mysqli_close($dbc);
?>
<h2>Suppression d'une photo</h2>
<fieldset><legend>Cliquez sur la photo &agrave; supprimer : </legend>
<br />
<table width="100%" border="0" cellspacing="5" cellpadding="10">
<?php
	echo '<tr>';
	$count=1;
	for ($i=0; $i<count($file); $i++) {
		$size=getimagesize($file[$i]);
		echo '<td width="25%" align="center"><a href="photo_del_main.php?photoid=' . $lid[$i] . '" title="Cliquez sur cette photo pour la supprimer de la base de donn&eacute;es." onClick="if(confirm(\'Voulez-vous vraiment supprimer cette photo ?\')) return true; else return false;">';
		echo '<img src="' . $file[$i] . '" border="0" width="' . round($size[0]/3) . '" height="' . round($size[1]/3) . '" /></a></td>';
		if (($count%4)==0){
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
			echo '<td width="25%"></td><td width="25%"></td><td width="25%"></td></tr>';
		}
		elseif ($count==3)
		{
			echo '<td width="25%"></td><td width="25%"></td></tr>';
		}
		elseif ($count==4)
		{
			echo '<td width="25%"></td></tr>';
		}
		else
		{
			echo '</tr>';
		}
	} else {
		echo '<td colspan="4"></td></tr>';
	}
?>
</table>
<br />
</fieldset>
<br />
<?php
	include('../inclusion/adminpied.php');
?>
		