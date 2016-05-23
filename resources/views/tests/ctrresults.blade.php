@extends('templates.base')
@section('head')
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <title>Результаты</title>
    {!! HTML::style('css/full.css') !!}
    {!! HTML::style('css/font-awesome.min.css') !!}
    {!! HTML::style('css/material-design-iconic-font.min.css') !!}
    {!! HTML::style('css/materialadmin_demo.css') !!}
    {!! HTML::style('css/test_style.css') !!}
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
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
        <table id="result-table">
            <?php $i=1;?>
            @foreach($widgets as $widget)
            <tr>
                <td>{!! $widget !!}</td>
                @if ($right_or_wrong[$i] == 'Верно')
                <td><div class="col-md-12 col-sm-6 card style-success">
                        <h2 class="text-default-bright answer">{{$right_or_wrong[$i]}}</h2>
                        <h2 class="text-default-bright answer">({{$right_percent[$i]}}%)</h2>
                    </div></td>
                @endif
                @if ($right_or_wrong[$i] == 'Неверно')
                <td><div class="col-md-12 col-sm-6 card style-danger">
                        <h2 class="text-default-bright answer">{{$right_or_wrong[$i]}}</h2>
                        <h2 class="text-default-bright answer">({{$right_percent[$i]}}%)</h2>
                    </div></td>
                @endif
            </tr>
            <?php $i++;?>
            @endforeach
        </table>
    </div>
    <br>

    <div class="row">
        <a href="{{URL::route('tests')}}" class="btn btn-warning btn-lg col-md-4 col-md-offset-4 style-primary" role="button">К списку тестов</a>
    </div>
    <input type="hidden" name="user" id="user" value="{{ $id_user }}">
    <input type="hidden" name="test" id="test" value="{{ $id_test }}">
@stop
@section('js-down')
    {!! HTML::script('js/testResults.js') !!}
@stop