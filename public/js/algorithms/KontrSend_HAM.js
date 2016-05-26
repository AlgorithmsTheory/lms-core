function drop_sup(x) {
    var chars = '0123456789', sup   = '₀₁₂₃₄₅₆₇₈₉';
    rs = ""
    for ( var i = 0; i < x.length; i++ ) {
        var n = sup.indexOf(x[i]);
        rs += ( n!=-1 ? chars[n] : x[i]);
    }
    return rs
}



function run_all_normal(i){

    var number = i;
    var key = '#' + $('div.active *> li.active > a')[0].href.split('#')[1];  // for example = #light1     var $max_mark;
    var task = new Object();
    task.id = task_id_map[key]; // get id task
    task.rule = new Array();
    task.duration = now.getMinutes() - start_time;
    task.str = $('textarea[name=textarea_src]').val();
    var src = $('input[name=start]').toArray();
    var dst = $('input[name=end]').toArray();
    if(i == 0) {
        document.getElementById("send_one").disabled = true;
    }
    else {
        document.getElementById("send_two").disabled = true;
    }
    for ( var i = 0; i < src.length; i++) {
        tmp = new Object();
        tmp.src = drop_sup(src[i].value);
        tmp.dst = drop_sup(dst[i].value);
        if ( src[i].value.length > 0 && dst[i].value.length > 0 ) {
            task.rule.push(tmp)
        }
    }


    token = $('#forma').children().eq(0).val();
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/uir/public/get-HAM-kontr',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { task: JSON.stringify(task), token: 'token' },
        success: function(data){
            var resp = data;
            show_result(number, resp);
            if ( resp.error != 'ok' ) {
                alert("Программа зациклилась!");
            }
        }
    });
    return false;
}


function show_result(task_number, resp){
    $('input[id=result' + (task_number + 1) + ']').val(resp.result); // записываем ответ
    for (var i = 1; i <= 5; ++i) {     //выводим последовательности
        field_number = i + task_number * 5;
        $('td[id=output' + field_number + ']').text(resp.conv[i - 1]);
        $('td[id=input' + field_number + ']').text(resp.input[i - 1]);
        $('td[id=field' + field_number + ']').text(resp.ksuha[i - 1]);
    }
}
function get_tasks(){
    var token = $('#forma').children().eq(0).val();
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/uir/public/get_control_tasks_HAM',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: {token: 'token' },
        success: function(data){
            var resp = $.parseJSON(data);
            //var resp = data;
            //alert(resp);
            for ( var i = 0; i < resp.length; ++i){
                selector = '#' + ((resp[i].level == 1) ? 'light' : 'hard') + resp[i].number + '> p';
                $(selector).text(resp[i].task);
                task_id_map[selector.split('>')[0]] = resp[i].id_task;
                number_task = resp[i].number;
            }
        }
    });
}
var task_id_map = {};
var now = new Date();
//alert( now );
var start_time = now.getMinutes() ;
setTimeout(get_tasks, 500);