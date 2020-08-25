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
	
	seq_true = $("[name=type][value=15]").eq(impl).parent().find("[name=sequences_true]").first();
	seq_all = $("[name=type][value=15]").eq(impl).parent().find("[name=sequences_all]").first();
    debug_form = $("[name=type][value=15]").eq(impl).parent().find("[name=debug_counter]").first();
    task_id = $("[name=type][value=15]").eq(impl).parent().find("[name=num]").first().val();
    counter = $("[name=type][value=15]").eq(impl).parent().find("[name=counter]").first().val();
    test_id = $("#id_test").val();
	
	var sequences_true = checkAnswer(impl, test_seq);
	seq_true.val(sequences_true);
	
	var sequences_all  = test_seq['input_word'].length;
	seq_all.val(sequences_all);
	
	envs[impl].ctx.input.val("");
	envs[impl].ctx.output.val("");
	envs[impl].ctx.no_notice = false;
	
    if(notice){
        $.ajax({
            cache: false,
            type: 'POST',
            url: '/algorithm/RAMCheck',
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
                    user_code: user_code,
                    token:     'token' },
            success: function(data){
                
                debug_counter = data['choice']['debug_counter'];
                debug_form.val(debug_counter);
                
                alert("Текущий результат отправки: " + sequences_true + " тестов сработало из " + sequences_all + 
                      " . Количество отправок: " + debug_counter + "\n");
            }
        });
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
