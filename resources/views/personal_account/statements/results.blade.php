<h2>Итоговые результаты</h2>
<br>
<table class="table table-condensed table-bordered">
    <tr class="info">
        <td rowspan="2">Группа</td>
        <td rowspan="2">Фамилия</td>
        <td rowspan="2">Имя</td>
        <td colspan="2">Раздел 1</td>
        <td colspan="2">Раздел 2</td>
        <td colspan="2">Раздел 3</td>
        <td colspan="2">Раздел 4</td>
        <td colspan="2">Итог за семестр</td>
        <td colspan="2">Экзамен (авт.)</td>
        <td colspan="2">Экзамен (письм.)</td>
        <td colspan="2">Суммарный итог</td>
        <td rowspan="2">Оценка(A-F)</td>
        <td rowspan="2">Оценка(2-5)</td>
    </tr>
    <tr class="active">
        <td>min 13</td>
        <td>max 22</td>

        <td>min 7</td>
        <td>max 12</td>

        <td>min 10</td>
        <td>max 16</td>

        <td>min 6</td>
        <td>max 10</td>

        <td>min 36</td>
        <td>max 60</td>

        <td>min 12</td>
        <td>max 20</td>

        <td>min 12</td>
        <td>max 20</td>

        <td>min 60</td>
        <td>max 100</td>
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
            <td colspan="2" class="
                @if ($progress1[$count] == 0)
                    danger
                @else
                    success
                @endif
            ">
                <div>
                   {{ $state['section1'] }}
                </div>
{{--                <input type="number" value="{{ $state['section1'] }}" name="{{ $state['userID'] }}" id="section1" class="resulting" style="width: 50px;">--}}
            </td>
            <td colspan="2" class="
                @if ($progress2[$count] == 0)
                    danger
                @else
                    success
                @endif
            ">
                <div>
                    {{ $state['section2'] }}
                </div>
{{--                <input type="number" value="{{ $state['section2'] }}" name="{{ $state['userID'] }}" id="section2" class="resulting" style="width: 50px;">--}}
            </td>
            <td colspan="2" class="
                @if ($progress3[$count] == 0)
                    danger
                @else
                    success
                @endif
            ">
                <div>
                    {{ $state['section3'] }}
                </div>
{{--                <input type="number" value="{{ $state['section3'] }}" name="{{ $state['userID'] }}" id="section3" class="resulting" style="width: 50px;">--}}
            </td>
            <td colspan="2" class="
                @if ($progress4[$count] == 0)
                    danger
                @else
                    success
                @endif
            ">
                <div>
                    {{ $state['section4'] }}
                </div>
{{--                <input type="number" value="{{ $state['section4'] }}" name="{{ $state['userID'] }}" id="section4" class="resulting" style="width: 50px;">--}}
            </td>
            <td colspan="2" class="
                @if (($progress1[$count] == 0) || ($progress2[$count] == 0) || ($progress3[$count] == 0) || ($progress4[$count] == 0))
                    danger
                @else
                    success
                @endif
            ">
                <div>
                    {{ $state['termResult'] }}
                </div>
                {{--<input type="number" value="{{ $state['termResult'] }}" name="{{ $state['userID'] }}" id="termResult" class="resulting" style="width: 50px;">--}}
            </td>
            <td colspan="2" class="
                @if ($state['exam'] < 12)
                    danger
                @else
                    success
                @endif
            ">
                <input type="number" value="{{ $state['exam'] }}" name="{{ $state['userID'] }}" id="exam" class="resulting" style="width: 50px;">
            </td>
            <td colspan="2" class="
                @if ($state['exam2'] < 12)
                    danger
                @else
                    success
                @endif
                    ">
                <input type="number" value="{{ $state['exam2'] }}" name="{{ $state['userID'] }}" id="exam2" class="resulting" style="width: 50px;">
            </td>
            <td colspan="2" class="
                @if ($state['finalResult'] < 60)
                    danger
                @else
                    success
                @endif
            ">
                <div>
                    {{ $state['finalResult'] }}
                </div>
                {{--<input type="number" value="{{ $state['finalResult'] }}" name="{{ $state['ID'] }}" id="finalResult" class="resulting" style="width: 50px;">--}}
            </td>
            <td class="
                @if ($state['markEU'] === 'F')
                    danger
                @else
                    success
                @endif
            ">
                <div>
                    {{ $state['markEU'] }}
                </div>
                {{--<input type="number" value="{{ $state['markEU'] }}" name="{{ $state['userID'] }}" id="markEU" class="resulting" style="width: 50px;">--}}
            </td>
            <td class="
                @if ($state['markRU'] < 3)
                    danger
                @else
                    success
                @endif
            ">
                <div>
                    {{ $state['markRU'] }}
                </div>
                {{--<input type="number" value="{{ $state['markRU'] }}" name="{{ $state['userID'] }}" id="markRU" class="resulting" style="width: 50px;">--}}
            </td>
        </tr>
        <?php
        $count++;
        ?>
    @endforeach
    </tbody>
</table>
{{--<br>--}}
{{--<br>--}}
{{--<button class="btn btn-accent-bright btn-raised submit-question" id="calc1">Посчитать итоги за 1 раздел</button>--}}

{{--<button class="btn btn-accent-bright btn-raised submit-question" id="calc2">Посчитать итоги за 2 раздел</button>--}}

{{--<button class="btn btn-accent-bright btn-raised submit-question" id="calc3">Посчитать итоги за 3 раздел</button>--}}

{{--<button class="btn btn-accent-bright btn-raised submit-question" id="calc4">Посчитать итоги за 4 раздел</button>--}}
{{--<br>--}}
{{--<br>--}}
{{--<button class="btn btn-accent-bright btn-raised submit-question" id="calc5">Посчитать итоги за семестр</button>--}}

{{--<button class="btn btn-accent-bright btn-raised submit-question" id="calc6">Посчитать финальные итоги</button>--}}
{{--<br>--}}

{!! HTML::script('js/statements/resulting.js') !!}