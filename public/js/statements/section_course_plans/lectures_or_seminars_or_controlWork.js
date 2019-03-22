
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


//возвращает представление для добавление лекуии или сем или К.М.
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




