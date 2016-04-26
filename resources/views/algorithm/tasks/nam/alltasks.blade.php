@extends('templates.base')
@section('head')
		<title>Контрольные материалы</title>

		<!-- BEGIN META -->
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
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
				<li class="active"> Контрольные материалы НАМ</li>
				</ol>
			</div>
			<div class="section-body contain-lg">
					
						<div class="row">
							<div class="col-lg-8">
							
								<h1 class="text-primary">Работа с контрольным материалом по теме "Нормальные алгоритмы Маркова"</h1>
								
								
							</div><!--end .col -->
							<div class="col-lg-12">
								<div class="col-lg-6">
								<article class="margin-bottom-xxl">
									<p class="lead">
										Добавить/удалить задачи и тестовые последовательности
									</p>
								</article>
								</div>
								<div class="col-lg-6">
								<button type="button" class="btn ink-reaction btn-raised btn-primary"> {!! HTML::linkRoute('addtask', '+ Добавить задачу') !!} </button>
								</div>
							</div><!--end .col -->
							
						</div>
						<!-- BEGIN NESTABLE LISTS -->
				
				<div class="card">
				<div class="card-body">
<?php
	
	echo ("
	<table class=\"table table-bordered no-margin\">
	<tr>
	<th class=\"text-right\">Удалить задачу</th>
	<th>Текст задачи</th>
    <th>Максимальный балл</th>
	<th>Сложность (1 - легкий, 2 - сложный)</th>
	<th>Номер задачи</th>
    <th>Тестовая последовательность входная</th>
	<th>Тестовая последовательность выходная</th>

	
	<th class=\"text-right\">Изменить</th>
   </tr>
  

");
	$i = 0;
	$j = 0;
	$len = count($tasks_and_sequences);
	while($j < $len) {
		$row = $tasks_and_sequences[$j++];
		print "			
			<tr>";
			if ($i == 0)
			{
			print "
			<td rowspan=\"5\">";
			echo HTML::linkRoute('delete', 'Удалить', array("id" => $row['id']));
			echo '</td>';
			print "<td rowspan=\"5\">".$row["task_text"]."</td>
			<td rowspan=\"5\">".$row["max_mark"]."</td>
			<td rowspan=\"5\">".$row["level"]."</td>
			<td rowspan=\"5\">".$row["task_number"]."</td>";
			}
			print "
			<td>".$row["input_word"]."</td>
			<td>".$row["output_word"]."</td>

			
			<td>";
			echo HTML::linkRoute('edit', 'Изменить', array("sequense_id" => $row['sequense_id']));
			print "</td>		
			</tr>";
			$i++;
			if ($i == 5) $i=0;

	}

echo ("</table>\n");


?>	
	
	
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
