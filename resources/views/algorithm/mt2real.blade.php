<div class="mt2-header">
    <h2>Эмулятор машины Тьюринга</h2>
    <div class="mt2-view-section">
        <button class="mt2-list-view-btn mt2-view-btn-active" type="button">
            Списочный вид
        </button>
        <button class="mt2-table-view-btn" type="button">
            Табличный вид
        </button>
    </div>
</div>
<div class="mt2-tape">
    <button type="button" class="mt2-tape-left">‹</button>
    <div class="mt2-tape-content"></div>
    <button type="button" class="mt2-tape-right">›</button>
</div>
<div class="mt2-place-word-section">
    Текущее состояние:&nbsp;
    <div class="mt2-current-state-section">
        <span class="mt2-current-state"></span>
    </div>
    Слово:&nbsp;
    <input type="text" class="mt2-new-word">
    <button type="button" class="mt2-place-word-btn btn btn-primary">Поместить на ленту</button>
    <button type="button" class="mt2-clear-tape-btn btn btn-primary">Очистить ленту</button>
</div>
<div class="mt2-alphabet-section">
    Алфавит:
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
<div class="mt2-import-export-section btn-group">
    <button type="button" class="mt2-export-btn btn btn-default-bright btn-raised" title="" data-original-title="Сохранить в файл алгоритм и условие задачи" data-toggle="tooltip" data-placement="top"><i class="md md-file-download"></i></button>
    <input type="file" class="mt2-import-input btn ink-reaction btn-raised btn-xs btn-primary">
    <input class="mt2-algo-name" type="text" placeholder="Комментарий">
</div>
<div class="mt2-list-section">
    <div class="mt2-list-section-rows">
    </div>
    <button class="mt2-list-add-row-btn" type="button">
        +
    </button>
</div>
<div class="mt2-table-section" style="display: none">
    <table class="mt2-table">
    </table>
</div>
<div>Для ввода λ используйте "\l".</div>
<div>Для ввода Ω используйте "\o".</div>
<div>Для ввода ∂ используйте "\d".</div>
