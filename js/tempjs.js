// JavaScript Document
$(document).ready(function() {
	$('#colorSelector10').ColorPicker({
		color: '#3b2f15',
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
		color: '#804444',
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
		color: '#faf7fa',
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
		color: '#ffee03',
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
		color: '#733f2e',
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
		color: '#8de0d6',
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
		color: '#ebbbab',
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
		color: '#bdbdf0',
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
		color: '#de663e',
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
		color: '#732313',
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
		color: '#f0ebf0',
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
		color: '#bdbd17',
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
		color: '#d67f1c',
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
		color: '#2ae0c5',
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
});