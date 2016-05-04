/**
 * Created by Станислав on 04.05.16.
 */
var files = 1;                                                                                                          //число прикрепленных файлов

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
        for (var i=1; i < array.length; i = i + 2){                                                                     //обратно обрамляем названия файлов в скобки
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
    $('#text-images-container').children('input').each(function(){                                                      //составляем массив из названий выбранных файлов
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

    //TODO: добавить проверку, чтобы не сабмиталось, если не выбрано ни одного верного варианта
});