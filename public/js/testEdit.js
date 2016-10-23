/**
 * Created by Станислав on 16.05.16.
 */
if ($('#test-type').val() == 'Контрольный' && ($('#test-time-zone').val() == -1 || $('#test-time-zone').val() == 0) && $('#test-resolved') == 1){ //если тест прошедший или текущий и обязательно контрольный и обязательно уже кем-то решенный
    $('#question-table input, #question-table select').prop('disabled', true);                                          //блокируем все поля в настройке струтктуры теста
    $('#add-row').prop('disabled', true);
    $('#del-row').prop('disabled', true);
    $('#start-date, #start-time').prop('disabled', true);                                                               //нельзя менять начало теста
}

    /** Действия по сабмиту */
    // : TODO сделать соответствующие проверки на передвижение дат в зависимости от завершенности теста
$('.submit-test').click(function(){
//    var start = Date.parse($('#start-date').val().toString() + ' ' + $('#start-time').val().toString());
//    var end = Date.parse($('#end-date').val().toString() + ' ' + $('#end-time').val().toString());
//
//    if ($('#test-type').val() === 'Контрольный' && ($('#test-time-zone').val() == -1 || $('#test-time-zone').val() == 0)){
//        if (end < Date.parse($('#old-end-date').val().toString() + ' ' + $('#old-end-time').val().toString())){
//            alert('Нельзя уменьшать время окончания прошлых и текущих тестов!');
//            $('#end-date').val($('#old-end-date').val());                                                               //возвращаем в исходное состояние
//            $('#end-time').val($('#old-end-time').val());
//            $('#end-date').focus();
//            return false;
//        }
//    }
});