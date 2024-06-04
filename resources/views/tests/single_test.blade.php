@extends('templates.base')
@section('head')
<title>Главная</title>
@stop
@section('content')
<div class="col-md-12 col-sm-6 card style-danger">
    <h1 class="text-default-bright">У вас уже открыт тест "{{$active_test_name}}"</h1>
</div>
<div class="row">
    <a href="{{$active_is_adaptive ? URL::route('show_adaptive_test_immediate') : URL::route('question_showtest', $active_test_id)}}" class="btn btn-warning btn-lg col-md-4 col-md-offset-4 style-primary" role="button">Продолжить решение</a>
    <a href="{{URL::route('drop_opened_test',  $desired_test_id)}}" class="btn btn-warning btn-lg col-md-4 col-md-offset-4 style-primary" role="button">Сбросить решение, начать новый тест</a>
</div>
@stop
