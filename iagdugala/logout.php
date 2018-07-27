<?php
		/**
		 *	script logout.php
		 *
		 *	fichier de déconnexion à l'interface de gestion
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		//détruire la session
		$_SESSION=array();
		session_destroy();
		setcookie(session_name(),'',time()-300);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>D&eacute;connexion de l'interface administrative</title>
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
    <h2>Merci de votre visite.</h2>
    <p>Vous &ecirc;tes maintenant d&eacute;connect&eacute; de l'interface administrative de mise &agrave; jour</p>
    <p>Vous pouvez voir les changements de votre site en cliquant sur <a href="<?php echo BASE_URL_FR; ?>" title="Cliquez ici pour aller sur la page d'acceuil du site &quot;D'un Gout &agrave; l'Autre&quot;.">ce lien</a>, ou vous pouvez faire d'autres changements en vous <a href="index.php" title="Cliquez ici pour vous reconnecter &agrave; l'interface administrative de mise &agrave; jour.">identifiant</a> de nouveau.</p>
    <p>A bient&ocirc;t...</p>
  </div>
  <!-- #contenu -->  
  <p id="copyright"> R&eacute;alisation &copy; 2011 <a href="http://www.iiidees.com" target="_new" title="Cliquez ici pour aller sur le site www.iiidees.com">www.iiidees.com</a></p>
</div>
<!-- #global -->
</body>
</html>