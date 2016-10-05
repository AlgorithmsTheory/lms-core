/**
 * Created by Станислав on 21.09.16.
 */

/**
 * Created by Станислав on 22.01.16.
 */

var countsEng = [];                                                                                                    //счетчики числа вариантов для текстового вопроса
var wordNumberEng = parseInt($('#js_word_number_eng').val());                                                                                                //номер вставляемого слова для текстового вопроса (всегда на 1 больше, чем блоков на самом деле)
var spanLastEng = parseInt($('#js_span_last_eng').val());                                                                                                   //номер последнего спана в тексте
var spanEdgeEng = parseInt($('#js_span_edge_eng').val());                                                                                                   //крайний правый спан (здесь только спаны с одиночными словами)
var startSpanEng = 0, endSpanEng = 10000;                                                                                 //номера крайних выделенных спанов

for (k=0; k<50; k++){
    countsEng[k] = parseInt($('#js_count_eng_'+k).val());
}

/** Добавление варианта */
$('#type_question_add').on('click','.eng-add-var-3', function(){
    var idButton = $(this).attr('id');
    var numButton;
    numButton = idButton.substring(19);
    //alert(numButton);
    $('#eng-column-'+numButton).append('\
                <div class="form-group">\
                    <textarea  name="eng-variants-'+numButton+'[]"  class="form-control textarea3" rows="1" placeholder="" required></textarea>\
                    <label for="textarea3">Variant ' + countsEng[numButton] + '</label>\
                </div>\
                ');
    countsEng[numButton]++;
});

/** Удаление последнего варианта */
$('#type_question_add').on('click','.eng-del-var-3',function(){
    var idButton = $(this).attr('id');
    var numButton;
    numButton = idButton.substring(19);
    if (countsEng[numButton] > 2){
        $('#eng-column-'+numButton).children().last().remove();
        countsEng[numButton]--;
    }
});

/** по номеру блока удаляет необходимый блок и сдвигает все индексы у нижестоящих блоков */
function removeBlockEng(blockNum){
    var j;
    $('#eng-card-body-'+blockNum).remove();                                                                  //удаляем этот блок
    j = blockNum + 1;
    for (j; j<wordNumberEng; j++){                                                                         //передвигаем индексы всех нижестоящих элементов на -1
        $('#eng-card-body-'+j).attr('id', 'eng-card-body-'+(j-1));
        $('#eng-column-'+j+' textarea').attr('name', 'eng-variants-'+(j-1)+'[]');
        $('#eng-column-'+j).attr('id', 'eng-column-'+(j-1));
        $('#eng-add-del-buttons-'+j).attr('id', 'eng-add-del-buttons-'+(j-1));
        $('#eng-var-add-button-'+j).attr('id', 'eng-var-add-button-'+(j-1));
        $('#eng-var-del-button-'+j).attr('id', 'eng-var-del-button-'+(j-1));
    }
    wordNumberEng--;
}

/** Добавляет блок. На вход принимает строку вида span-x, где x - номер спана в тексте и текст спана для автозаполнения им первого варианта блока */
function addBlockEng(numSpan, firstVar){
    $('#eng-word-variants').append('\
                <div class="eng-card-body '+numSpan+'" id="eng-card-body-'+wordNumberEng+'">\
                    <div class="col-md-12 col-sm-6 var-column" id="eng-column-'+wordNumberEng+'">\
                     <div class="form-group">\
                            <textarea  name="eng-variants-'+wordNumberEng+'[]"  class="form-control textarea3" rows="1" value="0.5" required>0.5</textarea>\
                            <label for="textarea3">Difficulty</label>\
                        </div>\
                        <div class="form-group">\
                            <textarea  name="eng-variants-'+wordNumberEng+'[]"  class="form-control textarea3 text-answer" rows="1" value="'+firstVar+'">'+firstVar+'</textarea>\
                            <label for="textarea3">Variant 1</label>\
                        </div>\
                        <div class="form-group">\
                            <textarea  name="eng-variants-'+wordNumberEng+'[]"  class="form-control textarea3" rows="1" placeholder="" required></textarea>\
                            <label for="textarea3">Variant 2</label>\
                        </div>\
                        <div class="form-group">\
                             <textarea  name="eng-variants-'+wordNumberEng+'[]"  class="form-control textarea3" rows="1" placeholder="" required></textarea>\
                            <label for="textarea3">Variant 3</label>\
                        </div>\
                        <div class="form-group">\
                            <textarea  name="eng-variants-'+wordNumberEng+'[]"  class="form-control textarea3" rows="1" placeholder="" required></textarea>\
                            <label for="textarea3">Variant 4</label>\
                        </div>\
                    </div>\
                    <div class="col-md-offset-10 col-md-6 col-sm-6" id="eng-add-del-buttons-'+wordNumberEng+'">\
                        <button type="button" class="btn ink-reaction btn-floating-action btn-success eng-add-var-3" id="eng-var-add-button-'+wordNumberEng+'"><b>+</b>   </button>\
                        <button type="button" class="btn ink-reaction btn-floating-action btn-danger eng-del-var-3" id="eng-var-del-button-'+wordNumberEng+'"><b>-</b></button>\
                    </div>\
                </div>\
                ');
    wordNumberEng++;
}

