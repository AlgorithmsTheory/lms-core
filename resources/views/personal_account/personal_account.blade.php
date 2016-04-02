@extends('templates.base')
@section('head')
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <title>Личный кабинет</title>
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/full.css') !!}
@stop

@section('background')
    full
@stop

@section('content')
    <div class="col-lg-offset-1 col-md-10 col-sm-6">
        <div class="card">
            <div class="card-body">
                <nav class="navbar col-md-4 col-md-offset-4 style-primary">
                    <div class="container-fluid">
                        <div id="navbar" class="collapse navbar-collapse">
                            <ul class="nav navbar-nav">
                                {{--<li><a href="{{URL::route('personal_account')}}" class="btn">Результаты прохождения тестов</a></li>--}}
                                <li><h3>Результаты прохождения тестов</h3></li>
                            </ul>
                            {{--<ul class="nav navbar-nav navbar-right">--}}
                                {{--<li><a href="{{URL::route('in_process')}}" class="btn">Личные данные</a></li>--}}
                            {{--</ul>--}}
                        </div>
                    </div><!-- /.container-fluid -->
                </nav>
                <br>
                <br>
                <br>
                <div class="form">
                    <div class="form-group">
                        <select name="type" id="tests" class="form-control" size="1">
                            <option value="">Все</option>
                            @for ($i=0; $i<$amount; $i++)
                                <option value="{{ $names[$i] }}">{{ $names[$i] }}</option>/td>
                            @endfor
                        </select>
                        <label for="select-type">Тесты</label>
                    </div>
                </div>
                <br>
                <br>
                <table class="table table-condensed">
                    <tr>
                        <td>Название теста</td>
                        <td>Результат</td>
                        <td>Оценка</td>
                        <td>Дата и время</td>
                    </tr>
                    <tbody id="target">
                        @for ($i=(count($results)-1); $i>=0; $i--)
                            <tr>
                                <td>{{ $results[$i]['test_name'] }}</td>
                                <td>{{ $results[$i]['result'] }}</td>
                                <td>{{ $results[$i]['mark_eu'] }}</td>
                                <td>{{ $results[$i]['result_date'] }}</td>
                            </tr>

                        @endfor
                    </tbody>
                </table>

            </div>
        </div>

    </div>
        {!! HTML::script('js/personalAccount.js') !!}

@stop