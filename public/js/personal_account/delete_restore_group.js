$(".delete").on('click', function() {
    const thisEl = $(this);
    const groupId = +thisEl.attr('data-id');
    const isArchived = thisEl.attr('data-archived') === '1';
    token = $('#forma').children().eq(0).val();
    $.ajax({
        cache: false,
        type: 'POST',
        url:   `/manage_groups/group_set/${isArchived ? 'restore' : 'delete'}`,
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { number: groupId, token: 'token' },
        success: function(){
            location.reload();
        }
    });
    return false;
});