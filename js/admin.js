// JavaScript Document
$(document).ready(function() {
	$('#colorSelector10').ColorPicker({
		color: '#D4BE8D',
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
		color: '#A7A2A2',
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
		color: '#000000',
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
		color: '#660000',
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
		color: '#C2BCBA',
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
		color: '#663300',
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
		color: '#CC3300',
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
		color: '#CC3300',
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
		color: '#0000ff',
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
		color: '#66000',
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
		color: '#CC3300',
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
		color: '#c2bcba',
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
			var btcss = "background-image: linear-gradient(bottom, "+ $('#b2').val()+ " 20%, #" + hex + " 100%);";
			btcss = btcss + "background-image: -o-linear-gradient(bottom, "+ $('#b2').val()+ " 20%, #" + hex + " 100%);";
			btcss = btcss + "background-image: -moz-linear-gradient(bottom, "+ $('#b2').val()+ " 20%, #" + hex + " 100%);";
			btcss = btcss + "background-image: -webkit-linear-gradient(bottom, "+ $('#b2').val()+ " 20%, #" + hex + " 100%);";
			btcss = btcss + "background-image: -ms-linear-gradient(bottom, "+ $('#b2').val()+ " 20%, #" + hex + " 100%);";		
			$('.btOff').attr('style', btcss);
		}
	});
	$('#colorSelector22').ColorPicker({
		color: '#716c6b',
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
			var btcss = "background-image: linear-gradient(bottom, #" + hex + " 20%, "+ $('#b1').val()+ " 100%);";
			btcss = btcss + "background-image: -o-linear-gradient(bottom, #" + hex + " 20%, "+ $('#b1').val()+ " 100%);";
			btcss = btcss + "background-image: -moz-linear-gradient(bottom, #" + hex + " 20%, "+ $('#b1').val()+ " 100%);";
			btcss = btcss + "background-image: -webkit-linear-gradient(bottom, #" + hex + " 20%, "+ $('#b1').val()+ " 100%);";
			btcss = btcss + "background-image: -ms-linear-gradient(bottom, #" + hex + " 20%, "+ $('#b1').val()+ " 100%);";		
			$('.btOff').attr('style', btcss);
		}
	});
	$('#colorSelector23').ColorPicker({
		color: '#000000',
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
		color: '#3f0b04',
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
			var btcss = "background-image: linear-gradient(bottom, "+ $('#b5').val()+ " 20%, #" + hex + " 100%);";
			btcss = btcss + "background-image: -o-linear-gradient(bottom, "+ $('#b5').val()+ " 20%, #" + hex + " 100%);";
			btcss = btcss + "background-image: -moz-linear-gradient(bottom, "+ $('#b5').val()+ " 20%, #" + hex + " 100%);";
			btcss = btcss + "background-image: -webkit-linear-gradient(bottom, "+ $('#b5').val()+ " 20%, #" + hex + " 100%);";
			btcss = btcss + "background-image: -ms-linear-gradient(bottom, "+ $('#b').val()+ " 20%, #" + hex + " 100%);";		
			$('.btOn').attr('style', btcss);
		}
	});
	$('#colorSelector25').ColorPicker({
		color: '#791c08',
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
			var btcss = "background-image: linear-gradient(bottom, #" + hex + " 20%, "+ $('#b4').val()+ " 100%);";
			btcss = btcss + "background-image: -o-linear-gradient(bottom, #" + hex + " 20%, "+ $('#b4').val()+ " 100%);";
			btcss = btcss + "background-image: -moz-linear-gradient(bottom, #" + hex + " 20%, "+ $('#b4').val()+ " 100%);";
			btcss = btcss + "background-image: -webkit-linear-gradient(bottom, #" + hex + " 20%, "+ $('#b4').val()+ " 100%);";
			btcss = btcss + "background-image: -ms-linear-gradient(bottom, #" + hex + " 20%, "+ $('#b4').val()+ " 100%);";		
			$('.btOn').attr('style', btcss);
		}
	});
	$('#colorSelector26').ColorPicker({
		color: '#ea890b',
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
	var v = $("#cmxform").validate({
		rules : {
			name : {
				required : true,
				minlength : 2,
				maxlength : 65
				}	
		},
		messages : {
			name : {
				required : "<br />Ce champs ne peut pas être vide",
				minlength : "<br />Le nom doit avoir au moins deux lettres",
				maxlength : "<br />Le nom ne peut pas faire plus de 65 lettres"
			}
		}
	});
});