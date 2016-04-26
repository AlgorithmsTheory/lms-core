<h2>Работа на семинарах</h2>
<br>
<table class="table table-condensed table-bordered">
    <tr>
        <td rowspan="2" class="warning">Группа</td>
        <td rowspan="2" class="warning">Имя</td>
        <td rowspan="2" class="warning">Фамилия</td>
        <td colspan="7" class="info">1 Раздел</td>
        <td colspan="4" class="warning">2 Раздел</td>
        <td colspan="4" class="info">3 Раздел</td>
        <td colspan="1" class="warning">4 Раздел</td>
    </tr>
    <tr class="active">
        <td>1</td>
        <td>2</td>
        <td>3</td>
        <td>4</td>
        <td>5</td>
        <td>6</td>
        <td>7</td>
        <td>8</td>
        <td>9</td>
        <td>10</td>
        <td>11</td>
        <td>12</td>
        <td>13</td>
        <td>14</td>
        <td>15</td>
        <td>16</td>
    </tr>
    <tbody id="target">
    <?php
    $count = 0;
    ?>
    @foreach($statement as $state)
        <tr id="{{ $state['userID'] }}">
            <td>
                {{ $state['group'] }}
            </td>
            <td>
                {{ $first_names[$count] }}
            </td>
            <td>
                {{ $last_names[$count] }}
            </td>
            <td>
                <input type="number" value="{{ $state['col1'] }}" name="{{ $state['userID'] }}" id="col1" class="classwork" style="width: 50px;" step="any">
            </td>
            <td>
                <input type="number" value="{{ $state['col2'] }}" name="{{ $state['userID'] }}" id="col2" class="classwork" style="width: 50px;" step="any">
            </td>
            <td>
                <input type="number" value="{{ $state['col3'] }}" name="{{ $state['userID'] }}" id="col3" class="classwork" style="width: 50px;" step="any">
            </td>
            <td>
                <input type="number" value="{{ $state['col4'] }}" name="{{ $state['userID'] }}" id="col4" class="classwork" style="width: 50px;" step="any">
            </td>
            <td>
                <input type="number" value="{{ $state['col5'] }}" name="{{ $state['userID'] }}" id="col5" class="classwork" style="width: 50px;" step="any">
            </td>
            <td>
                <input type="number" value="{{ $state['col6'] }}" name="{{ $state['userID'] }}" id="col6" class="classwork" style="width: 50px;" step="any">
            </td>
            <td>
                <input type="number" value="{{ $state['col7'] }}" name="{{ $state['userID'] }}" id="col7" class="classwork" style="width: 50px;" step="any">
            </td>
            <td>
                <input type="number" value="{{ $state['col8'] }}" name="{{ $state['userID'] }}" id="col8" class="classwork" style="width: 50px;" step="any">
            </td>
            <td>
                <input type="number" value="{{ $state['col9'] }}" name="{{ $state['userID'] }}" id="col9" class="classwork" style="width: 50px;" step="any">
            </td>
            <td>
                <input type="number" value="{{ $state['col10'] }}" name="{{ $state['userID'] }}" id="col10" class="classwork" style="width: 50px;" step="any">
            </td>
            <td>
                <input type="number" value="{{ $state['col11'] }}" name="{{ $state['userID'] }}" id="col11" class="classwork" style="width: 50px;" step="any">
            </td>
            <td>
                <input type="number" value="{{ $state['col12'] }}" name="{{ $state['userID'] }}" id="col12" class="classwork" style="width: 50px;" step="any">
            </td>
            <td>
                <input type="number" value="{{ $state['col13'] }}" name="{{ $state['userID'] }}" id="col13" class="classwork" style="width: 50px;" step="any">
            </td>
            <td>
                <input type="number" value="{{ $state['col14'] }}" name="{{ $state['userID'] }}" id="col14" class="classwork" style="width: 50px;" step="any">
            </td>
            <td>
                <input type="number" value="{{ $state['col15'] }}" name="{{ $state['userID'] }}" id="col15" class="classwork" style="width: 50px;" step="any">
            </td>
            <td>
                <input type="number" value="{{ $state['col16'] }}" name="{{ $state['userID'] }}" id="col16" class="classwork" style="width: 50px;" step="any">
            </td>
        </tr>
        <?php
        $count++;
        ?>
    @endforeach
    </tbody>
</table>

{!! HTML::script('js/statements/classwork.js') !!}