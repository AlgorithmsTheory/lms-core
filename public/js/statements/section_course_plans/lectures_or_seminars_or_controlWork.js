
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

function return1IfEmpty(elem) {
    if($.isEmptyObject(elem)) {
        return 1;
    } else {
        return parseInt(elem) + 1;
    }
}


//возвращает представление для добавление раздела
$(document).on('click', '.add_lecture_or_sem_or_CW', function () {

    var typeCard = $(this).attr('type_card');

    var currentSection = $(this).closest('.section');
   //Номер последней карты в разделе
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

// TODO: не работает event.preventDefault(); срабатывает дефолтный action у кнопки а на него нет роута поэтому исключение MethodNotAllowedHttpException
//Сохранение добаленного раздела
$(document).on('submit', '#form_add_lecture_or_sem_or_CW', function (event) {
    event.preventDefault();
    var token = $('meta[name="csrf-token"]').attr('content');
    alert(token);
    var typeCard = $(this).attr('type_card');
    // if ($(this).attr('type_card') == 'lecture') {
    //     typeCard = 'lecture';
    // } else {
    //     typeCard = 'seminar';
    // }

    var currentSection = $(this).closest('.section');
    var idSectionDB = currentSection.attr('id_DB');
    var idSectionForFindJs = currentSection.attr('id').match(/\d+/);
    var idCardForFindJs = $(this).closest('.lecture');

    // $.ajax({
    //     type: 'POST',
    //     url:   '/course_plan/section/lec_sem_cw/store',
    //     data:  { form: $(this).serialize(),
    //         id_sectionDB: idSectionDB,
    //         id_section_for_find_js: idSectionForFindJs,
    //         id_card_for_find_js: idCardForFindJs,
    //         type_card: typeCard,
    //         "_token": token
    //     },
    //     success: function(data){
    //         var currentSection = $('#section'+data.id_section_for_find_js);
    //         var typeConteinerCards = getConteinerTypeCard(data.typeCard);
    //         var currentCard = currentSection.find('.'+typeConteinerCards).find('#'+data.id_card_for_find_js);
    //
    //         if($.isEmptyObject(data.error)){
    //             currentCard.replaceWith(data.view);
    //             alert("hi");
    //
    //             //Прибавляем +1 к номерам лекций, семам, КМ после добавленного
    //             var allCards = ('.'+data.type_card);
    //             allCards.each(function( elem ) {
    //                 var inputNumberCard = $( this ).find('input[name="'+ typeCard +'_plan_num"]');
    //                 if(inputNumberCard.val() >= data.new_card_num){
    //                     inputNumberCard.val(inputNumberCard.val() + 1);
    //                 }
    //             });
    //         }else{
    //             //добавление в html сообщений об ошибках
    //             var divError = currentCard.find('.print-error-msg').filter( ':first' );
    //             divError.find("ul").html('');
    //             divError.css('display','block');
    //             $.each( data.error, function( key, value ) {
    //                 divError.find("ul").append('<li>'+value+'</li>');
    //             });
    //         }
    //     }
    // });

});

// //Изменяет view_or_update_section для редактирования раздела
// $(document).on('click', '.activateEditSection', function () {
//     //сркрытие иконки редактировать
//     $(this).hide();
//     var SectionNum = parseInt($(this).closest('.section').find('header').filter( ':first' ).html());
//     var htmlInsertHeader = '<div class="row">\n' +
//         '                <div class="col-lg-4 col-md-4">\n' +
//         '                    <label for="section_num">Номер раздела:</label>\n' +
//         '                </div>\n' +
//         '                <div class="col-lg-4 col-md-4">\n' +
//         '                <input type="text" name="section_num" value="'+SectionNum+'" class="form-control" ' +
//         'required style="background-color: white">' +
//         '                </div>\n' +
//         '            </div>';
//     //вставляем поле с section_num
//     $(this).parent().parent().siblings("header").html(htmlInsertHeader);
//     //выключение readonly для полей
//     var currentSection = $(this).closest('.section');
//     currentSection.find('input[name="section_plan_name"]').filter( ':first' ).removeAttr("readonly");
//     currentSection.find('input[name="section_plan_desc"]').filter( ':first' ).removeAttr("readonly");
//     currentSection.find('#is_exam').filter( ':first' ).prop( "disabled", false );
//     //вставка кнопки "Обновить информ. о разделе"
//     var htmlUpdateBatton = '<button type="submit" class="ink-reaction btn btn-success" id="updateSection">Обновить информ. о разделе</button>';
//     currentSection.find('.update_button_section').filter( ':first' ).html(htmlUpdateBatton);
// });
//
// //Обновление добаленного раздела
// $(document).on('submit', '#form_update_section', function (event) {
//     event.preventDefault();
//     $.ajax({
//         type: 'PATCH',
//         url:   '/course_plan/section/update',
//         data:  $(this).serialize(),
//         success: function(data){
//             if($.isEmptyObject(data.error)){
//                 var htmlInsertHeader = data.real_section_num +' Раздел';
//                 var currentSection = $('#section'+data.section_num_for_find_js);
//                 //вставляем поле с section_num
//                 var currentHeader = $('#section'+data.section_num_for_find_js).find("header").filter( ':first' );
//                 currentHeader.html(htmlInsertHeader);
//                 //выключение readonly для полей
//                 currentSection.find('input[name="section_plan_name"]').filter( ':first' ).attr('readonly', true);
//                 currentSection.find('input[name="section_plan_desc"]').filter( ':first' ).attr('readonly', true);
//                 currentSection.find('#is_exam').filter( ':first' ).prop( "disabled", true);
//                 //удаление кнопки "Обновить доп. инфор о разделе"
//                 currentSection.find('.update_button_section').filter( ':first' ).empty();
//                 // удаление сообщений об ошибках
//                 var currentErrorDiv = currentSection.find('.print-error-msg').filter( ':first' );
//                 currentErrorDiv.find("ul").html('');
//                 currentErrorDiv.css('display','none');
//                 //отображение иконки редактировать
//                 currentSection.find('.activateEditSection').filter( ':first' ).show();
//             }else{
//                 //добавление в html сообщений об ошибках
//                 var divError = $('#section'+data.section_num_for_find_js).find('.print-error-msg').filter( ':first' );
//                 divError.find("ul").html('');
//                 divError.css('display','block');
//                 $.each( data.error, function( key, value ) {
//                     divError.find("ul").append('<li>'+value+'</li>');
//                 });
//             }
//         }
//     });
//
// });
//
// //Удаление раздела
// $(document).on('click', '.deleteSection', function () {
//     if (confirm("Удалить данный раздел ?")) {
//         var currentSection = $(this).closest('.section');
//         var sectionNumForFindJs = parseInt(currentSection.attr('id').match(/\d+/));
//         var idSectionPlan  = currentSection.find('input[name="id_section_plan"]').filter( ':first' ).val();
//         if($.isEmptyObject(idSectionPlan)) {
//
//             $('#section'+sectionNumForFindJs).remove();
//
//         } else {
//
//             var token = $('meta[name="csrf-token"]').attr('content');
//             $.ajax({
//                 type: 'DELETE',
//                 url:   '/course_plan/section/delete',
//                 data:  { "section_num_for_find_js": sectionNumForFindJs,
//                     "id_section_plan": idSectionPlan,
//                     "_token": token},
//                 success: function(data){
//                     $('#section'+data).remove();
//                 }
//             });
//
//         }
//     }
//
// });
