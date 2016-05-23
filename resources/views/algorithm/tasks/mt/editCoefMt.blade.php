@extends('templates.base')
@section('head')
		<title>Изменение коэффициентов</title>

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
							<li>{!! HTML::linkRoute('alltasksmt', 'Контрольные материалы МТ') !!}</li>
							
							<li class="active">Редактирование коэффициентов для оценивания</li>
						</ol>
					</div>
					<div class="section-body contain-lg">
					
						<div class="row">
							<div class="col-lg-12">
								<h1 class="text-primary">Работа с контрольным материалом по теме "Машины Тьюринга"</h1>
							</div><!--end .col -->
							<div class="col-lg-8">
								<article class="margin-bottom-xxl">
									<p class="lead">
										Здесь можно изменить коэффициенты, по которым ведется оценивание контрольных работ на эмуляторе
									</p>
								</article>
							</div><!--end .col -->
							
						</div>
						<!-- BEGIN NESTABLE LISTS -->
				

				<div class="col-lg-6">

<div class="card">
			
			<form class="form form-validate floating-label" novalidate="novalidate" method="post"  action="{{URL::route('editAllCoefMt', array('id_task'=> "1"))}}">
				<div class="modal-body">
					<div class="input-group">
						<div class="input-group-content">
							<label for="amount9">Коэффициент для строк</label>
							<input type="text" id="old_rows" class="form-control" name="old_effic"  aria-required="true"value="<?php echo $result['rows_coef']; ?>" disabled/>
						
						</div>
						<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
						<div class="input-group-content">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<div class="form-group">
							<input type="text" id="new_rows" class="form-control" placeholder="Новое значение R" data-rule-number="true" aria-required="true" name="new_rows"  / >
							</div>
						</div>
					</div>
					
				</div>
				<div class="modal-body">

					<div class="input-group">
						<div class="input-group-content">
							<label for="amount9">Параметр учета времени:</label>
							<input type="text" id="old_time" class="form-control" name="old_time"  value="B = <?php echo $result['time_coef_b']; ?>" disabled/>
						</div>
						<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
						<div class="input-group-content">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<div class="form-group">
							<input type="text" id="new_time_b" class="form-control" placeholder="Новое значение B" data-rule-number="true" aria-required="true" name="new_time_b"  / >
						
						</div>
						</div>

					</div>

</div>
<div class="modal-body">
					<div class="input-group">
						<div class="input-group-content">
							<label for="amount9">Параметр учета балла:</label>
							<input type="text" id="old_time" class="form-control" name="old_time"  value="A = <?php echo $result['time_coef_a']; ?>" disabled/>
						</div>
						<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
						<div class="input-group-content">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<div class="form-group">
							<input type="text" id="new_time_a" class="form-control" placeholder="Новое значение A" data-rule-number="true" aria-required="true" name="new_time_a"  / >
						
						</div>
						</div>
						
					</div>
					
				</div>
				<div class="modal-body">
					<div class="input-group">
						<div class="input-group-content">
							<label for="amount9">Тактовый коэффициент</label>
							<input type="text" id="old_cycle" class="form-control" name="old_effic"  aria-required="true"value="<?php echo $result['cycle_coef']; ?>" disabled/>
						
						</div>
						<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
						<div class="input-group-content">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<div class="form-group">
							<input type="text" id="new_cycle" class="form-control" placeholder="Новое значение C" data-rule-number="true" aria-required="true" name="new_cycle"  / >
							</div>
						</div>
					</div>
					
				</div>
				<div class="modal-body">
					<div class="input-group">
						<div class="input-group-content">
							<label for="amount9">Коэфф. состояний и символов</label>
							<input type="text" id="old_sum" class="form-control" name="old_effic"  aria-required="true"value="<?php echo $result['sum_coef']; ?>" disabled/>
						
						</div>
						<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
						<div class="input-group-content">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<div class="form-group">
							<input type="text" id="new_sum" class="form-control" placeholder="Новое значение S" data-rule-number="true" aria-required="true" name="new_sum"  / >
							</div>
						</div>
					</div>
					
				</div>
				<button style="left:450px"class="btn ink-reaction btn-raised btn-primary" type="submit" name="submit"> Изменить </button>
		
			</form>
				</br>
</div>
	
		</div>
		<div class="col-lg-6">
		<div class="card">
									<div class="card-head card-head-xs style-primary">
										<header>Как происходит оценивание?</header>
										<div class="tools">
											<a class="btn btn-icon-toggle btn-close"><i class="md md-close"></i></a>
										</div>
									</div><!--end .card-head -->
									<div class="card-body">
										Оценка за задачу формируется с помощью параметров, представленных слева, а также максимального балла за задачу (недоступно для редактирования).
										<p>Общая формула оценивания каждой задачи имеет следующий вид:</p>
										<blockquote>O  =  K * M * R * T * C * S,    где</blockquote>
										<p>K - количество верно отлаженных последовательностей</p>
										<p>M - максимальный балл за задачу</p>
										<p>R - коэфициент строк алгоритма. Применяется в случае, если n₀/n’ > 1, где n₀ – наименьшее количество строк алгоритма, а n’ – число строк в алгоритме, написанном студентом</p>
										<p>T - временной коэффициент. Для его расчета используется формула: </p>
										<blockquote>T  =  1-arctg(B*(x-A))/π,    где</blockquote>
										<p>A – время, когда баллы за очень быструю сдачу начинают сгорать</p>
										<p>B – определяет насколько быстро начинают сгорать баллы за время A</p>

										<p>С - тактовый коэфициент. Применяется, если t₀ /t’ > 1, где t’ – число тактов машины Тьюринга при выполнении алгоритма, написанного студентом, а t₀ – наименьшее или «эталонное» число тактов машины</p>
										<p>S - коэффициент количества символов и состояний. Применяется, если s₀/s’ > 1, где s’ - минимальная сумма символов и состояний, а s₀ - сумма символов и состояний алгоритма, написанного студентом</p>
									</div><!--end .card-body -->
								</div>
								</div>

</div>
								
				</section>
			<!--end #content-->
@stop		

		<!--end #base-->
		<!-- END BASE -->
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


