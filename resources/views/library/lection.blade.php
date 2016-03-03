@extends('templates.base')
@section('head')
	<title>Бронирование печатных изданий</title>
	<!-- BEGIN META -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="your,keywords">
	<meta name="description" content="Short explanation about this website">
	<!-- END META -->

	<!-- BEGIN STYLESHEETS -->
	<link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
	{!! HTML::style('css/bootstrap.css') !!}
	{!! HTML::style('css/materialadmin.css') !!}
	{!! HTML::style('css/font-awesome.min.css') !!}
	{!! HTML::style('css/material-design-iconic-font.min.css') !!}
			<!-- END STYLESHEETS -->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	{!! HTML::script('js/libs/utils/html5shiv.js') !!}
	{!! HTML::script('js/libs/utils/respond.min.js') !!}
	<![endif]-->
@stop

@section('content')

		<!-- BEGIN HEADER-->


				<section>
					<div class="section-header">
						<ol class="breadcrumb">
							<li>{!! HTML::linkRoute('library_index', 'Библиотека') !!}</li>
							<li class="active">Бронирование печатных изданий</li>

						</ol>
					</div><!--end .section-header -->
					<div class="section-body">
					</div><!--end .section-body -->
				</section>
					<div class="section-body contain-lg">

						<div class="row">
						
							<div class="col-lg-offset-1 col-md-8">
							</div><!--end .col -->
						
						
							<div class="col-lg-3 col-md-4">
							
							</div><!--end .col -->
							<center>
								<div class="card">
									<div class="card-body">
								<form class="form" name="date" action="{{URL::route('book_order', array('book_id' => $book_id))}}" method="post">
									<input type="hidden" name="_token" value="{{ csrf_token() }}" />

										<?php
											if ($success){
												echo '<h3 >Успешно заказано</h3>';
												echo '<br>';
											}
											echo '<h3>Доступные даты для заказа:</h3>';
											$today = date("Y-m-d");
											$counter = count($result1);
										    $i = 0;
											while($i < $counter){
												$row = $result1[$i++];
												if ($today <= $row["date"])
													echo '<div><p><input type="radio" required name="date" value='.$row["date"].' />'.$row["date"].'</p></div>';
											}
											echo "<input type=\"submit\" class=\"btn ink-reaction btn-primary\" value=\"Заказать\" /><br>";

										?>
										
							<!--	<br><p><input type="submit" id="sendRequest"></p></br> -->
								</div><!--end .card -->

								</form>
															</div><!--end .col -->
									</center>						
						<!--end .row -->
					</div><!--end .section-body -->


			</div><!--end #content-->
			

			</div><!--end .offcanvas-->

		</div><!--end #base-->
		<!-- END BASE -->
		@stop
		@section('js-down')
		<!-- BEGIN JAVASCRIPT -->
		{!! HTML::script('js/libs/spin.js/spin.min.js') !!}
		{!! HTML::script('js/libs/autosize/jquery.autosize.min.js') !!}
		{!! HTML::script('js/libs/nanoscroller/jquery.nanoscroller.min.js') !!}
		{!! HTML::script('js/core/source/App.js') !!}
		{!! HTML::script('js/core/source/AppNavigation.js') !!}
		{!! HTML::script('js/core/source/AppOffcanvas.js') !!}
		{!! HTML::script('js/core/source/AppCard.js') !!}
		{!! HTML::script('js/core/source/AppForm.js') !!}
		{!! HTML::script('js/core/source/AppNavSearch.js') !!}
		{!! HTML::script('js/core/source/AppVendor.js') !!}
		{!! HTML::script('js/core/demo/Demo.js') !!}

		<!-- END JAVASCRIPT -->

@stop