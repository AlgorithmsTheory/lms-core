<html>
<body>
<h2>Вопрос номер {{ $id }}</h2>
<p>{{ $text }}</p>
{!! Form::open(['method' => 'PATCH', 'route' => 'question_checktest']) !!}
<input type="hidden" name="num" value="{{ $id }}">
<input type="hidden" name="type" value="{{ $type }}">
@foreach ($variants as $var)
<input type="radio"  name="choice" value="{{ $var }}"> {{ $var }} <br>
@endforeach
{!! Form::close() !!}
<br>
</body>
</html>