/** проверка, не принадлежит ли слово другой области (true - belong, false - doesn't belong) */
function belongSelectionEng(numSpan) {
    if ($('#eng-text-part-'+numSpan).hasClass('eng-inside') == true){
        alert ('Your selection belongs to another selection!');
        return true;
    }
    else {
        return false;
    }
}

/** Работа с текстовым полем для занесения текстового вопроса */
$('#type_question_add').on('click','#eng-finish-edit', function(){
    var text;
    var text_part = "";
    var i,q;
    var j=1;
    var flag = true;
    text = $('#eng-edit-text').val();
    var pattern = /\s|,|\.|\?|!|-|:|"/;

    //каждое слово запихиваем в спан
    $('#eng-general-text').attr('style', 'display:block;');
    for (i=0; i<text.length; i++){
        if (pattern.test(text[i]) == false){
            text_part += text[i];
        }
        else {
            if (text_part != ''){
                $('#eng-general-text').append('<span id="eng-text-part-'+j+'" class="eng-text-part" style="cursor:pointer">'+text_part+'</span><span>'+text[i]+'</span>');
                j++;
                text_part = "";
            }
            else {
                $('#eng-general-text').append('<span>'+text[i]+'</span>');
            }
        }
    }
    spanLastEng = j-1;                                                                                                 //запоминаем номер последнего спана
    spanEdgeEng = j-1;                                                                                                 //запоминаем номер крайнего спана (в данном случае совпадают)

    $('#eng-edit-text').css({'display' : 'none'});                                                                      //прячем поле формы с текстом вопроса
    $('#eng-finish-edit').attr('id', 'eng-edit');                                                                           //меняем статус кнопки
    $('#eng-button-title').text('Back to editing');                                                          //меняем текст кнопки

    //работа с блоками, если они уже были созданы
    for (i=1; i<wordNumberEng; i++){                                                                                  //идем по всем уже выбранным словам (блокам)
        for (q=1; q<j; q++){                                                                                       //для каждого выбранного слова идем по всем словам в новом тексте
            if ($('#eng-card-body-'+i+' textarea').eq(1).text() == $('#eng-text-part-'+q).text()){                         //если слова совпали
                if ($('#eng-card-body-'+i).attr('class').substring(19) != q){                                          //если старый номер слова в тексте больше не совпадает с новым
                    $('#eng-card-body-'+i).attr('class', 'eng-card-body eng-span-'+q);                                         //присваиваем блоку класс с актуальным номером спана
                    flag = true;
                    $('#eng-text-part-'+q).attr('style', 'cursor:pointer; background-color:lightgreen;');
                    break;
                }
                $('#eng-text-part-'+q).attr('style', 'cursor:pointer; background-color:lightgreen;');                  //при совпадении слова в новом тексте это слово выделяем цветом
            }
            else flag = false;
        }
        if (flag == false){           //если для предыдущего слово не было найдено в новом тексте
            $('#eng-card-body-'+i+' textarea').eq(1).text($('#eng-text-part-'+$('#eng-card-body-'+i).attr('class').substring(19)).text());       //пишем в первый вариант текущего блока слово с номером, соответсвующим старому номеру в тексте
            $('#eng-text-part-'+$('#eng-card-body-'+i).attr('class').substring(19)).attr('style', 'cursor:pointer; background-color:lightgreen;');  //задаем цвет слову в новом тексте
            flag = true;
        }
    }
});

