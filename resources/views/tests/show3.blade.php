<html>
<body>
{!! Form::open(['method' => 'PATCH', 'route' => $route, 'class' => ['smart-blue', 'question-form']]) !!}
<h1>Вопрос {{ $count }}</h1>
<h2>Заполните пропуски в тексте</h2>
<input type="hidden" name="type" value="{{ $type }}">
<input type="hidden" name="num" value="{{ $id }}">
<p class="text-lg">
    @for ($i = 0; $i < $num_slot; $i++)
    {{ $text_parts[$i] }} <span><select name="{{$i}}">
            <option disabled selected class="text-lg">Вставьте пропущенное слово</option>
            @for ($j = 0; $j < $num_var[$i]; $j++)
            <option value="{{ $variants[$i][$j] }}" class="text-lg">{{ $variants[$i][$j] }}</option>
            @endfor
        </select></span>
    @endfor
    {{ $text_parts[$num_slot] }} </p>
@if (!$is_adaptive)
    <div class="checkbox checkbox-styled checkbox-warning">
        <label>
            <input type="checkbox" name="seeLater" class="css-checkbox">
            <span class="css-checkbox text-lg">Вернуться позже</span>
        </label>
    </div>
@endif
{!! Form::close() !!}
</body>
</html>