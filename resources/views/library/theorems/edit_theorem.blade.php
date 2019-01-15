@extends('templates.base')
@section('head')
    <title>Редактирование теоремы</title>
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
                            <li>{!! HTML::linkRoute('library_theorems', 'Теоремы к экзамену') !!}</li>
                            <li class="active">Редактировать теорему</li>
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

                {!! Form::model($theorem,array('url' => 'library/theorems/'.$theorem->id, 'method' => 'PATCH')) !!}
                <div class="form-group">
                    <h4> {!! Form::label('theorem_name', 'Название термина:') !!}</h4>
                    {!! Form::text('theorem_name',$theorem->name,['class' => 'form-control','placeholder' => 'Введите название термина']) !!}
                </div>
                <div class="form-group">
                    <h4> {!! Form::label('theorem_content', 'Определение термина:') !!}</h4>
                    {!! Form::textarea('theorem_content',$theorem->content,['class' => 'form-control','placeholder' => 'Введите определение термина']) !!}
                </div>

                <div class="input-group" style="margin-bottom: 10px">
                    @if($theorem->exam != null)
                    <input type="checkbox" name="exam" class="form-group" checked>
                    @else
                        <input type="checkbox" name="exam" class="form-group">
                        @endif
                    <span class="input-group-text" >&nbsp;Теорема будет на экзамене</span>
                </div>

                <div class="input-group" style="margin-bottom: 20px">
                    <input type="checkbox" aria-label="Checkbox for following text input" data-toggle="collapse" data-target="#addLink"
                           aria-expanded="false" aria-controls="addLink" name="addLink" class="form-group">
                    <span class="input-group-text" >&nbsp;Редактировать ссылку на лекцию</span>
                </div>

                <div class="collapse" id="addLink">
                    <div class="form-group">
                        <h4> {!! Form::label('name_anchor', 'Название ссылки:') !!}</h4>
                        {!! Form::text('name_anchor',$theorem->nameAnchor,['class' => 'form-control','placeholder' => 'Введите название ссылки']) !!}
                    </div>
                    <div class="form-group">
                        <h4> {!! Form::label('id_section', 'Раздел:') !!}</h4>
                        {!! Form::select('id_section',array('' =>'Выберите раздел:',
                        '1' => 'Формальные описания алгоритмов',
                        '2' => 'Числовые множества и арифметические вычисления',
                        '3' => 'Рекурсивные функции',
                        '4' => 'Сложность вычислений'), $idSectionLecture, ['id' => 'id_section','class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <h4>{!! Form::label('id_lecture', 'Лекция:') !!}</h4>
                        <select name="id_lecture" class="form-control" >
                            <option value="">
                                Выберите лекцию:
                            </option>
                            @foreach ($lectures as $lecture)
                                @if($theorem->idLecture == $lecture->id_lecture)
                                <option value="{{ $lecture->id_lecture }}" id_section="{{ $lecture->id_section }}" selected="selected">
                                    {{ $lecture->lecture_name }}
                                </option>
                                @else
                                    <option value="{{ $lecture->id_lecture }}" id_section="{{ $lecture->id_section }}">
                                        {{ $lecture->lecture_name }}
                                    </option>
                                    @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="form-control btn ink-reaction btn-primary">Редактировать теорему</button>
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
    {!! HTML::script('js/library/definition.js') !!}
    <!-- END JAVASCRIPT -->

@stop