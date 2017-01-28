@extends('templates.base')
@section('head')
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <title>Администрирование</title>
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/full.css') !!}
    {!! HTML::style('css/tests_list.css') !!}

@stop

@section('background')
    full
@stop

@section('content')
    <div class="card style-default-light">
        <h2 class="text-center">Панель управления системой</h2>
            <div class="col-md-12 col-sm-12 style-gray">
                <h2 class="text-default-bright">Общие административные функции</h2>
            </div>
            <div class="card col-md-10 col-sm-10 col-md-offset-1">
                <div class="card-body no-padding">
                    <ul class="list divider-full-bleed">
                        <li class="tile">
                            <a href="{{ route('statements')}}" class="tile-content ink-reaction">
                            <div class="tile-text">
                                Работа с ведомостями
                            </div>
                            </a>
                        </li>
                        <li class="tile">
                            <a href="{{ route('verify_students')}}" class="tile-content ink-reaction">
                            <div class="tile-text">
                                Добавление студентов
                            </div>
                            </a>
                        </li>
                        @if(Auth::user()['role'] == 'Админ')
                        <li class="tile">
                            <a href="{{ route('change_role')}}" class="tile-content ink-reaction">
                            <div class="tile-text">
                                Работа с пользователями
                            </div>
                            </a>
                        </li>
                        @endif
                        <li class="tile">
                            <a href="{{ route('student_info')}}" class="tile-content ink-reaction">
                            <div class="tile-text">
                                Просмотр личного кабинета
                            </div>
                            </a>
                        </li>
                        @if(Auth::user()['role'] == 'Админ')
                        <li class="tile">
                            <a href="{{ route('manage_groups')}}" class="tile-content ink-reaction">
                            <div class="tile-text">
                                Назначить группы
                            </div>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()['role'] == 'Админ')
                        <li class="tile">
                            <a href="{{ route('manage_news')}}" class="tile-content ink-reaction">
                            <div class="tile-text">
                                Редактировать новости
                            </div>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()['role'] == 'Админ')
                            <li class="tile">
                                <a href="{{ route('group_set')}}" class="tile-content ink-reaction">
                                    <div class="tile-text">
                                        Редактировать список групп
                                    </div>
                                </a>
                            </li>
                        @endif
                        <li class="tile">
                            <a href="{{ route('manage_plan')}}" class="tile-content ink-reaction">
                            <div class="tile-text">
                                Редактировать план выполнения учебного курса
                            </div>
                            </a>
                        </li>
                    </ul>
                </div><!--end .card-body -->
            </div>
            <div class="col-md-12 col-sm-12 style-gray">
                <h2 class="text-default-bright">Модуль тестирования</h2>
            </div>
            <div class="card col-md-10 col-sm-10 col-md-offset-1">
                <div class="card-body no-padding">
                    <ul class="list divider-full-bleed">
                        <li class="tile">
                            <a href="{{ route('question_create')}}" class="tile-content ink-reaction">
                            <div class="tile-text">
                                Добавление вопросов
                            </div>
                            </a>
                        </li>
                        <li class="tile">
                            <a href="{{ route('questions_list')}}" class="tile-content ink-reaction">
                            <div class="tile-text">
                                Список всех вопросов
                            </div>
                            </a>
                        </li>
                        <li class="tile">
                            <a href="{{ route('test_create')}}" class="tile-content ink-reaction">
                            <div class="tile-text">
                                Добавление тестов
                            </div>
                            </a>
                        </li>
                        <li class="tile">
                            <a href="{{ route('choose_group')}}" class="tile-content ink-reaction">
                            <div class="tile-text">
                                Список всех тестов
                            </div>
                            </a>
                        </li>
                        <li class="tile">
                            <a href="{{ route('retest_index')}}" class="tile-content ink-reaction">
                            <div class="tile-text">
                                Переписывание тестов
                            </div>
                            </a>
                        </li>
                        <li class="tile">
                            <a href="{{ route('all_test_results')}}" class="tile-content ink-reaction">
                            <div class="tile-text">
                                Результаты тестирования
                            </div>
                            </a>
                        </li>
                        <li class="tile">
                            <a href="{{ route('generator_index')}}" class="tile-content ink-reaction">
                            <div class="tile-text">
                                Генерация печатных тестов
                            </div>
                            </a>
                        </li>
                    </ul>
                </div><!--end .card-body -->
            </div>
            <div class="col-md-12 col-sm-12 style-gray">
                <h2 class="text-default-bright">Электронная библиотека</h2>
            </div>
            <div class="card col-md-10 col-sm-10 col-md-offset-1">
                <div class="card-body no-padding">
                    <ul class="list divider-full-bleed">
                        <li class="tile">
                            <a href="{{ route('library_calendar')}}" class="tile-content ink-reaction">
                                <div class="tile-text">
                                    Задать даты лекций
                                </div>
                            </a>
                        </li>
                        <li class="tile">
                            <a href="{{ route('library_order_list')}}" class="tile-content ink-reaction">
                                <div class="tile-text">
                                    Бронирование печатных изданий
                                </div>
                            </a>
                        </li>
                    </ul>
                </div><!--end .card-body -->
            </div>
            <div class="col-md-12 col-sm-12 style-gray">
                <h2 class="text-default-bright">Эмуляторы</h2>
            </div>

            <div class="card col-md-10 col-sm-10 col-md-offset-1">
                <div class="card-body no-padding">
                    <ul class="list divider-full-bleed">
                        <li class="tile">
                            <a href="{{ route('main_menu')}}" class="tile-content ink-reaction">
                                <div class="tile-text">
                                    Управление контрольными материалами эмуляторов Машины Тьюринга и Алгоритмов Маркова
                                </div>
                            </a>
                        </li>
                        
                    </ul>
                </div><!--end .card-body -->
            </div>
    </div>

@stop