<?php
		/**
		 *
		 *		script livredor.php
		 *
		 *		page livre d'or
		 *
		 */
		 
		 $menuid = 6;
		 $lang = '_fr'; 
		 include('inclusion/config.inc.php');
		 include('inclusion/sitetete.php');
		 include('inclusion/admin_form_function.inc.php');
?>
<div id="uncol"><h3>Notre Livre d'Or</h3>
<?php
	//preparer pour la pagination
	$display = 10;
	$liv_errors = array();
	
	if (isset($_GET['p']) && is_numeric($_GET['p']))  {
		$pages = $_GET['p'];
	} else if (isset($_POST['p']) && is_numeric($_POST['p'])) {
		//connu
		$pages = $_POST['p'];
	} else {
		//on a besoin de trouver le nombre de pages
		$q = "SELECT COUNT(id) FROM livres";
		$r = @mysqli_query($dbc,$q);
		$row = @mysqli_fetch_array($r,MYSQLI_NUM);
		$records = $row[0];
		if ($records > $display) {
			$pages = ceil($records/$display);
		} else {
			$pages = 1;
		}
	}
	if (isset($_GET['s']) && is_numeric($_GET['s']))  {
		$start = $_GET['s'];
	} else if (isset($_POST['s']) && is_numeric($_POST['s'])) {
		//connu
		$start = $_POST['s'];
	} else {
		$start = 0;
	}
	if (isset($_GET['l']) && is_numeric($_GET['l']))  {
		$signe = $_GET['l'];
	} else if (isset($_POST['l']) && is_numeric($_POST['l'])) {
		//connu
		$signe = $_POST['l'];
	} else {
		$signe = 0;
	}
	
	if (isset($_POST['submission'])) {
		//l'utilisateur a soumis un message
		//vérification des données
		if (preg_match('/^[ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿA-Z \'.-]{2,30}$/i',stripslashes($_POST['prenom']))) {
			$p = escape_data($_POST['prenom']);
		} else {
			$liv_errors['prenom'] = "<br /><small>Veuillez entrer votre pr&eacute;nom correctement.</small>";
		}
		if (preg_match('/^[ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿA-Z \'.-]{2,40}$/i',stripslashes($_POST['nom']))) {
			$n = escape_data($_POST['nom']);
		} else {
			$liv_errors['nom'] = "<br /><small>Veuillez entrer votre nom correctement.</small>";
		}
		if (trim($_POST['ville']) != '') {
			if (preg_match('/^[ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿA-Z \'.-]{2,80}$/i',stripslashes($_POST['ville']))) {
				$v = escape_data($_POST['ville']);
			} else {
				$liv_errors['ville'] = "<br /><small>Veuillez entrer votre ville correctement.</small>";
			}
		} else {
			$v = escape_data('0a');
		}
		if (trim($_POST['pays']) != '') {
			if (preg_match('/^[ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿA-Z \'.-]{2,80}$/i',stripslashes($_POST['pays']))) {
				$c = escape_data($_POST['pays']);
			} else {
				$liv_errors['pays'] = "<br /><small>Veuillez entrer votre pays correctement.</small>";
			}
		} else {
			$c = escape_data('0a');
		}
		if (filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
			$e = escape_data($_POST['email']);
		} else {
			$liv_errors['email'] = "<br /><small>L'adresse email n'est pas une adresse valide.</small>";
		}
		if (trim($_POST['tele']) != '') {
			if (preg_match('/^[0-9 -]{10,20}$/u',stripslashes($_POST['tele']))) {
				$te = escape_data(str_replace(' ','',$_POST['tele']));
			} else {
				$liv_errors['tele'] = "<br /><small>Num&eacute;ro invalide.</small>";
			}
		} else {
			$te = escape_data('x');
		}
		if (preg_match('/^[a-zA-Z0-9 ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ€;?!().;,:"\'\n\r-]{3,10000}$/u',stripslashes($_POST['message']))) {
			$ms = escape_data($_POST['message']);
		} else {
			$liv_errors['message'] = "Certains caract&egrave;res ne sont pas accept&eacute;s. Veuillez corriger.";
		}
		//pas d'erreur
		if (empty($liv_errors)) {
			//faire la requete
			$q = "INSERT INTO livres (prenom, nom, email, commentaire, ville, pays, telephone) VALUES (";
			$q .= "'" . $p . "','" . $n . "','" . $e . "','" . $ms . "','" . $v . "','" . $c . "','" . $te . "')";
			$r = @mysqli_query($dbc, $q);
			if (mysqli_affected_rows($dbc) == 1) {
				$signe = 1;
				$body = utf8_decode("Un nouveau commentaire a été laissé sur votre site internet.");
				mail($contact_email,'Nouveau commentaire',$body,'From:administration@iiidees.com');
				//on a besoin de retrouver le nombre de pages
				$q = "SELECT COUNT(id) FROM livres";
				$r = @mysqli_query($dbc,$q);
				$row = @mysqli_fetch_array($r,MYSQLI_NUM);
				$records = $row[0];
				if ($records > $display) {
					$pages = ceil($records/$display);
				} else {
					$pages = 1;
				}
			} else {
				$signe = 0;
				echo "<p>Votre message n'a pas pu &ecirc;tre sauvegard&eacute;. Veuillez recommencer. Si le problème persiste, contactez l'administrateur du site.</p>";
			}
		}
	}
	//		FIN DE		if ($_SERVER['REQUEST_METHOD'] == 'post')
	
		
	//faire la requête
	$q = "SELECT CONCAT(prenom, ' ', nom) AS nom, commentaire, ville, pays, date_created FROM livres ORDER BY date_created DESC LIMIT $start, $display";
	$r = @mysqli_query($dbc,$q);
	if (mysqli_num_rows($r) >0) {
		$message =array();
		while ($rows = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
			$local = NULL;
			if (trim($rows['ville']) != '0a') {
				$local = $rows['ville'];
			}
			if (trim($rows['pays']) != '0a') {
				if (isset($local)) {
					$local .= ' (' . $rows['pays'] . ')';
				} else {
					$local = $rows['pays'];
				}
			}
			if (!isset($local)) {
				$local = '0';
			}
			$message[] = array(
				'nom' => $rows['nom'],
				'lieu' => $local,
				'comm' => $rows['commentaire'],
				'ddate' =>  my_date_handler($rows['date_created'],2) 
			);
		}
	}
	//creer le formulaire
	if ($signe == 0) {		
?>
	<fieldset style="margin-left:18px;width:700px;"><legend>Signez notre livre d'or : </legend>
    <form action="livredor.php" method="post" accept-charset="utf-8">
    <table width="90%" align="center" cellpadding="2"  border="0">
    <tr><td width="15%" valign="top">
    <label for="prenom"><strong>Pr&eacute;nom : </strong></label>
	</td><td width="35%" valign="top">
	<?php create_form_input('prenom','text',$liv_errors,30,30); ?>
    </td>
    <td width="15%" valign="top">
    <label for="prenom"><strong>Nom : </strong></label>
	</td>
    <td width="35%" valign="top">
	<?php create_form_input('nom','text',$liv_errors,30,40); ?>
    </td></tr>
    <tr><td valign="top">
    <label for="ville"><strong>Ville : </strong></label>
	</td><td valign="top">
	<?php create_form_input('ville','text',$liv_errors,30,80); ?>
    <br /><small>(falcutatif)</small>
    </td>
    <td valign="top">
    <label for="prenom"><strong>Pays : </strong></label>
	</td><td valign="top">
	<?php create_form_input('pays','text',$liv_errors,30,80); ?>
    <br /><small>(falcutatif)</small>
    </td></tr>
    <tr><td width="15%" valign="top">
    <label for="email"><strong>Email : </strong></label>
	</td><td width="33%" valign="top">
	<?php create_form_input('email','text',$liv_errors,30,88); ?>
    <br /><small>L'email ne sera pas publi&eacute; sur notre site.</small>
    </td><td valign="top">
    <label for="tele"><strong>T&eacute;l&eacute;phone: </strong></label>
	</td><td valign="top">
	<?php create_form_input('tele','text',$liv_errors,30,20); ?>
    <br /><small>(falcutatif)</small>
    </td></tr>
    <tr><td colspan="4">    
    <label for="message"><strong>Votre message : </strong></label><br /><?php create_form_input('message','textarea2',$liv_errors,20,30); ?>
    </td></tr>
    <tr><td colspan="4" align="center">    
    <input type="submit" name="submit" value="Signez notre livre d'or" />
    </td></tr></table>
    <input type="hidden" name="p" value="'<?php echo $pages; ?>" />
    <input type="hidden" name="s" value="'<?php echo $start; ?>" />
    <input type="hidden" name="l" value="'<?php echo $signe; ?>" />
    <input type="hidden" name="submission" value="TRUE" />
    </form>
    </fieldset>
    <br />
<?php
	}
	if (isset($message)) {
		echo '<table width="90%" align="center" border="0" cellspacing="10">';
		for ($i=0; $i<count($message);$i++) {
			echo '<tr><td width="100%" class="part" valign="top">';
			echo '<table width="90%" align="center"><tr><td width="55%" align="left" valign="top"><b>De ' . $message[$i]['nom'];
			if ($message[$i]['lieu'] != '0') {
				echo ' - ' . $message[$i]['lieu'];
			}
			echo '</b></td><td width="45%" align="right" valign="top"><i>Post&eacute; ' . $message[$i]['ddate'] . '</i></td></tr>';
			echo '<tr><td colspan="2" align="left">' . nl2br($message[$i]['comm']) . '</td></tr></table>';
			echo '</td></tr>';
		}
		echo '</table>';
		if ($pages > 1) {
			echo '<p style="padding-left:50px;">';
			$current_page = ($start/$display)+1;
			if ($current_page != 1) {
				echo '<a href="livredor.php?s=' . ($start-$display) . '&p=' . $pages . '&l=' . $signe . '">Pr&eacute;c&eacute;dent</a>&nbsp;&nbsp;&nbsp;';
			}
			for ($i = 1; $i<=$pages; $i++) {
				if ($i != $current_page) {
					echo '<a href="livredor.php?s=' . (($display*($i-1))) . '&p=' . $pages . '&l=' . $signe . '">' . $i .  '</a>&nbsp;&nbsp;&nbsp;';
				} else {
					echo $i . '&nbsp;&nbsp;&nbsp;';
				}
			}
			if ($current_page != $pages) {
				echo '<a href="livredor.php?s=' . ($start+$display) . '&p=' . $pages . '&l=' . $signe . '">Suivant</a>&nbsp;&nbsp;&nbsp;';
			}
			echo '</p>';
		}
		echo '<br />';			
	} else {
		echo '<p>Soyez le premier &agrave; signer notre livre d\'or....</p><br />';
	}
?>

</div>
<?php
		include('inclusion/sitepied.php');
?>