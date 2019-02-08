function sleep(milliseconds) { // danger function
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}

function set_code(value) {
	//reset
	$('input[type=text]').each(function(){$(this).val('');});
	$('input[type=number]').each(function() {$(this).val('');});
	$('select').each(function(){$(this).val('');});
	//set
	SetRules(JSON.parse(value.replace("&gt;",">").replace("&lt;","<")));
}

function get_code() {
	return JSON.stringify(GetRules());
}

function check_answer(arr){
	try{
		var count = 0;
		for(var i=0; i < arr.length; i++){
		
			rules = GetRules();
			input = arr[i]['input_word'];
			
			result_log = GetResult(rules, input);
			results = result_log.toString().split(",");
			result = results[results.length - 1].replace("[","").replace("]","");
			
			if( result == arr[i]['output_word'] ){
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

function get_str(task, level){
	if(level == "hard")
		task++;
		task++;
	return level + task;
}

function swap_content(hide_str, show_str){
	var code_old = get_code();
	var code_new = $("#" + show_str + "code").html();
	set_code(code_new);
	$("#" + hide_str + "code").html(code_old);
}

function change_my_task(){
	var task_new, task_old, level_new, level_old;
	// old task
	task_old  = $("#task").html();
	level_old = $("#level").html();
	hide_str = get_str(task_old, level_old);
	// new task
	click = this.id;
	if(click == "task1")
	{
		task_new = 1;
		level_new = level_old;
	}
	else if(click == "task2")
	{
		task_new = 2;
		level_new = level_old;
	}
	else if(click == "easy")
	{
		task_new = task_old;
		level_new = "easy";
	}
	else if(click == "hard")
	{
		task_new = task_old;
		level_new = "hard";
	}
	show_str = get_str(task_new, level_new);
	// action
	if(hide_str != show_str)
	{
		$("#level").html(level_new);
		$("#task").html(task_new);
		$("#" + hide_str).css('display', 'none');
		$("#" + show_str).css('display', 'block');
		swap_content(hide_str, show_str);
		if(task_new == 1){
			$("#task2").attr('class', '');
			$("#task1").attr('class', 'active');
		}
		else{
			$("#task1").attr('class', '');
			$("#task2").attr('class', 'active');
		}
		if(level_new == 'easy')
		{
			$("#hard").attr('class', '');
			$("#easy").attr('class', 'active');
		}
		else{
			$("#easy").attr('class', '');
			$("#hard").attr('class', 'active');
		}
	}
}

function submit_task(){
	curr_code = get_code();
	
	var task_old  = $("#task").html();
	var level_old = $("#level").html();
	var hide_str = get_str(task_old, level_old);
	$("#" + hide_str + "code").html(curr_code);
	var easy2code = $("#easy2code").html();
	var easy3code = $("#easy3code").html();
	var hard3code = $("#hard3code").html();
	var hard4code = $("#hard4code").html();
	
	var easy2seqj = $("#easy2seq").html();
	var easy3seqj = $("#easy3seq").html();
	var hard3seqj = $("#hard3seq").html();
	var hard4seqj = $("#hard4seq").html();
	
	var easy2seq  = JSON.parse(easy2seqj);
	var easy3seq  = JSON.parse(easy3seqj);
	var hard3seq  = JSON.parse(hard3seqj);
	var hard4seq  = JSON.parse(hard4seqj);
	
	var mark1 = 0, mark2 = 0;
	
	// some stupid, this must depend on field mark in task_ram table
	set_code(easy2code);
	if( check_answer(easy2seq) == easy2seq.length ){
		mark1 = 2;
	}
	set_code(hard3code);
	if( check_answer(hard3seq) == hard3seq.length ){
		mark1 = 3;
	}
	set_code(easy3code);
	if( check_answer(easy3seq) == easy3seq.length ){
		mark2 = 3;
	}
	set_code(hard4code);
	if( check_answer(hard4seq) == hard4seq.length ){
		mark2 = 4;
	}
	
	SetInput("0000");
	// hide test output
	
	set_code(curr_code);
	
	sum_mark  = mark1 + mark2;
	user_code = "\n********* Задача 1 легкая *******\n" + easy2code +
				"\n********* Задача 1 сложная ******\n" + hard3code + 
				"\n********* Задача 2 легкая *******\n" + easy3code + 
				"\n********* Задача 2 сложная ******\n" + hard4code;
	
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
    });
}

$("#easy2code").html('{"length":13}');
$("#easy3code").html('{"length":13}');
$("#hard3code").html('{"length":13}');
$("#hard4code").html('{"length":13}');

task1.onclick = change_my_task;
task2.onclick = change_my_task;
easy.onclick = change_my_task;
hard.onclick = change_my_task;