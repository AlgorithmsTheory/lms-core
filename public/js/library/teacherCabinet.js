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
                    var id = $(this).find(".form_issure").attr('id');
                    $('#comment'+ id).attr("class", "info comment");
                }
            });
            rows.each(function( elem ) {
                if($( this ).attr('class') == "info comment"){
                    $( this ).show();
                    $( this ).attr("class", "info");
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
                    var id = $(this).find(".form_issure").attr('id');
                    $('#comment'+ id).attr("class", "info comment");
                }
            });
            rows.each(function( elem ) {
                if($( this ).attr('class') == "info comment"){
                    $( this ).show();
                    $( this ).attr("class", "info");
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
                    var id = $(this).find(".form_issure").attr('id');
                    $('#comment'+ id).attr("class", "info comment");
                }
            });
            rows.each(function( elem ) {
                if($( this ).attr('class') == "info comment"){
                    $( this ).show();
                    $( this ).attr("class", "info");
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
                    var id = $(this).find(".form_issure").attr('id');
                    $('#comment'+ id).attr("class", "info comment");
                }
            });
            rows.each(function( elem ) {
                if($( this ).attr('class') == "info comment"){
                    $( this ).show();
                    $( this ).attr("class", "info");
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
                    var id = $(this).find(".form_issure").attr('id');
                    $('#comment'+ id).attr("class", "info comment");
                }
            });
            rows.each(function( elem ) {
                if($( this ).attr('class') == "info comment"){
                    $( this ).show();
                    $( this ).attr("class", "info");
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
                if($( this ).children('#genre_order_td').text() != $("#genresOrder option:selected").text() ){
                    $( this ).hide();
                }else{
                    $( this ).show();
                    var id = $(this).find(".form_issure").attr('id');
                    $('#comment'+ id).attr("class", "info comment");

                }
            });
            rows.each(function( elem ) {
                if($( this ).attr('class') == "info comment"){
                    $( this ).show();
                    $( this ).attr("class", "info");
                }
            });
        }
    });
    // Сортировка таблицы Выданные Книги
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
            event.preventDefault();
            var id_issure_book = $( this ).attr("id");
            var button = $( this ).find('#'+$( this ).attr("id"));

            $.ajax({
                type: 'post',
                url: "teacherCabinet/"+id_issure_book+'/issureBook',
                data: $(this).serialize(),
                success: function (data)
                {
                    var button = $('table.tableOrder tr:gt(0) ').find("#issure"+data);
                    var button = button.parent().parent().parent().parent().attr('class','deleted');
                     button.hide();
                    $('#comment'+data).attr('class','deleted');
                    $('#comment'+data).hide();
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
                        var button = $('table.tableOrder tr:gt(0) ').find('.cancel_order').parent().find('#'+data);
                        button.parent().parent().attr('class','deleted');
                        button.parent().parent().hide();
                        $('#comment'+data).attr('class','deleted');
                        $('#comment'+data).hide();

                    }
                });
        }
        else
            return false;
    });

//Кнопка Перенести

    $('.form_extend').on('submit', function(event) {
        //Валидация календаря
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
                    var form = $("form[id=extend" + data['id_order'] + "]");
                    var row = form.parent().parent();
                    var new_dateExtend = data['date_extend'].replace(/[\.\/]/g,'-');
                    row.find('#date_return_order_td').text(new_dateExtend);
                    form.find("input[type=text]").attr('value', '');

                    var table = row.parent();
                    var input = table.find('input[name=id_book]');
                   input.siblings('input[name=date_order]').val();
                }
            });
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
                        var button = $('table.tableIssureBook tr:gt(0) ').find('.return_book').parent().find("#"+data);
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
                    var form = $("form[id=remember" + data + "]");
                     var button = form.find('button').attr('disabled',true);
                }
            });
            event.preventDefault();
        }else
            return false;
    });



});