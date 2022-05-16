'use strict';
(function() {
    const mt2EditParamsEl = document.querySelector('.mt2-edit-params');
    if (!mt2EditParamsEl) {
        return;
    }
    const tbDebug = mt2EditParamsEl.querySelector('.tb-debug');
    const tbSyntax = mt2EditParamsEl.querySelector('.tb-syntax');
    const tbRun = mt2EditParamsEl.querySelector('.tb-run');
    const btnApply = mt2EditParamsEl.querySelector('.btn-apply');

    btnApply.addEventListener('click', () => {
        const debugPercent = +tbDebug.value;
        const syntaxPercent = +tbSyntax.value;
        const runPercent = +tbRun.value;
        if (isNaN(debugPercent) || debugPercent < 0 || debugPercent > 100) {
            alert('Значение штрафа за отладку должно быть от 0 до 100');
            return;
        }
        if (isNaN(syntaxPercent) || syntaxPercent < 0 || syntaxPercent > 100) {
            alert('Значение штрафа за проверку синтаксиса должно быть от 0 до 100');
            return;
        }
        if (isNaN(runPercent) || runPercent < 0 || runPercent > 100) {
            alert('Значение штрафа за запуск должно быть от 0 до 100');
            return;
        }
        btnApply.disabled = true;
        $.ajax({
            cache: false,
            type: 'POST',
            url:   '/edit_mt_params_apply',
            beforeSend: function (xhr) {
                const token = $('meta[name="csrf-token"]').attr('content');
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            },
            data: {
                debugPercent: debugPercent,
                checkSyntaxPercent: syntaxPercent,
                runPercent: runPercent,
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