/** возвращение в режим набора текста вопроса */
$('#type_question_add').on('click','#eng-edit', function(){
    $('#eng-button-title').text('Finish editing text');                                                     //меняем текст кнопки
    $('#eng-edit-text').css({'display' : 'block'});                                                                     //вновь показываем поле формы с текстом вопроса
    $('#eng-general-text').attr('style', 'display:none;');                                                              //прячем набранный текст
    $('#eng-edit').attr('id', 'eng-finish-edit');                                                                           //меняем статус кнопки

    $('#eng-general-text').children().remove();                                                                         //очищаем поле с набранным текстом для нового занесения
    $('#eng-general-text').text('');
});

/** работа со спанами при кликании на них */
$('#type_question_add').on('click','.eng-text-part', function(){
    if ($('#eng-union').text() == 'Go to union mode'){                                                  //если не включен режим объединения в компакты
        var i, j, p, index;
        var pattern = /eng-text-part-/;
        if ($(this).hasClass('eng-inside') == false){                                                                   //если слово не находится в области
            if ($(this).css('background-color') == 'rgb(144, 238, 144)'){                                           //слово уже выделено (выделено светло-зеленым)
                $(this).attr('style', 'cursor:pointer');
                for (i=1; i<wordNumberEng; i++){
                    if ($('#eng-card-body-'+i+' textarea').eq(1).text() == $(this).text()){                             //ищем нужный блок
                        removeBlockEng(i);
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
                var numSpan = 'eng-span-'+idSpan.substring(index);
                addBlockEng(numSpan, $(this).text());
            }
        }
        else{                                                                                                       //если слово принадлежит какой-либо области
            $(this).parent().attr('style', 'cursor:pointer');                                                       //убираем его цвет
            $(this).parent().children().attr('style', 'cursor:pointer');                                            //убираем цвет всех элементов области
            var parentId = $(this).parent().attr('id');                                                             //id спана области, куда тыкнули
            var removableBlock = $('.eng-span-'+parentId.substring(14)).attr('id').substring(14);
            removeBlockEng(parseInt(removableBlock, 10));                                                              //удаляем блок
            $('#'+parentId+' .eng-text-part').removeClass('eng-inside');                                                    //убираем классы принадлжености области
            $('#'+parentId+' .eng-text-part').addClass('eng-temp');                                                         //создаем фиктивный временный класс
            $('.eng-temp').unwrap();                                                                                    //удаляем спан, охватывающий область
            $('.eng-text-part').removeClass('eng-temp');                                                                    //удаляем временный класс
            spanLastEng--;                                                                                             //уменньшаем число спанов

        }
    }

    if ($('#eng-union').text() == 'Merge'){                                                                        //если включен режим объединения в компакты
        var tempSpan = parseInt($(this).attr('id').substring(14),10);                                               //текущий выбранный спан
        var temp;
        if (startSpanEng == tempSpan) return;                                                                          //если выбранный спан совпадает с начальным, то ничего не выпоняем
        var q,l;
        if (startSpanEng == 0){                                                                                        //если еще не было выделено ни одного элемента
            if (belongSelectionEng(startSpanEng)) return;
            startSpanEng = parseInt($(this).attr('id').substring(14),10);
            $(this).css({'background-color':'darkorange'});
            //$(this).addClass('wrapped');
            return;
        }
        if (startSpanEng != 0 ){                                                                                       //когда уже был выделен стартовый элемент
            if (startSpanEng <= tempSpan){
                for (q=startSpanEng; q<=tempSpan; q++){
                    if (belongSelectionEng(q)) return;                                                                 //проверяем, не будет ли новая область пересекаться с существующей
                }
            }
            else {
                for (q=tempSpan; q<=startSpanEng; q++){
                    if (belongSelectionEng(q)) return;
                }
            }
            $('.eng-wrapped').unwrap();                                                                                 //убираем область
            $('#eng-general-text span').removeClass('eng-wrapped');                                                         //а вместе с ней и классы
            endSpanEng = tempSpan;                                                                                     //выбранный элемент становится новой крайней границей
            if (startSpanEng <= endSpanEng){                                                                              //определяем начало и конец области
                for (q=startSpanEng; q<=endSpanEng; q++){
                    if ($('#eng-text-part-'+q).hasClass('eng-wrapped') == false) {
                        $('#eng-text-part-'+q).addClass('eng-wrapped');
                        if (q != endSpanEng){
                            temp =  $('#eng-text-part-'+q).next();
                            // заглушка - можно написать проверку, чтобы проверялось не только два специальных символа, а до конца выделения
                            while (temp.hasClass('eng-text-part') == false){
                                //alert(temp.text());
                                temp.addClass('eng-wrapped');
                                temp = temp.next();
                            }
                        }
                    }
                    else{

                    }
                }
            }
            else {
                for (q=endSpanEng; q<=startSpanEng; q++){
                    if ($('#eng-text-part-'+q).hasClass('eng-wrapped') == false) {
                        $('#eng-text-part-'+q).addClass('eng-wrapped');
                        if (q != startSpanEng){
                            $('#eng-text-part-'+q).next().addClass('eng-wrapped');
                            if ($('#eng-text-part-'+q).next().next().hasClass('eng-text-part') != true){
                                $('#eng-text-part-'+q).next().next().addClass('eng-wrapped');
                            }
                        }
                    }
                }
            }
            $('.eng-wrapped').wrapAll('<span id="eng-text-part-'+(spanLastEng+1)+'"></span>');                                 //обособляем нашу область новым спаном
        }
    }
});

/** обработка внесения изменений в первый вариант(ответ) блока */
$('#type_question_add').on('blur', '.eng-text-answer', function(){
    var prevText = $(this).text();                                                                                  //текст до изменения
    var prevSpan =  $(this).parents('.eng-card-body').attr('class').substring(19);                                      //номер спана, совпадавшего с полем до изменения
    var flag = false;
    var i;
    if ($(this).val() == prevText) return;
    for (i=1; i<=spanLastEng; i++){                                                                                    //идем по всем спанам текста
        if ($(this).val() == $('#eng-text-part-'+i).text() &&  $('#eng-text-part-'+i).attr('style') == 'cursor:pointer'){  //если новое введенное слово существует в спанах и еще не задействовано в других блоках
            $(this).parents('.eng-card-body').attr('class', 'eng-card-body eng-span-'+i);                                       //присваиаем блоку номер этого спана
            $('#eng-text-part-'+i).attr('style', 'cursor:pointer; background-color:lightgreen;');                       //присваиваем этому спану цвет
            $('#eng-text-part-'+prevSpan).attr('style', 'cursor:pointer; ');                                            //убираем цвет у старого совпадавшего спана
            $(this).text($(this).val());                                                                            //присваиваем новое значение полю
            flag = true;
            break;
        }
    }
    if (flag == false){                                                                                             //если новое слово в поле не совпадает ни с одним спаном в тексте
        alert('Error! This word is absent in text or is already in use!');
        $(this).val(prevText);
    }
});

/** режим объединения слов в компакты */
$('#type_question_add').on('click', '#eng-union', function(){
    if ($('#eng-edit').attr('id') == 'eng-edit'){                                                                           //если включен режим выделения слов
        $('#eng-edit').attr('disabled', 'disabled');                                                                    //отключаем кнопку "Венуться к редактированию"
        if ($(this).text() == 'Go to union mode'){                                                  //если сейчас режим объединения отключен
            $(this).text('Merge');                                                                             //включаем режим объединения слов в компакты
            $('#eng-cancel-selection').attr('style', 'display: inline');                                                //отображаем кнопку сброса выделения
            var i;
            for (i=1; i<=spanLastEng; i++){
                //alert($('#text-part-'+i).css('background-color'));
                if ($('#eng-text-part-'+i).css('background-color') == 'rgb(144, 238, 144)'){                            //проверка на светло-зеленый цвет
                    $('#eng-text-part-'+i).css({'color':'#cc0000'});                                                    //выделяем выбранные ранее слова красным цветом
                    $('#eng-text-part-'+i).css({'background-color':''});                                                //убираем фоновое выделение
                }
            }
            return;
        }
        if ($(this).text() == 'Merge'){                                                                        //действия при объединении
            $('#eng-edit').removeAttr('disabled');                                                                      //включаем кнопку "Венуться к редактированию"
            $(this).text('Go to union mode');                                                       //меняем текст кнопки
            $('#eng-cancel-selection').attr('style', 'display: none');                                                  //скрываем кнопку сброса выделения
            var j,k, removableBlock;
            for (j=1; j<=spanLastEng; j++){                                                                            //идем по всем спанам тексте
                if ($('#eng-text-part-'+j).css('color') == 'rgb(204, 0, 0)'){                                           //красный цвет слов (слова, которые были выделены в блоки)
                    $('#eng-text-part-'+j).css({'color':'', 'background-color':'lightgreen'});                          //убираем цвет букв
                    if ($('#eng-text-part-'+j).hasClass('eng-wrapped') == true){                                            //если слово оказалось внутри выделенной области
                        for (k=1; k<wordNumberEng; k++){
                            if ($('.eng-card-body').hasClass('eng-span-'+j)){                                                //нужно найти блок, у которого в нлассе span-x с нужным номером слова (i), взять id, а точнее номер card-body-y, и функцией удалить блок
                                removableBlock = $('.eng-span-'+j).attr('id').substring(14);
                                removeBlockEng(parseInt(removableBlock, 10));
                            }
                        }
                    }
                    else{                                                                                           //если красное слово вне выделенной области
                        $('#eng-text-part-'+j).css({'background-color':'lightgreen'});                                  //меняем фоновое выделение на обычный зеленый
                    }
                }
            }
            if (endSpanEng == 10000){                                                                                  //если в области одно слово
                if ($('#eng-text-part-'+startSpanEng).css('color') != 'rgb(204, 0, 0)'){                                   //если слово не красное (не входит в блок)
                    $('#eng-text-part-'+startSpanEng).css({'background-color':'', 'cursor':'pointer'});                    //не подсвечиваем его
                }
                startSpanEng = 0;                                                                                      //сбрасываем границы выделенной области
                endSpanEng = 10000;
                return;                                                                                             //ничего не добавляем
            }
            $('#eng-general-text span').removeClass('eng-wrapped');                                                         //убираем класс для сброса оранжевого цвета
            $('#eng-text-part-'+startSpanEng).css({'background-color':'lightgreen'});                                      //отдельно подсвечиваем начальный элемент области
            $('#eng-text-part-'+(spanLastEng+1)).css({'background-color':'lightgreen', 'cursor':'pointer'});               //выделяем область зеденым цветом + курсор
            $('#eng-text-part-'+(spanLastEng+1)+' .eng-text-part').addClass('eng-inside');                                         //добавляем всем одиночным словам внутри области класс, символизирующий, что они находятся внутри спана
            addBlockEng('eng-span-'+(spanLastEng+1), $('#eng-text-part-'+(spanLastEng+1)).text());                                   //добавляем блок с областью
            spanLastEng++;                                                                                             //инкрементируем число спанов
        }
        startSpanEng = 0;                                                                                              //сбрасываем границы выделенной области
        endSpanEng = 10000;
    }
});

/** сбросить выделение */
$('#type_question_add').on('click', '#eng-cancel-selection', function(){
    $('.eng-wrapped').unwrap();                                                                                        //убираем область
    $('#eng-general-text span').removeClass('eng-wrapped');                                                                //а вместе с ней и классы
    $('#eng-text-part-'+startSpanEng).css({'background-color':''});
    startSpanEng = 0;
    endSpanEng = 10000;
});
