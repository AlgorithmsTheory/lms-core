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
<input type="hidden" name="num" value="{{ $id }}">
<input type="hidden" name="type" value="{{ $type }}">
@foreach ($variants as $var)
<?php $flag = false; ?>
@foreach ($choice as $ch)
@if ($var == $ch)
    <div class="checkbox checkbox-styled">
        <label>
            <input type="checkbox"  name="choice[]" value="{{ $var }}" checked>
            <span class="text-lg"> {{ $var }}</span>
        </label>
    </div>
<?php $flag = true;?>
@endif
@endforeach
@if ($flag == false)
    <div class="checkbox checkbox-styled">
        <label>
            <input type="checkbox"  name="choice[]" value="{{ $var }}">
            <span class="text-lg"> {{ $var }}</span>
        </label>
    </div>
@endif
@endforeach
{!! Form::close() !!}
</div>
<br><br><br>
