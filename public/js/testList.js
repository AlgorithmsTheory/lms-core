/**
 * Created by Станислав on 07.04.16.
 */
/** Действия при нажатии на кнопку "Текущие" */
$('#edit-list').on('click', '#current-btn', function(){
   if ($(this).hasClass('btn-warning'))
        return;
   $('.btn-period').removeClass('btn-warning');
   $('.btn-period').addClass('btn-primary');
   $(this).addClass('btn-warning');
   $('.container-list').css('display', 'none');
   $('#container-current').css('display', 'block');
});

/** Действия при нажатии на кнопку "Прошлые" */
$('#edit-list').on('click', '#past-btn', function(){
    if ($(this).hasClass('btn-warning'))
        return;
    $('.btn-period').removeClass('btn-warning');
    $('.btn-period').addClass('btn-primary');
    $(this).addClass('btn-warning');
    $('.container-list').css('display', 'none');
    $('#container-past').css('display', 'block');
});

/** Действия при нажатии на кнопку "Будущие" */
$('#edit-list').on('click', '#future-btn', function(){
    if ($(this).hasClass('btn-warning'))
        return;
    $('.btn-period').removeClass('btn-warning');
    $('.btn-period').addClass('btn-primary');
    $(this).addClass('btn-warning');
    $('.container-list').css('display', 'none');
    $('#container-future').css('display', 'block');
});

/** Заполняет скрытые поля в зависимсоти от поставленной галочки */
$('#edit-list').on('click', '#finish-chosen', function(){
    $('.finish-checkbox').each(function(){
        if($(this).prop('checked'))
            $(this).prev().val(1);
        else
            $(this).prev().val(0);
    })
});