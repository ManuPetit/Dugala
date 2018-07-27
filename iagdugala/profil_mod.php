<?php
		/**
		 *	script profil_mod.php
		 *
		 *	page d'edition du profil
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Editer mon profil";
		$_SESSION['menuid'] = 1;
		include('../inclusion/admintete.php');
		require('../../dugala.inc.php');
		include('../inclusion/admin_form_function.inc.php');
		$pro_errors=array();
		
		//retrouver les valeurs d'origine
		$q = "SELECT identifiant, email, prenom, nom FROM membres WHERE id=" . $_SESSION['memid'] . " LIMIT 1";
		$r = @mysqli_query($dbc,$q);
		if (mysqli_num_rows($r) == 1) {
			$row = mysqli_fetch_array($r, MYSQLI_NUM);
			$pre_i = $row[0];
			$pre_e = $row[1];
			$pre_p = $row[2];
			$pre_n = $row[3];
		} else {
			echo "Une erreur s'est produite. Veuillez consulter l'administrateur du syst&egrave;me...";
			include('../inclusion/adminpied.php');
			exit();
		}
		
		//la page est submitted
		if (isset($_POST['soumission'])) {
			//verification des données
			if (preg_match('/^[ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿA-Z \'.-]{2,20}$/i',stripslashes($_POST['prenom']))) {
				$p = escape_data($_POST['prenom']);
			} else {
				$pro_errors['prenom'] = "Veuillez entrer le pr&eacute;nom correctement.";
			}
			//vérification du nom
			if (preg_match('/^[ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿA-Z \'.-]{2,40}$/i',stripslashes($_POST['nom']))) {
				$n = escape_data($_POST['nom']);
			} else {
				$pro_errors['nom'] = "Veuillez entrer le nom correctement.";
			}
			//vérification de l'identifiant
			if (preg_match('/^[ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿA-Z \'.-]{2,30}$/i',stripslashes($_POST['identifiant']))) {
				$i = escape_data($_POST['identifiant']);
			} else {
				$pro_errors['identifiant'] = "Veuillez entrer l'identifiant correctement.";
			}
			//verification de l'email
			if (filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
				$e = escape_data($_POST['email']);
			} else {
				$pro_errors['email'] = "L'adresse email n'est pas une adresse valide.";
			}
			if (empty($pro_errors)) { //on a pas d'erreurs
				//verification email et identifiant unique
				$q = "SELECT email, identifiant FROM membres WHERE (email='$e' OR identifiant='$i') AND id!=" . $_SESSION['memid'];
				$r = @mysqli_query($dbc,$q);
				if  (mysqli_num_rows($r) == 0) {
					//identifiant et email non utilisé par un autre membre
					$update=array();
					if ($p != $pre_p) {
						$update[] = " prenom='" . $p . "'";
					}
					if ($n != $pre_n) {
						if (!empty($update)) {
							$update[] = ", nom='" . $n . "'";
						} else {
							$update[] = " nom='" . $n . "'";
						}
					}
					if ($i != $pre_i) {
						if (!empty($update)) {
							$update[] = ", identifiant='" . $i . "'";
						} else {
							$update[] = " identifiant='" . $i . "'";
						}
					}
					if ($e != $pre_e) {
						if (!empty($update)) {
							$update[] = ", email='" . $e . "'";
						} else {
							$update[] = " email='" . $e . "'";
						}
					}
					//si il y a des changement on crée le update
					if (!empty($update)) {
						$q = "UPDATE membres SET";
						for ($i=0; $i<count($update); $i++){
							$q .= $update[$i];
						}
						$q .= " WHERE id=" . $_SESSION['memid'] . " LIMIT 1";
						$r = @mysqli_query($dbc,$q);
						if (mysqli_affected_rows($dbc) == 1) {
							//update ok
							echo '<h2>Mise &agrave; jour du profil termin&eacute;e</h2><p>Votre profil a &eacute;t&eacute; mis &agrave; jour avec succ&eacute;s.</p><p>Mer&ccedil;i...</p>';
							mysqli_close($dbc);
							include ('../inclusion/adminpied.php');
							exit();
						} else {
							echo '<h2>Mise &agrave; jour du profil abort&eacute;e</h2><p>Votre profil n\'a pas pu &ecirc;tre mis &agrave; jour.</p><p>Veuillez recommencer s\'il vous plait.</p><p>
							Si l\'erreur persiste, contactez l\'administrateur du site...</p>';
							mysqli_close($dbc);
							include ('../inclusion/adminpied.php');
							exit();
						}
					} else {
						echo '<h2>Pas de modification</h2><p>Aucun &eacute;l&eacute;ment n\'a &eacute;t&eacute; modifi&eacute; sur votre profil.</p>';
						mysqli_close($dbc);
						include('../inclusion/adminpied.php');
						exit();
					}
					//		FIN DE 		if (!empty($update)) 
				} else {
					$rows = mysqli_num_rows($r);
					if ($rows == 2) {
						//identifiant et email déjà utilisté
						$pro_errors['email'] = "Cette adresse email a d&eacute;j&agrave; &eacute;t&eacute; utilis&eacute;e. Veuillez en fournir une autre.";
						$pro_errors['identifiant'] = "Cet identifiant a d&eacute;j&agrave; &eacute;t&eacute; utilis&eacute;. Veuillez en fournir un autre.";
					} else {
						//identifiant et/ou email ou les deux déjà utilisé
						$row=mysqli_fetch_array($r,MYSQLI_NUM);
						if (($row[0] == $_POST['email']) && ($row[1] == $_POST['identifiant'])) {//les deux
							$pro_errors['email'] = "Cette adresse email a d&eacute;j&agrave; &eacute;t&eacute; utilis&eacute;e. Veuillez en fournir une autre.";
							$pro_errors['identifiant'] = "Cet identifiant a d&eacute;j&agrave; &eacute;t&eacute; utilis&eacute;. Veuillez en fournir un autre.";
						} elseif ($row[0] == $_POST['email']) {
							$pro_errors['email'] = "Cette adresse email a d&eacute;j&agrave; &eacute;t&eacute; utilis&eacute;e. Veuillez en fournir une autre.";
						} elseif ($row[1] == $_POST['identifiant']) {
							$pro_errors['identifiant'] = "Cet identifiant a d&eacute;j&agrave; &eacute;t&eacute; utilis&eacute;. Veuillez en fournir un autre.";
						}
					}
					//		FIN DE		if ($rows == 2)
				}
				//		FIN DE		if  (mysqli_num_rows($r) == 0)
			}
		}
		//		FIN DE		if (isset($_POST['soumission']))
		mysqli_close($dbc);
?>
<h2>Editer mon profil</h2>
<fieldset><legend>Modifiez vos détails : </legend>
<form action="profil_mod.php" method="post" accept-charset="utf-8" style="padding-left:100px">
<p><label for="prenom"><strong>Pr&eacute;nom :</strong></label><br />
<?php create_form_edit('prenom','text',$pro_errors,30,20,$pre_p); ?>
</p>
<p><label for="nom"><strong>Nom :</strong></label><br />
<?php create_form_edit('nom','text',$pro_errors,30,40,$pre_n); ?>
</p>
<p><label for="identifiant"><strong>Identifiant de connexion :</strong></label><br />
<?php create_form_edit('identifiant','text',$pro_errors,30,30,$pre_i); ?>
</p>
<p><label for="email"><strong>Email :</strong></label><br />
<?php create_form_edit('email','text',$pro_errors,40,80,$pre_e); ?>
</p>
<input type="submit" name="submit" value="Mettre &agrave; jour" />
<input type="hidden" name="soumission" value="TRUE" />
</form>
</fieldset>
<?php 
	include('../inclusion/adminpied.php');
?>
