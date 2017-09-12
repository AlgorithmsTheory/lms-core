$(".delete").click(function() {
    var number = this.name;
    token = $('#forma').children().eq(0).val();
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/manage_groups/group_set/delete',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { number: number, token: 'token' },
        success: function(){
            location.reload();
        }
    });
    return false;
});