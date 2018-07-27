<?php
		/**
		 *	script mjou_changeplat.php
		 *
		 *	page principal du menu du jour
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Changer les plats de mon menu du jour";
		$_SESSION['menuid'] = 3;
		include('../inclusion/admintete.php');
		require('../../dugala.inc.php');
		include('../inclusion/admin_form_function.inc.php');
		$pla_errors=array();
		
		//retrouver les plats du menu du jour
		$q = "SELECT * FROM menujour LIMIT 1";
		$r = @mysqli_query($dbc,$q);
		if (mysqli_num_rows($r) == 1) {
			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
			$pre_e1 = $row['entre1'];
			$pre_e2 = $row['entre2'];
			$pre_p1 = $row['plat1'];
			$pre_p2 = $row['plat2'];
			$pre_d1 = $row['dessert1'];
			$pre_d2 = $row['dessert2'];
		} else {
			echo '<p>Une erreur s\'est produite. Veuillez contacter l\'administrateur du syst&egrave;me si le probl&egrave;me persiste.</p>';
			mysqli_close($dbc);
			include('../inclusion/admin.pied');
			exit();
		}
		//		FIN DE		if (mysqli_num_rows($r) == 1)
		
		//validation des changements
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (preg_match('/^[a-zA-Z0-9 ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ+;().,:\'-]{3,120}$/u',stripslashes($_POST['entree1']))) {
				$e1 = escape_data($_POST['entree1']);						
			} else {
				$pla_errors['entree1'] = "<br />Un ou plusieurs caract&egrave;res non accept&eacute;s sont dans cette description.";
			}
			
			if (preg_match('/^[a-zA-Z0-9 ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ+;().,:\'-]{3,120}$/u',stripslashes($_POST['entree2']))){
				$e2 = escape_data($_POST['entree2']);
			} else {
				$pla_errors['entree2'] = "<br />Un ou plusieurs caract&egrave;res non accept&eacute;s sont dans cette description.";
			}
		
		
			if (preg_match('/^[a-zA-Z0-9 ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ+;().,:\'-]{3,120}$/u',stripslashes($_POST['plat1']))) {
				$p1 = escape_data($_POST['plat1']);
			} else {
				$pla_errors['plat1'] = "<br />Un ou plusieurs caract&egrave;res non accept&eacute;s sont dans cette description.";
			}
			
			
			if (preg_match('/^[a-zA-Z0-9 ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ+;().,:\'-]{3,120}$/u',stripslashes($_POST['plat2']))) {
				$p2 = escape_data($_POST['plat2']);
			} else {
				$pla_errors['plat2'] = "<br />Un ou plusieurs caract&egrave;res non accept&eacute;s sont dans cette description.";
			}
		
		
			if (preg_match('/^[a-zA-Z0-9 ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ+;().,:\'-]{3,120}$/u',stripslashes($_POST['dessert1']))) {
				$d1 = escape_data($_POST['dessert1']);
			} else {
				$pla_errors['dessert1'] = "<br />Un ou plusieurs caract&egrave;res non accept&eacute;s sont dans cette description.";
			}
			
		
			if (preg_match('/^[a-zA-Z0-9 ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ+;().,:\'-]{3,120}$/u',stripslashes($_POST['dessert2']))) {
				$d2 = escape_data($_POST['dessert2']);
			} else {
				$pla_errors['dessert2'] = "<br />Un ou plusieurs caract&egrave;res non accept&eacute;s sont dans cette description.";
			}
			
			if (empty($pla_errors)) {
				$update=array();//variable de creation du statement
				if ($pre_e1 != $e1){//creation requete
					$update[]= " entre1='" . $e1 . "'";
				}				
				if ($pre_e2 != $e2){//creation requete
					if (empty($update)) {
						$update[] = " entre2='" . $e2 . "'";
					} else {
						$update[] = ", entre2='" . $e2 . "'";
					}
				}
				if ($pre_p1 != $p1){//creation requete
					if (empty($update)) {
						$update[] = " plat1='" . $p1 . "'";
					} else {
						$update[] = ", plat1='" . $p1 . "'";
					}
				}
				if ($pre_p2 != $p2){//creation requete
					if (empty($update)) {
						$update[] = " plat2='" . $p2 . "'";
					} else {
						$update[] = ", plat2='" . $p2 . "'";
					}
				}
				if ($pre_d1 != $d1){//creation requete
					if (empty($update)) {
						$update[] = " dessert1='" . $d1 . "'";
					} else {
						$update[] = ", dessert1='" . $d1 . "'";
					}
				}
				if ($pre_d2 != $d2){//creation requete
					if (empty($update)) {
						$update[] = " dessert2='" . $d2 . "'";
					} else {
						$update[] = ", dessert2='" . $d2 . "'";
					}
				}
				if (!empty($update)) {
					$q = "UPDATE menujour SET";
					for ($i=0; $i<count($update);$i++)
					{
						$q .= $update[$i];
					}
					$q .= " LIMIT 1";
					$r = @mysqli_query($dbc, $q);
					if (mysqli_affected_rows($dbc) == 1) {
						echo '<h2>Changement du menu du jour r&eacute;ussi</h2><p>Vos modifications ont &eacute;t&eacute; r&eacute;alis&eacute;es avec succ&eacute;s.</p>';
						mysqli_close($dbc);
						include('../inclusion/adminpied.php');
						exit();
					} else {
						echo '<h2>Changement du menu du jour abort&eacute;</h2><p>Votre menu du jour n\'a pas pu &ecirc;tre mis &agrave; jour.</p><p>Veuillez recommencer s\'il vous plait.</p><p>
						Si l\'erreur persiste, contactez l\'administrateur du site...</p>';
						mysqli_close($dbc);
						include ('../inclusion/adminpied.php');
						exit();
					}
				} else {
					//aucun changement
					echo '<h2>Aucun changement</h2><p>Vous n\'avez fait aucun chamgement &agrave; votre menu du jour.</p>';
					mysqli_close($dbc);
					include ('../inclusion/adminpied.php');
					exit();
				}
				//		FIN DE		if (!empty($update))
			}
			//		FIN DE		if (empty($pla_errors)) 
			
		}
		//		FIN DE		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		mysqli_close($dbc);
?>
<h2>Changer les plats de mon menu du jour</h2>
<fieldset><legend>Modifiez les plats selon votre choix : </legend>
<form action="mjou_changeplat.php" method="post" accept-charset="utf-8" style="padding-left:100px">
<p><label for="entree1"><strong>Premi&egrave;re entr&eacute;e :</strong></label><br />
<?php create_form_edit('entree1','text',$pla_errors,80,120,$pre_e1); ?>
<br /><small>Si vous ne voulez pas afficher votre menu du jour, tapez &quot;non&quot; comme premier plat</small>
</p>
<p><label for="entree2"><strong>Deuxi&egrave;me entr&eacute;e :</strong></label><br />
<?php create_form_edit('entree2','text',$pla_errors,80,120,$pre_e2); ?>
</p>
<p><label for="plat1"><strong>Premier plat :</strong></label><br />
<?php create_form_edit('plat1','text',$pla_errors,80,120,$pre_p1); ?>
</p>
<p><label for="plat2"><strong>Deuxi&egrave;me plat :</strong></label><br />
<?php create_form_edit('plat2','text',$pla_errors,80,120,$pre_p2); ?>
</p>
<p><label for="dessert1"><strong>Premier dessert :</strong></label><br />
<?php create_form_edit('dessert1','text',$pla_errors,80,120,$pre_d1); ?>
</p>
<p><label for="dessert2"><strong>Deuxi&egrave;me dessert :</strong></label><br />
<?php create_form_edit('dessert2','text',$pla_errors,80,120,$pre_d2); ?></p>
<input type="submit" name="submit" value="Valider les modifications" />
</form>
</fieldset>
<?php
	include('../inclusion/adminpied.php');
?>

			