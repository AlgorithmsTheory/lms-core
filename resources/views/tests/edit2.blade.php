@extends('templates.base')
@section('head')
<meta name="csrf_token" content="{{ csrf_token() }}" />
<title>Редактирование структуры теста</title>
{!! HTML::style('css/createTest2.css') !!}
{!! HTML::style('css/loading_blur.css') !!}
@stop

@section('content')
<div id="structures_data" style="display: none">{{$structures_data}}</div>
<div class="section-body" id="page">
    <div class="col-md-12 col-sm-6 card style-primary text-center">
        <h1 id="header_name" class=""><!-- insert in JS --></h1>
    </div>
    <form action="{{URL::route('test_change_structure')}}" method="POST" class="form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="num-rows" name="num-rows" value="1">
        <input type="hidden" id="sections-info" name="sections-info" value="{{$json_sections}}">
        <input type="hidden" id="types-info" name="types-info" value="{{$json_types}}">
        <input type="hidden" id="general-settings" name="general-settings" value="{{$general_settings}}">

        <div id="structures">
        </div>

        <div class="col-md-10 col-sm-10" id="add-test">
            <button class="btn btn-primary btn-raised submit-test" type="button" id="add-test-button">Редактировать тест</button>
            <br><br>
        </div>
        
        <div class="col-sm-2" id="add-del-buttons">
            <button type="button" class="btn ink-reaction btn-floating-action btn-success" id="add-structure"><b>+</b>   </button>
            <button type="button" class="btn ink-reaction btn-floating-action btn-danger" id="del-structure"><b>-</b></button>
        </div>

    </form>
</div>
<div id="overlay" class="none">
    <div class="loading-pulse"></div>
</div>
@stop

@section('js-down')
{!! HTML::script('js/testCreate2.js') !!}
{!! HTML::script('js/testEdit2.js') !!}
@stop


