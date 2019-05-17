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
    
    deb_cnt = $("[name=type][value=14]").eq(cnt).parent().find("[name=debug_counter]").first();
	seq_true = $("[name=type][value=14]").eq(cnt).parent().find("[name=sequences_true]").first();
	seq_all = $("[name=type][value=14]").eq(cnt).parent().find("[name=sequences_all]").first();
    
    if(notice){
        var debug_counter = deb_cnt.val();
        debug_counter++;
        deb_cnt.val(debug_counter);
    }
    
    var sequences_true = postCheckAnswer(ctx, test_seq);
	seq_true.val(sequences_true);
	
	var sequences_all  = test_seq['input_word'].length;
	seq_all.val(sequences_all);
	
	SetInput(ctx, "0000");
	
    /*
	$.ajax({
		cache: false,
        type: 'POST',
        url: '/algorithm/Post/set_mark',
		beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { mark1:     mark1,
				mark2:     mark2,
				sum_mark:  sum_mark,
				user_code: user_code,
				token:     'token' },
        success: function(data){
			alert("Ваша работа была успешно отправлена!");
			alert("Ваша оценка за первую работу: " + mark1 + " из 3 баллов\n" +
				  "Ваша оценка за вторую работу: " + mark2 + " из 4 баллов\n" +
				  "Ваша общая оценка: " + (mark1 * 1 + mark2 * 1) + " из 7 баллов");
        }
    });*/
    
    if(notice){
		alert("Текущий результат отправки: " + sequences_true + " тестов сработало из " + sequences_all + 
			  " . Количество отправок: " + debug_counter + "\n");
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
