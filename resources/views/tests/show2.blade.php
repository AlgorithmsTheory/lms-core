{!! Form::open(['method' => 'PATCH', 'route' => $route, 'class' => 'smart-blue question-form']) !!}
<h1>Вопрос {{ $count }}</h1>
<h2>
    @for ($i = 0; $i < count($text); $i++)
        @if ($i % 2 == 0) {{ $text[$i] }}
        @else {!! HTML::image($text[$i]) !!}
        @endif
    @endfor
</h2>
<input type="hidden" name="num" value="{{ $id }}">
<input type="hidden" name="type" value="{{ $type }}">
@foreach ($variants as $var)
<div class="checkbox checkbox-styled">
    <label>
        <input type="checkbox"  name="choice[]" value="{{ $var }}">
        <span class="text-lg"> {{ $var }}</span>
    </label>
</div>
@endforeach
<br><br>
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