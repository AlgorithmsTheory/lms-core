function drop_sup(x) {
	var chars = '0123456789', sup   = '₀₁₂₃₄₅₆₇₈₉';
	rs = ""
	for ( var i = 0; i < x.length; i++ ) {
		var n = sup.indexOf(x[i]);
		rs += ( n!=-1 ? chars[n] : x[i]);
	}
	return rs
}

function debag(resp){
	//$('td[id=input1]').text(resp.logs[0]);
	//$('td[id=input2]').text(resp.logs[1]);
	for (var i = 0; i < resp.logs.length; i++) {
		row = $('<tr>');
		col = $('<td>').text(i+1);
		col2 = $('<td>').text(resp.logs[i]);
		row.append(col, col2);
		$('#debug');
		$('#debug').append(row);
	}
}

function run_one_normal(j){
	var step = j;
	var task = new Object()
	task.rule = new Array()
	task.str = 'Λ'+$('textarea[name=textarea_src]').val()
	var src = $('input[name=start]').toArray()
	var dst = $('input[name=end]').toArray()
	//$("td").remove();
	//document.getElementById("onerun").disabled = true;

	for ( var i = 0; i < src.length; i++) {
		tmp = new Object()
		tmp.src = drop_sup(src[i].value)
		tmp.dst = drop_sup(dst[i].value)
		if ( src[i].value.length > 0 && dst[i].value.length ) {
			task.rule.push(tmp)
		}
	}

	token = $('#forma').children().eq(0).val();
	$.ajax({
		cache: false,
		type: 'POST',
		url:   '/get-HAM',
		beforeSend: function (xhr) {
			var token = $('meta[name="csrf_token"]').attr('content');

			if (token) {
				return xhr.setRequestHeader('X-CSRF-TOKEN', token);
			}
		},
		data: { task: JSON.stringify(task), token: 'token' },
		success: function(data){
			var resp = data;

			resp = JSON.parse(data);

			if ( resp.error != 'ok' ) {
				alert("Программа зациклилась!");
				$('input[id=disabled6]').val("Ошибка!");
				if (step == true){
					debag(resp);
				}
			} else {
				$('input[id=disabled6]').val(resp.result);
				if (step == true){
					debag(resp);
				}
			}
		}
	});
	return false;
}

function run_one_turing(j){
	var step = j;
	var task = new Object()
	task.rule = new Array()

	task.str = $('textarea[name=textarea_src]').val()
	var src = $('input[name=start]').toArray()
	var dst = $('input[name=end]').toArray()
	//document.getElementById("onerun").disabled = true;

	for ( var i = 0; i < src.length; i++) {
		tmp = new Object()
		tmp.src = drop_sup(src[i].value)
		tmp.dst = drop_sup(dst[i].value)
		if ( src[i].value.length > 0 && dst[i].value.length > 0 ) {
			task.rule.push(tmp)
		}
	}


	token = $('#forma').children().eq(0).val();
	alert(task.str);
	$.ajax({
		cache: false,
		type: 'POST',
		url:   '/get-MT',
		beforeSend: function (xhr) {
			var token = $('meta[name="csrf_token"]').attr('content');

			if (token) {
				return xhr.setRequestHeader('X-CSRF-TOKEN', token);
			}
		},
		data: { task: JSON.stringify(task), token: 'token' },
		success: function(data){
			var resp = data;
			resp = JSON.parse(data);
			if ( resp.error != 'ok' ) {
				alert("Программа зациклилась!");
				$('input[id=disabled6]').val("Ошибка!");
				if (step == true){
					debag(resp);
				}
			} else {
				$('input[id=disabled6]').val(resp.result);
				if (step == true){
					debag(resp);
				}
			}
		}
	});
	return false;
}
