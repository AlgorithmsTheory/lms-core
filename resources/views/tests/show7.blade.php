<html>
<body>
{!! Form::open(['method' => 'PATCH', 'route' => $route, 'class' => ['smart-blue', 'question-form']]) !!}
<h1>Вопрос {{ $count }}</h1>
<h2>{{ $text }}</h2>
<input type="hidden" name="num" value="{{ $id }}">
<input type="hidden" name="type" value="{{ $type }}">
<div class="form-group">
    <textarea style="resize: vertical" name="choice" class="form-control" rows="5">Напишите определение</textarea>
</div>
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