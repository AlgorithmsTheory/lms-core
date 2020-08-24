@extends('templates.base')
@section('head')
	<title>Дополнительно</title>
	<!-- BEGIN META -->
	<meta charset="utf-8">
	<!-- END META -->

@stop

@section('content')

<!-- BEGIN CONTENT-->
	<section>
		<div class="section-header">
			<ol class="breadcrumb">
				<li>{!! HTML::linkRoute('home', 'Главная') !!}</li>
				<li>{!! HTML::linkRoute('library_index', 'Библиотека') !!}</li>
				<li>{!! HTML::linkRoute('library_extras', 'Дополнительно') !!}</li>
				<li class="active">Редактирование доп. материала</li>
			</ol>
		</div>
	</section>
    <div class="card card-tiles style-default-light" style="margin-left:2%; margin-right:2%">
		<div class="card-body">
			<article style="margin-left:10%; margin-right:10%; text-align: justify">
				<div class="card">
					<div class="card-head style-default-dark">
						<header>Доп. материал</header>
					</div>
					<div class="card-body style-default-bright">
					{!! Form::model($extra,array('action' => array('LibraryController@extraUpdate', $extra->id_extra), 'files' => true, 'method' => 'PATCH')) !!}
					<div class="form-group">
						{!! Form::label('extra_header', 'Заголовок доп. материала') !!}
						{!! Form::textarea('extra_header',$extra->extra_header,['class' => 'form-control','placeholder' => 'Введите заголовок доп. материала',
						'rows' => 3]) !!}
					</div>
					<div class="form-group">
						{!! Form::label('extra_desc', 'Описание доп. материала') !!}
						{!! Form::textarea('extra_desc',$extra->extra_desc,['class' => 'form-control','placeholder' => 'Введите описание доп. материала',
						'rows' => 3]) !!}
					</div>
					<div class="form-group">
						<input type="file"  name="extra_file" >
					</div>
					<div class="form-group">
						<button class="btn btn-primary btn-raised submit-question" type="submit">Обновить</button>
					</div>
				{!! Form::close() !!}
						@if ($errors->any())
							<ul class="alert alert-danger">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						@endif
					</div>
				</div>
			</article>
		</div>
	</div>
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