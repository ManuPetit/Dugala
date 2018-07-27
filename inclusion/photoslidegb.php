<?php
		/**
		 *
		 *		script photoslidegb.php
		 *
		 *		ce script permet d'ajouter le slide show
		 *
		 */
		 
		 $q = "SELECT nom_fr, fichier FROM photos WHERE visible='Oui' ORDER BY id";
		 $r = @mysqli_query($dbc,$q);
		 if (mysqli_num_rows($r) > 0) {
			 //on a des photo verifier si on a le fichier xml.
			 $fichier = "images/photogb.xml";
			 if (file_exists($fichier)) {
				 $show = true;
				 //tout est bon on peut afficher le programme
				 echo '<div id="flashContent">

			<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="260" height="280" id="showgb" align="middle">
				<param name="movie" value="showgb.swf" />
				<param name="quality" value="high" />
				<param name="bgcolor" value="#a7a2a2" />
				<param name="play" value="true" />
				<param name="loop" value="true" />
				<param name="wmode" value="window" />
				<param name="scale" value="showall" />
				<param name="menu" value="true" />

				<param name="devicefont" value="false" />
				<param name="salign" value="" />
				<param name="allowScriptAccess" value="sameDomain" />
				<!--[if !IE]>-->
				<object type="application/x-shockwave-flash" data="showgb.swf" width="260" height="280">
					<param name="movie" value="showgb.swf" />
					<param name="quality" value="high" />
					<param name="bgcolor" value="#a7a2a2" />
					<param name="play" value="true" />

					<param name="loop" value="true" />
					<param name="wmode" value="window" />
					<param name="scale" value="showall" />
					<param name="menu" value="true" />
					<param name="devicefont" value="false" />
					<param name="salign" value="" />
					<param name="allowScriptAccess" value="sameDomain" />
				<!--<![endif]-->
					<a href="http://www.adobe.com/go/getflash">

						<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
					</a>
				<!--[if !IE]>-->
				</object>
				<!--<![endif]-->
			</object>
		</div>';
			 }
		 }
?>
