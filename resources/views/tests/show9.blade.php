<html>
<body>
{!! Form::open(['method' => 'PATCH', 'route' => $route, 'class' => ['smart-blue', 'question-form']]) !!}
<h1>Вопрос {{ $count }}</h1>
<h2>Дана система рекурсивных уравнений:</h2>
<h2>
    @for ($i = 0; $i < count($text); $i++)
        @if ($i % 2 == 0) {{ $text[$i] }}
        @else {!! HTML::image($text[$i]) !!}
        @endif
    @endfor
</h2>
<h2>Найдите значение функции f(х) в указанных точках.</h2>
<h2>В случае, если в данной точке значение функции не определено, в поле с ответом следует записать "-1"</h2>

<input type="hidden" name="num" value="{{ $id }}">
<input type="hidden" name="type" value="{{ $type }}">
<table class="table table-bordered no-margin text-lg">
    <tr class="info" align="center">
        <td>Точка</td>
        <td>{{ $variants[0] }}</td>
        <td>{{ $variants[1] }}</td>
        <td>{{ $variants[2] }}</td>
    </tr>
    <tr align="center">
        <td class="info">Значение</td>
        <td>
            <input type="number" name="choice[]" value="">
        </td>
        <td>
            <input type="number" name="choice[]" value="">
        </td>
        <td>
            <input type="number" name="choice[]" value="">
        </td>
    </tr>
</table>
<br><br>
@if (!$is_adaptive)
    <div class="checkbox checkbox-styled checkbox-warning">
        <label>
            <input type="checkbox" name="seeLater" class="css-checkbox">
            <span class="css-checkbox text-lg">Вернуться позже</span>
        </label>
    </div>
@endif
{!! Form::close() !!}
<br>
</body>
</html>