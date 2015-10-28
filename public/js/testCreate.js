/**
 * Created by Станислав on 07.09.15.
 */
    count = 1;
function sleepTheme(arg){
    return arg.parent().next().children().children().val();
}

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
    $('tr').last().children().eq(2).children().attr('id','container-'+count);                                           //колонка темы
    $('tr').last().children().last().attr('id', 'amount-container-'+count);                                             //колонка всего вопросов такого типа
    $('tr').last().children().first().children().attr('id', 'num-'+count);                                              //колонка количества вопросов
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

/**
 * Определение количества вопросов по указанному фильтру (Раздел, Тема, Тип)
 */
$('#question-table').on('change','.select-type, .select-theme, .select-section', '#training', function(){
    if ($('#training').prop('checked')){
        testType = 'Тренировочный';
    }
    else testType = 'Контрольный';
    if ($(this).attr('name') == 'section[]'){                                                                           //если изменили раздел
        section = $(this).val();
        theme = 'Любая';
        type = $(this).parent().next().next().children().val();
        tempCount = $(this).parent().parent().attr('id').substring(4);
    }
    if ($(this).attr('name') == 'theme[]'){                                                                             //если изменили тему
        section = $(this).parent().parent().prev().children().val();
        theme = $(this).val();
        type = $(this).parent().parent().next().children().val();
        tempCount = $(this).parent().parent().parent().attr('id').substring(4);
    }
    if ($(this).attr('name') == 'type[]'){                                                                              //если изменили тип
        section = $(this).parent().prev().prev().children().val();
        theme = $(this).parent().prev().children().children().val();
        type = $(this).val();
        tempCount = $(this).parent().parent().attr('id').substring(4);
    }
    token = $('.form').children().eq(0).val();

    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/uir/public/get-amount',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { section: section, theme: theme, type: type, test_type: testType, token: 'token' },
        success: function(data){
            $('#amount-container-'+tempCount).html(data);
            $('#num-'+tempCount).attr('max', data);
        }
    });
    return false;
});