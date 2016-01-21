/**
 * Created by Станислав on 22.01.16.
 */

var count = 4;                                                                                                      //счетчик числа вариантов
var margin = 220;                                                                                                   //расстояние верхней границы кнопок доавления и удаления

/** Добавление варианта */
$('#type_question_add').on('click','#add-var-1', function(){
    count++;
    $('#variants').append('\
            <div class="form-group">\
                <textarea  name="variants[]"  class="form-control textarea3" rows="1" placeholder="" required></textarea>\
                <label for="textarea3">Вариант ' + count + '</label>\
            </div>\
            ');
    margin += 74;
    $('#add-del-buttons').attr('style','margin-top:'+margin+'px');
});

/** Удаление последнего варианта */
$('#type_question_add').on('click','#del-var-1',function(){
    if (count > 1){
        lastelem = $('#variants').children().last().remove();
        margin -= 74;
        $('#add-del-buttons').attr('style','margin-top:'+margin+'px');
        count--;
    }
});