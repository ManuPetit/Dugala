<?php
		/**
		 *	script mjou_changeprix.php
		 *
		 *	page principal du menu du jour
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Changer les prix de mon menu du jour";
		$_SESSION['menuid'] = 3;
		include('../inclusion/admintete.php');
		require('../../dugala.inc.php');
		include('../inclusion/admin_form_function.inc.php');
		$prx_errors=array();
		
		//retrouver les plats du menu du jour
		$q = "SELECT prix2, prix3 FROM menujour LIMIT 1";
		$r = @mysqli_query($dbc,$q);
		if (mysqli_num_rows($r) == 1) {
			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
			$pre_p1 = str_replace('.',',',$row['prix2']);
			$pre_p2 = str_replace('.',',',$row['prix3']);
		} else {
			echo '<p>Une erreur s\'est produite. Veuillez contacter l\'administrateur du syst&egrave;me si le probl&egrave;me persiste.</p>';
			mysqli_close($dbc);
			include('../inclusion/admin.pied');
			exit();
		}
		//		FIN DE		if (mysqli_num_rows($r) == 1)
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if ((isset($_POST['prix1']) && (trim($_POST['prix1']) != ''))) {
				$pp1 = str_replace(',','.',escape_data($_POST['prix1']));
				if (preg_match('/^\d*\.?\d*$/',$pp1)) {
					$p1 = $pp1;
				} else {
					$prx_errors['prix1'] = "Veuillez entrer une valeur num&eacute;rique correcte.";
				}
			} else {
				$prx_errors['prix1'] = "Veuillez entrer une valeur num&eacute;rique.";
			}
			//		FIN DE		if ((isset($_POST['prix1']) && (trim($_POST['prix1']) != '')))
			if ((isset($_POST['prix2']) && (trim($_POST['prix2']) != ''))) {
				$pp2 = str_replace(',','.',escape_data($_POST['prix2']));
				if (preg_match('/^\d*\.?\d*$/',$pp2)) {
					$p2 = $pp2;
				} else {
					$prx_errors['prix2'] = "Veuillez entrer une valeur num&eacute;rique correcte.";
				}
			} else {
				$prx_errors['prix2'] = "Veuillez entrer une valeur num&eacute;rique.";
			}
			//		FIN DE		if ((isset($_POST['prix2']) && (trim($_POST['prix2']) != '')))
			if (empty($prx_errors)) {
				$update=array();
				//vérification pour preparer la requete
				if (str_replace(',','.',$pre_p1) != $p1) {
					$update[] = " prix2=" . $p1;
				}
				if (str_replace(',','.',$pre_p2) != $p2) {
					if (empty($update)) {
						$update[] = " prix3=" . $p2;
					} else {
						$update[] = ", prix3=" . $p2;
					}
				}
				if (!empty($update)) {
					//créer la requete
					$q = "UPDATE menujour SET";
					for ($i=0; $i<count($update); $i++)
					{
						$q .= $update[$i];
					}
					$q .= " LIMIT 1";
					$r = mysqli_query($dbc, $q);
					if (mysqli_affected_rows($dbc) == 1) {
						echo '<h2>Changement des prix du menu du jour r&eacute;ussi</h2><p>Vos modifications ont &eacute;t&eacute; r&eacute;alis&eacute;es avec succ&eacute;s.</p>';
						mysqli_close($dbc);
						include('../inclusion/adminpied.php');
						exit();
					} else {
						echo '<h2>Changement des prix du menu du jour abort&eacute;</h2><p>Les prix de votre menu du jour n\'ont pas pu &ecirc;tre mis &agrave; jour.</p><p>Veuillez recommencer s\'il vous plait.</p><p>
						Si l\'erreur persiste, contactez l\'administrateur du site...</p>';
						mysqli_close($dbc);
						include ('../inclusion/adminpied.php');
						exit();
					}
				} else {
					//aucun changement
					echo '<h2>Aucun changement</h2><p>Vous n\'avez fait aucun chamgement &agrave; aux prix de votre menu du jour.</p>';
					mysqli_close($dbc);
					include ('../inclusion/adminpied.php');
					exit();
				}
				//		FIN DE		if (!empty($update))
			}
			//		FIN DE		if (empty($prx_errors))
		}
		//		FIN DE		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		mysqli_close($dbc);
?>
<h2>Changer les prix de mon menu du jour</h2>
<fieldset><legend>Modifiez les prix de votre menu du jour selon votre choix : </legend>
<form action="mjou_changeprix.php" method="post" accept-charset="utf-8" style="padding-left:100px">
<p><label for="prix1"><strong>Prix pour 2 plats :</strong></label><br />
<?php create_form_edit('prix1','text',$prx_errors,10,6,$pre_p1); ?>
</p>
<p><label for="prix2"><strong>Prix pour 3 plats :</strong></label><br />
<?php create_form_edit('prix2','text',$prx_errors,10,6,$pre_p2); ?>
</p>
<input type="submit" name="submit" value="Valider les modifications" /><br />
<p><strong>Attention : </strong>Il n'est pas n&eacute;cessaire de mettre le signe &quot;<strong>&euro;</strong>&quot; dans le prix.</p>
</form>
</fieldset>
<?php
	include('../inclusion/adminpied.php');
?>

			