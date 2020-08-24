
$('.was').on('change', function() {
    var thisCell = $(this).closest('td');
    var idControlWorkPass = thisCell.attr('id');
    var inputResultControlWork = thisCell.find('.result_control_work');
    var isPresence = false;
    myBlurFunction(1);
    if (this.checked) {
        isPresence = true;
    }
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/statements/result/mark_present',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { id_control_work_pass: idControlWorkPass, token: 'token', is_presence: isPresence },
        success: function(data){
            if (isPresence) {
                //Разблокирование input result_control_work при отметки присутствия
                inputResultControlWork.prop('disabled', false);
                myBlurFunction(0);
            } else {
                //Блокирование input classwork при отсутсвии студента на семинаре
                inputResultControlWork.prop('disabled', true);
                myBlurFunction(0);
            }

        }
    });
    return false;
});

$('.result_control_work').on('change', function() {
    var thisCell = $(this).closest('td');
    var thisRow = $(this).closest('tr');
    var idUser = thisRow.attr('id');
    var idControlWorkPass = thisCell.attr('id');
    var workStatus = thisCell.attr('data-status');
    var sectionNum = thisCell.attr('data-section_num');
    var points = $( this ).val();
    var idCoursePlan = $('table').attr('data-id-course_plan');
    //var idGroup = $('table').attr('data-id_group');
    myBlurFunction(1);
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/statements/result/control_work/change',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { id_control_work_pass: idControlWorkPass,
            token: 'token',
            control_work_points: points,
            id_course_plan: idCoursePlan,
            work_status: workStatus,
            section_num: sectionNum,
            id_user: idUser

        },
        success: function(data){
            myBlurFunction(0);
            var divError = $('.print-error-msg');
            if($.isEmptyObject(data.error)) {
                if (workStatus == 'section') {
                    var sectionResult = thisRow.find('td[data-result-section_num='+ sectionNum + ']');
                    sectionResult.text(data.sectionResult);
                    changeColorTd(sectionResult, data.sectionResult, sectionResult.attr('data-section-max_points'));
                    var sumResultSection = thisRow.find('.sum_result_section');
                    sumResultSection.text(data.sumResultSection);
                    changeColorTd(sumResultSection, data.sumResultSection, sumResultSection.attr('data-max_controls'));
                } else {
                    var sumResultExam = thisRow.find('.sum_result_exam');
                    sumResultExam.text(data.sumResultSection);
                    changeColorTd(sumResultExam, data.sumResultSection, sumResultExam.attr('data-max_exam'));
                }
                var resultAllCourse = thisRow.find('.result_all_course');
                resultAllCourse.text(data.resultAllCourse);
                changeColorTd(resultAllCourse,data.resultAllCourse, 100);
                var markBologna = thisRow.find('.mark_bologna');
                markBologna.text(data.markBologna);
                changeColorTd(markBologna,data.resultAllCourse, 100);
                var markRus = thisRow.find('.mark_rus');
                markRus.text(data.markRus);
                changeColorTd(markRus,data.resultAllCourse, 100);
                // удаление сообщений об ошибках
                divError.find("ul").html('');
                divError.css('display','none');
                thisCell.attr('style', 'border-color:rgba(163, 168, 168, 0.2);');
            } else {
                //добавление в html сообщений об ошибках
                divError.find("ul").html('');
                divError.css('display','block');
                $.each( data.error, function( key, value ) {
                    divError.find("ul").append('<li>'+value+'</li>');
                });
                thisCell.attr('style', 'border-color:#ff0000;');
            }
        }
    });
    return false;
});

function changeColorTd(td, currentPoints, maxPoints) {
    if (currentPoints < maxPoints * 0.6 &&
        td.hasClass('success')) {
        td.toggleClass('danger success');
    }
    if (currentPoints > maxPoints * 0.6 &&
        td.hasClass('danger')) {
        td.toggleClass('success danger');
    }
}


$(".all").click(function() {
    var idControlWorkPlan = $(this).attr('data-id-control_work');
    var idGroup = this.name;
    myBlurFunction(1);
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/statements/result/mark_present_all',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { id_control_work_plan: idControlWorkPlan, id_group: idGroup, token: 'token' },
        success: function(data){
            var cells = $('.was').closest('td');
            var sortedCells = cells.filter(function(index) {
                return $(this).attr('data-id-control_work') === idControlWorkPlan;
            });
            sortedCells.find('.was').prop( "checked", true );
            sortedCells.find('.result_control_work').prop('disabled', false);
            myBlurFunction(0);
        }
    });
    return false;
});

var myBlurFunction = function(state) {
    /* state can be 1 or 0 */
    var containerElement = document.getElementById('main_container');
    var overlayEle = document.getElementById('overlay');

    if (state) {
        var winHeight = $(window).height()/2 - 24;
        winHeight = winHeight.toString()

        overlayEle.style.display = 'block';
        overlayEle.style.top = winHeight.concat('px');
        containerElement.setAttribute('class', 'blur');
    } else {
        overlayEle.style.display = 'none';
        containerElement.setAttribute('class', null);
    }
};