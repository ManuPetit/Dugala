<?php
		/**
		 *
		 *		script contact.php
		 *
		 *		page d'accueil anglaise du site
		 *
		 */
		 
		 $menuid = 5;
		 $lang = '_fr'; 
		 include('inclusion/config.inc.php');
		 include('inclusion/sitetete.php');
		 include('inclusion/admin_form_function.inc.php');
		 $liv_errors=array();
		 $safe = 0;
		 
		 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (preg_match('/^[ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿA-Z \'.-]{2,50}$/i',stripslashes($_POST['nom']))) {
				$n = utf8_decode(stripslashes($_POST['nom']));
			} else {
				$liv_errors['nom'] = "<br /><small>Veuillez entrer votre nom correctement.</small>";
			}
			if (filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
				$e = $_POST['email'];
			} else {
				$liv_errors['email'] = "<br /><small>L'adresse email n'est pas une adresse valide.</small>";
			}
			if (preg_match('/^[a-zA-Z0-9 ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ€;?!.;,:"\'-]{3,100}$/u',stripslashes($_POST['sujet']))) {
				$s = utf8_decode(stripslashes($_POST['sujet']));
			} else {
				$liv_errors['sujet'] = "<br /><small>Certains caract&egrave;res ne sont pas accept&eacute;s. Veuillez corriger.</small>";
			}
			if (preg_match('/^[0-9 -]{10,20}$/u',stripslashes($_POST['tele']))) {
				$te = str_replace(' ','',$_POST['tele']);
			} else {
				$liv_errors['tele'] = "<br /><small>Le num&eacute;ro de t&eacute;l&eacute;phone que vous avez entr&eacute; n'est pas valide.</small>";
			}
			if (preg_match('/^[a-zA-Z0-9 ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ€;?!().;,:"\'\n\r-]{3,10000}$/u',stripslashes($_POST['message']))) {
				$m = stripslashes($_POST['message']);
			} else {
				$liv_errors['message'] = "<small>Certains caract&egrave;res ne sont pas accept&eacute;s. Veuillez corriger.</small>";
			}
			
			if (empty($liv_errors)) {
				$body = utf8_decode("Message de " . $n . " (Téléphone " . $te . " ) :\r\n" . $m);
				mail($contact_email,$s,$body,"From:".$e);
				
				$safe = 1;
			} 
		 }
		 //		FIN DE		if ($_SERVER['REQUEST_METHOD'] == 'post')
?>
<div id="gauche"><h3>Nos coordonn&eacute;es</h3>
<div class="evene">
<p><span class="titre">Adresse</span><br />
D'un Gout &agrave; l'Autre<br />
21 rue des D&eacute;port&eacute;s<br />
26110 Nyons</p></div>
<br />
<div class="evene">
<p><span class="titre">T&eacute;l&eacute;phone</span><br />
04 75 26 62 27</p></div>
<br />
</div>
<?php
	if ($safe == 0) {
?>
<div id="contenu"><h3>Contactez nous...</h3>
<p>Pour toute demande de renseignements, n'h&eacute;sitez pas &agrave; nous envoyer un message.</p>
<fieldset style="margin-left:10px;width:484px;"><legend>D&eacute;tails de votre message : </legend>
<form action="contact.php" method="post" accept-charset="utf-8">
<p>
<label for="prenom"><strong>Votre nom : </strong></label>
<?php create_form_input('nom','text',$liv_errors,55,50); ?>
</p>
<p>
<label for="email"><strong>Votre email : </strong></label>
<?php create_form_input('email','text',$liv_errors,54,80); ?>
</p>
<p>
<label for="tele"><strong>Votre num&eacute;ro de t&eacute;l&eacute;phone : </strong></label>
<?php create_form_input('tele','text',$liv_errors,35,20); ?>
<br /><small>Ce num&eacute;ro ne sera utilis&eacute; que si nous avons besoin de vous contacter.</small>
</p>
<p>
<label for="sujet"><strong>Sujet de votre message : </strong></label>
<?php create_form_input('sujet','text',$liv_errors,39,100); ?>
</p>
<p>
<label for="message"><strong>Votre message : </strong></label><br />
<?php create_form_input('message','textarea3',$liv_errors,39,10); ?>
</p>
<div align="center">
<input type="submit" name="submit" value="Envoyez votre message" />
</div>
</form>
</fieldset>
<?php
	} else {
?>
<div id="contenu"><h3>Votre message a bien &eacute;t&eacute; envoy&eacute;...</h3>
<p>Nous vous contacterons d&egrave;s que possible.</p>
<p>Merci...</p>
<?php
	}
?>
<br />
</div>
<?php
	include('inclusion/sitepied.php');
?>