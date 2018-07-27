<?php
		/**
		 *
		 *		script carte.php
		 *
		 *		page menu
		 *
		 */
		 
		 $menuid = 2;
		 $lang = '_gb'; 
		 include('inclusion/config.inc.php');
		 include('inclusion/sitetete.php');
		 
		 //faire la requete du menu du jour
		 $q = "SELECT * FROM menujour LIMIT 1";
		 $r = @mysqli_query($dbc,$q);
		 if (mysqli_num_rows($r) == 1) {
			 $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
			 $e1 = $row['entre1'];
			 $e2 = $row['entre2'];
			 $p1 = $row['plat1'];
			 $p2 = $row['plat2'];
			 $d1 = $row['dessert1'];
			 $d2 = $row['dessert2'];
			 $px2p = $row['prix2'];
			 $px3p = $row['prix3'];
		 }
?>

<div id="menujour">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr class="haut">
      <td width="100%"></td>
    </tr>
    <tr class="body">
      <td width="100%" align="center">
      <span class="menu"><b>Daily Specials</b></span><br />
<?php
		if ($e1 != 'non') {
			//on a un menu
			echo '<span class="prix">2 courses ' . number_format($px2p, 2, '.', '') . '&euro;<br />3 courses '. number_format($px3p, 2, '.', '') . '&euro;</span><br /><br /><span class="plats">';
			echo $e1 . '<br /><small>ou</small><br />' . $e2 . '<br />- - - - -<br />';
			echo $p1 . '<br /><small>ou</small><br />' . $p2 . '<br />- - - - -<br />';
			echo $d1 . '<br /><small>ou</small><br />' . $d2 . '</span><br />';
		} else {
			echo '<br />Come back soon<br />to find out more on<br />our daily specials...</br />';
		}
?>
      </td>
    </tr>
    <tr class="bas">
      <td width="100%"></td>
    </tr>
  </table>
</div>
<div id="contenu">
  <h3>Our menus...</h3>
