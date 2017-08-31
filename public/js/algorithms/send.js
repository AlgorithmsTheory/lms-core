function drop_sup(x) {
	var chars = '0123456789', sup   = '₀₁₂₃₄₅₆₇₈₉';
	rs = ""
	for ( var i = 0; i < x.length; i++ ) {
		var n = sup.indexOf(x[i]);
		rs += ( n!=-1 ? chars[n] : x[i]);
	}
	return rs
}

function to_multi_tape_src_rule(rule) {
    src = rule.split('.')
    state = src[0]
    symbol = src[1]
    return state  + '{' + symbol + '}';
}

function to_multi_tape_dst_rule(rule) {
    dst = rule.split('.')
    symbol = dst[0]
    action = dst[1]
    state  = dst[2]
    return '{' + symbol + '}{' + action + '}' + state;
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

function run_all_normal(j){
	var step = j;
	var task = new Object()
	task.rule = new Array()
	task.str = 'Λ'+$('textarea[name=textarea_src]').val()
	var src = $('input[name=start]').toArray()
	var dst = $('input[name=end]').toArray()


	$("tr").remove();
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
			var resp = JSON.parse(data);
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


function run_all_mmt(j){
	var step = j;
	var task = new Object()
	task.rule = new Array()
    
	task.str = [] 
    input = $('textarea[name=textarea_src]')
    for (var i = 0; i < input.length; i++) {
        task.str.push(input[i].value)
    }

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

  
//	$("#debug > tr").remove();
	token = $('#forma').children().eq(0).val();
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
			var resp = JSON.parse(data);
			if ( resp.error != 'ok' ) {
				$('input[id=disabled6]').val("Ошибка!");
				if (step == true){
					debag(resp);
				}
			} else {
				$('#output1').text(resp.result.split(' ')[0]);
				$('#output2').text(resp.result.split(' ')[1]);
				$('#output3').text(resp.result.split(' ')[2]);
			}
		}
	});
	return false;
}

function run_all_turing(j){
	var step = j;
	var task = new Object()
	task.rule = new Array()

	task.str = [$('textarea[name=textarea_src]').val()]
	var src = $('input[name=start]').toArray()
	var dst = $('input[name=end]').toArray()

	for ( var i = 0; i < src.length; i++) {
		tmp = new Object()
		tmp.src = to_multi_tape_src_rule(drop_sup(src[i].value))
		tmp.dst = to_multi_tape_dst_rule(drop_sup(dst[i].value))
		if ( src[i].value.length > 0 && dst[i].value.length > 0 ) {
			task.rule.push(tmp)
		}
	}

  
	$("#debug > tr").remove();
	token = $('#forma').children().eq(0).val();
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
			var resp = JSON.parse(data);
			if ( resp.error != 'ok' ) {
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
