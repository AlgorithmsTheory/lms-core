$(document).ready(function(){
    //Строки таблицы Мои заказы
    $('#dateOrder').change( function(){
        var rows = $('table.tableMyOrder tr:gt(0) ');
        rows = rows.not( ".deleted" );
        $("#authorOrder").val("Автор книги");
        $("#titleOrder").val("Название книги");
        $("#genreOrder").val("Жанр книги");
        if( $("#dateOrder option:selected").text() == "Дата заказа" ){
            rows.show();
        }else{
            rows.each(function( elem ) {
                    if($( this ).children('#date_order_td').text() != $("#dateOrder option:selected").text()){
                        $( this ).hide();
                    }else{
                        $( this ).show();
                    }
            });
        }
    });
    $('#authorOrder').change( function(){
        var rows = $('table.tableMyOrder tr:gt(0) ');
        rows = rows.not( ".deleted" );
        $("#dateOrder").val("Дата заказа");
        $("#titleOrder").val("Название книги");
        $("#genreOrder").val("Жанр книги");
        if( $("#authorOrder option:selected").text() == "Автор книги" ){
            rows.show();
        }else{
            rows.each(function( elem ) {

                if($( this ).children('#author_order_td').text() != $("#authorOrder option:selected").text()){
                    $( this ).hide();
                }else{
                    $( this ).show();
                }
            });
        }
    });
    $('#titleOrder').change( function(){
        var rows = $('table.tableMyOrder tr:gt(0) ');
        rows = rows.not( ".deleted" );
        $("#dateOrder").val("Дата заказа");
        $("#authorOrder").val("Автор книги");
        $("#genreOrder").val("Жанр книги");
        if( $("#titleOrder option:selected").text() == "Название книги" ){
            rows.show();
        }else{
            rows.each(function( elem ) {
                if($( this ).children('#title_order_td').text() != $("#titleOrder option:selected").text()){
                    $( this ).hide();
                }else{
                    $( this ).show();
                }
            });
        }
    });
    $('#genreOrder').change( function(){
        var rows = $('table.tableMyOrder tr:gt(0) ');
        rows = rows.not( ".deleted" );
        $("#dateOrder").val("Дата заказа");
        $("#authorOrder").val("Автор книги");
        $("#titleOrder").val("Название книги");
        if( $("#genreOrder option:selected").text() == "Жанр книги" ){
            rows.show();
        }else{
            rows.each(function( elem ) {
                if($( this ).children('#genre_order_td').text() != $("#genreOrder option:selected").text()){
                    $( this ).hide();
                }else{
                    $( this ).show();
                }
            });
        }
    });
//Строки таблицы Книги на руках
    var rowsMyOrder = $('table.tableMyBook tr:gt(0) ');
    $('#dateReturnBook').change( function(){
        $("#authorBook").val("Автор книги");
        $("#titleBook").val("Название книги");
        $("#genreBook").val("Жанр книги");
        if( $("#dateReturnBook option:selected").text() == "Дата возврата" ){
            rowsMyOrder.show();
        }else{
            rowsMyOrder.each(function( elem ) {
                if($( this ).children('#date_return_td').text() != $("#dateReturnBook option:selected").text()){
                    $( this ).hide();
                }else{
                    $( this ).show();
                }
            });
        }
    });
    $('#authorBook').change( function(){
        $("#dateReturnBook").val("Дата возврата");
        $("#titleBook").val("Название книги");
        $("#genreBook").val("Жанр книги");
        if( $("#authorBook option:selected").text() == "Автор книги" ){
            rowsMyOrder.show();
        }else{
            rowsMyOrder.each(function( elem ) {

                if($( this ).children('#author_book_td').text() != $("#authorBook option:selected").text()){
                    $( this ).hide();
                }else{
                    $( this ).show();
                }
            });
        }
    });
    $('#titleBook').change( function(){
        $("#dateReturnBook").val("Дата возврата");
        $("#authorBook").val("Автор книги");
        $("#genreBook").val("Жанр книги");
        if( $("#titleBook option:selected").text() == "Название книги" ){
            rowsMyOrder.show();
        }else{
            rowsMyOrder.each(function( elem ) {
                if($( this ).children('#title_book_id').text() != $("#titleBook option:selected").text()){
                    $( this ).hide();
                }else{
                    $( this ).show();
                }
            });
        }
    });
    $('#dateIssureBook').change( function(){
        $("#dateReturnBook").val("Дата возврата");
        $("#authorBook").val("Автор книги");
        $("#genreBook").val("Жанр книги");
        if( $("#dateIssureBook option:selected").text() == "Дата получения" ){
            rowsMyOrder.show();
        }else{
            rowsMyOrder.each(function( elem ) {
                if($( this ).children('#date_issure_td').text() != $("#dateIssureBook option:selected").text()){
                    $( this ).hide();
                }else{
                    $( this ).show();
                }
            });
        }
    });
    $('#genreBook').change( function(){
        $("#dateReturnBook").val("Дата возврата");
        $("#authorBook").val("Автор книги");
        $("#dateIssureBook").val("Дата получения");
        if( $("#genreBook option:selected").text() == "Жанр книги" ){
            rowsMyOrder.show();
        }else{
            rowsMyOrder.each(function( elem ) {
                if($( this ).children('#genre_book_td').text() != $("#genreBook option:selected").text()){
                    $( this ).hide();
                }else{
                    $( this ).show();
                }
            });
        }
    });


//Потверждение  и отмена заказа

    $('.cancel_order').click(function () {
        var x = confirm("Отменить заказ?");
        if (x){
            var id = $( this ).attr("id");
            var regular = /\d+/;
            id = (id.match(regular));
            var token = $( this ).attr("value");
            var button = $( this );
            $.ajax(
                {
                    url: "studentCabinet/"+id+"/delete",
                    type: 'DELETE',
                    dataType: "JSON",
                    data: {
                        "id": id,
                        "_method": 'DELETE',
                        "_token": token,
                    },
                    success: function (data)
                    {
                        //$('td[id=' + adId + ']')
                        var button = $('table.tableMyOrder tr:gt(0) ').find("#delete"+data);
                        button.parent().parent().attr('class','deleted');
                        button.parent().parent().hide();


                    }
                });

        }
        else
            return false;
    });


    //Потверждение и удаление уведомления о отмене заказа

    $('.cancel_message').click(function () {
        var x = confirm("Удалить уведомление?");
        if (x){
            var id = $( this ).attr("id");
            var token = $( this ).attr("value");
            var regular = /\d+/;
            id = (id.match(regular));
            $.ajax(
                {
                    url: "studentCabinet/"+id+"/delete_message",
                    type: 'DELETE',
                    dataType: "JSON",
                    data: {
                        "id": id,
                        "_method": 'DELETE',
                        "_token": token
                    },
                    success: function (data)
                    {
                        var button = $('table.table_message tr:gt(0) ').find("#cancel"+data);
                        button.parent().parent().hide();
                    }
                });

        }
        else
            return false;
    });
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
                    format: 'YYYY.MM.DD ',
                    locale: 'ru',
                    daysOfWeekDisabled: arrayPossibleDate,
                    minDate: data["minDay"],
                    maxDate: data["maxDay"],
                    useCurrent: false
                });
            }
        });

    $('.form_extend').on('submit', function(event) {
        //Валидация календаря
        var myDate = new Date();
        var input_date = $(this).find('.datetimepicker').data("DateTimePicker").date();
             if (input_date <= myDate){
                 alert("Введенна не актуальная дата");
                 $(this).find('#date_extend').attr('value','');
                 event.preventDefault();
                    return false;
             }else {
                 var $form = $(this);
                 var input_date = $(this).find('#date_extend');
                 var id_issure_book = $(this).attr('id');
                 $.ajax({
                     type: 'post',
                     url: "studentCabinet/" + id_issure_book + '/extendDate',
                     data: $(this).serialize(),
                     async: false,
                     success: function (data) {
                         var form = $("form[id=" + id_issure_book + "]");
                         var row = form.parent().parent();
                         var new_dateExtend = data.replace(/[\.\/]/g,'-');
                         row.find('#date_return_td').text(new_dateExtend);
                         form.find('#date_extend').attr('value', '');
                     }
                 });
                 event.preventDefault();
             }
    });
});