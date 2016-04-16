/**
 * Created by Станислав on 22.01.16.
 */

var count = 4;                                                                                                      //счетчик числа вариантов
var margin = 220;                                                                                                   //расстояние верхней границы кнопок доавления и удаления
var files = 1;                                                                                                          //число прикрепленных файлов

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

$('#text-images-container').on('change','.text-image-input',function(){
    var numFile = $(this).attr('id').substr(17);
    var filename = '[[' + $(this).val() + ']]';
    if (numFile == files){                                                                                              //если работа ведется с последней формой
        files++;
        $('#textarea1').val($('#textarea1').val() + filename);
        $('#text-images-container').append('\
        <br>\
        <input type="file" name="text-images[]" id="text-image-input-'+files+'" class="text-image-input">\
        ');
    }
    else{
        var array = $('#textarea1').val().split(/\[\[|\]\]/);                                                           //разбиваем строку на элементы, где на нечетных номерах названия файлов
        array[2*numFile-1] = $(this).val();                                                                             // меням поменявшийся файл
        for (var i=1; i < array.length; i = i + 2){                                                                     //обратно обрамлсем названия файлов в скобки
            array[i] = '[[' + array[i] + ']]';
        }
        var text = "";
        for (i = 0; i < array.length; i++){                                                                             //записываем все в строку
            text += array[i];
        }
        $('#textarea1').val(text);                                                                                      //передаем эту строку в поле текста вопроса
    }
});

$('#type_question_add').on('click', '.submit-question', function(){
    var array = $('#textarea1').val().split(/\[\[|\]\]/);
    var filenames = [];
    $('#text-images-container').children('input').each(function(){                                                             //составляем массив из названий выбранных файлов
        filenames.push($(this).val());
    });

    if(array.length != (2*filenames.length - 1)){
        alert('Структура текста была изменена. Число выбранных файлов не соответствует тексту! Внесите изменения');
        return false;
    }

    var j = 0;
    for (var i=1; i < array.length; i = i + 2){
        if (array[i] != filenames[j]){
            alert('Ваш файл №'+(j+1)+'в строке текста вопроса не совпадает с выбранным файлом! Перевыберите этот файл.');
            return false;
        }
        else j++;
    }
});

