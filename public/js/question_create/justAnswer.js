/**
 * Created by Станислав on 22.01.16.
 */

var count = 1;                                                                                                      //счетчик числа вариантов
var margin = 50;                                                                                                   //расстояние верхней границы кнопок доавления и удаления

/** Добавление варианта */
$('#type_question_add').on('click','#add-var-8', function(){
    count++;
    $('#variants').append('\
                    <div class="form-group"> \
                        <textarea name="variants[]" class="form-control textarea3" rows="3" placeholder="" required></textarea> \
                        <label for="textarea3">Текст вопроса ' + (count) + '</label> \
                    </div> \
                ');
    $('#answers').append('\
                    <div class="form-group"> \
                        <textarea name="answers[]" class="form-control textarea3" rows="3" placeholder="" required></textarea> \
                        <label for="textarea3">Ответ ' + (count) + '</label> \
                    </div> \
            ');
    margin += 132;
    $('#add-del-buttons').attr('style','margin-top:'+margin+'px');
});

/** Удаление последнего варианта */
$('#type_question_add').on('click','#del-var-8',function(){
    if (count > 1){
        lastvar = $('#variants').children().last().remove();
        lastans = $('#answers').children().last().remove();
        margin -= 132;
        $('#add-del-buttons').attr('style','margin-top:'+margin+'px');
        count--;
    }
});