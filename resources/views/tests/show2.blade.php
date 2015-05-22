<html>
<body>
{!! Form::open(['method' => 'PATCH', 'route' => 'question_checktest', 'class' => 'smart-blue']) !!}
<h1>Вопрос {{ $count }}</h1>
<h2>{{ $text }}</h2>
<input type="hidden" name="num" value="{{ $id }}">
<input type="hidden" name="type" value="{{ $type }}">
@foreach ($variants as $var)
<input type="checkbox"  name="choice[]" value="{{ $var }}"> {{ $var }} <br>
@endforeach
{!! Form::close() !!}
<br>
</body>
</html>