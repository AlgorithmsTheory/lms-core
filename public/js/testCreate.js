/**
 * Created by Станислав on 07.09.15.
 */
    //подгружаем данные в зависимости от выбранного типа вопроса
$('#select-section').change(function(){
    choice = $('#select-section option:selected').val();
    token = $('.form').children().eq(0).val();
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/uir/public/get-theme-for-test',
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