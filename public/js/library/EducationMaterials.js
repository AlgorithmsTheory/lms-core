
$( document ).ready(function() {
//Удаление материала
    $('.deleteEducationalMaterial').click(function () {
        var x = confirm("Удалить материал?");
        if (x) {
            var id = $(this).attr("id");
            var token = $(this).attr("value");
            $.ajax(
                {
                    url: "educationalMaterials/" + id + "/delete",
                    type: 'DELETE',
                    dataType: "JSON",
                    data: {
                        "id": id,
                        "_method": 'DELETE',
                        "_token": token
                    },
                    success: function (data) {
                        if (data.msg != 'ok') {
                            alert(data.msg)
                        } else {

                            $('[name = "delete'+data.id+'"]').parent().parent().hide();
                        }
                    }
                });
        }
        else
            return false;
    });
});
