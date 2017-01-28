/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 

/** Формирование списка тем, соответствующих выбранному разделу */
$('.card').on('change','#section', function(){
    choice = $('#section option:selected').val();
    token = $('.form').children().eq(0).val();
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/get-theme',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { choice: choice, token: 'token' },
        success: function(data){
            $('#theme-container').html(data);
        }
    });
    return false;
});

/** Удаление вопроса */
$('.card').on('click', '.btn-close', function(){
    idQuestion = $(this).first().parents('.card-bordered').find('input[name="num"]').val();
    removableObject = $(this).parents('.col-md-12');
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/questions/delete',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { id_question: idQuestion, token: 'token' },
        success: function(){
            removableObject.remove();
        }
    });
    return false;
});

