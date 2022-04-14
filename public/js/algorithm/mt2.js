function createMt2(containerEl) {
    function qs(selector) { return containerEl.querySelector(selector); }

    const tapeContentEl = qs('.mt2-tape-content');
    const newWordEl = qs('.mt2-new-word');
    const tableEl = qs('.mt2-table');
    const alphabetEl = qs('.mt2-alphabet');
    const examplesButtonsWrapperEl = qs('.mt2-examples-buttons-wrapper');
    const currentStateEl = qs('.mt2-current-state');
    const errorsEl = qs('.mt2-errors');
    const startBtnEl = qs('.mt2-start-btn');
    const stepBtnEl = qs('.mt2-step-btn');
    const tapeLeftEl = qs('.mt2-tape-left');
    const tapeRightEl = qs('.mt2-tape-right');
    const placeWordBtnEl = qs('.mt2-place-word-btn');
    const clearTapeBtnEl = qs('.mt2-clear-tape-btn');
    const toFirstStateEl = qs('.mt2-to-first-state');
    const checkBtnEl = qs('.mt2-check-btn');




    const ce = document.createElement.bind(document);
    let tape = {};
    let visibleTapeStartPos = 0;
    let tapePos = 6;
    let alphabet = ['a', 'b'];
    const firstState = 'q0';
    let currentState = firstState;

    let automaton = [
        {
            state: 'q0',
            expressions: {
            },
        },
    ];

    const lambdaSymbol = 'λ';

    const examples = [
        {
            title: 'Инкремент (двоичная СС)',
            alphabet: '01',
            word: '1011',
            automaton: [
                {
                    state: 'q0',
                    expressions: {
                        '0': 'R',
                        '1': 'R',
                        [lambdaSymbol]: `${lambdaSymbol} L q1`,
                    }
                },
                {
                    state: 'q1',
                    expressions: {
                        '0': '1 N q2',
                        '1': '0 L q1',
                        [lambdaSymbol]: `1 N !`,
                    }
                },
                {
                    state: 'q2',
                    expressions: {
                        '0': 'L',
                        '1': 'L',
                        [lambdaSymbol]: `${lambdaSymbol} R !`,
                    }
                },
            ]
        },
        {
            title: 'Инкремент (десятичная СС)',
            alphabet: '0123456789',
            word: '1011',
            automaton: [
                {
                    state: 'q0',
                    expressions: {
                        '0': 'R',
                        '1': 'R',
                        '2': 'R',
                        '3': 'R',
                        '4': 'R',
                        '5': 'R',
                        '6': 'R',
                        '7': 'R',
                        '8': 'R',
                        '9': 'R',
                        [lambdaSymbol]: `${lambdaSymbol} L q1`,
                    }
                },
                {
                    state: 'q1',
                    expressions: {
                        '0': '1 N q2',
                        '1': '2 N q2',
                        '2': '3 N q2',
                        '3': '4 N q2',
                        '4': '5 N q2',
                        '5': '6 N q2',
                        '6': '7 N q2',
                        '7': '8 N q2',
                        '8': '9 N q2',
                        '9': '0 L q1',
                        [lambdaSymbol]: '1 N !',
                    }
                },
                {
                    state: 'q2',
                    expressions: {
                        '0': 'L',
                        '1': 'L',
                        '2': 'L',
                        '3': 'L',
                        '4': 'L',
                        '5': 'L',
                        '6': 'L',
                        '7': 'L',
                        '8': 'L',
                        '9': 'L',
                        [lambdaSymbol]: `${lambdaSymbol} R !`,
                    }
                },
            ]
        },
        {
            title: 'Инверсия слова',
            alphabet: 'ab',
            word: 'abaabbaaabbb',
            automaton: [
                {
                    state: 'q0',
                    expressions: {
                        'a': 'b R q0',
                        'b': 'a R q0',
                        [lambdaSymbol]: `${lambdaSymbol} N !`,
                    }
                },
            ]
        },
        {
            title: 'Удаление символа',
            alphabet: 'abc#',
            word: 'abacabaab',
            automaton: [
                {
                    state: 'q0',
                    expressions: {
                        'a': 'R',
                        'b': 'R',
                        'c': 'R',
                        '#': '',
                        [lambdaSymbol]: '# L q1',
                    }
                },
                {
                    state: 'q1',
                    expressions: {
                        'a': 'L',
                        'b': 'L',
                        'c': 'L',
                        '#': 'L',
                        [lambdaSymbol]: `${lambdaSymbol} R q2`,
                    }
                },
                {
                    state: 'q2',
                    expressions: {
                        'a': `${lambdaSymbol} R q2`,
                        'b': `${lambdaSymbol} R q3`,
                        'c': `${lambdaSymbol} R q4`,
                        '#': `${lambdaSymbol} R !`,
                        [lambdaSymbol]: `${lambdaSymbol} R !`,
                    }
                },
                {
                    state: 'q3',
                    expressions: {
                        'a': 'R',
                        'b': 'R',
                        'c': 'R',
                        '#': 'R',
                        [lambdaSymbol]: 'b L q1',
                    }
                },
                {
                    state: 'q4',
                    expressions: {
                        'a': 'R',
                        'b': 'R',
                        'c': 'R',
                        '#': 'R',
                        [lambdaSymbol]: 'c L q1',
                    }
                },
            ]
        }
    ]

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
        setButtonsEnabled(false);
    }

    function tapeInputHandler(ev) {
        const tapeCell = ev.target.closest('.mt2-tape-cell');
        if (!tapeCell) {
            return;
        }
        placeWord(tapeCell, tapeCell.value);
    }

    function tapeLeftHandler() {
        visibleTapeStartPos--;
        refillTape();
    }

    function tapeRightHandler() {
        visibleTapeStartPos++;
        refillTape();
    }

    function placeWordHandler() {
        const word = newWordEl.value;
        const letters = word.split('');
        for (let i = 0; i < letters.length; i++) {
            const realInd = tapePos + i;
            tape[realInd] = letters[i];
        }
        refillTape();
        setButtonsEnabled(false);
    }

    function clearTapeHandler() {
        tape = {};
        refillTape();
    }

    function tapeDblClickHandler(ev) {
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
        const val = ev.target.value;
        alphabet = [...new Set(val.split(''))];
        ev.target.value = alphabet.join('');
        generateTable();
        setButtonsEnabled(false);
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
        inputEl.placeholder = 'N';
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
                state: `q${automaton.length}`,
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
        setButtonsEnabled(false);
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
        setButtonsEnabled(false);
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
            res.push(el);
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
        setButtonsEnabled(false);
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
        let tapeMovement = 'N';
        let nextState = currentState;
        const parts = command.replace(/\s+/g, ' ').trim().split(' ');
        if (parts.length === 1) {
            if (parts[0] === 'R') {
                tapeMovement = 'R';
            } else if (parts[0] === 'L') {
                tapeMovement = 'L';
            }
        } else {
            fillCharOnTape = parts[0] === lambdaSymbol ? '' : parts[0];
            if (parts[1] === 'R') {
                tapeMovement = 'R';
            } else if (parts[1] === 'L') {
                tapeMovement = 'L';
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
        if (tapeMovement === 'R') {
            tapePos++;
        } else if (tapeMovement === 'L') {
            tapePos--;
        }
        refillTape();
        if (nextState === '!') {
            changeCurrentState(firstState);
        } else {
            changeCurrentState(nextState);
        }
    }

    function stepButtonClickHandler() {
        const automatonRow = automaton.find(x => x.state === currentState);
        const automatonExpressions = automatonRow.expressions;
        const command = automatonExpressions[tape[tapePos] || lambdaSymbol] || '';
        const parsedCommand = parseCommand(command);
        applyCommand(parsedCommand);
        highlightNextCommand();
    }

    function startButtonClickHandler() {
        const itersCount = 500;
        let all_ok = false;
        for (let i = 0; i < itersCount; i++) {
            const automatonRow = automaton.find(x => x.state === currentState);
            const automatonExpressions = automatonRow.expressions;
            const command = automatonExpressions[tape[tapePos] || lambdaSymbol] || '';
            const parsedCommand = parseCommand(command);
            applyCommand(parsedCommand);
            if (parsedCommand.nextState === '!') {
                all_ok = true;
                break;
            }
        }
        highlightNextCommand();
        if (!all_ok) {
            alert(`Следующий шаг был выполнен ${itersCount} раз, но не было найдено команды, обозначающей конец, поэтому машина была приостановлена.`);
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
        changeCurrentState(firstState);
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
            if (part !== '' && part !== 'R' && part !== 'L' && part !== 'N') {
                res.push(`элемент должен иметь значение 'R', 'L', 'N' или быть не заданным. Сейчас задано в '${part}'.`);
                return res;
            }
        } else {
            const left = parts[0];
            const middle = parts[1];
            const right = parts[2];
            if (!(alphabet.includes(left) || left === lambdaSymbol)) {
                res.push(`первый элемент должен быть символом алфавита "${alphabet.join('')}" или символом ${lambdaSymbol}. Сейчас первый элемент имеет значение "${left}".`);
            }
            if (middle !== 'R' && middle !== 'L' && middle !== 'N') {
                res.push(`средний элемент должен иметь значение 'R', 'L' или 'N'. Сейчас задано в '${middle}'.`);
            }
            if (!(automaton.map(x => x.state).includes(right) || right === '!')) {
                res.push(`последний элемент должен являться состоянием или являться символом '!', обозначающим конец. Сейчас последний элемент имеет значение "${right}".`);
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

    function checkBtnClickHandler() {
        removeHighlightCommands();
        const errors = getErrors();
        if (errors.length <= 0) {
            clearErrors();
            setButtonsEnabled(true);
            highlightNextCommand();
        } else {
            showErrors(errors);
            setButtonsEnabled(false);
        }
    }

    function clearErrors() {
        errorsEl.innerHTML = '';
    }

    function showErrors(errors) {
        errorsEl.innerHTML = '';
        for (let error of errors) {
            const pEl = ce('p');
            pEl.classList.add('.mt2-error');
            pEl.textContent = error;
            errorsEl.append(pEl);
        }
    }

    function setButtonsEnabled(value) {
        startBtnEl.disabled = !value;
        stepBtnEl.disabled = !value;
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

    function start() {
        window.addEventListener('resize', refillTape);
        tapeContentEl.addEventListener('input', tapeInputHandler);
        tapeContentEl.addEventListener('dblclick', tapeDblClickHandler);

        tapeLeftEl.addEventListener('click', tapeLeftHandler);
        tapeRightEl.addEventListener('click', tapeRightHandler);

        placeWordBtnEl.addEventListener('click', placeWordHandler);
        clearTapeBtnEl.addEventListener('click', clearTapeHandler);

        alphabetEl.addEventListener('input', alphabetInputHandler);

        tableEl.addEventListener('click', buttonsOnTableClickHandler);
        tableEl.addEventListener('focusout', reflectAutomatonOnTableInputBlurHandler);

        refillTape();
        fillAlphabetInput();
        generateTable();
        addExamplesButtons();

        examplesButtonsWrapperEl.addEventListener('click', examplesButtonsWrapperClickHandler);
        stepBtnEl.addEventListener('click', stepButtonClickHandler);
        startBtnEl.addEventListener('click', startButtonClickHandler);
        toFirstStateEl.addEventListener('click', toFirstStateButtonClickHandler);
        checkBtnEl.addEventListener('click', checkBtnClickHandler);

        return checking();
    }

    function checkAnswer(formEl, notice) {
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
                    token: 'token' },
                success: function(data){
                    const sequences_true = data['choice']['sequences_true'];
                    const sequences_all = data['choice']['sequences_all'];
                    const debug_counter = data['choice']['debug_counter'];

                    debugCounterEl.value = debug_counter;

                    alert("Текущий результат отправки: " + sequences_true + " тестов сработало из " + sequences_all +
                        " . Количество отправок: " + debug_counter + "\n");
                }
            });
        }
    }

    function checking() {
        const formEl = tapeContentEl.closest('form');
        if (!formEl) {
            return () => {};
        }
        const btnCheckAnswerEl = formEl.querySelector('.btn-check-answer');
        if (!btnCheckAnswerEl) {
            return () => {};
        }

        btnCheckAnswerEl.addEventListener('click', () => checkAnswer(formEl, true));
        return () => {
            checkAnswer(formEl, false);
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
