<?php
		/**
		 *	script imgf_ajou.php
		 *
		 *	page permettant d'ajouter une image de fond
		 *
		 */
		
		require('../inclusion/config.inc.php');
		require('../../dugala.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Ajouter une nouvelle image de fond";
		$_SESSION['menuid'] = 8;
		include('../inclusion/admintete.php');
		include('../inclusion/admin_form_function.inc.php');
		$pto_errors=array();
		echo '<h2>Ajouter une nouvelle image de fond</h2>';
		
		//validation des entrées
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//validation des entrées
			if (trim($_POST['nomfr']) != '') {
				if (preg_match('/^[^<>"]{4,45}$/u',stripslashes($_POST['nomfr']))) {
					$nfr = escape_data($_POST['nomfr']);
				} else {
					$pto_errors['nomfr'] = "<br />Certains caract&egrave;res ne sont pas accept&eacute;s. Veuillez corriger.";
				}
			}
			
			//verifiaction de l'image
			if ((isset($_FILES['img']['name'])) && (!empty($_FILES['img']['name']))) {
				if (is_uploaded_file($_FILES['img']['tmp_name']) && ($_FILES['img']['error'] == UPLOAD_ERR_OK)) {
					$file = $_FILES['img'];
					$size = ROUND($file['size']/1024);
					if ($size > 5120) {
						$pto_errors['img'] = "<br />Le fichier image est trop volumineux. Taille maximum : 5 Mo!";
					}
					$all_mime = array('image/pjpeg', 'image/jpeg', 'image/JPG');
					$all_ext = array ('.jpg', 'jpeg');
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
							createthumb($dest,175,175);
							echo '<p>Création des images pour le site</p>';
							//tailler l'image
							include 'imageslicer.php';
							echo '<p>Fin de création des images pour le site</p>';
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
			if (empty($pto_errors)){
				$name = $_SESSION['img']['new_name'];
				$v = escape_data($_POST['visible']);
				if ($v=='Oui'){
					//on doit changer toutes les images à 0 dans la base de données
					$sql = 'UPDATE photofond SET IsActive = 0';
					$r = @mysqli_query($dbc, $sql);
					$vval = 1;
				}else{
					$vval=0;
				}
				$sql = "INSERT INTO photofond(nom, datecreer, nomfichier, IsActive,nomThumb) VALUES('" . $nfr . "',NOW(),'" . $_SESSION['imgnom'] . "'," . $vval . ",'" . $name ."')";
				$r = @mysqli_query($dbc, $sql);
				if (mysqli_affected_rows($dbc) == 1) {
					//ca a marché
					echo '<p>Le fond d\'écran a bien été ajouté à la base de données.</p>';
					if ($vval == 1){
						$mes ='@charset "utf-8";
						/* CSS Document */
						#entere {
							background-image:url(../images/css/chead' . $_SESSION['imgnom'] . ');
							background-repeat:no-repeat;
						}
						#wrapper {
							background-image:url(../images/css/ccorps' . $_SESSION['imgnom'] . ');
							background-repeat:repeat-y;
						}';
						$myccs="../css/photo.css";
						if ($fh = fopen($myccs, 'w')){
							fwrite($fh,$mes);
							fclose($fh);
							echo '<p>Le nouveau fond d\'écran a été activé sur le site.</p>';
						}else{
							echo '<p>Le nouveau fond d\'écran n\'a pas pu être activé sur le site.</p>';
						}		
					}
					$_POST = array();
					$_FILES = array();
					unset($file,$_SESSION['img']);
					unset($file,$_SESSION['imgnom']);
					include('../inclusion/adminpied.php');
					mysqli_close($dbc);
					exit();
				} else {
					trigger_error("<p>Le fond d\'écran n\'a pas pu être ajouté à la base de données.Veuillez recommencer s'il vous plait.</p><p>
					Si l'erreur persiste, contactez l'administrateur du site...</p>");
					unlink($dest);
					mysqli_close($dbc);
				}			
				
			}
		}//			fin de if ($_SERVER['REQUEST_METHOD'] == 'POST') {
?>

<p>Veuillez entrer les détails de votre nouveau fond d'écran</p>
<fieldset>
  <legend>D&eacute;tails de la photo : </legend>
  <form action="imgf_ajou.php"  method="post" accept-charset="utf-8" style="padding-left:100px" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
    <p>
      <label for="nomfr"><strong>Donnez un nom à cette image :</strong></label>
      <br />
      <?php create_form_input('nomfr','text',$pto_errors,70,45); ?>
    </p>
    <p>
      <label for="visible"><strong>Activer cette image de suite : </strong></label>
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
    <p>
      <label for="img"><strong>Fichier image &agrave; t&eacute;l&eacute;charger :</strong></label>
      <br />
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
?>
      <br />
      <small>Type de fichiers accept&eacute;s : <b>JPG seulement</b>, dont la taille est inf&eacute;rieure &agrave; 5Mo.</small> </p>
    <input type="submit" name="submit_button" value="Ajouter cette image de fond" />
  </form>
</fieldset>
<?php
	include('../inclusion/adminpied.php');
?>