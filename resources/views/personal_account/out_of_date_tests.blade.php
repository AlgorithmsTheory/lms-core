@extends('templates.base')
@section('head')
<meta name="csrf_token" content="{{ csrf_token() }}" />
<title>Просроченные тесты</title>
{!! HTML::style('css/materialadmin.css') !!}
{!! HTML::style('css/full.css') !!}
{!! HTML::style('css/bootstrap.css') !!}
@stop

@section('background')
full
@stop

@section('content')
<div class="col-lg-offset-1 col-md-10 col-sm-6">
    <div class="card">
        <div class="card-body">
            <nav class="navbar col-md-4 col-md-offset-4 style-primary">
                <h3 class="text-center">Просроченные тесты</h3>
            </nav>
            <br>
            <br>
            <br>
            <div class="col-lg-offset-1 col-md-10 col-sm-10 card style-gray">
                <h2 class="text-default-bright">Контрольные тесты</h2>
            </div>
            <form action="{{URL::route('finish_test')}}" method="POST" class="form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <table class="table table-condensed" id="out-of-date-test-table">
                    <tr>
                        <th>Название теста</th>
                        <th class="text-center">Время закрытия теста</th>
                        <th class="text-center">Завершить тест</th>
                        <th class="text-center">Продлить тест
                            <span class="demo-icon-hover">
                                <i class="md md-restore"></i>
                            </span>
                        </th>
                    </tr>
                    @foreach ($out_of_date_control_tests as $test)
                    <input type="hidden" name="id-test[]" value="{{$test['id_test']}}">
                        <tr>
                            <td>{{$test['test_name']}}</td>
                            <td class="text-center">{{$test['end']}}</td>
                            <td class="text-center"> <div class="checkbox checkbox-styled">
                                    <label>
                                        <input type="checkbox" class="flag" name="finished[]">
                                        <span></span>
                                    </label>
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="{{URL::route('in_process')}}" class="btn btn-primary" role="button">
                                    <span class="demo-icon-hover">
                                        <i class="md md-restore"></i>
                                    </span>
                                </a>
                            </td>
                       </tr>
                    @endforeach
                </table>
                <div class="col-lg-offset-8"  id="finish-chosen">
                    <button class="btn btn-primary btn-raised submit-test" type="submit">Завершить выбранные тесты</button>
                </div>
            </form>
            <br>
                <div class="col-lg-offset-1 col-md-10 col-sm-10 card style-gray">
                    <h2 class="text-default-bright">Тренировочные тесты</h2>
                </div>
            <form action="{{URL::route('finish_test')}}" method="POST" class="form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <table class="table table-condensed" id="out-of-date-test-table">
                    <tr>
                        <th>Название теста</th>
                        <th class="text-center">Время закрытия теста</th>
                        <th class="text-center">Продлить тест на
                            <span class="demo-icon-hover">
                                <i class="md md-filter-4"></i>
                            </span>
                            месяца
                        </th>
                        <th class="text-center">Продлить тест
                            <span class="demo-icon-hover">
                                <i class="md md-restore"></i>
                            </span>
                        </th>
                    </tr>
                    @foreach ($out_of_date_training_tests as $test)
                    <input type="hidden" name="id-test[]" value="{{$test['id_test']}}">
                    <tr>
                        <td>{{$test['test_name']}}</td>
                        <td class="text-center">{{$test['end']}}</td>
                        <td class="text-center">
                            <a href="{{URL::route('in_process')}}" class="btn btn-primary" role="button">
                                    <span class="demo-icon-hover">
                                        <i class="md md-filter-4"></i>
                                    </span>
                            </a>
                        </td>
                        <td class="text-center" >
                            <a href="{{URL::route('in_process')}}" class="btn btn-primary" role="button">
                                    <span class="demo-icon-hover">
                                        <i class="md md-restore"></i>
                                    </span>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </table>
                <div class="col-lg-offset-8"  id="prolong-all">
                    <button class="btn btn-primary btn-raised submit-test" type="submit">Продлить все тесты на 4 месяца</button>
                </div>
            </form>
        </div>
    </div>

</div>
@stop

@section('js-down')
    {!! HTML::script('js/retest.js') !!}
@stop