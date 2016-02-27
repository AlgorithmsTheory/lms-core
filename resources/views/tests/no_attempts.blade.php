@extends('templates.base')
@section('head')
<title>Нет попыток</title>
@stop
@section('content')
<div class="col-md-12 col-sm-6 card style-danger">
    <h1 class="text-default-bright">К сожалению, у вас нет попыток проходить этот тест</h1>
    <h2 class="text-default-bright">В новой попытке вы сможете набрать не больше {{ $max_test_points }} баллов</h2>
</div>
<div class="row">
    <a href="{{ URL::route('tests') }}" class="btn btn-warning btn-lg col-md-4 col-md-offset-4 style-primary" role="button">К списку тестов</a>
</div>
@stop