/**
 * Created by Станислав on 28.07.15.
 */
    var count = 5;    //счетчик числа вариантов
    var margin = 220; //расстояние верхней границы кнопок доавления и удаления

    //подгружаем данные в зависимости от выбранного типа вопроса
    $('#select-type').change(function(){
        count = 5;
        margin = 220;
        choice = $('#select-type option:selected').val();
        token = $('.form').children().eq(0).val();
        $.ajax({
            cache: false,
            type: 'POST',
            url:   '/uir/public/get-type',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: { choice: choice, token: 'token' },
            success: function(data){
                $('#type_question_add').html(data);
            }
        });
        return false;
    });

    //Добавление варианта
    $('#type_question_add').on('click','#add-var-1', function(){
        $('#variants').append('\
            <div class="form-group">\
                <textarea  name="variants[]"  class="form-control textarea3" rows="1" placeholder=""></textarea>\
                <label for="textarea3">Вариант ' + count + '</label>\
            </div>\
            ');
        margin += 74;
        $('#add-del-buttons').attr('style','margin-top:'+margin+'px');
        count++;
    });

    $('#type_question_add').on('click','#add-var-2', function(){
        $('#variants').append('\
            <div class="form-group">\
                <textarea  name="variants[]"  class="form-control textarea3" rows="1" placeholder=""></textarea>\
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
        count++;
    });

    //Удаление варианта
    $('#type_question_add').on('click','#del-var-1',function(){
        if (count > 2){
            lastelem = $('#variants').children().last().remove();
            margin -= 74;
            $('#add-del-buttons').attr('style','margin-top:'+margin+'px');
            count--;
        }
    });

    $('#type_question_add').on('click','#del-var-2',function(){
        if (count > 2){
            lastelem = $('#variants').children().last().remove();
            $('.checkbox-styled').last().remove();
            margin -= 74;
            $('#add-del-buttons').attr('style','margin-top:'+margin+'px');
            count--;
        }
    });

    //Формирование списка тем, соответствующих выбранному разделу
    $('#type_question_add').on('change','#select-section', function(){
        choice = $('#select-section option:selected').val();
        token = $('.form').children().eq(0).val();
        $.ajax({
            cache: false,
            type: 'POST',
            url:   '/uir/public/get-theme',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: { choice: choice, token: 'token' },
            success: function(data){
                $('#container').html(data);
            }
        });
        return false;
    });
