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
                    format: 'YYYY.MM.DD ',
                    locale: 'ru',
                    daysOfWeekDisabled: arrayPossibleDate,
                    minDate: data["minDay"],
                    maxDate: data["maxDay"],
                    useCurrent: false
                });
            }
        });
// Сортировка таблицы Заказы книг
//     $('#studentOrder').change( function(){
//         var rows = $('table.tableOrder tr:gt(0) ');
//         rows = rows.not( ".deleted" );
//         $("#groupOrder").val("Группа");
//         $("#titleOrder").val("Название книги");
//         $("#authorOrder").val("Автор книги");
//         $("#dateOrder").val("Дата заказа");
//         if( $("#studentOrder option:selected").text() == "Студент" ){
//             rows.show();
//         }else{
//             rows.each(function( elem ) {
//                 if($( this ).children('#student_order_id').attr('class') != "delay"){
//                     $( this ).hide();
//                 }else{
//                     $( this ).show();
//                 }
//             });
//         }
//     });

    $('#studentOrder').change( function(){
        var rows = $('table.tableOrder tr:gt(0) ');
        rows = rows.not( ".deleted" );
        $("#titleOrder").val("Название книги");
        $("#groupOrder").val("Группа");
        $("#authorOrder").val("Автор книги");
        $("#dateOrder").val("Дата заказа");
        $("#genresOrder").val("Жанр книги");
        if( $("#studentOrder option:selected").text() == "Студент" ){
            rows.show();
        }else{
            rows.each(function( elem ) {
                if($( this ).children('#student_order_id').text() != $("#studentOrder option:selected").text()){
                    $( this ).hide();
                }else{
                    $( this ).show();
                }
            });
        }
    });



    $('#groupOrder').change( function(){
        var rows = $('table.tableOrder tr:gt(0) ');
        rows = rows.not( ".deleted" );
        $("#studentOrder").val("Студент");
        $("#titleOrder").val("Название книги");
        $("#authorOrder").val("Автор книги");
        $("#dateOrder").val("Дата заказа");
        $("#genresOrder").val("Жанр книги");
        if( $("#groupOrder option:selected").text() == "Группа" ){
            rows.show();
        }else{
            rows.each(function( elem ) {
                if($( this ).children('#group_order_id').text() != $("#groupOrder option:selected").text()){
                    $( this ).hide();
                }else{
                    $( this ).show();
                }
            });
        }
    });
    $('#titleOrder').change( function(){
        var rows = $('table.tableOrder tr:gt(0) ');
        rows = rows.not( ".deleted" );
        $("#studentOrder").val("Студент");
        $("#groupOrder").val("Группа");
        $("#authorOrder").val("Автор книги");
        $("#dateOrder").val("Дата заказа");
        $("#genresOrder").val("Жанр книги");
        if( $("#titleOrder option:selected").text() == "Название книги" ){
            rows.show();
        }else{
            rows.each(function( elem ) {
                if($( this ).children('#title_order_id').text() != $("#titleOrder option:selected").text()){
                    $( this ).hide();
                }else{
                    $( this ).show();
                }
            });
        }
    });
    $('#authorOrder').change( function(){
        var rows = $('table.tableOrder tr:gt(0) ');
        rows = rows.not( ".deleted" );
        $("#studentOrder").val("Студент");
        $("#groupOrder").val("Группа");
        $("#titleOrder").val("Название книги");
        $("#dateOrder").val("Дата заказа");
        $("#genresOrder").val("Жанр книги");
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
    $('#dateOrder').change( function(){
        var rows = $('table.tableOrder tr:gt(0) ');
        rows = rows.not( ".deleted" );
        $("#studentOrder").val("Студент");
        $("#groupOrder").val("Группа");
        $("#titleOrder").val("Название книги");
        $("#authorOrder").val("Автор книги");
        $("#genresOrder").val("Жанр книги");
        if( $("#dateOrder option:selected").text() == "Дата заказа" ){
            rows.show();
        }else{
            rows.each(function( elem ) {
                if($( this ).children('#date_return_order_td').text() != $("#dateOrder option:selected").text()){
                    $( this ).hide();
                }else{
                    $( this ).show();
                }
            });
        }
    });
    $('#genresOrder').change( function(){
        var rows = $('table.tableOrder tr:gt(0) ');
        rows = rows.not( ".deleted" );
        $("#studentOrder").val("Студент");
        $("#groupOrder").val("Группа");
        $("#titleOrder").val("Название книги");
        $("#authorOrder").val("Автор книги");
        $("#dateOrder").val("Дата заказа");
        if( $("#genresOrder option:selected").text() == "Жанр книги" ){
            rows.show();
        }else{
            rows.each(function( elem ) {
                if($( this ).children('#genre_order_td').text() != $("#genresOrder option:selected").text()){
                    $( this ).hide();
                }else{
                    $( this ).show();
                }
            });
        }
    });
    // Сортировка таблицы Выданные Книги
    // $('#studentIssureBook').change( function(){
    //     var rows = $('table.tableIssureBook tr:gt(0) ');
    //     rows = rows.not( ".deleted" );
    //     $("#groupIssureBook").val("Группа");
    //     $("#titleIssureBook").val("Название книги");
    //     $("#authorIssureBook").val("Автор книги");
    //     $("#dateIssureBook").val("Дата выдачи");
    //     $("#dateReturnIssureBook").val("Дата Возврата");
    //     if( $("#studentIssureBook option:selected").text() == "Студент" ){
    //         rows.show();
    //     }else{
    //         rows.each(function( elem ) {
    //             if($( this ).children('#student_issure_book_id').attr('class') != "notDelay"){
    //                 $( this ).hide();
    //             }else{
    //                 $( this ).show();
    //             }
    //         });
    //     }
    // });

    $('#studentIssureBook').change( function(){
        var rows = $('table.tableIssureBook tr:gt(0) ');
        rows = rows.not( ".deleted" );
        $("#groupIssureBook").val("Группа");
        $("#titleIssureBook").val("Название книги");
        $("#authorIssureBook").val("Автор книги");
        $("#dateIssureBook").val("Дата выдачи");
        $("#dateReturnIssureBook").val("Дата Возврата");
        $("#genresIssureBook").val("Жанр книги");
        if( $("#studentIssureBook option:selected").text() == "Студент" ){
            rows.show();
        }else{
            rows.each(function( elem ) {
                if($( this ).children('#student_issure_book_id').attr('class') != "delay"){
                    $( this ).hide();
                }else{
                    $( this ).show();
                }
            });
        }
    });


    $('#groupIssureBook').change( function(){
        var rows = $('table.tableIssureBook tr:gt(0) ');
        rows = rows.not( ".deleted" );
        $("#studentIssureBook").val("Студент");
        $("#titleIssureBook").val("Название книги");
        $("#authorIssureBook").val("Автор книги");
        $("#dateIssureBook").val("Дата выдачи");
        $("#dateReturnIssureBook").val("Дата Возврата");
        $("#genresIssureBook").val("Жанр книги");
        if( $("#groupIssureBook option:selected").text() == "Группа" ){
            rows.show();
        }else{
            rows.each(function( elem ) {
                if($( this ).children('#group_issure_book_id').text() != $("#groupIssureBook option:selected").text()){
                    $( this ).hide();
                }else{
                    $( this ).show();
                }
            });
        }
    });

    $('#titleIssureBook').change( function(){
        var rows = $('table.tableIssureBook tr:gt(0) ');
        rows = rows.not( ".deleted" );
        $("#studentIssureBook").val("Студент");
        $("#groupIssureBook").val("Группа");
        $("#authorIssureBook").val("Автор книги");
        $("#dateIssureBook").val("Дата выдачи");
        $("#dateReturnIssureBook").val("Дата Возврата");
        $("#genresIssureBook").val("Жанр книги");
        if( $("#titleIssureBook option:selected").text() == "Название книги" ){
            rows.show();
        }else{
            rows.each(function( elem ) {
                if($( this ).children('#title_issure_book_id').text() != $("#titleIssureBook option:selected").text()){
                    $( this ).hide();
                }else{
                    $( this ).show();
                }
            });
        }
    });

    $('#authorIssureBook').change( function(){
        var rows = $('table.tableIssureBook tr:gt(0) ');
        rows = rows.not( ".deleted" );
        $("#studentIssureBook").val("Студент");
        $("#groupIssureBook").val("Группа");
        $("#titleIssureBook").val("Название книги");
        $("#dateIssureBook").val("Дата выдачи");
        $("#dateReturnIssureBook").val("Дата Возврата");
        $("#genresIssureBook").val("Жанр книги");
        if( $("#authorIssureBook option:selected").text() == "Автор книги" ){
            rows.show();
        }else{
            rows.each(function( elem ) {
                if($( this ).children('#author_issure_book_td').text() != $("#authorIssureBook option:selected").text()){
                    $( this ).hide();
                }else{
                    $( this ).show();
                }
            });
        }
    });
    $('#dateIssureBook').change( function(){
        var rows = $('table.tableIssureBook tr:gt(0) ');
        rows = rows.not( ".deleted" );
        $("#studentIssureBook").val("Студент");
        $("#groupIssureBook").val("Группа");
        $("#titleIssureBook").val("Название книги");
        $("#authorIssureBook").val("Автор книги");
        $("#dateReturnIssureBook").val("Дата Возврата");
        $("#genresIssureBook").val("Жанр книги");
        if( $("#dateIssureBook option:selected").text() == "Дата выдачи" ){
            rows.show();
        }else{
            rows.each(function( elem ) {
                if($( this ).children('#date_issure_book_td').text() != $("#dateIssureBook option:selected").text()){
                    $( this ).hide();
                }else{
                    $( this ).show();
                }
            });
        }
    });
    $('#dateReturnIssureBook').change( function(){
        var rows = $('table.tableIssureBook tr:gt(0) ');
        rows = rows.not( ".deleted" );
        $("#studentIssureBook").val("Студент");
        $("#groupIssureBook").val("Группа");
        $("#titleIssureBook").val("Название книги");
        $("#authorIssureBook").val("Автор книги");
        $("#dateIssureBook").val("Дата выдачи");
        $("#genresIssureBook").val("Жанр книги");
        if( $("#dateReturnIssureBook option:selected").text() == "Дата Возврата" ){
            rows.show();
        }else{
            rows.each(function( elem ) {
                if($( this ).children('#date_return_issure_book_td').text() != $("#dateReturnIssureBook option:selected").text()){
                    $( this ).hide();
                }else{
                    $( this ).show();
                }
            });
        }
    });
    $('#genresIssureBook').change( function(){
        var rows = $('table.tableIssureBook tr:gt(0) ');
        rows = rows.not( ".deleted" );
        $("#studentIssureBook").val("Студент");
        $("#groupIssureBook").val("Группа");
        $("#titleIssureBook").val("Название книги");
        $("#authorIssureBook").val("Автор книги");
        $("#dateIssureBook").val("Дата выдачи");
        $("#dateReturnIssureBook").val("Дата Возврата");
        if( $("#genresIssureBook option:selected").text() == "Жанр книги" ){
            rows.show();
        }else{
            rows.each(function( elem ) {
                if($( this ).children('#genere_issure_book_td').text() != $("#genresIssureBook option:selected").text()){
                    $( this ).hide();
                }else{
                    $( this ).show();
                }
            });
        }
    });
    // сортировка таблицы Книги в наличии
    $('#titleLibraryBook').change( function(){
        var rows = $('table.tableInLibrary tr:gt(0) ');
        $("#authorLibraryBook").val("Автор книги");
        if( $("#titleLibraryBook option:selected").text() == "Название книги" ){
            rows.show();
        }else{
            rows.each(function( elem ) {
                if($( this ).children('#title_library_id').text() != $("#titleLibraryBook option:selected").text()){
                    $( this ).hide();
                }else{
                    $( this ).show();
                }
            });
        }
    });
    $('#authorLibraryBook').change( function(){
        var rows = $('table.tableInLibrary tr:gt(0) ');
        $("#titleLibraryBook").val("Название книги");
        if( $("#authorLibraryBook option:selected").text() == "Автор книги" ){
            rows.show();
        }else{
            rows.each(function( elem ) {
                if($( this ).children('#author_library_id').text() != $("#authorLibraryBook option:selected").text()){

                    $( this ).hide();
                }else{
                    $( this ).show();
                }
            });
        }
    });
//Кнопка Выдать
    $('.form_issure').on('submit', function(event){
        var x = confirm("Выдать книгу?");
        if (x){
            //отмена действия по умолчанию для кнопки submit
            event.preventDefault();
            var id_issure_book = $( this ).attr("id");
            var button = $( this ).find('#'+$( this ).attr("id"));

            $.ajax({
                type: 'post',
                url: "teacherCabinet/"+id_issure_book+'/issureBook',
                data: $(this).serialize(),
                success: function (data)
                {

                    //alert("IT is work"+data);
                    var button = $('table.tableOrder tr:gt(0) ').find("#issure"+data);

                   // alert(button.attr("id"));
                    var button = button.parent().parent().parent().parent().attr('class','deleted');
                     button.hide();
                }
            });

        }
        else
            return false;
    });



    //Кнопка отменить
    $('.cancel_order').click(function () {
        var x = confirm("Отменить заказ?");
        if (x){
            // alert( "{{ route('student_order_delete',['id' => \"+id+\"]) }}");
            var id = $( this ).attr("id");
            var token = $( this ).attr("value");
            $.ajax(
                {
                    url: "teacherCabinet/"+id+"/delete",
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
                        var button = $('table.tableOrder tr:gt(0) ').find('.cancel_order').parent().find('#'+data);
                        //alert(button.attr("id"));
                        button.parent().parent().attr('class','deleted');
                        button.parent().parent().hide();
                    }
                });
        }
        else
            return false;
    });

//Кнопка Перенести

    $('.form_extend').on('submit', function(event) {
        //Валидация календаря
        // $('.extend_button').on('click',function(event){
        //     event.preventDefault();
        //
        //     var myDate = new Date();
        //     // var input_date = new Date($(this).parent().parent().find('#date_extend').val());
        //     var input_date = $(this).parent().parent().find('.datetimepicker').data("DateTimePicker").date();
        //     if (input_date < myDate){
        //         alert("Введенна не актуальная дата");
        //          $(this).parent().parent().find('#date_extend').attr('value','');
        //         event.preventDefault();
        //     }
        // });
        var myDate = new Date();
        var input_date = $(this).find('.datetimepicker').data("DateTimePicker").date();
        // alert(input_date);
        if (input_date <= myDate){
            alert("Введенна не актуальная дата");
            $(this).find("input[type=text]").attr('value','');
            event.preventDefault();
            return false;
        }else {
            var $form = $(this);
            // alert('hi');
            var input_date = $(this).find('#date_extend');
            var id_order_book = $(this).attr('id');
            $.ajax({
                type: 'post',
                url: "teacherCabinet/" + id_order_book + '/extendDate',
                data: $(this).serialize(),
                success: function (data) {
                    //var form = $("form[id=extend"+id_order_book+"]");
                    var form = $("form[id=extend" + data['id_order'] + "]");

                    // alert(data['id_order']);
                    var row = form.parent().parent();
                    var new_dateExtend = data['date_extend'].replace(/[\.\/]/g,'-');
                    row.find('#date_return_order_td').text(new_dateExtend);
                    form.find("input[type=text]").attr('value', '');

                    var table = row.parent();
                    var input = table.find('input[name=id_book]');
                   // alert(input.val());
                   // alert(data['id_book']);
                    var sosed = input.siblings('input[name=date_order]').val();
                   // alert(sosed );
                   // alert(data['date_extend']);
                    // через php

                    // input.each(function( elem ) {
                    //     // var date_order = new Date($( this ).siblings('input[name=date_order]').val());
                    //     // var date_extnd =  new Date(new_dateExtend);
                    //     alert($( this ).siblings('input[name=date_order]').val()+"data_extend"+ new_dateExtend );
                    //     if (input.siblings('input[name=date_order]').val()== data['dateReturnToBD']){
                    //        alert("hi");
                    //     }
                    // });
                    // через js
                    // var new_dateExtend = data['date_extend'].replace(/[\.\/]/g,'-');
                    // input.each(function( elem ) {
                    //     // var date_order = new Date($( this ).siblings('input[name=date_order]').val());
                    //     // var date_extnd =  new Date(new_dateExtend);
                    //     alert($( this ).siblings('input[name=date_order]').val()+"data_extend"+ new_dateExtend );
                    //     if($( this ).siblings('input[name=date_order]').val() == new_dateExtend){
                    //         alert('hi');
                    //         if ($( this ).val() == data['id_book'] ){
                    //             //alert('hi');
                    //             $( this ).parent().hide();
                    //         }
                    //     }
                    // });

                }
            });
            //отмена действия по умолчанию для кнопки submit
            event.preventDefault();
        }
    });

    // Возврат книги
    $('.return_book').click(function () {
        var x = confirm("Подтверждение возврата книги");
        if (x){
            var id = $( this ).attr("id");
            var token = $( this ).attr("value");
            $.ajax(
                {
                    url: "teacherCabinet/"+id+"/returnBook",
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
                        var button = $('table.tableIssureBook tr:gt(0) ').find('.return_book').parent().find("#"+data);
                        //alert(button.attr("id"));
                        button.parent().parent().attr('class','deleted');
                        button.parent().parent().hide();
                    }
                });
        }
        else
            return false;
    });
//Кнопка напомнить


    $('.form_remember').on('submit', function(event) {
        var x = confirm("Отправить напоминание?");
        var id_issure_book = $(this).attr('id');
        if (x) {
            $.ajax({
                type: 'post',
                url: "teacherCabinet/" + id_issure_book + '/sendMessage',
                data: $(this).serialize(),
                success: function (data) {
                    //var form = $("form[id=extend"+id_order_book+"]");
                    var form = $("form[id=remember" + data + "]");

                     var button = form.find('button').attr('disabled',true);
                    // var row = form.parent().parent();
                    // row.find('#date_return_order_td').text(data['date_extend']);
                    // form.find('#date_extend').attr('value', '');

                }
            });
            //отмена действия по умолчанию для кнопки submit
            event.preventDefault();
        }else
            return false;
    });



});