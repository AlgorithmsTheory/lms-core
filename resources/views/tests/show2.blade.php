<html>
<body>
<h2>Вопрос номер {{ $id }}</h2>
<p>{{ $text }}</p>
{!! Form::open(['method' => 'PATCH', 'route' => 'question_checktest']) !!}
<input type="hidden" name="num" value="{{ $id }}">
<input type="hidden" name="type" value="{{ $type }}">
@foreach ($variants as $var)
<input type="checkbox"  name="choice[]" value="{{ $var }}"> {{ $var }} <br>
@endforeach
<input type="submit" name="check" value="Ответить">
{!! Form::close() !!}
<br>
</body>
</html>