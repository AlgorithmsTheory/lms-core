@extends('templates.base')
@section('head')
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <input type="hidden" id="id_test" value="{{ $test['id_test'] }}">
    <title>Профиль вопроса</title>
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/full.css') !!}
@stop

@section('content')
    <div class="col-lg-offset-1 col-md-10 col-sm-6">
        <div class="col-md-12 col-sm-6 card style-primary">
            <h1 class="text-default-bright text-center">Профиль теста "{{ $test['test_name'] }}"</h1>
        </div>
    </div>

    <!-- Структура теста -->
    <div class="col-lg-offset-1 col-md-10 col-sm-6">
        <div class="card card-collapsed">
            <div class="card-head style-primary-dark text-center">
                <div class="tools">
                    <div class="btn-group">
                        <a href="{{URL::route('test_edit', array($test['id_test']))}}" class="btn btn-icon-toggle dropdown-toggle"><i class="md md-colorize"></i></a>
                        <a class="btn btn-icon-toggle btn-collapse"><i class="md md-keyboard-arrow-down"></i></a>
                    </div>
                </div>
                <header>Структура теста</header>
            </div>
            <div class="card-body height-10 scroll">
                <table class="table table-bordered no-margin">
                    <thead>
                    <tr>
                        <th>Число вопросов</th>
                        <th>Разделы</th>
                        <th>Темы</th>
                        <th>Типы</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($restrictions as $restriction)
                        <tr>
                            <td>{{$restriction['amount']}}</td>
                            <td>
                                @foreach($restriction['sections'] as $section)
                                    {{ $section }} <br>
                                @endforeach
                            </td>
                            <td>
                                @foreach($restriction['themes'] as $theme)
                                    {{ $theme }} <br>
                                @endforeach
                            </td>
                            <td>
                                @foreach($restriction['types'] as $type)
                                    {{ $type }} <br>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Настройки теста -->
    <div class="col-lg-offset-1 col-md-10 col-sm-6">
        <div class="card card-collapsed">
            <div class="card-head style-primary-dark text-center">
                <div class="tools">
                    <div class="btn-group">
                        <a href="{{URL::route('test_edit', array($test['id_test']))}}" class="btn btn-icon-toggle dropdown-toggle"><i class="md md-colorize"></i></a>
                        <a class="btn btn-icon-toggle btn-collapse"><i class="md md-keyboard-arrow-down"></i></a>
                    </div>
                </div>
                <header>Характеристики Теста</header>
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
                        <td>Тип теста</td>
                        <td>{{ $test['test_type'] }}</td>
                    </tr>
                    <tr>
                        <td>Является адаптивным</td>
                        @if ($test['is_adaptive'] == 1)
                            <td>Да</td>
                        @else
                            <td>Нет</td>
                        @endif
                    </tr>
                    <tr>
                        <td>Открыт для прохождения</td>
                        @if ($test['visibility'] == 1)
                            <td>Да</td>
                        @else
                            <td>Нет</td>
                        @endif
                    </tr>
                    <tr>
                        <td>Удален</td>
                        @if ($test['archived'] == 1)
                            <td>Да</td>
                        @else
                            <td>Нет</td>
                        @endif
                    </tr>
                    <tr>
                        <td>Доступен на английском языке</td>
                        @if ($test['multilanguage'] == 1)
                            <td>Да</td>
                        @else
                            <td>Нет</td>
                        @endif
                    </tr>
                    <tr>
                        <td>Предназначен только для печатной версии</td>
                        @if ($test['only_for_print'] == 1)
                            <td>Да</td>
                        @else
                            <td>Нет</td>
                        @endif
                    </tr>
                    <tr>
                        <td>Время на прохождение в минутах</td>
                        <td>{{ $test['test_time'] }}</td>
                    </tr>
                    <tr>
                        <td>Максимальное число баллов</td>
                        <td>{{ $test['total'] }}</td>
                    </tr>
                    <tr>
                        <td>Математическое ожидание результатов</td>
                        <td>{{ $test['mean'] }}</td>
                    </tr>
                    <tr>
                        <td>Медиана результатов</td>
                        <td>{{ $test['median'] }}</td>
                    </tr>
                    <tr>
                        <td>Среднеквадратичное отклонение результатов</td>
                        <td>{{ $test['deviation'] }}</td>
                    </tr>
                    <tr>
                        <td>Надежность теста</td>
                        <td>{{ $test['reliability'] }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Статистические показатели вопроса -->
    <div class="col-lg-offset-1 col-md-10 col-sm-6" id="stats">
        <div class="card card-collapsed">
            <div class="card-head style-primary-dark text-center">
                <div class="tools">
                    <div class="btn-group">
                        <a href="{{URL::route('test_edit', array($test['id_test']))}}" class="btn btn-icon-toggle dropdown-toggle"><i class="md md-colorize"></i></a>
                        <a class="btn btn-icon-toggle btn-collapse" id="stat-down-button" style="display: none"><i class="md md-keyboard-arrow-down"></i></a>
                    </div>
                </div>
                <header>Статистические показатели</header>
            </div>
            <div class="card-body" style="display: none">
                <form class="form">
                    <div class="form-group">
                        <select name="section" id="test_results_selector" class="form-control" size="1" required>
                            <option value="-1">Все</option>
                            @foreach($groups as $group)
                                <option value="{{ $group['group_id']}}">{{ $group['group_name'] }}</option>
                            @endforeach
                        </select>
                        <label for="test_results_selector">Группа</label>
                    </div>
                </form>
                <div id="test_results_pie" class="js-plotly-plot"></div>
                <hr>
                <div id="types_freq" class="js-plotly-plot"></div>
            </div>
        </div>
    </div>
@stop

@section('js-down')
    {!! HTML::script('js/libs/spin.js/spin.min.js') !!}
    {!! HTML::script('js/libs/autosize/jquery.autosize.min.js') !!}
    {!! HTML::script('js/libs/nanoscroller/jquery.nanoscroller.min.js') !!}
    {!! HTML::script('js/core/source/App.js') !!}
    {!! HTML::script('js/core/source/AppNavigation.js') !!}
    {!! HTML::script('js/core/source/AppOffcanvas.js') !!}
    {!! HTML::script('js/core/source/AppCard.js') !!}
    {!! HTML::script('js/core/source/AppForm.js') !!}
    {!! HTML::script('js/core/source/AppNavSearch.js') !!}
    {!! HTML::script('js/core/source/AppVendor.js') !!}
    {!! HTML::script('js/core/demo/Demo.js') !!}
    {!! HTML::script('js/plotly-latest.min.js') !!}
    {!! HTML::script('js/statistics/test_profile.js') !!}
@stop