<html>
<body>
{!! Form::open(['method' => 'PATCH', 'route' => 'question_checks', 'class' => 'smart-blue']) !!}
<h1>Вопрос {{ $count }}</h1>
<h2>Заполните пропуски в тексте</h2>
<input type="hidden" name="type" value="{{ $type }}">
<input type="hidden" name="num" value="{{ $id }}">
<p>
    @for ($i = 0; $i < $num_slot; $i++)
    {{ $text_parts[$i] }} <span><select name="{{$i}}">
            <option disabled selected>Вставьте пропущенное слово</option>
            @for ($j = 0; $j < $num_var[$i]; $j++)
            <option value="{{ $variants[$i][$j] }}">{{ $variants[$i][$j] }}</option>
            @endfor
        </select></span>
    @endfor
    {{ $text_parts[$num_slot] }} </p>
<input type="checkbox" name="seeLater" class="css-checkbox"><span class="css-checkbox">Вернуться позже</span>
{!! Form::close() !!}
</body>
</html>