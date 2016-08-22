/**
 * Created by Станислав on 22.01.16.
 */

var margins = [];                                                                                                   //расстояние верхней границы кнопок добавления и удаления для текстового вопроса
var counts = [];                                                                                                    //счетчики числа вариантов для текстового вопроса
var word_number = 1;                                                                                                //номер вставляемого слова для текстового вопроса (всегда на 1 больше, чем блоков на самом деле)
var spanLast = 0;                                                                                                   //номер последнего спана в тексте
var spanEdge = 0;                                                                                                   //крайний правый спан (здесь только спаны с одиночными словами)
var startSpan = 0, endSpan = 10000;                                                                                 //номера крайних выделенных спанов

for (k=0; k<50; k++){
    margins[k] = 294;
}
for (k=0; k<50; k++){
    counts[k] = 5;
}

/** Добавление варианта */
$('#type_question_add').on('click','.add-var-3', function(){
    var idButton = $(this).attr('id');
    var numButton;
    numButton = idButton.substring(15);
    //alert(numButton);
    $('#column-'+numButton).append('\
                <div class="form-group">\
                    <textarea  name="variants-'+numButton+'[]"  class="form-control textarea3" rows="1" placeholder="" required></textarea>\
                    <label for="textarea3">Вариант ' + counts[numButton] + '</label>\
                </div>\
                ');
    margins[numButton] += 74;
    $('#add-del-buttons-'+numButton).attr('style','margin-top:'+ margins[numButton]+'px');
    counts[numButton]++;
});

/** Удаление последнего варианта */
$('#type_question_add').on('click','.del-var-3',function(){
    var idButton = $(this).attr('id');
    var numButton;
    numButton = idButton.substring(15);
    if (counts[numButton] > 2){
        $('#column-'+numButton).children().last().remove();
        margins[numButton] -= 74;
        $('#add-del-buttons-'+numButton).attr('style','margin-top:'+margins[numButton]+'px');
        counts[numButton]--;
    }
});

/** по номеру блока удаляет необходимый блок и сдвигает все индексы у нижестоящих блоков */
function removeBlock(blockNum){
    var j;
    $('#card-body-'+blockNum).remove();                                                                  //удаляем этот блок
    j = blockNum + 1;
    for (j; j<word_number; j++){                                                                         //передвигаем индексы всех нижестоящих элементов на -1
        $('#card-body-'+j).attr('id', 'card-body-'+(j-1));
        $('#column-'+j+' textarea').attr('name', 'variants-'+(j-1)+'[]');
        $('#column-'+j).attr('id', 'column-'+(j-1));
        $('#add-del-buttons-'+j).attr('id', 'add-del-buttons-'+(j-1));
        $('#var-add-button-'+j).attr('id', 'var-add-button-'+(j-1));
        $('#var-del-button-'+j).attr('id', 'var-del-button-'+(j-1));
    }
    word_number--;
}

