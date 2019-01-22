<div class="col-md-12 col-sm-6">
{!! Form::open(['method' => 'PATCH', 'class' => 'smart-blue']) !!}
<h1>Вопрос {{ $count }}</h1>
<h2>Заполните пропуски в тексте</h2>
<input type="hidden" name="type" value="{{ $type }}">
<input type="hidden" name="num" value="{{ $id }}">
<p class="text-lg">
    @for ($i = 0; $i < $num_slot; $i++)
    {{ $text_parts[$i] }} <span><select name="{{$i}}">
            <option disabled selected class="text-lg">Вставьте пропущенное слово</option>
            @for ($j = 0; $j < $num_var[$i]; $j++)
            <?php $flag = false; ?>
            @foreach ($choice as $ch)
            @if ($variants[$i][$j] == $ch)
            <option value="{{ $variants[$i][$j] }}" selected class="text-lg">{{ $variants[$i][$j] }}</option>
            <?php $flag = true;?>
            @endif
            @endforeach
            @if ($flag == false)
            <option value="{{ $variants[$i][$j] }}" class="text-lg">{{ $variants[$i][$j] }}</option>
            @endif
            @endfor
        </select></span>
    @endfor
    {{ $text_parts[$num_slot] }} </p>
{!! Form::close() !!}
</div>