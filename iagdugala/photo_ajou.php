<?php
		/**
		 *	script photo_ajou.php
		 *
		 *	page permettant d'ajouter un partenaire
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Ajouter une nouvelle photo";
		$_SESSION['menuid'] = 2;
		include('../inclusion/admintete.php');
		require('../../dugala.inc.php');
		include('../inclusion/admin_form_function.inc.php');
		$pto_errors=array();
		echo '<h2>Ajouter une nouvelle photo</h2>';
		
		//validation des entrées
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//validation des entrées
			if (trim($_POST['nomfr']) != '') {
				if (preg_match('/^[a-zA-Z0-9 ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ€().,:\'-]{4,50}$/u',stripslashes($_POST['nomfr']))) {
					$nfr = escape_data($_POST['nomfr']);
				} else {
					$pto_errors['nomfr'] = "<br />Certains caract&egrave;res ne sont pas accept&eacute;s. Veuillez corriger.";
				}
			} else {
				$nfr = 'Photo_Aucune';
			}
			if (trim($_POST['nomgb']) == '') {
				//on prend la traduction française
				if (isset($nfr)) {
					if ($nfr == 'Photo_Aucune') {
						$ngb = 'Photo_Aucune';
					} else {
						$ngb = $nfr;
						$_POST['nomgb'] = $nfr;
					}
				} else {
					$pto_errors['nomgb'] = "<br />En attente de correction du nom fran&ccedil;ais.";
				}
			} else if (preg_match('/^[a-zA-Z0-9 ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ€().,:\'-]{4,50}$/u',stripslashes($_POST['nomgb']))) {
				$ngb = escape_data($_POST['nomgb']);
			} else {
				$pto_errors['nomgb'] = "<br />Certains caract&egrave;res ne sont pas accept&eacute;s. Veuillez corriger.";
			}
			//verifiaction de l'image
			if ((isset($_FILES['img']['name'])) && (!empty($_FILES['img']['name']))) {
				if (is_uploaded_file($_FILES['img']['tmp_name']) && ($_FILES['img']['error'] == UPLOAD_ERR_OK)) {
					$file = $_FILES['img'];
					$size = ROUND($file['size']/1024);
					if ($size > 5120) {
						$pto_errors['img'] = "<br />Le fichier image est trop volumineux. Taille maximum : 5 Mo!";
					}
					$all_mime = array('image/gif', 'image/pjpeg', 'image/jpeg', 'image/JPG');
					$all_ext = array ('.jpg', '.gif', 'jpeg');
					$image_info = getimagesize($file['tmp_name']);
					$ext=strtolower(substr($file['name'],-4));
					if ((!in_array($file['type'],$all_mime)) || (!in_array($image_info['mime'], $all_mime)) || (!in_array($ext,$all_ext))) {
						$pto_errors['img'] = "<br />Le fichier t&eacute;l&eacute;charg&eacute; n'est pas un fichier image reconnu par le syst&egrave;me.";
					}
					//si pas d'erreur
					if (!array_key_exists('img',$pto_errors)) {
						$newname = (string)sha1($file['name'].uniqid('',true));
						$newname .= ((substr($ext, 0, 1) != '.') ? ".{$ext}" : $ext);
						$dest = "../images/$newname";
						if (move_uploaded_file($file['tmp_name'],$dest)) {
							$_SESSION['img']['new_name'] = $newname;
							$_SESSION['img']['file_name'] = $file['name'];
							echo '<h4>Le fichier image a &eacute;t&eacute; t&eacute;l&eacute;charg&eacute; avec succ&eacute;s.</h4>';
							//generer thumbnail
							createthumb($dest,250,250);
							//Détruire l'image original pour garder selement thumbnail
							unlink($dest);
						} else {
							trigger_error('Le fichier ne pouvait &ecirc;tre d&eacute;plac&eacute;.');
							unlink($file['tmp_name']);
						}
					}
					//		FIN DE		if (!array_key_exists('img',$pto_errors))
				} elseif (!isset($_SESSION['img'])) { // No current or previous uploaded file.
					switch ($_FILES['img']['error']) {
						case 1:
						case 2:
							$pto_errors['img'] = '<br />Le fichier &agrave; t&eacute;l&eacute;charger est trop volumineux.';
							break;
						case 3:
							$pto_errors['img'] = '<br />Le fichier n\'a &eacute;t&eacute; que partiellement t&eacute;l&eacute;charg&eacute;.';
							break;
						case 6:
						case 7:
						case 8:
							$pto_errors['img'] = '<br />Le fichier n\'a pas pu &ecirc;tre t&eacute;l&eacute;charg&eacute; &agrave; cause d\'une erreur syst&egrave;me.';
							break;
						case 4:
						default: 
							$pto_errors['img'] = '<br />Aucun fichier n\'a &eacute;t&eacute; t&eacute;l&eacute;charg&eacute;.';
							break;
					} // End of SWITCH.		
				} 
			}
			//		FIN DE		if ((isset($_FILES['img']['name'])) && (!empty($_FILES['img']['name'])))
			
			//pas d'erreur
			if (empty($pto_errors)) {
				$name = $_SESSION['img']['new_name'];
				$v = escape_data($_POST['visible']);
				//requete
				$q = "INSERT INTO photos (nom_fr, nom_gb, fichier, visible) VALUES ('";
				$q .= $nfr . "','" . $ngb . "','" . $name . "','" . $v . "')";
				$r = @mysqli_query($dbc, $q);
				if (mysqli_affected_rows($dbc) == 1) {
					echo '<p>La photo a &eacute;t&eacute; ajout&eacute;e &agrave; la base de donn&eacute;es.</p>';
					$_POST = array();
					$_FILES = array();
					unset($file,$_SESSION['img']);
					//creation fichier xml
					include('create_xml.php');
					include('../inclusion/adminpied.php');
					mysqli_close($dbc);
					exit();
				} else {
					trigger_error("La photo n'a pas pu &ecirc;tre ajout&eacute;e &agrave; cause d'une erreur syst&egrave;me.Veuillez recommencer s'il vous plait.
					Si l'erreur persiste, contactez l'administrateur du site...</p>");
					unlink($dest);
					mysqli_close($dbc);
				}
			}
		}
		//		FIN DE		if ($_SERVER['REQUEST_METHOD'] == 'POST')
?>
<p>Veuillez entrer les détails de votre nouvelle photo</p>
<fieldset><legend>D&eacute;tails de la photo : </legend>
<form action="photo_ajou.php"  method="post" accept-charset="utf-8" style="padding-left:100px" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
<p><label for="nomfr"><strong>L&eacute;gende de la photo en fran&ccedil;ais (facultatif) :</strong></label><br />
<?php create_form_input('nomfr','text',$pto_errors,70,50); ?>
</p>
<p><label for="nomgb"><strong>L&eacute;gende de la photo en anglais (facultatif) :</strong></label><br />
<?php create_form_input('nomgb','text',$pto_errors,70,50); ?>
<br><small>Si vous souhaitez utiliser la légende fran&ccedil;aise dans la version anglaise du site, laissez cette entrée vide.</small>
</p>
<p>
<label for="visible"><strong>Cette photo sera visible sur le site internet : </strong></label>
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
	if (array_key_exists('img',$pto_errors)) {
		echo ' class="error" /><span class="error">' . $pto_errors['img'] . '</span>';
	} else {
		echo ' />';
		if (isset($_SESSION['img'])) {
			echo "<br />Actuellement '" . $_SESSION['img']['file_name'] . "'";
		}
	}
?><br /><small>Type de fichiers accept&eacute;s : GIF ou JPG, dont la taille est inf&eacute;rieure &agrave; 5Mo.</small>
</p>
<input type="submit" name="submit_button" value="Ajouter cette image" />
</form>
</fieldset>
<?php
	include('../inclusion/adminpied.php');
?>