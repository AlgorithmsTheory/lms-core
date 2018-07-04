$(document).ready(function(){
    //Строки таблицы Мои заказы
    $('#dateOrder').change( function(){
        var rows = $('table.tableMyOrder tr:gt(0) ');
        rows = rows.not( ".deleted" );
        $("#authorOrder").val("Автор книги");
        $("#titleOrder").val("Название книги");
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
           // rows = rows.not( "[style='display: none;']" );
        }
    });
    $('#titleOrder').change( function(){
        var rows = $('table.tableMyOrder tr:gt(0) ');
        rows = rows.not( ".deleted" );
        $("#dateOrder").val("Дата заказа");
        $("#authorOrder").val("Автор книги");
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
           // rows = rows.not( "[style='display: none;']" );
        }
    });
//Строки таблицы Книги на руках
    var rowsMyOrder = $('table.tableMyBook tr:gt(0) ');
    $('#dateReturnBook').change( function(){
        $("#authorBook").val("Автор книги");
        $("#titleBook").val("Название книги");
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
            // rows = rows.not( "[style='display: none;']" );
        }
    });
    $('#titleBook').change( function(){
        $("#dateReturnBook").val("Дата возврата");
        $("#authorBook").val("Автор книги");
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
            // rows = rows.not( "[style='display: none;']" );
        }
    });
    $('#dateIssureBook').change( function(){
        $("#dateReturnBook").val("Дата возврата");
        $("#authorBook").val("Автор книги");
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
            // rows = rows.not( "[style='display: none;']" );
        }
    });



//Потверждение  и отмена заказа

    $('.cancel_order').click(function () {
        var x = confirm("Отменить заказ?");
        if (x){
            // alert( "{{ route('Kadyrov_student_order_delete',['id' => \"+id+\"]) }}");
            var id = $( this ).attr("id");
            var regular = /\d+/;
            id = (id.match(regular));
            var token = $( this ).attr("value");
            var button = $( this );
            $.ajax(
                {
                    //посмотри как можно изменить данный url
                    url: "studentCabinet/"+id+"/delete",
                    type: 'DELETE',
                    dataType: "JSON",
                    data: {
                        "id": id,
                        "_method": 'DELETE',
                        "_token": token,
                        //"button": button
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


    //Потверждение и удаление уедомления о отмене заказа

    $('.cancel_message').click(function () {
        var x = confirm("Удалить уведомление?");
        if (x){
            // alert( "{{ route('Kadyrov_student_order_delete',['id' => \"+id+\"]) }}");
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
                        //$('td[id=' + adId + ']')
                        var button = $('table.table_message tr:gt(0) ').find("#cancel"+data);

                        //alert(button.attr("id"));
                        button.parent().parent().hide();
                        //console.log("it Work");
                    }
                });

        }
        else
            return false;
    });
//Настройка календаря
    $.ajax(
        {
            //посмотри как можно изменить данный url
            url: "studentCabinet/settingCalendar",
            type: 'GET',
            dataType: "json",
            async: false,
            success: function (data)
            {

                //alert(data["possible_date"]);
                //var arr = data["possible_date"].split(',');
                var arrayPossibleDate = JSON.parse(data["possible_date"]);
                //alert(typeof (data["minDay"]));
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
        // $('.extend_button').on('click',function(event){
        //    alert("hi");
        //     var myDate = new Date();
        //     // var input_date = new Date($(this).parent().parent().find('#date_extend').val());
        //     var input_date = $(this).parent().parent().find('.datetimepicker').data("DateTimePicker").date();
        //     if (input_date < myDate){
        //         alert("Введенна не актуальная дата");
        //        // $(this).parent().parent().find('#date_extend').attr('value','');
        //         event.preventDefault();
        //     }
        // });
        var myDate = new Date();
        var input_date = $(this).find('.datetimepicker').data("DateTimePicker").date();
       // alert(input_date);
             if (input_date <= myDate){
                 alert("Введенна не актуальная дата");
                 $(this).find('#date_extend').attr('value','');
                 event.preventDefault();
                    return false;
             }else {
                 var $form = $(this);
                 // alert($form.attr('action'));
                 var input_date = $(this).find('#date_extend');
                 var id_issure_book = $(this).attr('id');
                 //alert($form.attr('method'));
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
                        // row.find('#date_return_td').text(data);
                         form.find('#date_extend').attr('value', '');
                         // var button = $('table.table_message tr:gt(0) ').find("#"+data);
                         //alert("it is work"+ id_issure_book);
                     }
                 });
                 //отмена действия по умолчанию для кнопки submit
                 event.preventDefault();
             }
    });



});