/** Добавляет блок. На вход принимает строку вида span-x, где x - номер спана в тексте и текст спана для автозаполнения им первого варианта блока */
function addBlock(numSpan, firstVar){
    $('#word-variants').append('\
                <div class="card-body '+numSpan+'" id="card-body-'+word_number+'">\
                    <div class="col-md-10 col-sm-6 var-column" id="column-'+word_number+'">\
                     <div class="form-group">\
                            <textarea  name="variants-'+word_number+'[]"  class="form-control textarea3" rows="1" value="0.5" required>0.5</textarea>\
                            <label for="textarea3">Стоимость</label>\
                        </div>\
                        <div class="form-group">\
                            <textarea  name="variants-'+word_number+'[]"  class="form-control textarea3 text-answer" rows="1" value="'+firstVar+'">'+firstVar+'</textarea>\
                            <label for="textarea3">Вариант 1</label>\
                        </div>\
                        <div class="form-group">\
                            <textarea  name="variants-'+word_number+'[]"  class="form-control textarea3" rows="1" placeholder="" required></textarea>\
                            <label for="textarea3">Вариант 2</label>\
                        </div>\
                        <div class="form-group">\
                             <textarea  name="variants-'+word_number+'[]"  class="form-control textarea3" rows="1" placeholder="" required></textarea>\
                            <label for="textarea3">Вариант 3</label>\
                        </div>\
                        <div class="form-group">\
                            <textarea  name="variants-'+word_number+'[]"  class="form-control textarea3" rows="1" placeholder="" required></textarea>\
                            <label for="textarea3">Вариант 4</label>\
                        </div>\
                    </div>\
                    <div class="col-md-2 col-sm-6" style="margin-top: 294px" id="add-del-buttons-'+word_number+'">\
                        <button type="button" class="btn ink-reaction btn-floating-action btn-success add-var-3" id="var-add-button-'+word_number+'"><b>+</b>   </button>\
                        <button type="button" class="btn ink-reaction btn-floating-action btn-danger del-var-3" id="var-del-button-'+word_number+'"><b>-</b></button>\
                    </div>\
                </div>\
                ');
    word_number++;
}

/** проверка, не принадлежит ли слово другой области (true - belong, false - doesn't belong) */
function belongSelection(numSpan) {
    if ($('#text-part-'+numSpan).hasClass('inside') == true){
        alert ('Недопустимо соприкосновение с другой выделенной областью!');
        return true;
    }
    else {
        return false;
    }
}

/** Работа с текстовым полем для занесения текстового вопроса */
$('#type_question_add').on('click','#finish-edit', function(){
    var text;
    var text_part = "";
    var i,q;
    var j=1;
    var flag = true;
    text = $('#edit-text').val();
    var pattern = /\s|,|\.|\?|!|-|:|"/;

    //каждое слово запихиваем в спан
    $('#general-text').attr('style', 'display:block;');
    for (i=0; i<text.length; i++){
        if (pattern.test(text[i]) == false){
            text_part += text[i];
        }
        else {
            if (text_part != ''){
                $('#general-text').append('<span id="text-part-'+j+'" class="text-part" style="cursor:pointer">'+text_part+'</span><span>'+text[i]+'</span>');
                j++;
                text_part = "";
            }
            else {
                $('#general-text').append('<span>'+text[i]+'</span>');
            }
        }
    }
    spanLast = j-1;                                                                                                 //запоминаем номер последнего спана
    spanEdge = j-1;                                                                                                 //запоминаем номер крайнего спана (в данном случае совпадают)

    $('#edit-text').css({'display' : 'none'});                                                                      //прячем поле формы с текстом вопроса
    $('#finish-edit').attr('id', 'edit');                                                                           //меняем статус кнопки
    $('#button-title').text('Вернуться к редактированию');                                                          //меняем текст кнопки

    //работа с блоками, если они уже были созданы
    for (i=1; i<word_number; i++){                                                                                  //идем по всем уже выбранным словам (блокам)
        for (q=1; q<j; q++){                                                                                       //для каждого выбранного слова идем по всем словам в новом тексте
            if ($('#card-body-'+i+' textarea').eq(1).text() == $('#text-part-'+q).text()){                         //если слова совпали
                if ($('#card-body-'+i).attr('class').substring(15) != q){                                          //если старый номер слова в тексте больше не совпадает с новым
                    $('#card-body-'+i).attr('class', 'card-body span-'+q);                                         //присваиваем блоку класс с актуальным номером спана
                    flag = true;
                    $('#text-part-'+q).attr('style', 'cursor:pointer; background-color:lightgreen;');
                    break;
                }
                $('#text-part-'+q).attr('style', 'cursor:pointer; background-color:lightgreen;');                  //при совпадении слова в новом тексте это слово выделяем цветом
            }
            else flag = false;
        }
        if (flag == false){           //если для предыдущего слово не было найдено в новом тексте
            $('#card-body-'+i+' textarea').eq(1).text($('#text-part-'+$('#card-body-'+i).attr('class').substring(15)).text());       //пишем в первый вариант текущего блока слово с номером, соответсвующим старому номеру в тексте
            $('#text-part-'+$('#card-body-'+i).attr('class').substring(15)).attr('style', 'cursor:pointer; background-color:lightgreen;');  //задаем цвет слову в новом тексте
            flag = true;
        }
    }
});

