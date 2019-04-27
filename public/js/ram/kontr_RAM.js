function checkAnswer(impl, arr){
	var count = 0;
	for(var i=0; i < arr['input_word'].length; i++){
		envs[impl].ctx.input.val(arr['input_word'][i]);
		envs[impl].ctx.output.val("");
		envs[impl].ctx.drop_run.trigger("click");
		envs[impl].ctx.btn_start.trigger("click");
		if( envs[impl].ctx.output.val() == " " + arr['output_word'][i] ){
			count++;
		}
		envs[impl].ctx.btn_reset.trigger("click");
	}
	return count;
}

function ramSubmitTask(impl, notice){
	var user_code = envs[impl].RAM.TextEditor.get_text();
	var test_seq = JSON.parse(envs[impl].ctx.get_elem("test_seq").html());
	
	envs[impl].ctx.no_notice = true;
	
	deb_cnt = $("[name=type][value=15]").eq(impl).parent().find("[name=debug_counter]").first();
	seq_true = $("[name=type][value=15]").eq(impl).parent().find("[name=sequences_true]").first();
	seq_all = $("[name=type][value=15]").eq(impl).parent().find("[name=sequences_all]").first();
	
	var debug_counter = deb_cnt.val();
	debug_counter++;
	deb_cnt.val(debug_counter);
	
	var sequences_true = checkAnswer(impl, test_seq);
	seq_true.val(sequences_true);
	
	var sequences_all  = test_seq['input_word'].length;
	seq_all.val(sequences_all);
	
	envs[impl].ctx.input.val("");
	envs[impl].ctx.output.val("");
	envs[impl].ctx.no_notice = false;
	
	/*
	$.ajax({
		cache: false,
        type: 'POST',
        url: '/algorithm/RAM/set_mark',
		beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { mark1:     mark,
				mark2:     mark,
				sum_mark:  sum_mark,
				user_code: user_code,
				token:     'token' },
        success: function(data){
			alert("Ваша работа была успешно отправлена!");
			alert("Ваша оценка: " + mark + " из 1 баллов\n");
        }
    });*/
	
	if(notice){
		alert("Текущий результат отправки: " + sequences_true + " тестов сработало из " + sequences_all + 
			  " . Количество отправок: " + debug_counter + "\n");
	}
}

class ContextKontr{
    constructor(ptr, cnt){
        $(ptr).click(function(){ ramSubmitTask(cnt, true); });
    }
}

var envsKontr = [];
var cnt = 0;

$("[name^=ram-entity] [name=btn_submit]").each(function(){
   envsKontr.push( new ContextKontr(this, cnt) );
   cnt++;
});
