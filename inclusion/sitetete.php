<?php
		/**
		 *
		 *		script sitetete.php
		 *
		 *		permet la création de l'entete du fichier selon la langue
		 *
		 */
		
		//verifier que l'on a bien les valeurs passées par le fichier demandé
		if (!isset($menuid)) {
			$menuid = 1;
		}
		if (!isset($lang)) {
			$lang = '_fr';
		}
		require('../dugala.inc.php');
		//faire la requete du détail des menus
		$q = "SELECT menusite.id, menusite.nom". $lang . " AS menu, menusite.title" . $lang . " AS title, pagesite.titre" . $lang . " AS titre,";
		$q .= "pagesite.metakey" . $lang . " AS lkey, pagesite.metadesc" . $lang . " AS ldesc, pagesite.page_fr, pagesite.page_gb FROM menusite LEFT JOIN pagesite ON ";
		$q .= "menusite.pageid = pagesite.id ORDER BY menusite.ordre ASC";
		$r = @mysqli_query($dbc,$q);
		$details=array();
		while($row = mysqli_fetch_array($r,MYSQLI_ASSOC)) {
			$details[] = array(
				'id' => $row['id'],
				'nommenu' => $row['menu'],
				'titlemenu' => $row['title'],
				'titrepage' => $row['titre'],
				'metakey' => $row['lkey'],
				'metadesc' => $row['ldesc'],
				'pagefr' => $row['page_fr'] . '.php',
				'pagegb' => $row['page_gb'] . '.php'
			);
		}
		//faire la requête du theme
		$q = "SELECT fichierNom, HasSnow, heading FROM theme WHERE IsOn = 1";
		$r = @mysqli_query($dbc,$q);
		$theme=array();
		while($row = mysqli_fetch_array($r,MYSQLI_ASSOC)) {
			$theme=array(
				'fichier'=>$row['fichierNom'],
				'snow'=>$row['HasSnow'],
				'heading'=>$row['heading']
			);
		}
		
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo $details[$menuid-1]['metakey']; ?>" />
<meta name="description" content="<?php echo $details[$menuid-1]['metadesc']; ?>" />
<title><?php echo $details[$menuid-1]['titrepage']; ?></title>
<link href="css/mainsite.css" rel="stylesheet" type="text/css" />
<link href="css/photo.css" rel="stylesheet" type="text/css" />
<?php
	if (isset($theme['fichier'])){
		echo '<link href="css/' . $theme['fichier'] . '.css" rel="stylesheet" type="text/css" />';
	}else{
		echo '<link href="css/default.css" rel="stylesheet" type="text/css" />';
	}
	echo "\n";
	if ((isset($theme['snow'])) &&($theme['snow']==1)){
		echo '<script type="text/javascript" src="js/snowstorm.js"></script>';
	}
?>
</head>

<body>
<div id="conteneur">
<div id="entere">
  <?php
  	if (isset($theme['heading'])){
		echo '<img src="images/css/'. $theme['heading'].'" width="800" height="105" border="0" usemap="#Map" />';
	}else{
		echo '<img src="images/css/entetetitre.png" width="800" height="105" border="0" usemap="#Map" />';
	}
	?>
  <map name="Map" id="Map">
    <area shape="rect" coords="691,14,739,46" href="<?php echo $details[$menuid-1]['pagefr']; ?>" alt="Version française" Title="Version française" />
    <area shape="rect" coords="691,51,739,88" href="<?php echo $details[$menuid-1]['pagegb']; ?>" alt="English version" title="English version" />
  </map>
</div>
<div id="wrapper">
<ul id="navigation">
  <br />
  <?php
	  		//creation du menu
			for ($i=0; $i<count($details); $i++) {
				if ($lang == "_fr") {
					$pagelien = $details[$i]['pagefr'];
					$titlepage = 'Cliquez ici pour ';
				} else {
					$pagelien = $details[$i]['pagegb'];
					$titlepage = 'Click here to ';
				} 
				echo '<li><a href="' . $pagelien . '" title="' . $titlepage . $details[$i]['titlemenu'] . '."';
				if ($menuid == $details[$i]['id']) {
					echo ' class="button mygradsel"';
				}else{
					echo ' class="button mygrad"';
				}
				echo '>' . $details[$i]['nommenu'] . '</a></li>';
			}
	  ?>
</ul>
