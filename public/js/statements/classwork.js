$('.classwork').on('change', function() {
    var userID = this.name;
    var column = String(this.id);
    var value = $( this ).val();
    token = $('#forma').children().eq(0).val();
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/uir/public/statements/classwork/change',
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