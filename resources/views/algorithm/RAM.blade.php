@extends('templates.MTbase')
@section('head')
		<title>Эмулятор Random Access Machine</title>

		<!-- BEGIN META -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
		<meta name="keywords" content="your,keywords">
		<meta name="description" content="Short explanation about this website">
		<!-- END META -->

		<!-- BEGIN STYLESHEETS -->
		{!! HTML::style('css/RAM_style.css') !!}
		<!-- END STYLESHEETS -->
@stop
		
@section('content')
	<div class="section-body contain-lg">
		<div class = "container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="text-primary">Random Access Machine Emulator</h1>
				</div>
				<div class="col-lg-12">
					<article class="margin-bottom-xxl">
						<p class="lead">
							Данный эмулятор предназначен для получения навыков написания алгоритмов, а также для проверки решения задач. Перед работой ВНИМАТЕЛЬНО ознакомьтесь со справкой (кнопка "Помощь")
						</p>
					</article>
				</div>
			</div>
		</div>
		<div class = "container-fluid">
			<div class = "row">
				<div class = "col-md-8">
					<div id = "editor">
					</div>
				</div>
				<div class = "col-md-2">
					<div class = "input-group mb-3">
						<span class="input-group-addon"><b>R0</b></span>
						<input type = "number" class = "form-control" value = "0" id = "r0">
					</div>
					<div id = "registerContainer">
						<div class = "input-group mb-1">
							<span class="input-group-addon"><b>R1</b></span>
							<input type = "number" class = "form-control" value = "0" id = "r1">
						</div>
					</div>	
				</div>
				<div class = "col-md-2">
					<div class = "row justify-content-md-center">
						<div class = "col col-md-auto">	
							<div class="dropdown">
								<button class="btn btn-block btn-primary dropdown-toggle" type="button" id="dropdownChoiceMod" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
									<span id = "mod">Отладка</span>
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" aria-labelledby="dropdownChoiceMod">
									<li id = "drop_debug"><a href="#">Отладка</a></li>
									<li id = "drop_animate"><a href="#">Анимация</a></li>
									<li id = "drop_run"><a href="#">Исполнение</a></li>
								</ul>
							</div>
							</br>
							<button type="button" class="btn btn-block btn-primary mt-5" id = "btn_start">Старт</button>
							<button type="button" class="btn btn-block btn-primary" id = "btn_pause" disabled>Пауза</button>
							<button type="button" class="btn btn-block btn-primary" id = "btn_next" disabled>След. Операция</button>
							<button type="button" class="btn btn-block btn-primary" id = "btn_reset">Сброс</button>
							<button type="button" class="btn btn-block btn-primary" id = "btn_save_doc">Сохранить в файл</button>
							<button type="button" class="btn btn-block btn-primary" id = "btn_load_doc">Загрузить из файла</button>
							<button type="button" class="btn btn-block btn-primary mb-5" id = "btn_help">Помощь</button>
							</br></br></br>
							<div class = "row justify-content-md-center">
								<div class = "col-md-10 col-md-offset-1">
									<b>Работа с регистрами</b>
								</div>
							</div>
							<div class = "row">
								<div class = "col-md-2">
									<button type="button" class="btn btn-block btn-primary" id = "btn_reg_plus">+</button>
								</div>
								<div class = "col-md-2">
									<button type="button" class="btn btn-block btn-primary" id = "btn_reg_minus">-</button>
								</div>
								<div class = "col-md-8">
									<button type="button" class="btn btn-block btn-primary" id = "btn_reg_default">default</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class = "container-fluid">
			<div class = "row">
				<form class="form-horizontal">
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label"><b>Входная лента</b></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="input" placeholder="">
						</div>
					</div>
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label"><b>Выходная лента</b></label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="output" placeholder="">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<!--end #content-->
@stop		
		<!--end #base-->
		<!-- END BASE -->
@section('js-down')
		<!-- BEGIN JAVASCRIPT -->
		{!! HTML::script('/js/ram/jquery-2.1.1.min.js') !!}
		{!! HTML::script('/js/ram/popper.min.js') !!}
		{!! HTML::script('/js/ram/bootstrap.min.js') !!}
		{!! HTML::script('/js/ram/src-noconflict/ace.js') !!}
		
		{!! HTML::script('/js/ram/RAM.js') !!}
		<!-- END JAVASCRIPT -->
@stop


