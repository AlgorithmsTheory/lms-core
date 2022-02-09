/**
 * Created by Станислав on 07.04.16.
 */

/** Заполняет скрытые поля в зависимсоти от поставленной галочки */
$('#edit-list').on('change', '.visibility, .only_for_print, .multilanguage', function(){
    myBlurFunction(1);
    var tr = $(this).parents('tr');
    var testId = $(tr).find('.id-test').val();
    var visibility = $(tr).find('.visibility').prop('checked') ? 1 : 0;
    var onlyForPrint = $(tr).find('.only_for_print').prop('checked') ? 1 : 0;
    var multilanguage = $(tr).find('.multilanguage').prop('checked') ? 1 : 0;
    $.ajax({
        cache: false,
        type: 'POST',
        url:   '/tests/update-general-settings',
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { id_test: testId, visibility: visibility, only_for_print: onlyForPrint, multilanguage: multilanguage },
        success: function(){
            myBlurFunction(0);
        }
    });
});

var myBlurFunction = function(state) {
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

// testType should be 'control' or 'train'
function makeUnavailable(testType) {
    if (!confirm('Вы уверены, что хотите сделать все тесты недоступными?')) {
        return;
    }
    myBlurFunction(1);
    $.ajax({
        cache: false,
        type: 'POST',
        url:   `/tests/make-all-${testType}-tests-unavailable`,
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: { },
        success: function(){
            const requiredTable = document.querySelector(`.${testType}-tests-table`);
            if (requiredTable) {
                let isFirst = true;
                for (let row of requiredTable.rows) {
                    if (isFirst) {
                        isFirst = false;
                        continue;
                    }
                    row.style.backgroundColor = '#faeaea';
                }
            }
            myBlurFunction(0);
        }
    });
}

$('.btn-unavailable-all-control-tests').on('click', function(){
    makeUnavailable('control');
});

$('.btn-unavailable-all-train-tests').on('click', function(){
    makeUnavailable('train');
});