/** возвращение в режим набора текста вопроса */
$('#type_question_add').on('click','#edit', function(){
    $('#button-title').text('Завершить редактирование текста');                                                     //меняем текст кнопки
    $('#edit-text').css({'display' : 'block'});                                                                     //вновь показываем поле формы с текстом вопроса
    $('#general-text').attr('style', 'display:none;');                                                              //прячем набранный текст
    $('#edit').attr('id', 'finish-edit');                                                                           //меняем статус кнопки

    $('#general-text').children().remove();                                                                         //очищаем поле с набранным текстом для нового занесения
    $('#general-text').text('');
});

/** работа со спанами при кликании на них */
$('#type_question_add').on('click','.text-part', function(){
    if ($('#union').text() == 'Перейти в режим объединения слов'){                                                  //если не включен режим объединения в компакты
        var i, j, p, index;
        var pattern = /text-part-/;
        if ($(this).hasClass('inside') == false){                                                                   //если слово не находится в области
            if ($(this).css('background-color') == 'rgb(144, 238, 144)'){                                           //слово уже выделено (выделено светло-зеленым)
                $(this).attr('style', 'cursor:pointer');
                for (i=1; i<word_number; i++){
                    if ($('#card-body-'+i+' textarea').eq(1).text() == $(this).text()){                             //ищем нужный блок
                        removeBlock(i);
                        break;
                    }
                }
            }
            else {                                                                                                  //слово еще не выделено
                $(this).attr('style', 'cursor:pointer; background-color:lightgreen;');
                var idSpan = ($(this).attr('id'));
                var tempStr = idSpan[0];
                for (p=1; p<idSpan.length; p++){
                    if (pattern.test(tempStr) == true){                                                             //присваиваем блоку класс span-x, где x - номер spanа в тексте
                        index  = p;
                        break;
                    }
                    else tempStr += idSpan[p];
                }
                var numSpan = 'span-'+idSpan.substring(index);
                addBlock(numSpan, $(this).text());
            }
        }
        else{                                                                                                       //если слово принадлежит какой-либо области
            $(this).parent().attr('style', 'cursor:pointer');                                                       //убираем его цвет
            $(this).parent().children().attr('style', 'cursor:pointer');                                            //убираем цвет всех элементов области
            var parentId = $(this).parent().attr('id');                                                             //id спана области, куда тыкнули
            var removableBlock = $('.span-'+parentId.substring(10)).attr('id').substring(10);
            removeBlock(parseInt(removableBlock, 10));                                                              //удаляем блок
            $('#'+parentId+' .text-part').removeClass('inside');                                                    //убираем классы принадлжености области
            $('#'+parentId+' .text-part').addClass('temp');                                                         //создаем фиктивный временный класс
            $('.temp').unwrap();                                                                                    //удаляем спан, охватывающий область
            $('.text-part').removeClass('temp');                                                                    //удаляем временный класс
            spanLast--;                                                                                             //уменньшаем число спанов

        }
    }

    if ($('#union').text() == 'Объединить'){                                                                        //если включен режим объединения в компакты
        var tempSpan = parseInt($(this).attr('id').substring(10),10);                                               //текущий выбранный спан
        var temp;
        if (startSpan == tempSpan) return;                                                                          //если выбранный спан совпадает с начальным, то ничего не выпоняем
        var q,l;
        if (startSpan == 0){                                                                                        //если еще не было выделено ни одного элемента
            if (belongSelection(startSpan)) return;
            startSpan = parseInt($(this).attr('id').substring(10),10);
            $(this).css({'background-color':'darkorange'});
            //$(this).addClass('wrapped');
            return;
        }
        if (startSpan != 0 ){                                                                                       //когда уже был выделен стартовый элемент
            if (startSpan <= tempSpan){
                for (q=startSpan; q<=tempSpan; q++){
                    if (belongSelection(q)) return;                                                                 //проверяем, не будет ли новая область пересекаться с существующей
                }
            }
            else {
                for (q=tempSpan; q<=startSpan; q++){
                    if (belongSelection(q)) return;
                }
            }
            $('.wrapped').unwrap();                                                                                 //убираем область
            $('#general-text span').removeClass('wrapped');                                                         //а вместе с ней и классы
            endSpan = tempSpan;                                                                                     //выбранный элемент становится новой крайней границей
            if (startSpan <= endSpan){                                                                              //определяем начало и конец области
                for (q=startSpan; q<=endSpan; q++){
                    if ($('#text-part-'+q).hasClass('wrapped') == false) {
                        $('#text-part-'+q).addClass('wrapped');
                        if (q != endSpan){
                            temp =  $('#text-part-'+q).next();
                            // заглушка - можно написать проверку, чтобы проверялось не только два специальных символа, а до конца выделения
                            while (temp.hasClass('text-part') == false){
                                //alert(temp.text());
                                temp.addClass('wrapped');
                                temp = temp.next();
                            }
                        }
                    }
                    else{

                    }
                }
            }
            else {
                for (q=endSpan; q<=startSpan; q++){
                    if ($('#text-part-'+q).hasClass('wrapped') == false) {
                        $('#text-part-'+q).addClass('wrapped');
                        if (q != startSpan){
                            $('#text-part-'+q).next().addClass('wrapped');
                            if ($('#text-part-'+q).next().next().hasClass('text-part') != true){
                                $('#text-part-'+q).next().next().addClass('wrapped');
                            }
                        }
                    }
                }
            }
            $('.wrapped').wrapAll('<span id="text-part-'+(spanLast+1)+'"></span>');                                 //обособляем нашу область новым спаном
        }
    }
});

