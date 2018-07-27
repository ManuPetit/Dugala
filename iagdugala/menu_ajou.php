<?php
		/**
		 *	script menu_ajou.php
		 *
		 *	page permettant d'ajouter un menu ou une carte
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Ajouter un menu ou une carte";
		$_SESSION['menuid'] = 4;
		include('../inclusion/admintete.php');
		require('../../dugala.inc.php');
		include('../inclusion/admin_form_function.inc.php');
		$pdf_errors=array();
		echo '<h2>Ajouter un menu ou une carte</h2>';
		
		//validation des entrées
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (preg_match('/^[a-zA-Z0-9 ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ+;().,:\'-]{6,80}$/u',stripslashes($_POST['menufr']))) {
				$dfr = escape_data($_POST['menufr']);
			} else {
				$pdf_errors['menufr'] = "<br />Il y a des caractères non valide dans votre description du menu.";
			}
			
			if (trim($_POST['menugb']) == '') {
				//utilise version française
				if (isset($dfr)) {
					$dgb = $dfr;
					$_POST['menugb'] = $dfr;
				} else {
					$pdf_errors['menugb'] = "<br />En attente de correction du nom fran&ccedil;ais.";
				}
			} else if (preg_match('/^[a-zA-Z0-9 ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ+;().,:\'-]{6,80}$/u',stripslashes($_POST['menugb']))) {
				$dgb = escape_data($_POST['menugb']);
			} else {
				$pdf_errors['menugb'] = "<br />Il y a des caractères non valide dans votre description du menu.";
			}
			
			if (preg_match('/^[a-zA-Z0-9]{3,60}$/u',stripslashes($_POST['titre']))) {
				$t = escape_data($_POST['titre']);
			} else {
				$pdf_errors['titre'] = "<br />Le titre n'accepte que des caract&egrave;res alphanum&eacute;riques non accentu&eacute;s et sans espace.<br />Par exemple : MenuAvril2011.";
			}
			 
			//vérification que l'on a un fichier téléchargé
			
			if (is_uploaded_file($_FILES['pdf']['tmp_name']) && ($_FILES['pdf']['error'] == UPLOAD_ERR_OK)) {
				$file = $_FILES['pdf'];
				//vérifier la taille du fichier
				$size = ROUND($file['size']/1024);
				if ($size > 2048) {
					//fichier trop volumineux
					$pdf_errors['pdf'] = "<br />Le fichier t&eacute;l&eacute;charg&eacute; est trop volumineux. Sa taille doit &ecirc;tre inf&eacute;rieure &agrave; 2Mo.";
				}
				if (($file['type']!='application/pdf') || (substr($file['name'],-4)!='.pdf')) {
					$pdf_errors['pdf'] = '<br />Le fichier t&eacute;l&eacute;charg&eacute; n\'est pas un fichier PDF.';
				}
				if (!array_key_exists('pdf', $pdf_errors)) {
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
				//		FIN DE		if (!array_key_exists('pdf', $pdf_errors)) 
			} else if (!isset($_SESSION['pdf'])) {
				//pas de fichier
				switch($_FILES['pdf']['error']) {
					case 1:
					case 2:
						$pdf_errors['pdf'] = "<br />Le fichier &agrave; t&eacute;l&eacute;charger est trop volumineux.";
						break;
					case 3:
						$pdf_errors['pdf'] = "<br />Le fichier n'a &eacute;t&eacute; que partiellement t&eacute;l&eacute;charg&eacute;.";
						break;
					case 6:
					case 7:
					case 8:
						$pdf_errors['pdf'] = "<br />Le fichier n'a pas pu &ecirc;tre t&eacute;l&eacute;charg&eacute; &agrave; cause d'une erreur syst&egrave;me.";
						break;
					case 4:
					default:
						$pdf_errors['pdf'] = "<br />Aucun fichier n'a &eacute;t&eacute; t&eacute;l&eacute;charg&eacute;.";
						break;					
				}
				//		FIN DE		if (is_uploaded_file($_FILES['pdf']['tmp_name']) && ($_FILES['pdf']['error'] == UPLOAD_ERR_OK)) 
			}
			
			if (empty($pdf_errors)) {
				$fn = $t . '.pdf';
				$nsize = (int)$_SESSION['pdf']['size'];
				$vis = escape_data($_POST['visible']);
				$grp = escape_data($_POST['groupe']);
				//Faire la requête
				$q = "INSERT INTO menus (nom_fr, nom_gb, file_name, visible, groupe, taille) VALUES ('" . $dfr . "','" . $dgb . "','" . $fn . "','" . $vis . "','" . $grp . "',". $nsize .")";
				$r = @mysqli_query($dbc,$q);
				if (mysqli_affected_rows($dbc) == 1) {
					//ca a marché
					//renommer pdf
					$original =  PDF_DIR . $_SESSION['pdf']['tmp_name'] . '_tmp';
					$dest = PDF_DIR . $fn;
					rename($original,$dest);
					echo '<h4>Le fichier PDF a &eacute;t&eacute; ajout&eacute; avec succ&egrave;s sur le serveur distant.</h4>';
					$_POST = array();
					$_FILES = array();
					unset($file,$_SESSION['pdf']);
					echo "<p>Le menu est maintenant ajout&eacute; &agrave; la base de donn&eacute;es.</p>";
					include('../inclusion/adminpied.php');
					mysqli_close($dbc);
					exit();
				} else {
					trigger_error("Le fichier PDF n'a pas pu &ecirc;tre ajout&eacute; &agrave; cause d'une erreur syst&egrave;me.Veuillez recommencer s'il vous plait.
					Si l'erreur persiste, contactez l'administrateur du site...</p>");
					unlink($dest);
					mysqli_close($dbc);
				}
				//		FIN DE		if (mysqli_affected_rows($dbc) == 1)
			}
			//		FIN DE		if (empty($pdf_errors))
		} else {
			unset($_SESSION['pdf']);
		}
		//		FIN DE		if ($_SERVER['REQUEST_METHOD'] == 'POST')
?>
<p>Veuillez entrer les d&eacute;tails suivants pour enregistrer un nouveau menu ou une nouvelle carte.</p>
<fieldset><legend>D&eacute;tails du nouveau menu : </legend>
<form action="menu_ajou.php" method="post" accept-charset="utf-8" style="padding-left:100px" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
<p>
<label for="visible"><strong>Chosissez une cat&eacute;gorie pour ce menu : </strong></label><br />
<select name="groupe">
<?php
	if (isset($_POST['groupe'])) {
		if ($_POST['groupe'] == 'Me') {
			echo '<option value="Me" selected="selected">Menus</option>
		    <option value="Ms">Menus sp&eacute;ciaux</option>
		    <option value="Ca">Cartes</option>
		    <option value="Cb">Boissons</option>';
		} else if ($_POST['groupe'] == 'Ms') {
			echo '<option value="Me">Menus</option>
		    <option value="Ms" selected="selected">Menus sp&eacute;ciaux</option>
		    <option value="Ca">Cartes</option>
		    <option value="Cb">Boissons</option>';
		} else if ($_POST['groupe'] == 'Ca') {
			echo '<option value="Me">Menus</option>
		    <option value="Ms">Menus sp&eacute;ciaux</option>
		    <option value="Ca" selected="selected">Cartes</option>
		    <option value="Cb">Boissons</option>';
		} else if ($_POST['groupe'] == 'Cb') {
			echo '<option value="Me">Menus</option>
		    <option value="Ms">Menus sp&eacute;ciaux</option>
		    <option value="Ca">Cartes</option>
		    <option value="Cb" selected="selected">Boissons</option>';
		}
	} else {
		echo '<option value="Me">Menus</option>
		<option value="Ms">Menus sp&eacute;ciaux</option>
		<option value="Ca">Cartes</option>
		<option value="Cb">Boissons</option>';
	}
?>	
</select>
</p>
<p><label for="nomfr"><strong>Nom du menu en fran&ccedil;ais :</strong></label><br />
<?php create_form_input('menufr','text',$pdf_errors,70,80); ?>
</p>
<p><label for="nomgb"><strong>Nom du menu en anglais :</strong></label><br />
<?php 
	if ((isset($dgb)) && ($_POST['menugb'] =='')) {
		create_form_edit_translate('menugb','text',$pdf_errors,70,80,$dgb);
	} else {
		create_form_input('menugb','text',$pdf_errors,70,80); 
	}
?>       
<br><small>Si vous souhaitez utiliser le nom fran&ccedil;ais dans la version anglaise du site, laissez cette entrée vide.</small>
</p>
<p>
<label for="visible"><strong>Le menu sera visible sur le site internet : </strong></label>
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
<p><label for="titre"><strong>Donner un nom au fichier PDF :</strong></label><br />
<?php create_form_input('titre','text',$pdf_errors,50,60); ?>
<br /><small>Ce nom apparaitra comme le titre du fichier une fois t&eacute;l&eacute;charg&eacute;.</small>
</p>
<p><label for="pdf"><strong>Fichier PDF &agrave; t&eacute;l&eacute;charger :</strong></label><br />
<?php
	echo '<input type="file" size="50" name="pdf" id="pdf"';
	if (array_key_exists('pdf',$pdf_errors)) {
		echo ' class="error" /><span class="error">' . $pdf_errors['pdf'] . '</span>';
	} else {
		echo ' />';
		if (isset($_SESSION['pdf'])) {
			echo "<br />Actuellement '" . $_SESSION['pdf']['file_name'] . "'";
		}
	}
?><br /><small>Fichier de type PDF seulement d'une taille inf&eacute;rieure &agrave; 2Mo.</small>
</p>
<input type="submit" name="submit_button" value="Ajouter ce menu" />
</form>
</fieldset>
<?php
	include('../inclusion/adminpied.php');
?>