
//Возвращает название div контейнера для типов карт (Лекций или семинаров)
function getConteinerTypeCard(typeCard) {
    if (typeCard == 'lecture') {
        return 'lectures';

    }
    if (typeCard == 'seminar') {
        return 'seminars';
    }
    if (typeCard == 'control_work') {
        return 'control_works';
    }
}

//Стиль для карты декции сема или контр. меропр.
function getStyleCard(typeCard) {
    if (typeCard == 'lecture') {
        return 'info';

    }
    if (typeCard == 'seminar') {
        return 'warning';
    }
    if (typeCard == 'control_work') {
        return 'danger';
    }
}

//
function getDeleteMsg(typeCard) {
    if (typeCard == 'lecture') {
        return 'Удалить лекцию ?';

    }
    if (typeCard == 'seminar') {
        return 'Удалить семинар ?';
    }
    if (typeCard == 'control_work') {
        return 'Удалить контрольное мероприятие';
    }
}


// для генерирования id созданых на странице карт
function return1IfEmpty(elem) {
    if($.isEmptyObject(elem)) {
        return 1;
    } else {
        return parseInt(elem) + 1;
    }
}

//Преобразовывает сериализованную форму в json
function getFormData($form){
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}

//возвращает представление для добавление раздела
$(document).on('click', '.add_lecture_or_sem_or_CW', function () {

    var typeCard = $(this).attr('data-type-card');

    var currentSection = $(this).closest('.section');
   //Номер последней карты в вообще
   //  var numberLastCard = currentSection.find('.' + typeCard).filter( ':last' )
   //      .find('input[name="'+ typeCard +'_plan_num"]').val();
    var numberLastCard = $('.' + typeCard).size().toString();

    //Номер для новой карты
    var numberNewCard = return1IfEmpty(numberLastCard);

    //генерируемое id раздела для поиска через js
    var idSectionForFindJs = currentSection.attr('id').match(/\d+/);

    // id для добавляемой карты
    //var idLastCard = $('.'+typeCard).filter( ':last' ).attr('id');
    var idLastCard = currentSection.find('.'+typeCard).filter( ':last' ).attr('id');
    var idNewCardForFindJs;

    idNewCardForFindJs = return1IfEmpty(idLastCard);

    $.ajax({
        cache: false,
        type: 'GET',
        url:   '/course_plan/section/get_add_lec_sem_cw',
        data: { id_new_card_for_find_js: idNewCardForFindJs,
                id_section_for_find_js: idSectionForFindJs,
                type_card: typeCard,
                number_new_card: numberNewCard},
        success: function(data){
            var thisSection = $('#section'+data.idSectionForFindJs);
            var typeConteinerCards = getConteinerTypeCard(data.typeCard);
            //Вставка формы добавления лекции или сема
            thisSection.find('.'+typeConteinerCards).append(data.view);


        }
    });
});


//Сохранение добаленного раздела
$(document).on('click', '.store_lec_sem_cw', function (event) {

    // var token = $('meta[name="csrf-token"]').attr('content');
    var typeCard = $(this).attr('data-btn-type-card');
    var currentSection = $(this).closest('.section');
    var idSectionDB = currentSection.attr('data-id-DB');
    var idSectionForFindJs = currentSection.attr('id').match(/\d+/).toString();
    var idCardForFindJs = $(this).closest('.'+typeCard).attr('id');
   // var thisForm = JSON.stringify( $(this).closest('form').serializeArray() );
    //var thisForm = getFormData($(this).closest('form'));//Самый лучший вар возможно
    var thisForm = $(this).closest('form').serialize();
    $.ajax({
        cache: false,
        type: 'POST',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf-token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
        url:   '/course_plan/section/lec_sem_cw/store',
        data:  { form: thisForm,
            id_section_DB: idSectionDB,
            id_section_for_find_js: idSectionForFindJs,
            id_card_for_find_js: idCardForFindJs,
            type_card: typeCard
        },
        success: function(data){
            console.log(data);
            var currentSection = $('#section'+data.id_section_for_find_js);
            var typeConteinerCards = getConteinerTypeCard(data.type_card);
            var currentCard = currentSection.find('.'+typeConteinerCards).find('#'+data.id_card_for_find_js);
            if($.isEmptyObject(data.error)){
                //Замена формы добавления на форму с readonly
                currentCard.replaceWith(data.view);

                // //Прибавляем +1 к номерам лекций, семам, КМ после добавленного
                // var allCards = ('.'+data.type_card);
                // allCards.each(function( elem ) {
                //     var inputNumberCard = $( this ).find('input[name="'+ typeCard +'_plan_num"]');
                //     if(inputNumberCard.val() >= data.new_card_num){
                //         inputNumberCard.val(inputNumberCard.val() + 1);
                //     }
                // });
            }else{
                //добавление в html сообщений об ошибках
                var divError = currentCard.find('.print-error-msg').filter( ':first' );
                divError.find("ul").html('');
                divError.css('display','block');
                $.each( data.error, function( key, value ) {
                    divError.find("ul").append('<li>'+value+'</li>');
                });
            }
        }
    });

});

