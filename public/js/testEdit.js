/**
 * Created by Станислав on 16.05.16.
 */

    /** Действия по сабмиту */
$('#edit-test-structure').click(function(){
    $('#go-to-edit-structure').val(1);
    $('.form').submit();
});

$('.finish-test-for-group').click(function () {
    if (confirm("Вы уверены, что хотите завершить тест для выбранной группы?")) {
        $(this).parent('td').find('a')[0].click();
    }

});

$('#finish-test').click(function () {
    if (confirm("Вы уверены, что хотите завершить тест для всех групп?")) {
        $(this).parent('div').find('a')[0].click();
    }
});

$('#adaptive').change(function () {
    let maxQuestions = $('#max_questions');
    if ($(this).prop('checked')) {
        maxQuestions.prop('disabled', false);
        maxQuestions.val(10);
    }
    else {
        maxQuestions.prop('disabled', true);
        maxQuestions.val(null);
    }
});