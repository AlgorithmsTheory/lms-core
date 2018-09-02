$( document ).ready(function() {
    //Настройка календаря
    $.ajax(
        {
            url: "studentCabinet/settingCalendar",
            type: 'GET',
            dataType: "json",
            async: false,
            success: function (data)
            {
                var arrayPossibleDate = JSON.parse(data["possible_date"]);
                $('.datetimepicker').datetimepicker({
                    format: 'DD.MM.YYYY ',
                    locale: 'ru',
                    daysOfWeekDisabled: arrayPossibleDate,
                    minDate: data["minDay"],
                    maxDate: data["maxDay"],
                    useCurrent: false
                });
            }
        });
});