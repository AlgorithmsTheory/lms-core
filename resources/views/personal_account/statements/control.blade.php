<h2>Результаты контрольных мероприятий</h2>
<br>
<table class="table table-condensed table-bordered">
    <tr>
        <td rowspan="3" class="warning">Группа</td>
        <td rowspan="3" class="warning">Фамилия</td>
        <td rowspan="3" class="warning">Имя</td>
        <td colspan="8" class="info">1 Раздел</td>
        <td colspan="4" class="warning">2 Раздел</td>
        <td colspan="8" class="info">3 Раздел</td>
        <td colspan="2" class="warning">4 Раздел</td>
    </tr>
    <tr class="active">
        <td colspan="2">КР №1 (Тьюринг)</td>
        <td colspan="2">КР №2 (Марков)</td>
        <td colspan="2">Тест 1(авт.)</td>
        <td colspan="2">Тест 1(письм.)</td>
        <td colspan="2">Тест 2(авт.)</td>
        <td colspan="2">Тест 2(письм.)</td>
        <td colspan="2">КР №3-рекурсии</td>
        <td colspan="2">КР №3-письм.</td>
        <td colspan="2">Тест 3(авт.)</td>
        <td colspan="2">Тест 3(письм.)</td>
        <td colspan="2">Опрос</td>
    </tr>
    <tr class="active">
        <td>min 4.2</td>
        <td>max 7</td>
        <td>min 4.2</td>
        <td>max 7</td>
        <td>min 0.6</td>
        <td>max 1</td>
        <td>min 2.4</td>
        <td>max 4</td>

        <td>min 3.6</td>
        <td>max 6</td>
        <td>min 1.8</td>
        <td>max 3</td>

        <td>min 2.4</td>
        <td>max 4</td>
        <td>min 1.8</td>
        <td>max 3</td>
        <td>min 1.8</td>
        <td>max 3</td>
        <td>min 1.8</td>
        <td>max 3</td>

        <td>min 6</td>
        <td>max 10</td>
    </tr>
    <tbody id="target">
    <?php
    $count = 0;
    ?>
    @foreach($statement as $state)
        <tr id="{{ $state['userID'] }}">
            <td>
                {{ $state['group_name'] }}
            </td>
            <td>
                {{ $last_names[$count] }}
            </td>
            <td>
                {{ $first_names[$count] }}
            </td>
            <td colspan="2">
                <input type="number" value="{{ $state['control1'] }}" name="{{ $state['userID'] }}" id="control1" class="controls" style="width: 50px;" step="any">
            </td>
            <td colspan="2">
                <input type="number" value="{{ $state['control2'] }}" name="{{ $state['userID'] }}" id="control2" class="controls" style="width: 50px;" step="any">
            </td>
            <td colspan="2">
                <input type="number" value="{{ $state['test1'] }}" name="{{ $state['userID'] }}" id="test1" class="controls" style="width: 50px;" step="any">
            </td>
            <td colspan="2">
                <input type="number" value="{{ $state['test1quiz'] }}" name="{{ $state['userID'] }}" id="test1quiz" class="controls" style="width: 50px;" step="any">
            </td>
            <td colspan="2">
                <input type="number" value="{{ $state['test2'] }}" name="{{ $state['userID'] }}" id="test2" class="controls" style="width: 50px;" step="any">
            </td>
            <td colspan="2">
                <input type="number" value="{{ $state['test2quiz'] }}" name="{{ $state['userID'] }}" id="test2quiz" class="controls" style="width: 50px;" step="any">
            </td>
            <td colspan="2">
                <input type="number" value="{{ $state['control3'] }}" name="{{ $state['userID'] }}" id="control3" class="controls" style="width: 50px;" step="any">
            </td>
            <td colspan="2">
                <input type="number" value="{{ $state['control3quiz'] }}" name="{{ $state['userID'] }}" id="control3quiz" class="controls" style="width: 50px;" step="any">
            </td>
            <td colspan="2">
                <input type="number" value="{{ $state['test3'] }}" name="{{ $state['userID'] }}" id="test3" class="controls" style="width: 50px;" step="any">
            </td>
            <td colspan="2">
                <input type="number" value="{{ $state['test3quiz'] }}" name="{{ $state['userID'] }}" id="test3quiz" class="controls" style="width: 50px;" step="any">
            </td>
            <td colspan="2">
                <input type="number" value="{{ $state['lastquiz'] }}" name="{{ $state['userID'] }}" id="lastquiz" class="controls" style="width: 50px;" step="any">
            </td>

        </tr>
        <?php
        $count++;
        ?>
    @endforeach
    </tbody>
</table>

{!! HTML::script('js/statements/controls.js') !!}