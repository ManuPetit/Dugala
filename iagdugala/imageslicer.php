<?php
	//		imageslicer.php
	//		fonction pour découper une image de fond en deux parties

			
	$in_filename =$dest;
	list($width,$height)=getimagesize($in_filename);
	$image=imagecreatefromjpeg($in_filename);
	$t=getdate();
	//resizer la photo
	if ($width != 800){
		$difinwidth = $width / 800;
		$nheight = intval($height / $difinwidth);
		$nwidth = 800;
		$dst = imagecreatetruecolor ($nwidth,$nheight);
		imagecopyresampled ($dst,$image,0,0,0,0,$nwidth,$nheight,$width,$height);
		$timgname='../images/temp'.$t[0].'.jpg';
		imagejpeg($dst,$timgname);
		$image=imagecreatefromjpeg($timgname);
		list($width,$height)=getimagesize($timgname);
	}	
	$offset_x=0;
	$offset_y=0;
	$offset_y2=105;
	$new_height=105;
	$new_height2=$height-105;
	$new_width=$width;
	
	
	$new_image=imagecreatetruecolor($new_width,$new_height);
	$imgname='../images/css/chead'.$t[0].'.jpg';
	$_SESSION['imgnom']=$t[0].'.jpg';
	imagecopy($new_image,$image,0,0,$offset_x,$offset_y,$width,$height);
	imagejpeg($new_image,$imgname);
	
	$mini=imagecreatefromjpeg($imgname);
	list($width1,$height1)=getimagesize($imgname);
	//creer mini version pour modelel
	if ($width1 != 450){
		$difinwidth = $width1 / 450;
		$nheight = intval($height1 / $difinwidth);
		$nwidth = 450;
		$dst = imagecreatetruecolor ($nwidth,$nheight);
		imagecopyresampled ($dst,$mini,0,0,0,0,$nwidth,$nheight,$width1,$height1);
		$mimgname='../images/css/chmini'.$t[0].'.jpg';
		imagejpeg($dst,$mimgname);
	}	
	
	$new_image=imagecreatetruecolor($width,$height);
	$imgname='../images/css/ccorps'.$t[0].'.jpg';
	imagecopy($new_image,$image,0,0,$offset_x,$offset_y2,$width,$height);
	imagecopy($new_image,$image,0,$new_height2,$offset_x,$offset_y,$width,$height);
	imagejpeg($new_image,$imgname);
	$mini=imagecreatefromjpeg($imgname);
	list($width2,$height2)=getimagesize($imgname);
	//creer mini version pour modelel
	if ($width2 != 450){
		$difinwidth = $width2 / 450;
		$nheight = intval($height2 / $difinwidth);
		$nwidth = 450;
		$dst = imagecreatetruecolor ($nwidth,$nheight);
		imagecopyresampled ($dst,$mini,0,0,0,0,$nwidth,$nheight,$width2,$height2);
		$nimgname='../images/css/ccmini'.$t[0].'.jpg';
		imagejpeg($dst,$nimgname);
	}	
	imagedestroy($new_image);
	imagedestroy($image);
	imagedestroy($mini);
	if (isset($timgname)){
		//detruit du fichier l'image temp
		unlink($timgname);
	}
?>