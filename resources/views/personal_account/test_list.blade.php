@extends('templates.base')
@section('head')
<meta name="csrf_token" content="{{ csrf_token() }}" />
<title>Список всех тестов</title>
@stop

@section('content')
<div class="col-md-12 col-sm-6 card style-primary text-center">
    <h1 class="">Список тестов</h1>
</div>

<div class="col-lg-offset-0 col-md-12 col-sm-6">
    <div class="card" id="edit-list">
        <div class="card-body">
            <div class="col-lg-offset-1 col-md-3 col-sm-3">
                <button class="btn btn-warning btn-raised btn-lg submit-test btn-period"
                        id="current-btn" type="submit">Текущие
                </button>
            </div>
            <div class="col-lg-offset-1 col-md-3 col-sm-3">
                <button class="btn btn-primary btn-raised btn-lg submit-test btn-period"
                        id="past-btn" type="submit">Прошлые
                </button>
            </div>
            <div class="col-lg-offset-1 col-md-3 col-sm-3">
                <button class="btn btn-primary btn-raised btn-lg submit-test btn-period"
                        id="future-btn" type="submit">Будущие
                </button>
            </div>
            <br>
            <br>
            <br>
            <!-- Блок с текущими тестами -->
            <div id="container-current" class="container-list" style="display: block;">
                <div class="col-lg-offset-0 col-md-12 col-sm-12 card style-gray">
                    <h2 class="text-default-bright">Контрольные тесты</h2>
                </div>
                <form action="{{URL::route('finish_test')}}" method="POST" class="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <table class="table table-condensed" id="out-of-date-test-table">
                        <tr>
                            <th>Название теста</th>
                            <th class="text-center">Время открытия теста</th>
                            <th class="text-center">Время закрытия теста</th>
                            <th class="text-center">Количество вопросов</th>
                            <th class="text-center">Время прохождения, мин</th>
                            <th class="text-center">Завершить тест</th>
                            <th class="text-center">Редактировать тест</th>
                            <th class="text-center">Удалить тест</th>
                        </tr>
                        @foreach ($current_ctr_tests as $test)
                        <input type="hidden" name="id-test[]" value="{{$test['id_test']}}">
                        <tr>
                            <td>{{$test['test_name']}}</td>
                            <td class="text-center">{{$test['start']}}</td>
                            <td class="text-center">{{$test['end']}}</td>
                            <td class="text-center">{{$test['amount']}}</td>
                            <td class="text-center">{{$test['test_time']}}</td>
                            <td class="text-center"> <div class="checkbox checkbox-styled">
                                    <label>
                                        <input type="hidden" name="changes[]" value="">
                                        <input type="checkbox" class="flag finish-checkbox" name="finished[]" value="true">
                                        <span></span>
                                    </label>
                                </div>
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
                        </tr>
                        @endforeach
                    </table>
                    <div class="col-lg-offset-9" >
                        <button class="btn btn-primary btn-raised submit-test" type="submit" id="finish-chosen">Завершить выбранные тесты</button>
                    </div>
                </form>
                <br>
                <div class="col-lg-offset-0 col-md-12 col-sm-12 card style-gray">
                    <h2 class="text-default-bright">Тренировочные тесты</h2>
                </div>
                <form action="{{URL::route('finish_test')}}" method="POST" class="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <table class="table table-condensed" id="out-of-date-test-table">
                        <tr>
                            <th>Название теста</th>
                            <th class="text-center">Время открытия теста</th>
                            <th class="text-center">Время закрытия теста</th>
                            <th class="text-center">Количество вопросов</th>
                            <th class="text-center">Время прохождения, мин</th>
                            <th class="text-center">Редактировать тест</th>
                            <th class="text-center">Удалить тест</th>
                        </tr>
                        @foreach ($current_tr_tests as $test)
                        <input type="hidden" name="id-test[]" value="{{$test['id_test']}}">
                        <tr>
                            <td>{{$test['test_name']}}</td>
                            <td class="text-center">{{$test['start']}}</td>
                            <td class="text-center">{{$test['end']}}</td>
                            <td class="text-center">{{$test['amount']}}</td>
                            <td class="text-center">{{$test['test_time']}}</td>
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
            </div>

            <!-- Блок с прошедшими тестами -->
            <div id="container-past" class="container-list" style="display: none;">
                <div class="col-lg-offset-0 col-md-12 col-sm-12 card style-gray">
                    <h2 class="text-default-bright">Контрольные тесты</h2>
                </div>
                <form action="{{URL::route('finish_test')}}" method="POST" class="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <table class="table table-condensed" id="out-of-date-test-table">
                        <tr>
                            <th>Название теста</th>
                            <th class="text-center">Время открытия теста</th>
                            <th class="text-center">Время закрытия теста</th>
                            <th class="text-center">Количество вопросов</th>
                            <th class="text-center">Время прохождения, мин</th>
                            <th class="text-center">Завершить тест</th>
                            <th class="text-center">Редактировать тест</th>
                            <th class="text-center">Удалить тест</th>
                        </tr>
                        @foreach ($past_ctr_tests as $test)
                        <input type="hidden" name="id-test[]" value="{{$test['id_test']}}">
                        <tr>
                            <td>{{$test['test_name']}}</td>
                            <td class="text-center">{{$test['start']}}</td>
                            <td class="text-center">{{$test['end']}}</td>
                            <td class="text-center">{{$test['amount']}}</td>
                            <td class="text-center">{{$test['test_time']}}</td>
                            @if ($test['finish_opportunity'] == 1)
                            <td class="text-center"> <div class="checkbox checkbox-styled">
                                    <label>
                                        <input type="hidden" name="changes[]" value="">
                                        <input type="checkbox" class="flag finish-checkbox" name="finished[]" value="true">
                                        <span></span>
                                    </label>
                                </div>
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
                            @else
                            <td class="text-center" title="Тест уже завершен">
                                <span class="demo-icon-hover">
                                    <i class="md md-done" style="font-size: 24px;"></i>
                                </span>
                            </td>
                            <td class="text-center">
                                 <span class="demo-icon-hover">
                                    <i class="md md-block" style="font-size: 24px;"></i>
                                </span>
                            </td>
                            <td class="text-center">
                                 <span class="demo-icon-hover">
                                    <i class="md md-block" style="font-size: 24px;"></i>
                                </span>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </table>
                    <div class="col-lg-offset-9"  id="finish-chosen">
                        <button class="btn btn-primary btn-raised submit-test" type="submit">Завершить выбранные тесты</button>
                    </div>
                </form>
                <br>
                <div class="col-lg-offset-0 col-md-12 col-sm-12 card style-gray">
                    <h2 class="text-default-bright">Тренировочные тесты</h2>
                </div>
                <form action="{{URL::route('finish_test')}}" method="POST" class="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <table class="table table-condensed" id="out-of-date-test-table">
                        <tr>
                            <th>Название теста</th>
                            <th class="text-center">Время открытия теста</th>
                            <th class="text-center">Время закрытия теста</th>
                            <th class="text-center">Количество вопросов</th>
                            <th class="text-center">Время прохождения, мин</th>
                            <th class="text-center">Редактировать тест</th>
                            <th class="text-center">Удалить тест</th>
                        </tr>
                        @foreach ($past_tr_tests as $test)
                        <input type="hidden" name="id-test[]" value="{{$test['id_test']}}">
                        <tr>
                            <td>{{$test['test_name']}}</td>
                            <td class="text-center">{{$test['start']}}</td>
                            <td class="text-center">{{$test['end']}}</td>
                            <td class="text-center">{{$test['amount']}}</td>
                            <td class="text-center">{{$test['test_time']}}</td>
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
            </div>

            <!-- Блок с будущими тестами -->
            <div id="container-future" class="container-list" style="display: none;">
                <div class="col-lg-offset-0 col-md-12 col-sm-12 card style-gray">
                    <h2 class="text-default-bright">Контрольные тесты</h2>
                </div>
                <form action="{{URL::route('finish_test')}}" method="POST" class="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <table class="table table-condensed" id="out-of-date-test-table">
                        <tr>
                            <th>Название теста</th>
                            <th class="text-center">Время открытия теста</th>
                            <th class="text-center">Время закрытия теста</th>
                            <th class="text-center">Количество вопросов</th>
                            <th class="text-center">Время прохождения, мин</th>
                            <th class="text-center">Редактировать тест</th>
                            <th class="text-center">Удалить тест</th>
                        </tr>
                        @foreach ($future_ctr_tests as $test)
                        <input type="hidden" name="id-test[]" value="{{$test['id_test']}}">
                        <tr>
                            <td>{{$test['test_name']}}</td>
                            <td class="text-center">{{$test['start']}}</td>
                            <td class="text-center">{{$test['end']}}</td>
                            <td class="text-center">{{$test['amount']}}</td>
                            <td class="text-center">{{$test['test_time']}}</td>
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
                        </tr>
                        @endforeach
                    </table>
                </form>
                <br>
                <div class="col-lg-offset-0 col-md-12 col-sm-12 card style-gray">
                    <h2 class="text-default-bright">Тренировочные тесты</h2>
                </div>
                <form action="{{URL::route('finish_test')}}" method="POST" class="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <table class="table table-condensed" id="out-of-date-test-table">
                        <tr>
                            <th>Название теста</th>
                            <th class="text-center">Время открытия теста</th>
                            <th class="text-center">Время закрытия теста</th>
                            <th class="text-center">Количество вопросов</th>
                            <th class="text-center">Время прохождения, мин</th>
                            <th class="text-center">Редактировать тест</th>
                            <th class="text-center">Удалить тест</th>
                        </tr>
                        @foreach ($future_tr_tests as $test)
                        <input type="hidden" name="id-test[]" value="{{$test['id_test']}}">
                        <tr>
                            <td>{{$test['test_name']}}</td>
                            <td class="text-center">{{$test['start']}}</td>
                            <td class="text-center">{{$test['end']}}</td>
                            <td class="text-center">{{$test['amount']}}</td>
                            <td class="text-center">{{$test['test_time']}}</td>
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
            </div>
        </div>
    </div>

</div>
{!! HTML::script('js/testList.js') !!}

@stop