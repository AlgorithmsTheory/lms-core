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

function debug(ctx, resp){
	for (var i = 0; i < resp.logs.length; i++) {
		row = $('<tr>');
		col = $('<td>').text(i+1);
		col2 = $('<td>').text(resp.logs[i]);
		row.append(col, col2);
		ctx.find('[name = debug]').append(row);
	}
}

function run_all_normal(ctx, j){
	var step = j;
	var task = new Object()
	task.rule = new Array()
	task.str = ['Λ' + ctx.find('textarea[name = textarea_src]').val()]
	var src = ctx.find('input[name ^= st_]').toArray()
	var dst = ctx.find('input[name ^= end_]').toArray()

	for ( var i = 0; i < src.length; i++) {
		tmp = new Object()
		tmp.src = drop_sup(src[i].value)
		tmp.dst = drop_sup(dst[i].value)
		if ( src[i].value.length > 0 && dst[i].value.length ) {
			task.rule.push(tmp)
		}
	}
    
    ctx.find("[name = debug] > tr").remove();
    
	$.ajax({
		cache: false,
		type: 'POST',
		url:   '/algorithm/HAM',
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
				ctx.find('input[name = disabled6]').val("Ошибка!");
				if (step == true){
					debug(ctx, resp);
				}
			} else {
				ctx.find('input[name = disabled6]').val(resp.result);
				if (step == true){
					debug(ctx, resp);
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
					debug(resp);
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

function run_all_turing(ctx, j){
	var step = j;
	var task = new Object()
	task.rule = new Array()

	task.str = [ctx.find('textarea[name = textarea_src]').val()]
	var src = ctx.find('input[name ^= st_]').toArray()
	var dst = ctx.find('input[name ^= end_]').toArray()

	for ( var i = 0; i < src.length; i++) {
		tmp = new Object()
		tmp.src = to_multi_tape_src_rule(drop_sup(src[i].value))
		tmp.dst = to_multi_tape_dst_rule(drop_sup(dst[i].value))
		if ( src[i].value.length > 0 && dst[i].value.length > 0 ) {
			task.rule.push(tmp)
		}
	}

  
	ctx.find("[name = debug] > tr").remove();
    
	$.ajax({
		cache: false,
		type: 'POST',
		url:   '/algorithm/MT',
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
				ctx.find('input[name = disabled6]').val("Ошибка!");
				if (step == true){
					debug(ctx, resp);
				}
			} else {
				ctx.find('input[name = disabled6]').val(resp.result);
				if (step == true){
					debug(ctx, resp);
				}
			}
               
		}
	});
	return false;
}


function SendMtContext(inst) {
    let ctx = $('[name = mt-entity' + inst + ']');
    
    ctx.find('[name = run_turing_true]').click(function(){
        event.stopPropagation();
        run_all_turing(ctx, true);
        return false;
    });
    
    ctx.find('[name = run_turing_false]').click(function(){
        event.stopPropagation();
        run_all_turing(ctx, false);
        return false;
    });
}

function SendHAMContext(inst) {
    let ctx = $('[name = ham-entity' + inst + ']');
    
    ctx.find('[name = run_markov_true]').click(function(){
        event.stopPropagation();
        run_all_normal(ctx, true);
        return false;
    });
    
    ctx.find('[name = run_markov_false]').click(function(){
        event.stopPropagation();
        run_all_normal(ctx, false);
        return false;
    });
}


j = 0;

$("[name^=mt-entity]").each(function(){
	SendMtContext(j);
	j++;
});

j = 0;

$("[name^=ham-entity]").each(function(){
	SendHAMContext(j);
	j++;
});
