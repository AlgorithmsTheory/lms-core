<div class="ham2-comment-section" style="display: none;">
    <textarea class="ham2-algo-comment" placeholder="Комментарий"></textarea>
</div>
<div class="ham2-header">
    <h2 class="ham2-header-h2">Эмулятор нормальных алгоритмов Маркова</h2>
    <div class="ham2-import-export-section btn-group" style="display: none">
        <button type="button" class="ham2-export-btn btn btn-default-bright btn-raised" style="height: 44px" title="Сохранить в файл алгоритм и условие задачи" data-toggle="tooltip" data-placement="top"><i class="md md-file-download"></i></button>
        <label class="btn btn-default-bright btn-raised" title="Загрузить в эмулятор программу из файла" style="height: 44px">
            <input type="file" class="ham2-import-input" style="display: none">
            <i class="md md-file-upload" style="line-height: 39px"></i>
        </label>
        <div class="ham2-algo-name-wrapper" style="display: none">
            <input class="ham2-algo-name" type="text" placeholder="Название файла">
            <button class="ham2-export-apply-btn btn btn-primary">Подтвердить</button>
        </div>
    </div>
    <a class="ham2-help-link" href="/algorithm/ham2_HELP" target="_blank">Помощь</a>
    <a class="ham2-help-link" href="/algorithm/ham2_SCORES" target="_blank">Система оценивания КР</a>
</div>
<div class="ham2-current-word-section">
    Текущее слово: <span class="ham2-current-word"></span>
</div>
<div class="ham2-place-word-section">
    <span style="width: 70px; display: inline-block;">
        Слово:&nbsp;
    </span>
    <input type="text" class="ham2-new-word">
    <button type="button" class="ham2-place-word-btn btn btn-primary">Поместить на ленту</button>
    <button type="button" class="ham2-clear-tape-btn btn btn-primary">Очистить ленту</button>
</div>
<div class="ham2-alphabet-section">
    <span style="width: 70px; display: inline-block;">
        Алфавит:
    </span>
    <input type="text" class="ham2-alphabet">
    <button type="button" class="ham2-check-btn btn btn-primary">Проверить синтаксис</button>
    <button type="button" class="ham2-to-first-state btn btn-primary">Начать заново</button>
    <button type="button" class="ham2-step-btn btn btn-primary" disabled style="display: none">Сделать шаг</button>
    <button type="button" class="ham2-start-btn btn btn-primary" disabled>Запустить до конца</button>
</div>
<div class="ham2-syntax-success" style="background-color: #aaffaa;max-width: max-content; display: none;">Проверка синтаксиса завершена успешно</div>
<div class="ham2-errors"></div>
<div class="ham2-list-section">
    <button class="ham2-list-add-row-btn" type="button">
        +
    </button>
    <div class="ham2-list-section-rows">
    </div>
</div>
<div>Для ввода Λ используйте "\l".</div>
<div>Для ввода • используйте "\o".</div>
