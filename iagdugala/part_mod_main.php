<?php
		/**
		 *	script part_mod_main.php
		 *
		 *	ce fichier permet de modifier le menu de la base de données et son fichier pdf
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Modifier un partenaire";
		$_SESSION['menuid'] = 6;
		include('../inclusion/admintete.php');
		include('../inclusion/admin_form_function.inc.php');
		require('../../dugala.inc.php');
		echo "<h2>Modifier un partenaire</h2>";
		$par_errors=array();
		
		//verifier le type de requete serveur
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//on vient d'une autre page car c'est un
			if ((isset($_GET['partid'])) && (is_numeric($_GET['partid']))) {
				$pid = escape_data($_GET['partid']);
				//retrouver les données
				$q = "SELECT id, nom_fr, nom_gb, description_fr, description_gb, lien, photo, visible FROM partenaires WHERE id=" . $pid . " LIMIT 1";
				$r = @mysqli_query($dbc,$q);
				if (mysqli_num_rows($r) == 1) {
					$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
					$pre_nfr = $row['nom_fr'];
					$pre_ngb = $row['nom_gb'];
					$pre_dfr = $row['description_fr'];
					$pre_dgb = $row['description_gb'];
					$pre_lie = $row['lien'];
					$lienhttp = 'http://' . $pre_lie;
					if ($row['photo'] == 'A') {
						$pre_pho = 'Aucune';
					} else {
						$image = $row['photo'];
						$piece = explode('.',$image);
						$pre_pho= '../images/' . $piece[0] . '_th.' . $piece[1];
					}
					$pre_vis = $row['visible'];
				} else {
					echo "<p>Le partenaire que vous essayez de modifier, n'a pas &eacute;t&eacute; localis&eacute; dans la base de donn&eacute;es.</p><p>Modification impossible...</p><p>V&eacute;rifiez que le partenaire existe bien en allant sur la <a href=\"part_list.php\" title=\"Cliquez ici pour afficher la liste de vos partenaires.\">liste des partenaires</a>, pour confirmation.</p>";
					mysqli_close($dbc);
					include('../inclusion/adminpied.php');
					exit();
				}
				//		FIN DE		if (mysqli_num_rows($r) == 1)
			} else {
				echo "<p>Le partenaire que vous essayez de modifier, n'a pas &eacute;t&eacute; localis&eacute; dans la base de donn&eacute;es.</p><p>Modification impossible...</p><p>V&eacute;rifiez que le partenaire existe bien en allant sur la <a href=\"part_list.php\" title=\"Cliquez ici pour afficher la liste de vos partenaires.\">liste des partenaires</a>, pour confirmation.</p>";
				mysqli_close($dbc);
				include('../inclusion/adminpied.php');
				exit();
			}
			//		FIN DE		if ((isset($_GET['partid'])) && (is_numeric($_GET['partid'])))			
		}
		//		FIN DE		if ($_SERVER['REQUEST_METHOD'] == 'GET')
			//validation des entrées
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//récupération des entrées
			$pid = escape_data($_POST['partid']);
			//retrouver les données
			$q = "SELECT id, nom_fr, nom_gb, description_fr, description_gb, lien, photo, visible FROM partenaires WHERE id=" . $pid . " LIMIT 1";
			$r = @mysqli_query($dbc,$q);
			if (mysqli_num_rows($r) == 1) {
				$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
				$pre_nfr = $row['nom_fr'];
				$pre_ngb = $row['nom_gb'];
				$pre_dfr = $row['description_fr'];
				$pre_dgb = $row['description_gb'];
				$pre_lie = $row['lien'];
				$lienhttp = 'http://' . $pre_lie;
				if ($row['photo'] == 'A') {
					$pre_pho = 'Aucune';
				} else {
					$image = $row['photo'];
					$piece = explode('.',$image);
					$pre_pho= '../images/' . $piece[0] . '_th.' . $piece[1];
				}
				$pre_vis = $row['visible'];
			} else {
				echo "<p>Le partenaire que vous essayez de modifier, n'a pas &eacute;t&eacute; localis&eacute; dans la base de donn&eacute;es.</p><p>Modification impossible...</p><p>V&eacute;rifiez que le partenaire existe bien en allant sur la <a href=\"part_list.php\" title=\"Cliquez ici pour afficher la liste de vos partenaires.\">liste des partenaires</a>, pour confirmation.</p>";
				mysqli_close($dbc);
				include('../inclusion/adminpied.php');
				exit();
			}
			//		FIN DE		if (mysqli_num_rows($r) == 1)

			//validation des entrées
			if (preg_match('/^[^<>"]{4,100}$/u',stripslashes($_POST['nomfr']))) {
				$nfr = escape_data($_POST['nomfr']);
			} else {
				$par_errors['nomfr'] = "<br />Certains caract&egrave;res ne sont pas accept&eacute;s. Veuillez corriger.";
			}
			if (preg_match('/^[^<>"]{4,100}$/u',stripslashes($_POST['nomgb']))) {
				$ngb = escape_data($_POST['nomgb']);
			} else {
				$par_errors['nomgb'] = "<br />Certains caract&egrave;res ne sont pas accept&eacute;s. Veuillez corriger.";
			}
			if (preg_match('/^[^<>"]{6,10000}$/u',stripslashes($_POST['descfr']))) {
				$dfr = escape_data($_POST['descfr']);
			} else {
				$par_errors['descfr'] = "<br />Certains caract&egrave;res ne sont pas accept&eacute;s. Veuillez corriger.";
			}
			if (preg_match('/^[^<>"]{6,10000}$/u',stripslashes($_POST['descgb']))) {
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
							//enlever image originale si existe
							if ($pre_pho != 'Aucune') {
								unlink($pre_pho);
							}
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
							//pas de fichier on n'en veut pas donc pas d'erreur
							break;
						default: 
							$par_errors['img'] = '<br />Aucun fichier n\'a &eacute;t&eacute; t&eacute;l&eacute;charg&eacute;.';
							break;
					} // End of SWITCH.		
				} 
			}
			//		FIN DE		if ((isset($_FILES['img']['name'])) && (!empty($_FILES['img']['name'])))
			if (empty($par_errors)) {
				//pas d'erreur on prépare la requête
				$update = array();
				if ($pre_nfr != $nfr) {
					$update[] = " nom_fr='" . $nfr . "'";
				}
				if ($pre_ngb != $ngb) {
					if (empty($update)) {
						$update[] = " nom_gb='" . $ngb . "'";
					} else {
						$update[] = ", nom_gb='" . $ngb . "'";
					}
				}
				if ($dfr != escape_data($pre_dfr)) {
					if (empty($update)) {
						$update[] = " description_fr='" . $dfr . "'";
					} else {
						$update[] = ", description_fr='" . $dfr . "'";
					}
				}
				if ($dgb != escape_data($pre_dgb)) {
					if (empty($update)) {
						$update[] = " description_gb='" . $dgb ."'";
					} else {
						$update[] = ", description_gb='" . $dgb ."'";
					} 
				}
				if ($l != $pre_lie) {
					if (empty($update)) {
						$update[] = " lien='" . $lie . "'";
					} else {
						$update[] = ", lien='" . $lie . "'";
					} 
				}
				//verifier photo
				if (isset($_SESSION['img'])) {
					$n_name = escape_data($_SESSION['img']['new_name']);
					if (empty($update)) {
						$update[] = " photo='" . $n_name . "'";
					} else {
						$update[] = ", photo='" . $n_name . "'";
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
				//verifier que l'on a des changement
				if (!empty($update)) {
					$q = "UPDATE partenaires SET";
					for ($i=0; $i<count($update); $i++) {
						$q .= $update[$i];
					}
					$q .= " WHERE id=" . $pid . " LIMIT 1";
					$r = @mysqli_query($dbc, $q);
					if (mysqli_affected_rows($dbc) == 1) {
						//ca a marché
						echo '<p>Le partenaire a &eacute;t&eacute; modifi&eacute; dans la base de donn&eacute;es.</p>';
						$_POST = array();
						$_FILES = array();
						unset($file,$_SESSION['img']);
						include('../inclusion/adminpied.php');
						mysqli_close($dbc);
						exit();
					} else {
						trigger_error("Le partenaire n'a pas pu &ecirc;tre modifi&eacute;e &agrave; cause d'une erreur syst&egrave;me.Veuillez recommencer s'il vous plait.</p><p>
						Si l'erreur persiste, contactez l'administrateur du site...</p>");
						unlink($dest);
						mysqli_close($dbc);
					}
				} else {
					//aucun changement
					echo '<h4>Aucun changement</h4><p>Vous n\'avez fait aucun chamgement &agrave; ce partenaire.</p>';
					mysqli_close($dbc);
					include ('../inclusion/adminpied.php');
					exit();
				}				
			}
			//		FIN DE		if (empty($par_errors)) 
		}
		//		FIN DE		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		mysqli_close($dbc);
?>
<p>Veuillez modifier votre partenaire selon vos choix.</p>
<fieldset><legend>D&eacute;tails du partenaire &agrave; modifier : </legend>
<form action="part_mod_main.php"  method="post" accept-charset="utf-8" style="padding-left:100px" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
<p><label for="nomfr"><strong>Nom du partenaire en fran&ccedil;ais :</strong></label><br />
<?php create_form_edit('nomfr','text',$par_errors,70,100,$pre_nfr); ?>
</p>
<p><label for="nomgb"><strong>Nom du partenaire en anglais :</strong></label><br />
<?php create_form_edit('nomgb','text',$par_errors,70,100,$pre_ngb); ?>
</p>
<p><label for="descfr"><strong>Description de l'activit&eacute; du partenaire en fran&ccedil;ais :</strong></label><br />
<?php create_form_edit('descfr','textarea',$par_errors,70,80,$pre_dfr); ?>
</p>
<p><label for="descgb"><strong>Description de l'activit&eacute; du partenaire en anglais :</strong></label><br />
<?php create_form_edit('descgb','textarea',$par_errors,70,80,$pre_dgb); ?>   
</p>
<p><label for="lien"><strong>Adresse internet du partenaire :</strong></label><br />
<?php create_form_edit('lien','text',$par_errors,60,150,$lienhttp); ?>  
</p>
<p>
<label for="visible"><strong>Le partenaire sera visible sur le site internet : </strong></label>
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
<table width="100%" border="0"><tr><td width="60%">
<?php
	
	if (isset($_SESSION['img'])) {
		echo "Actuellement '" . $_SESSION['img']['file_name'] . "'";
		echo ' :</td><td width="40%" rowspan="2">&nbsp;</td></tr>';
	} else {
		if ($pre_pho == 'Aucune') {
			echo 'Aucune photo n\'a &eacute;t&eacute; s&eacute;lectionn&eacute;e pour ce partenaire.</td><td width="40%" rowspan="2">&nbsp;</td></tr>';
		} else {
		$psize = getimagesize($pre_pho);
		echo 'Photo actuellement s&eacute;lectionn&eacute;e :</td><td width="40%" rowspan="2"><img src="' . $pre_pho . '" border="0" width="' . $psize[0]/2 . '" height="' . $psize[1]/2 . '" title="Photo du partenaire." alt="Photo du partenaire." /></td></tr>';
		}
	}
	echo '<tr><td><label for="img"><strong>Téléchargez un nouveau fichier image :</strong></label><br />';
	echo '<input type="file" size="50" name="img" id="img"';
	if (array_key_exists('img',$par_errors)) {
		echo ' class="error" /><span class="error">' . $par_errors['img'] . '</span>';
	} else {
		echo ' />';
		
	}
?><br />
<small>L'addition d'une image du site internet de votre partenaire est falcutative.<br/>
Type de fichiers accept&eacute;s : GIF ou JPG, dont la taille est inf&eacute;rieure &agrave; 5Mo</small></td></tr></table>
</p>
<input type="hidden" name="partid" value="<?php 
	if (isset($_POST['partid'])) {
		echo $_POST['partid'];
	} else {
		echo $pid;
	}
	?>" />
<input type="submit" name="submit_button" value="Modifier ce partenaire" />
</form>
</fieldset>
<?php
	include('../inclusion/adminpied.php');
?>