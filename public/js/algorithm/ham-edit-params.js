'use strict';
(function() {
    const hamEditParams = document.querySelector('.ham-edit-params');
    if (!hamEditParams) {
        return;
    }
    const tbDebug = hamEditParams.querySelector('.tb-debug');
    const tbRun = hamEditParams.querySelector('.tb-run');
    const tbSteps = hamEditParams.querySelector('.tb-steps');
    const btnApply = hamEditParams.querySelector('.btn-apply');

    btnApply.addEventListener('click', () => {
        const debugPercent = +tbDebug.value;
        const runPercent = +tbRun.value;
        const stepsPercent = +tbSteps.value;
        if (isNaN(debugPercent) || debugPercent < 0 || debugPercent > 100) {
            alert('Значение штрафа за проверку (нажатие "Проверить работу") должно быть от 0 до 100');
            return;
        }
        if (isNaN(runPercent) || runPercent < 0 || runPercent > 100) {
            alert('Значение штрафа за запуск должно быть от 0 до 100');
            return;
        }
        if (isNaN(stepsPercent) || stepsPercent < 0 || stepsPercent > 100) {
            alert('Значение штрафа за отладку (запу с шагами) должно быть от 0 до 100');
            return;
        }
        btnApply.disabled = true;
        $.ajax({
            cache: false,
            type: 'POST',
            url:   '/edit_ham_params_apply',
            beforeSend: function (xhr) {
                const token = $('meta[name="csrf-token"]').attr('content');
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            },
            data: {
                debugPercent: debugPercent,
                runPercent: runPercent,
                stepsPercent: stepsPercent,
                token: 'token'
            },
            success: function(data){
                btnApply.disabled = false;
                if (data.success === true) {
                    alert('Параметры успешно сохранены');
                } else {
                    alert('Что-то пошло не так =(');
                }
            },
            error: function (request, status, er) {
                btnApply.disabled = false;
                console.log(er);
                alert(`Ошибка: ${er.message}`);
            },
        });
    });
})();
