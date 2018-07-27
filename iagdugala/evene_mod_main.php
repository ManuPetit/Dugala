<?php
		/**
		 *	script evene_mod_main.php
		 *
		 *	ce fichier permet de modifier un evenment de la base de données
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Modifier un &eacute;v&eacute;nement";
		$_SESSION['menuid'] = 5;
		include('../inclusion/admintete.php');
		include('../inclusion/admin_form_function.inc.php');
		require('../../dugala.inc.php');
		echo "<h2>Modifier un &eacute;v&eacute;nement</h2>";
		$mod_errors=array();
		$menu=array();
		$menu[0] = array('id' => 0,'menufr' => '(Pas de menu s&eacute;lectionn&eacute;)','file' =>'', 'nom' => '');
		$count=1;
		
		//retrouver les menus speciaux
		$q = "SELECT id, nom_fr, file_name FROM menus WHERE groupe='Ms' ORDER BY nom_fr ASC";
		$r = @mysqli_query($dbc,$q);
		if (mysqli_num_rows($r) > 0) {
			while ($row = mysqli_fetch_array($r,MYSQLI_ASSOC)) {
				$menu[$count] = array('id' => $row['id'], 'menufr' => $row['nom_fr'], 'file' => $row['file_name'], 'nom' => $row['file_name']);
				$count++;
			}
		}
		
		//verifier le type de requete serveur
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//on vient d'une autre page car c'est un
			if ((isset($_GET['eveneid'])) && (is_numeric($_GET['eveneid']))) {
				//c'est une valeur numérique on fait la requête
				$mid = escape_data($_GET['eveneid']);
				//faire la requête
				$q = "SELECT nom_fr, nom_gb, DATE_FORMAT(date_evenement,'%d-%m-%Y') AS jour, description_fr, description_gb, visible, menuid FROM evenements WHERE id=" . $mid . " LIMIT 1";
				$r = @mysqli_query($dbc,$q);
				if (mysqli_num_rows($r) == 1) {
					//on a un retour
					$row = mysqli_fetch_array($r,MYSQLI_ASSOC);
					$pre_nfr = $row['nom_fr'];
					$pre_ngb = $row['nom_gb'];
					$pre_jour = $row['jour'];
					$pre_dfr = $row['description_fr'];
					$pre_dgb = $row['description_gb'];
					$pre_vis = $row['visible'];
					$pre_mid = $row['menuid'];
				} else {
					echo "<p>L'&eacute;v&eacute;nement que vous essayez de modifier, n'a pas &eacute;t&eacute; localis&eacute; dans la base de donn&eacute;es.</p><p>Modification impossible...</p><p>V&eacute;rifiez que cet &eacute;v&eacute;nement existe bien en allant sur la <a href=\"evene_list.php\" title=\"Cliquez ici pour afficher la liste des &eacute;v&eacute;nements.\">liste des &eacute;v&eacute;nement</a>, pour confirmation.</p>";
					mysqli_close($dbc);
					include('../inclusion/adminpied.php');
					exit();
				}
				//		FIN DE		if (mysqli_num_rows($r) == 1)
			} else {				
				echo "<p>L'&eacute;v&eacute;nement que vous essayez de modifier, n'a pas &eacute;t&eacute; localis&eacute; dans la base de donn&eacute;es.</p><p>Modification impossible...</p><p>V&eacute;rifiez que cet &eacute;v&eacute;nement existe bien en allant sur la <a href=\"evene_list.php\" title=\"Cliquez ici pour afficher la liste des &eacute;v&eacute;nements.\">liste des &eacute;v&eacute;nement</a>, pour confirmation.</p>";
				mysqli_close($dbc);
				include('../inclusion/adminpied.php');
				exit();
			}
		}
			//		FIN DE		if ((isset($_GET['menuid'])) && (is_numeric($_GET['menuid'])))			
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$mid = $_POST['eveneid'];
			//faire la requête
				$q ="SELECT nom_fr, nom_gb, DATE_FORMAT(date_evenement,'%d-%m-%Y') AS jour, description_fr, description_gb, visible, menuid FROM evenements WHERE id=" . $mid . "  LIMIT 1";
				$r = @mysqli_query($dbc,$q);
				if (mysqli_num_rows($r) == 1) {
					//on a un retour
					$row = mysqli_fetch_array($r,MYSQLI_ASSOC);
					$pre_nfr = $row['nom_fr'];
					$pre_ngb = $row['nom_gb'];
					$pre_jour = $row['jour'];
					$pre_dfr = $row['description_fr'];
					$pre_dgb = $row['description_gb'];
					$pre_vis = $row['visible'];
					$pre_mid = $row['menuid'];
					//verification des entrées
					//validation des entrées
					if (preg_match('/^[^<>"]{4,80}$/u',stripslashes($_POST['nomfr']))) {
						$nfr = escape_data($_POST['nomfr']);
					} else {
						$mod_errors['nomfr'] = "<br />Certains caract&egrave;res ne sont pas accept&eacute;s. Veuillez corriger.";
					}
					if (preg_match('/^[^<>"]{4,80}$/u',stripslashes($_POST['nomgb']))) {
						$ngb = escape_data($_POST['nomgb']);
					} else {
						$mod_errors['nomgb'] = "<br />Certains caract&egrave;res ne sont pas accept&eacute;s. Veuillez corriger.";
					}
					if (preg_match('/^[0-9]{2}[-][0-9]{2}[-][0-9]{4}$/',trim($_POST['date'])))
					{
						$j = substr($_POST['date'],0,2);
						$m = substr($_POST['date'],3,2);
						$a = substr($_POST['date'],6,4);
						$aujour = time();
						$au_day = date('d',$aujour);
						$au_month = date('m',$aujour);
						$au_year = date('Y',$aujour);
						$au_date = mktime(0,0,0,$au_month,$au_day,$au_year);
						if (checkdate($m, $j, $a) == true) {
							//transformer date de la bdd
							$date = mktime(0,0,0,$m,$j,$a);
							$ja = substr($pre_jour,0,2);
							$ma = substr($pre_jour,3,2);
							$aa = substr($pre_jour,6,4);
							$datea = mktime(0,0,0,$ma,$ja,$aa);
							if ($date < $au_date) {
								$mod_errors['date'] = '<br />Vous ne pouvez pas changer la date de l\'&eacute;v&eacute;nement, pour une date ant&eacute;rieure &agrave; aujourd\'hui.';
							} else {
								if ($date != $datea) {
									$d = date('Y.m.d',$date);
								}
							}
						} else {
							$mod_errors['date'] = '<br />Les valeurs propos&eacute;es de la date ne correspondent pas à celles attendues par la base de donn&eacute;e...';
						}
					} else {
						$mod_errors['date'] = '<br />La date doit &ecirc;tre au format <b>jj-mm-aaaa</b>.';
					}
					if (preg_match('/^[^<>"]{6,10000}$/u',stripslashes($_POST['descfr']))) {
						$dfr = escape_data($_POST['descfr']);
					} else {
						$mod_errors['descfr'] = '<br /><br />Certains caract&egrave;res ne sont pas accept&eacute;s. Veuillez corriger..';
					}
					if (preg_match('/^[^<>"]{6,10000}$/u',stripslashes($_POST['descgb']))) {
						$dgb = escape_data($_POST['descgb']);
					} else {
						$mod_errors['descgb'] = '<br /><br />Certains caract&egrave;res ne sont pas accept&eacute;s. Veuillez corriger..';
					}
					if (empty($mod_errors)) {
						//pas d'erreur
						$v = escape_data($_POST['visible']);
						$m = escape_data($_POST['menuid']);
						//creation de requete
						$update=array();
						if ($nfr != $pre_nfr) {
							$update[] =" nom_fr ='" . $nfr . "'";
						}
						if ($ngb != $pre_ngb) {
							if (empty($update)) {
								$update[] = " nom_gb='" . $ngb . "'";
							} else {
								$update[] = ", nom_gb='" . $ngb . "'";
							}
						}
						if (isset($d)) {
							if (empty($update)) {
								$update[] = " date_evenement='" . $d . "'";
							} else {
								$update[] = ", date_evenement='" . $d . "'";
							}
						}
						if ($dfr != escape_data($pre_dfr)) {
							if (empty($update)) {
								$update[] = " description_fr='" . $dfr . "'";
							} else  {
								$update[] = ", description_fr='" . $dfr . "'";
							} 
						}
						if ($dgb != escape_data($pre_dgb)) {
							if (empty($update)) {
								$update[] = " description_gb='" . $dgb . "'";
							} else {
								$update[] = ", description_gb='" . $dgb . "'";
							}
						}
						if ($v != $pre_vis) {
							if (empty($update)) {
								$update[] = " visible='" . $v . "'";
							} else {
								$update[] = ", visible='" . $v . "'";
							}
						}
						if ($m != $pre_mid) {
							if (empty($update)) {
								$update[] = " menuid=" . $m;
							} else {
								$update[] = ", menuid=" . $m;
							} 
						}
						//voir si il y a des changements
						if (!empty($update)) {
							$q = "UPDATE evenements SET";
							for ($i=0;$i<count($update);$i++) {
								$q .= $update[$i];
							}
							$q .= " WHERE id=" . $mid . " LIMIT 1";
							$r = @mysqli_query($dbc, $q);
							if (mysqli_affected_rows($dbc) == 1) {
								echo "<p>Votre &eacute;v&eacute;nement a &eacute;t&eacute; modifi&eacute; avec succ&eacute;s.</p>";
								mysqli_close($dbc);
								include('../inclusion/adminpied.php');
								exit();
							} else {
								echo "<p>Une erreur s'est produite lors de la tentative de modification de votre &eacute;v&eacute;nement.</p><p>Veuillez recommencer. Si le probl&egrave;me persiste, contactez l'administrateur du site.</p>";
								mysqli_close($dbc);
								include('../inclusion/adminpied.php');
								exit();
							}
						} else {
							echo "<p>Aucune modification n'a &eacute;t&eacute; faite &agrave; votre &eacute;v&eacute;nement.</p>";
							mysqli_close($dbc);
							include('../inclusion/adminpied.php');
							exit();
						}	
						//		FIN DE		if (!empty($update)) 							
					}
					
				} else {
					echo "<p>L'&eacute;v&eacute;nement que vous essayez de modifier, n'a pas &eacute;t&eacute; localis&eacute; dans la base de donn&eacute;es.</p><p>Modification impossible...</p><p>V&eacute;rifiez que cet &eacute;v&eacute;nement existe bien en allant sur la <a href=\"evene_list.php\" title=\"Cliquez ici pour afficher la liste des &eacute;v&eacute;nements.\">liste des &eacute;v&eacute;nement</a>, pour confirmation.</p>";
					mysqli_close($dbc);
					include('../inclusion/adminpied.php');
					exit();
				}
				//		FIN DE		if (mysqli_num_rows($r) == 1)
			}
			//		FIN DE		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		mysqli_close($dbc);
?>
<p>Veuillez modifier votre &eacute;v&eacute;nement selon vos choix.</p>
<fieldset class="livre"><legend>D&eacute;tails de l'&eacute;v&eacute;nement &agrave; modifier : </legend>
<form action="evene_mod_main.php" method="post" accept-charset="utf-8" style="padding-left:100px">
<p><label for="nomfr"><strong>Nom de l'&eacute;v&eacute;nement en fran&ccedil;ais :</strong></label><br />
<?php create_form_edit('nomfr','text',$mod_errors,70,80,$pre_nfr); ?>
</p>
<p><label for="nomgb"><strong>Nom de l'&eacute;v&eacute;nement en anglais :</strong></label><br />
<?php create_form_edit('nomgb','text',$mod_errors,70,80,$pre_ngb); ?>
</p>
<p><label for="date"><strong>Date de l'&eacute;v&eacute;nement :</strong></label><br />
<?php create_form_edit('date','text',$mod_errors,20,10,$pre_jour); ?>
<br /><small>La date doit &ecirc;tre entrée sous le format jj-mm-aaaa.</small>
</p>
<p><label for="descfr"><strong>Description de l'&eacute;v&eacute;nement en fran&ccedil;ais :</strong></label><br />
<?php create_form_edit('descfr','textarea',$mod_errors,70,80,$pre_dfr); ?>
</p>
<p><label for="descgb"><strong>Description de l'&eacute;v&eacute;nement en anglais :</strong></label><br />
<?php create_form_edit('descgb','textarea',$mod_errors,70,80,$pre_dgb); ?>
</p>
<p><label for="visible"><strong>L'&eacute;v&eacute;nement sera visible sur le site internet : </strong></label>
<select name="visible">
<?php
	if (isset($_POST['visible'])) {
		$visible = $_POST['visible'];
	} else {
		$visible = $pre_vis;
	}
	if ($visible == 'Oui') {
		echo '<option value="Oui" selected="selected">Oui</option>
		<option value="Non">Non</option>';
	} else {
		echo '<option value="Oui">Oui</option>
		<option value="Non" selected="selected">Non</option>';
	}
?>	
</select>
</p>
<p><label for="menuid"><strong>Menu sp&eacute;cial s&eacute;lectionn&eacute; :</strong></label>
<?php
	if (isset($_POST['menuid'])) {
		$menuid = $_POST['menuid'];
	} else {
		$menuid = $pre_mid;
	}
	$choix=0;
	echo '<select name="menuid">';
	for ($i=0; $i<$count; $i++) {
		echo '<option value="' . $menu[$i]['id'] . '"';
		if ($menuid == $menu[$i]['id']) {
			echo ' selected="selected"';
			$choix = $i;
		}
		echo '>' . $menu[$i]['menufr'] . '</option>';
	}
	echo '</select>';
	if ($choix != 0) {
		echo '&nbsp;&nbsp;Cliquez sur <a href="../menus/'. $menu[$choix]['file']  .'" target="_blank"" title="Cliquez ici pour afficher le fichier : ' . $menu[$choix]['nom'] . '.">' . $menu[$choix]['nom'] . '</a> pour voir le menu.';
	}
?>
</p>
<input type="hidden" name="eveneid" value="<?php echo $mid; ?>" />
<input type="submit" name="submit" value="Modifier cet &eacute;v&eacute;nement" />
</form>
</fieldset>
<?php
		include('../inclusion/adminpied.php');
?>

