@extends('templates.base')
@section('head')
<meta name="csrf_token" content="{{ csrf_token() }}" />
<title>Создание вопроса</title>
{!! HTML::style('css/question_create.css') !!}
@stop

@section('content')
<div class="section-body" id="page">
    <div class="col-md-12 col-sm-6 card style-primary text-center">
        <h1 class="">Создать новый вопрос</h1>
    </div>
        <form action="{{URL::route('question_add')}}" method="POST" class="form" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="q-type" value="">
            <div class="col-lg-offset-1 col-md-10 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <!-- Выбор типа вопроса -->
                        <div class="form-group ">
                            <select name="type" id="select-type" class="form-control" size="1">
                                <option value="$nbsp"></option>
                                @foreach ($types as $type)
                                <option value="{{$type['type_name']}}">{{$type['type_name']}}</option>/td>
                                @endforeach
                            </select>
                            <label for="select-type">Тип</label>
                        </div>


                        <div id="type_question_add"></div>
@stop
@section('js-down')
    {!! HTML::script('js/core/source/App.js') !!}
    {!! HTML::script('js/core/source/AppCard.js') !!}
    {!! HTML::script('js/core/demo/Demo.js') !!}
    {!! HTML::script('js/question_create/questionCreate.js') !!}
@stop