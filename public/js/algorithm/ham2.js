function createHam2(containerEl) {
    function qs(selector) { return containerEl.querySelector(selector); }

    const newWordEl = qs('.ham2-new-word');
    const alphabetEl = qs('.ham2-alphabet');
    const listSectionRowsEl = qs('.ham2-list-section-rows');
    const examplesButtonsWrapperEl = qs('.ham2-examples-buttons-wrapper');
    const syntaxSuccessEl = qs('.ham2-syntax-success');
    const errorsEl = qs('.ham2-errors');
    const startBtnEl = qs('.ham2-start-btn');
    const stepBtnEl = qs('.ham2-step-btn');
    const placeWordBtnEl = qs('.ham2-place-word-btn');
    const clearTapeBtnEl = qs('.ham2-clear-tape-btn');
    const toFirstStateEl = qs('.ham2-to-first-state');
    const checkBtnEl = qs('.ham2-check-btn');
    const listAddRowBtn = qs('.ham2-list-add-row-btn');
    const algoNameWrapperEl = qs('.ham2-algo-name-wrapper');
    const algoNameEl = qs('.ham2-algo-name');
    const importInput = qs('.ham2-import-input');
    const exportBtn = qs('.ham2-export-btn');
    const exportApplyBtn = qs('.ham2-export-apply-btn');
    const currentWordEl = qs('.ham2-current-word');
    const algoCommentEl = qs('.ham2-algo-comment');
    // can be null. If not null then emulator is used inside the test
    const formEl = newWordEl.closest('form');

    const ce = document.createElement.bind(document);
    let canTapeBeChanged = true;
    const lastCommandSymbol = '•';
    const lambdaSymbol = 'Λ';
    const removingSymbol = '_';
    newWordEl.value = '';
    let alphabet = ['a', 'b'];
    const lambdaSymbolAbbr = '\\l';
    const lastCommandSymbolAbbr = '\\o';
    let currentWord = '';

    let list = [
        {
            source: `${lambdaSymbol}`,
            dest: `${lambdaSymbol}${lastCommandSymbol}`,
        },
    ];

    const examples = [
        {
            title: 'Удвоение числа x-ов',
            alphabet: `#x`,
            word: `xx`,
            list: [
                {
                    source: '#x',
                    dest: 'xx#',
                },
                {
                    source: '#',
                    dest: `${removingSymbol}${lastCommandSymbol}`,
                },
                {
                    source: lambdaSymbol,
                    dest: '#',
                },
            ],
        },
    ];

    function qsaIndexOf(qsaResult, searchTarget) {
        for (let i = 0; i < qsaResult.length; i++) {
            if (qsaResult[i] === searchTarget) {
                return i;
            }
        }
        return -1;
    }

    function placeWordHandler() {
        if (!canTapeBeChanged)
        {
            return;
        }
        const word = newWordEl.value;
        setCurrentWord(word);
    }

    function clearTapeHandler() {
        if (!canTapeBeChanged)
        {
            return;
        }
        setCurrentWord('');
    }

    function alphabetInputHandler(ev) {
        let val = ev.target.value;
        alphabet = [...new Set(val.split(''))];
        ev.target.value = alphabet.join('');
        setStepStartButtonsEnabled(false);
    }

    function createListRow(source, dest) {
        const res = document.createElement('div');
        res.classList.add('ham2-list-row');
        const inputFrom = document.createElement('input');
        const arrowEl = document.createElement('span');
        const inputTo = document.createElement('input');

        const trash = document.createElement('button');
        trash.type = 'button';
        trash.classList.add('ham2-list-row-remove-btn');
        const trashIcon = document.createElement('i');
        trashIcon.classList.add('fa', 'fa-trash');
        trash.append(trashIcon);
        trash.tabIndex = -1;

        const up = document.createElement('button');
        up.type = 'button';
        up.classList.add('ham2-list-row-up-btn');
        up.textContent = '↑';
        up.tabIndex = -1;

        const down = document.createElement('button');
        down.type = 'button';
        down.classList.add('ham2-list-row-down-btn');
        down.textContent = '↓';
        down.tabIndex = -1;

        inputFrom.type = 'text';
        inputTo.type = 'text';
        inputFrom.classList.add('ham2-list-row-input-from');
        arrowEl.classList.add('ham2-list-row-arrow');
        inputTo.classList.add('ham2-list-row-input-to');
        inputFrom.value = source;
        arrowEl.textContent = '→';
        inputTo.value = dest;
        res.append(inputFrom);
        res.append(arrowEl);
        res.append(inputTo);
        res.append(trash);
        res.append(up);
        res.append(down);
        return res;
    }

    function generateList() {
        listSectionRowsEl.innerHTML = '';
        for (let rowInfo of list) {
            const listRow = createListRow(rowInfo.source, rowInfo.dest);
            listSectionRowsEl.append(listRow);
        }
    }

    function fillAlphabetInput() {
        alphabetEl.value = alphabet.join('');
    }

    function reflectListOnListInputBlurHandler(ev) {
        const inputFrom = ev.target.closest('.ham2-list-row-input-from');
        const inputTo = ev.target.closest('.ham2-list-row-input-to');
        let input;
        let isInputFrom = false;
        if (inputFrom) {
            input = inputFrom;
            isInputFrom = true;
        } else if (inputTo) {
            input = inputTo;
        } else {
            return;
        }
        const row = input.closest('.ham2-list-row');
        const ind = qsaIndexOf(listSectionRowsEl.querySelectorAll('.ham2-list-row'), row);
        if (ind < 0) {
            return;
        }
        if (isInputFrom) {
            list[ind].source = input.value;
        } else {
            list[ind].dest = input.value;
        }
        setStepStartButtonsEnabled(false);
    }

    function cloneList(list) {
        const res = [];
        for (let row of list) {
            res.push(Object.assign({}, row));
        }
        return res;
    }

    function applyExample(ind) {
        const example = examples[ind];
        alphabet = example.alphabet.split('');
        list = cloneList(example.list);
        alphabetEl.value = example.alphabet;
        newWordEl.value = example.word;
        setCurrentWord('');
        generateList();
        setStepStartButtonsEnabled(false);
    }

    function addExamplesButtons() {
        examplesButtonsWrapperEl.innerHTML = '';
        for (let example of examples) {
            const el = ce('button');
            el.type = 'button';
            el.classList.add('ham2-example-btn', 'btn', 'btn-secondary');
            el.textContent = example.title;
            examplesButtonsWrapperEl.append(el);
            examplesButtonsWrapperEl.append(' ');
        }
    }

    function examplesButtonsWrapperClickHandler(ev) {
        const buttonEl = ev.target.closest('button');
        if (!buttonEl) {
            return;
        }
        const buttons = buttonEl.closest('.ham2-examples-buttons-wrapper').querySelectorAll('button');
        let ind = 0;
        for (let i = 0; i < buttons.length; i++) {
            if (buttons[i] === buttonEl) {
                ind = i;
                break;
            }
        }
        applyExample(ind);
    }

    function setCurrentWord(word) {
        currentWord = word.replaceAll(lambdaSymbol, '');
        currentWordEl.textContent = currentWord;
    }

    // returns true if it is the last command
    function makeStep() {
        for (const row of list) {
            let source = row.source;
            let dest = row.dest;
            if (source === '') {
                continue;
            }
            let sourceIsLambda = false;
            if (source.length > 0) {
                sourceIsLambda = true;
                for (const symb of source) {
                    if (symb !== lambdaSymbol) {
                        sourceIsLambda = false;
                    }
                }
            }
            source = source.replaceAll(lambdaSymbol, '');
            if (!sourceIsLambda && !currentWord.includes(source)) {
                continue;
            }
            const isLastCommand = dest.includes(lastCommandSymbol);
            const isRemovingRule = dest.includes(removingSymbol);
            if (isRemovingRule) {
                dest = '';
            } else {
                dest = dest.replaceAll(lastCommandSymbol, '')
                    .replaceAll(lambdaSymbol, '');
            }
            if (sourceIsLambda) {
                currentWord = dest + currentWord;
            } else {
                currentWord = currentWord.replace(source, dest);
            }
            setCurrentWord(currentWord);
            return isLastCommand;
        }
        return true;
    }

    function setTapeEnabled(value) {
        canTapeBeChanged = value;
        placeWordBtnEl.disabled = !value;
        clearTapeBtnEl.disabled = !value;
    }

    function stepButtonClickHandler() {
        if (checkErrors()) {
            if (formEl) {
                checkAnswer('btnStep', formEl, false);
            }
            return;
        }
        setTapeEnabled(false);
        const isLast = makeStep();
        setCurrentWord(currentWord);
        if (isLast) {
            setStepStartButtonsEnabled(false);
        }
    }

    function startButtonClickHandler() {
        if (checkErrors()) {
            if (formEl) {
                checkAnswer('btnRun', formEl, true);
            }
            return;
        }
        setTapeEnabled(false);
        let itersCount = 500;
        let stopReason = 'too-many-commands';
        for (let i = 0; i < itersCount; i++) {
            const isLast = makeStep();
            if (isLast) {
                stopReason = 'successful-finish';
                break;
            }
        }
        if (stopReason === 'too-many-commands') {
            alert(`Машина была остановлена, т.к. за ${itersCount} команд не было найдено последней команды.`);
        }
        setStepStartButtonsEnabled(false);
        if (formEl) {
            checkAnswer('btnRun', formEl, true);
        }
    }

    function toFirstStateButtonClickHandler() {
        setTapeEnabled(true);
        setCurrentWord(newWordEl.value);
        setStepStartButtonsEnabled(true);
    }

    function getErrors() {
        const res = [];
        for (let i = 0; i < list.length; i++) {
            const row = list[i];
            for (const letter of row.source) {
                if (!alphabet.includes(letter) && letter !== lambdaSymbol) {
                    res.push(`Правило №${i + 1} (левая часть) содержит символ не из алфавита: ${letter}`);
                }
            }
            for (const letter of row.dest) {
                if (!alphabet.includes(letter) && letter !== lambdaSymbol && letter !== lastCommandSymbol
                    && letter !== removingSymbol) {
                    res.push(`Правило №${i + 1} (правая часть) содержит символ не из алфавита: ${letter}`);
                }
            }
        }
        return res;
    }

    // returns true if errors were detected
    function checkErrors() {
        const errors = getErrors();
        if (errors.length <= 0) {
            clearErrors();
        } else {
            showErrors(errors);
        }
        return errors.length > 0;
    }

    function checkBtnClickHandler() {
        checkErrors();
        if (formEl) {
            checkAnswer('btnCheckSyntax', formEl, true);
        }
    }

    function clearErrors() {
        errorsEl.innerHTML = '';
        syntaxSuccessEl.style.display = '';
    }

    function showErrors(errors) {
        errorsEl.innerHTML = '';
        syntaxSuccessEl.style.display = errors.length > 0 ? 'none' : '';
        for (let error of errors) {
            const pEl = ce('p');
            pEl.classList.add('.ham2-error');
            pEl.textContent = error;
            errorsEl.append(pEl);
        }
    }

    function setStepStartButtonsEnabled(value) {
        startBtnEl.disabled = !value;
        stepBtnEl.disabled = !value;
        if (!value) {
            syntaxSuccessEl.style.display = 'none';
        }
    }

    function newWordInputHandler(ev) {
        const t = ev.target;
        let v = t.value;
        v = v.replace(lambdaSymbolAbbr, lambdaSymbol);
        t.value = v;
    }

    function listAddRowClickHandler() {
        listAddRow();
    }

    function listAddRow() {
        const row = createListRow('', '');
        listSectionRowsEl.append(row);
        list.push({
            source: '',
            dest: '',
        });
        return row;
    }

    function inputFromEnterHandler(ev, inputFrom) {
        if (ev.shiftKey) {
            return;
        }
        if (ev.key !== 'Enter') {
            return;
        }
        ev.preventDefault();
        const ind = qsaIndexOf(listSectionRowsEl.querySelectorAll('.ham2-list-row-input-from'), inputFrom);
        if (ind < 0) {
            return;
        }
        listSectionRowsEl.querySelectorAll('.ham2-list-row-input-to')[ind].focus();
    }

    function inputToTabEnterHandler(ev, inputTo) {
        if (ev.shiftKey) {
            return;
        }
        if (!['Enter', 'Tab'].includes(ev.key)) {
            return;
        }
        ev.preventDefault();
        const ind = qsaIndexOf(listSectionRowsEl.querySelectorAll('.ham2-list-row-input-to'), inputTo);
        if (ind < 0) {
            return;
        }
        const fromEls = listSectionRowsEl.querySelectorAll('.ham2-list-row-input-from');
        if (ind + 1 < fromEls.length) {
            fromEls[ind + 1].focus();
        } else {
            const row = listAddRow();
            row.querySelector('.ham2-list-row-input-from').focus();
        }
    }

    function listInputsTabEnterHandler(ev) {
        const inputFrom = ev.target.closest('.ham2-list-row-input-from');
        const inputTo = ev.target.closest('.ham2-list-row-input-to');
        if (inputFrom) {
            inputFromEnterHandler(ev, inputFrom);
        } else if (inputTo) {
            inputToTabEnterHandler(ev, inputTo);
        }
    }

    function listInputsRewriteAbbrs(ev) {
        const inputFrom = ev.target.closest('.ham2-list-row-input-from');
        const inputTo = ev.target.closest('.ham2-list-row-input-to');
        let input;
        if (inputFrom) {
            input = inputFrom;
        } else if (inputTo) {
            input = inputTo;
        } else {
            return;
        }
        input.value = input.value.replace(lambdaSymbolAbbr, lambdaSymbol)
            .replace(lastCommandSymbolAbbr, lastCommandSymbol);
    }

    function listRowButtonClicks(ev) {
        const btn = ev.target.closest('button');
        if (!btn) {
            return;
        }
        const cl = btn.classList;
        const isRem = cl.contains('ham2-list-row-remove-btn');
        const isUp = cl.contains('ham2-list-row-up-btn');
        const isDown = cl.contains('ham2-list-row-down-btn');
        if (!isRem && !isUp && !isDown) {
            return;
        }
        const listRow = btn.closest('.ham2-list-row');
        const listRows = listSectionRowsEl.querySelectorAll('.ham2-list-row');
        const ind = qsaIndexOf(listRows, listRow);
        if (ind < 0) {
            return;
        }
        if (isRem) {
            listRow.remove();
            list.splice(ind, 1);
        } else if (isUp) {
            if (ind <= 0) {
                return;
            }
            listRow.parentNode.insertBefore(listRow, listRow.previousElementSibling);
            const item = list.splice(ind, 1)[0];
            list.splice(ind - 1, 0, item);
        } else if (isDown) {
            if (ind >= listRows.length - 1) {
                return;
            }
            listRow.parentNode.insertBefore(listRow.nextElementSibling, listRow);
            const item = list.splice(ind, 1)[0];
            list.splice(ind + 1, 0, item);
        }
    }

    function saveFile(filename, text) {
        const element = document.createElement('a');
        element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
        element.setAttribute('download', filename);
        element.style.display = 'none';
        document.body.appendChild(element);
        element.click();
        document.body.removeChild(element);
    }

    function algoNameWrapperClick(ev) {
        if (ev.target == algoNameWrapperEl) {
            algoNameWrapperEl.style.display = 'none';
        }
    }

    function exportBtnClick() {
        algoNameEl.value = '';
        algoNameWrapperEl.style.display = '';
    }

    function exportApplyBtnClick() {
        algoNameWrapperEl.style.display = 'none';
        const algoName = algoNameEl.value;
        const exportData = {
            algoName: algoName,
            comment: algoCommentEl.value,
            newWord: newWordEl.value,
            alphabet: alphabet,
            list: list,
        };
        const data = JSON.stringify(exportData);
        saveFile(`${algoName}.json`, data);
    }

    function importInputChangeHandler(ev) {
        const file = ev.target.files[0];
        if (!file) {
            return;
        }
        const reader = new FileReader();
        reader.onload = function(ev) {
            const contents = ev.target.result;
            applyImportedData(JSON.parse(contents+''));
            importInput.value = '';
        };
        reader.readAsText(file);
    }

    function applyImportedData(data) {
        const d = data;
        if (!d || d.algoName === undefined || d.newWord === undefined || !d.alphabet || !d.list) {
            alert('Неверный формат файла для импорта');
            return;
        }
        algoNameEl.value = d.algoName;
        algoCommentEl.value = d.comment;
        newWordEl.value = d.newWord;
        alphabet = d.alphabet;
        list = d.list;
        fillAlphabetInput();
        generateList();
        setStepStartButtonsEnabled(false);
    }

    function start() {
        listAddRowBtn.addEventListener('click', listAddRowClickHandler);
        listSectionRowsEl.addEventListener('keydown', listInputsTabEnterHandler);
        listSectionRowsEl.addEventListener('input', listInputsRewriteAbbrs);
        listSectionRowsEl.addEventListener('click', listRowButtonClicks);
        listSectionRowsEl.addEventListener('focusout', reflectListOnListInputBlurHandler)
        newWordEl.addEventListener('input', newWordInputHandler);
        placeWordBtnEl.addEventListener('click', placeWordHandler);
        clearTapeBtnEl.addEventListener('click', clearTapeHandler);
        alphabetEl.addEventListener('input', alphabetInputHandler);
        exportBtn.addEventListener('click', exportBtnClick);
        exportApplyBtn.addEventListener('click', exportApplyBtnClick);
        algoNameWrapperEl.addEventListener('click', algoNameWrapperClick)
        importInput.addEventListener('change', importInputChangeHandler, false);
        fillAlphabetInput();
        generateList();
        if (examplesButtonsWrapperEl) {
            addExamplesButtons();
        }

        if (examplesButtonsWrapperEl) {
            examplesButtonsWrapperEl.addEventListener('click', examplesButtonsWrapperClickHandler);
        }
        stepBtnEl.addEventListener('click', stepButtonClickHandler);
        startBtnEl.addEventListener('click', startButtonClickHandler);
        toFirstStateEl.addEventListener('click', toFirstStateButtonClickHandler);
        checkBtnEl.addEventListener('click', checkBtnClickHandler);

        return checking();
    }

    // buttonCode: 'btnDebug'|'btnCheckSyntax'|'btnRun'|'btnStep'
    function checkAnswer(buttonCode, formEl, notice) {
        const testId = +document.querySelector('#id_test').value;

        const counterEl = formEl.querySelector('[name=counter]');
        const numEl = formEl.querySelector('[name=num]');
        const debugCounterEl = formEl.querySelector('[name=debug_counter]');
        const taskEl = formEl.querySelector('[name=task]');
        const task = JSON.stringify({
            list: list,
            alphabet: alphabet,
        });
        taskEl.value = task;

        if (notice) {
            if (!['btnDebug', 'btnCheckSyntax', 'btnRun'].includes(buttonCode)) {
                return;
            }

            $.ajax({
                cache: false,
                type: 'POST',
                url:   '/algorithm/HAM2Check',
                beforeSend: function (xhr) {
                    const token = $('meta[name="csrf_token"]').attr('content');

                    if (token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                data: { counter: +counterEl.value,
                    task_id: +numEl.value,
                    test_id: testId,
                    task: task,
                    buttonCode: buttonCode,
                    token: 'token' },
                success: function(data){
                    if (buttonCode === 'btnDebug') {
                        const sequences_true = data['choice']['sequences_true'];
                        const sequences_all = data['choice']['sequences_all'];
                        const debug_counter = data['choice']['debug_counter'];
                        const check_syntax_counter = data['choice']['check_syntax_counter'];
                        const run_counter = data['choice']['run_counter'];

                        debugCounterEl.value = debug_counter;

                        alert(`Текущий результат отправки: ${sequences_true} тестов сработало из ${sequences_all}.\n` +
                            `Количество нажатий "Проверить работу": ${debug_counter}\n` +
                            `Количество нажатий "Проверить синтаксис": ${check_syntax_counter}\n` +
                            `Количество нажатий "Запустить": ${run_counter}`);
                    } else {
                        const debug_counter = data['debug_counter'];
                        const check_syntax_counter = data['check_syntax_counter'];
                        const run_counter = data['run_counter'];
                        alert(`Количество нажатий "Проверить работу": ${debug_counter}\n` +
                            `Количество нажатий "Проверить синтаксис": ${check_syntax_counter}\n` +
                            `Количество нажатий "Запустить": ${run_counter}`);
                    }
                }
            });
        }
    }

    function checking() {
        if (!formEl) {
            return () => {};
        }
        const btnCheckAnswerEl = formEl.querySelector('.btn-check-answer');
        if (!btnCheckAnswerEl) {
            return () => {};
        }

        btnCheckAnswerEl.addEventListener('click', () => checkAnswer('btnDebug', formEl, true));
        return () => {
            checkAnswer('btnDebug', formEl, false);
        };
    }

    return start();
}

$(() => {
    const allSubmitItFuncs = [];
    for (let containerEl of document.querySelectorAll('.ham2-container')) {
        const submitIt = createHam2(containerEl);
        allSubmitItFuncs.push(submitIt);
    }

    window.ham2SubmitAllTasks = () => {
        for (let foo of allSubmitItFuncs) {
            foo();
        }
    };
});
