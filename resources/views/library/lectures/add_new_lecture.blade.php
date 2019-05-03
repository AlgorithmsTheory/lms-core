@extends('templates.base')
@section('head')
    <title>Добавление новой лекции</title>
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

    {{--Редактор текста--}}
    {!! HTML::script("https://cdn.ckeditor.com/4.11.2/full/ckeditor.js") !!}

@stop
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <section>
                    <div class="section-header">
                        <ol class="breadcrumb">
                            <li>{!! HTML::linkRoute('home', 'Главная') !!}</li>
                            <li>{!! HTML::linkRoute('library_index', 'Библиотека') !!}</li>
                            <li class="active">Добавление новой лекции</li>
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

                {!! Form::open(array('url' => 'library/lecture/store', 'files' => true)) !!}
                <div class="form-group">
                    <h4> {!! Form::label('lecture_name', 'Название лекции:') !!}</h4>
                    {!! Form::text('lecture_name',null,['class' => 'form-control','placeholder' => 'Введите название лекции', 'required' => 'true']) !!}
                </div>
                <div class="form-group">
                    <h4> {!! Form::label('id_section', 'Раздел:') !!}</h4>
                    {!! Form::select('id_section',array('' =>'Выберите раздел:',
                    '1' => 'Формальные описания алгоритмов',
                    '2' => 'Числовые множества и арифметические вычисления',
                    '3' => 'Рекурсивные функции',
                    '4' => 'Сложность вычислений'), null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <h4> <label for="doc_file">Выберите doc файл</label></h4>
                    <input type="file" class="form-control-file" name="doc_file" >
                </div>
                <div class="form-group">
                    <h4> <label for="ppt_file">Выберите ppt файл</label></h4>
                    <input type="file" class="form-control-file" name="ppt_file" >
                </div>
                <div class="form-group">
                    <h4> {!! Form::label('lecture_text', 'Текст лекции для онлайн просмотра:') !!}</h4>
                    {!! Form::textarea('lecture_text',null,['class' => 'form-control','id' => 'lecture_text']) !!}
                </div>
                <div class="form-group">
                    <button type="submit" class="form-control btn ink-reaction btn-primary">Добавить лекцию</button>
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
        <input id="path_ckeditor_config" value="{{ asset('/js/library/ckeditor/config.js') }}" hidden/>
    </div>
@stop
@section('js-down')
    <!-- BEGIN JAVASCRIPT -->
    {!! HTML::script('js/core/source/App.js') !!}
    {!! HTML::script('js/core/source/AppNavigation.js') !!}
    {!! HTML::script('js/core/source/AppOffcanvas.js') !!}
    {!! HTML::script('js/core/source/AppCard.js') !!}
    {!! HTML::script('js/core/source/AppForm.js') !!}
    {!! HTML::script('js/core/source/AppNavSearch.js') !!}
    {!! HTML::script('js/core/source/AppVendor.js') !!}
    {!! HTML::script('js/core/demo/Demo.js') !!}
    {{--для редактора --}}
    {!! HTML::script('js/library/lectures/ckeditorSetting.js') !!}
    <!-- END JAVASCRIPT -->
@stop