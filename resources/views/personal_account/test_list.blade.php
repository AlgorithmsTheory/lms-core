@extends('templates.base')
@section('head')
    {!! HTML::style('css/loading_blur.css') !!}
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <title>Список всех тестов</title>
@stop

@section('content')
<div id="main_container">
    <div class="col-md-12 col-sm-6 card style-primary text-center">
        <h1 class="">Список тестов</h1>
    </div>

    <div class="col-lg-offset-0 col-md-12 col-sm-6">
        <div class="card" id="edit-list">
            <div class="card-body">
                <!-- Блок с прошедшими тестами -->
                <div id="container" class="container-list">
                    <div class="col-lg-offset-0 col-md-12 col-sm-12 card style-gray">
                        <h2 class="text-default-bright">Контрольные тесты</h2>
                    </div>
                    <form action="" method="POST" class="form" style="overflow-x: auto; width: 100%">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <table class="table table-condensed control-tests-table" id="out-of-date-test-table">
                            <tr>
                                <th>Название теста</th>
                                <th class="text-center">Количество вопросов</th>
                                <th class="text-center">Время прохождения, мин</th>
                                <th class="text-center">Видимость</th>
                                <th class="text-center">Только для печати</th>
                                <th class="text-center">Перейти в профиль</th>
                                <th class="text-center">Редактировать тест</th>
                                <th class="text-center">Удалить тест</th>
                            </tr>
                            @foreach ($ctr_tests as $test)
                            <tr style="background-color: {{ $test['at_least_one_available'] ? '#caffca' : '#faeaea' }};">
                                <input type="hidden" name="id-test[]" class="id-test" value="{{$test['id_test']}}">
                                <td>{{$test['test_name']}}</td>
                                <td class="text-center">{{$test['amount']}}</td>
                                <td class="text-center">{{$test['test_time']}}</td>
                                <td class="text-center">
                                    <div class="checkbox checkbox-styled">
                                        <label>
                                            <input type="checkbox" name="visibility[]" class="visibility" @if ($test['visibility'] == 1) checked @endif>
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="checkbox checkbox-styled">
                                        <label>
                                            <input type="checkbox" name="only_for_print[]" class="only_for_print" @if ($test['only_for_print'] == 1) checked @endif>
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a href="{{URL::route('test_profile', $test['id_test'])}}" class="btn btn-info" role="button">
                                                <span class="demo-icon-hover">
                                                    <i class="md md-insert-chart"></i>
                                                </span>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a href="{{URL::route('test_edit', $test['id_test'])}}" class="btn btn-primary" role="button">
                                                <span class="demo-icon-hover">
                                                    <i class="md md-create"></i>
                                                </span>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a href="{{URL::route('test_remove', $test['id_test'])}}" class="btn btn-danger" role="button">
                                            <span class="demo-icon-hover">
                                                <i class="md md-remove-circle"></i>
                                            </span>
                                    </a>
                                </td>
                            @endforeach
                        </table>
                        <div class="col-lg-offset-9"  id="finish-chosen">
                            <button class="btn btn-primary btn-raised submit-test" type="submit">Завершить выбранные тесты</button>
                        </div>
                    </form>
                    <button class="btn btn-primary btn-raised btn-unavailable-all-control-tests" style="margin-bottom: 20px;}" type="button">
                        Сделать недоступными<br>
                        все контрольные тесты<br>
                        для всех групп
                    </button>
                    <div class="col-lg-offset-0 col-md-12 col-sm-12 card style-gray">
                        <h2 class="text-default-bright">Тренировочные тесты</h2>
                    </div>
                    <form action="" method="POST" class="form" style="overflow-x: auto">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id_group" value="{{ $id_group }}">
                        <table class="table table-condensed train-tests-table" id="out-of-date-test-table">
                            <tr>
                                <th>Название теста</th>
                                <th class="text-center">Количество вопросов</th>
                                <th class="text-center">Время прохождения, мин</th>
                                <th class="text-center">Видимость</th>
                                <th class="text-center">Только для печати</th>
                                <th class="text-center">Перейти в профиль</th>
                                <th class="text-center">Редактировать тест</th>
                                <th class="text-center">Удалить тест</th>
                            </tr>
                            @foreach ($tr_tests as $test)
                            <tr style="background-color: {{ $test['at_least_one_available'] ? '#caffca' : '#faeaea' }};">
                                <input type="hidden" name="id-test[]" class="id-test" value="{{$test['id_test']}}">
                                <td>{{$test['test_name']}}</td>
                                <td class="text-center">{{$test['amount']}}</td>
                                <td class="text-center">{{$test['test_time']}}</td>
                                <td class="text-center">
                                    <div class="checkbox checkbox-styled">
                                        <label>
                                            <input type="checkbox" name="visibility[]" class="visibility" @if ($test['visibility'] == 1) checked @endif>
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="checkbox checkbox-styled">
                                        <label>
                                            <input type="checkbox" name="only_for_print[]" class="only_for_print" @if ($test['only_for_print'] == 1) checked @endif>
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a href="{{URL::route('test_profile', $test['id_test'])}}" class="btn btn-info" role="button">
                                                <span class="demo-icon-hover">
                                                    <i class="md md-insert-chart"></i>
                                                </span>
                                    </a>
                                </td>
                                <td class="text-center" >
                                    <a href="{{URL::route('test_edit', $test['id_test'])}}" class="btn btn-primary" role="button">
                                                <span class="demo-icon-hover">
                                                    <i class="md md-create"></i>
                                                </span>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a href="{{URL::route('test_remove', $test['id_test'])}}" class="btn btn-danger" role="button">
                                            <span class="demo-icon-hover">
                                                <i class="md md-remove-circle"></i>
                                            </span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </form>
                    <button class="btn btn-primary btn-raised btn-unavailable-all-train-tests" type="button">
                        Сделать недоступными<br>
                        все тренировочные тесты<br>
                        для всех групп
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
<div id="overlay" class="none">
    <div class="loading-pulse"></div>
</div>
@stop

@section('js-down')
    {!! HTML::script('js/testList.js') !!}
@stop