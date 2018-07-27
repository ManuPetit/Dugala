<?php
		/**
		 *
		 *		script home.php
		 *
		 *		page d'accueil anglaise du site
		 *
		 */
		 
		 $menuid = 1;
		 $lang = '_gb'; 
		 include('inclusion/config.inc.php');
		 include('inclusion/sitetete.php');
		  //faire la requete pour l'image
		 $sql = 'SELECT fichier, desc_gb FROM photoopen WHERE IsShowing = 1 LIMIT 1';
		 $ra = @mysqli_query($dbc,$sql);
		 $img = mysqli_fetch_array($ra,MYSQLI_ASSOC);
		 if (!empty($img)){
			 $image = $img['fichier'];
			 $piece = explode('.',$image);
			 $photo = 'images/' . $piece[0] . '_th.' . $piece[1];
			 $size = getimagesize($photo); 
			 $desc = $img['desc_gb'];
			 $srcimg = '<img src="'.$photo.'" width="'.$size[0].'" height="'.$size[1].'" class="imgDroit" title="'.$desc.'" alt="'.$desc.'" />';
		 }else{
			 $srcimg ='<img src="images/imgAcc01.jpg" width="200" height="186" class="imgDroit" title="Outisde picture of the restaurant D\'un Gout &agrave; l\'Autre" alt="Outisde picture of the restaurant D\'un Gout &agrave; l\'Autre" />';
		 }
?>
<div id="gauche"><h3>Coming Soon...</h3>
<?php
	//creation date du jour
	$aujour = time();
	$ladate = date('Y.m.d',$aujour);
	//faire la requete pour trouver tous les evnements
	$q = "SELECT evenements.nom_gb AS evene, DATE_FORMAT(evenements.date_evenement,'%d-%m-%Y') AS ladate, evenements.date_evenement AS fdate, evenements.description_gb, menus.nom_gb AS menu, ";
	$q .= "menus.visible AS visible, menus.file_name FROM evenements LEFT JOIN menus ON evenements.menuid=menus.id ";
	$q .= "WHERE evenements.visible='Oui' AND evenements.date_evenement >= '$ladate' ORDER BY evenements.date_evenement";
	$r = @mysqli_query($dbc,$q);
	if (mysqli_num_rows($r) > 0) {
		while($row = mysqli_fetch_array($r,MYSQLI_ASSOC)) {
			echo '<div class="evene"><p><span class="titre">' . $row['evene'] . '</span><br />';
			echo '<span class="ladate">' . my_date_handler_uk($row['fdate'],0) . '</span></p>';
			echo '<p>' . $row['description_gb'] . '</p>';
			if ($row['visible'] != NULL) {
				if ($row['visible'] == 'Oui') {
					echo '<a href="menus/'. $row['file_name'] .'" title="Click here to see the menu: ' . $row['file_name'] . '." target="_new">Find out about the menu</a><br />';
				}
			}
			echo '<br /></div><br />';
		}
	} else {
		echo '<p>Come back soon, to find out about our futur events..</p>';
	}
?>
</p></div>
    <div id="contenu">
    <h3>Welcome</h3>
    <p><?php echo $srcimg; ?>
    In the heart of Proven&ccedil;al Dr&ocirc;me, in the town of Nyons, Isabelle and Christophe welcome you.</p>
    <p>Isabelle is your host, and she will help you in choosing your meal and wines.</p>
    <p>In the kitchen, Christophe will cook for you, some delightful dishes based on fresh local produce.</p>
    <p>Offering semi-gastronomical meals, the restaurant D'un Gout &agrave; l'Autre will seduce you with its &quot;Business&quot; menu every weekdays lunchtime (not available on public holidays), where you can enjoy a 3 courses meal served in 45 minutes...</p><br />
    </div>
<?php
	include('inclusion/sitepied.php');
?>