//возвращает представление для добавление раздела
$(document).on('click', '#addSection', function () {
    var sectionNum = $('.section').filter(function(index) {
        return $(this).find("input[name='is_exam']").val() != 1;
    }).length;
    sectionNum++;
    var idCoursePlan = parseInt($(".course_plan").attr('id').match(/\d+/));
    var idSectionPlanJs = Math.floor(Math.random() * 1000) + Date.now();
    var maxCourseBalls = parseInt($(".course_plan").attr('max_balls'));
    var section_plan_max_lecture_ball = parseInt($(".course_plan").attr('max_lecture_ball'));
    var section_plan_max_seminar_pass_ball = parseInt($(".course_plan").attr('max_seminar_pass_ball'));
    $.ajax({
        cache: false,
        type: 'GET',
        url:   '/course_plan/get_add_section',
        data: { section_num: sectionNum, id_course_plan: idCoursePlan, id_section_plan_js: idSectionPlanJs, max_balls: maxCourseBalls, max_lecture_ball: section_plan_max_lecture_ball, max_seminar_pass_ball:section_plan_max_seminar_pass_ball},
        success: function(data){
            $('#sections').append(data);
        }
    });
});

//Сохранение добаленного раздела
$(document).on('submit', '#form_add_section', function (event) {
    event.preventDefault();
    var idCoursePlan = parseInt($(".course_plan").attr('id').match(/\d+/));
    $.ajax({
        type: 'POST',
        url:   '/course_plan/'+idCoursePlan+'/section',
        data:  $(this).serialize(),
        success: function(data){
            console.log(data)
            var currentSection = $('#section'+data.idSectionPlanJs);
            if($.isEmptyObject(data.error)){
                currentSection.replaceWith(data.view);
            }else{
                //добавление в html сообщений об ошибках
                var divError = currentSection.find('.print-error-msg').filter( ':first' );
                divError.find("ul").html('');
                divError.css('display','block');
                $.each( data.error, function( key, value ) {
                    divError.find("ul").append('<li>'+value+'</li>');
                });
            }
        }
    });

});

//Изменяет view_or_update_section для редактирования раздела
$(document).on('click', '.activate_edit_section', function () {
    var currentSection = $(this).closest('.section');
    //сркрытие иконки редактировать
    $(this).hide();
    var isExam = currentSection.find('#is_exam').filter( ':first' ).val();
    if(isExam == 0) {
        var SectionNum = parseInt($(this).closest('.section').find('header').filter( ':first' ).html());
        var htmlInsertHeader = '<div class="row">\n' +
            '                <div class="col-lg-4 col-md-4">\n' +
            '                    <label for="section_num">Номер раздела:</label>\n' +
            '                </div>\n' +
            '                <div class="col-lg-4 col-md-4">\n' +
            '                <input type="text" name="section_num" value="'+SectionNum+'" class="form-control" ' +
            'required style="background-color: white">' +
            '                </div>\n' +
            '            </div>';
        //вставляем поле с section_num
        $(this).parent().parent().siblings("header").html(htmlInsertHeader);
    }

    //выключение readonly для полей
    currentSection.find('input[name="section_plan_name"]').filter( ':first' ).removeAttr("readonly");
    currentSection.find('input[name="section_plan_desc"]').filter( ':first' ).removeAttr("readonly");
    currentSection.find('input[name="max_ball"]').filter(':first').removeAttr("readonly");
    currentSection.find('input[name="max_seminar_pass_ball"]').filter(':first').removeAttr("readonly");
    currentSection.find('input[name="max_lecture_ball"]').filter(':first').removeAttr("readonly");
    //вставка кнопки "Обновить информ. о разделе"
    var htmlUpdateBatton = '<button type="submit" class="ink-reaction btn btn-success" id="updateSection">Обновить информ. о разделе</button>';
    currentSection.find('.update_button_section').filter( ':first' ).html(htmlUpdateBatton);
});

//Обновление добаленного раздела
$(document).on('submit', '#form_update_section', function (event) {
    event.preventDefault();
    $.ajax({
        type: 'PATCH',
        url:   '/course_plan/section/update',
        data:  $(this).serialize(),
        success: function(data){
            console.log(data)
            var currentSection = $('#section'+data.idSectionPlan);
            if($.isEmptyObject(data.error)){
                var isExam = currentSection.find('#is_exam').filter( ':first' ).val();
                if(isExam == 0) {
                    var htmlInsertHeader = data.sectionNum +' Раздел';
                    //вставляем поле с section_num
                    var currentHeader = currentSection.find("header").filter( ':first' );
                    currentHeader.html(htmlInsertHeader);
                }
                //выключение readonly для полей
                currentSection.find('input[name="section_plan_name"]').filter( ':first' ).attr('readonly', true);
                currentSection.find('input[name="section_plan_desc"]').filter( ':first' ).attr('readonly', true);
                //удаление кнопки "Обновить доп. инфор о разделе"
                currentSection.find('.update_button_section').filter( ':first' ).empty();
                // удаление сообщений об ошибках
                var currentErrorDiv = currentSection.find('.print-error-msg').filter( ':first' );
                currentErrorDiv.find("ul").html('');
                currentErrorDiv.css('display','none');
                //отображение иконки редактировать
                currentSection.find('.activate_edit_section').filter( ':first' ).show();
            }else{
                //добавление в html сообщений об ошибках
                var divError = currentSection.find('.print-error-msg').filter( ':first' );
                divError.find("ul").html('');
                divError.css('display','block');
                $.each( data.error, function( key, value ) {
                    divError.find("ul").append('<li>'+value+'</li>');
                });
            }
        }
    });

});

//Удаление раздела
$(document).on('click', '.delete_section', function () {
    if (confirm("Удалить данный раздел ?")) {
        var currentSection = $(this).closest('.section');
        var idSectionPlan = parseInt(currentSection.attr('id').match(/\d+/));
        var idSectionPlanInput  = currentSection.find('input[name="id_section_plan"]').filter( ':first' ).val();
        if($.isEmptyObject(idSectionPlanInput)) {

            $('#section'+idSectionPlan).remove();

        } else {

            var token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'DELETE',
                url:   '/course_plan/section/delete',
                data:  {
                    "id_section_plan": idSectionPlan,
                    "_token": token},
                success: function(data){
                    $('#section'+data).remove();
                }
            });

        }
    }

});
