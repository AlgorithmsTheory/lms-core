/**
 * Created by Станислав on 07.09.15.
 */
    count = 1;

/**
 * подгружаем данные в зависимости от выбранного типа вопроса
 */
$('#question-table').on('change','.select-section', function(){
    choice = $(this).val();
    var tempCount = $(this).parent().parent().attr('id').substring(4);
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
            $('#container-'+tempCount).html(data);
        }
    });
    return false;
});

/**
 * добавление строки в таблицу
 */
$('#add-row').click(function(){
    $('#row-1').clone().appendTo('#question-table');                                                                    //копируем первую строку и добавляем в конец таблицы
    count++;
    $('tr').last().attr('id', 'row-'+count);                                                                            //добавляем идентифицирующие id
    $('tr').last().children().eq(2).children().attr('id','container-'+count);
});

/**
 * удаление строки из таблицы
 */
$('#del-row').click(function(){
    if (count > 1){
        $('#row-'+count).remove();
        count--;
    }
});

$('.submit-test').click(function(){
    $('#num-rows').val(count-1);
});