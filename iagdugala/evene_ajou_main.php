<?php
		/**
		 *	script evene_ajou_main.php
		 *
		 *	page d'ajout de l'événement
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		
		//on verifie si une date est passée
		if ((isset($_GET['ladate'])) && (!is_null($_GET['ladate'])))
		{
			$ladate = $_GET['ladate'];
		} else if ((isset($_POST['ladate'])) && (!is_null($_POST['ladate']))) {
			$ladate = $_POST['ladate'];
		}
		else
		{
			//pas de date on retourne à l'index
			$url = 'evene.php';
			header("Location: $url");
			exit();//quitter le script
		}
		
		$page_title = "Ajouter un &eacute;v&eacute;nement";
		$_SESSION['menuid'] = 5;
		include('../inclusion/admintete.php');
		include('../inclusion/admin_form_function.inc.php');
		require('../../dugala.inc.php');
		echo '<h2>Ajouter un &eacute;v&eacute;nement</h2>';
		$eve_errors=array();
		//variable
		$menu=array();
		$count=0;
		
		//preparer les variables du jour
		$lejour = get_jour($ladate);
		$jour = date('d',$ladate);
		$lemois = get_mois($ladate);
		$annee = date('Y',$ladate);
		$date_comp = 'le ' . $lejour . ' ' . $jour . ' ' . $lemois . ' ' . $annee;
		
		//retrouver les menus speciaux
		$q = "SELECT id, nom_fr FROM menus WHERE groupe='Ms' AND visible='Oui' ORDER BY nom_fr ASC";
		$r = @mysqli_query($dbc,$q);
		if (mysqli_num_rows($r) > 0) {
			while ($row = mysqli_fetch_array($r,MYSQLI_ASSOC)) {
				$menu[$count] = array('id' => $row['id'], 'menufr' => $row['nom_fr']);
				$count++;
			}
		}
		
		if (isset($_POST['submission'])) {
			//validation des entrées
			if (preg_match('/^[^<>"]{4,80}$/u',stripslashes($_POST['nomfr']))) {
				$nfr = escape_data($_POST['nomfr']);
			} else {
				$eve_errors['nomfr'] = "<br />Certains caract&egrave;res ne sont pas accept&eacute;s. Veuillez corriger.";
			}
			if (trim($_POST['nomgb']) == '') {
				//on prend la traduction française
				if (isset($nfr)) {
					$ngb = $nfr;
					$_POST['nomgb'] = $nfr;
				} else {
					$eve_errors['nomgb'] = "<br />En attente de correction du nom fran&ccedil;ais.";
				}
			} else if (preg_match('/^[^<>"]{4,80}$/u',stripslashes($_POST['nomgb']))) {
				$ngb = escape_data($_POST['nomgb']);
			} else {
				$eve_errors['nomgb'] = "<br />Certains caract&egrave;res ne sont pas accept&eacute;s. Veuillez corriger.";
			}
			if (preg_match('/^[^<>"]{6,10000}$/u',stripslashes($_POST['desfr']))) {
				$dfr = escape_data($_POST['desfr']);
			} else {
				$eve_errors['desfr'] = "<br />Certains caract&egrave;res ne sont pas accept&eacute;s. Veuillez corriger.";
			}
			if (trim($_POST['desgb']) == '') {
				//on prend la version française
				if (isset($dfr)) {
					$dgb = $dfr;
					$_POST['desgb'] = $_POST['desfr'];
				} else {
					$eve_errors['desgb'] = "<br />En attente de correction du nom fran&ccedil;ais.";
				}
			} else if (preg_match('/^[^<>"]{6,10000}$/u',stripslashes($_POST['desgb']))) {
				$dgb = escape_data($_POST['desgb']);
			} else {
				$eve_errors['desgb'] = "<br />Certains caract&egrave;res ne sont pas accept&eacute;s. Veuillez corriger.";
			}
			
			if (empty($eve_errors)) {
				//requête
				$v = escape_data($_POST['visible']);
				if (isset($_POST['menu'])) {
					$m = (int)$_POST['menu'];
				} else {
					$m = 0;
				}
				$date = date('Y.m.d',$ladate);
				$q = "INSERT INTO evenements (nom_fr, nom_gb, date_evenement, description_fr, description_gb, visible, menuid) VALUES(";
				$q .= "'" . $nfr . "','" . $ngb . "','" . $date . "','" . $dfr . "','" . $dgb . "','" . $v . "'," . $m . ")";
				$r = @mysqli_query($dbc, $q);
				if (mysqli_affected_rows($dbc) == 1) {				
					echo '<h3>Votre &eacute;v&eacute;nement a bien &eacute;t&eacute; enregistr&eacute;.</h3>';
					mysqli_close($dbc);
					include('../inclusion/adminpied.php');
					exit();
				} else {
					echo '<p>Votre &eacute;v&eacute;nement n\'a pas pu être enregisté.<p>Veuillez recommencer.</p><p>Contactez l\'administrateur du site si le probl&egrave;me persiste.</p>';
					mysqli_close($dbc);
					include('../inclusion/adminpied.php');
					exit();
				}
			}
		}
		//		FIN DE		if (isset($_POST['submission']))
		mysqli_close($dbc);
		echo '<p>Vous souhaitez entrer un &eacute;v&eacute;nement pour ' . $date_comp . '.';
?>
<fieldset><legend>Entrez les d&eacute;tails de votre &eacute;v&eacute;nement : </legend>
<form action="evene_ajou_main.php" method="post" accept-charset="utf-8" style="padding-left:100px">
<p><label for="nomfr"><strong>Nom de l'&eacute;v&eacute;nement en fran&ccedil;ais :</strong></label><br />
<?php create_form_input('nomfr','text',$eve_errors,70,80); ?>
</p>
<p><label for="nomgb"><strong>Nom de l'&eacute;v&eacute;nement en anglais :</strong></label><br />
<?php create_form_input('nomgb','text',$eve_errors,70,80); ?>
<br><small>Si vous souhaitez utiliser le nom fran&ccedil;ais dans la version anglaise du site, laissez cette entrée vide.</small>
</p>
<?php
	//on regarde si il est possible d'ajouter un lien vers des menus existant
	if (!empty($menu)) {
		echo '<p><label for="menu"><strong>Ajouter un lien avec le menu sp&eacute;cial suivant :</strong><br />
		<select name="menu">';
		if ((isset($_POST['menu'])) && ($_POST['menu'] == 0)) {
			echo '<option value"0" selected="selected">(Pas de menu s&eacute;lectionn&eacute;)</option>';
		} else {
			echo '<option value"0">(Pas de menu s&eacute;lectionn&eacute;)</option>';
		}
		for ($i=0; $i<$count; $i++) {
			if (isset($_POST['menu'])) {
				if ($_POST['menu'] == $menu[$i]['id']) {
					echo '<option value="' . $menu[$i]['id'] . '" selected="selected">' . $menu[$i]['menufr'] . '</option>';
				} else {
					echo '<option value="' . $menu[$i]['id'] . '">' . $menu[$i]['menufr'] . '</option>';
				} 	
			} else {
				echo '<option value="' . $menu[$i]['id'] . '">' . $menu[$i]['menufr'] . '</option>';
			}
		}
		echo '</select></p>';
	}
?>
<p><label for="desfr"><strong>Description de l'&eacute;v&eacute;nement en fran&ccedil;ais :</strong></label><br />
<?php create_form_input('desfr','textarea',$eve_errors,70,80); ?>
</p>
<p><label for="desgb"><strong>Description de l'&eacute;v&eacute;nement en anglais :</strong></label><br />
<?php create_form_input('desgb','textarea',$eve_errors,70,80); ?>
<br><small>Si vous souhaitez utiliser la description fran&ccedil;aise dans la version anglaise du site, laissez cette entrée vide.</small>
</p>
<p>
<label for="visible"><strong>L'&eacute;v&eacute;nement sera visible sur le site internet : </strong></label>
<select name="visible">
<?php
	if (isset($_POST['visible'])) {
		if ($_POST['visible'] == 'Oui') {
			echo '<option value="Oui" selected="selected">Oui</option>
		    <option value="Non">Non</option>';
		} else {
			echo '<option value="Oui">Oui</option>
		    <option value="Non" selected="selected">Non</option>';
		}
	} else {
		echo '<option value="Oui">Oui</option>
		<option value="Non">Non</option>';
	}
?>	
</select>
</p>
<input type="submit" name="submit" value="Créer l'&eacute;v&eacute;nement" />
<input type="hidden" name="submission" value="TRUE" />
<input type="hidden" name="ladate" value="<?php echo $ladate; ?>" />
</form>
</fieldset>
<?php
		include('../inclusion/adminpied.php');
?>
