/**
 * Created by Станислав on 30.10.16.
 */
/** Действия по сабмиту */
$('.submit-test').click(function(){
    $('#num-rows').val(count);

    var now = Date.now();
    var startDates = [];
    var endDates = [];
    var startTimes = [];
    var endTimes = [];

    $('.start-date').each(function(){
        startDates.push($(this).val());
    });
    $('.end-date').each(function(){
        endDates.push($(this).val());
    });
    $('.start-time').each(function(){
        startTimes.push($(this).val());
    });
    $('.end-time').each(function(){
        endTimes.push($(this).val());
    });

    for (i = 0; i < startDates.length; i++) {
        var start = Date.parse(startDates[i].concat(" ").concat(startTimes[i]));
        var end = Date.parse(endDates[i].concat(" ").concat(endTimes[i]));
        if (start <= now){                                                                                              //если начало меньше текущего времени
            alert('Открытие теста должно быть больше текущего времени!');
            $('.start-date').focus();
            return false;
        }

        if (end <= start + 3600000){                                                                                    //если между началом и концом менее часа разницы
            alert('Окончание теста должно быть хотя бы на час больше времени открытия');
            $('.end-date').focus();
            return false;
        }
    }
});