@extends('templates.MTbase')
@section('head')
		<title>@yield('title')</title>

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
					<h1 class="text-primary">Эмулятор Random Access Machine</h1>
				</div>
				<div class="col-lg-12">
					<article class="margin-bottom-xxl">
						@yield('text')
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
							</br>
							<button type="button" class="btn btn-block btn-primary" id = "btn_save_doc">Сохранить в файл</button>
							</br>
							<input type="file" class="btn btn-block ink-reaction btn-raised btn-xs btn-primary" id="fileToLoad">
							<button type="button" class="btn btn-block btn-primary" id = "btn_load_doc">Загрузить из файла</button>
							</br>
							<a class="btn btn-block btn-primary" href="#offcanvas-demo-right" data-toggle="offcanvas" id = "btn_help">
								<span>Помощь </span><i class="md md-help"></i>
							</a>
							</br>
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
									<button type="button" class="btn btn-block btn-primary" id = "btn_reg_default">Стандартно</button>
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
	
	<div class="offcanvas">
		<div id="offcanvas-demo-right" class="offcanvas-pane width-10" style="">
			<div class="offcanvas-head">
				<header>Как работать с эмулятором</header>
				<div class="offcanvas-tools">
					<a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
						<i class="md md-close"></i>
					</a>
				</div>
			</div>
			<div class="nano has-scrollbar" style="height: 318px;"><div class="nano-content" tabindex="0" style="right: -17px;"><div class="offcanvas-body">

			<p>
				Введите программный код для RAM в редактор кода, а также исходные данные во входную ленту, после чего можно запустить эмулятор, нажав кнопку "Старт". Текст программы имеет подсветку синтаксиса. Вы можете оставлять комментарии, используя символы “//”. Входная лента должна быть заполнена необходимым количеством натуральных чисел, разделенных через пробел. Также при необходимости можно задать начальные значения регистров.
			</p>
			
			<h4>Команды RAM:</h4>
				<ul class="list-divided">
					<li>READ – читает значение с входной ленты в R0</li>
					<li>WRITE – записывает значение из R0 на выходную ленту</li>
					<li>LOAD i – записывает значение i в R0</li>
					<li>LOAD [i] – записывает значение Ri в R0</li>
					<li>LOAD [[i]] – записывает значение из регистра, на который ссылается регистр Ri, в R0</li>
					<li>STORE [i] – записывает значение из R0 в Ri</li>
					<li>STORE [[i]] – записывает значение из R0 в регистр, на который ссылается   i-й регистр</li>
					<li>ADD i  – добавляет к значению в R0 значение i</li>
					<li>ADD [i] – добавляет к значению в R0 значение из Ri</li>
					<li>ADD [[i]] – добавляет к значению в R0 значение регистра, на который ссылается Ri</li>
					<li>SUB i  – вычитает из значения в R0 значение i</li>
					<li>SUB [i] – вычитает из значения в R0 значение из Ri</li>
					<li>SUB [[i]] – вычитает из значения в R0 значение регистра, на который ссылается Ri</li>
					<li>MULT i / [i] / [[i]] – домножает R0 по аналогии</li>
					<li>DIV i / [i] / [[i]] – делит R0 по аналогии</li>
					<li>JUMP b – переходим на команду с меткой b</li>
					<li>JGTZ b – если R0 > 0, то переходим на команду с меткой b</li>
					<li>JZERO b – если R0 = 0, то переходим на команду с меткой b</li>
					<li>“name:” – данная команда ставит метку с названием name</li>
					<li>HALT – завершение программы</li>
				</ul>
			<h4>Режимы эмулятора:</h4>
				<ul class="list-divided">
					<li>Отладка - выполнение программы по строкам. Для выполнения всех операций выделенной строки нажмите кнопку «След. Операция».</li>
					<li>Анимация - постепенное выполнение программы. Чтобы остановить исполнение нажмите кнопку «Пауза».</li>
					<li>Исполнение - мгновенное исполнение программы.</li>
				</ul>
				После завершения исполнения программы в любом из режимов нажмите кнопку "Сброс", чтобы разблокировать текстовый редактор и обнулить значения регистров. Также вы можете сохранять и загружать программный код с помощью соответствующих кнопок.
			</div></div><div class="nano-pane"><div class="nano-slider" style="height: 199px; transform: translate(0px, 0px);"></div></div></div>
		</div>
	</div>
<!--end #content-->
@stop		
		<!--end #base-->
		<!-- END BASE -->
@section('js-down')
		<!-- BEGIN JAVASCRIPT -->
		@yield('js-down-addl')
		{!! HTML::script('/js/ram/popper.min.js') !!}
		{!! HTML::script('/js/ram/src-noconflict/ace.js') !!}
		
		{!! HTML::script('/js/ram/RAM.js') !!}
		
		{!! HTML::script('js/algorithms/jquery-1.4.3.min.js') !!}
		{!! HTML::script('js/algorithms/jquery-1.10.2.js') !!}
		{!! HTML::script('js/algorithms/symbols.js') !!}
		{!! HTML::script('js/algorithms/saving.js') !!}
		{!! HTML::script('js/algorithms/superScript.js') !!}
		{!! HTML::script('js/libs/jquery/jquery-1.11.2.min.js') !!}
		{!! HTML::script('js/libs/jquery/jquery-migrate-1.2.1.min.js') !!}
		{!! HTML::script('js/libs/jquery-ui/jquery-ui.min.js') !!}
		{!! HTML::script('js/libs/bootstrap/bootstrap.min.js') !!}
		{!! HTML::script('js/libs/spin.js/spin.min.js') !!}
		{!! HTML::script('js/libs/jquery-validation/dist/jquery.validate.min.js') !!}
		{!! HTML::script('js/libs/jquery-validation/dist/additional-methods.min.js') !!}
		{!! HTML::script('js/libs/autosize/jquery.autosize.min.js') !!}
		{!! HTML::script('js/libs/nestable/jquery.nestable.js') !!}
		{!! HTML::script('js/libs/nanoscroller/jquery.nanoscroller.min.js') !!}
		{!! HTML::script('js/core/source/App.js') !!}
		{!! HTML::script('js/core/source/AppNavigation.js') !!}
		{!! HTML::script('js/core/source/AppOffcanvas.js') !!}
		{!! HTML::script('js/core/source/AppCard.js') !!}
		{!! HTML::script('js/core/source/AppForm.js') !!}
		{!! HTML::script('js/core/source/AppNavSearch.js') !!}
		{!! HTML::script('js/core/source/AppVendor.js') !!}
		{!! HTML::script('js/core/demo/Demo.js') !!}
		{!! HTML::script('js/core/demo/DemoUILists.js') !!}
		{!! HTML::script('js/algorithms/send.js') !!}
		{!! HTML::script('js/core/demo/DemoUIMessages.js') !!}
		{!! HTML::script('js/libs/toastr/toastr.js') !!}
		<!-- END JAVASCRIPT -->
@stop


