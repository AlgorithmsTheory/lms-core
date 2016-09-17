/**
 * Created by Станислав on 04.05.16.
 */
var files = 1;                                                                                                          //число прикрепленных файлов

/** Обновление ссылки на файл при его изменении */
function updateLinkedFile(field, numFile) {
    var array = field.val().split(/\[\[|\]\]/);                                                           //разбиваем строку на элементы, где на нечетных номерах названия файлов
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

/** Проверка корректности файлов в тексте вопроса */
function checkFiles(field) {
    var res = true;
    var con;
    var flag = true;
    var array = field.val().split(/\[\[|\]\]/);
    var oldArray = field.val().split(/::/);
    var filenames = [];
    $('#text-images-container').children('input').each(function(){                                                      //составляем массив из названий выбранных файлов
        filenames.push($(this).val());
    });


    if(array.length != (2*filenames.length - 1)){
        alert('Структура текста была изменена. Число выбранных файлов не соответствует тексту! Внесите изменения');
        res = false;
    }

    var j = 0;
    for (var i=1; i < array.length; i = i + 2){
        if (array[i] != filenames[j]){
            alert('Ваш файл №'+(j+1)+'в строке текста вопроса не совпадает с выбранным файлом! Перевыберите этот файл.');
            res = false;
        }
        else j++;
    }

    $('.images-in-text').each(function() {
       if (!flag){
           return false;
       }
       for (i = 1; i < oldArray.length; i += 2) {
           if ($(this).val() != oldArray[i]){
               con = confirm("Вы изменили название ранее прикрепленного файла! Верните исходное название " + $(this).val() +
                                 ". В противном случае в тесте данный текст будет отображен в таком виде: " + oldArray[i] +
                                 ". Вернуться к редактированию?");
               if (!con) {
                   res = false;
                   flag = false;
                   break;
               }
           }
       }
    });
    return res;
}

$('#text-images-container').on('change','.text-image-input',function(){
    var numFile = $(this).attr('id').substr(17);
    var filename = '[[' + $(this).val() + ']]';
    if (numFile == files){                                                                                              //если работа ведется с последней формой
        files++;
        $('#textarea1').val($('#textarea1').val() + filename);
        $('#eng-textarea1').val($('#eng-textarea1').val() + filename);
        $('#text-images-container').append('\
        <br>\
        <input type="file" name="text-images[]" id="text-image-input-'+files+'" class="text-image-input">\
        ');
    }
    else{
        updateLinkedFile($('#textarea1'), numFile);
        updateLinkedFile($('#eng-textarea1'), numFile);
    }
});

$('#type_question_add').on('click', '.submit-question', function(){
    if (!checkFiles($('#textarea1'))){
        return false;
    }
    if (!checkFiles($('#eng-textarea1'))) {
        return false;
    }

    //TODO: добавить проверку, чтобы не сабмиталось, если не выбрано ни одного верного варианта
});