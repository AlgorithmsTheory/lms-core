/**
 * Created by Станислав on 22.01.16.
 */

var count = $('#count').val();                                                                                                //счетчик числа вариантов

/** Добавление варианта */
$('#type_question_add').on('click','#add-var-1', function(){
    count++;
    $('#variants').append('\
            <div class="form-group">\
                <textarea  name="variants[]"  class="form-control textarea3" rows="1" placeholder="" required></textarea>\
                <label for="textarea3">Вариант ' + count + '</label>\
            </div>\
            ');
    $('#eng-variants').append('\
            <div class="form-group">\
                <textarea  name="eng-variants[]"  class="form-control textarea3" rows="1" placeholder=""></textarea>\
                <label for="textarea3">Variant ' + count + '</label>\
            </div>\
            ');
});

/** Удаление последнего варианта */
$('#type_question_add').on('click','#del-var-1',function(){
    if (count > 1){
        $('#variants').children().last().remove();
        $('#eng-variants').children().last().remove();
        count--;
    }
});