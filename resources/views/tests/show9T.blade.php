<html>
<body>
<div class="col-md-12 col-sm-6">
    {!! Form::open(['method' => 'PATCH', 'route' => 'question_checktest', 'class' => 'smart-blue']) !!}
    <h1>Вопрос {{ $count }}</h1>
    <h2>
        @for ($i = 0; $i < count($text); $i++)
            @if ($i % 2 == 0) {{ $text[$i] }}
            @else {!! HTML::image($text[$i]) !!}
            @endif
        @endfor
    </h2>
    <input type="hidden" name="num" value="{{ $id }}" />
    <input type="hidden" name="type" value="{{ $type }}" />

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
                {{ $choice[0] }}
            </td>
            <td>
                {{ $choice[1] }}
            </td>
            <td>
                {{ $choice[2] }}
            </td>
        </tr>
    </table>

    {!! Form::close() !!}
    <br>
</div>
</body>
</html>