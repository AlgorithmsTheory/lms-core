/**
 * Created by Станислав on 28.07.15.
 */


//var count_yesno = 1; //Счетчик числа вариантов для Да/Нет


var count = 5;                                                                                                      //счетчик числа вариантов
var margin = 220;                                                                                                   //расстояние верхней границы кнопок доавления и удаления
var margins = [];                                                                                                   //расстояние верхней границы кнопок добавления и удаления для текстового вопроса
for (k=0; k<50; k++){
    margins[k] = 294;
}
var counts = [];                                                                                                    //счетчики числа вариантов для текстового вопроса
for (k=0; k<50; k++){
    counts[k] = 5;
}
var word_number = 1;                                                                                                //номер вставляемого слова для текстового вопроса (всегда на 1 больше, чем блоков на самом деле)
var spanLast = 0;                                                                                                   //номер последнего спана в тексте
var spanEdge = 0;                                                                                                   //крайний правый спан (здесь только спаны с одиночными словами)
var startSpan = 0, endSpan = 10000;                                                                                 //номера крайних выделенных спанов

//по номеру блока удаляет необходимый блок и сдвигает все индексы у нижестоящих блоков
function removeBlock(blockNum){
    var j;
    $('#card-body-'+blockNum).remove();                                                                             //удаляем этот блок
    for (j=blockNum+1; j<word_number; j++){                                                                         //передвигаем индексы всех нижестоящих элементов на -1
        $('#card-body-'+j).attr('id', 'card-body-'+(j-1));
        $('#column-'+j+' textarea').attr('name', 'variants-'+(j-1)+'[]');
        $('#column-'+j).attr('id', 'column-'+(j-1));
        $('#add-del-buttons-'+j).attr('id', 'add-del-buttons-'+(j-1));
        $('#var-add-button-'+j).attr('id', 'var-add-button-'+(j-1));
        $('#var-del-button-'+j).attr('id', 'var-del-button-'+(j-1));
    }
    word_number--;
}

//Добавляет блок. На вход принимает строку вида span-x, где x - номер спана в тексте и текст спана для автозаполнения им первого варианта блока
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

//проверка, не принадлежит ли слово другой области (true - belong, false - doesn't belong)
function belongSelection(numSpan) {
    if ($('#text-part-'+numSpan).hasClass('inside') == true){
        alert ('Недопустимо соприкосновение с другой выделенной областью!');
        return true;
    }
    else {
        return false;
    }
}

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
                <textarea  name="variants[]"  class="form-control textarea3" rows="1" placeholder="" required></textarea>\
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
    count++;
});

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

$('#type_question_add').on('click','#add-var-4', function(){            //Я добавил
    $('#variants').append('\
            <div class="form-group">\
                <textarea  name="variants[]"  class="form-control textarea3" rows="1" placeholder="" required></textarea>\
                <label for="textarea3">Утверждение ' + (count-3) + '</label>\
            </div>\
            ');
    $('#answers').append('\
            <div class="checkbox checkbox-styled" style="margin-top:49px">\
                <label>\
                    <input type="checkbox" name="answers[]" value="'+ (count-3) + '">\
                    <span></span>\
                </label>\
            </div>\
            ');
    margin += 74;
    $('#add-del-buttons').attr('style','margin-top:'+(margin-120)+'px');
    count++;
});

