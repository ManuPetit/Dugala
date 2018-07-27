<?php
		/**
		 *	script menu_mod_main.php
		 *
		 *	ce fichier permet de modifier le menu de la base de données et son fichier pdf
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Modifier un menu";
		$_SESSION['menuid'] = 4;
		include('../inclusion/admintete.php');
		include('../inclusion/admin_form_function.inc.php');
		require('../../dugala.inc.php');
		echo "<h2>Modifier un menu</h2>";
		$mod_errors=array();
		
		//verifier le type de requete serveur
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			//on vient d'une autre page car c'est un
			if ((isset($_GET['menuid'])) && (is_numeric($_GET['menuid']))) {
				//c'est une valeur numérique on fait la requête
				$mid = escape_data($_GET['menuid']);
				$q = "SELECT nom_fr, nom_gb, file_name, visible, groupe FROM menus WHERE id=" . $mid . " LIMIT 1";
				$r = @mysqli_query($dbc,$q);
				if (mysqli_num_rows($r) == 1) {
					//on a un retour
					$row = mysqli_fetch_array($r,MYSQLI_ASSOC);
					$pre_nfr = $row['nom_fr'];
					$pre_ngb = $row['nom_gb'];
					$pre_fil = str_replace('.pdf', '',$row['file_name']);
					$pre_vis = $row['visible'];
					$pre_grp = $row['groupe'];					
				} else {
					echo "<p>Le menu que vous essayez de modifier, n'a pas &eacute;t&eacute; localis&eacute; dans la base de donn&eacute;es.</p><p>Modification impossible...</p><p>V&eacute;rifiez que le menu existe bien en allant sur la <a href=\"menu_list.php\" title=\"Cliquez ici pour afficher la liste des menus et cartes.\">liste des menus et cartes</a>, pour confirmation.</p>";
					mysqli_close($dbc);
					include('../inclusion/adminpied.php');
					exit();
				}
				//		FIN DE		if (mysqli_num_rows($r) == 1)
			} else {
				echo "<p>Le menu que vous essayez de modifier, n'a pas &eacute;t&eacute; localis&eacute; dans la base de donn&eacute;es.</p><p>Modification impossible...</p><p>V&eacute;rifiez que le menu existe bien en allant sur la <a href=\"menu_list.php\" title=\"Cliquez ici pour afficher la liste des menus et cartes.\">liste des menus et cartes</a>, pour confirmation.</p>";
				mysqli_close($dbc);
				include('../inclusion/adminpied.php');
				exit();
			}
			//		FIN DE		if ((isset($_GET['menuid'])) && (is_numeric($_GET['menuid'])))			
		}
		
		//requete post
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//on recupère les anciennes données
			$q = "SELECT nom_fr, nom_gb, file_name, visible, groupe FROM menus WHERE id=" . escape_data($_POST['menuid']) . " LIMIT 1";
			$r = @mysqli_query($dbc,$q);
			if (mysqli_num_rows($r) == 1) {
				//on a un retour
				$row = mysqli_fetch_array($r,MYSQLI_ASSOC);
				$pre_nfr = $row['nom_fr'];
				$pre_ngb = $row['nom_gb'];
				$pre_fil = str_replace('.pdf', '',$row['file_name']);
				$pre_vis = $row['visible'];
				$pre_grp = $row['groupe'];					
			} else {
				echo "<p>Le menu que vous essayez de modifier, n'a pas &eacute;t&eacute; localis&eacute; dans la base de donn&eacute;es.</p><p>Modification impossible...</p><p>V&eacute;rifiez que le menu existe bien en allant sur la <a href=\"menu_list.php\" title=\"Cliquez ici pour afficher la liste des menus et cartes.\">liste des menus et cartes</a>, pour confirmation.</p>";
				mysqli_close($dbc);
				include('../inclusion/adminpied.php');
				exit();
			}
			//		FIN DE		if (mysqli_num_rows($r) == 1)
			
			//Validation des entrées
			if (preg_match('/^[a-zA-Z0-9 ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ+;().,:\'-]{6,80}$/u',stripslashes($_POST['menufr']))) {
				$dfr = escape_data($_POST['menufr']);
			} else {
				$mod_errors['menufr'] = "<br />Il y a des caractères non valide dans votre description du menu.";
			}
			
			if (preg_match('/^[a-zA-Z0-9 ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ+;().,:\'-]{6,80}$/u',stripslashes($_POST['menugb']))) {
				$dgb = escape_data($_POST['menugb']);
			} else {
				$mod_errors['menugb'] = "<br />Il y a des caractères non valide dans votre description du menu.";
			}
			
			if (preg_match('/^[a-zA-Z0-9]{3,60}$/u',trim(stripslashes($_POST['titre'])))) {
				$t = escape_data($_POST['titre']);
			} else {
				$mod_errors['titre'] = "<br />Le titre n'accepte que des caract&egrave;res alphanum&eacute;riques non accentu&eacute;s et sans espace.<br />Par exemple : MenuAvril2011.";
			}
			
			//vérification que l'on a un fichier téléchargé
			if (!isset($_SESSION['pdf']) && (isset($_FILES['pdf']))) {
				if (is_uploaded_file($_FILES['pdf']['tmp_name']) && ($_FILES['pdf']['error'] == UPLOAD_ERR_OK)) {
					$file = $_FILES['pdf'];
					//vérifier la taille du fichier
					$size = ROUND($file['size']/1024);
					if ($size > 2048) {
						//fichier trop volumineux
						$mod_errors['pdf'] = "<br />Le fichier t&eacute;l&eacute;charg&eacute; est trop volumineux. Sa taille doit &ecirc;tre inf&eacute;rieure &agrave; 2Mo.";
					}
					if (($file['type']!='application/pdf') || (substr($file['name'],-4)!='.pdf')) {
						$mod_errors['pdf'] = '<br />Le fichier t&eacute;l&eacute;charg&eacute; n\'est pas un fichier PDF.';
					}
					if (!array_key_exists('pdf', $mod_errors)) {
						//pas d'erreur
						$tmp_name = sha1($file['name'].uniqid('',true));
						$dest = PDF_DIR . $tmp_name . '_tmp';
						if (move_uploaded_file($file['tmp_name'],$dest)) {
							$_SESSION['pdf']['tmp_name'] = $tmp_name;
							$_SESSION['pdf']['size'] = $size;
							$_SESSION['pdf']['file_name'] = $file['name'];
							echo '<h4>Le fichier a &eacute;t&eacute; t&eacute;l&eacute;charg&eacute;!</h4>';
						} else {
							trigger_error('Le fichier ne pouvait &ecirc;tre d&eacute;plac&eacute;.');
							unlink($file['tmp_name']);
						}
					}
					//		FIN DE		if (!array_key_exists('pdf', $mod_errors)) 
				} else {
					//pas de fichier
					switch($_FILES['pdf']['error']) {
						case 1:
						case 2:
							$mod_errors['pdf'] = "<br />Le fichier &agrave; t&eacute;l&eacute;charger est trop volumineux.";
							break;
						case 3:
							$mod_errors['pdf'] = "<br />Le fichier n'a &eacute;t&eacute; que partiellement t&eacute;l&eacute;charg&eacute;.";
							break;
						case 6:
						case 7:
						case 8:
							$mod_errors['pdf'] = "<br />Le fichier n'a pas pu &ecirc;tre t&eacute;l&eacute;charg&eacute; &agrave; cause d'une erreur syst&egrave;me.";
							break;
						case 4:
							break;
						default:
							$mod_errors['pdf'] = "<br />Aucun fichier n'a &eacute;t&eacute; t&eacute;l&eacute;charg&eacute;.";
							break;
					}
				}
			}
			
			//verifier qu'il y a des changement si pas d'erreur
			if (empty($mod_errors)) {
				$update=array();
				if ($dfr != $pre_nfr) {
					$update[] = " nom_fr='" . $dfr . "'";
				}
				if ($dgb != $pre_ngb) {
					if (empty($update)) {
						$update[] = " nom_gb='" . $dgb . "'";
					} else {
						$update[] = ", nom_gb='" . $dgb . "'";
					}
				}
				if ($t != $pre_fil) {
					$t .= '.pdf';
					if (empty($update)) {
						$update[] = " file_name='" . $t . "'";
					} else {
						$update[] = ", file_name='" . $t . "'";
					}
				} else {
					$t = $pre_fil . '.pdf';
				}
				$v = escape_data($_POST['visible']);
				$g = escape_data($_POST['groupe']);
				if ($v != $pre_vis) {
					if (empty($update)) {
						$update[] = " visible='" . $v . "'";
					} else {
						$update[] = ", visible='" . $v . "'";
					}
				}
				if ($g != $pre_grp) {
					if (empty($update)) {
						$update[] = " groupe='" . $g . "'";
					} else {
						$update[] = ", groupe='" . $g . "'";
					}
				}
				//verifier nouveau pdf
				if (isset($_SESSION['pdf'])) {
					$nsize = (int)$_SESSION['pdf']['size'];
					if (empty($update)) {
						$update[] = " taille=" . $nsize;
					} else {
						$update[] = ", taille=" . $nsize;
					}
				}
				//faire requete si necessaire
				if (!empty($update)) {
					$q = "UPDATE menus SET";
					for ($i=0; $i<count($update); $i++) {		
						$q .= $update[$i];
					}
					$q .= " WHERE id=" . escape_data($_POST['menuid']) . " LIMIT 1";
					$r = @mysqli_query($dbc,$q);
					if (mysqli_affected_rows($dbc) == 1) {
						//ca a marché
						//renommer pdf
						if (isset($_SESSION['pdf'])) {
							$oldfile = PDF_DIR . $pre_fil . '.pdf';
							if (file_exists($oldfile)) {
								unlink($oldfile);
							}
							$original =  PDF_DIR . $_SESSION['pdf']['tmp_name'] . '_tmp';
							$dest = PDF_DIR . $t;
							rename($original,$dest);
							echo '<h4>Le fichier PDF a &eacute;t&eacute; ajout&eacute; avec succ&egrave;s sur le serveur distant.</h4>';
							$_FILES = array();
							unset($file,$_SESSION['pdf']);
							$secu = true;
						}
						if (($t !=  ($pre_fil . '.pdf')) && (!isset($secu))) {
							$original = PDF_DIR . $pre_fil .'.pdf';
							$dest = PDF_DIR . $t;
							rename($original,$dest);
						}
						$_POST = array();
						echo "<p>Vos changements ont &eacute;t&eacute; ajout&eacute; &agrave; la base de donn&eacute;es.</p>";
						mysqli_close($dbc);
						exit();
					} else {
						trigger_error("Le fichier PDF n'a pas pu &ecirc;tre ajout&eacute; &agrave; cause d'une erreur syst&egrave;me.Veuillez recommencer s'il vous plait.
						Si l'erreur persiste, contactez l'administrateur du site...</p>");
						unlink($dest);
					}
				} else {
					//aucun changement
					echo '<h4>Aucun changement</h4><p>Vous n\'avez fait aucun chamgement &agrave; ce menu.</p>';
					mysqli_close($dbc);
					include ('../inclusion/adminpied.php');
					exit();
				}				
			}
			//		FIN DE		if (empty($mod_errors))
		}
		//		FIN DE		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		mysqli_close($dbc);
?>
<p>Veuillez modifier votre menu selon vos choix.</p>
<fieldset><legend>D&eacute;tails du menu &agrave; modifier : </legend>
<form action="menu_mod_main.php" method="post" accept-charset="utf-8" style="padding-left:100px" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
<p><label for="visible"><strong>Cat&eacute;gorie de ce menu : </strong></label><br />
<select name="groupe">
<?php
	if (isset($_POST['groupe'])) {
		$groupe = $_POST['groupe'];
	} else {
		$groupe = $pre_grp;
	}
	if ($groupe == 'Me') {
		echo '<option value="Me" selected="selected">Menus</option>
		<option value="Ms">Menus sp&eacute;ciaux</option>
		<option value="Ca">Cartes</option>
		<option value="Cb">Boissons</option>';
	} else if ($groupe == 'Ms') {
		echo '<option value="Me">Menus</option>
		<option value="Ms" selected="selected">Menus sp&eacute;ciaux</option>
		<option value="Ca">Cartes</option>
		<option value="Cb">Boissons</option>';
	} else if ($groupe == 'Ca') {
		echo '<option value="Me">Menus</option>
		<option value="Ms">Menus sp&eacute;ciaux</option>
		<option value="Ca" selected="selected">Cartes</option>
		<option value="Cb">Boissons</option>';
	} else if ($groupe == 'Cb') {
		echo '<option value="Me">Menus</option>
		<option value="Ms">Menus sp&eacute;ciaux</option>
		<option value="Ca">Cartes</option>
		<option value="Cb" selected="selected">Boissons</option>';
	}
?>	
</select>
</p>
<p><label for="menufr"><strong>Nom du menu en fran&ccedil;ais :</strong></label><br />
<?php create_form_edit('menufr','text',$mod_errors,70,80,$pre_nfr); ?>
</p>
<p><label for="menugb"><strong>Nom du menu en anglais :</strong></label><br />
<?php create_form_edit('menugb','text',$mod_errors,70,80,$pre_ngb); ?>
</p>
<p>
<label for="visible"><strong>Le menu est visible sur le site internet : </strong></label>
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
<p><label for="titre"><strong>Nom du fichier PDF de votre menu :</strong></label><br />
<?php create_form_edit('titre','text',$mod_errors,50,60,$pre_fil); ?>
<br /><small>Ce nom apparait comme le titre du fichier sur le site internet.</small>
</p>
<p><label for="pdf"><strong>Téléchargez un nouveau fichier PDF :</strong></label><br />
<?php
	echo '<input type="file" size="50" name="pdf" id="pdf"';
	if (array_key_exists('pdf',$mod_errors)) {
		echo ' class="error" /><span class="error">' . $mod_errors['pdf'] . '</span>';
	} else {
		echo ' />';
		if (isset($_SESSION['pdf'])) {
			echo "<br />Actuellement '" . $_SESSION['pdf']['file_name'] . "'";
		} else {
			$filename = $pre_fil . '.pdf';
			echo '<br />Cliquez sur <a href="../menus/' . $filename .'" target="_blank" title="Cliquez ici pour afficher le fichier : ' . $filename . '.">' . $filename . '</a> pour visualiser le fichier actuel.';
		}
	}
?>
<br /><small>Fichier de type PDF seulement d'une taille inf&eacute;rieure &agrave; 2Mo.</small>
</p>
<input type="hidden" name="menuid" value="<?php 
	if (isset($_POST['menuid'])) {
		echo $_POST['menuid'];
	} else {
		echo $mid;
	}
	?>" />
<input type="submit" name="submit_button" value="Modifier ce menu" />
</form>
</fieldset>
<?php
	include('../inclusion/adminpied.php');
?>