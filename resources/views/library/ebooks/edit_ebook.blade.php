@extends('templates.base')
@section('head')
	<title>Редактирование электронной книги</title>
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
				<li>{!! HTML::linkRoute('ebooks', 'Электронные книги') !!}</li>
				<li class="active">Редактирование электронной книги</li>
			</ol>
		</div>
	</section>
    <div class="card card-tiles style-default-light" style="margin-left:2%; margin-right:2%">
		<div class="card-body">
			<article style="margin-left:10%; margin-right:10%; text-align: justify">
					{!! Form::model($ebook,array('action' => array('LibraryController@updateEbook', $ebook->id_ebook), 'files' => true, 'method' => 'PATCH')) !!}
						<div class="form-group">
							<h4> {!! Form::label('ebook_title', 'Название книги:') !!}</h4>
							{!! Form::text('ebook_title',$ebook['ebook_title'],['class' => 'form-control','placeholder' => 'Введите название книги']) !!}
						</div>
						<div class="form-group">
							<h4> {!! Form::label('ebook_author', 'Автор книги:') !!}</h4>
							{!! Form::text('ebook_author',$ebook['ebook_author'],['class' => 'form-control','placeholder' => 'Введите автора книги']) !!}

						</div>
						<div class="form-group">
							<h4> {!! Form::label('id_genre', 'Жанр книги:') !!}</h4>
							{!! Form::select('id_genre',array('' =>'Выберите жанр книги:',
                            '1' => 'Теория графов', '2' => 'Принятие решений и мягкие вычисления',
                            '3' => 'Логистика и экономико-математические методы',
                            '4' => 'Информационные технологии в образовании',
                            '5' => 'Научно-популярная литература',
                            '6' => 'Дискретная математика',
                            '7' => 'Теория алгоритмов и сложности вычислений'), $ebook['id_genre'], ['class' => 'form-control']) !!}
						</div>
						<div class="form-group">
							<h4> {!! Form::label('ebook_desc', 'Описание книги:') !!}</h4>
							{!! Form::textarea('ebook_desc',$ebook['ebook_desc'],['class' => 'form-control','placeholder' => 'Введите описание книги']) !!}

						</div>
						<div class="form-group">
							<h4> <label for="ebook_img">Выберите изображение </label></h4>
							<input type="file" class="form-control-file" name="ebook_img" >
						</div>
						<div class="form-group">
							<h4> <label for="ebook_file">Выберите файл книги в формате doc,docx,pdf,djvu</label></h4>
							<input type="file" class="form-control-file" name="ebook_file" >
						</div>
						<div class="form-group">
							<button type="submit" class=" btn ink-reaction btn-primary">Редактировать</button>
						</div>
				{!! Form::close() !!}
						@if ($errors->any())
							<ul class="alert alert-danger">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						@endif
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