/** обработка внесения изменений в первый вариант(ответ) блока */
$('#type_question_add').on('blur', '.text-answer', function(){
    var prevText = $(this).text();                                                                                  //текст до изменения
    var prevSpan =  $(this).parents('.card-body').attr('class').substring(15);                                      //номер спана, совпадавшего с полем до изменения
    var flag = false;
    var i;
    if ($(this).val() == prevText) return;
    for (i=1; i<=spanLast; i++){                                                                                    //идем по всем спанам текста
        if ($(this).val() == $('#text-part-'+i).text() &&  $('#text-part-'+i).attr('style') == 'cursor:pointer'){  //если новое введенное слово существует в спанах и еще не задействовано в других блоках
            $(this).parents('.card-body').attr('class', 'card-body span-'+i);                                       //присваиаем блоку номер этого спана
            $('#text-part-'+i).attr('style', 'cursor:pointer; background-color:lightgreen;');                       //присваиваем этому спану цвет
            $('#text-part-'+prevSpan).attr('style', 'cursor:pointer; ');                                            //убираем цвет у старого совпадавшего спана
            $(this).text($(this).val());                                                                            //присваиваем новое значение полю
            flag = true;
            break;
        }
    }
    if (flag == false){                                                                                             //если новое слово в поле не совпадает ни с одним спаном в тексте
        alert('Ошибка! Такого слова нет в тексте либо оно уже используется!');
        $(this).val(prevText);
    }
});

