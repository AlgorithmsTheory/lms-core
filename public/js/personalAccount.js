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
        0: document.getElementById("tests"),
    }
);


