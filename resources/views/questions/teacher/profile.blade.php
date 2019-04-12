@extends('templates.base')
@section('head')
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <input type="hidden" id="id_question" value="{{ $question['id_question'] }}">
    <title>Профиль вопроса</title>
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/full.css') !!}
@stop

@section('content')
    <div class="col-lg-offset-1 col-md-10 col-sm-6">
        <div class="col-md-12 col-sm-6 card style-primary">
            <h1 class="text-default-bright text-center">Профиль вопроса</h1>
        </div>
    </div>

    <!-- Отображение вопроса в тесте -->
    <div class="col-lg-offset-1 col-md-10 col-sm-6">
        <div class="card card-collapsed">
            <div class="card-head style-primary-dark text-center">
                <div class="tools">
                    <div class="btn-group">
                        <a href="{{URL::route('question_edit', array($question['id_question']))}}" class="btn btn-icon-toggle dropdown-toggle"><i class="md md-colorize"></i></a>
                        <a class="btn btn-icon-toggle btn-collapse"><i class="md md-keyboard-arrow-down"></i></a>
                    </div>
                </div>
                <header>Отображение вопроса</header>
            </div>
            <div class="card-body">
                {!! $widget !!}
            </div>
        </div>
    </div>

    <!-- Настройки вопроса -->
    <div class="col-lg-offset-1 col-md-10 col-sm-6">
        <div class="card card-collapsed">
            <div class="card-head style-primary-dark text-center">
                <div class="tools">
                    <div class="btn-group">
                        <a href="{{URL::route('question_edit', array($question['id_question']))}}" class="btn btn-icon-toggle dropdown-toggle"><i class="md md-colorize"></i></a>
                        <a class="btn btn-icon-toggle btn-collapse"><i class="md md-keyboard-arrow-down"></i></a>
                    </div>
                </div>
                <header>Характеристики вопроса</header>
            </div>
            <div class="card-body" style="display: none">
                <table class="table table-bordered no-margin">
                    <thead>
                    <tr>
                        <th>Характеристика</th>
                        <th>Значение</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Число баллов</td>
                        <td>{{ $question['points'] }}</td>
                    </tr>
                    <tr>
                        <td>Сложность</td>
                        <td>{{ $question['difficulty'] }}</td>
                    </tr>
                    <tr>
                        <td>Разделяющая способность</td>
                        <td>{{ $question['discriminant'] }}</td>
                    </tr>
                    <tr>
                        <td>Коэффициент угадывания</td>
                        <td>{{ $question['guess'] }}</td>
                    </tr>
                    <tr>
                        <td>Доступен только в контролных тестах</td>
                        @if ($question['points'] == 1)
                            <td>Да</td>
                        @else
                            <td>Нет</td>
                        @endif
                    </tr>
                    <tr>
                        <td>Время на ответ в адаптивном режиме в секундах</td>
                        <td>{{ $question['pass_time'] }}</td>
                    </tr>
                    <tr>
                        <td>Переведен на английский язык</td>
                        @if ($question['translated'] == 1)
                            <td>Да</td>
                        @else
                            <td>Нет</td>
                        @endif
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Статистические показатели вопроса -->
    <div class="col-lg-offset-1 col-md-10 col-sm-6">
        <div class="card card-collapsed">
            <div class="card-head style-primary-dark text-center">
                <div class="tools">
                    <div class="btn-group">
                        <a href="{{URL::route('question_edit', array($question['id_question']))}}" class="btn btn-icon-toggle dropdown-toggle"><i class="md md-colorize"></i></a>
                        <a class="btn btn-icon-toggle btn-collapse" id="stat-down-button" style="display: none"><i class="md md-keyboard-arrow-down"></i></a>
                    </div>
                </div>
                <header>Статистические показатели</header>
            </div>
            <div class="card-body" style="display: none">
                <div id="success_pie" class="js-plotly-plot"></div>
                <hr>
                <div id="diff_and_disc_scatter" class="js-plotly-plot"></div>
                <hr>
                <div id="month_hist_frequency" class="js-plotly-plot"></div>
                <hr>
                <div id="success_group_hist" class="js-plotly-plot"></div>
            </div>
        </div>
    </div>
@stop

@section('js-down')
    {!! HTML::script('js/modules.js') !!}
    {!! HTML::script('js/statistics/question_profile.js') !!}

    {!! HTML::script('js/core/source/App.js') !!}
    {!! HTML::script('js/core/source/AppCard.js') !!}
    {!! HTML::script('js/core/demo/Demo.js') !!}
@stop