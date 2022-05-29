<h3>Как начисляются баллы?</h3>
<p>
    Количество баллов, которое получит пользователь за решение
    конкретной задачи по эмулятору Маркова вычисляется по следующей формуле:
</p>
<p>
    <code>max(0, seq_true/seq_all - fee) * max_scores</code>, где
</p>
<ul>
    <li>
        <code>seq_true</code> - число верно пройденных тестов для данной задачи;
    </li>
    <li>
        <code>seq_all</code> - общее число тестов для данной задачи;
    </li>
    <li>
        <code>max_scores</code> - это максимальное количество баллов, которое возможно получить за данную работу;
    </li>
    <li>
        <code>fee</code> - общий штраф за проверки, запуски и отладки.
    </li>
</ul>
<p>При этом fee вычисляется по следующей формуле:</p>
<p>
    <code>min(0.5, (debug_fee / 100) * debug_count + (run_fee / 100) * run_count +
        + (steps_fee / 100) * steps_count)</code>, где
</p>
<ul>
    <li>
        <code>debug_fee = {{$fees->debug_fee}} (%)</code> - процент штрафа
        за 1 клик по кнопке "Проверить работу", который привёл к тому, что не все тесты пройдены верно;
    </li>
    <li>
        <code>run_fee = {{$fees->run_fee}} (%)</code> - процент штрафа за 1 клик по кнопке "Запустить";
    </li>
    <li>
        <code>steps_fee = {{$fees->steps_fee}} (%)</code> - процент штрафа за 1 клик по кнопке "Отладить до конца";
    </li>
    <li>
        <code>debug_count</code> - число кликов по кнопке "Проверить работу", которые привели к тому, что не все тесты пройдены верно;
    </li>
    <li>
        <code>run_count</code> - число кликов по кнопке "Запустить".
    </li>
    <li>
        <code>steps_count</code> - число кликов по кнопке "Отладить до конца";
    </li>
</ul>