/** режим объединения слов в компакты */
$('#type_question_add').on('click', '#union', function(){
    if ($('#edit').attr('id') == 'edit'){                                                                           //если включен режим выделения слов
        $('#edit').attr('disabled', 'disabled');                                                                    //отключаем кнопку "Венуться к редактированию"
        if ($(this).text() == 'Перейти в режим объединения слов'){                                                  //если сейчас режим объединения отключен
            $(this).text('Объединить');                                                                             //включаем режим объединения слов в компакты
            $('#cancel-selection').attr('style', 'display: inline');                                                //отображаем кнопку сброса выделения
            var i;
            for (i=1; i<=spanLast; i++){
                //alert($('#text-part-'+i).css('background-color'));
                if ($('#text-part-'+i).css('background-color') == 'rgb(144, 238, 144)'){                            //проверка на светло-зеленый цвет
                    $('#text-part-'+i).css({'color':'#cc0000'});                                                    //выделяем выбранные ранее слова красным цветом
                    $('#text-part-'+i).css({'background-color':''});                                                //убираем фоновое выделение
                }
            }
            return;
        }
        if ($(this).text() == 'Объединить'){                                                                        //действия при объединении
            $('#edit').removeAttr('disabled');                                                                      //включаем кнопку "Венуться к редактированию"
            $(this).text('Перейти в режим объединения слов');                                                       //меняем текст кнопки
            $('#cancel-selection').attr('style', 'display: none');                                                  //скрываем кнопку сброса выделения
            var j,k, removableBlock;
            for (j=1; j<=spanLast; j++){                                                                            //идем по всем спанам тексте
                if ($('#text-part-'+j).css('color') == 'rgb(204, 0, 0)'){                                           //красный цвет слов (слова, которые были выделены в блоки)
                    $('#text-part-'+j).css({'color':'', 'background-color':'lightgreen'});                          //убираем цвет букв
                    if ($('#text-part-'+j).hasClass('wrapped') == true){                                            //если слово оказалось внутри выделенной области
                        for (k=1; k<word_number; k++){
                            if ($('.card-body').hasClass('span-'+j)){                                                //нужно найти блок, у которого в нлассе span-x с нужным номером слова (i), взять id, а точнее номер card-body-y, и функцией удалить блок
                                removableBlock = $('.span-'+j).attr('id').substring(10);
                                removeBlock(parseInt(removableBlock, 10));
                            }
                        }
                    }
                    else{                                                                                           //если красное слово вне выделенной области
                        $('#text-part-'+j).css({'background-color':'lightgreen'});                                  //меняем фоновое выделение на обычный зеленый
                    }
                }
            }
            if (endSpan == 10000){                                                                                  //если в области одно слово
                if ($('#text-part-'+startSpan).css('color') != 'rgb(204, 0, 0)'){                                   //если слово не красное (не входит в блок)
                    $('#text-part-'+startSpan).css({'background-color':'', 'cursor':'pointer'});                    //не подсвечиваем его
                }
                startSpan = 0;                                                                                      //сбрасываем границы выделенной области
                endSpan = 10000;
                return;                                                                                             //ничего не добавляем
            }
            $('#general-text span').removeClass('wrapped');                                                         //убираем класс для сброса оранжевого цвета
            $('#text-part-'+startSpan).css({'background-color':'lightgreen'});                                      //отдельно подсвечиваем начальный элемент области
            $('#text-part-'+(spanLast+1)).css({'background-color':'lightgreen', 'cursor':'pointer'});               //выделяем область зеденым цветом + курсор
            $('#text-part-'+(spanLast+1)+' .text-part').addClass('inside');                                         //добавляем всем одиночным словам внутри области класс, символизирующий, что они находятся внутри спана
            addBlock('span-'+(spanLast+1), $('#text-part-'+(spanLast+1)).text());                                   //добавляем блок с областью
            spanLast++;                                                                                             //инкрементируем число спанов
        }
        startSpan = 0;                                                                                              //сбрасываем границы выделенной области
        endSpan = 10000;
    }
});

/** сбросить выделение */
$('#type_question_add').on('click', '#cancel-selection', function(){
    $('.wrapped').unwrap();                                                                                        //убираем область
    $('#general-text span').removeClass('wrapped');                                                                //а вместе с ней и классы
    $('#text-part-'+startSpan).css({'background-color':''});
    startSpan = 0;
    endSpan = 10000;
});
