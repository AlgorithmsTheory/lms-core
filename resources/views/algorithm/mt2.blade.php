@extends('templates.base')
@section('head')
    <title>Эмулятор машины Тьюринга</title>
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <meta charset="utf-8">
    {!! HTML::style('css/algorithm/mt2.css') !!}
    {!! HTML::style('css/font-awesome.min.css?1422529194') !!}
@stop

@section('content')
    <div class="mt2-container">
        @include('algorithm.mt2real')
        <div class="mt2-examples-section">
            Пример:
            <div class="mt2-examples-buttons-wrapper"></div>
        </div>
    </div>
    <script>
        // Показать кнопку "Сделать шаг"
        const mt2StepBtnEl = document.querySelector('.mt2-step-btn');
        if (mt2StepBtnEl) {
            mt2StepBtnEl.style.display = '';
        }

        // Показать импорт экспорт
        const mt2ImportExportSection = document.querySelector('.mt2-import-export-section');
        if (mt2ImportExportSection) {
            mt2ImportExportSection.style.display = '';
        }

        // Показать комментарий
        const mt22CommentSection = document.querySelector('.mt2-comment-section');
        if (mt22CommentSection) {
            mt22CommentSection.style.display = '';
        }
    </script>
@stop

@section('js-down')
    {!! HTML::script('js/algorithm/mt2.js') !!}
@stop
