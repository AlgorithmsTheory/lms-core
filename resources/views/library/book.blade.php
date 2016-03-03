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
				<li class="active">Бронирование печатных изданий</li>

			</ol>
		</div><!--end .section-header -->
		<div class="section-body">
		</div><!--end .section-body -->
	</section>
	<div class="card card-tiles style-default-light" style="margin-left:2%; margin-right:2%">
	<article class="style-default-bright">
		<div class="card-body">
		<article style="margin-left:10%; margin-right:10%; text-align: justify">

		<table cellpadding="5" ><tbody>
    <tr>
      <td valign="top" colspan="1">
		  {!! HTML::image('img/library/'.$row['coverImg'], '', array('style' => 'border:0px', 'width' => '200', 'height' => '300')) !!}
		  <br>
      </td>
	  <td style="width:130px">
			<p>&nbsp;</p>
			</td>
      <td style="text-align: left;" rowspan="2" colspan="1"><font size="4" style="font-weight: bold;"> <?php print $row["title"] ?></font>
	  <font size="3" style="text-decoration: underline;">
	  <?php
		print "
			<p>".$row["author"]."</p>";?>
	  </font>
	  <font size="2" style="font-style: italic;"><br></font><font size="2" style="color: rgb(102, 102, 102);">Издательство:</font>
	  <font size="2" style="font-style: italic; color: rgb(102, 102, 102);">
	  <?php
		print "
			".$row["publisher"]."</p>";?>
	  </font>
	  <font size="2" style="color: rgb(102, 102, 102);">Формат:</font> <font size="2" style="font-style: italic;">
	  <span style="color: rgb(102, 102, 102);">
	  <?php
		print "
			".$row["format"]."</p>";?>
	  </span></font>
	  <font size="2" style="color: rgb(102, 102, 102);">

		<button class="btn ink-reaction btn-primary" onclick='location.href="{{ URL::route('lection', array('id' => $row['id']))}}"'>Заказать</button>
	 </td>

    </tr>

    </tbody>
  </table>
  <br></br>
  <p><b>Аннотация</b></p>
  <p><?php
		print "
			<p>".$row["description"]."</p>";

			?></p>




			</article></article>	</div></div>

				<!-- BEGIN BLANK SECTION -->
			</div><!--end #content-->
			<!-- END CONTENT -->


	@stop
			
			
			
			<!-- BEGIN MENUBAR-->
			
					<!-- END MAIN MENU -->

					
		<!-- END BASE -->
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
