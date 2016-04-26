/**
 * Created by Misha on 31/03/16.
 */

$('.was').on('change', function() {
    if (this.checked) {
        var userID = this.name;
        var column = String(this.id);
        token = $('#forma').children().eq(0).val();
        $.ajax({
            cache: false,
            type: 'POST',
            url:   '/uir/public/statements/lecture/was',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: { id: userID, column: column, token: 'token' },
            success: function(data){
            }
        });
        return false;
    }
    else{
        var userID = this.name;
        var column = String(this.id);
        token = $('#forma').children().eq(0).val();
        $.ajax({
            cache: false,
            type: 'POST',
            url:   '/uir/public/statements/lecture/wasnot',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: { id: userID, column: column, token: 'token' },
            success: function(data){
            }
        });
        return false;
    }
});