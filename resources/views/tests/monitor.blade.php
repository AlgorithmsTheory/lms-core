@extends('templates.base')
@section('head')
<meta name="csrf_token" content="{{ csrf_token() }}" />
<title>Состояние контрольных тестов</title>}
{!! HTML::style('css/createTest.css') !!}
{!! HTML::style('css/loading_blur.css') !!}
@stop

@section('content')
<div class="section-body" id="page">
    <div class="col-md-12 col-sm-6 card style-primary text-center">
        <h1 class="">Состояние контрольных тестов</h1>
    </div>
        <!-- модуль задания основных настроек теста -->
        <div class="col-lg-offset-1 col-md-10 col-sm-10 card style-gray">
            <h2 class="text-default-bright"><center>Управление доступностью контрольных тестов для групп</center></h2>
        </div>
        <form action="{{URL::route('test_update')}}" method="POST" class="form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" id="num-rows" name="num-rows" value="{{ count($structures) }}">
            <input type="hidden" id="id-test" name="id-test" value="{{ $test['id_test'] }}">
            <input type="hidden" id="test-type" name="test-type" value="{{ $test['test_type'] }}">
            <input type="hidden" id="test-resolved" name="test-resolved" value="{{ $test['is_resolved'] }}">
            <input type="hidden" id="go-to-edit-structure" name="go-to-edit-structure" value="0">

            <div class="col-md-offset-2 col-md-8 col-sm-8">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-condensed" id="test-dates-table">
                            <tr>
                                <td></td>
                                <td>Без группы</td>
                                <td>Админы</td>
                                <td>Б17-501</td>
                                <td>Б17-504</td>
                                <td>Б17-511</td>
                                <td>Б17-514</td>
                                <td>Б17-565</td>
                                <td>Б17-594</td>
                            </tr>
                            <tr>
                                <td>Контрольный тест №1</td>
                                <td></td>
                                <td></td>
                                @for($i = 0; $i < 6; $i++)
                                <td class="text-center">
                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-3 checkbox checkbox-styled">
                                            <label>
                                                <input type="checkbox" >
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="col-sm-3">
                                            <button class="btn btn-danger finish-test-for-group" type="button">
                                                <div class="demo-icon-hover">
                                                    <span class="glyphicon glyphicon-time text-medium"></span>
                                                </div>
                                            </button>
                                            <a href="{{URL::route('finish_test_for_group', [$test['id_test'], $group['id_group']])}}" style="display: none;"></a>
                                        </div>
                                        <div class="col-sm-3"></div>
                                    </div>
                                </td>
                                @endfor
                            </tr><tr>
                                <td>Контрольный тест №2</td>
                                <td></td>
                                <td></td>
                                @for($i = 0; $i < 6; $i++)
                                <td class="text-center">
                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-3 checkbox checkbox-styled">
                                            <label>
                                                <input type="checkbox" >
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="col-sm-3">
                                            <button class="btn btn-danger finish-test-for-group" type="button">
                                                <div class="demo-icon-hover">
                                                    <span class="glyphicon glyphicon-time text-medium"></span>
                                                </div>
                                            </button>
                                            <a href="{{URL::route('finish_test_for_group', [$test['id_test'], $group['id_group']])}}" style="display: none;"></a>
                                        </div>
                                        <div class="col-sm-3"></div>
                                    </div>
                                </td>
                                @endfor
                            </tr><tr>
                                <td>Контрольный тест №3</td>
                                <td></td>
                                <td></td>
                                @for($i = 0; $i < 6; $i++)
                                <td class="text-center">
                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-3 checkbox checkbox-styled">
                                            <label>
                                                <input type="checkbox" >
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="col-sm-3">
                                            <button class="btn btn-danger finish-test-for-group" type="button">
                                                <div class="demo-icon-hover">
                                                    <span class="glyphicon glyphicon-time text-medium"></span>
                                                </div>
                                            </button>
                                            <a href="{{URL::route('finish_test_for_group', [$test['id_test'], $group['id_group']])}}" style="display: none;"></a>
                                        </div>
                                        <div class="col-sm-3"></div>
                                    </div>
                                </td>
                                @endfor
                            </tr><tr>
                                <td>Заключительный контрольный тест</td>
                                <td></td>
                                <td></td>
                                @for($i = 0; $i < 6; $i++)
                                <td class="text-center">
                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-3 checkbox checkbox-styled">
                                            <label>
                                                <input type="checkbox" >
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="col-sm-3">
                                            <button class="btn btn-danger finish-test-for-group" type="button">
                                                <div class="demo-icon-hover">
                                                    <span class="glyphicon glyphicon-time text-medium"></span>
                                                </div>
                                            </button>
                                            <a href="{{URL::route('finish_test_for_group', [$test['id_test'], $group['id_group']])}}" style="display: none;"></a>
                                        </div>
                                        <div class="col-sm-3"></div>
                                    </div>
                                </td>
                                @endfor
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop
@section ('js-down')
{!! HTML::script('js/testEdit.js') !!}
@stop


