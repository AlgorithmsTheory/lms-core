@extends('templates.base')
@section('head')
    <title>Эмулятор машины Тьюринга - Система оценивания КР</title>
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <meta charset="utf-8">
    {!! HTML::style('css/algorithm/mt2.css') !!}
@stop

@section('content')
    <div class="mt2-help-container">
        <div class="mt2-rules-section">
            @include('algorithm.mt2help_scores_part')
        </div>
    </div>
@stop

@section('js-down')
@stop
