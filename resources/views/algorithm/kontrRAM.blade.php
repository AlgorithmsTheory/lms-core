@extends('algorithm.RAMbase')

@section ('title')
Эмулятор Random Access Machine контрольная работа
@stop

@section('text')

<div id="test_seq"  style="display:none">{{ $test_seq }}</div>

<p class = 'lead'>
	<button type="button" id="btn_submit" class="btn ink-reaction btn-primary" onClick="submitTask()">Закончить работу</button>
	<h3 id="task" style="display:block">{{ $task }}</h3>
</p>
@stop

@section('js-down-addl')
	{!! HTML::script('js/ram/kontr_RAM.js') !!}
@stop