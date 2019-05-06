// Удаление доп. материала
$('.delete_extra').click(function () {
    var x = confirm("Удалить доп. материал?");
    if (x) {
        var button = $(this);
        var id = button.attr("id");
        var token = button.attr("value");
        $.ajax(
            {
                url: 'extra/delete/' + id,
                type: 'DELETE',
                dataType: "JSON",
                data: {
                    "id": id,
                    "_method": 'DELETE',
                    "_token": token
                },
                success: function (data) {
                    button.closest('.extra').hide();
                }
            });
    }
    else
        return false;
});