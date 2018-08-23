@extends('templates.base')
@section('head')
    <title>Редактирование данных о книге</title>
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <section>
                    <div class="section-header">
                        <ol class="breadcrumb">
                            <li>{!! HTML::linkRoute('library_index', 'Библиотека') !!}</li>
                            <li>{!! HTML::linkRoute('books', 'Бронирование печатных изданий') !!}</li>
                            <li class="active">Редактирование данных о книге</li>
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

                {!! Form::model($book,array('url' => 'library/book/'.$book->id, 'files' => true, 'method' => 'PATCH')) !!}
                <div class="form-group">
                    <h4> {!! Form::label('title', 'Название книги:') !!}</h4>
                    {!! Form::text('title',null,['class' => 'form-control','placeholder' => 'Введите название книги']) !!}
                </div>
                <div class="form-group">
                    <h4> {!! Form::label('author', 'Автор книги:') !!}</h4>
                    {!! Form::text('author',null,['class' => 'form-control','placeholder' => 'Введите автора книги']) !!}

                </div>
                <div class="form-group">
                    <h4> {!! Form::label('description', 'Описание книги:') !!}</h4>
                    {!! Form::textarea('description',null,['class' => 'form-control','placeholder' => 'Введите описание книги']) !!}

                </div>
                <div class="form-group">
                    <h4> {!! Form::label('format', 'Формат книги:') !!}</h4>
                    {!! Form::text('format',null,['class' => 'form-control','placeholder' => 'Введите формат книги']) !!}

                </div>
                <div class="form-group">
                    <h4> {!! Form::label('publisher', 'Издательство:') !!}</h4>
                    {!! Form::text('publisher',null,['class' => 'form-control','placeholder' => 'Введите издательство']) !!}

                </div>
                <div class="form-group">
                    <h4> <label for="picture">Выберите изображение</label></h4>
                    <input type="file" class="form-control-file" name="picture" >
                </div>
                <div class="form-group">
                    <input type="hidden" class="form-control" name="status" value = "0" >
                </div>
                <div class="form-group">
                    <button type="submit" class="form-control btn ink-reaction btn-primary">Сохранить изменения</button>
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