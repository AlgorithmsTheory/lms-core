/**
 * Created by Misha on 18/03/16.
 */

$(".student").click(function() {
    var id = this.name;
    token = $('#forma').children().eq(0).val();
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/verify_students/student',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { id: id, token: 'token' },
        success: function(data){
            $('#' + data).attr('style', 'display: none;');
        }
    });
    return false;
});

$(".average").click(function() {
    var id = this.name;
    token = $('#forma').children().eq(0).val();
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/verify_students/average',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { id: id, token: 'token' },
        success: function(data){
            $('#' + data).attr('style', 'display: none;');
        }
    });
    return false;
});

$(".admin").click(function() {
    var id = this.name;
    token = $('#forma').children().eq(0).val();
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/verify_students/admin',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { id: id, token: 'token' },
        success: function(data){
            $('#' + data).attr('style', 'display: none;');
        }
    });
    return false;
});

$(".tutor").click(function() {
    var id = this.name;
    token = $('#forma').children().eq(0).val();
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/verify_students/tutor',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { id: id, token: 'token' },
        success: function(data){
            $('#' + data).attr('style', 'display: none;');
        }
    });
    return false;
});

$('.l_name_change').on('change', function() {
    var userID = this.name;
    var value = $( this ).val();
    token = $('#forma').children().eq(0).val();
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/verify_students/change_user_l_name',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { id: userID, value: value, token: 'token' },
        success: function(data){
            alert("Фамилия изменена!");
        }
    });
    return false;
});

$('.f_name_change').on('change', function() {
    var userID = this.name;
    var value = $( this ).val();
    token = $('#forma').children().eq(0).val();
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/verify_students/change_user_f_name',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { id: userID, value: value, token: 'token' },
        success: function(data){
            alert("Имя изменено!");
        }
    });
    return false;
});