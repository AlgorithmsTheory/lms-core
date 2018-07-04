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

			<!-- BEGIN BLANK SECTION -->
	<section>
		<div class="section-header">
			<ol class="breadcrumb">
				<li>{!! HTML::linkRoute('library_index', 'Библиотека') !!}</li>

				<?php if ($searchquery == ""){
					echo '<li class="active">Бронирование печатных изданий</li>';
				}else{
					echo '<li><a href="';
					echo URL::route('books');
					echo '">Бронирование печатных изданий</a></li>';
					echo '<li class="active">Поиск печатных изданий</li>';
				}?>
			</ol>
		</div><!--end .section-header -->
		<div class="section-body">
		</div><!--end .section-body -->
	</section>

	<div class="card card-tiles style-default-light">
		<article style="margin-left:10%; margin-right:13%; text-align: justify">
			<br>
			<center>
				<form class="form" action="{{URL::route('library_search')}}"  method="post">
					<input type="text"  name="search" id="text-to-find" size="50px" value="<?php echo $searchquery?>" placeholder="Введите название книги или имя автора" />
					<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					<button type="submit" class="btn ink-reaction btn-primary">Искать</button></form>
				<!--<input type="button" onclick="javascript: FindOnPage('text-to-find'); " value="Искать" target="_blank"/> -->
			</center>		<center>

				<br>
				<table border="0" cellpadding="0" cellspacing="0">
					<tbody >

					<?php
					$rows = count($result);
					$c_row = 0;
					while($c_row < $rows) {
						$row = $result[$c_row++];
						echo '<tr style="padding:20px; margin-top:20px">';
						// left book
						echo view('library.books.book', compact('row'));
						echo '<td style="width:155px">';
						echo '<p>&nbsp;</p>';
						echo '</td>';
						// right book
						if ($c_row < $rows){
							$row = $result[$c_row++];
							echo view('library.books.book', compact('row'));
						}else{ //right
							echo '<td style="width:155px; padding: 5px"/>';
							echo '<td style="width:154px"/>';
						}
						echo '</tr>';
					}
					?>

					</tbody>
				</table>
				<p>&nbsp;</p>
			</center>
		</article>
	</div>
	</div><!--end #content-->

	<div class="offcanvas">

	</div><!--end .offcanvas-->

	</div><!--end #base-->




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
