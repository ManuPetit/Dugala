<?php
		/**
		 *	script part_ajou.php
		 *
		 *	page permettant d'ajouter un partenaire
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Ajouter un partenaire";
		$_SESSION['menuid'] = 6;
		include('../inclusion/admintete.php');
		require('../../dugala.inc.php');
		include('../inclusion/admin_form_function.inc.php');
		$par_errors=array();
		echo '<h2>Ajouter un partenaire</h2>';
		
		//validation des entrées
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//validation des entrées
			//if (preg_match('/^[a-zA-Z0-9 ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ€().,:\'-]{4,100}$/u',stripslashes($_POST['nomfr']))) {
			//changement effectué le 6/5/2011 due au vérificateur orthographique du navigateur
			if (preg_match('/^[^<>"]{4,100}$/u',stripslashes($_POST['nomfr']))) {
				$nfr = escape_data($_POST['nomfr']);
			} else {
				$par_errors['nomfr'] = "<br />Certains caract&egrave;res ne sont pas accept&eacute;s. Veuillez corriger.";
			}
			if (trim($_POST['nomgb']) == '') {
				//on prend la traduction française  
				if (isset($nfr)) {
					$ngb = $nfr;
					$_POST['nomgb'] = $_POST['nomfr'];
				} else {
					$par_errors['nomgb'] = "<br />En attente de correction du nom fran&ccedil;ais.";
				} 
			} //else if (preg_match('/^[a-zA-Z0-9 ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ€().,:\'-]{4,100}$/u',stripslashes($_POST['nomgb']))) {
			else if (preg_match('/^[^<>"]{4,100}$/u',stripslashes($_POST['nomgb']))) {
				$ngb = escape_data($_POST['nomgb']);
			} else {
				$par_errors['nomgb'] = "<br />Certains caract&egrave;res ne sont pas accept&eacute;s. Veuillez corriger.";
			}
			if (preg_match('/^[^<>"]{6,10000}$/u',stripslashes($_POST['descfr']))) {
				$dfr = escape_data($_POST['descfr']);
			} else {
				$par_errors['descfr'] = "<br />Certains caract&egrave;res ne sont pas accept&eacute;s. Veuillez corriger.";
			}
			if (trim($_POST['descgb']) == '') {
				//on prend la version française
				if (isset($dfr)) {
					$dgb = $dfr;
					$_POST['descgb'] = $_POST['descfr'];
				} else {
					$par_errors['descgb'] = "<br />En attente de correction du nom fran&ccedil;ais.";
				}
			} else if (preg_match('/^[^<>"]{6,10000}$/u',stripslashes($_POST['descgb']))) {
				$dgb = escape_data($_POST['descgb']);
			} else {
				$par_errors['descgb'] = "<br />Certains caract&egrave;res ne sont pas accept&eacute;s. Veuillez corriger.";
			}
			if (filter_var($_POST['lien'],FILTER_VALIDATE_URL)) {
				$mot = array('http://','https://','ftp://');
				$l = escape_data(str_replace($mot,'',$_POST['lien']));
			} else {
				$par_errors['lien'] = "<br />Vérifiez l'adresse internet que vous avez entr&eacute;. Celle-ci ne semble pas &ecirc;tre valide.";
			}
			//verifiaction de l'image
			if ((isset($_FILES['img']['name'])) && (!empty($_FILES['img']['name']))) {
				if (is_uploaded_file($_FILES['img']['tmp_name']) && ($_FILES['img']['error'] == UPLOAD_ERR_OK)) {
					$file = $_FILES['img'];
					$size = ROUND($file['size']/1024);
					if ($size > 5120) {
						$par_errors['img'] = "<br />Le fichier image est trop volumineux. Taille maximum : 5 Mo!";
					}
					$all_mime = array('image/gif', 'image/pjpeg', 'image/jpeg', 'image/JPG');
					$all_ext = array ('.jpg', '.gif', 'jpeg');
					$image_info = getimagesize($file['tmp_name']);
					$ext=strtolower(substr($file['name'],-4));
					if ((!in_array($file['type'],$all_mime)) || (!in_array($image_info['mime'], $all_mime)) || (!in_array($ext,$all_ext))) {
						$par_errors['img'] = "<br />Le fichier t&eacute;l&eacute;charg&eacute; n'est pas un fichier image reconnu par le syst&egrave;me.";
					}
					//si pas d'erreur
					if (!array_key_exists('img',$par_errors)) {
						$newname = (string)sha1($file['name'].uniqid('',true));
						$newname .= ((substr($ext, 0, 1) != '.') ? ".{$ext}" : $ext);
						$dest = "../images/$newname";
						if (move_uploaded_file($file['tmp_name'],$dest)) {
							$_SESSION['img']['new_name'] = $newname;
							$_SESSION['img']['file_name'] = $file['name'];
							echo '<h4>Le fichier image a &eacute;t&eacute; t&eacute;l&eacute;charg&eacute; avec succ&eacute;s.</h4>';
							//generer thumbnail
							createthumb($dest,150,150);
							//Détruire l'image original pour garder selement thumbnail
							unlink($dest);
						} else {
							trigger_error('Le fichier ne pouvait &ecirc;tre d&eacute;plac&eacute;.');
							unlink($file['tmp_name']);
						}
					}
					//		FIN DE		if (!array_key_exists('img',$par_errors))
				} elseif (!isset($_SESSION['img'])) { // No current or previous uploaded file.
					switch ($_FILES['img']['error']) {
						case 1:
						case 2:
							$par_errors['img'] = '<br />Le fichier &agrave; t&eacute;l&eacute;charger est trop volumineux.';
							break;
						case 3:
							$par_errors['img'] = '<br />Le fichier n\'a &eacute;t&eacute; que partiellement t&eacute;l&eacute;charg&eacute;.';
							break;
						case 6:
						case 7:
						case 8:
							$par_errors['img'] = '<br />Le fichier n\'a pas pu &ecirc;tre t&eacute;l&eacute;charg&eacute; &agrave; cause d\'une erreur syst&egrave;me.';
							break;
						case 4:
						default: 
							$par_errors['img'] = '<br />Aucun fichier n\'a &eacute;t&eacute; t&eacute;l&eacute;charg&eacute;.';
							break;
					} // End of SWITCH.		
				} 
			}
			//		FIN DE		if ((isset($_FILES['img']['name'])) && (!empty($_FILES['img']['name'])))
			if (empty($par_errors)) {
				//pas d'erreur verifier si il y a une photo
				if (!isset($_SESSION['img']['new_name'])) {
					$newname ='A';
				} else {
					$newname = $_SESSION['img']['new_name'];
				}
				$v = escape_data($_POST['visible']);
				$p = escape_data($newname);
				$q = "INSERT INTO partenaires (nom_fr, nom_gb, description_fr, description_gb, lien, photo, visible) VALUES ('";
				$q .= $nfr . "','" . $ngb . "','" . $dfr . "','" . $dgb . "','" . $l . "','" . $p . "','" . $v . "')";
				$r = @mysqli_query($dbc, $q);
				if (mysqli_affected_rows($dbc) == 1) {
					echo '<p>Le partenaire a &eacute;t&eacute; ajout&eacute; &agrave; la base de donn&eacute;es.</p>';
					$_POST = array();
					$_FILES = array();
					unset($file,$_SESSION['img']);
					include('../inclusion/adminpied.php');
					mysqli_close($dbc);
					exit();
				} else {
					trigger_error("Le partenaire n'a pas pu &ecirc;tre ajout&eacute; &agrave; cause d'une erreur syst&egrave;me.Veuillez recommencer s'il vous plait.
					Si l'erreur persiste, contactez l'administrateur du site...</p>");
					unlink($dest);
					mysqli_close($dbc);
				}
				//		FIN DE		if (mysqli_affected_rows($dbc) == 1)
			}
			//		FIN  DE		if (empty($par_errors))
		}
		//	FIN DE		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		
		
?>
<p>Veuillez entrer les d&eacute;tails suivants pour enregistrer un nouveau partenaire.</p>
<fieldset><legend>D&eacute;tails du nouveau partenaire : </legend>
<form action="part_ajou.php"  method="post" accept-charset="utf-8" style="padding-left:100px" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
<p><label for="nomfr"><strong>Nom du partenaire en fran&ccedil;ais :</strong></label><br />
<?php create_form_input('nomfr','text',$par_errors,70,100); ?>
</p>
<p><label for="nomgb"><strong>Nom du partenaire en anglais :</strong></label><br />
<?php create_form_input('nomgb','text',$par_errors,70,100); ?>           
<br><small>Si vous souhaitez utiliser le nom fran&ccedil;ais dans la version anglaise du site, laissez cette entrée vide.</small>
</p>
<p><label for="descfr"><strong>Description de l'activit&eacute; du partenaire en fran&ccedil;ais :</strong></label><br />
<?php create_form_input('descfr','textarea',$par_errors,70,80); ?>
</p>
<p><label for="descgb"><strong>Description de l'activit&eacute; du partenaire en anglais :</strong></label><br />
<?php create_form_input('descgb','textarea',$par_errors,70,80); ?>         
<br><small>Si vous souhaitez utiliser la description fran&ccedil;aise dans la version anglaise du site, laissez cette entrée vide.</small>
</p>
<p><label for="lien"><strong>Adresse internet du partenaire :</strong></label><br />
<?php create_form_input('lien','text',$par_errors,60,150); ?>  
</p>
<p>
<label for="visible"><strong>Le partenaire sera visible sur le site internet : </strong></label>
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
<p><label for="img"><strong>Fichier image &agrave; t&eacute;l&eacute;charger :</strong></label><br />
<?php
	echo '<input type="file" size="50" name="img" id="img"';
	if (array_key_exists('img',$par_errors)) {
		echo ' class="error" /><span class="error">' . $par_errors['img'] . '</span>';
	} else {
		echo ' />';
		if (isset($_SESSION['img'])) {
			echo "<br />Actuellement '" . $_SESSION['img']['file_name'] . "'";
		}
	}
?><br /><small>L'addition d'une image du site internet de votre partenaire est falcutative.<br/>
Type de fichiers accept&eacute;s : GIF ou JPG, dont la taille est inf&eacute;rieure &agrave; 5Mo.</small>
</p>
<input type="submit" name="submit_button" value="Ajouter ce partenaire" />
</form>
</fieldset>
<?php
	include('../inclusion/adminpied.php');
?>