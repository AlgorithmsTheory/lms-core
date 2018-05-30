@extends('templates.base')
@section('head')
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <title>Уровень подготовки студентов</title>
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/dropzone-theme.css') !!}
    {!! HTML::style('css/full.css') !!}
@stop

@section('content')
    <div class="col-lg-offset-1 col-md-10 col-sm-6">
        @if(isset($error))
            <div class="col-md-12 col-sm-6 card style-danger">
                <h1 class="text-default-bright">При обработке файлов возникли ошибки!</h1>
                <h2 class="text-lg"> {{ $error }} </h2>
            </div>
        @endif
    </div>
    <div class="col-lg-offset-1 col-md-10 col-sm-6">
        <div class="card">
            <div class="card-head style-primary">
                <header>Задать уровень подготовленности студентов</header>
            </div>
            <div class="card-body no-padding">
                <form action="{{URL::route('set_students_level')}}" method="POST" class="dropzone dz-clickable" id="statements-dropzone">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="dz-message">
                        <h3>Вставьте файлы с оценками за предыдущие семестры</h3>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-offset-10 col-md-10 col-sm-6">
            <button class="btn btn-primary btn-raised" type="submit" id="eval-level">Рассчитать уровни</button>
        </div>
    </div>
@stop

@section('js-down')
    {!! HTML::script('js/libs/dropzone/dropzone.js') !!}
    {!! HTML::script('js/knowledge_level.js') !!}
@stop