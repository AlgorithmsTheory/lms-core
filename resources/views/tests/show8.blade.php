<html>
<body>
{!! Form::open(['method' => 'PATCH', 'route' => 'question_checktest', 'class' => 'smart-blue']) !!}
<h1>Вопрос {{ $count }}</h1>
<h2>
    @for ($i = 0; $i < count($text); $i++)
        @if ($i % 2 == 0) {{ $text[$i] }}
        @else {!! HTML::image($text[$i]) !!}
        @endif
    @endfor
</h2>
<input type="hidden" name="num" value="{{ $id }}">
<input type="hidden" name="type" value="{{ $type }}">
<input type="text" name="choice" value="" placeholder="Напишите ответ в любом виде">
<br><br>
<div class="checkbox checkbox-styled checkbox-warning">
    <label>
        <input type="checkbox" name="seeLater" class="css-checkbox">
        <span class="css-checkbox text-lg">Вернуться позже</span>
    </label>
</div>
{!! Form::close() !!}
<br>
</body>
</html>