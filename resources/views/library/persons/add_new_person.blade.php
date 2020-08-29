@extends('templates.base')
@section('head')
    <title>Добавление персоналии</title>
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
                            <li>{!! HTML::linkRoute('library_persons', 'Персоналии') !!}</li>
                            <li class="active">Добавление персоналии</li>
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

                {!! Form::open(array('url' => 'library/persons', 'files' => true)) !!}
                <div class="form-group">
                    <h4> {!! Form::label('name_person', 'ФИО:') !!}</h4>
                    {!! Form::text('name_person',null,['class' => 'form-control','placeholder' => 'Введите ФИО']) !!}
                </div>
                <div class="form-group">
                    <h4> {!! Form::label('year_birth', 'Годы жизни:') !!}</h4>
                    <div class="input-group">
                    {!! Form::text('year_birth',null,['class' => 'form-control', 'placeholder' => 'С']) !!}
                    {!! Form::text('year_death',null,['class' => 'form-control', 'placeholder' => 'По']) !!}
                    </div>

                </div>
                <div class="form-group">
                    <h4> {!! Form::label('person_text', 'Текст для онлайн просмотра:') !!}</h4>
                    {!! Form::textarea('person_text',null,['class' => 'form-control','id' => 'person_text']) !!}
                </div>
                <div class="form-group">
                    <h4> <label for="picture">Выберите изображение</label></h4>
                    <input type="file" class="form-control-file" name="picture" >
                </div>
                <div class="form-group">
                    <button type="submit" class="form-control btn ink-reaction btn-primary">Добавить</button>
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

    {{--для редактора --}}
    <script>
        var editor = CKEDITOR.replace( 'person_text' , {
            customConfig: '{{ asset('/js/library/ckeditor/config.js') }}'
        });
    </script>
@stop