<div id="pied">
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
				echo '<a href="' . $pagelien . '" title="' . $titlepage . $details[$i]['titlemenu'] . '."';
				if ($menuid == $details[$i]['id']) {
					echo ' class="selection"';
				}
				echo '>' . $details[$i]['nommenu'] . '</a>';
				if ($i != (count($details) - 1)){
					echo '&nbsp;|&nbsp;';
				}
			}
			if ($lang == '_fr') {
				echo '<br />Site réalisé par <a href="http://www.iiidees.com" target="_blank" title="Cliquez ici pour aller sur le site www.iiidees.com">iiidees.com</a>';
			}else {
				echo'<br />Website design by <a href="http://www.iiidees.com" target="_blank" title="Click here to visit www.iiidees.com">iiidees.com</a>';
			}
			mysqli_close($dbc);
	  ?>
   <br />
    <br />&nbsp;
    </div>
  </div>
</div>
</div>
</body>
</html>
