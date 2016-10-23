@extends('templates.base')
@section('head')
<meta name="csrf_token" content="{{ csrf_token() }}" />
<title>Создание теста</title>
{!! HTML::style('css/createTest.css') !!}
{!! HTML::style('css/loading_blur.css') !!}
@stop

@section('content')
    <div class="section-body" id="page">
        <div class="col-md-12 col-sm-6 card style-primary text-center">
            <h1 class="">Создать тест</h1>
        </div>

        <!-- модуль задания основных настроек теста -->
        <div class="col-lg-offset-1 col-md-10 col-sm-10 card style-gray">
            <h2 class="text-default-bright">Настройка теста</h2>
        </div>
        <form action="{{URL::route('test_add')}}" method="POST" class="form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" id="num-rows" name="num-rows" value="1">
            <div class="col-lg-offset-1 col-md-10 col-sm-6">
                <div class="card">
                    <div class="card-body">
                            <!-- название теста -->
                            <div class="form-group dropdown-label">
                                <textarea  name="test-name" class="form-control textarea1" rows="1" placeholder=""  required></textarea>
                                <label for="textarea1">Название теста</label>
                            </div>
                            <!-- тренировочный тест -->
                        <div class="checkbox checkbox-styled">
                            <label>
                                <input type="checkbox" name="training" id="training">
                                <span>Тренировочный тест</span>
                            </label>
                        </div>
                        <!-- Видимость теста -->
                        <div class="checkbox checkbox-styled">
                            <label>
                                <input type="checkbox" name="visibility" id="visibility" checked>
                                <span>Видимость</span>
                            </label>
                        </div>
                        <!-- Доступен на английском языке -->
                        <div class="checkbox checkbox-styled">
                            <label>
                                <input type="checkbox" name="multilanguage" id="multilanguage">
                                <span>Доступен на английском языке</span>
                            </label>
                        </div>
                        <!-- Только для печатной версии -->
                        <div class="checkbox checkbox-styled">
                            <label>
                                <input type="checkbox" name="only-for-print" id="only-for-print">
                                <span>Только для печатной версии</span>
                            </label>
                        </div>
                        <!-- Максимум баллов за тест -->
                        <div class="form-group dropdown-label">
                            <input type="number" min="1" name="total" id="total" class="form-control" required>
                            <label for="total">Максимум баллов за тест</label>
                        </div>
                        <!-- Время на прохождение теста -->
                        <div class="form-group dropdown-label">
                            <input type="number" min="1" name="test-time" id="test-time" class="form-control" required>
                            <label for="test-time">Время на прохождение теста в минутах</label>
                        </div>
                     </div>
                </div>
            </div>
            <div class="col-lg-offset-1 col-md-10 col-sm-10">
                <div class="card">
                    <div class="card-body">
                       <table class="table table-condensed" id="test-dates-table">
                           <tr>
                               <td>Группа</td>
                               <td>Дата открытия</td>
                               <td>Время открытия</td>
                               <td>Дата закрытия</td>
                               <td>Время закрытия</td>
                           </tr>
                           @foreach ($groups as $group)
                                <input type="hidden" name="id-group[]" value="{{ $group['group_id'] }}">
                                <tr>
                                    <td>{{ $group['group_name'] }}</td>
                                    <td><input type="date" name="start-date[]" class="start-date" value="{{ $date }}"></td>
                                    <td><input type="time" name="start-time[]" class="start-time" value="{{ $time }}"></td>
                                    <td><input type="date" name="end-date[]" class="end-date" value="{{ $date }}"></td>
                                    <td><input type="time" name="end-time[]" class="end-time" value="{{ $time }}"></td>
                                </tr>
                           @endforeach
                       </table>
                    </div>
                </div>
            </div>

            <!-- модуль создания структуры теста -->
            <div class="col-lg-offset-1 col-md-10 col-sm-10 card style-gray">
                <h2 class="text-default-bright">Состав теста</h2>
            </div>
            <div class="col-lg-offset-1 col-md-10 col-sm-1">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped no-margin table-bordered" id="question-table">
                            <thead>
                            <tr>
                                <th class="num-field">Количество вопросов</th>
                                <th class="select-field">Раздел</th>
                                <th class="select-field">Тема</th>
                                <th class="select-field">Тип</th>
                                <th class="db-amount">Всего вопрососв такого типа</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr id="row-1" class="test-structure">
                                <td><input type="number" min="1" name="num[]" id="num-1" value="1" size="1" class="form-control num"></td>
                                <td> <select name="section[]" id="select-section-1" class="form-control select-section" size="1" required="">
                                        <option value="Любой">Любой</option>
                                        @foreach ($sections as $section)
                                        <option value="{{$section}}">{{$section}}</option>
                                        @endforeach
                                    </select></td>
                                <td>
                                        <div class="form-group" id="container-1">
                                            <select name="theme[]" id="select-theme" class="form-control select-theme" size="1" required="">
                                                <option value="Любая">Любая</option>
                                        <!-- контейнер для ajax -->
                                        </div>
                                </td>
                                <td> <select name="type[]" id="select-type" class="form-control select-type" size="1" required="">
                                        <option value="Любой">Любой</option>
                                        @foreach ($types as $type)
                                        <option value="{{$type}}">{{$type}}</option>
                                        @endforeach
                                    </select></td>
                                <td id="amount-container-1" class="amount-container"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-offset-10 col-md-2 col-sm-6" id="add-del-buttons">
                <button type="button" class="btn ink-reaction btn-floating-action btn-success" id="add-row"><b>+</b>   </button>
                <button type="button" class="btn ink-reaction btn-floating-action btn-danger" id="del-row"><b>-</b></button>
            </div>
            <div class="col-lg-offset-1 col-md-2 col-sm-6" id="add-test">
                <button class="btn btn-primary btn-raised submit-test" type="submit">Добавить тест</button>
                <br><br>
            </div>
        </form>
    </div>
    <div id="overlay" class="none">
        <div class="loading-pulse"></div>
    </div>
@stop

@section('js-down')
    {!! HTML::script('js/testCreate.js') !!}
@stop


