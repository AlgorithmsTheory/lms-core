function drop_sup(x) {
	var chars = '0123456789', sup   = '₀₁₂₃₄₅₆₇₈₉';
	rs = ""
	for ( var i = 0; i < x.length; i++ ) {
		var n = sup.indexOf(x[i]);
		rs += ( n!=-1 ? chars[n] : x[i]);
	}
	return rs
}
function run_all_normal(){
	var task = new Object()
	task.rule = new Array()
	task.str = $('textarea[name=textarea_src]').val()
	var src = $('input[name=start]').toArray()
	var dst = $('input[name=end]').toArray()

	for ( var i = 0; i < src.length; i++) {
		tmp = new Object()
		tmp.src = drop_sup(src[i].value)
		tmp.dst = drop_sup(dst[i].value)
		if ( src[i].value.length > 0 && dst[i].value.length ) {
			task.rule.push(tmp)
		}
	}
	$.post("/laravel/app/Normal.php", JSON.stringify(task)).done(
		function(data){
			resp = $.parseJSON(data);
			if ( resp.error != 'ok' ) {
				alert("Программа зациклилась!")
				$('input[id=disabled6]').val("Ошибка!");
			} else {
				$('input[id=disabled6]').val(resp.result);
			}
		});
}

function run_all_turing(){
	var task = new Object()
	task.rule = new Array()

	task.str = $('textarea[name=textarea_src]').val()
	var src = $('input[name=start]').toArray()
	var dst = $('input[name=end]').toArray()

	for ( var i = 0; i < src.length; i++) {
		tmp = new Object()
		tmp.src = drop_sup(src[i].value)
		tmp.dst = drop_sup(dst[i].value)
		if ( src[i].value.length > 0 && dst[i].value.length > 0 ) {
			task.rule.push(tmp)
		}
	}
	
	$.post("/laravel/app/Turing.php", JSON.stringify(task)).done(
		function(data){
			resp = $.parseJSON(data);
			if ( resp.error != 'ok' ) {
				alert("Программа зациклилась!")
				$('input[id=disabled6]').val("Ошибка!");
			} else {
				$('input[id=disabled6]').val(resp.result);
			}
		});
}
