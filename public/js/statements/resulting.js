$('.resulting').on('change', function() {
    var userID = this.name;
    var column = String(this.id);
    var value = $( this ).val();
    token = $('#forma').children().eq(0).val();
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/uir/public/statements/resulting/change',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { id: userID, column: column, value: value, token: 'token' },
        success: function(data){
        }
    });
    return false;
});

$('#calc1').click(function(){
    token = $('#forma').children().eq(0).val();
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/uir/public/statements/resulting/calc_first',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: {token: 'token' },
        success: function(data){
            alert('OK');
        }
    });
    return false;
});

$('#calc2').click(function(){
    token = $('#forma').children().eq(0).val();
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/uir/public/statements/resulting/calc_second',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: {token: 'token' },
        success: function(data){
            alert('OK');
        }
    });
    return false;
});

$('#calc3').click(function(){
    token = $('#forma').children().eq(0).val();
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/uir/public/statements/resulting/calc_third',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: {token: 'token' },
        success: function(data){
            alert('OK');
        }
    });
    return false;
});

$('#calc4').click(function(){
    token = $('#forma').children().eq(0).val();
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/uir/public/statements/resulting/calc_fourth',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: {token: 'token' },
        success: function(data){
            alert('OK');
        }
    });
    return false;
});

$('#calc5').click(function(){
    token = $('#forma').children().eq(0).val();
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/uir/public/statements/resulting/calc_term',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: {token: 'token' },
        success: function(data){
            alert('OK');
        }
    });
    return false;
});

$('#calc6').click(function(){
    token = $('#forma').children().eq(0).val();
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/uir/public/statements/resulting/calc_final',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: {token: 'token' },
        success: function(data){
            alert('OK');
        }
    });
    return false;
});