superScript = function(e) {
											var chars = '0123456789', sup   = '₀₁₂₃₄₅₆₇₈₉';
											e.value = e.value.replace(/_\{(.*?)\}/g, function(x) {
												var str = '';
												txt = x;
												for (var i=2; i<txt.length-1; i++) {
													var n = chars.indexOf(txt[i]);
													str += (n!=-1 ? sup[n] : txt[i]);
												}
												return str;
											})
										}



setTimeout(function(){
	$('input[name=start]').each(function(){this.setAttribute('onchange', 'superScript(this)')})
	$('input[name=end]').each(function(){this.setAttribute('onchange', 'superScript(this)')})
}, 500);

