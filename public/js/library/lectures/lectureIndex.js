
$( document ).ready(function() {
    var $myGroup = $('#accordion');
    $myGroup.on('show.bs.collapse','.collapse', function() {
        $myGroup.find('.collapse.in').collapse('hide');
    });

//Удаление лекции
    $('.deleteLecture').click(function () {
        var x = confirm("Удалить лекцию?");
        if (x) {
            var id = $(this).attr("id");
            var token = $(this).attr("value");
            $.ajax(
                {
                    url: "library/lecture/" + id + "/delete",
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
                            location.reload();
                        }
                    }
                });
        }
        else
            return false;
    });
});
