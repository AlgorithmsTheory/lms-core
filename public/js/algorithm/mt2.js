function createMt2(containerEl) {
    function qs(selector) { return containerEl.querySelector(selector); }

    const tapeContentEl = qs('.mt2-tape-content');
    const newWordEl = qs('.mt2-new-word');
    const tableEl = qs('.mt2-table');
    const alphabetEl = qs('.mt2-alphabet');
    const examplesButtonsWrapperEl = qs('.mt2-examples-buttons-wrapper');
    const currentStateEl = qs('.mt2-current-state');
    const syntaxSuccessEl = qs('.mt2-syntax-success');
    const errorsEl = qs('.mt2-errors');
    const startBtnEl = qs('.mt2-start-btn');
    const stepBtnEl = qs('.mt2-step-btn');
    const tapeLeftEl = qs('.mt2-tape-left');
    const tapeRightEl = qs('.mt2-tape-right');
    const placeWordBtnEl = qs('.mt2-place-word-btn');
    const clearTapeBtnEl = qs('.mt2-clear-tape-btn');
    const toFirstStateEl = qs('.mt2-to-first-state');
    const checkBtnEl = qs('.mt2-check-btn');
    const formEl = tapeContentEl.closest('form'); // can be null. If not null then emulator is used inside the test




    const ce = document.createElement.bind(document);
    let canTapeBeChanged = true;
    let visibleTapeStartPos = 0;
    let tapePos = 0;
    const stateSymbol = 'S';
    const lastCommandSymbol = 'Ω';
    const firstSymbol = '∂';
    const lambdaSymbol = 'λ';
    const RSymbol = 'R';
    const LSymbol = 'L';
    const NSymbol = 'H';
    newWordEl.value = firstSymbol;
    let tape = {
        0: firstSymbol,
    };
    let alphabet = [firstSymbol, 'a', 'b'];
    const firstState = `${stateSymbol}0`;
    let currentState = firstState;
    const lastCommandSymbolAbbr = '\\o';
    const lambdaSymbolAbbr = '\\l';
    const firstSymbolAbbr = '\\d';
    currentStateEl.textContent = firstState;

    let automaton = [
        {
            state: `${stateSymbol}0`,
            expressions: {
            },
        },
    ];

    const examples = [
        {
            title: 'Инверсия слова',
            alphabet: `${firstSymbol}ab`,
            word: `${firstSymbol}aba`,
            automaton: [
                {
                    state: `${stateSymbol}0`,
                    expressions: {
                        [firstSymbol]: RSymbol,
                        'a': `b ${RSymbol} ${stateSymbol}0`,
                        'b': `a ${RSymbol} ${stateSymbol}0`,
                        [lambdaSymbol]: `${lambdaSymbol} ${NSymbol} ${lastCommandSymbol}`,
                    }
                },
            ]
        },
    ];

    function createTapeCell(tapeSuperIndex) {
        const res = ce('input');
        res.type = 'text';
        res.placeholder = lambdaSymbol;
        if (tapeSuperIndex in tape) {
            res.value = tape[tapeSuperIndex];
        }
        if (tapePos === tapeSuperIndex) {
            res.style.backgroundColor = '#b3ffb4';
        }
        res.classList.add('mt2-tape-cell');
        if (!canTapeBeChanged) {
            res.disabled = true;
        }
        return res;
    }

    function refillTape() {
        const tapeCellWidth = 40;
        const tapeCellCount = tapeContentEl.offsetWidth / tapeCellWidth;
        tapeContentEl.innerHTML = '';
        for (let i = 0; i < tapeCellCount; i++) {
            const tapeCell = createTapeCell(visibleTapeStartPos + i);
            tapeContentEl.append(tapeCell);
        }
    }

    function qsaIndexOf(qsaResult, searchTarget) {
        for (let i = 0; i < qsaResult.length; i++) {
            if (qsaResult[i] === searchTarget) {
                return i;
            }
        }
        return -1;
    }

    function getCells() {
        return tapeContentEl.querySelectorAll('.mt2-tape-cell');
    }

    function placeWord(cell, word) {
        const cells = getCells();
        const ind = qsaIndexOf(cells, cell);
        if (ind === -1) {
            return;
        }
        const letters = word.split('');
        let realInd = ind;
        if (word) {
            tape[visibleTapeStartPos + realInd] = word;
        } else {
            delete tape[visibleTapeStartPos + realInd];
        }
        for (let i = 0; i < letters.length; i++) {
            if (ind + i >= cells.length) {
                break;
            }
            realInd = ind + i;
            cells[realInd].value = letters[i];
            tape[visibleTapeStartPos + realInd] = letters[i];
        }
        const requireFocusInd = ((realInd + 1) < cells.length && letters.length > 0) ? realInd + 1 : realInd;
        cells[requireFocusInd].focus();
        cells[requireFocusInd].select();
    }

    function tapeInputHandler(ev) {
        const tapeCell = ev.target.closest('.mt2-tape-cell');
        if (!tapeCell) {
            return;
        }
        if (!canTapeBeChanged) {
            return;
        }
        placeWord(tapeCell, tapeCell.value);
    }

    function tapeLeftHandler() {
        if (visibleTapeStartPos > 0) {
            visibleTapeStartPos--;
            refillTape();
        }
    }

    function tapeRightHandler() {
        visibleTapeStartPos++;
        refillTape();
    }

    function placeWordHandler() {
        if (!canTapeBeChanged)
        {
            return;
        }
        const word = newWordEl.value;
        const letters = word.split('');
        tape = {};
        for (let i = 0; i < letters.length; i++) {
            const realInd = /* tapePos + */ i;
            tape[realInd] = letters[i];
        }
        refillTape();
    }

    function clearTapeHandler() {
        if (!canTapeBeChanged)
        {
            return;
        }
        tape = {};
        refillTape();
    }

    function tapeDblClickHandler(ev) {
        if (!canTapeBeChanged) {
            return;
        }
        const tapeCell = ev.target.closest('.mt2-tape-cell');
        if (!tapeCell) {
            return;
        }
        const ind = qsaIndexOf(getCells(), tapeCell);
        if (ind === -1) {
            return;
        }
        tapePos = visibleTapeStartPos + ind;
        refillTape();
    }

    function alphabetInputHandler(ev) {
        let val = ev.target.value;
        val = val.replace(firstSymbolAbbr, firstSymbol);
        if (val.length <= 0 || val[0] !== firstSymbol) {
            val = firstSymbol + val;
        }
        alphabet = [...new Set(val.split(''))];
        ev.target.value = alphabet.join('');
        removeNonAlphaColumnsFromAutomaton();
        generateTable();
        setStepStartButtonsEnabled(false);
    }

    function removeNonAlphaColumnsFromAutomaton() {
        for (let item of automaton) {
            const badSymbols = [];
            for (let ch in item.expressions) {
                if (!alphabet.includes(ch) && ch !== lambdaSymbol) {
                    badSymbols.push(ch);
                }
            }
            for (let ch of badSymbols) {
                delete item.expressions[ch];
            }
        }
    }

    function addHeaderCell(headRow, text) {
        const thEl = ce('th');
        thEl.textContent = text;
        headRow.append(thEl);
    }

    function addHeaderCellAsHtml(headRow, htmlText) {
        const thEl = ce('th');
        thEl.innerHTML = htmlText;
        headRow.append(thEl);
    }

    function addCellWithInput(tableRow, value) {
        const td = tableRow.insertCell();
        const inputEl = ce('input');
        inputEl.type = 'text';
        inputEl.placeholder = NSymbol;
        inputEl.value = value;
        td.append(inputEl);
    }

    function generateTable() {
        tableEl.innerHTML = '';
        const theadEl = ce('thead');
        const headRow = ce('tr');
        theadEl.append(headRow);
        addHeaderCellAsHtml(headRow, 'Состояние <button type="button">+</button>');
        for (let letter of alphabet) {
            addHeaderCell(headRow, letter);
        }
        addHeaderCell(headRow, lambdaSymbol);
        tableEl.append(theadEl);
        const tbodyEl = ce('tbody');
        for (let rowInfo of automaton) {
            const tr = tbodyEl.insertRow();
            let td = tr.insertCell();
            const divEl = ce('div');
            divEl.classList.add('mt2-state-wrapper');
            td.append(divEl);
            const inputStateEl = ce('input');
            inputStateEl.type = 'text';
            inputStateEl.value = rowInfo.state;
            const deleteButton = ce('button');
            deleteButton.type = 'button';
            deleteButton.classList.add('mt2-del-state-btn');
            deleteButton.textContent = '-';
            divEl.append(inputStateEl, deleteButton);
            for (let letter of alphabet) {
                addCellWithInput(tr, rowInfo.expressions[letter] || '');
            }
            addCellWithInput(tr, rowInfo.expressions[lambdaSymbol] || '');
        }
        tableEl.append(tbodyEl);
    }

    function fillAlphabetInput() {
        alphabetEl.value = alphabet.join('');
    }

    function buttonsOnTableClickHandler(ev) {
        const el = ev.target;
        if (el.tagName !== 'BUTTON') {
            return;
        }
        if (el.textContent === '+') {
            automaton.push({
                state: `${stateSymbol}${automaton.length}`,
                expressions: {},
            });
        } else {
            const trEl = el.closest('tr');
            const tbodyEl = trEl.closest('tbody');
            const trArray = tbodyEl.querySelectorAll('tr');
            let ind = 0;
            for (let i = 0; i < trArray.length; i++) {
                if (trArray[i] === trEl) {
                    ind = i;
                    break;
                }
            }
            automaton.splice(ind, 1);
        }
        generateTable();
    }

    function reflectAutomatonOnTableInputBlurHandler(ev) {
        const el = ev.target;
        if (el.tagName !== 'INPUT') {
            return;
        }
        const tdEl = el.closest('td');
        const trEl = tdEl.closest('tr');
        const tbodyEl = trEl.closest('tbody');
        const trArray = tbodyEl.querySelectorAll('tr');
        const tdArray = trEl.querySelectorAll('td');
        let rowIndex = 0;
        let cellIndex = 0;
        for (let i = 0; i < trArray.length; i++) {
            if (trArray[i] === trEl) {
                rowIndex = i;
                break;
            }
        }
        for (let i = 0; i < tdArray.length; i++) {
            if (tdArray[i] === tdEl) {
                cellIndex = i;
                break;
            }
        }
        if (cellIndex === 0) {
            automaton[rowIndex].state = el.value;
        } else {
            const letter = cellIndex - 1 < alphabet.length ? alphabet[cellIndex - 1] : lambdaSymbol;
            automaton[rowIndex].expressions[letter] = el.value;
        }
        setStepStartButtonsEnabled(false);
    }

    function changeToSpecialsOnInput(ev) {
        const el = ev.target;
        if (el.tagName !== 'INPUT') {
            return;
        }
        el.value = el.value.replace(lambdaSymbolAbbr, lambdaSymbol)
            .replace(lastCommandSymbolAbbr, lastCommandSymbol)
            .replace(firstSymbolAbbr, firstSymbol);
    }

    function cloneAutomaton(automaton) {
        const res = [];
        for (let el of automaton) {
            const resItem = {
                state: el.state,
                expressions: {},
            };
            for (let x in el.expressions) {
                resItem.expressions[x] = el.expressions[x];
            }
            res.push(resItem);
        }
        return res;
    }

    function applyExample(ind) {
        changeCurrentState(firstState);
        const example = examples[ind];
        visibleTapeStartPos = 0;
        tapePos = 6;
        alphabet = example.alphabet.split('');
        automaton = cloneAutomaton(example.automaton);
        tape = {};
        alphabetEl.value = example.alphabet;
        newWordEl.value = example.word;
        placeWordHandler();
        generateTable();
        setStepStartButtonsEnabled(false);
    }

    function addExamplesButtons() {
        examplesButtonsWrapperEl.innerHTML = '';
        for (let example of examples) {
            const el = ce('button');
            el.type = 'button';
            el.classList.add('mt2-example-btn', 'btn', 'btn-secondary');
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
        const buttons = buttonEl.closest('.mt2-examples-buttons-wrapper').querySelectorAll('button');
        let ind = 0;
        for (let i = 0; i < buttons.length; i++) {
            if (buttons[i] === buttonEl) {
                ind = i;
                break;
            }
        }
        applyExample(ind);
    }

    // fillCharOnTape will be '' for lambda
    function parseCommand(command) {
        let fillCharOnTape = tape[tapePos] || '';
        let tapeMovement = NSymbol;
        let nextState = currentState;
        const parts = command.replace(/\s+/g, ' ').trim().split(' ');
        if (parts.length === 1) {
            if (parts[0] === RSymbol) {
                tapeMovement = RSymbol;
            } else if (parts[0] === LSymbol) {
                tapeMovement = LSymbol;
            }
        } else {
            fillCharOnTape = parts[0] === lambdaSymbol ? '' : parts[0];
            if (parts[1] === RSymbol) {
                tapeMovement = RSymbol;
            } else if (parts[1] === LSymbol) {
                tapeMovement = LSymbol;
            }
            nextState = parts[2];
        }
        return {
            fillCharOnTape: fillCharOnTape,
            tapeMovement: tapeMovement,
            nextState: nextState,
        };
    }

    function applyCommand(parsedCommand) {
        const { fillCharOnTape, tapeMovement, nextState } = parsedCommand;
        tape[tapePos] = fillCharOnTape;
        if (tapeMovement === RSymbol) {
            tapePos++;
        } else if (tapeMovement === LSymbol) {
            tapePos--;
        }
        refillTape();
        if (nextState === lastCommandSymbol) {
            changeCurrentState(firstState);
        } else {
            changeCurrentState(nextState);
        }
    }

    function setTapeEnabled(value) {
        canTapeBeChanged = value;
        for (let el of tapeContentEl.querySelectorAll('.mt2-tape-cell')) {
            el.disabled = !value;
        }
    }

    function stepButtonClickHandler() {
        if (checkErrors()) {
            if (formEl) {
                checkAnswer('btnStep', formEl, false);
            }
            return;
        }
        setTapeEnabled(false);
        const automatonRow = automaton.find(x => x.state === currentState);
        const automatonExpressions = automatonRow.expressions;
        const command = automatonExpressions[tape[tapePos] || lambdaSymbol] || '';
        const parsedCommand = parseCommand(command);
        applyCommand(parsedCommand);
        if (parsedCommand.nextState === lastCommandSymbol) {
            setStepStartButtonsEnabled(false);
        }
        if (tapePos < 0) {
            alert(`Неверная команда: попытка выйти за пределы однонаправленной ленты!`);
            tapePos = 0;
            refillTape();
        }
        highlightNextCommand();
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
            const automatonRow = automaton.find(x => x.state === currentState);
            const automatonExpressions = automatonRow.expressions;
            const command = automatonExpressions[tape[tapePos] || lambdaSymbol] || '';
            const parsedCommand = parseCommand(command);

            const { fillCharOnTape, tapeMovement, nextState } = parsedCommand;
            if (tapeMovement === NSymbol && nextState === currentState && fillCharOnTape === (tape[tapePos] || '')) {
                itersCount = i;
                stopReason = 'empty-rule';
                break;
            }

            applyCommand(parsedCommand);
            if (tapePos < 0) {
                stopReason = 'outside-the-tape';
                break;
            }
            if (parsedCommand.nextState === lastCommandSymbol) {
                stopReason = 'successful-finish';
                break;
            }
        }
        highlightNextCommand();
        if (stopReason === 'too-many-commands') {
            alert(`Машина была остановлена, т.к. за ${itersCount} команд не было найдено команды с переходом в конечное состояние (${lastCommandSymbol}).`);
        } else if (stopReason === 'empty-rule') {
            alert(`Машина была остановлена, т.к. спустя ${itersCount} команд была встречена команда, не влияющая на машину.`);
        } else if (stopReason === 'outside-the-tape') {
            alert(`Машина была остановлена, т.к. был произведён переход за пределы однонаправленной ленты.`);
        }
        setStepStartButtonsEnabled(false);
        if (formEl) {
            checkAnswer('btnRun', formEl, true);
        }
    }

    function fillCurrentState() {
        currentStateEl.textContent = currentState;
    }

    function changeCurrentState(newState) {
        currentState = newState;
        fillCurrentState();
    }

    function toFirstStateButtonClickHandler() {
        setTapeEnabled(true);
        // to s0
        changeCurrentState(firstState);

        clearTapeHandler();
        placeWordHandler();

        setStepStartButtonsEnabled(true);

        // select first letter on tape
        let elementsOnTape = false;
        let minValue = 2000000000;
        for (let el in tape) {
            if (+el < minValue && tape[el] !== lambdaSymbol && tape[el] !== '') {
                elementsOnTape = true;
                minValue = +el;
            }
        }
        if (!elementsOnTape) {
            return;
        }
        tapePos = minValue;
        refillTape();
    }

    function getTapeErrors() {
        const res = [];
        for (let el in tape) {
            if (tape[el] !== '' && !alphabet.includes(tape[el])) {
                res.push(`На ленте имеется символ '${tape[el]}', который не входит в состав алфавита "${alphabet.join('')}".`);
            }
        }
        return res;
    }

    function getStatesErrors() {
        const res = [];
        const allStates = [];
        let firstStateExists = false;
        let currentStateExists = false;
        for (let row of automaton) {
            const state = row.state;
            if (state === firstState) {
                firstStateExists = true;
            }
            if (state === currentState) {
                currentStateExists = true;
            }
            if (allStates.includes(state)) {
                res.push(`Состояние "${state}" повторяется более одного раза в таблице.`);
            } else {
                allStates.push(state);
            }
        }
        if (!firstStateExists) {
            res.push(`В таблице должно присутствовать начальное состояние с названием "${firstState}".`);
        }
        if (!currentStateExists) {
            res.push(`В таблице должно присутствовать текущее состояние с названием "${currentState}" или же нажмите на кнопку "Перейти в начальное состояние".`);
        }
        return res;
    }

    function getOneCommandErrors(command) {
        const res = [];
        const parts = command.replace(/\s+/g, ' ').trim().split(' ');
        if (parts.length !== 1 && parts.length !== 3) {
            res.push(`команда должна иметь 1 или 3 элемента разделённых пробелами. У Вас команда имеет ${parts.length} элементов, разделённых пробелами.`);
            return res;
        }
        if (parts.length === 1) {
            const part = parts[0];
            if (part !== '' && part !== RSymbol && part !== LSymbol && part !== NSymbol) {
                res.push(`элемент должен иметь значение '${RSymbol}', '${LSymbol}', '${NSymbol}' или быть не заданным. Сейчас задано '${part}'.`);
                return res;
            }
        } else {
            const left = parts[0];
            const middle = parts[1];
            const right = parts[2];
            if (!(alphabet.includes(left) || left === lambdaSymbol)) {
                res.push(`первый элемент должен быть символом алфавита "${alphabet.join('')}" или символом ${lambdaSymbol}. Сейчас первый элемент имеет значение "${left}".`);
            }
            if (middle !== RSymbol && middle !== LSymbol && middle !== NSymbol) {
                res.push(`средний элемент должен иметь значение '${RSymbol}', '${LSymbol}' или '${NSymbol}'. Сейчас задано '${middle}'.`);
            }
            if (!(automaton.map(x => x.state).includes(right) || right === lastCommandSymbol)) {
                res.push(`последний элемент должен являться состоянием или являться символом '${lastCommandSymbol}', обозначающим конец. Сейчас последний элемент имеет значение "${right}".`);
            }
        }
        return res;
    }

    function getCommandsErrors() {
        const res = [];
        for (let row of automaton) {
            for (let symbol in row.expressions) {
                const command = row.expressions[symbol];
                if (command === undefined) {
                    continue;
                }
                const errors = getOneCommandErrors(command);
                for (let error of errors) {
                    res.push(`Состояние "${row.state}" символ '${symbol}': ${error}`);
                }
            }
        }
        return res;
    }

    function getErrors() {
        const res = [];
        res.push(...getTapeErrors());
        res.push(...getStatesErrors());
        res.push(...getCommandsErrors());
        return res;
    }

    // returns true if errors were detected
    function checkErrors() {
        removeHighlightCommands();
        const errors = getErrors();
        if (errors.length <= 0) {
            clearErrors();
            highlightNextCommand();
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
            pEl.classList.add('.mt2-error');
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

    function highlightNextCommand() {
        removeHighlightCommands();
        const symbol = tape[tapePos] || lambdaSymbol;
        let stateIndex = -1;
        for (let i = 0; i < automaton.length; i++) {
            if (automaton[i].state === currentState) {
                stateIndex = i;
                break;
            }
        }
        if (stateIndex === -1) {
            return;
        }
        let symbolIndex = -1;
        if (symbol === lambdaSymbol) {
            symbolIndex = alphabet.length;
        } else {
            for (let i = 0; i < alphabet.length; i++) {
                if (alphabet[i] === symbol) {
                    symbolIndex = i;
                }
            }
        }
        const requiredInput = containerEl.querySelector(`.mt2-table tbody tr:nth-of-type(${stateIndex + 1}) td:nth-of-type(${symbolIndex + 2}) input`);
        if (!requiredInput) {
            return;
        }
        requiredInput.classList.add('mt2-input-next-command');
    }

    function removeHighlightCommands() {
        const highlightEls = containerEl.querySelectorAll('.mt2-table .mt2-input-next-command');
        for (let el of highlightEls) {
            el.classList.remove('mt2-input-next-command');
        }
    }

    function newWordInputHandler(ev) {
        const t = ev.target;
        let v = t.value;
        v = v.replace(firstSymbolAbbr, firstSymbol);
        if (v.length <= 0 || v[0] !== firstSymbol) {
            v = firstSymbol + v;
        }
        t.value = v;
    }

    function start() {
        window.addEventListener('resize', refillTape);
        tapeContentEl.addEventListener('input', tapeInputHandler);
        tapeContentEl.addEventListener('dblclick', tapeDblClickHandler);

        tapeLeftEl.addEventListener('click', tapeLeftHandler);
        tapeRightEl.addEventListener('click', tapeRightHandler);

        newWordEl.addEventListener('input', newWordInputHandler);

        placeWordBtnEl.addEventListener('click', placeWordHandler);
        clearTapeBtnEl.addEventListener('click', clearTapeHandler);

        alphabetEl.addEventListener('input', alphabetInputHandler);

        tableEl.addEventListener('click', buttonsOnTableClickHandler);
        tableEl.addEventListener('focusout', reflectAutomatonOnTableInputBlurHandler);
        tableEl.addEventListener('input', changeToSpecialsOnInput);

        refillTape();
        fillAlphabetInput();
        generateTable();
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
            automaton: automaton,
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
                url:   '/algorithm/MTCheck',
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');

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
    for (let containerEl of document.querySelectorAll('.mt2-container')) {
        const submitIt = createMt2(containerEl);
        allSubmitItFuncs.push(submitIt);
    }

    window.mt2SubmitAllTasks = () => {
        for (let foo of allSubmitItFuncs) {
            foo();
        }
    };
});
