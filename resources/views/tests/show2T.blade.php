4 lines (24 sloc)  779 Bytes
<html>
<body>
{!! Form::open(['method' => 'PATCH', 'route' => 'question_checktest', 'class' => 'smart-blue']) !!}
<h1>Вопрос {{ $count }}</h1>
<h2>{{ $text }}</h2>
<input type="hidden" name="num" value="{{ $id }}">
<input type="hidden" name="type" value="{{ $type }}">
@foreach ($variants as $var)
<?php $flag = false; ?>
@foreach ($choice as $ch)
@if ($var == $ch)
<input type="checkbox"  name="choice[]" value="{{ $var }}" checked> {{ $var }} <br>
<?php $flag = true;?>
@endif
@endforeach
@if ($flag == false)
<input type="checkbox"  name="choice[]" value="{{ $var }}"> {{ $var }} <br>
@endif
@endforeach
<input type="checkbox" name="seeLater" class="css-checkbox"><span class="css-checkbox">Вернуться позже</span>
{!! Form::close() !!}
<br>
</body>
</html>