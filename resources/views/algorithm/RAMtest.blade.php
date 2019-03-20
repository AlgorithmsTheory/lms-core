{!! HTML::style('css/RAM_style.css') !!}
		<div class = "container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="text-primary">Эмулятор Random Access Machine</h1>
				</div>
				<div class="col-lg-12">
					<article class="margin-bottom-xxl">
						<div id="test_seq"  style="display:none">{{ $test_seq }}</div>
						<p class = 'lead'>
							<button type="button" id="btn_submit" class="btn ink-reaction btn-primary" onClick="ramSubmitTask(true)">Закончить работу</button>
							<h3 id="task" style="display:block">{{ $task }}</h3>
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
									<li id = "drop_debug"><a>Отладка</a></li>
									<li id = "drop_animate"><a>Анимация</a></li>
									<li id = "drop_run"><a>Исполнение</a></li>
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
				<div class="form-horizontal">
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
				</div>
			</div>
		</div>
<!-- BEGIN JAVASCRIPT -->
{!! HTML::script('js/ram/popper.min.js') !!}

{!! HTML::script('js/ram/bootstrap.min.js') !!}

{!! HTML::script('js/ram/src-noconflict/ace.js') !!}
{!! HTML::script('js/ram/RAM.js') !!}
{!! HTML::script('js/ram/kontr_RAM.js') !!}
