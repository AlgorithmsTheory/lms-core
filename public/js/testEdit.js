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

$('#create-extended-test').click(function(){
    $('#go-to-create-extended-test').val(1);
    $('.form').submit();
});

$('.btn-clone-test').click(function() {
    const testID = +document.querySelector('#id-test').value;
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/tests/clone',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { test_id: testID, token: 'token' },
        success: function(data){
            alert('Тест успешно склонирован');
        }
    });
});