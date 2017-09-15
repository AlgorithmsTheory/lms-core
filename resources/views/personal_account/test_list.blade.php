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
            <!-- Блок с прошедшими тестами -->
            <div id="container-past" class="container-list">
                <div class="col-lg-offset-0 col-md-12 col-sm-12 card style-gray">
                    <h2 class="text-default-bright">Контрольные тесты</h2>
                </div>
                <form action="{{URL::route('finish_test')}}" method="POST" class="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <table class="table table-condensed" id="out-of-date-test-table">
                        <tr>
                            <th>Название теста</th>
                            <th class="text-center">Количество вопросов</th>
                            <th class="text-center">Время прохождения, мин</th>
                            <th class="text-center">Видимость</th>
                            <th class="text-center">Только для печати</th>
                            <th class="text-center">Доступен на английском</th>
                            <th class="text-center">Завершить тест</th>
                            <th class="text-center">Редактировать тест</th>
                            <th class="text-center">Удалить тест</th>
                        </tr>
                        @foreach ($ctr_tests as $test)
                        <input type="hidden" name="id-test[]" value="{{$test['id_test']}}">
                        <tr>
                            <td>{{$test['test_name']}}</td>
                            <td class="text-center">{{$test['amount']}}</td>
                            <td class="text-center">{{$test['test_time']}}</td>
                            <td class="text-center">{{$test['visibility']}}</td>
                            <td class="text-center">{{$test['only_for_print']}}</td>
                            <td class="text-center">{{$test['multilanguage']}}</td>
                            @if ($test['finish_opportunity'] == 1)
                            <td class="text-center"> <div class="checkbox checkbox-styled">
                                    <label>
                                        <input type="hidden" name="changes[]" value="">
                                        <input type="checkbox" class="flag finish-checkbox" name="finished[]" value="true">
                                        <span></span>
                                    </label>
                                </div>
                            </td>
                            @else
                            <td class="text-center" title="Тест уже завершен">
                                <span class="demo-icon-hover">
                                    <i class="md md-done" style="font-size: 24px;"></i>
                                </span>
                            </td>
                            @endif
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
                <br>
                <div class="col-lg-offset-0 col-md-12 col-sm-12 card style-gray">
                    <h2 class="text-default-bright">Тренировочные тесты</h2>
                </div>
                <form action="{{URL::route('finish_test')}}" method="POST" class="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id_group" value="{{ $id_group }}">
                    <table class="table table-condensed" id="out-of-date-test-table">
                        <tr>
                            <th>Название теста</th>
                            <th class="text-center">Количество вопросов</th>
                            <th class="text-center">Время прохождения, мин</th>
                            <th class="text-center">Видимость</th>
                            <th class="text-center">Только для печати</th>
                            <th class="text-center">Доступен на английском</th>
                            <th class="text-center">Редактировать тест</th>
                            <th class="text-center">Удалить тест</th>
                        </tr>
                        @foreach ($tr_tests as $test)
                        <input type="hidden" name="id-test[]" value="{{$test['id_test']}}">
                        <tr>
                            <td>{{$test['test_name']}}</td>
                            <td class="text-center">{{$test['amount']}}</td>
                            <td class="text-center">{{$test['test_time']}}</td>
                            <td class="text-center">{{$test['visibility']}}</td>
                            <td class="text-center">{{$test['only_for_print']}}</td>
                            <td class="text-center">{{$test['multilanguage']}}</td>
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