/**
 * Created by Станислав on 22.01.16.
 */

var count = 4;                                                                                                      //счетчик числа вариантов
var margin = 220;                                                                                                   //расстояние верхней границы кнопок доавления и удаления

/** Добавление варианта */
$('#type_question_add').on('click','#add-var-2', function(){
    count++;
    $('#variants').append('\
            <div class="form-group">\
                <textarea  name="variants[]"  class="form-control textarea3" rows="1" placeholder="" required></textarea>\
                <label for="textarea3">Вариант ' + count + '</label>\
            </div>\
            ');
    $('#answers').append('\
            <div class="checkbox checkbox-styled" style="margin-top:49px">\
                <label>\
                    <input type="checkbox" name="answers[]" value="'+ count + '">\
                    <span></span>\
                </label>\
            </div>\
            ');
    margin += 74;
    $('#add-del-buttons').attr('style','margin-top:'+margin+'px');
});

/** Удаление последнего варианта */
$('#type_question_add').on('click','#del-var-2',function(){
    if (count > 1){
        lastelem = $('#variants').children().last().remove();
        $('.checkbox-styled').last().remove();
        margin -= 74;
        $('#add-del-buttons').attr('style','margin-top:'+margin+'px');
        count--;
    }
});