@extends('templates.base')
@section('head')
<title>Главная</title>
@stop
@section('content')
<div class="col-md-12 col-sm-6 card style-danger">
    <h1 class="text-default-bright">У вас уже открыт тест "{{$test_name}}"</h1>
</div>
<div class="row">
    <a href="{{URL::route('question_showtest', $id_test)}}" class="btn btn-warning btn-lg col-md-4 col-md-offset-4 style-primary" role="button">Продолжить решение</a>
</div>
@stop