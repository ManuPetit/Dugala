<?php
		/**
		 *
		 *		script menus.php
		 *
		 *		page menu
		 *
		 */
		 
		 $menuid = 2;
		 $lang = '_fr'; 
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
      <span class="menu"><b>Formule du jour</b></span><br />
<?php
		if ($e1 != 'non') {
			//on a un menu
			echo '<span class="prix">2 plats ' . number_format($px2p, 2, ',', ' ') . '&euro;<br />3 plats '. number_format($px3p, 2, ',', ' ') . '&euro;</span><br /><br /><span class="plats">';
			echo $e1 . '<br /><small>ou</small><br />' . $e2 . '<br />- - - - -<br />';
			echo $p1 . '<br /><small>ou</small><br />' . $p2 . '<br />- - - - -<br />';
			echo $d1 . '<br /><small>ou</small><br />' . $d2 . '</span><br />';
		} else {
			echo '<br />Revenez bient&ocirc;t<br />pour d&eacute;couvrir notre<br />formule du jour...</br />';
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
  <h3>Nos menus...</h3>
<?php 
		$long = 190;
		$show = false;
		//affichage des menus
		include('inclusion/photoslidefr.php');
		$q = "SELECT COUNT(id) FROM menus WHERE visible='Oui'";
		$r = @mysqli_query($dbc, $q);
		$row = mysqli_fetch_array($r, MYSQLI_NUM);
		if ($row[0] <1) {
			if ($show == true) {
				echo '<p>Vous pouvez d&eacute;couvrir sur votre droite, des plats r&eacute;alis&eacute;s dans notre restaurant.</p>';
			}
			echo '<p>Nous n\'avons pas encore mis de menu en ligne.</p><p>N\'h&eacute;sitez pas &agrave; revenir consulter cette page dans quelques jours...</p>';
			echo '<p>Merci de votre compr&eacute;hension...</p>';
		} else {
			if ($show == true) {
				echo '<p>Vous pouvez d&eacute;couvrir sur votre droite, des plats r&eacute;alis&eacute;s dans notre restaurant.</p>';
			}
			echo '<p>D&eacute;couvrez ici l\'ensemble de nos menus actuels...</p>';
			$q = "SELECT nom_fr, file_name FROM menus WHERE visible='Oui' AND groupe='Me' ORDER BY nom_fr ASC";
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
					echo '<fieldset style="margin-left:10px;width:' . $fwidth .'px;"><legend><b>Notre menu : </b></legend>';
				} else {
					echo '<fieldset style="margin-left:10px;width:' . $fwidth .'px;"><legend><b>Nos menus : </b></legend>';
				}
				while ($row=mysqli_fetch_array($r, MYSQLI_ASSOC)) {
					echo '<p><b class="nmenu">' . $row['nom_fr'] . '</b> :' . $pspace .'T&eacute;l&eacute;charger le menu <a href="menus/' . $row['file_name'] . '" target="_new" title="Cliquez ici pour t&eacute;l&eacute;charger le menu.">';
					echo $row['file_name'] . '</a>.</p>';
					$long = $long - 59;
				}
				echo '</fieldset><br />';
			}
			$q = "SELECT nom_fr, file_name FROM menus WHERE visible='Oui' AND groupe='Ms' ORDER BY nom_fr ASC";
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
					echo '<fieldset style="margin-left:10px;width:' . $fwidth .'px;"><legend><b>Menu sp&eacute;cial : </b></legend>';
				} else {
					echo '<fieldset style="margin-left:10px;width:' . $fwidth .'px;"><legend><b>Nos menus sp&eacute;ciaux : </b></legend>';
				}
				while ($row=mysqli_fetch_array($r, MYSQLI_ASSOC)) {
					echo '<p><b class="nmenu">' . $row['nom_fr'] . '</b> :' . $pspace .'T&eacute;l&eacute;charger le menu <a href="menus/' . $row['file_name'] . '" target="_new" title="Cliquez ici pour t&eacute;l&eacute;charger le menu.">';
					echo $row['file_name'] . '</a>.</p>';
					$long = $long - 59;
				}
				echo '</fieldset><br />';
			}
			$q = "SELECT nom_fr, file_name FROM menus WHERE visible='Oui' AND groupe='Ca' ORDER BY nom_fr ASC";
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
					echo '<fieldset style="margin-left:10px;width:' . $fwidth .'px;"><legend><b>Notre carte : </b></legend>';
				} else {
					echo '<fieldset style="margin-left:10px;width:' . $fwidth .'px;"><legend><b>Nos cartes : </b></legend>';
				}
				while ($row=mysqli_fetch_array($r, MYSQLI_ASSOC)) {
					echo '<p><b class="nmenu">' . $row['nom_fr'] . '</b> :' . $pspace .'T&eacute;l&eacute;charger le menu <a href="menus/' . $row['file_name'] . '" target="_new" title="Cliquez ici pour t&eacute;l&eacute;charger le menu.">';
					echo $row['file_name'] . '</a>.</p>';
					$long = $long - 59;
				}
				echo '</fieldset><br />';
			}
			$q = "SELECT nom_fr, file_name FROM menus WHERE visible='Oui' AND groupe='Cb' ORDER BY nom_fr ASC";
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
					echo '<fieldset style="margin-left:10px;width:' . $fwidth .'px;"><legend><b>Notre carte de boissons : </b></legend>';
				} else {
					echo '<fieldset style="margin-left:10px;width:' . $fwidth .'px;"><legend><b>Nos cartes de boissons : </b></legend>';
				}
				while ($row=mysqli_fetch_array($r, MYSQLI_ASSOC)) {
					echo '<p><b class="nmenu">' . $row['nom_fr'] . '</b> :' . $pspace .'T&eacute;l&eacute;charger le menu <a href="menus/' . $row['file_name'] . '" target="_new" title="Cliquez ici pour t&eacute;l&eacute;charger le menu.">';
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