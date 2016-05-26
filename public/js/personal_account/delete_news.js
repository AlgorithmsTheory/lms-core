$(".delete").click(function() {
    var id = this.name;
    var token = $('meta[name="csrf_token"]').attr('content');
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/uir/public/manage_news/delete',
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

$(".show").click(function() {
    var id = this.name;
    token = $('#forma').children().eq(0).val();
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/uir/public/manage_news/hide',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { id: id, token: 'token' },
        success: function(data){
            location.reload();
        }
    });
    return false;
});