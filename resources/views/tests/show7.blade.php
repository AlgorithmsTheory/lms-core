<html>
<body>
{!! Form::open(['method' => 'PATCH', 'route' => 'question_checktest', 'class' => 'smart-blue']) !!}
<h1>Вопрос {{ $count }}</h1>
<h2>{{ $text }}</h2>
<input type="hidden" name="num" value="{{ $id }}">
<input type="hidden" name="type" value="{{ $type }}">
<div class="form-group">
    <textarea style="resize: vertical" name="choice" class="form-control" rows="5">Напишите определение</textarea>
</div>
<input type="checkbox" name="seeLater" class="css-checkbox"><span class="css-checkbox">Вернуться позже</span>
{!! Form::close() !!}
<br>
</body>
</html>