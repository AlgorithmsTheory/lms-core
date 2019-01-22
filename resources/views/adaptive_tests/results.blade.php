@extends('templates.base')
@section('head')
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <title>Результаты</title>
    {!! HTML::style('css/font-awesome.min.css') !!}
    {!! HTML::style('css/test_style.css') !!}
@stop
@section('content')
    <div id="results">
        <div class="col-md-12 col-sm-6 card style-primary text-center">
            <h1 class="text-default-bright">Ваши результаты</h1>
        </div>
        <div class="col-md-12 col-sm-6 card style-primary">
            <h2 class="text-default-bright">Вы набрали {{$score}} баллов из {{ $total }}!</h2>
            <h2 class="text-default-bright">Ваша оценка: {{$mark_bologna}}({{$mark_rus}})</h2>
        </div>
    </div>
    <br>

    <div class="row">
        <a href="{{URL::route('home')}}" class="btn btn-warning btn-lg col-md-4 col-md-offset-4 style-primary" role="button">На главную</a>
    </div>
@stop
@section('js-down')
    {!! HTML::script('js/testResults.js') !!}
@stop