<?php
		/**
		 *	script index.php
		 *
		 *	fichier de connexion à l'interface de gestion
		 *
		 */
		
	require('../inclusion/config.inc.php');
	require('../../dugala.inc.php');
	include('../inclusion/admin_form_function.inc.php');
	
	$login_errors = array();
	// vider les variables de session
	if (isset($_SESSION['memid'])) {
		$_SESSION=array();
		session_destroy();
		setcookie(session_name(),'',time()-300);
	}
	//si le formulaire a été soumis
	if (isset($_POST['submitted'])) {
		//vérification de l'identifiant
		if (preg_match('/^[ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿA-Z \'.-]{2,30}$/i',$_POST['identifiant'])) {
			$i = escape_data($_POST['identifiant']);
		} else {
			$login_errors['identifiant'] = "Veuillez entrer l'identifiant correctement.";
		}
		if (!empty($_POST['motpass'])) {
			$mdp = escape_data($_POST['motpass']);
		} else {
			$login_errors['motpass'] = "Veuillez entrer votre mot de passe.";
		}
		//si il n'y a pas d'erreur on verifie que l'identifiant existe
		if (empty($login_errors)) {
			$nmdp = get_password_hash($mdp);
			$q = "SELECT id, prenom, date_connexion FROM membres WHERE (mdpass='$nmdp' AND identifiant='$i')";
			$r = @mysqli_query($dbc,$q);
			if (mysqli_num_rows($r) == 1) {
				//on a trouvé le membre
				$row = mysqli_fetch_array($r, MYSQLI_NUM);
				$_SESSION['memid'] = $row[0];
				$_SESSION['memnom'] = $row[1];
				if ($row[2] != '0000-00-00 00:00:00') {
					$_SESSION['derconnex'] =date('d/m/Y',strtotime($row[2]));
				} else {
					$_SESSION['derconnex'] = "first";
				}
				//mettre à jour la date de connexion
				$q = "UPDATE membres SET date_connexion=CURRENT_TIMESTAMP WHERE id=" . $_SESSION['memid'];
				$r = @mysqli_query($dbc,$q);
				if (mysqli_affected_rows($dbc) != 1) {
					trigger_error("Une erreur s'est produite lors de la mise à jour de la dernière connexion du membre.");
				}
				mysqli_close($dbc);
				$url = BASE_ADMIN . 'principal.php';
				 header("Location:$url");
				 exit();				
			} else {
				$login_errors['login'] = "L'identifiant et le mot de passe ne correspondent pas &agrave; ceux du fichier.";
			}
		}
		//		FIN DE		if (empty($login_errors))	
		mysqli_close($dbc);
	}
	//		FIN DE		if (isset($_POST['submitted']))
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Interface administrative de mise &agrave; jour</title>
<link rel="stylesheet" type="text/css" href="../css/admin.css" />
</head>

<body>
<div id="global">
  <div id="entete">
    <h1> Interface administrative de mise &agrave; jour </h1>
    <p class="sous-titre"> Restaurant<strong> D'un Gout &agrave; l'Autre</strong> </p>
  </div>
  <!-- #entete -->
  <div id="contenu">
    <h2>Veuillez vous connecter &agrave; l'interface administrative :</h2>
    <fieldset>
      <legend>Vos identifiants de connexion : </legend>
      <form action="index.php" method="post"  accept-charset="utf-8" style="padding-left:100px">
      <?php 
	  //verifier qu'il n'y a pas d'erreur
	  if(array_key_exists('login',$login_errors)) {
		  echo '<span class="error">' . $login_errors['login'] . '</span><br />';
	  }
	  //verifier que l'on remet les labels à zéro
	  if (isset($_POST['identifiant'])) {
		  $_POST['identifiant'] = '';
	  }
	  if (isset($_POST['motpass'])) {
		  $_POST['motpass'] = '';
	  }
	  ?>
        <p>
          <label for="identifiant"><strong>Identifiant :</strong></label>
          <br />
          <?php create_form_input('identifiant','text',$login_errors,30,30); ?>
        </p>
         <p>
          <label for="motpass"><strong>Mot de passe :</strong></label>
          <br />
          <?php create_form_input('motpass','password',$login_errors,30,20); ?>
        </p>
        <input type="submit" name="submit_button" value="Se connecter" id="submit_button" />
        <input type="hidden" name="submitted" value="TRUE" />
        <p style="text-align:right"><a href="motpass_oubli.php" title="Cliquez ici, si vous avez oubli&eacute; votre mot de passe.">Mot de passe oubli&eacute; </a></p>
      </form>
    </fieldset>
  </div>
  <!-- #contenu -->
  
  <p id="copyright"> R&eacute;alisation &copy; 2011 <a href="http://www.iiidees.com" target="_new" title="Cliquez ici pour aller sur le site www.iiidees.com">www.iiidees.com</a></p>
</div>
<!-- #global -->
</body>
</html>
