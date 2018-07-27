<?php
		/**
		 *
		 *		script index.php
		 *
		 *		page d'accueil française du site
		 *
		 */
		 
		 include('inclusion/config.inc.php');
		 include('inclusion/sitetete.php');
		 $menuid = 1;
		 $lang = '_fr';
		 //faire la requete pour l'image
		 $sql = 'SELECT fichier, desc_fr FROM photoopen WHERE IsShowing = 1 LIMIT 1';
		 $ra = @mysqli_query($dbc,$sql);
		 $img = mysqli_fetch_array($ra,MYSQLI_ASSOC);
		 if (!empty($img)){
			 $image = $img['fichier'];
			 $piece = explode('.',$image);
			 $photo = 'images/' . $piece[0] . '_th.' . $piece[1];
			 $size = getimagesize($photo); 
			 $desc = $img['desc_fr'];
			 $srcimg = '<img src="'.$photo.'" width="'.$size[0].'" height="'.$size[1].'" class="imgDroit" title="'.$desc.'" alt="'.$desc.'" />';
		 }else{
			 $srcimg ='<img src="images/imgAcc01.jpg" width="200" height="186" class="imgDroit" title="Photo ext&eacute;rieure du restaurant D\'un Gout &agrave; l\'Autre" alt="Photo ext&eacute;rieure du restaurant D\'un Gout &agrave; l\'Autre" />';
		 }
?>
<div id="gauche"><h3>Prochainement...</h3>
<?php
	//creation date du jour
	$aujour = time();
	$ladate = date('Y.m.d',$aujour);
	//faire la requete pour trouver tous les evnements
	$q = "SELECT evenements.nom_fr AS evene, DATE_FORMAT(evenements.date_evenement,'%d-%m-%Y') AS ladate, evenements.date_evenement AS fdate, evenements.description_fr, menus.nom_fr AS menu, ";
	$q .= "menus.visible AS visible, menus.file_name FROM evenements LEFT JOIN menus ON evenements.menuid=menus.id ";
	$q .= "WHERE evenements.visible='Oui' AND evenements.date_evenement >= '$ladate' ORDER BY evenements.date_evenement";
	$r = @mysqli_query($dbc,$q);
	if (mysqli_num_rows($r) > 0) {
		while($row = mysqli_fetch_array($r,MYSQLI_ASSOC)) {
			echo '<div class="evene"><p><span class="titre">' . $row['evene'] . '</span><br />';
			echo '<span class="ladate">' . my_date_handler($row['fdate'],0) . '</span></p>';
			echo '<p>' . $row['description_fr'] . '</p>';
			if ($row['visible'] != NULL) {
				if ($row['visible'] == 'Oui') {
					echo '<a href="menus/'. $row['file_name'] .'" title="Cliquez ici pour afficher le menu : ' . $row['file_name'] . '." target="_new">Découvrez le menu</a><br />';
				}
			}
			echo '<br /></div><br />';
		}
	} else {
		echo '<p>Revenez r&eacute;guli&egrave;rement sur notre site pour d&eacute;couvrir nos futurs &eacute;v&eacute;nements...</p>';
	}
?>
</p></div>
    <div id="contenu">
    <h3>Bienvenue</h3>
    <p><?php echo $srcimg; ?>
    C'est au coeur de la Dr&ocirc;me Proven&ccedil;ale, dans la ville de Nyons, que vous accueillent Isabelle et Christophe.</p>
    <p>Isabelle est votre h&ocirc;te, et vous conseille dans votre choix de repas, et de vins.</p>
    <p>En cuisine, Christophe prepare pour vous, des mets de qualit&eacute; &agrave; base de produits frais en provenance du terroir local.</p>
    <p>Proposant un cuisine semi-gastronomique, le restaurant D'un Gout &agrave; l'Autre vous s&eacute;duira &eacute;galement avec sa formule &quot;Business&quot; le midi en semaine (sauf jours f&eacute;ri&eacute;s), o&ugrave; vous pourrez d&eacute;guster un repas de 3 plats en 45 minutes...</p><br />
    </div>
<?php
	include('inclusion/sitepied.php');
?>