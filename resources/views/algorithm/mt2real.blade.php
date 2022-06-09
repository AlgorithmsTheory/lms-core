<div class="mt2-comment-section" style="display: none;">
    <textarea class="mt2-algo-comment" placeholder="Комментарий"></textarea>
</div>
<div class="mt2-header">
    <h2 class="mt2-header-h2">Эмулятор машины Тьюринга</h2>
    <div class="mt2-view-section">
        <button class="mt2-list-view-btn mt2-view-btn-active" type="button">
            Список
        </button>
        <button class="mt2-table-view-btn" type="button">
            Таблица
        </button>
    </div>
    <div class="mt2-import-export-section btn-group" style="display: none">
        <button type="button" class="mt2-export-btn btn btn-default-bright btn-raised" style="height: 44px" title="Сохранить в файл алгоритм и условие задачи" data-toggle="tooltip" data-placement="top"><i class="md md-file-download"></i></button>
        <label class="btn btn-default-bright btn-raised" title="Загрузить в эмулятор программу из файла" style="height: 44px">
            <input type="file" class="mt2-import-input" style="display: none">
            <i class="md md-file-upload" style="line-height: 39px"></i>
        </label>
{{--        <input type="file" class="mt2-import-input btn ink-reaction btn-raised btn-xs btn-primary">--}}
{{--    /stackoverflow.com/questions/43649952/instruct-browser-to-make-user-select-location-for-downloaded-file--}}
        <div class="mt2-algo-name-wrapper" style="display: none">
            <input class="mt2-algo-name" type="text" placeholder="Название файла">
            <button class="mt2-export-apply-btn btn btn-primary">Подтвердить</button>
        </div>
    </div>
    <a class="mt2-help-link" href="/algorithm/mt2_HELP" target="_blank">Помощь</a>
    <a class="mt2-help-link" href="/algorithm/mt2_SCORES" target="_blank">Система оценивания КР</a>
</div>
<div class="mt2-tape">
    <button type="button" class="mt2-tape-left">‹</button>
    <div class="mt2-tape-content"></div>
    <button type="button" class="mt2-tape-right">›</button>
</div>
<div class="mt2-place-word-section">
    <span style="width: 70px; display: inline-block;">
        Слово:&nbsp;
    </span>
    <input type="text" class="mt2-new-word">
    <button type="button" class="mt2-place-word-btn btn btn-primary">Поместить на ленту</button>
    <button type="button" class="mt2-clear-tape-btn btn btn-primary">Очистить ленту</button>
    Состояние:
    <div class="mt2-current-state-section">
        <span class="mt2-current-state"></span>
    </div>
</div>
<div class="mt2-alphabet-section">
    <span style="width: 70px; display: inline-block;">
        Алфавит:
    </span>
    <input type="text" class="mt2-alphabet">
    <button type="button" class="mt2-check-btn btn btn-primary">Проверить синтаксис</button>
    <button type="button" class="mt2-to-first-state btn btn-primary">Начать заново</button>
    <button type="button" class="mt2-step-btn btn btn-primary" disabled style="display: none">Сделать шаг</button>
    <button type="button" class="mt2-start-btn btn btn-primary" disabled>Запустить до конца</button>
</div>
<div class="mt2-syntax-success" style="background-color: #aaffaa;max-width: max-content; display: none;">Проверка синтаксиса завершена успешно</div>
<div class="mt2-errors"></div>
{{--<div class="mt2-import-export-section" style="display: none">--}}
{{--    <label class="mt2-import-label">--}}
{{--        Импорт из:--}}
{{--        <input class="mt2-import-input" type="file">--}}
{{--    </label>--}}
{{--    <button class="mt2-export-btn" type="button">Экспорт</button>--}}
{{--</div>--}}
<div class="mt2-list-section">
    <button class="mt2-list-add-row-btn" type="button">
        +
    </button>
    <div class="mt2-list-section-rows">
    </div>
</div>
<div class="mt2-table-section" style="display: none">
    <table class="mt2-table">
    </table>
</div>
<div>Для ввода λ используйте "\l".</div>
<div>Для ввода Ω используйте "\o".</div>
<div>Для ввода ∂ используйте "\d".</div>
