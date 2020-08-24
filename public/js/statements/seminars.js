/**
 * Created by Misha on 31/03/16.
 */

$('.was').on('change', function() {
    var thisCell = $(this).closest('td');
    var idSeminarPass = thisCell.attr('id');
    var inputClassWork = thisCell.find('.classwork');
    var isPresence = false;
    myBlurFunction(1);
    if (this.checked) {
        isPresence = true;
    }
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/statements/seminar/mark_present',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { id_seminar_pass: idSeminarPass, token: 'token', is_presence: isPresence },
        success: function(data){
            if (isPresence) {
                //Разблокирование input classwork при отметки присутствия
                inputClassWork.prop('disabled', false);
                myBlurFunction(0);
            } else {
                inputClassWork.prop('disabled', true);
                inputClassWork.val(0);
                myBlurFunction(0);
            }

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

$(".all").click(function() {
    var idSeminarPlan = $(this).attr('data-id-seminar');
    var idGroup = this.name;
    myBlurFunction(1);
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/statements/seminar/mark_present_all',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { id_seminar_plan: idSeminarPlan, id_group: idGroup, token: 'token' },
        success: function(data){
            var cells = $('.was').closest('td');
            var sortedCells = cells.filter(function(index) {
                return $(this).attr('data-id-seminar') === idSeminarPlan;
            });
            sortedCells.find('.was').prop( "checked", true );
            sortedCells.find('.classwork').prop('disabled', false);
            myBlurFunction(0);
        }
    });
    return false;
});

$('.classwork').on('change', function() {
    var thisCell = $(this).closest('td');
    var idSeminarPass = thisCell.attr('id');
    var classWorkPoint = $( this ).val();
    var idCoursePlan = $('table').attr('data-id-course_plan');
    myBlurFunction(1);
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/statements/seminar/classwork/change',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { id_seminar_pass: idSeminarPass, token: 'token', class_work_point: classWorkPoint, id_course_plan: idCoursePlan },
        success: function(data){
            myBlurFunction(0);
            var divError = $('.print-error-msg');
            if($.isEmptyObject(data.error)) {
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