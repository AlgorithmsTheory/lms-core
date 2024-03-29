@extends('templates.base')
@section('head')
    <title>Добавление новой книги</title>
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

@stop
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <section>
                    <div class="section-header">
                        <ol class="breadcrumb">
                            <li>{!! HTML::linkRoute('library_index', 'Библиотека') !!}</li>
                            <li>{!! HTML::linkRoute('books', 'Бронирование печатных изданий') !!}</li>
                            <li class="active">Добавление новой книги</li>
                        </ol>
                    </div><!--end .section-header -->
                </section>
            </div>
        </div>
    </div>
    <div class="card card-tiles style-default-light">
        <br>
        <div class ="container-fluid">
            <div class="col-lg-1 col-md-1">
            </div>
            <div class="col-lg-11 col-md-11">

                {!! Form::open(array('url' => 'library/books', 'files' => true)) !!}
                <div class="form-group">
                   <h4> {!! Form::label('book_title', 'Название книги:') !!}</h4>
                    {!! Form::text('book_title',null,['class' => 'form-control','placeholder' => 'Введите название книги']) !!}
                </div>
                <div class="form-group">
                    <h4> {!! Form::label('book_author', 'Автор книги:') !!}</h4>
                    {!! Form::text('book_author',null,['class' => 'form-control','placeholder' => 'Введите автора книги']) !!}

                </div>
                <div class="form-group">
                    <h4> {!! Form::label('book_genre_id', 'Жанр книги:') !!}</h4>
                    {!! Form::select('book_genre_id',array('' =>'Выберите жанр книги:',
                    '1' => 'Теория графов', '2' => 'Принятие решений и мягкие вычисления',
                    '3' => 'Логистика и экономико-математические методы',
                    '4' => 'Информационные технологии в образовании',
                    '5' => 'Научно-популярная литература',
                    '6' => 'Дискретная математика',
                    '7' => 'Теория алгоритмов и сложности вычислений'), null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <h4> {!! Form::label('book_description', 'Описание книги:') !!}</h4>
                    {!! Form::textarea('book_description',null,['class' => 'form-control','placeholder' => 'Введите описание книги']) !!}

                </div>
                <div class="form-group">
                    <h4> {!! Form::label('book_format', 'Формат книги:') !!}</h4>
                    {!! Form::text('book_format',null,['class' => 'form-control','placeholder' => 'Введите формат книги']) !!}

                </div>
                <div class="form-group">
                    <h4> {!! Form::label('book_publisher', 'Издательство:') !!}</h4>
                    {!! Form::text('book_publisher',null,['class' => 'form-control','placeholder' => 'Введите издательство']) !!}

                </div>
                <div class="form-group">
                    <h4> <label for="picture">Выберите изображение</label></h4>
                    <input type="file" class="form-control-file" name="picture" >
                </div>
                <div class="form-group">
                    <input type="hidden" class="form-control" name="status" value = "1" >
                </div>
                <div class="form-group">
                    <button type="submit" class="form-control btn ink-reaction btn-primary">Добавить книгу</button>
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