<?php
		/**
		 *	script motpass_oubli.php
		 *
		 *	fichier de creation d'un nouveau mot de passe en cas d'oubli
		 *
		 */
		 		 
		require('../inclusion/config.inc.php');
		include('../inclusion/admin_form_function.inc.php');
		$em_errors=array();
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			require('../../dugala.inc.php');
			if (filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
				//creer requete pour vérifier que email bien sur le site
				$e = escape_data($_POST['email']);
				$q = "SELECT id FROM membres WHERE email='" . $e ."' LIMIT 1";
				$r = @mysqli_query($dbc,$q);
				if (mysqli_num_rows($r) == 1) {
					list($uid)=mysqli_fetch_array($r, MYSQLI_NUM);
				} else {
					//pas d'email similaire
					$em_errors['email'] ="<br />L'adresse email que vous avez entr&eacute;e, ne correspond &agrave; aucune adresse pr&eacute;sente dans le fichier.<br />";
				}
				//		FIN DE		if (mysqli_num_rows($r) == 1) 
			} else {
				//mauvais format d'email
				$em_errors['email'] = "<br />Veuillez entrer une adresse email valide.<br />";
			}
			//		FIN DE		if (filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
			
			//si il n'y a pas d'erreur
			if (empty($em_errors)) {
				//creer mot de passe
				$p = escape_data(make_password(12));
				$q = "UPDATE membres SET mdpass='" . get_password_hash($p) . "' WHERE id=" . $uid . " LIMIT 1";
				$r = @mysqli_query($dbc,$q);
				if (mysqli_affected_rows($dbc) == 1) {
					//pas de problèmes
					$body = utf8_decode("Votre mot de passe pour vous connecter à l'interface administrative de mise à jour du restaurant D'un Gout à l'Autre a été modifié temporairement. Lors de votre prochaine connexion, veuillez utiliser le mot de passe suivant : " . $p . " et votre identifiant. Nous vous conseillons de changer ce mot de passe pour un qui vous soit plus familier.\n\nCordialement...\n\nPS: Ce message est généré automatiquement par le système. Veuillez ne pas y répondre.");
					$contact_email=$e;
					$s="Votre nouveau mot de passe";
					$fe="administration@dungoutalautre.fr";
					echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
					<html xmlns="http://www.w3.org/1999/xhtml">
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<title>Mot de passe oubli&eacute;</title>
					<link rel="stylesheet" type="text/css" href="../css/admin.css" />
					</head>
					<body>
					<div id="global">
					  <div id="entete">
						<h1>Interface administrative de mise &agrave; jour </h1>
						<p class="sous-titre"> Restaurant<strong> D\'un Gout &agrave; l\'Autre</strong> </p>
					  </div>
					  <!-- #entete -->
					  <div id="contenu">
					  <h2>Votre mot de passe a &eacute;t&eacute; modifi&eacute;</h2>';
					   echo '<p>Vous allez recevoir par email votre nouveau mot de passe. Une fois connect&eacute; &agrave; l\'interface administrative de mise &agrave; jour, vous pourrez changer votre mot de passe en choisissant le menu &quot;Mon profil&quot; et en cliquant ensuite sur l\'option &quot;Changer mot de passe&quot;</p>';
					mail($contact_email,$s,$body,"From:".$fe);
					
					  mysqli_close($dbc);
					  include('../inclusion/adminpied.php');
					  exit();
				} else {
					trigger_error("Votre mot de passe n'a pas pu &ecirc;tre chang&eacute; &agrave; cause d'une erreur syst&egrave;me. Veuillez nous en excuser. Si le probl&egrave;me persiste, veuillez contacter l'adminsitrateur.");
				}
				//		FIN DE		if (mysqli_affected_rows($dbc) == 1)
			}
			//		FIN DE		if (empty($em_errors)) 
			mysqli_close($dbc);		  
		}
		//		FIN DE		if ($_SERVER['REQUEST_METHOD'] == 'POST')
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mot de passe oubli&eacute;</title>
<link rel="stylesheet" type="text/css" href="../css/admin.css" />
</head>

<body>
<div id="global">
  <div id="entete">
    <h1>Interface administrative de mise &agrave; jour </h1>
    <p class="sous-titre"> Restaurant<strong> D'un Gout &agrave; l'Autre</strong> </p>
  </div>
  <!-- #entete -->
  <div id="contenu">
    <h2>Vous avez oubli&eacute; votre mot de passe</h2>
    <fieldset><legend>Entrez votre adresse email enregistr&eacute;e sur le syst&egrave;me : </legend>
    <form action="motpass_oubli.php" method="post" accept-charset="utf-8" style="padding-left:100px">
<p><label for="email"><strong>Votre email :</strong></label><br />
<?php create_form_input('email','text',$em_errors,60,80); ?>
</p>
<input type="submit" name="submit" value="G&eacute;n&eacute;rer nouveau mot de passe" />
</form>
</fieldset>
  </div>
  <!-- #contenu -->  
  <p id="copyright"> R&eacute;alisation &copy; 2011 <a href="http://www.iiidees.com" target="_new" title="Cliquez ici pour aller sur le site www.iiidees.com">www.iiidees.com</a></p>
</div>
<!-- #global -->
</body>
</html>
		