$('#type_question_add').on('click','#build-table', function(){ //построение таблицы
    var tr_number=document.getElementById("table-tr").value; //были изменения
    var td_number=document.getElementById("table-td").value;
    var cols = parseInt(tr_number);
    var rows = parseInt(td_number);
    var but = document.getElementById('build-table');
    but.disabled = true;

    var x = document.createElement("TABLE");
    x.setAttribute("id", "myTable");
    x.setAttribute("class" , "table table-bordered");
    document.getElementById("table-place").appendChild(x);
    var b = document.createElement("TBODY");

    b.setAttribute("id", "myBody");
    document.getElementById("myTable").appendChild(b);

    var y = document.createElement("TR");
    y.setAttribute("id", "0");
    document.getElementById("myBody").appendChild(y);
    var z = document.createElement("TD");
    var t = document.createTextNode("#");
    z.appendChild(t);
    document.getElementById("0").appendChild(z);
    for (k = 1; k <= rows; k++) {
        z = document.createElement("TD");
        t = document.createElement("INPUT");
        t.setAttribute("type", "text");
        t.setAttribute("style", "width: 80px;");
        t.setAttribute("placeholder", "Свойство");
        t.setAttribute("name", "variants[]");
        z.appendChild(t);
        document.getElementById("0").appendChild(z);
    }
    for (i = 1; i <= cols; i++) {
        y = document.createElement("TR");
        y.setAttribute("id", i);
        document.getElementById("myBody").appendChild(y);
        z = document.createElement("TD");
        t = document.createElement("INPUT");
        t.setAttribute("type", "text");
        t.setAttribute("placeholder", "Объект");
        t.setAttribute("name", "title[]");
        t.setAttribute("style", "width: 80px;");
        z.appendChild(t);
        document.getElementById(i).appendChild(z);
        for (k = 1; k <= rows; k++) {
            z = document.createElement("TD");
            t = document.createElement("INPUT");
            t.setAttribute("type", "checkbox");
            t.setAttribute("name", "answer[]");
            t.setAttribute("value", ((i-1)*rows + k));
            z.appendChild(t);
            document.getElementById(i).appendChild(z);
        }
    }
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

$('#type_question_add').on('click','#del-var-4',function(){                 //Я добавил
    if (count > 5){
        lastelem = $('#variants').children().last().remove();
        $('.checkbox-styled').last().remove();
        margin -= 74;
        $('#add-del-buttons').attr('style','margin-top:'+(margin-120)+'px');
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

//Работа с текстовым полем для занесения текстового вопроса
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

//возвращение в режим набора текста вопроса
$('#type_question_add').on('click','#edit', function(){
    $('#button-title').text('Завершить редактирование текста');                                                     //меняем текст кнопки
    $('#edit-text').css({'display' : 'block'});                                                                     //вновь показываем поле формы с текстом вопроса
    $('#general-text').attr('style', 'display:none;');                                                              //прячем набранный текст
    $('#edit').attr('id', 'finish-edit');                                                                           //меняем статус кнопки

    $('#general-text').children().remove();                                                                         //очищаем поле с набранным текстом для нового занесения
    $('#general-text').text('');
});

//работа со спанами при кликании на них
$('#type_question_add').on('click','.text-part', function(){
    if ($('#union').text() == 'Перейти в режим объединения слов'){                                                  //если не включен режим объединения в компакты
        var i, j, p, index;
        var pattern = /text-part-/;
        if ($(this).hasClass('inside') == false){                                                                   //если слово не находится в области
            if ($(this).css('background-color') == 'rgb(144, 238, 144)'){                                           //слово уже выделено (выделено светло-зеленым)
                $(this).css({'background-color':''});
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
                    //alert(tempStr);
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
            $(this).parent().css({'background-color':''});                                                          //убираем его цвет
            $(this).parent().children().css({'background-color':''});                                               //убираем цвет всех элементов области
            var parentId = $(this).parent().attr('id');                                                             //id спана области, куда тыкнули
            removeBlock($('.span-'+parentId.substring(10)).attr('id').substring(10));                               //удаляем блок
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

//обработка внесения изменений в первый вариант(ответ) блока
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

//режим объединения слов в компакты
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
            var j,k;
            for (j=1; j<=spanLast; j++){                                                                            //идем по всем спанам тексте
                if ($('#text-part-'+j).css('color') == 'rgb(204, 0, 0)'){                                           //красный цвет слов (слова, которые были выделены в блоки)
                    $('#text-part-'+j).css({'color':'', 'background-color':'lightgreen'});                          //убираем цвет букв
                    if ($('#text-part-'+j).hasClass('wrapped') == true){                                            //если слово оказалось внутри выделенной области
                        for (k=1; k<word_number; k++){
                            if ($('.card-body').hasClass('span-'+j)){                                                //нужно найти блок, у которого в нлассе span-x с нужным номером слова (i), взять id, а точнее номер card-body-y, и функцией удалить блок
                                removeBlock($('.span-'+j).attr('id').substring(10));
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

//сбросить выделение
$('#type_question_add').on('click', '#cancel-selection', function(){
    $('.wrapped').unwrap();                                                                                        //убираем область
    $('#general-text span').removeClass('wrapped');                                                                //а вместе с ней и классы
    $('#text-part-'+startSpan).css({'background-color':''});
    startSpan = 0;
    endSpan = 10000;
});

//заполнение preview в зависимсти от типа вопроса
$('#type_question_add').on('click', '#preview-btn', function(){
    $('#preview-text').text($('#textarea1').val());                                                                  //вписываем текст вопроса
    var i;
    var str = '';
    var type = $('#select-type').val();
    switch (type) {                                                                                                  //для каждого типа вопроса заполняем варианты
        case 'Выбор одного из списка':
            $('.textarea3').each(function(){
                $('#preview-container').append('<input type="radio" value="'+$(this).val()+'"> '+$(this).val()+'<br>');
            });
            break;
        case 'Выбор нескольких из списка':
            $('.textarea3').each(function(){
                $('#preview-container').append('<input type="checkbox" value="'+$(this).val()+'"> '+$(this).val()+'<br>');
            });
            break;
        case 'Текстовый вопрос':
            //$('#preview-container').append($('#general-text').text());
            $('#general-text').clone().appendTo('#preview-container');                                               //клонируем в превью весь текст
            for (i=1; i<word_number; i++){                                                                           //идем по всем пропущенным словам
                str = '<span><select>\
                       <option disabled selected>Вставьте пропущенное слово</option>';
                $("#card-body-"+i+" textarea").each(function(){                                                      //составляем строку с вариантами для каждого пропущенного слова
                    if ($(this).next().text() != 'Стоимость'){
                        str += '<option value="'+$(this).val()+'">'+$(this).val()+'</option>';
                    }
                });
                str +=  '</select></span>';
                $('#preview-container #text-part-'+$('#card-body-'+i).attr('class').substring(15)).html(str);        //вставляем строку вместо пропущенного слова
            }
            $('#preview-container #general-text').children().removeAttr('id');                                       //удаляем ненужные атрибуты
            $('#preview-container #general-text').children().removeAttr('style');
            $('#preview-container #general-text').children().removeAttr('class');
            $('#preview-container #general-text').removeAttr('class');
            $('#preview-container #general-text').removeAttr('id');
            break;
        case 'Да/Нет':
            var trig_show = true;
            $('.textarea3').each(function(){
                if(trig_show){
                    $('#preview-container').append('<table class="table table-striped" id="prw-table"><tbody><tr><td>#</td><td>Верно</td><td>Неверно</td></tr></tbody></table>');
                }
                $('#prw-table').append('<tr><td>'+$(this).val()+'</td><td><input type="checkbox"></td><td><input type="checkbox"></td>');
                trig_show = false;
            });
            break;
    }
});

$('#type_question_add').on('click', '#close-btn', function(){
    $('#preview-container').empty();
});

//действия при сабмите формы
$('#type_question_add').on('click', '.submit-question', function(){
    if ($('#select-section').val() == '$nbsp'){                                                                     //если не выбрали раздел
        alert('Вы не выбрали раздел и тему!');
        return false;
    }
    if ($('#select-theme').val() == '$nbsp'){                                                                       //если не выбрали тему
        alert('Вы не выбрали тему!');
        return false;
    }
    if ($('#select-type').val() == 'Текстовый вопрос'){
        if (word_number == 1){                                                                                          //если не выделили ни одного слова
            alert('Вы не выделили ни одного слова!');
            return false;
        }
        $('#number-of-blocks').val(word_number-1);                                                                      //заносим в форму информацию о количестве пропущенных слов
        var i;
        var sumCost = 0;
        var costStting = '';
        for (i=1; i<word_number; i++){
            $('#column-'+i+' textarea').first().val($('#column-'+i+' textarea').first().val().replace(/,/g, '.'));  //меняем в стоимости запятую на точку для правильной обработки на сервере
            sumCost += Number($('#column-'+i+' textarea').first().val());                                           //считаем сумму всех стоимостей
            costStting += $('#column-'+i+' textarea').eq(1).val()+': '+$('#column-'+i+' textarea').eq(0).val()+'\n';//создаем строку вида "слово: стоимость"
        }
        //alert($('#edit-text').val());
        if (sumCost.toFixed(2) != '1.00'){                                                                          //не сабмитим, если стоимости не равны 1 в сумме
            alert('Сумма стоимостей должна быть равна единице!\n' + costStting);
            return false;
        }
        for (i=1; i<word_number; i++){
            $('#text-part-'+$('#card-body-'+i).attr('class').substring(15)).text($('#text-part-'+$('#card-body-'+i).attr('class').substring(15)).text().replace($('#text-part-'+$('#card-body-'+i).attr('class').substring(15)).text(), $('#text-part-'+$('#card-body-'+i).attr('class').substring(15)).text()+'|'+i));     //ко всем выделенным словам добавляем маркер вида |x, где x - номер пропущенного слова
            $('#edit-text').val($('#general-text').text());                                                         //записываем измененный текст в поле формы с текстом для отправки на сервер
            $('#column-'+i+' textarea').eq(1).val($('#column-'+i+' textarea').eq(1).val()+'|'+i);                   //верный вариант ответа также заменяем на него же с маркером
        }
    }
});


