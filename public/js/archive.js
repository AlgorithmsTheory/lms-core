/**
 * Created by Стас on 17.05.16.
 */
$('.folder-panel').click(function(){
   $(this).parent('form').submit();
});

$('#file-table').on('click', '.remove-btn', function(){
    filePath = $(this).parents('form').children('.file-path-input').val();
    object = $(this);
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
        data: { file_path: filePath, token: 'token' },
        success: function(){
            object.parents('.card-bordered').remove();
        }
    });
    return false;
});

/*$('#base').on('click', '#download-folder', function(){
    folderPath = $('#current-folder').val();
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/uir/public/storage/download-folder/folder',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { folder_path: folderPath, token: 'token' },
        success: function(data){
            alert(data);
        }
    });
    return false;
});*/