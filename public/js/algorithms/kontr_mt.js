function mtSubmitTask(cnt, notice) {
    let ctx = $('[name = mt-entity' + cnt + ']').first();
    
    /* Get variables */
    task_form = $("[name=type][value=12]").eq(cnt).parent().find("[name=task]").first();
    debug_form = $("[name=type][value=12]").eq(cnt).parent().find("[name=debug_counter]").first();
    task_id = $("[name=type][value=12]").eq(cnt).parent().find("[name=num]").first().val();
    counter = $("[name=type][value=12]").eq(cnt).parent().find("[name=counter]").first().val();
    test_id = $("#id_test").val();
    
    /* Create rules from emulator view */
    var task = new Object();
	task.rule = new Array();

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
    
    task_form.val(JSON.stringify(task));
    
    /* Check and show result */
    
    if(notice){
    
        $.ajax({
            cache: false,
            type: 'POST',
            url:   '/algorithm/MTCheck',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: { counter: counter,
                    task_id: task_id,
                    test_id: test_id,
                    task: JSON.stringify(task),
                    token: 'token' },
            success: function(data){
                
                sequences_true = data['choice']['sequences_true'];
                sequences_all = data['choice']['sequences_all'];
                debug_counter = data['choice']['debug_counter'];
                
                debug_form.val(debug_counter);

                alert("Текущий результат отправки: " + sequences_true + " тестов сработало из " + sequences_all + 
                      " . Количество отправок: " + debug_counter + "\n");                
            }
        });
     
	}
    return false;
}

function MtContextControl(ptr, cnt) {
    $(ptr).click(function(){ mtSubmitTask(cnt, true); });
}

j = 0;

$("[name^=mt-entity] [name=btn_submit]").each(function(){
   MtContextControl(this, j);
   j++;
});
