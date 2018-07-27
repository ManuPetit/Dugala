<?php
		/**
		 *	script profil_mdp.php
		 *
		 *	page d'edition du profil
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "Changer mon mot de passe";
		$_SESSION['menuid'] = 1;
		include('../inclusion/admintete.php');
		require('../../dugala.inc.php');
		include('../inclusion/admin_form_function.inc.php');
		$mdp_errors=array();
				
		//validation des données
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (isset($_POST['mdpa'])) {
				//ici par sécurité on ne fait aucune vérification
				$mdp1 = escape_data($_POST['mdpa']);
				$q = "SELECT nom FROM membres WHERE mdpass='" . get_password_hash($mdp1) . "' AND id=" . $_SESSION['memid'];
				$r = mysqli_query($dbc,$q);
				if (mysqli_num_rows($r) != 1) {
					$mdp_errors['mdpa'] = "Mauvais mot de passe actuel.";
				}				
			} else {
				$mdp_errors['mdpa'] = "Veuillez entrer votre mot de passe actuel.";
			}
			if (preg_match('/^(\w){6,20}$/', $_POST['mdpnu'])) {
				//mot de passe 1 ok verifier que le mot de passe 2 soit pareil
				if ($_POST['mdpnu'] == $_POST['mdpnd']) {
					$mdpass=escape_data($_POST['mdpnu']);
				} else {
					$mdp_errors['mdpnd'] = "La confirmation de votre mot de passe ne correspond pas &agrave; votre nouveau mot de passe.";
				}
			} else {
				$mdp_errors['mdpnu'] = "Votre nouveau mot de passe ne correspond pas aux r&egrave;gles pr&eacute;cis&eacute;es ci-dessous.";
			}
			if (empty($mdp_errors)) {
				//on a pas d'ereurs
				$q = "UPDATE membres SET mdpass='" . get_password_hash($mdpass) . "' WHERE id=" . $_SESSION['memid'];
				if ($r=mysqli_query($dbc,$q)) {
					//update ok
					echo '<h2>Changement de votre mot de passe</h2><p>Votre mot de passe a &eacute;t&eacute; mis &agrave; jour avec succ&eacute;s.</p><p>N\'oubliez pas d\'utiliser ce nouveau mot de passe pour votre prochaine connexion.</p><p>Mer&ccedil;i...</p>';
					mysqli_close($dbc);
					include ('../inclusion/adminpied.php');
					exit();
				} else {
					echo '<h2>Changement de votre mot de passe</h2><p>Votre mot de passe n\'a pas pu &ecirc;tre modifier.</p><p>Veuillez recommencer s\'il vous plait.</p><p>
					Si l\'erreur persiste, contactez l\'administrateur du site...</p>';
					mysqli_close($dbc);
					include ('../inclusion/adminpied.php');
					exit();
				}
			}
			mysqli_close($dbc);
			//remettre variable à zero
			$_POST['mdpa']=NULL;
			$_POST['mdpnu']=NULL;
			$_POST['mdpnd']=NULL;
			
		}
		//		FIN DE		if ($_SERVER['REQUEST_METHOD'] == 'POST') 
		
?>
<h2>Changer mon mot de passe</h2>
<fieldset><legend>Modifiez votre mot de passe : </legend>
<form action="profil_mdp.php" method="post" accept-charset="utf-8" style="padding-left:100px">
<p><label for="mdpa"><strong>Votre mot de passe actuel :</strong></label><br />
<?php create_form_input('mdpa','password',$mdp_errors,30,20); ?>
</p>
<p><label for="mdpnu"><strong>Votre nouveau mot de passe :</strong></label><br />
<?php create_form_input('mdpnu','password',$mdp_errors,30,20); ?>
</p>
<p><label for="mdpnd"><strong>Confirmez votre nouveau mot de passe :</strong></label><br />
<?php create_form_input('mdpnd','password',$mdp_errors,30,20); ?>
</p>
<input type="submit" name="submit" value="Changer le mot de passe" />
<p><strong>Attention</strong><br /><ul><li>Votre nouveau mot de passe ne peut contenir que des lettres ou des chiffres.</li><li>Il tient compte de la casse des lettres (majuscule et minuscule).</li><li>Il doit &ecirc;tre compos&eacute; de 6 &agrave; 20 caractères.</li></ul></p>
</form>
</fieldset>
<?php
	include('../inclusion/adminpied.php');
?>