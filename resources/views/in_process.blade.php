@extends('templates.base')
@section('head')
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <title>В разработке</title>
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/full.css') !!}
@stop

@section('background')
full-in_process
@stop

@section('content')
    <div class="col-md-12 col-sm-6 card style-primary">
        <h1 class="text-default-bright">Данный модуль находится в разработке!</h1>
    </div>
    <div class="row">
        <a href="{{URL::route('home')}}" class="btn btn-warning btn-lg col-md-4 col-md-offset-4 style-primary" role="button">Перейти на главную</a>
    </div>
@stop