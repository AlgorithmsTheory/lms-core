function checkAnswer(arr){
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

function ramSubmitTask(notice){
	var user_code = RAM.TextEditor.get_text();
	var test_seq = JSON.parse($("#test_seq").html());
	
	RAM.no_notice = true;
	
	var debug_counter = $("#debug_counter").val();
	debug_counter++;
	$("#debug_counter").val(debug_counter);
	
	var sequences_true = checkAnswer(test_seq);
	$("#sequences_true").val(sequences_true);
	
	var sequences_all  = test_seq.length;
	$("#sequences_all").val(sequences_all);
	
	input.value  = "";
	output.value = "";
	RAM.no_notice = false;
	
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
