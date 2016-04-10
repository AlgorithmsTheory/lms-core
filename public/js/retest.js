/**
 * Created by Станислав on 15.03.16.
 */
var filterTable = function (HTMLTBodyRef, aFilters) {
    var rows = HTMLTBodyRef.getElementsByTagName("TR"),
        filters = {}, n,
        walkThrough = function (rows) {
            var tr, i, f;
            for (i = 0; i < rows.length; i += 1) {
                tr = rows.item(i);
                for(f in filters) {
                    if (filters.hasOwnProperty(f)) {
                        if (false === filters[f].validate(tr.children[f].innerText) ) {
                            tr.style.display = "none"; break;
                        } else {
                            tr.style.display = "";
                        }
                    }
                }
            }
        };
    for(n in aFilters) {
        if (aFilters.hasOwnProperty(n)) {
            if (aFilters[n] instanceof filterTable.Filter) {
                filters[n] = aFilters[n];
            } else {
                filters[n] = new filterTable.Filter(aFilters[n]);
            }
            filters[n]._setAction("onchange", function () {walkThrough(rows);});
        }
    }
}

filterTable.Filter = function (HTMLElementRef, callback, eventName) {
    /* Если ф-цию вызвали не как конструктор фиксим этот момент: */
    if (!(this instanceof arguments.callee)) {
        return new arguments.callee(HTMLElementRef, callback, eventName);
    }

    /* Выравниваем пришедший аргумент к массиву */
    this.filters = {}.toString.call(HTMLElementRef) == "[object Array]" ? HTMLElementRef : [HTMLElementRef];

    this.validate = function (cellValue) {
        for (var i = 0; i < this.filters.length; i += 1) {
            if ( false === this.__validate(cellValue, this.filters[i], i) ) {
                return false;
            }
        }
    }

    this.__validate = function (cellValue, filter, i) {
        /* Если фильтр был создан явно и явно указана функция валидации: */
        if (typeof callback !== "undefined") {
            return callback(cellValue, this.filters, i);
        }
        /* Если в фильтр напихали пробелов,  или другой непечатной фигни - удаляем: */
        filter.value = filter.value.replace(/^\s+$/g, "");
        /* "Фильтр содержит значение и оно совпало со значением ячейки" */
        return !filter.value || filter.value == cellValue;
    }

    this._setAction = function (anEventName, callback) {
        for (var i = 0; i < this.filters.length; i += 1) {
            this.filters[i][eventName||anEventName] = callback;
        }
    }
};


filterTable(
    /* Ссылка на элемент <tbody> таблицы */
    document.getElementById("target"),

    /* Объект-конфигурация фильтров: */
    {

        0: document.getElementById("selected-student"),
        1: document.getElementById("selected-group"),
        2: document.getElementById("selected-test")
        //4: document.getElementById("selected-mark")
    }
);

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
$('#retest-form').on('load', '.fine-level', function(){
    $(this).attr('step', checkStep($(this).val()));
});

/** Проверка введенного значения штрафа */
$('#retest-form').on('focusout', '.fine-level', function(){
    var allowable = [100, 90, 85, 80, 75, 70];                                                                          //массив разрешенных штрафов
    if (allowable.indexOf(parseInt($(this).val())) != -1){
        $(this).attr('step', checkStep($(this).val()));
    }
    else {
        alert('Вы ввели недопустимый штраф! Штраф должен быть выбран из набора '+allowable);
        (this).focus();
    }
});

/** Фильтр по оценке */
$('#retest-form').on('change', '#selected-mark', function(){
    var mark = $(this).val();                                                                                           //выбранная оценка
    $('.last-marks').each(function(){
        switch (mark) {
            case 'F':                                                                                                   //если выбрана F, то включаем туда
                if ($(this).text() != mark && $(this).text() != 'Отсутствие'){                                              //еще и отсутствующих
                    $(this).parent().css('display', 'none')
                }
                else
                    $(this).parent().css('display', '');
                break;
            case 'All':                                                                                                 //если выбран параметр "Все"
                $(this).parent().css('display', '');
                break;
            default:                                                                                                    //иначе ищем точное совпадение
                if ($(this).text() != mark){
                    $(this).parent().css('display', 'none')
                }
                else
                    $(this).parent().css('display', '');
                break;
        }
    });
});


