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
                            <li >{!! HTML::linkRoute('manage_news_library', 'Управление библиотечными новостями') !!}</li>
                            <li class="active">Редактирование</li>
                        </ol>
                    </div><!--end .section-header -->
                </section>
            </div>
            <div class="col-lg-4">

                <div>
        </div>
    </div>
    <div class="card card-tiles style-default-light">
        <br>
        <div class ="container-fluid">
            <div class="col-lg-1 col-md-1">
            </div>
            <div class="col-lg-11 col-md-11">

                {!! Form::model($news,array('url' => 'library/manageNewsLibrary/'.$news->id, 'method' => 'PATCH', 'id' => 'form_edit_news')) !!}
                <div class="form-group">
                    <h4> {!! Form::label('title', 'Заголовок новости:') !!}</h4>
                    {!! Form::text('title',null,['class' => 'form-control','placeholder' => 'Введите заголовок новости', 'id' => 'title_edit_news',
                    'required']) !!}
                </div>
                <div class="form-group" >
                    <h4> {!! Form::label('body', 'Описание новости:') !!}</h4>
                    {!! Form::textarea('body',null,['class' => 'form-control','placeholder' => 'Введите описание книги', 'id' => 'body_edit_news',
                    'required']) !!}
                </div>
                <div class="form-group">
                    <button type="submit" class="form-control btn ink-reaction btn-primary">Сохранить изменения</button>
                </div>
                {!! Form::close() !!}


            </div>
        </div>

    </div>
@stop
@section('js-down')
    {!! HTML::script('js/library/manage_library_news.js') !!}

    {!! HTML::script('js/core/source/App.js') !!}
    {!! HTML::script('js/core/source/AppNavigation.js') !!}
    {!! HTML::script('js/core/source/AppOffcanvas.js') !!}
    {!! HTML::script('js/core/source/AppCard.js') !!}
    {!! HTML::script('js/core/source/AppForm.js') !!}
    {!! HTML::script('js/core/source/AppNavSearch.js') !!}
    {!! HTML::script('js/core/source/AppVendor.js') !!}
    {!! HTML::script('js/core/demo/Demo.js') !!}
@stop