//Изменяет view_or_update_item для редактирования лекции, сем или контр мероприятия
$(document).on('click', '.activate_edit_lec_sem_cw', function () {

    var thisCard = $(this).closest('.card');
    var typeCard = thisCard.attr('data-type-card');
    //сркрытие иконки редактировать
    $(this).hide();

    //выключение readonly для полей

    thisCard.find('input[name="'+typeCard+'_plan_name"]').filter( ':first' ).removeAttr("readonly");
    thisCard.find('input[name="'+typeCard+'_plan_desc"]').filter( ':first' ).removeAttr("readonly");
    thisCard.find('input[name="'+typeCard+'_plan_num"]').filter( ':first' ).removeAttr("readonly");
    //toDo для типа контрольное мероприятия добавить поле с  привязанными тестами
    //вставка кнопки "Обновить информ. о разделе"
    var htmlUpdateBatton = '<button type="button" class="ink-reaction btn btn-'+getStyleCard(typeCard)+' update_lec_sem_cw">Обновить</button>';
    thisCard.find('.update_button_place').filter( ':first' ).html(htmlUpdateBatton);
});

//Обновление лекции семинара или контр мероприятия
$(document).on('click', '.update_lec_sem_cw', function () {

    var thisCard = $(this).closest('.card');
    var typeCard = thisCard.attr('data-type-card');
    var currentSection = $(this).closest('.section');
    var idSectionForFindJs = currentSection.attr('id').match(/\d+/).toString();
    var idCardForFindJs = thisCard.attr('id');
    var thisForm = $(this).closest('form').serialize();

    $.ajax({
        type: 'PATCH',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf-token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url:   '/course_plan/section/lec_sem_cw/update',
        data:  { form: thisForm,
            id_section_for_find_js: idSectionForFindJs,
            id_card_for_find_js: idCardForFindJs,
            type_card: typeCard
        },
        success: function(data){
            console.log(data);
            var currentSection = $('#section'+data.id_section_for_find_js);
            var currentCard = currentSection.find('.'+getConteinerTypeCard(data.type_card)).find('#'+data.id_card_for_find_js);

            if($.isEmptyObject(data.error)){

                //выключение readonly для полей
                currentCard.find('input[name="'+typeCard+'_plan_name"]').filter( ':first' ).attr('readonly', true);
                currentCard.find('input[name="'+typeCard+'_plan_desc"]').filter( ':first' ).attr('readonly', true);
                currentCard.find('input[name="'+typeCard+'_plan_num"]').filter( ':first' ).prop( "readonly", true);
                //toDo добавить ещё поле с выбором тестов для контрольного мероприятия

                //удаление кнопки "Обновить доп. инфор о разделе"
                currentCard.find('.update_button_place').filter( ':first' ).empty();
                // удаление сообщений об ошибках
                var currentErrorDiv = currentCard.find('.print-error-msg').filter( ':first' );
                currentErrorDiv.find("ul").html('');
                currentErrorDiv.css('display','none');
                //отображение иконки редактировать
                currentCard.find('.activate_edit_lec_sem_cw').filter( ':first' ).show();
            }else{
                //добавление в html сообщений об ошибках
                var divError = currentCard.find('.print-error-msg').filter( ':first' );
                divError.find("ul").html('');
                divError.css('display','block');
                $.each( data.error, function( key, value ) {
                    divError.find("ul").append('<li>'+value+'</li>');
                });
            }
        }
    });

});

//Удаление раздела
$(document).on('click', '.delete_lec_sem_cw', function () {
    var thisCard = $(this).closest('.card');
    var typeCard = thisCard.attr('data-type-card');
    var idCardForFindJs = thisCard.attr('id');
    var currentSection = $(this).closest('.section');
    var idSectionForFindJs = parseInt(currentSection.attr('id').match(/\d+/));
    var idItemPlan  = thisCard.find('input[name="id_'+typeCard+'_plan"]').filter( ':first' ).val();
    if (confirm(getDeleteMsg(typeCard))) {
        if($.isEmptyObject(idItemPlan)) {

            thisCard.remove();

        } else {
            var token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'DELETE',
                url:   '/course_plan/section/lec_sem_cw/delete',
                data:  {id_item_plan: idItemPlan,
                    id_section_for_find_js: idSectionForFindJs,
                    id_card_for_find_js: idCardForFindJs,
                    type_card: typeCard,
                    "_token": token},
                success: function(data){
                    console.log(data);
                    $('#section'+data.id_section_for_find_js).find('.'+getConteinerTypeCard(data.type_card)).
                    find('#'+data.id_card_for_find_js).remove();
                }
            });

        }
    }

});
