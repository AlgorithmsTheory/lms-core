/**
 * Created by Станислав on 19.05.16.
 */
$(document).ready(function(){
    var htmlText = $('#results').html();
    var test = $('#test').val();
    var user = $('#user').val();
    alert('protocol');
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/uir/public/tests/get-protocol',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { id_test: test, id_user: user, html_text: htmlText, token: 'token' },
        success: function(){
            return true;
        }
    });
    return false;
});
