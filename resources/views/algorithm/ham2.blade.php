@extends('templates.base')
@section('head')
    <title>Эмулятор нормальных алгоритмов Маркова</title>
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <meta charset="utf-8">
    {!! HTML::style('css/algorithm/ham2.css') !!}
    {!! HTML::style('css/font-awesome.min.css?1422529194') !!}
@stop

@section('content')
    <div class="ham2-container">
        @include('algorithm.ham2real')
        <div class="ham2-examples-section">
            Пример:
            <div class="ham2-examples-buttons-wrapper"></div>
        </div>
    </div>
    <script>
        // Показать кнопку "Сделать шаг"
        const ham2StepBtnEl = document.querySelector('.ham2-step-btn');
        if (ham2StepBtnEl) {
            ham2StepBtnEl.style.display = '';
        }

        // Показать импорт экспорт
        const ham2ImportExportSection = document.querySelector('.ham2-import-export-section');
        if (ham2ImportExportSection) {
            ham2ImportExportSection.style.display = '';
        }

        // Показать комментарий
        const ham2CommentSection = document.querySelector('.ham2-comment-section');
        if (ham2CommentSection) {
            ham2CommentSection.style.display = '';
        }
    </script>
@stop

@section('js-down')
    {!! HTML::script('js/algorithm/ham2.js') !!}
@stop
