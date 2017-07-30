/**
 * Created by Станислав on 22.01.16.
 */

var count = 1;                                                                                                      //счетчик числа вариантов
var margin = 50;                                                                                                   //расстояние верхней границы кнопок доавления и удаления

/** Добавление варианта */
$('#type_question_add').on('click','#add-var-7', function(){
    count++;
    $('#variants').append('\
                    <div class="form-group"> \
                        <textarea name="variants[]" class="form-control textarea3" rows="3" placeholder="" required></textarea> \
                        <label for="textarea3">Определение ' + (count) + '</label> \
                    </div> \
                ');
    $('#answers').append('\
                    <div class="form-group"> \
                        <textarea name="answers[]" class="form-control textarea3" rows="3" placeholder="" required></textarea> \
                        <label for="textarea3">Расшифровка ' + (count) + '</label> \
                    </div> \
            ');
    $('#eng-variants').append('\
                    <div class="form-group"> \
                        <textarea name="eng-variants[]" class="form-control textarea3" rows="3" placeholder=""></textarea> \
                        <label for="textarea3">Definition ' + (count) + '</label> \
                    </div> \
                ');
    $('#eng-answers').append('\
                    <div class="form-group"> \
                        <textarea name="eng-answers[]" class="form-control textarea3" rows="3" placeholder=""></textarea> \
                        <label for="textarea3">Transcript ' + (count) + '</label> \
                    </div> \
            ');
    margin += 132;
    $('#add-del-buttons').attr('style','margin-top:'+margin+'px');
});

/** Удаление последнего варианта */
$('#type_question_add').on('click','#del-var-7',function(){
    if (count > 1){
        lastvar = $('#variants').children().last().remove();
        lastans = $('#answers').children().last().remove();
        margin -= 132;
        $('#add-del-buttons').attr('style','margin-top:'+margin+'px');
        count--;
    }
});