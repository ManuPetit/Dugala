<?php
		/**
		 *
		 *	script livre_fil.php
		 *
		 *	permet de générer un fichier excel à télécharger
		 *
		 */
		
		require('../inclusion/config.inc.php');
		//verifier que l'utilisateur est logge
		redirect_invalid_user();
		$page_title = "G&eacute;n&eacute;ration de fichier email";
		$_SESSION['menuid'] = 7;
		include('../inclusion/admintete.php');
		require('../../dugala.inc.php');
		echo '<h2>G&eacute;n&eacute;ration de fichier email</h2>';
		
		if (isset($_POST['submission'])) {
			if ($_POST['type'] == 1) {
				$qs = "UPDATE livres SET export='B' WHERE export='A'";
			} else {
				$qs = "UPDATE livres SET export='B'";
			}
			$rs = @mysqli_query($dbc,$qs);
			if (mysqli_affected_rows($dbc) <1) {
				echo "<p>Il n'y a pas eu de nouveau contact depuis la derni&egrave;re g&eacute;n&eacute;ration de fichier email.</p><p>Si vous souhaitez quand m&ecirc;me g&eacute;n&eacute;rer un fichier email, choisissez l'option &quot;Tous les contacts pr&eacute;sents dans la base de donn&eacute;es&quot;.</p>";
				mysqli_close($dbc);
			} else {
				//on a des résultats on fait donc la requete
				$qc = "SELECT CONCAT(prenom, ' ', nom) AS pers, prenom, nom, email, ville, pays, telephone FROM livres WHERE export='B'";
				$rc = @mysqli_query($dbc, $qc); 
				if (mysqli_num_rows($rc) > 0) {
					$livre=array();
					while ($row=mysqli_fetch_array($rc,MYSQLI_ASSOC)) {
						$livre[] = array(
							'pers' => $row['pers'],
							'prenom' => $row['prenom'],
							'nom' => $row['nom'],
							'email' => $row['email'],
							'ville' => $row['ville'],
							'pays' => $row['pays'],
							'tele' => $row['telephone']
						);
					}
					include ('process_contact.php');
					//faire mise à jour de la base de données
					$qa = "UPDATE livres SET export='C' WHERE export='B'";
					$ra = @mysqli_query($dbc,$qa);
					echo "<p>Le fichier a &eacute;t&eacute; g&eacute;n&eacute;r&eacute; avec succ&egrave;s.</p><p>Cliquez sur <a href=\"contact_restau.csv\" title=\"T&eacute;l&eacute;chargez le fichier de contact pour importer dans Gmail.\">ce lien</a> pour sauvegarder le fichier sur votre ordinateur et l'importer dans Gmail.</p><br />";
					mysqli_close($dbc);
					include('../inclusion/adminpied.php');
					exit();
				}
			}
		} else {
			$q = "SELECT COUNT(id) FROM livres";
			$r = @mysqli_query($dbc,$q);
			$row = mysqli_fetch_array($r,MYSQLI_NUM);
			if ($row[0] < 1) {
				echo "<p>Il n'y a aucun commentaire dans la base de donn&eacute;es. Il n'est pas possible de g&eacute;n&eacute;rer le fichier email.</p><p>Revenez d&egrave;s que des commentaires auront &eacute;t&eacute; enregstr&eacute;s</p>";
				mysqli_close($dbc);
				include('../inclusion/adminpied.php');
				exit();
			}
		}				
		//		FIN DE		if (isset($_POST['submission']))
		
?>
<fieldset><legend>Choisissez le type de fichier &agrave; g&eacute;n&eacute;rer : </legend>
<form action="livre_fil.php" method="post" style="padding-left:100px">
<p><label for="type"><strong>Selectionnez le type :</strong></label><br />
<select name="type">
<option value="1">Seulement les nouveaux contacts (depuis la derni&egrave;re g&eacute;n&eacute;ration de fichier)</option>
<option value="2">Tous les contacts pr&eacute;sents dans la base de donn&eacute;es</option>
</select>
</p>
<input type="submit" name="submit" value="G&eacute;n&eacute;rer le fichier" />
<input type="hidden" name="submission" value="TRUE" />
<br /><p>N'appuyez qu'une seule fois sur le bouton.</p><p>Selon les nombre de donn&eacute;es &agrave; traiter, la g&eacute;n&eacute;ration du fichier csv peut prendre quelques minutes. Votre &eacute;cran se raffraichir d&egrave;s que le traitement sera temin&eacute;.</p>
</form>
</fieldset>
<br />
<?php
	include('../inclusion/adminpied.php');
?>