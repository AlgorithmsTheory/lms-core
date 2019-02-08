@extends('templates.base')
@section('head')
		<title>Настройка дат и групп по НАМ</title>

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
			<li class="active">Редактирование дат контрольных мероприятий</li>
		</ol>
	</div>
	<div class="section-body contain-lg">				
		<div class="row">
			<div class="col-lg-12">
				<h1 class="text-primary">Редактирование дат контрольных мероприятий</h1>
			</div><!--end .col -->
			<div class="col-lg-8">
				<article class="margin-bottom-xxl">
					<p class="lead">
						Здесь можно настроить даты и группы для проведения контрольной работы по теме эмулятор @if ($emr_id == 1) Тьюринга 
																											   @elseif ($emr_id == 2) Маркова 
																											   @elseif ($emr_id == 4) RAM
																											   @else Поста
																											   @endif 
					</p>
				</article>
			</div><!--end .col -->			
		</div>
		<!-- BEGIN NESTABLE LISTS -->		
		<div class="col-lg-6">
			<div class="card">
				<form class="form form-validate floating-label" novalidate="novalidate" method="post"  action="{{URL::route('editAllDate', array('emr_id' => $emr_id))}}">
				<div class="modal-body">
					<h3><label>
						@if ($emr_id == 1) Эмулятор Тьюринга:
						@elseif ($emr_id == 2) Эмулятор Маркова:
						@elseif ($emr_id == 4) Эмулятор RAM:
						@else Поста Эмулятор Поста:
						@endif 
					</label></h3>
					<div class="input-group">
						<div class="input-group-content">	
							<input type="text" id="old_nam_start" class="form-control" name="old_nam_start"   value="Дата открытия работы:" disabled/>
						</div>
						<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
						<div class="input-group-content">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<div class="form-group">
								<input type="text" id="new_start" class="form-control" placeholder="YYYY-MM-DD HH:MM:SS" value="<?php echo $kontr_work['start_date']; ?>"   name="new_start"  / >
							</div>
						</div>
					</div>	
					<div class="input-group">
						<div class="input-group-content">	
							<input type="text" id="old_nam_finish" class="form-control" name="old_nam_finish"  value="Дата закрытия работы" disabled/>
						</div>
						<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
						<div class="input-group-content">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<div class="form-group">
								<input type="text" id="new_finish" class="form-control" placeholder="YYYY-MM-DD HH:MM:SS"  value="<?php echo $kontr_work['finish_date']; ?>" name="new_finish"  / >
							</div>
						</div>	
					</div>
				</div>	
				</br>
			
				<div class="col-md-5 col-sm-5">
			        <div class="card">
			            <div class="card-body">
			                <table class="table table-condensed" id="test-dates-table">
								<tr>
									<td>Группа</td>
									<td>Доступность</td>
								</tr>
								@foreach ($all_groups as $group)
									<input type="hidden" name="id-group[]" value="{{ $group['group_id'] }}">
										<tr>
											<td>{{ $group['group_name'] }}</td>
			                                <td>
												<div class="checkbox checkbox-styled">
													<label>
														<input type="checkbox" name="availability[]" value="{{ $group['group_id'] }}"
															@if ($group['availability'] == 1)
																checked
			                                                @endif
			                                            >
			                                            <span></span>
													</label>
			                                    </div>
											</td>
										</tr>
								@endforeach
							</table>
						</div>
						<button style="left:450px"class="btn ink-reaction btn-raised btn-primary" type="submit" name="submit"> Изменить </button>
					</div>
				</div>
				</form>
				</br>
			</div>
		</div>
		
		<div class="col-lg-6">
			<div class="card">
				<div class="card-head card-head-xs style-primary">
					<header>Зачем нужны эти настройки?</header>
					<div class="tools">
						<a class="btn btn-icon-toggle btn-close"><i class="md md-close"></i></a>
					</div>
				</div><!--end .card-head -->
				<div class="card-body">
					Для того чтобы контрольные материалы были доступны студентам в конкретные дни проведения контрольных работ, нужно установить даты и время их открытия и закрытия. 
					<p>Введенные даты будут означать, что теперь страницы с контрольными режимами эмуляторов будут доступны в указанные сроки. Обучающие режимы эмуляторов доступны не будут, при попытке попасть на них система автоматически перенаправит в контрольный режим. </p>
					<p>По окончании контрольного мероприятия обучающий режим будет вновь доступен для работы. </p>
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


