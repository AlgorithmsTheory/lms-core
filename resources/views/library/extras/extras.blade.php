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
				<li class="active">Дополнительно</li>
			</ol>
		</div>
	</section>
    <div class="card card-tiles style-default-light" style="margin-left:2%; margin-right:2%">
		<div class="card-body">
			<article style="margin-left:10%; margin-right:10%; text-align: justify">
				@if($role == 'Админ')
				<div class="card">
					<div class="card-head style-default-dark">
						<header>Добавление доп. материала</header>
					</div>

					<div class="card-body style-default-bright">
					{!! Form::open(array('action' => 'LibraryController@extraStore', 'files' => true)) !!}
					<div class="form-group">
						{!! Form::label('extra_header', 'Заголовок доп. материала') !!}
						{!! Form::textarea('extra_header',null,['class' => 'form-control','placeholder' => 'Введите заголовок доп. материала',
						'rows' => 3]) !!}
					</div>
					<div class="form-group">
						{!! Form::label('extra_desc', 'Описание доп. материала') !!}
						{!! Form::textarea('extra_desc',null,['class' => 'form-control','placeholder' => 'Введите описание доп. материала',
						'rows' => 3]) !!}
					</div>
					<div class="form-group">
						<input type="file"  name="extra_file" >
					</div>
					<div class="form-group">
						<button class="btn btn-primary btn-raised submit-question" type="submit">Добавить</button>
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
				@endif

					<div class="all_extras" style="margin-top: 4%">
				@foreach($extras as $extra)
					<div class="extra">
					<div class="card-body style-default-dark">
						<div class="card-head">
							<header>{{ $extra['extra_header'] }}</header>
							@if($role == 'Админ' or $role == 'Преподаватель')
							<div class="tools">
								<div class="btn-group">
									<a class="btn btn-icon-toggle " href="{{ action('LibraryController@extraEdit', [$extra->id_extra])}}">
										<i class="glyphicon glyphicon-edit"></i>
									</a>
								</div>
								<div class="btn-group ">
									<button type="submit" class="btn btn-icon-toggle  delete_extra" value="{{ csrf_token() }}" id="{{ $extra->id_extra }}">
										<i class="md md-close"></i>
									</button>
								</div>
							</div>
							@endif
						</div>
					</div>
					<blockquote>
						<p>{{$extra['extra_desc']}}</p>
					</blockquote>
						@if($extra['path_file'] != null)
					{!! HTML::link($extra['path_file'], 'Скачать', array('class' => 'btn btn-default')) !!}
						@endif
					<p>&nbsp;</p>
					</div>
				@endforeach
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
	{!! HTML::script('js/library/extra.js') !!}
@stop