//$('#select-teacher').change(function(){
//    choice = $('#select-teacher option:selected').val();
//    alert(choice);
//    //token = $('.form').children().eq(0).val();
//    //$.ajax({
//    //    cache: false,
//    //    type: 'POST',
//    //    url:   '/uir/public/get-type',
//    //    beforeSend: function (xhr) {
//    //        var token = $('meta[name="csrf_token"]').attr('content');
//    //
//    //        if (token) {
//    //            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
//    //        }
//    //    },
//    //    data: { choice: choice, token: 'token' },
//    //    success: function(data){
//    //        $('#type_question_add').html(data);
//    //    }
//    //});
//    return false;
//});

$(".delete").click(function() {
    var id = this.name;
    token = $('#forma').children().eq(0).val();
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/manage_groups/delete_group',
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