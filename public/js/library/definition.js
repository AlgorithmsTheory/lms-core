$(document).ready(function() {
    //Сортировка лекций по разделам
    $('#id_section').change(function () {
        var id_section = $("#id_section option:selected").attr('value');
        var options = $('select[name="id_lecture"] option');
            options.each(function (elem) {
                $(this).show();
            });
            var optionsNot = options.not('[id_section="'+id_section+'"]');
            optionsNot.each(function (elem) {
                $(this).hide();
            });
        if (!id_section) {
            options.each(function (elem) {
                $(this).show();
            });
        }
    });

// Удаление определения
    $('.deleteDefinition').click(function () {
        var x = confirm("Удалить определение?");
        if (x) {
            var id = $(this).attr("id");
            var token = $(this).attr("value");
            $.ajax(
                {
                    url: "definitions/" + id + "/delete",
                    type: 'DELETE',
                    dataType: "JSON",
                    data: {
                        "id": id,
                        "_method": 'DELETE',
                        "_token": token
                    },
                    success: function (data) {
                        $('[name = "delete'+data+'"]').parent().parent().hide();
                    }
                });
        }
        else
            return false;
    });

// Удаление Теоремы
    $('.deleteTheorem').click(function () {
        var x = confirm("Удалить теорему?");
        if (x) {
            var id = $(this).attr("id");
            var token = $(this).attr("value");
            $.ajax(
                {
                    url: "theorems/" + id + "/delete",
                    type: 'DELETE',
                    dataType: "JSON",
                    data: {
                        "id": id,
                        "_method": 'DELETE',
                        "_token": token
                    },
                    success: function (data) {
                        $('[name = "delete'+data+'"]').parent().parent().hide();
                    }
                });
        }
        else
            return false;
    });
});
