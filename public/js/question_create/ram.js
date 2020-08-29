var count = $('#count').val();

/** Добавление варианта */
$('#type_question_add').on('click','#add-var-1', function(){
    count++;
    $('#variants-in').append('\
            <div class="form-group">\
                <textarea  name="variants-in[]"  class="form-control textarea3" rows="1" placeholder="" required></textarea>\
                <label for="textarea3">Входное слово ' + count + '</label>\
            </div>\
            ');
    $('#variants-out').append('\
            <div class="form-group">\
                <textarea  name="variants-out[]"  class="form-control textarea3" rows="1" placeholder=""></textarea>\
                <label for="textarea3">Выходное слово ' + count + '</label>\
            </div>\
            ');
});

/** Удаление последнего варианта */
$('#type_question_add').on('click','#del-var-1',function(){
    if (count > 1){
        $('#variants-in').children().last().remove();
        $('#variants-out').children().last().remove();
        count--;
    }
});
