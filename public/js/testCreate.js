/**
 * Created by Станислав on 07.09.15.
 */
    count = 1;
    //подгружаем данные в зависимости от выбранного типа вопроса
$('#question-table').on('change','.select-section', function(){
    choice = $('.select-section option:selected').val();
    alert (choice);
    token = $('.form').children().eq(0).val();
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/uir/public/get-theme-for-test',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { choice: choice, token: 'token' },
        success: function(data){
            $('.cont').html(data);
        }
    });
    return false;
});

$('#add-row').click(function(){
    $('#row').children().clone().appendTo('#question-table');
});

$('#type_question_add').on('click','#del-var-1',function(){
    if (count > 2){
        lastelem = $('#variants').children().last().remove();
        margin -= 74;
        $('#add-del-buttons').attr('style','margin-top:'+margin+'px');
        count--;
    }
});