<?php
		/**
		 *	script photo_mod_main.php
		 *
		 *	page listant l'ensemble des photos
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Modification d'une photo";
		$_SESSION['menuid'] = 2;
		include('../inclusion/admintete.php');
		include('../inclusion/admin_form_function.inc.php');
		require('../../dugala.inc.php');
		echo '<h2>Modification d\'une photo</h2>';
		$pto_errors=array();
		
		if ((isset($_GET['photoid'])) && (is_numeric($_GET['photoid']))) {
			$pid = $_GET['photoid'];
		} else if ((isset($_POST['photoid'])) && (is_numeric($_POST['photoid']))) {
			$pid = $_POST['photoid'];
		} else {
			echo "<p>Une erreur s'est produite.</p><p>Veuillez recommencer. Si le probl&egrave;me persiste, contactez l'administrateur du syst&egrave;me.</p>";
			include('../inclusion/adminpied.php');
			exit();
		}
		
		$q = "SELECT nom_fr, nom_gb, fichier, visible FROM photos WHERE id=" . $pid . " LIMIT 1";
		$r = @mysqli_query($dbc,$q);
		$r = @mysqli_query($dbc,$q);
		if (mysqli_num_rows($r) == 1) {
			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
			$pre_nfr = $row['nom_fr'];
			$pre_ngb = $row['nom_gb'];
			$img = explode('.', $row['fichier']);
			$pre_img = $img[0] . '_th.' . $img[1];
			$pre_fil = "../images/" . $pre_img;
			$pre_vis = $row['visible'];
		} else {
			echo "<p>L'image que vous cherchez n'&eacute;xiste pas dans la base de donn&eacute;es.</p><p>Modification impossible...</p><p>V&eacute;rifiez que la photo existe bien en allant sur la <a href=\"photo_list.php\" title=\"Cliquez ici pour afficher la liste de vos photos.\">liste des photos</a>, pour confirmation.</p>";
			mysqli_close($dbc);
			include('../inclusion/adminpied.php');
			exit();
		}
		
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
							break;
						default: 
							$pto_errors['img'] = '<br />Aucun fichier n\'a &eacute;t&eacute; t&eacute;l&eacute;charg&eacute;.';
							break;
					} // End of SWITCH.		
				} 
			}
			//		FIN DE		if ((isset($_FILES['img']['name'])) && (!empty($_FILES['img']['name'])))
			if (empty($pto_errors)) {
				$update=array();
				if ($nfr != $pre_nfr) {
					$update[] = " nom_fr='" . $nfr . "'";
				}
				if ($ngb != $pre_ngb) {
					if (empty($update)) {
						$update[] = " nom_gb='" . $ngb . "'";
					} else {
						$update[] = ", nom_gb='" . $ngb . "'";
					} 
				}
				//verifier photo
				if (isset($_SESSION['img'])) {
					$n_name = escape_data($_SESSION['img']['new_name']);
					if (empty($update)) {
						$update[] = " fichier='" . $n_name . "'";
					} else {
						$update[] = ", fichier='" . $n_name . "'";
					}
				}
				$v = escape_data($_POST['visible']);
				if ($v != $pre_vis) {
					if (empty($update)) {
						$update[] = " visible='" . $v . "'";
					} else  {
						$update[] = ", visible='" . $v . "'";
					}
				}
				if (!empty($update)) {
					$q = "UPDATE photos SET";
					for ($i=0; $i<count($update); $i++) {
						$q .= $update[$i];
					}
					$q .= " WHERE id=" . $pid . " LIMIT 1";
					$r = @mysqli_query($dbc, $q);
					if (mysqli_affected_rows($dbc) == 1) {//ca a marché
						echo '<p>La photo a &eacute;t&eacute; modifi&eacute;e dans la base de donn&eacute;es.</p>';
						$_POST = array();
						$_FILES = array();
						unset($file,$_SESSION['img']);
						//creation fichier xml
						include('create_xml.php');
						include('../inclusion/adminpied.php');
						mysqli_close($dbc);
						exit();
					} else {
						trigger_error("La photo n'a pas pu &ecirc;tre modifi&eacute;e &agrave; cause d'une erreur syst&egrave;me.</p><p>Veuillez recommencer s'il vous plait.
						Si l'erreur persiste, contactez l'administrateur du site...</p>");
						unlink($dest);
						mysqli_close($dbc);
					}
				} else {
					//aucun changement
					echo '<h4>Aucun changement</h4><p>Vous n\'avez fait aucun chamgement &agrave; cette photo.</p>';
					mysqli_close($dbc);
					include ('../inclusion/adminpied.php');
					exit();
				}				
			}
			//		FIN DE		if (empty($par_errors)) 
				
		}
		//		FIN DE		if ($_SERVER['REQUEST_METHOD'] == 'post') {
		mysqli_close($dbc);
?>
<p>Modifiez les &eacute;tails de la photo selon votre choix.</p>
<fieldset><legend>D&eacute;tails de la photo : </legend>
<form action="photo_mod_main.php"  method="post" accept-charset="utf-8" style="padding-left:100px" enctype="multipart/form-data">
<p><label for="nomfr"><strong>L&eacute;gende de la photo en fran&ccedil;ais (facultatif) :</strong></label><br />
<?php 
	if ($pre_nfr == 'Photo_Aucune') {
		create_form_edit('nomfr','text',$pto_errors,70,50,''); 
	} else {
		create_form_edit('nomfr','text',$pto_errors,70,50,$pre_nfr);
	}
?>
</p>
<p><label for="nomgb"><strong>L&eacute;gende de la photo en anglais (facultatif) :</strong></label><br />
<?php 
	if ($pre_ngb == 'Photo_Aucune') {
		create_form_edit('nomgb','text',$pto_errors,70,50,''); 
	} else {
		create_form_edit('nomgb','text',$pto_errors,70,50,$pre_ngb);
	}
 ?>
<br><small>Si vous souhaitez utiliser la légende fran&ccedil;aise dans la version anglaise du site, laissez cette entrée vide.</small>
</p>	
<p>
<label for="visible"><strong>La photo sera visible sur le site internet : </strong></label>
<select name="visible">
<?php
	if (isset($_POST['visible'])) {
		$mvis = $_POST['visible'];
	} else {
		$mvis = $pre_vis;
	}
	if ($mvis == 'Oui') {
		echo '<option value="Oui" selected="selected">Oui</option>
		<option value="Non">Non</option>';
	} else {
		echo '<option value="Oui">Oui</option>
		<option value="Non" selected="selected">Non</option>';
	}
?>	
</select>
<p>
<p>
<table width="100%" border="0"><tr><td width="60%">
<?php
	
	if (isset($_SESSION['img'])) {
		echo "Actuellement '" . $_SESSION['img']['file_name'] . "'";
		echo ' :</td><td width="40%" rowspan="2">&nbsp;</td></tr>';
	} else {
		$psize = getimagesize($pre_fil);
		echo 'Photo actuellement s&eacute;lectionn&eacute;e :</td><td width="40%" rowspan="2"><img src="' . $pre_fil . '" border="0" width="' . $psize[0]/2 . '" height="' . $psize[1]/2 . '" title="Photo ' . $pre_img. '." alt="Photo ' . $pre_img. '." /></td></tr>';
	}
	echo '<tr><td><label for="img"><strong>Téléchargez un nouveau fichier image :</strong></label><br />';
	echo '<input type="file" size="50" name="img" id="img"';
	if (array_key_exists('img',$pto_errors)) {
		echo ' class="error" /><span class="error">' . $pto_errors['img'] . '</span>';
	} else {
		echo ' />';
		
	}
?><br />
<small>Type de fichiers accept&eacute;s : GIF ou JPG, dont la taille est inf&eacute;rieure &agrave; 5Mo</small></td></tr></table>
</p>
<input type="hidden" name="photoid" value="<?php 
	if (isset($_POST['photoid'])) {
		echo $_POST['photoid'];
	} else {
		echo $pid;
	}
	?>" />			
<input type="submit" name="submit_button" value="Modifier cette image" />
</form>
</fieldset>
<?php
	include('../inclusion/adminpied.php');
?>				
		
			