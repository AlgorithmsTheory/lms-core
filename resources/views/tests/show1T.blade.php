<div class="col-md-12 col-sm-6">
{!! Form::open(['method' => 'PATCH', 'route' => 'question_checktest', 'class' => 'smart-blue']) !!}
<h1>Вопрос {{ $count }}</h1>
<h2>
    @for ($i = 0; $i < count($text); $i++)
        @if ($i % 2 == 0) {{ $text[$i] }}
        @else {!! HTML::image($text[$i]) !!}
        @endif
    @endfor
</h2>
<input type="hidden" name="num" value="{{ $id }}" />
<input type="hidden" name="type" value="{{ $type }}" />
@foreach ($variants as $var)
@if ($var == @$choice)
    <div class="radio radio-styled">
        <label>
            <input type="radio" name="choice" value="{{ $var }}" checked>
            <span class="text-lg"> {{ $var }} </span>
        </label>
    </div>
@else
    <div class="radio radio-styled">
        <label>
            <input type="radio" name="choice" value="{{ $var }}">
            <span class="text-lg"> {{ $var }} </span>
        </label>
    </div>
@endif
@endforeach
{!! Form::close() !!}
<br>
</div>
