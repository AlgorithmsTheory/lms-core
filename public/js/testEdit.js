/**
 * Created by Станислав on 16.05.16.
 */
if ($('#test-type').val() == 'Контрольный' && $('#test-resolved').val() == 1){                                          //если тест контрольный и пройденный хотя бы раз                                                                             // если тест пройден хотя бы единожды
        $('#question-table input, #question-table select').prop('disabled', true);                                      //блокируем все поля в настройке струтктуры теста
        $('#add-row').prop('disabled', true);
        $('#del-row').prop('disabled', true);

        $(".test-for-group-row").each(function(){
            if ($(this).find('.is-finished').val() == 0) {                                                              // если тест незавершен для группы
                $(this).find('.start-date, .start-time').prop('disabled', true);                                        // блокируем начало теста для группы
            }
        });
}

    /** Действия по сабмиту */
$('.submit-test').click(function(){
    $('#num-rows').val(count);
    var flag = true;
    $('.test-for-group-row').each(function () {
        var start = Date.parse($(this).find('.start-date').val().toString() + ' ' + $(this).find('.start-time').val().toString());
        var end = Date.parse($(this).find('.end-date').val().toString() + ' ' + $(this).find('.end-time').val().toString());
        var oldStart = Date.parse($(this).find('.old-start-date').val().toString() + ' ' + $(this).find('.old-start-time').val().toString());
        var oldEnd = Date.parse($(this).find('.old-end-date').val().toString() + ' ' + $(this).find('.old-end-time').val().toString());

        if ($('#test-type').val() === 'Контрольный' && $('#test-resolved').val() == 1) {                                 // если тест контрольный и пройденный хотя бы раз
            if ($(this).find('.is-finished').val() == 0) {                                                              // если тест не завершен для группы
                if (end < oldEnd) {                                                                                      // если новое время закрытия стало меньше
                    alert('Нельзя уменьшать время окончания незавершенных пройденных контрольных тестов!');
                    $(this).find('.end-date').val($(this).find('.old-end-date').val());                                 // возвращаем в исходное состояние
                    $(this).find('.end-time').val($(this).find('.old-end-time').val());
                    $(this).find('.end-date').focus();
                    return flag = false;
                }
            }
            else {                                                                                                      // если тест завершен для группы, то его можно перезапустить
                if (start <= now) {                                                                                      //если начало меньше текущего времени
                    alert('Открытие теста должно быть больше текущего времени!');
                    $(this).find('.start-date').focus();
                    return flag = false;
                }
                if (end <= start + 3600000) {                                                                            // если между началом и концом менее часа разницы
                    alert('Окончание теста должно быть хотя бы на час больше времени открытия!');
                    $(this).find('.end-date').focus();
                    return flag = false;
                }
            }
        }
        else {                                                                                                          // если тест тренировочный или контрольный, но еще не пройденный ни разу
            if (start < oldStart) {                                                                                     // если новое время открытия оказалсоь меньше старого
                alert('Открытие теста не может стать меньше старого значения!');
                $(this).find('.start-date').focus();
                return flag = false;
            }
            if (end <= start + 3600000) {                                                                                // если между началом и концом менее часа разницы
                alert('Окончание теста должно быть хотя бы на час больше времени открытия!');
                $(this).find('.end-date').focus();
                return flag = false;
            }
        }
    });
    return flag;
});