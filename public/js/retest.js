/**
 * Created by Станислав on 15.03.16.
 */

var retestForm = $('#retest-form');

/** функция-хелпер для переноса значения из checkbox в hidden */
$('#retest-table').on('change', '.flag', function(){
    if ($(this).prop("checked"))                                                                                        //если галка стоит, то ставим в скрытое поле 1
        $(this).next().val(1);
    else $(this).next().val(0);                                                                                         //иначе 0
});

/** Вычисляет шаг штрафа в зависимости от значения поля */
function checkStep(value){
    if (value != 100)
        step = 5;
    else step = 10;
    return step;
}

/** Устанавливает шаг штрафа в зависимости от значения поля */
$(retestForm).on('load', '.fine-level', function(){
    $(this).attr('step', checkStep($(this).val()));
});

/** Проверка введенного значения штрафа */
$(retestForm).on('focusout', '.fine-level', function(){
    let allowable = [100, 90, 85, 80, 75, 70];                                                                          //массив разрешенных штрафов
    if (allowable.indexOf(parseInt($(this).val())) != -1){
        $(this).attr('step', checkStep($(this).val()));
    }
    else {
        alert('Вы ввели недопустимый штраф! Штраф должен быть выбран из набора '+allowable);
        $(this).focusin();
    }
});

$(retestForm).on('change', '#selected-student, #selected-test, #selected-group, #selected-mark', function(){
   filterAll();
});

/** Apply filter */
function filterAll() {
    let selectedStudent = $('#selected-student').val();
    let selectedGroup = $('#selected-group').val();
    let selectedTest = $('#selected-test').val();
    $('.fine-row').each(function () {
        let row = $(this);
        let student_filter = matchFilter(selectedStudent, $(row).children('.students').text());
        let group_filter = matchFilter(selectedGroup, $(row).children('.groups').text());
        let test_filter = matchFilter(selectedTest, $(row).children('.tests').text());
        let mark_filter = matchFilterMark($(row).children('.last-marks').text());

        if (!student_filter || !test_filter || !group_filter || !mark_filter) {
            $(this).css('display', 'none');
        }
        else {
            $(this).css('display', '');
        }
    })
}

/** Mark filter matcher */
function matchFilterMark(markValue) {
    let mark = $("#selected-mark").val();
    switch (mark) {
        case 'F':                                                                                                       //если выбрана F, то включаем туда еще и отсутствующих
            if (markValue != mark && markValue != 'Отсутствие') return false;
            else return true;
        case 'All':
        case '':
            return true;
        default:
            if (markValue != mark) return false;
            else return true;
    }
}

/** Student, group, test filter matcher */
function matchFilter(filterValue, rowValue) {
    switch (filterValue) {
        case 'All':
        case '':
            return true;
        default:
            if (rowValue != filterValue) return false;
            else return true;
    }
}





