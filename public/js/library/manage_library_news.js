
$(function () {

    //валидация добавления новой новости
    $('#form_add_news').on('submit',function(event){
        var x = confirm("Добавить новость?");
        if (x) {
            if ($('#title_add_news').val().length > 50 || $('#title_add_news').val().length < 4) {
                alert("Заголовок новости содержать  от 4 до 50 символов");
                event.preventDefault();
                return false;
            }
            if ($('#body_add_news').val().length > 1000 || $('#body_add_news').val().length < 10) {
                alert("Описание новости должно содержать  от 10 до 1000 символов");
                event.preventDefault();
                return false;
            }
        }else return false;
    });
    //удаление новости
    $('.delete_library_news').click(function () {
        var x = confirm("Удалить данную новость?");
        if (x){
            var id = $( this ).attr("id");
            var regular = /\d+/;
            id = (id.match(regular));
            var token = $( this ).attr("value");
            var button = $( this );
            $.ajax(
                {
                    url: "manageNewsLibrary/"+id+"/delete",
                    type: 'DELETE',
                    dataType: "JSON",
                    data: {
                        "id": id,
                        "_method": 'DELETE',
                        "_token": token,

                    },
                    success: function (data)
                    {
                        $('#'+data).hide();
                    }
                });
        }
        else
            return false;
    });
//Валидация редактирования библиотечной новости
    $('#form_edit_news').on('submit',function(event){
        var x = confirm("Сохранить изменения?");
        if (x) {
            if ($('#title_edit_news').val().length > 50 || $('#title_edit_news').val().length < 4) {
                alert("Заголовок новости должен содержать  от 4 до 50 символов");
                event.preventDefault();
                return false;
            }
            if ($('#body_edit_news').val().length > 1000 || $('#body_edit_news').val().length < 10) {
                alert("Описание новости должно содержать  от 10 до 1000 символов");
                event.preventDefault();
                return false;
            }
        }else return false;
    });
});




