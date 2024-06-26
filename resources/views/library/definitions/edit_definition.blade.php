@extends('templates.base')
@section('head')
    <title>Редактирование определения</title>
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
                            <li>{!! HTML::linkRoute('home', 'Главная') !!}</li>
                            <li>{!! HTML::linkRoute('library_index', 'Библиотека') !!}</li>
                            <li>{!! HTML::linkRoute('library_definitions', 'Определения к экзамену') !!}</li>
                            <li class="active">Редактировать определение</li>
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

                {!! Form::model($definition,array('url' => 'library/definitions/'.$definition->id, 'method' => 'PATCH')) !!}
                <div class="form-group">
                    <h4> {!! Form::label('definition_name', 'Название термина:') !!}</h4>
                    {!! Form::text('definition_name',$definition->name,['class' => 'form-control','placeholder' => 'Введите название термина']) !!}
                </div>
                <div class="form-group">
                    <h4> {!! Form::label('definition_content', 'Определение термина:') !!}</h4>
                    {!! Form::textarea('definition_content',$definition->content,['class' => 'form-control','placeholder' => 'Введите определение термина']) !!}
                </div>
                <div class="input-group" style="margin-bottom: 20px">
                    <input type="checkbox" aria-label="Checkbox for following text input" data-toggle="collapse" data-target="#addLink"
                           aria-expanded="false" aria-controls="addLink" name="addLink" class="form-group">
                    <span class="input-group-text" >&nbsp;Редактировать ссылку на лекцию</span>
                </div>

                <div class="collapse" id="addLink">
                    <div class="form-group">
                        <h4> {!! Form::label('name_anchor', 'Название ссылки:') !!}</h4>
                        {!! Form::text('name_anchor',$definition->nameAnchor,['class' => 'form-control','placeholder' => 'Введите название ссылки']) !!}
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
                                @if($definition->id_lecture == $lecture->id_lecture)
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
                    <button type="submit" class="form-control btn ink-reaction btn-primary">Редактировать определение</button>
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