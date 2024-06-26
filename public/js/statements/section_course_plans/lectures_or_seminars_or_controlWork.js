
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

//Сообщение для удаления
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


//Закрытие select Тестов
$(document).ready(function(){
    $('.test_select_hide').hide();
});
//Скрытие поля выбора тестов в К.М. при выборе типа WRITING, VERBAL
$(document).on('change', 'select[name="control_work_plan_type"]', function () {

    var optionSelected = $(this).find("option:selected").val();
    var selectTests = $(this).siblings('select[name="id_test"]');

    if( optionSelected == 'ONLINE_TEST' || optionSelected == 'OFFLINE_TEST' ){
        selectTests.collapse('show');
        selectTests.show();

    } else {
        selectTests.prop('selectedIndex', 0);
        selectTests.hide();
    }

});

//возвращает представление для добавление лек/сем/К.М.
$(document).on('click', '.add_lecture_or_sem_or_CW', function () {
    $(".add_lecture_or_sem_or_CW").attr("disabled", true);
    var typeCard = $(this).attr('data-type-card');
    var currentSection = $(this).closest('.section');
    var numberLastCard = $('.' + typeCard).length.toString();

    //Номер для новой карты
    var sectionItemNum = return1IfEmpty(numberLastCard);
    var idSectionPlan = currentSection.attr('id').match(/\d+/);
    // id для добавляемой карты
    var idNewSectionItemJs =  Math.floor(Math.random() * 1000) + Date.now();

    $.ajax({
        cache: false,
        type: 'GET',
        url:   '/course_plan/section/get_add_lec_sem_cw',
        data: { id_new_section_item_js: idNewSectionItemJs,
                id_section_plan: idSectionPlan,
                type_card: typeCard,
                section_item_num: sectionItemNum},
        success: function(data){
            var typeConteinerCards = getConteinerTypeCard(typeCard);
            //Вставка формы добавления лекции или сема или к.м.
            currentSection.find('.'+typeConteinerCards).append(data.view);
            $(".add_lecture_or_sem_or_CW").attr("disabled", false);
        }
    });
});


//Сохранение добаленной лекции/семинара/контрольного мероприятия
$(document).on('click', '.store_lec_sem_cw', function (event) {
    var typeCard = $(this).attr('data-btn-type-card');
    var currentSection = $(this).closest('.section');
    var idSectionPlan = currentSection.attr('id').match(/\d+/).toString();
    var itemSection = $(this).closest('.'+typeCard);
    var idSectionItemJs = itemSection.attr('id');
    var thisForm = $(this).closest('form').serialize();
    var idCoursePlan = parseInt($(".course_plan").attr('id').match(/\d+/));
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
            id_section_plan: idSectionPlan,
            id_section_item_js: idSectionItemJs,
            type_card: typeCard,
            id_course_plan: idCoursePlan
        },
        success: function(data){
            if($.isEmptyObject(data.error)){
                //Замена формы добавления на форму с readonly
                itemSection.replaceWith(data.view);

            }else{
                //добавление в html сообщений об ошибках
                var divError = itemSection.find('.print-error-msg').filter( ':first' );
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
    if(typeCard == 'control_work') {
        thisCard.find('#control_work_plan_type').filter( ':first' ).prop( "disabled", false );
        thisCard.find('#id_test').filter( ':first' ).prop( "disabled", false );
        thisCard.find('input[name="max_points"]').filter( ':first' ).removeAttr("readonly");
    }
    //вставка кнопки "Обновить информ. о разделе"
    var htmlUpdateBatton = '<button type="button" class="ink-reaction btn btn-'+getStyleCard(typeCard)+' update_lec_sem_cw">Обновить</button>';
    thisCard.find('.update_button_place').filter( ':first' ).html(htmlUpdateBatton);
});

//Обновление лекции семинара или контр мероприятия
$(document).on('click', '.update_lec_sem_cw', function () {

    var itemSection = $(this).closest('.card');
    var typeItemSection = itemSection.attr('data-type-card');
    var currentSection = $(this).closest('.section');
    var idSectionPlan = currentSection.attr('id').match(/\d+/).toString();
    var idItemSection = itemSection.attr('id');
    var thisForm = $(this).closest('form').serialize();
    var idCoursePlan = parseInt($(".course_plan").attr('id').match(/\d+/));
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
            id_section_plan: idSectionPlan,
            id_item_section: idItemSection,
            type_item_section: typeItemSection,
            id_course_plan: idCoursePlan
        },
        success: function(data){
            if($.isEmptyObject(data.error)){

                //включение readonly для полей
                itemSection.find('input[name="'+typeItemSection+'_plan_name"]').filter( ':first' ).attr('readonly', true);
                itemSection.find('input[name="'+typeItemSection+'_plan_desc"]').filter( ':first' ).attr('readonly', true);
                itemSection.find('input[name="'+typeItemSection+'_plan_num"]').filter( ':first' ).attr( "readonly", true);
                if(typeItemSection == 'control_work') {
                    itemSection.find('#control_work_plan_type').filter( ':first' ).prop( "disabled", true );
                    itemSection.find('#id_test').filter( ':first' ).prop( "disabled", true );
                    itemSection.find('input[name="max_points"]').filter( ':first' ).attr('readonly', true);
                }
                //удаление кнопки "Обновить доп. инфор о разделе"
                itemSection.find('.update_button_place').filter( ':first' ).empty();
                // удаление сообщений об ошибках
                var currentErrorDiv = itemSection.find('.print-error-msg').filter( ':first' );
                currentErrorDiv.find("ul").html('');
                currentErrorDiv.css('display','none');
                //отображение иконки редактировать
                itemSection.find('.activate_edit_lec_sem_cw').filter( ':first' ).show();
            }else{
                //добавление в html сообщений об ошибках
                var divError = itemSection.find('.print-error-msg').filter( ':first' );
                divError.find("ul").html('');
                divError.css('display','block');
                $.each( data.error, function( key, value ) {
                    divError.find("ul").append('<li>'+value+'</li>');
                });
            }
        }
    });

});

//Удаление лекции, семинара или контрольного мероприятия
$(document).on('click', '.delete_lec_sem_cw', function () {
    var itemSection = $(this).closest('.card');
    var typeItemSection = itemSection.attr('data-type-card');
    var idItemSection = itemSection.attr('id');
    var stored_item  = itemSection.find('input[name="id_'+typeItemSection+'_plan"]').filter( ':first' ).val();
    if (confirm(getDeleteMsg(typeItemSection))) {
        if($.isEmptyObject(stored_item)) {
            itemSection.remove();
        } else {
            var token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'DELETE',
                url:   '/course_plan/section/lec_sem_cw/delete',
                data:  {id_item_plan: idItemSection,
                        type_item_section: typeItemSection,
                    "_token": token},
                success: function(data){
                    itemSection.remove();
                }
            });

        }
    }

});
