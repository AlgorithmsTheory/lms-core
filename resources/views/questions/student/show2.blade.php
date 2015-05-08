<html>
<body>
<h1>Добро пожаловать в систему тестирования</h1>
<p>{{ $text }}</p>
{!! Form::open(['method' => 'PATCH', 'route' => 'question_check']) !!}
<input type="hidden" name="type" value="{{ $type }}">
<input type="hidden" name="points" value="{{ $points }}">
<input type="hidden" name="answer" value="{{ $answer }}">
@foreach ($new_variants as $var)
<input type="checkbox"  name="choice[]" value="{{ $var }}"> {{ $var }} <br>
@endforeach
<input type="submit" name="check" value="Ответить">
{!! Form::close() !!}
</html>