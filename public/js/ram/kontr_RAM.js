function CheckAnswer(arr){
	var count = 0;
	for(var i=0; i < arr.length; i++){
		input.value  = arr[i]['input_word'];
		output.value = "";
		drop_run.dispatchEvent(new Event("click"));
		btn_start.dispatchEvent(new Event("click"));
		if( output.value == " " + arr[i]['output_word'] ){
			count++;
		}
		btn_reset.dispatchEvent(new Event("click"));
	}
	return count;
}

function get_str(task, level){
	if(level == "hard")
		task++;
		task++;
	return level + task;
}

function SwapContent(hide_str, show_str){
	var code_old = RAM.TextEditor.get_text();
	var code_new = $("#" + show_str + "code").html();
	RAM.TextEditor.set_text(code_new);
	$("#" + hide_str + "code").html(code_old);
}

function ChangeMyTask(){
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
		SwapContent(hide_str, show_str);
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

function SubmitTask(){
	var curr_code = RAM.TextEditor.get_text();
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
	RAM.no_notice = true;
	// some stupid, this must depend on field mark in task_ram table
	RAM.TextEditor.set_text(easy2code);
	if( CheckAnswer(easy2seq) == easy2seq.length ){
		mark1 = 2;
	}
	RAM.TextEditor.set_text(hard3code);
	if( CheckAnswer(hard3seq) == hard3seq.length ){
		mark1 = 3;
	}
	RAM.TextEditor.set_text(easy3code);
	if( CheckAnswer(easy3seq) == easy3seq.length ){
		mark2 = 3;
	}
	RAM.TextEditor.set_text(hard4code);
	if( CheckAnswer(hard4seq) == hard4seq.length ){
		mark2 = 4;
	}
	input.value  = "";
	output.value = "";
	RAM.no_notice = false;
	RAM.TextEditor.set_text(curr_code);
	
	sum_mark  = mark1 + mark2;
	user_code = "\n********* Задача 1 легкая *******\n" + easy2code +
				"\n********* Задача 1 сложная ******\n" + hard3code + 
				"\n********* Задача 2 легкая *******\n" + easy3code + 
				"\n********* Задача 2 сложная ******\n" + hard4code;
	
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

task1.onclick = ChangeMyTask;
task2.onclick = ChangeMyTask;
easy.onclick = ChangeMyTask;
hard.onclick = ChangeMyTask;
