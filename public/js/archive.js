/**
 * Created by Станислав on 17.05.16.
 */
$('.folder-panel').click(function(){
   $(this).parent('form').submit();
});

$('#file-table').on('click', '.remove-btn', function(){
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/uir/public/storage/delete/file',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { section: section, theme: theme, type: type, test_type: testType, token: 'token' },
        success: function(data){
            $('#amount-container-'+tempCount).html(data);
            $('#num-'+tempCount).attr('max', data);
        }
    });
    return false;
});