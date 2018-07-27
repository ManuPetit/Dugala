<?php
		/**
		 *
		 *		script		create_xml.php
		 *
		 *		permet la création de deux fichier xml pour le slide show
		 *
		 */
		 $pfolder = '../images/';
		 $pfile_fr = 'photofr.xml';
		 $pfile_gb = 'photogb.xml';
		 $pfull_fr = $pfolder . $pfile_fr;
		 $pfull_gb = $pfolder . $pfile_gb;
		 //on detruit les deux fichiers
		 if (file_exists($pfull_fr)) {
			 unlink($pfull_fr);
		 }
		 if (file_exists($pfull_gb)) {
			 unlink($pfull_gb);
		 }
		 //faire la requete
		 $qq = "SELECT nom_fr, nom_gb, fichier FROM photos WHERE visible='Oui' ORDER BY id";
		 $rr = @mysqli_query($dbc,$qq);
		 if (mysqli_num_rows($rr) > 0) {
			 $pphoto = array();
			 while($row=mysqli_fetch_array($rr, MYSQLI_ASSOC)) {
				$ppiece = explode('.',$row['fichier']);
				$pfile = 'images/' . $ppiece[0] . '_th.' . $ppiece[1];
				if ($row['nom_fr'] == 'Photo_Aucune') {
					$pdfr = ' ';
				} else {
					$pdfr = $row['nom_fr'];
				}
				if ($row['nom_gb'] == 'Photo_Aucune') {
					$pdgb = ' ';
				} else {
					$pdgb = $row['nom_gb'];
				}				
				$pphoto[] = array(
					'pnfr' => $pdfr,
					'pngb' => $pdgb,
					'pfil' => $pfile
				);
			 }
			 //fichier franç&ais
			 $fichierfr = fopen($pfull_fr,"w");
			 $_xml ="<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n";
			 $_xml .="<SLIDESHOW SPEED=\"5\">\r\n";
			 for ($i=0; $i<count($pphoto); $i++) {
				 $_xml .= "<IMAGE URL=\"" . $pphoto[$i]['pfil'] . "\" TITLE=\"" . $pphoto[$i]['pnfr'] . "\" />\r\n";
			 }
			 $_xml .= "</SLIDESHOW>";
			 
			 fwrite($fichierfr, $_xml);
			 fclose($fichierfr);
			 
			 //fichier anglais
			 $fichiergb = fopen($pfull_gb,"w");
			 $_xml ="<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n";
			 $_xml .="<SLIDESHOW SPEED=\"2\">\r\n";
			 for ($i=0; $i<count($pphoto); $i++) {
				 $_xml .= "<IMAGE URL=\"" . $pphoto[$i]['pfil'] . "\" TITLE=\"" . $pphoto[$i]['pngb'] . "\" />\r\n";
			 }
			 $_xml .= "</SLIDESHOW>";
			 
			 fwrite($fichiergb, $_xml);
			 fclose($fichiergb);
		 }
?>