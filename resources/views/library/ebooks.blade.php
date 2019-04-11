@extends('templates.base')
@section('head')
	<title>Электронные книги</title>
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
	<!-- END STYLESHEETS -->
@stop

@section('content')

			<!-- BEGIN HEADER-->

	<div id="base">


		<div class="offcanvas">
		</div><!--end .offcanvas-->

		<div id="content">
			<section>
				<div class="section-header">
					<ol class="breadcrumb">
						<li>{!! HTML::linkRoute('library_index', 'Библиотека') !!}</li>
						<li class="active">Скачать книги</li>
					</ol>
				</div>
				<div class="section-body contain-lg">

					<div class="row">

						<div class="col-lg-offset-1 col-md-8">
						</div><!--end .col -->


						<div class="col-lg-3 col-md-4">

						</div><!--end .col -->

						<div class="card">

							<div class="card-body">
								<center>
									<form class="form" action="{{URL::route('library_esearch')}}"  method="post">
										<input type="text" name="search" id="text-to-find" size="50px" value="<?php echo $searchquery?>" placeholder="Введите название книги или имя автора" />
										<input type="hidden" name="_token" value="{{ csrf_token() }}" />
										<button class="btn ink-reaction btn-primary">Искать</button>
									</form>
								</center>
								<?php
									if ($searchquery == "") //all books
									{
											for($i = 0; $i < 5; $i++){
												if ($i == 0){
													$title = "Общие материалы";
												}else{
													$title = "Раздел ".$i;
												}
												$result = $results[$i];
												echo view('library.ebooks.ebook', compact('title','result'));
											}
									}else{ //search
										$title = "Результаты поиска";
										$result = $results;
										echo view('library.ebooks.ebook', compact('title','result'));
									}


								?>

					</div><!--end .card -->
				</div><!--end .col -->

				<!--end .row -->
		</div><!--end .section-body -->

		</section>
	</div><!--end #content-->


	</div><!--end .offcanvas-->

	</div><!--end #base-->
	<!-- END BASE -->
	@stop

@section('js-down')
	{!! HTML::script('js/core/source/App.js') !!}
	{!! HTML::script('js/core/source/AppNavigation.js') !!}
	{!! HTML::script('js/core/source/AppOffcanvas.js') !!}
	{!! HTML::script('js/core/source/AppCard.js') !!}
	{!! HTML::script('js/core/source/AppForm.js') !!}
	{!! HTML::script('js/core/source/AppNavSearch.js') !!}
	{!! HTML::script('js/core/source/AppVendor.js') !!}
	{!! HTML::script('js/core/demo/Demo.js') !!}
@stop
