
$( document ).ready(function() {
    // $('#accordion .collapse').on('show.bs.collapse', function () {
    //     $('#accordion .collapse').not(this).removeClass('in');
    // });
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
                        location.reload();
                    }
                });
        }
        else
            return false;
    });
});