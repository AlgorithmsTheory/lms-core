<html>
<body>
<h1>Добро пожаловать в систему тестирования</h1>
<h2>Вопрос номер {{ $num }}</h2>
<p>{{ $text }}</p>
{!! Form::open(['method' => 'PATCH', 'route' => 'question_checktest']) !!}
<input type="hidden" name="answer" value="{{ $answer }}">
<input type="hidden" name="num" value="{{ $num }}">
<input type="hidden" name="type" value="{{ $type }}">
@foreach ($variants as $var)
<input type="radio"  name="choice" value="{{ $var }}"> {{ $var }} <br>
@endforeach
<input type="submit" name="check" value="Ответить">
{!! Form::close() !!}
<br>
<h2>Вы верно ответили на {{ $score }} из {{ $num-1 }}</h2>
</body>
</html>