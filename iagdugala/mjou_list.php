<?php
		/**
		 *	script mjour_list.php
		 *
		 *	page principal du menu du jour
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "D&eacute;tails de mon menu du jour";
		$_SESSION['menuid'] = 3;
		include('../inclusion/admintete.php');
		require('../../dugala.inc.php');
		echo '<h2>D&eacute;tails actuels de mon menu du jour</h2>';
		
		//retrouver les détails du menu
		$q = "SELECT * FROM menujour LIMIT 1";
		$r = @mysqli_query($dbc,$q);
		if (mysqli_num_rows($r) == 1) {
			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
			echo '<table border="1" cellpadding="5" cellspacing="5" width="90%">
			<tr><td width="20%" align="left">Entr&eacute;e 1</td><td width="80%" align="left">' . $row['entre1'] . '</td></tr>';
			echo '<tr><td width="20%" align="left">Entr&eacute;e 2</td><td width="80%" align="left">' . $row['entre2'] . '</td></tr>';
			echo '<tr><td width="20%" align="left">Plat 1</td><td width="80%" align="left">' . $row['plat1'] . '</td></tr>';
			echo '<tr><td width="20%" align="left">Plat 2</td><td width="80%" align="left">' . $row['plat2'] . '</td></tr>';
			echo '<tr><td width="20%" align="left">Dessert 1</td><td width="80%" align="left">' . $row['dessert1'] . '</td></tr>';
			echo '<tr><td width="20%" align="left">Dessert 2</td><td width="80%" align="left">' . $row['dessert2'] . '</td></tr>';
			echo '<tr><td width="20%" align="left">Prix 2 plats</td><td width="80%" align="left">' . number_format($row['prix2'],2,',',' ') . '&euro;</td></tr>';
			echo '<tr><td width="20%" align="left">Prix 3 plats</td><td width="80%" align="left">' . number_format($row['prix3'],2,',',' ') . '&euro;</td></tr>
			</table>';
		} else {
			echo "Une erreur s'est produite. Si le probl&egrave;me persite, veuillez contacter l'administrateur du syst&egrave;me.";
		}
		mysqli_close($dbc);
		//		FIN DE		if (mysqli_num_rows($r) == 1)
		include('../inclusion/adminpied.php');
?>
		
			
			