function updateRow(row, statement) {
    for (let section of statement.sections) {
        for (let control of section.controls) {
            const controlPassId = control.id;
            const controlTd = row.find(`td[data-id-control_work=${controlPassId}]`);
            controlTd.find('input[type=checkbox]').prop('checked', control.presence);
            const pointsInput = controlTd.find('input[type=number]');
            const pointsRounded = controlTd.find('.points-rounded')
            pointsRounded.text(control.points);
            pointsInput.val(control.points_raw);
            pointsInput.prop('disabled', !control.presence);
        }
        const sectionResultEl = row.find(`td[data-result-section_num=${section.section_num}]`);
        setColorTd(sectionResultEl, section.total_ok);
        sectionResultEl.text(section.total);
    }
    for (let exam of statement.exams) {
        const controlPassId = exam.id;
        const controlTd = row.find(`td[data-id-control_work=${controlPassId}]`);
        const presenceInput = controlTd.find('input[type=checkbox]');
        presenceInput.prop('checked', exam.presence);
        presenceInput.prop('disabled', !statement.sections_total_ok);
        const pointsInput = controlTd.find('input[type=number]');
        const pointsRounded = controlTd.find('.points-rounded')
        pointsRounded.text(exam.points);
        pointsInput.val(exam.points_raw);
        pointsInput.prop('disabled', !exam.presence || !statement.sections_total_ok);
    }
    const sectionsResultEl = row.find('.sum_result_section');
    setColorTd(sectionsResultEl, statement.sections_total_ok);
    sectionsResultEl.text(statement.sections_total);
    const sumResultExamEl = row.find('.sum_result_exam');
    const resultAllCourseEl = row.find('.result_all_course');
    const markBolognaEl = row.find('.mark_bologna');
    const markRusEl = row.find('.mark_rus');
    setColorTd(sumResultExamEl, statement.exams_total_ok);
    setColorTd(resultAllCourseEl, statement.summary_total_ok);
    setColorTd(markBolognaEl, statement.summary_total_ok);
    setColorTd(markRusEl, statement.summary_total_ok);
    sumResultExamEl.text(statement.exams_total);
    resultAllCourseEl.text(statement.summary_total);
    markBolognaEl.text(statement.mark_bologna);
    markRusEl.text(statement.mark_rus);
}


$('.was').on('change', function() {
    var thisCell = $(this).closest('td');
    var thisRow = $(this).closest('tr');
    var idControlWorkPass = thisCell.attr('id');
    var isPresence = false;
    var idUser = thisRow.attr('id');
    var idCoursePlan = $('table').attr('data-id-course_plan');
    myBlurFunction(1);
    if (this.checked) {
        isPresence = true;
    }
    var data = { id_control_work_pass: idControlWorkPass, token: 'token', is_presence: isPresence,
        id_user: idUser, id_course_plan: idCoursePlan};
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
        data: data,
        success: function(data){
            myBlurFunction(0);
            updateRow(thisRow, data.statement);
        }
    });
    return false;
});

$('.result_control_work').on('change', function handleChange() {
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
            updateRow(thisRow, data.statement);
        }
    });
    return false;
});

$('.print_to_pdf').on('click', ()=>{
    let mywindow = window.open('', 'PRINT', 'height=650,width=900,top=100,left=150');

    mywindow.document.write(`<html><head><title></title>`);
    mywindow.document.write(`</head><body style="border: 2px solid black;">`);
    var printNode = document.getElementById('statement').cloneNode(true);
    printNode.getElementsByClassName('table')[0].setAttribute('border', '1')
    printNode.removeChild(printNode.getElementsByClassName('print_to_pdf')[0])
    //printNode.width = 800;
    //printNode.height = 650;
    //printNode.getElementsByClassName('table').width = 800;
    // tra = printNode.getElementsByClassName('functionalty_tr')[0]
    //var pTra = tra.parentNode;
    //pTra.remove(tra);
    mywindow.document.write(printNode.innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();
});

// Сгенерировать ведомость
$('.btn-gen-statement').on('click', function(ev){
    // Тип ведомости:
    // 1. credit - зачёт
    // 2. credit-with-grade - зачёт с оценкой
    // 3. exam - экзамен
    // 4. section-evaluation - аттестация разделов
    const type = ev.currentTarget.dataset.type;
    var group = $("#group_num").val();
    myBlurFunction(1);
    var formData = new FormData();
    formData.set('file', document.getElementById("image-file").files[0] ,'v.xlsx');
    formData.set('filename', "v.xlsx" );
    formData.set('group', group);
    formData.set('type', type)
    $.ajax({
        type: 'POST',
        url:   '/statements/gen-statement',
        processData: false,  // tell jQuery not to process the data
        contentType: false,  // tell jQuery not to set contentType
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
            formData.append('token',token);
        },
        data: formData,
        dataType: 'binary',
        xhrFields: {
            'responseType': 'blob'
        },
        success: function(data){
            myBlurFunction(0);
            var link = document.createElement('a')
            filename = 'file.xlsx';
            link.href = URL.createObjectURL(data);
            link.download = filename;
            link.click();
        }
    });
    return false;
});

function setColorTd(td, isGood) {
    if (isGood) {
        td.addClass('success');
        td.removeClass('danger');
    } else {
        td.removeClass('success');
        td.addClass('danger');
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