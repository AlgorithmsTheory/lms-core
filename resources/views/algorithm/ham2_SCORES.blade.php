@extends('templates.base')
@section('head')
    <title>Эмулятор нормальных алгоритмов Маркова - Система оценивания КР</title>
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <meta charset="utf-8">
    {!! HTML::style('css/algorithm/ham2.css') !!}
@stop

@section('content')
    <div class="ham2-help-container">
        <div class="ham2-rules-section">
            @include('algorithm.ham2help_scores_part')
        </div>
    </div>
@stop

@section('js-down')
@stop
