@extends('templates.base')
@section('head')
    <title>Эмулятор машины Тьюринга - справка</title>
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <meta charset="utf-8">
    {!! HTML::style('css/algorithm/mt2.css') !!}
@stop

@section('content')
    <div class="mt2-help-container">
        <div class="mt2-rules-section">
            @include('algorithm.mt2help_common')
            <div>
                <button class="mt2-toggle-scores-section">
                    Справка по начислению баллов
                </button>
            </div>
            <div class="mt2-scores-rule-section" style="display: none">
                @include('algorithm.mt2help_scores_part')
            </div>
            <script>
                // Показать/скрыть секцию правил о начислении очков
                const toggleScoresSectionEl = document.querySelector('.mt2-toggle-scores-section');
                const scoresRuleSectionEl = document.querySelector('.mt2-scores-rule-section');
                let scoresRuleSectionVisible = false;
                toggleScoresSectionEl.addEventListener('click', () => {
                    scoresRuleSectionVisible = !scoresRuleSectionVisible;
                    scoresRuleSectionEl.style.display = scoresRuleSectionVisible ? '' : 'none';
                });
            </script>
        </div>
    </div>
@stop

@section('js-down')
@stop
