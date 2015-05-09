<html>
<body>
<h2>Вопрос номер {{ $id }}</h2>
{!! Form::open(['method' => 'PATCH', 'route' => 'question_checks']) !!}
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
{!! Form::close() !!}
</body>
</html>