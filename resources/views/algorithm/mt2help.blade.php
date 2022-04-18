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
            <h3>Как начисляются баллы?</h3>
            <p>
                Баллы, которые пользователь получит за решение вычисляются по следующей формуле:
            </p>
            <p>
                <code>score = points * seq_true / seq_all</code>,
            </p>
            где
            <ul>
                <li><code>score</code> - результирующее число баллов, которое получит пользователь;</li>
                <li><code>points</code> - максимальное число баллов за данный вопрос;</li>
                <li><code>seq_true</code> - число пройденных тестов;</li>
                <li><code>seq_all</code> - общее число тестов.</li>
            </ul>
            <p>Число нажатий на кнопку "ПРОВЕРИТЬ РАБОТУ" не влияет на результат.</p>
            <p>Число нажатий на кнопку "ЗАПУСТИТЬ" или "СДЕЛАТЬ ШАГ" не влияет на результат.</p>
            <p>Таким образом, оценка зависит от количества пройденных тестов и только.</p>
            @include('algorithm.mt2help_common')
        </div>
    </div>
@stop

@section('js-down')
@stop
