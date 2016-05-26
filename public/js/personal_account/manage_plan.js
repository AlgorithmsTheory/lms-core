/**
 * Created by Misha on 31/03/16.
 */

$('.plan').on('change', function() {
    if (this.checked) {
        var group = this.name;
        var column = String(this.id);
        token = $('#forma').children().eq(0).val();
        $.ajax({
            cache: false,
            type: 'POST',
            url:   '/uir/public/manage_plan/is',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: { column: column, group: group, token: 'token' },
            success: function(data){
            }
        });
        return false;
    }
    else{
        var group = this.name;
        var column = String(this.id);
        token = $('#forma').children().eq(0).val();
        $.ajax({
            cache: false,
            type: 'POST',
            url:   '/uir/public/manage_plan/is_not',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: { column: column, group: group, token: 'token' },
            success: function(data){
            }
        });
        return false;
    }
});