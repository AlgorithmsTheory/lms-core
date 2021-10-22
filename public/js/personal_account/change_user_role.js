/**
 * Created by Misha on 18/03/16.
 */

$(".student").click(function() {
    $(this).attr("disabled", true);
    var id = this.name;
    token = $('#forma').children().eq(0).val();
    myBlurFunction(1);
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
            console.log(data);
            myBlurFunction(0);
            var divError = $('.print-error-msg');
            if($.isEmptyObject(data.errors)) {
                // удаление сообщений об ошибках
                divError.find("ul").html('');
                divError.css('display','none');
                $('#' + data.id + ' td:nth-of-type(5)').text('Студент');
            } else {
                //добавление в html сообщений об ошибках
                divError.find("ul").html('');
                divError.css('display','block');
                $.each( data.errors, function( key, value ) {
                    divError.find("ul").append('<li>'+value+'</li>');
                });
            }
            $('#' + data.id).find(".student").attr("disabled", false);
        }
    });
    return false;
});

function deleteMsgError () {
    var divError = $('.print-error-msg');
    // удаление сообщений об ошибках
    divError.find("ul").html('');
    divError.css('display','none');
}

$(".average").click(function() {
    deleteMsgError();
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
            $('#' + data + ' td:nth-of-type(5)').text('Обычный');
        }
    });
    return false;
});

$(".admin").click(function() {
    deleteMsgError();
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
            $('#' + data + ' td:nth-of-type(5)').text('Админ');
        }
    });
    return false;
});

$(".tutor").click(function() {
    deleteMsgError();
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
            $('#' + data + ' td:nth-of-type(5)').text('Преподаватель');
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


var myBlurFunction = function(state) {
    /* state can be 1 or 0 */
    var containerElement = document.getElementById('main_container');
    var overlayEle = document.getElementById('overlay');

    if (state) {
        var winHeight = $(window).height()/2 - 24;
        winHeight = winHeight.toString()

        overlayEle.style.display = 'block';
        overlayEle.style.top = winHeight.concat('px');
        containerElement.setAttribute('class', 'blur');
    } else {
        overlayEle.style.display = 'none';
        containerElement.setAttribute('class', null);
    }
};