function postCheckAnswer(ctx, arr){
	try{
		var count = 0;
		for(var i=0; i < arr['input_word'].length; i++){
            
			rules = GetRules(ctx);
			input = arr['input_word'][i];
			
			result_log = GetResult(rules, input);
			results = result_log.toString().split(",");
			result = results[results.length - 1].replace("[","").replace("]","");
			
			if( result == arr['output_word'][i] ){
				count++;
			}
		}
	}
	catch(err){
		console.log(err);
		count = 0;
	}
	return count;
}

function postSubmitTask(cnt, notice) {
    let ctx = $('[name = post-entity' + cnt + ']').first();
	
    let test_seq = JSON.parse(ctx.find("[name=test_seq]").html());
    seq_true = $("[name=type][value=14]").eq(cnt).parent().find("[name=sequences_true]").first();
	seq_all = $("[name=type][value=14]").eq(cnt).parent().find("[name=sequences_all]").first();
    debug_form = $("[name=type][value=14]").eq(cnt).parent().find("[name=debug_counter]").first();
    task_id = $("[name=type][value=14]").eq(cnt).parent().find("[name=num]").first().val();
    counter = $("[name=type][value=14]").eq(cnt).parent().find("[name=counter]").first().val();
    test_id = $("#id_test").val();
    
    var sequences_true = postCheckAnswer(ctx, test_seq);
	seq_true.val(sequences_true);
	
	var sequences_all  = test_seq['input_word'].length;
	seq_all.val(sequences_all);
	
	SetInput(ctx, "0000");
	
    if(notice){
        $.ajax({
            cache: false,
            type: 'POST',
            url: '/algorithm/PostCheck',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: { counter: counter,
                    task_id: task_id,
                    test_id: test_id,
                    seq_true: sequences_true,
                    seq_all: sequences_all,
                    token: 'token' },
            success: function(data){
                
                debug_counter = data['choice']['debug_counter'];
                debug_form.val(debug_counter);
                
                alert("Текущий результат отправки: " + sequences_true + " тестов сработало из " + sequences_all + 
                      " . Количество отправок: " + debug_counter + "\n");
            }
        });
    }   
}

function PostContextControl(ptr, cnt) {
    $(ptr).click(function(){ postSubmitTask(cnt, true); });
}

j = 0;

$("[name^=post-entity] [name=btn_submit]").each(function(){
   PostContextControl(this, j);
   j++;
});