<?php 
		$long = 190;
		$show = false;
		//affichage des menus
		include('inclusion/photoslidegb.php');
		//affichage des menus
		$q = "SELECT COUNT(id) FROM menus WHERE visible='Oui'";
		$r = @mysqli_query($dbc, $q);
		$row = mysqli_fetch_array($r, MYSQLI_NUM);
		if ($row[0] <1) {
			if ($show == true) {
				echo '<p>On the right, you can watch some of the dishes made in our restaurant.</p>';
			}
			echo '<p>We have not any menu online as yet..</p><p>Do not hesitate to come back in a few days...</p>';
			echo '<p>Thank you for your understanding...</p>';
		} else {
			if ($show == true) {
				echo '<p>On the right, you can watch some of the dishes made in our restaurant.</p>';
			}
			echo '<p>Find out more about our current menus...</p>';
			$q = "SELECT nom_gb, file_name FROM menus WHERE visible='Oui' AND groupe='Me' ORDER BY nom_fr ASC";
			$r = @mysqli_query($dbc,$q);
			if (mysqli_num_rows($r) >0) {
				if (($show == true) && ($long > 0)) {
					$fwidth = 204;
					$pspace = '<br />';
				} else {
					$fwidth = 484;
					$pspace = '&nbsp;';
				}
				//on retire le fieldset
				$long = $long-76;
				if (mysqli_num_rows($r) == 1) {
					echo '<fieldset style="margin-left:10px;width:' . $fwidth .'px;"><legend><b>Our menu : </b></legend>';
				} else {
					echo '<fieldset style="margin-left:10px;width:' . $fwidth .'px;"><legend><b>Our menus : </b></legend>';
				}
				while ($row=mysqli_fetch_array($r, MYSQLI_ASSOC)) {
					echo '<p><b class="nmenu">' . $row['nom_gb'] . '</b> :' . $pspace .'check it out <a href="menus/' . $row['file_name'] . '" target="_new" title="Click here to see the menu.">';
					echo $row['file_name'] . '</a>.</p>';
					$long = $long - 59;
				}
				echo '</fieldset><br />';
			}
			$q = "SELECT nom_gb, file_name FROM menus WHERE visible='Oui' AND groupe='Ms' ORDER BY nom_fr ASC";
			$r = @mysqli_query($dbc,$q);
			if (mysqli_num_rows($r) >0) {
				if (($show == true) && ($long > 0)) {
					$fwidth = 204;
					$pspace = '<br />';
				} else {
					$fwidth = 484;
					$pspace = '&nbsp;';
				}
				//on retire le fieldset
				$long = $long-76;
				if (mysqli_num_rows($r) == 1) {
					echo '<fieldset style="margin-left:10px;width:' . $fwidth .'px;"><legend><b>Our special menu : </b></legend>';
				} else {
					echo '<fieldset style="margin-left:10px;width:' . $fwidth .'px;"><legend><b>Our special menus : </b></legend>';
				}
				while ($row=mysqli_fetch_array($r, MYSQLI_ASSOC)) {
					echo '<p><b class="nmenu">' . $row['nom_gb'] . '</b> :' . $pspace .'check it out <a href="menus/' . $row['file_name'] . '" target="_new" title="Click here to see the menu.">';
					echo $row['file_name'] . '</a>.</p>';
					$long = $long - 59;
				}
				echo '</fieldset><br />';
			}
			$q = "SELECT nom_gb, file_name FROM menus WHERE visible='Oui' AND groupe='Ca' ORDER BY nom_fr ASC";
			$r = @mysqli_query($dbc,$q);
			if (mysqli_num_rows($r) >0) {
				if (($show == true) && ($long > 0)) {
					$fwidth = 204;
					$pspace = '<br />';
				} else {
					$fwidth = 484;
					$pspace = '&nbsp;';
				}
				//on retire le fieldset
				$long = $long-76;
				if (mysqli_num_rows($r) == 1) {
					echo '<fieldset style="margin-left:10px;width:' . $fwidth .'px;"><legend><b>Our &quot;A La Carte&quot; menu : </b></legend>';
				} else {
					echo '<fieldset style="margin-left:10px;width:' . $fwidth .'px;"><legend><b>Our &quot;A La Carte&quot; menus : </b></legend>';
				}
				while ($row=mysqli_fetch_array($r, MYSQLI_ASSOC)) {
					echo '<p><b class="nmenu">' . $row['nom_gb'] . '</b> :' . $pspace .'check it out <a href="menus/' . $row['file_name'] . '" target="_new" title="Click here to see the menu.">';
					echo $row['file_name'] . '</a>.</p>';
					$long = $long - 59;
				}
				echo '</fieldset><br />';
			}
			$q = "SELECT nom_gb, file_name FROM menus WHERE visible='Oui' AND groupe='Cb' ORDER BY nom_fr ASC";
			$r = @mysqli_query($dbc,$q);
			if (mysqli_num_rows($r) >0) {
				if (($show == true) && ($long > 0)) {
					$fwidth = 204;
					$pspace = '<br />';
				} else {
					$fwidth = 484;
					$pspace = '&nbsp;';
				}
				//on retire le fieldset
				$long = $long-76;
				if (mysqli_num_rows($r) == 1) {
					echo '<fieldset style="margin-left:10px;width:' . $fwidth .'px;"><legend><b>Our drinks menu : </b></legend>';
				} else {
					echo '<fieldset style="margin-left:10px;width:' . $fwidth .'px;"><legend><b>Our drinks menus : </b></legend>';
				}
				while ($row=mysqli_fetch_array($r, MYSQLI_ASSOC)) {
					echo '<p><b class="nmenu">' . $row['nom_gb'] . '</b> :' . $pspace .'check it out <a href="menus/' . $row['file_name'] . '" target="_new" title="Click here to see the menu.">';
					echo $row['file_name'] . '</a>.</p>';
					$long = $long - 59;
				}
				echo '</fieldset><br />';
			}
		}
?>

  <br />
</div>
<?php
	include('inclusion/sitepied.php');
?>