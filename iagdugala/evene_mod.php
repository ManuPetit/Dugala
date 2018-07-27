<?php
		/**
		 *	script evene_mod.php
		 *
		 *	ce fichier permet de selectionner l'evenement à a modifier
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		require('../../dugala.inc.php');
		
		if (isset($_POST['submitted'])) {
			//rediriger
			$url = BASE_ADMIN . 'evene_mod_main.php?eveneid=' . $_POST['ievene'];
			header("Location: $url");
			exit();//quitter le script
		}
		
		$page_title = "Modifier un &eacute;v&eacute;nement";
		$_SESSION['menuid'] = 5;
		include('../inclusion/admintete.php');
		echo '<h2>Modifier un &eacute;v&eacute;nement</h2>';
		
		//fonction de date
		$aujour = time();
		$ladate = date('Y.m.d',$aujour);
		$au_day = date('d',$aujour);
		$au_month = date('m',$aujour);
		$au_year = date('Y',$aujour);
		$au_date = mktime(0,0,0,$au_month,$au_day,$au_year);
		//faire la requete
		$q = "SELECT id, DATE_FORMAT(date_evenement,'%d-%m-%Y') AS jour, nom_fr FROM evenements WHERE date_evenement>='" . $ladate . "' ORDER BY date_evenement";
		$r = @mysqli_query($dbc, $q);
		if (mysqli_num_rows($r) > 0) {
			$eveid=array();
			$evenom=array();
			$evejour=array();
			while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
				$eveid[] = $row['id'];
				$evejour[] = $row['jour'];
				$evenom[] = $row['nom_fr'];
			}
			
		} else {
			echo "<p>Il n'y a aucun &eacute;v&eacute;nement dans la base donn&eacute;es.</p><p>Modification impossible !</p>";
			mysqli_close($dbc);
			include('../inclusion/adminpied.php');
			exit();
		}
		//		FIN DE		if (mysqli_num_rows($r) >0)
		mysqli_close($dbc);
?>		
<p>Veuillez choisir l'&eacute;v&eacute;nement &agrave; modifier dans la liste ci-dessous</p><p><strong>N.B. :</strong> Les &eacute;v&eacute;nements pass&eacute;s, ne sont pas inclus dans cette liste.</p>
<fieldset><legend>Choisissez l'&eacute;v&eacute;nement &agrave; modifier : </legend>
<form action="evene_mod.php" method="post" style="padding-left:100px">
<p><label for="menu"><strong>Selectionnez l'&eacute;v&eacute;nement :</strong></label><br />
<select name="ievene">
<?php
	for ($i=0; $i<count($eveid); $i++) {
		echo '<option value="' . $eveid[$i] . '">Le ' . $evejour[$i] . ' : ' . $evenom[$i] . '</option>';
	}
?>
</select>
</p>
<input type="submit" name="submit" value="Modifier cet &eacute;v&eacute;nement" />
<input type="hidden" name="submitted" value="TRUE" />
</form>
</fieldset>
<br />
<?php
	include('../inclusion/adminpied.php');
?>
		

		
		