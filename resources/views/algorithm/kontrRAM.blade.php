@extends('algorithm.RAMbase')

@section ('title')
Эмулятор Random Access Machine контрольная работа
@stop

@section('text')
<div id="task"      style="display:none">1</div>
<div id="level"  	style="display:none">easy</div>

<div id="easy2code" style="display:none"></div>
<div id="easy3code" style="display:none"></div>
<div id="hard3code" style="display:none"></div>
<div id="hard4code" style="display:none"></div>

<div id="easy2seq"  style="display:none">{{ $tasks['easy2_seq'] }}</div>
<div id="easy3seq"  style="display:none">{{ $tasks['easy3_seq'] }}</div>
<div id="hard3seq"  style="display:none">{{ $tasks['hard3_seq'] }}</div>
<div id="hard4seq"  style="display:none">{{ $tasks['hard4_seq'] }}</div>

<div id="mytimer"></div>
<p class = 'lead'>
	<div class="col-lg-4">
		<div class="card">
			<div class="card-head">
				<ul class="nav nav-tabs nav-justified" data-toggle="tabs">
					<li id="task1" class="active"><a>Задача 1</a></li>
					<li id="task2" class=""      ><a>Задача 2</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="card">
			<div class="card-head">
				<ul class="nav nav-tabs nav-justified" data-toggle="tabs">
					<li id="easy" class="active" ><a>Задача Легкая</a></li>
					<li id="hard" class="" 	     ><a>Задача Сложная</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-lg-2">
		<br>
		<button type="button" id="btn_submit" class="btn ink-reaction btn-primary" onClick="submitTask()">Закончить работу</button>
	</div>
	<div class="col-lg-12">
		<h3 id="easy2" style="display:block">{{ $tasks['easy2'] }}</h3>
		<h3 id="hard3" style="display:none"> {{ $tasks['hard3'] }}</h3>
		<h3 id="easy3" style="display:none"> {{ $tasks['easy3'] }}</h3>
		<h3 id="hard4" style="display:none"> {{ $tasks['hard4'] }}</h3>
	</div>
</p>
@stop

@section('js-down-addl')
	{!! HTML::script('js/algorithms/timer.js') !!}
	{!! HTML::script('js/ram/kontr_RAM.js') !!}
	<script>
	var s = <?php echo $remain_time['s']; ?>;
	var i = <?php echo $remain_time['i']; ?>;
	var h = <?php echo $remain_time['h']; ?>;
	var d = <?php echo $remain_time['d']; ?>;
	var m = <?php echo $remain_time['m']; ?>;
	var y = <?php echo $remain_time['y']; ?>;
	if(y > 0 || m > 0 || d > 0)
		$("#mytimer").html("<h3>Время не ограничено</h3>");
	else
		countDown( s + i*60 + h*3600 );
	</script>
@stop