<?php
	
		/**
		 *
		 *		script process_contact.php
		 *
		 *		creation du fichier pour importer dans gmail
		 *
		 */
		 $fichier='contact_restau.csv';
		 if (file_exists($fichier)) {
			 //detruire le fichier
			 unlink($fichier);
		 }
		 $contact = fopen($fichier,"w");
		 $mes = "Name,Given Name,Additional Name,Family Name,Yomi Name,Given Name Yomi,Additional Name Yomi,Family Name Yomi,Name Prefix,Name Suffix,Initials,Nickname,Short Name,Maiden Name,Birthday,Gender,Location,Billing Information,Directory Server,Mileage,Occupation,Hobby,Sensitivity,Priority,Subject,Notes,Group Membership,E-mail 1 - Type,E-mail 1 - Value,Phone 1 - Type,Phone 1 - Value,Phone 2 - Type,Phone 2 - Value,Address 1 - Type,Address 1 - Formatted,Address 1 - Street,Address 1 - City,Address 1 - PO Box,Address 1 - Region,Address 1 - Postal Code,Address 1 - Country,Address 1 - Extended Address,Website 1 - Type,Website 1 - Value\r\n";
		 for ($i=0; $i < count($livre); $i++) {
			 $mes .= $livre[$i]['pers'] . ',' . $livre[$i]['prenom'] . ',,' . $livre[$i]['nom'] . ',,,,,,,,,,,,,,,,,,,,,,,Clients,* Home,';
			 $mes .= $livre[$i]['email'] . ',';
			 if ($livre[$i]['tele'] != 'x') {
				 $mes .= 'Home,' . $livre[$i]['tele'] . ',,,';
			 } else {
				 $mes .= ',,,,';
			 }
			 $lieu = NULL;
			 if ($livre[$i]['ville'] != '0a') {
				 $lieu = $livre[$i]['ville'];
			 }
			 if ($livre[$i]['pays'] != '0a') {
				 if (isset($lieu)) {
					 $lieu .= '(' . $livre[$i]['pays'] . ')';
				 } else {
					 $lieu = $livre[$i]['pays'];
				 }
			 }
			 if (isset($lieu)) {
				 $mes .= 'Home,' . $lieu . ',,,,,,,,,';
			 } else {
				 $mes .= ',,,,,,,,,,';
			 }
			 $mes .= "\r\n";
		 }
		 fwrite($contact,$mes);
		 fclose($contact);
?>