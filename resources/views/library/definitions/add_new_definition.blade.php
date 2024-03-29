@extends('templates.base')
@section('head')
    <title>Добавление нового определения</title>
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
                            <li>{!! HTML::linkRoute('home', 'Главная') !!}</li>
                            <li>{!! HTML::linkRoute('library_index', 'Библиотека') !!}</li>
                            <li>{!! HTML::linkRoute('library_definitions', 'Определения к экзамену') !!}</li>
                            <li class="active">Добавление нового определения</li>
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

                {!! Form::open(array('url' => 'library/definitions/store')) !!}
                <div class="form-group">
                    <h4> {!! Form::label('definition_name', 'Название термина:') !!}</h4>
                    {!! Form::text('definition_name',null,['class' => 'form-control','placeholder' => 'Введите название термина']) !!}
                </div>
                <div class="form-group">
                    <h4> {!! Form::label('definition_content', 'Определение термина:') !!}</h4>
                    {!! Form::textarea('definition_content',null,['class' => 'form-control','placeholder' => 'Введите определение термина']) !!}
                </div>
                <div class="input-group" style="margin-bottom: 20px">
                <input type="checkbox" aria-label="Checkbox for following text input" data-toggle="collapse" data-target="#addLink"
                       aria-expanded="false" aria-controls="addLink" name="addLink" class="form-group">


                    {{--{{Form :: checkbox ('addLink', null, null, array ('data-toggle' => 'collapse', 'data-target' => '#addLink',--}}
                    {{--'aria-expanded' => 'false', 'aria-controls' => 'addLink', 'aria-label' => 'Checkbox for following text input'))}}--}}
                    <span class="input-group-text" >&nbsp;Добавить ссылку на лекцию</span>
                </div>

                <div class="collapse" id="addLink">
                    <div class="form-group">
                        <h4> {!! Form::label('name_anchor', 'Название ссылки:') !!}</h4>
                        {!! Form::text('name_anchor',null,['class' => 'form-control','placeholder' => 'Введите название ссылки']) !!}
                    </div>
                    <div class="form-group">
                        <h4> {!! Form::label('id_section', 'Раздел:') !!}</h4>
                        {!! Form::select('id_section',array('' =>'Выберите раздел:',
                        '1' => 'Формальные описания алгоритмов',
                        '2' => 'Числовые множества и арифметические вычисления',
                        '3' => 'Рекурсивные функции',
                        '4' => 'Сложность вычислений'), null, ['id' => 'id_section','class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <h4>{!! Form::label('id_lecture', 'Лекция:') !!}</h4>
                        <select name="id_lecture" class="form-control">
                            <option value="">
                                Выберите лекцию:
                            </option>
                            @foreach ($lectures as $lecture)
                                <option value="{{ $lecture->id_lecture }}" id_section="{{ $lecture->id_section }}">
                                    {{ $lecture->lecture_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="form-control btn ink-reaction btn-primary">Добавить определение</button>
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
    {!! HTML::script('js/library/definition.js') !!}

    {!! HTML::script('js/core/source/App.js') !!}
    {!! HTML::script('js/core/source/AppNavigation.js') !!}
    {!! HTML::script('js/core/source/AppOffcanvas.js') !!}
    {!! HTML::script('js/core/source/AppCard.js') !!}
    {!! HTML::script('js/core/source/AppForm.js') !!}
    {!! HTML::script('js/core/source/AppNavSearch.js') !!}
    {!! HTML::script('js/core/source/AppVendor.js') !!}
    {!! HTML::script('js/core/demo/Demo.js') !!}
@stop