<?php
		/**
		 *
		 *		script contactus.php
		 *
		 *		page d'accueil anglaise du site
		 *
		 */
		 
		 $menuid = 5;
		 $lang = '_gb'; 
		 include('inclusion/config.inc.php');
		 include('inclusion/sitetete.php');
		 include('inclusion/admin_form_function.inc.php');
		 $liv_errors=array();
		 $safe = 0;
		 
		 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (preg_match('/^[ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿA-Z \'.-]{2,50}$/i',stripslashes($_POST['nom']))) {
				$n = utf8_decode(stripslashes($_POST['nom']));
			} else {
				$liv_errors['nom'] = "<br /><small>Please enter your name correctly.</small>";
			}
			if (filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
				$e = $_POST['email'];
			} else {
				$liv_errors['email'] = "<br /><small>The submitted email is not a valid email.</small>";
			}
			if (preg_match('/^[0-9 -]{10,20}$/u',stripslashes($_POST['tele']))) {
				$te = str_replace(' ','',$_POST['tele']);
			} else {
				$liv_errors['tele'] = "<br /><small>This is not a valid phone number.</small>";
			}
			if (preg_match('/^[a-zA-Z0-9 ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ€;?!.;,:"\'-]{3,100}$/u',stripslashes($_POST['sujet']))) {
				$s = utf8_decode(stripslashes($_POST['sujet']));
			} else {
				$liv_errors['sujet'] = "<br /><small>Some typed characters are not valid. Please correct.</small>";
			}
			if (preg_match('/^[a-zA-Z0-9 ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ€;?!().;,:"\'\n\r-]{3,10000}$/u',stripslashes($_POST['message']))) {
				$m = stripslashes($_POST['message']);
			} else {
				$liv_errors['message'] = "<small>Some typed characters are not valid. Please correct.</small>";
			}
			
			if (empty($liv_errors)) {
				$body = utf8_decode("Message de " . $n . " (Téléphone " . $te . " ) :\r\n" . $m);
				
				mail($contact_email,$s,$body,"From:".$e);
				
				$safe = 1;
			} 
		 }
		 //		FIN DE		if ($_SERVER['REQUEST_METHOD'] == 'post')
?>
<div id="gauche"><h3>To contact us</h3>
<div class="evene">
<p><span class="titre">Address</span><br />
D'un Gout &agrave; l'Autre<br />
21 rue des D&eacute;port&eacute;s<br />
26110 Nyons<br />
France</p></div>
<br />
<div class="evene">
<p><span class="titre">Telephone</span><br />
00 33 4 75 26 62 27</p></div>
<br />
</div>
<?php
	if ($safe == 0) {
?>
<div id="contenu"><h3>Contact us...</h3>
<p>For all enquiries, do not hesitate to send us a message.</p>
<fieldset style="margin-left:10px;width:484px;"><legend>Your message: </legend>
<form action="contact.php" method="post" accept-charset="utf-8">
<p>
<label for="prenom"><strong>Your name: </strong></label>
<?php create_form_input('nom','text',$liv_errors,55,50); ?>
</p>
<p>
<label for="email"><strong>Your email: </strong></label>
<?php create_form_input('email','text',$liv_errors,55,80); ?>
</p>
<p>
<label for="tele"><strong>Your phone number : </strong></label>
<?php create_form_input('tele','text',$liv_errors,35,20); ?>
<br /><small>We will only use this number if we need to contact you.</small>
</p>

<p>
<label for="sujet"><strong>Subject: </strong></label>
<?php create_form_input('sujet','text',$liv_errors,59,100); ?>
</p>
<p>
<label for="message"><strong>Your message: </strong></label><br />
<?php create_form_input('message','textarea3',$liv_errors,39,10); ?>
</p>
<div align="center">
<input type="submit" name="submit" value="Send your message" />
</div>
</form>
</fieldset>
<?php
	} else {
?>
<div id="contenu"><h3>Your message has been sent with success...</h3>
<p>We will get back in touch with you, as soon as possible.</p>
<p>Thank you...</p>
<?php
	}
?>
<br />
</div>
<?php
	include('inclusion/sitepied.php');
?>