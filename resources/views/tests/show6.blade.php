<html>
<body>
{!! Form::open(['method' => 'PATCH', 'route' => $route, 'class' => ['smart-blue', 'question-form']]) !!}
<h1>Вопрос {{ $count }}</h1>
<h2>{{ $text }}</h2>
<input type="hidden" name="num" value="{{ $id }}">
<input type="hidden" name="type" value="{{ $type }}">
<div class="form-group">
    <textarea style="resize: vertical" name="choice[1]" class="form-control" rows="5">Напишите или продолжите формулировку</textarea>
</div>
<h2>Доказательство:</h2>
<div class="form-group">
    <textarea style="resize: vertical" name="choice[0]" class="form-control" rows="5">Напишите доказательство</textarea>
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