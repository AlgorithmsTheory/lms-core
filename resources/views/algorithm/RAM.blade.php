@extends('templates.MTbase')
@section('head')
		<title>Эмулятор Random Access Machine</title>

		<!-- BEGIN META -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="your,keywords">
		<meta name="description" content="Short explanation about this website">
		<!-- END META -->

		<!-- BEGIN STYLESHEETS -->
		<link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
		{!! HTML::style('css/bootstrap.css?1422792965') !!}
		{!! HTML::style('css/materialadmin.css?1425466319') !!}
		{!! HTML::style('css/font-awesome.min.css?1422529194') !!}
		{!! HTML::style('css/material-design-iconic-font.min.css?1421434286') !!}
		{!! HTML::style('css/libs/jquery-ui/jquery-ui-theme.css?1423393666') !!}
		{!! HTML::style('css/libs/nestable/nestable.css?1423393667') !!}
		{!! HTML::style('css/RAM_style.css') !!}
		<!-- END STYLESHEETS -->
@stop

@section('content')
<!-- <section> -->
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
				<div class = "col-md-2 mt-5">
					<div class = "input-group mb-3">
						<div class = "input-group-prepend">
							<span class = "input-group-text"><b>R0</b></span>
						</div>
						<input type = "number" class = "form-control" value = "0" id = "r0">
					</div>
					<div class = "input-group mb-1">
						<div class = "input-group-prepend">
							<span class = "input-group-text"><b>R1</b></span>
						</div>
						<input type = "number" class = "form-control" value = "0" id = "r1">
					</div>
					<div class = "input-group mb-1">
						<div class = "input-group-prepend">
							<span class = "input-group-text"><b>R2</b></span>
						</div>
						<input type = "number" class = "form-control" value = "0" id = "r2">
					</div>
					<div class = "input-group mb-1">
						<div class = "input-group-prepend">
							<span class = "input-group-text"><b>R3</b></span>
						</div>
						<input type = "number" class = "form-control" value = "0" id = "r3">
					</div>
					<div class = "input-group mb-1">
						<div class = "input-group-prepend">
							<span class = "input-group-text"><b>R4</b></span>
						</div>
						<input type = "number" class = "form-control" value = "0" id = "r4">
					</div>

				</div>
				<div class = "col-md-2">
					<div class = "row justify-content-md-center">
						<div class = "col col-md-auto">	
							<div class="btn-group btn-block btn-primary mt-5" role="group" aria-label="Button group with nested dropdown">
								<div class="btn-group" role="group">
									<button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
									<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
										<span class="dropdown-item" id = "drop_debug">Debug</span>
										<span class="dropdown-item" id = "drop_run">Run</span>
										<span class="dropdown-item" id = "drop_animate">Animate</span>
									</div>
								</div>
								<button id = "btn_animate" type="button" class="btn btn-lg btn-block btn-primary">Debug</button>
							</div>
							<button type="button" class="btn btn-lg btn-block btn-primary" id = "btn_pause" disabled>Пауза</button>
							<button type="button" class="btn btn-lg btn-block btn-primary" id = "btn_next" disabled>След. Операция</button>
							<button type="button" class="btn btn-lg btn-block btn-primary" id = "btn_reset">Сброс</button>
							<button type="button" class="btn btn-lg btn-block btn-primary" id = "btn_save_doc">Сохранить в файл</button>
							<button type="button" class="btn btn-lg btn-block btn-primary" id = "btn_load_doc">Загрузить из файла</button>
							<button type="button" class="btn btn-lg btn-block btn-primary mb-5" id = "btn_help">Помощь</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class = "container-fluid">
			<div class = "row">
				<div class = "input-group mb-3 mt-3">
					<div class = "input-group-prepend">
						<span class = "input-group-text">Input</span>
					</div>
					<textarea class = "form-control" id = "input"></textarea>
				</div>
				<div class = "input-group mb-3">
					<div class = "input-group-prepend">
						<span class = "input-group-text">Output</span>
					</div>
					<textarea class = "form-control" id = "output" disabled></textarea>
				</div>
			</div>
		</div>
	</div>
<!-- </section> -->
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
		{!! HTML::script('/js/ram/ace-first-init.js') !!}
		{!! HTML::script('/js/ram/functional.js') !!}
		{!! HTML::script('/js/ram/button_functional.js') !!}
		<!-- END JAVASCRIPT -->
@stop


