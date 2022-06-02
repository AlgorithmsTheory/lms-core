@extends('templates.base')
@section('head')
    <title>Редактирование параметров подсчета баллов для задач на эмулятор Маркова</title>

    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="your,keywords">
    <meta name="description" content="Short explanation about this website">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- END META -->

    <!-- BEGIN STYLESHEETS -->
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/font-awesome.min.css') !!}
    {!! HTML::style('css/material-design-iconic-font.min.css') !!}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <!-- END STYLESHEETS -->
@stop
@section('content')
    <!-- BEGIN BLANK SECTION -->
    <style>
        .ham-edit-params {
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 800px;
            margin: 0 auto;
        }
    </style>
    <div class="ham-edit-params">
        <h1>Редактирование параметров подсчета баллов для задач на эмулятор Маркова</h1>
        <p>Штрафные проценты:</p>
        <label>
            За проверку работы:
            <input class="tb-debug" type="text" value="{{$fees->debug_fee}}">
        </label>
        <label>
            За запуск:
            <input class="tb-run" type="text" value="{{$fees->run_fee}}">
        </label>
        <label>
            За отладку (запуск с шагами):
            <input class="tb-steps" type="text" value="{{$fees->steps_fee}}">
        </label>
        <button class="btn-apply">Применить</button>
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
    {!! HTML::script('js/algorithm/ham-edit-params.js') !!}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select-multiple').select2();
        });
    </script>
    <!-- END JAVASCRIPT -->
@stop

