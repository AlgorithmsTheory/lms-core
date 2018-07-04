$(document).ready(function(){


    $('#buttonBooks').click( function(){
        $('#collapseOrders').collapse('hide')
    });

    $('#buttonOrder').click( function(){
        $('#collapseMyBook').collapse('hide')
    });

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

//Потверждение  и отмены заказа

    $('.cancel_order').click(function () {
        var x = confirm("Отменить заказ?");
        if (x){
            // alert( "{{ route('Kadyrov_student_order_delete',['id' => \"+id+\"]) }}");
            var id = $( this ).attr("id");
            var token = $( this ).attr("value");
            $.ajax(
                {
                    //посмотри как можно изменить данный url
                    url: "studentCabinet/"+id+"/delete",
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
                        var button = $('table.tableMyOrder tr:gt(0) ').find("#"+data);

                       //alert(button.attr("id"));
                        button.parent().parent().attr('class','deleted');
                        button.parent().parent().hide();
                        //console.log("it Work");
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
            $.ajax(
                {
                    //посмотри как можно изменить данный url

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
                        var button = $('table.table_message tr:gt(0) ').find("#"+data);

                        //alert(button.attr("id"));
                        button.parent().parent().hide();
                        //console.log("it Work");
                    }
                });

        }
        else
            return false;
    });


});