<?php 
	//		tempsjs.php
	// création d'un fichier javascript temporaire
	$mes ="// JavaScript Document
$(document).ready(function() {
	$('#colorSelector10').ColorPicker({
		color: '".$tdet['fond']."',
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#colorSelector10 div').css('backgroundColor', '#' + hex);
			$('#c1').val('#' + hex);
			$('.g1').css('backgroundColor', '#' + hex);
		}
	});
	$('#colorSelector11').ColorPicker({
		color: '".$tdet['fondBoite']."',
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#colorSelector11 div').css('backgroundColor', '#' + hex);
			$('#c2').val('#' + hex);
			$('.col').css('backgroundColor', '#' + hex);
		}
	});
	$('#colorSelector12').ColorPicker({
		color: '".$tdet['police']."',
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#colorSelector12 div').css('backgroundColor', '#' + hex);
			$('#c3').val('#' + hex);
			$('.txt').css('color', '#' + hex);
		}
	});
	$('#colorSelector13').ColorPicker({
		color: '".$tdet['titreCadre']."',
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#colorSelector13 div').css('backgroundColor', '#' + hex);
			$('#c4').val('#' + hex);
			$('.t1').css('color', '#' + hex);
			$('.bx').css('borderColor', '#' + hex)
		}
	});
	$('#colorSelector14').ColorPicker({
		color: '".$tdet['fondBoiteDeux']."',
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#colorSelector14 div').css('backgroundColor', '#' + hex);
			$('#c5').val('#' + hex);
			$('.bx').css('backgroundColor', '#' + hex);
		}
	});
	$('#colorSelector15').ColorPicker({
		color: '".$tdet['date']."',
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#colorSelector15 div').css('backgroundColor', '#' + hex);
			$('#c6').val('#' + hex);
			$('.dt').css('color', '#' + hex);
		}
	});
	$('#colorSelector16').ColorPicker({
		color: '".$tdet['titreBoiteDeux']."',
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#colorSelector16 div').css('backgroundColor', '#' + hex);
			$('#c7').val('#' + hex);
			$('.t2').css('color', '#' + hex);
		}
	});
	$('#colorSelector17').ColorPicker({
		color: '".$tdet['lienVisible']."',
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#colorSelector17 div').css('backgroundColor', '#' + hex);
			$('#c8').val('#' + hex);
			$('.lv').css('color', '#' + hex);
		}
	});
	$('#colorSelector18').ColorPicker({
		color: '".$tdet['lienSurvol']."',
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#colorSelector18 div').css('backgroundColor', '#' + hex);
			$('#c9').val('#' + hex);
			$('.la').css('color', '#' + hex);
		}
	});
	$('#colorSelector19').ColorPicker({
		color: '".$tdet['lienPiedVisible']."',
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#colorSelector19 div').css('backgroundColor', '#' + hex);
			$('#c10').val('#' + hex);
			$('.pv').css('color', '#' + hex);
		}
	});
	$('#colorSelector20').ColorPicker({
		color: '".$tdet['lienPiedSurvol']."',
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#colorSelector20 div').css('backgroundColor', '#' + hex);
			$('#c11').val('#' + hex);
			$('.pa').css('color', '#' + hex);
		}
	});
	$('#colorSelector21').ColorPicker({
		color: '".$tdet['navHautVisible']."',
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#colorSelector21 div').css('backgroundColor', '#' + hex);
			$('#b1').val('#' + hex);
			var btcss = \"background-image: linear-gradient(bottom, \"+ $('#b2').val()+ \" 20%, #\" + hex + \" 100%);\";
			btcss = btcss + \"background-image: -o-linear-gradient(bottom, \"+ $('#b2').val()+ \" 20%, #\" + hex + \" 100%);\";
			btcss = btcss + \"background-image: -moz-linear-gradient(bottom, \"+ $('#b2').val()+ \" 20%, #\" + hex + \" 100%);\";
			btcss = btcss + \"background-image: -webkit-linear-gradient(bottom, \"+ $('#b2').val()+ \" 20%, #\" + hex + \" 100%);\";
			btcss = btcss + \"background-image: -ms-linear-gradient(bottom, \"+ $('#b2').val()+ \" 20%, #\" + hex + \" 100%);\";		
			$('.btOff').attr('style', btcss);
		}
	});
	$('#colorSelector22').ColorPicker({
		color: '".$tdet['navBasVisible']."',
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#colorSelector22 div').css('backgroundColor', '#' + hex);
			$('#b2').val('#' + hex);
			var btcss = \"background-image: linear-gradient(bottom, #\" + hex + \" 20%, \"+ $('#b1').val()+ \" 100%);\";
			btcss = btcss + \"background-image: -o-linear-gradient(bottom, #\" + hex + \" 20%, \"+ $('#b1').val()+ \" 100%);\";
			btcss = btcss + \"background-image: -moz-linear-gradient(bottom, #\" + hex + \" 20%, \"+ $('#b1').val()+ \" 100%);\";
			btcss = btcss + \"background-image: -webkit-linear-gradient(bottom, #\" + hex + \" 20%, \"+ $('#b1').val()+ \" 100%);\";
			btcss = btcss + \"background-image: -ms-linear-gradient(bottom, #\" + hex + \" 20%, \"+ $('#b1').val()+ \" 100%);\";		
			$('.btOff').attr('style', btcss);
		}
	});
	$('#colorSelector23').ColorPicker({
		color: '".$tdet['lienNavVisible']."',
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#colorSelector23 div').css('backgroundColor', '#' + hex);
			$('#b3').val('#' + hex);
			$('.nlv').css('color', '#' + hex);
		}
	});
	$('#colorSelector24').ColorPicker({
		color: '".$tdet['navHautActif']."',
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#colorSelector24 div').css('backgroundColor', '#' + hex);
			$('#b4').val('#' + hex);
			var btcss = \"background-image: linear-gradient(bottom, \"+ $('#b5').val()+ \" 20%, #\" + hex + \" 100%);\";
			btcss = btcss + \"background-image: -o-linear-gradient(bottom, \"+ $('#b5').val()+ \" 20%, #\" + hex + \" 100%);\";
			btcss = btcss + \"background-image: -moz-linear-gradient(bottom, \"+ $('#b5').val()+ \" 20%, #\" + hex + \" 100%);\";
			btcss = btcss + \"background-image: -webkit-linear-gradient(bottom, \"+ $('#b5').val()+ \" 20%, #\" + hex + \" 100%);\";
			btcss = btcss + \"background-image: -ms-linear-gradient(bottom, \"+ $('#b').val()+ \" 20%, #\" + hex + \" 100%);\";		
			$('.btOn').attr('style', btcss);
		}
	});
	$('#colorSelector25').ColorPicker({
		color: '".$tdet['navBasActif']."',
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#colorSelector25 div').css('backgroundColor', '#' + hex);
			$('#b5').val('#' + hex);
			var btcss = \"background-image: linear-gradient(bottom, #\" + hex + \" 20%, \"+ $('#b4').val()+ \" 100%);\";
			btcss = btcss + \"background-image: -o-linear-gradient(bottom, #\" + hex + \" 20%, \"+ $('#b4').val()+ \" 100%);\";
			btcss = btcss + \"background-image: -moz-linear-gradient(bottom, #\" + hex + \" 20%, \"+ $('#b4').val()+ \" 100%);\";
			btcss = btcss + \"background-image: -webkit-linear-gradient(bottom, #\" + hex + \" 20%, \"+ $('#b4').val()+ \" 100%);\";
			btcss = btcss + \"background-image: -ms-linear-gradient(bottom, #\" + hex + \" 20%, \"+ $('#b4').val()+ \" 100%);\";		
			$('.btOn').attr('style', btcss);
		}
	});
	$('#colorSelector26').ColorPicker({
		color: '".$tdet['lienNavSurvol']."',
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#colorSelector26 div').css('backgroundColor', '#' + hex);
			$('#b6').val('#' + hex);
			$('.nla').css('color', '#' + hex);
		}
	});
});";
	$myjs="../js/tempjs.js";
	if ($fh = fopen($myjs, 'w')){
		fwrite($fh,$mes);
		fclose($fh);
	}
?>