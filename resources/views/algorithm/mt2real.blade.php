<div class="mt2-container">
    <h2>Эмулятор машины Тьюринга</h2>
    <div class="mt2-tape">
        <button type="button" class="mt2-tape-left">‹</button>
        <div class="mt2-tape-content"></div>
        <button type="button" class="mt2-tape-right">›</button>
    </div>
    <div class="mt2-place-word-section">
        Слово:
        <input type="text" class="mt2-new-word">
        <button type="button" class="mt2-place-word-btn btn btn-primary">Поместить</button>
        <button type="button" class="mt2-clear-tape-btn btn btn-primary">Очистить ленту</button>
    </div>
    <div class="mt2-alphabet-section">
        Алфавит:
        <input type="text" class="mt2-alphabet">
        <button type="button" class="mt2-check-btn btn btn-primary">Проверить всё</button>
        <button type="button" class="mt2-to-first-state btn btn-primary">Перейти в начальное состояние</button>
        <button type="button" class="mt2-start-btn btn btn-primary" disabled>Запустить</button>
        <button type="button" class="mt2-step-btn btn btn-primary" disabled>Сделать шаг</button>
    </div>
    <div class="mt2-errors"></div>
    <div class="mt2-current-state-section">
        Текущее состояние: <span class="mt2-current-state">q0</span>
    </div>
    <div class="mt2-table-section">
        <table class="mt2-table">
        </table>
    </div>
    <div class="mt2-examples-section">
        Примеры:
        <div class="mt2-examples-buttons-wrapper"></div>
    </div>
</div>