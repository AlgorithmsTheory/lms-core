@extends('templates.base')
@section('head')
		<title>Добавление заданий</title>

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
		<!-- END STYLESHEETS -->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script type="text/javascript" src="/laravel/resources/assets/js/libs/utils/html5shiv.js?1403934957"></script>
		<script type="text/javascript" src="/laravel/resources/assets/js/libs/utils/respond.min.js?1403934956"></script>
		<![endif]-->

	@stop

    @section('content')


				<!-- BEGIN LIST SAMPLES -->
		<section>
			<div class="section-header">
				<ol class="breadcrumb">				
					<li>{!! HTML::linkRoute('main_menu', 'Администрирование') !!}</li>
					<li>{!! HTML::linkRoute('ramManageTask', 'Контрольные материалы RAM') !!}</li>
					<li class="active">Добавление контрольного материала</li>
				</ol>
			</div>
			<div class="section-body contain-lg">
				<div class="row">
					<div class="col-lg-8">
						<h1 class="text-primary">Работа с контрольным материалом по теме "Random Access Machine"</h1>
					</div>
					<div class="col-lg-8">
						<article class="margin-bottom-xxl">
							<p class="lead">
								Добавить/удалить задачи и тестовые последовательности 
							</p>
						</article>
					</div>
				</div>
				<div class="col-lg-12">
					<h4>Форма для ввода новой задачи</h4>
				</div>
				<div class="col-lg-3 col-md-4">
					<article class="margin-bottom-xxl">
						<ul class="list-divided">
							<li>
								Введите текст новой задачи и другие параметры. 
							</li>
							<li>
								В поле тестовых последовательностей для входных слов используйте примерно 10 символов
							</li>
						</ul>
					</article>
				</div>
				<div class="col-lg-offset-1 col-md-6 col-sm-6">
					<form class="form form-validate floating-label" novalidate="novalidate" method="post" action="{{URL::route('ramAddingTask')}}" id="RAM_tasks">
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<div class="card">
								<div class="card-head style-primary">
									<header>Добавить задание</header>
								</div>
								<div class="card-body">	
									<div class="form-group">
										<textarea name="task_text" id="task_text" class="form-control" rows="3" required="" aria-required="true"></textarea>
										<label for="task_text">Условие</label>
									</div>
									<div class="form-group">
										<select id="max_mark" name="max_mark" class="form-control" required="" aria-required="true">
											<option value="">&nbsp;</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
										</select>
										<label for="max_mark">Максимальный балл</label>
									</div>
									<div class="form-group">
										<select id="level" name="level" class="form-control" required="" aria-required="true">
											<option value="">&nbsp;</option>
											<option value="1">1</option>
											<option value="2">2</option>		
										</select>
										<label for="level">Уровень сложности</label>
										<p class="help-block">1 - легкий, 2 - сложный</p>
									</div>
									<div class="form-group">
										<select id="variant" name="variant" class="form-control" required="" aria-required="true">
											<option value="">&nbsp;</option>
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
											<option value="7">7</option>
											<option value="8">8</option>											
										</select>
										<label for="level">Вариант</label>
									</div>									
									<h4>Тестовые последовательности:</h4>
										<div class="input-group">
													<div class="input-group-content">
														<input type="text" id="input_word" class="form-control" placeholder="Входное слово" name="input_word">
													</div>
													<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
													<div class="input-group-content">
														<input type="text" id="output_word" class="form-control" placeholder="Верное преобразование" name="output_word">
													</div>
										</div>
										<div class="input-group">
													<div class="input-group-content">
														<input type="text" id="input_word1" class="form-control" placeholder="Входное слово" name="input_word1">
													</div>
													<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
													<div class="input-group-content">
														<input type="text" id="output_word1" class="form-control" placeholder="Верное преобразование" name="output_word1">
													</div>
										</div>
										<div class="input-group">
													<div class="input-group-content">
														<input type="text" id="input_word2" class="form-control" placeholder="Входное слово" name="input_word2">
													</div>
													<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
													<div class="input-group-content">
														<input type="text" id="output_word2" class="form-control" placeholder="Верное преобразование" name="output_word2">
													</div>
										</div>
										<div class="input-group">
													<div class="input-group-content">
														<input type="text" id="input_word3" class="form-control" placeholder="Входное слово" name="input_word3">
													</div>
													<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
													<div class="input-group-content">
														<input type="text" id="output_word3" class="form-control" placeholder="Верное преобразование" name="output_word3">
													</div>
										</div>
										<div class="input-group">
													<div class="input-group-content">
														<input type="text" id="input_word4" class="form-control" placeholder="Входное слово" name="input_word4">
													</div>
													<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
													<div class="input-group-content">
														<input type="text" id="output_word4" class="form-control" placeholder="Верное преобразование" name="output_word4">
													</div>
										</div>
								</div><!--end .card-body -->
								<div class="card-actionbar">
									<div class="card-actionbar-row">
										<button  class="btn btn-flat btn-primary ink-reaction" >Добавить</button>
									</div>
								</div>
							</div><!--end .card -->
					</form>	
				</div>		
			</div>				
		</section>
			
		@stop		
<!--end #content-->
		<!-- END BASE -->

		<!-- BEGIN JAVASCRIPT -->
@section('js-down')
		<!-- BEGIN JAVASCRIPT -->
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
		{!! HTML::script('js/libs/utils/send.js') !!}
		{!! HTML::script('js/core/demo/DemoUIMessages.js') !!}
		{!! HTML::script('js/libs/toastr/toastr.js') !!}
		<!-- END JAVASCRIPT -->
@stop
