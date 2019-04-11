@extends('templates.base')
@section('head')
    <title>Создание учебного плана</title>
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
                            <li>{!! HTML::linkRoute('course_plans', 'Все учебные планы') !!}</li>
                            <li class="active">Добавление нового учебного плана</li>
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

                {!! Form::open(array('url' => 'course_plans')) !!}
                <div class="form-group">
                    <h4> {!! Form::label('course_plan_name', 'Название учебного плана:') !!}</h4>
                    {!! Form::text('course_plan_name',null,['class' => 'form-control','placeholder' => 'Введите название учебного плана']) !!}
                </div>
                <div class="form-group">
                    <h4> {!! Form::label('course_plan_desc', 'Описание учебного плана:') !!}</h4>
                    {!! Form::textarea('course_plan_desc',null,['class' => 'form-control','placeholder' => 'Введите описание учебного плана']) !!}
                </div>
                <div class="form-group row">
                    <h4> {!! Form::label('max_controls', 'Макс балл за раздел "Контрольные мероприятия в семестре":', ['class'=>'col-sm-6']) !!}</h4>
                    <div class="col-sm-2">
                        {!! Form::text('max_controls',null,['class' => 'form-control','placeholder' => 'Макс. балл', 'type'=>'number']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <h4> {!! Form::label('max_seminars', 'Макс балл за раздел "Посещение семинаров":', ['class'=>'col-sm-6']) !!}</h4>
                    <div class="col-sm-2">
                        {!! Form::text('max_seminars',null,['class' => 'form-control','placeholder' => 'Макс. балл', 'type'=>'number']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <h4> {!! Form::label('max_seminars_work', 'Макс балл за раздел "Работа на семинарах":', ['class'=>'col-sm-6']) !!}</h4>
                    <div class="col-sm-2">
                        {!! Form::text('max_seminars_work',null,['class' => 'form-control','placeholder' => 'Макс. балл', 'type'=>'number']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <h4> {!! Form::label('max_lecrures', 'Макс балл за раздел "Посещение лекций":', ['class'=>'col-sm-6']) !!}</h4>
                    <div class="col-sm-2">
                        {!! Form::text('max_lecrures',null,['class' => 'form-control','placeholder' => 'Макс. балл', 'type'=>'number']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <h4> {!! Form::label('max_exam', 'Макс балл за раздел "Зачет (экзамен)":', ['class'=>'col-sm-6']) !!}</h4>
                    <div class="col-sm-2">
                        {!! Form::text('max_exam',null,['class' => 'form-control','placeholder' => 'Макс. балл', 'type'=>'number']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class=" btn ink-reaction btn-primary">Сохранить учебный план</button>
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
    {!! HTML::script('js/statements/statements.js') !!}

    {!! HTML::script('js/core/source/App.js') !!}
    {!! HTML::script('js/core/source/AppNavigation.js') !!}
    {!! HTML::script('js/core/source/AppOffcanvas.js') !!}
    {!! HTML::script('js/core/source/AppCard.js') !!}
    {!! HTML::script('js/core/source/AppForm.js') !!}
    {!! HTML::script('js/core/source/AppNavSearch.js') !!}
    {!! HTML::script('js/core/source/AppVendor.js') !!}
    {!! HTML::script('js/core/demo/Demo.js') !!}
@stop