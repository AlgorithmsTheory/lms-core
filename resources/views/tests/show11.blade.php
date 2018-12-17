<html>
<body>
{!! Form::open(['method' => 'PATCH', 'route' => $route, 'class' => 'smart-blue']) !!}
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
<div class="row">
<div class="col-md-1 col-sm-1">
    <h2 align="right" style="margin-top: 0px;">F(x,y)=</h2>
</div>
<div class="col-md-11 col-sm-11">
    <input type="text" name="choice" value="" placeholder="Напишите аналитический вид функции относительно переменных x, y">
</div>
</div>
<br>
<p>
    <strong>Примечание:</strong>
    допускается использование только переменных x, y (латинские символы); чисел; операций +, *, - (псевдоразность), ^ (возведение в степень); скобок, пробелов.
</p>
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