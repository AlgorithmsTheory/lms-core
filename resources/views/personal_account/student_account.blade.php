@extends('templates.base')
@section('head')
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <title>Личный кабинет</title>
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/full.css') !!}
    {!! HTML::style('css/student_account.css') !!}}
@stop

@section('background')
    full
@stop

@section('content')

    <div class="card style-default-light">
                    {{--<div class="card-body test-list">--}}
                    <h2 class="text-center">Личный кабинет</h2>
                        <a href="{{ route('test_results')}}" class="btn btn-warning col-md-offset-3 col-md-6 ">Перейти на страницу результатов системы тестирования</a>

                        <div class="col-md-12 col-sm-12 style-gray">
                            <h3 class="text-default-bright">Раздел 1</h3>
                        </div>
                        <div class="col-md-12 col-sm-12 card test-list">
                            <table class="table table-condensed table-bordered">
                                <tr>
                                    <td class="warning">Вид работы</td>
                                    <td class="info">Неделя 1</td>
                                    <td class="info">Неделя 2</td>
                                    <td class="info">Неделя 3</td>
                                    <td class="info">Неделя 4</td>
                                    <td class="info">Неделя 5</td>
                                    <td class="info">Неделя 6</td>
                                    <td class="info">Неделя 7</td>
                                </tr>
                                <tbody>
                                    <tr>
                                        <td class="warning">Посещение лекций</td>
                                        <td>
                                            <div class='checkbox checkbox-inline checkbox-styled'>
                                                <label>
                                                    @if( $lectures['col1'] == 1 )
                                                        <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                    @else
                                                        <i class="md md-remove"></i>
                                                    @endif
                                                <span></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class='checkbox checkbox-inline checkbox-styled'>
                                                <label>
                                                    @if( $lectures['col2'] == 1 )
                                                        <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                    @else
                                                        <i class="md md-remove"></i>
                                                    @endif
                                                    <span></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class='checkbox checkbox-inline checkbox-styled'>
                                                <label>
                                                    @if( $lectures['col3'] == 1 )
                                                        <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                    @else
                                                        <i class="md md-remove"></i>
                                                    @endif
                                                    <span></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class='checkbox checkbox-inline checkbox-styled'>
                                                <label>
                                                    @if( $lectures['col4'] == 1 )
                                                        <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                    @else
                                                        <i class="md md-remove"></i>
                                                    @endif
                                                    <span></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class='checkbox checkbox-inline checkbox-styled'>
                                                <label>
                                                    @if( $lectures['col5'] == 1 )
                                                        <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                    @else
                                                        <i class="md md-remove"></i>
                                                    @endif
                                                    <span></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class='checkbox checkbox-inline checkbox-styled'>
                                                <label>
                                                    @if( $lectures['col6'] == 1 )
                                                        <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                    @else
                                                        <i class="md md-remove"></i>
                                                    @endif
                                                    <span></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class='checkbox checkbox-inline checkbox-styled'>
                                                <label>
                                                    @if( $lectures['col7'] == 1 )
                                                        <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                    @else
                                                        <i class="md md-remove"></i>
                                                    @endif
                                                    <span></span>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="warning">Посещение семинаров</td>
                                        <td>
                                            <div class='checkbox checkbox-inline checkbox-styled'>
                                                <label>
                                                    @if( $seminars['col1'] == 1 )
                                                        <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                    @else
                                                        <i class="md md-remove"></i>
                                                    @endif
                                                    <span></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class='checkbox checkbox-inline checkbox-styled'>
                                                <label>
                                                    @if( $seminars['col2'] == 1 )
                                                        <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                    @else
                                                        <i class="md md-remove"></i>
                                                    @endif
                                                    <span></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class='checkbox checkbox-inline checkbox-styled'>
                                                <label>
                                                    @if( $seminars['col3'] == 1 )
                                                        <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                    @else
                                                        <i class="md md-remove"></i>
                                                    @endif
                                                    <span></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class='checkbox checkbox-inline checkbox-styled'>
                                                <label>
                                                    @if( $seminars['col4'] == 1 )
                                                        <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                    @else
                                                        <i class="md md-remove"></i>
                                                    @endif
                                                    <span></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class='checkbox checkbox-inline checkbox-styled'>
                                                <label>
                                                    @if( $seminars['col5'] == 1 )
                                                        <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                    @else
                                                        <i class="md md-remove"></i>
                                                    @endif
                                                    <span></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class='checkbox checkbox-inline checkbox-styled'>
                                                <label>
                                                    @if( $seminars['col6'] == 1 )
                                                        <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                    @else
                                                        <i class="md md-remove"></i>
                                                    @endif
                                                    <span></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class='checkbox checkbox-inline checkbox-styled'>
                                                <label>
                                                    @if( $seminars['col7'] == 1 )
                                                        <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                    @else
                                                        <i class="md md-remove"></i>
                                                    @endif
                                                    <span></span>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="warning">Работа на семинарах</td>
                                        <td>
                                            {{ $classwork['col1'] }}
                                        </td>
                                        <td>
                                            {{ $classwork['col2'] }}
                                        </td>
                                        <td>
                                            {{ $classwork['col3'] }}
                                        </td>
                                        <td>
                                            {{ $classwork['col4'] }}
                                        </td>
                                        <td>
                                            {{ $classwork['col5'] }}
                                        </td>
                                        <td>
                                            {{ $classwork['col6'] }}
                                        </td>
                                        <td>
                                            {{ $classwork['col7'] }}
                                        </td>
                                    </tr>
                                <tr>
                                    <td class="info">
                                        <div class="dropdown">
                                            <button class="dropbtn">КР №1 (Тьюринг)</button>
                                            <div class="dropdown-content">
                                                <a>От 4.2 до 7 баллов</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="info">
                                        <div class="dropdown">
                                            <button class="dropbtn">КР №2 (Марков)</button>
                                            <div class="dropdown-content">
                                                <a>От 4.2 до 7 баллов</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="info">
                                        <div class="dropdown">
                                            <button class="dropbtn">Тест №1</button>
                                            <div class="dropdown-content">
                                                <a>От 1.8 до 3 баллов</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="info">
                                        <div class="dropdown">
                                            <button class="dropbtn">Тест №1 (письменная часть)</button>
                                            <div class="dropdown-content">
                                                <a>От 1.2 до 2 баллов</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="info">
                                        <div class="dropdown">
                                            <button class="dropbtn">Итог за 1 раздел</button>
                                            <div class="dropdown-content">
                                                <a>От 13 до 22 баллов</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                    <tr>
                                        <td
                                                @if (($progress['control1'] == 0) and ($plan['control1'] == 1))
                                                class="danger"
                                                @endif
                                                @if ($progress['control1'] == 1)
                                                class="success"
                                                @endif
                                                >
                                            {{ $controls['control1'] }}
                                        </td>
                                        <td
                                                @if (($progress['control2'] == 0) and ($plan['test1'] == 1))
                                                class="danger"
                                                @endif
                                                @if ($progress['control2'] == 1)
                                                class="success"
                                                @endif
                                                >
                                            {{ $controls['control2'] }}
                                        </td>
                                        <td
                                          @if (($progress['test1'] == 0) and ($plan['test1'] == 1))
                                              class="danger"
                                          @endif
                                          @if ($progress['test1'] == 1)
                                              class="success"
                                          @endif
                                        >
                                            @if ( isset($test1))
                                                <div class="dropdown">
                                                    <button class="dropbtn">{{ $controls['test1'] }}</button>
                                                    <div class="dropdown-content">
                                                        <a href="{{ route('test_results')}}">Название: {{ $test1['test_name'] }}</a>
                                                        <a>Дата: {{ $test1['result_date'] }}</a>
                                                        <a>Балл: {{ $test1['result'] }} из </a>
{{--                                                        <a>Оценка: {{ $test1['mark_eu'] }}</a>--}}
                                                    </div>
                                                </div>
                                            @else
                                                <div class="dropdown">
                                                    <button class="dropbtn">{{ $controls['test1'] }}</button>
                                                    <div class="dropdown-content">
                                                        <a>Результатов нет</a>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td
                                                @if (($progress['test1quiz'] == 0) and ($plan['test1quiz'] == 1))
                                                class="danger"
                                                @endif
                                                @if ($progress['test1quiz'] == 1)
                                                class="success"
                                                @endif
                                                >
                                            {{ $controls['test1quiz'] }}
                                        </td>
                                        <td
                                                @if (($progress['section1'] == 0) and ($plan['section1'] == 1))
                                                class="danger"
                                                @endif
                                                @if ($progress['section1'] == 1)
                                                class="success"
                                                @endif
                                                >
                                            {{ $results['section1'] }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                        <div class="col-md-12 col-sm-12 style-gray">
                            <h3 class="text-default-bright">Раздел 2</h3>
                        </div>
                        <div class="col-md-12 col-sm-12 card test-list">
                            <table class="table table-condensed table-bordered">
                                <tr>
                                    <td class="warning">Вид работы</td>
                                    <td class="info">Неделя 8</td>
                                    <td class="info">Неделя 9</td>
                                    <td class="info">Неделя 10</td>
                                    <td class="info">Неделя 11</td>
                                </tr>
                                <tbody>
                                <tr>
                                    <td class="warning">Посещение лекций</td>
                                    <td>
                                        <div class='checkbox checkbox-inline checkbox-styled'>
                                            <label>
                                                @if( $lectures['col8'] == 1 )
                                                    <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                @else
                                                    <i class="md md-remove"></i>
                                                @endif
                                                <span></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class='checkbox checkbox-inline checkbox-styled'>
                                            <label>
                                                @if( $lectures['col9'] == 1 )
                                                    <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                @else
                                                    <i class="md md-remove"></i>
                                                @endif
                                                <span></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class='checkbox checkbox-inline checkbox-styled'>
                                            <label>
                                                @if( $lectures['col10'] == 1 )
                                                    <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                @else
                                                    <i class="md md-remove"></i>
                                                @endif
                                                <span></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class='checkbox checkbox-inline checkbox-styled'>
                                            <label>
                                                @if( $lectures['col11'] == 1 )
                                                    <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                @else
                                                    <i class="md md-remove"></i>
                                                @endif
                                                <span></span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="warning">Посещение семинаров</td>
                                    <td>
                                        <div class='checkbox checkbox-inline checkbox-styled'>
                                            <label>
                                                @if( $seminars['col8'] == 1 )
                                                    <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                @else
                                                    <i class="md md-remove"></i>
                                                @endif
                                                <span></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class='checkbox checkbox-inline checkbox-styled'>
                                            <label>
                                                @if( $seminars['col9'] == 1 )
                                                    <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                @else
                                                    <i class="md md-remove"></i>
                                                @endif
                                                <span></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class='checkbox checkbox-inline checkbox-styled'>
                                            <label>
                                                @if( $seminars['col10'] == 1 )
                                                    <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                @else
                                                    <i class="md md-remove"></i>
                                                @endif
                                                <span></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class='checkbox checkbox-inline checkbox-styled'>
                                            <label>
                                                @if( $seminars['col11'] == 1 )
                                                    <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                @else
                                                    <i class="md md-remove"></i>
                                                @endif
                                                <span></span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="warning">Работа на семинарах</td>
                                    <td>
                                        {{ $classwork['col8'] }}
                                    </td>
                                    <td>
                                        {{ $classwork['col9'] }}
                                    </td>
                                    <td>
                                        {{ $classwork['col10'] }}
                                    </td>
                                    <td>
                                        {{ $classwork['col11'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="info">
                                        <div class="dropdown">
                                            <button class="dropbtn">Тест №2</button>
                                            <div class="dropdown-content">
                                                <a>От 3 до 5 баллов</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="info">
                                        <div class="dropdown">
                                            <button class="dropbtn">Тест №2 (письменная часть)</button>
                                            <div class="dropdown-content">
                                                <a>От 2.4 до 4 баллов</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="info">
                                        <div class="dropdown">
                                            <button class="dropbtn">Итог за 2 раздел</button>
                                            <div class="dropdown-content">
                                                <a>От 7 до 12 баллов</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                            @if (($progress['test2'] == 0) and ($plan['test2'] == 1))
                                            class="danger"
                                            @endif
                                            @if ($progress['test2'] == 1)
                                            class="success"
                                            @endif
                                    >
                                        @if ( isset($test2))
                                            <div class="dropdown">
                                                <button class="dropbtn">{{ $controls['test2'] }}</button>
                                                <div class="dropdown-content">
                                                    <a href="{{ route('test_results')}}">Название: {{ $test2['test_name'] }}</a>
                                                    <a>Дата: {{ $test2['result_date'] }}</a>
                                                    <a>Балл: {{ $test2['result'] }}</a>
                                                    <a>Оценка: {{ $test2['mark_eu'] }}</a>
                                                </div>
                                            </div>
                                        @else
                                            <div class="dropdown">
                                                <button class="dropbtn">{{ $controls['test2'] }}</button>
                                                <div class="dropdown-content">
                                                    <a>Результатов нет</a>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td
                                            @if (($progress['test2quiz'] == 0) and ($plan['test2quiz'] == 1))
                                            class="danger"
                                            @endif
                                            @if ($progress['test2quiz'] == 1)
                                            class="success"
                                            @endif
                                            >
                                        {{ $controls['test2quiz'] }}
                                    </td>
                                    <td
                                            @if (($progress['section2'] == 0) and ($plan['section2'] == 1))
                                            class="danger"
                                            @endif
                                            @if ($progress['section2'] == 1)
                                            class="success"
                                            @endif
                                            >
                                        {{ $results['section2'] }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>


                        <div class="col-md-12 col-sm-12 style-gray">
                            <h3 class="text-default-bright">Раздел 3</h3>
                        </div>
                        <div class="col-md-12 col-sm-12 card test-list">
                            <table class="table table-condensed table-bordered">
                                <tr>
                                    <td class="warning">Вид работы</td>
                                    <td class="info">Неделя 12</td>
                                    <td class="info">Неделя 13</td>
                                    <td class="info">Неделя 14</td>
                                    <td class="info">Неделя 15</td>
                                </tr>
                                <tbody>
                                <tr>
                                    <td class="warning">Посещение лекций</td>
                                    <td>
                                        <div class='checkbox checkbox-inline checkbox-styled'>
                                            <label>
                                                @if( $lectures['col12'] == 1 )
                                                    <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                @else
                                                    <i class="md md-remove"></i>
                                                @endif
                                                <span></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class='checkbox checkbox-inline checkbox-styled'>
                                            <label>
                                                @if( $lectures['col13'] == 1 )
                                                    <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                @else
                                                    <i class="md md-remove"></i>
                                                @endif
                                                <span></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class='checkbox checkbox-inline checkbox-styled'>
                                            <label>
                                                @if( $lectures['col14'] == 1 )
                                                    <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                @else
                                                    <i class="md md-remove"></i>
                                                @endif
                                                <span></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class='checkbox checkbox-inline checkbox-styled'>
                                            <label>
                                                @if( $lectures['col15'] == 1 )
                                                    <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                @else
                                                    <i class="md md-remove"></i>
                                                @endif
                                                <span></span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="warning">Посещение семинаров</td>
                                    <td>
                                        <div class='checkbox checkbox-inline checkbox-styled'>
                                            <label>
                                                @if( $seminars['col12'] == 1 )
                                                    <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                @else
                                                    <i class="md md-remove"></i>
                                                @endif
                                                <span></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class='checkbox checkbox-inline checkbox-styled'>
                                            <label>
                                                @if( $seminars['col13'] == 1 )
                                                    <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                @else
                                                    <i class="md md-remove"></i>
                                                @endif
                                                <span></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class='checkbox checkbox-inline checkbox-styled'>
                                            <label>
                                                @if( $seminars['col14'] == 1 )
                                                    <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                @else
                                                    <i class="md md-remove"></i>
                                                @endif
                                                <span></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class='checkbox checkbox-inline checkbox-styled'>
                                            <label>
                                                @if( $seminars['col15'] == 1 )
                                                    <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                @else
                                                    <i class="md md-remove"></i>
                                                @endif
                                                <span></span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="warning">Работа на семинарах</td>
                                    <td>
                                        {{ $classwork['col12'] }}
                                    </td>
                                    <td>
                                        {{ $classwork['col13'] }}
                                    </td>
                                    <td>
                                        {{ $classwork['col14'] }}
                                    </td>
                                    <td>
                                        {{ $classwork['col15'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="info">
                                        <div class="dropdown">
                                            <button class="dropbtn">КР №3 (рекурсии)</button>
                                            <div class="dropdown-content">
                                                <a>От 2.4 до 4 баллов</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="info">
                                        <div class="dropdown">
                                            <button class="dropbtn">КР №3 (письменная часть)</button>
                                            <div class="dropdown-content">
                                                <a>От 1.8 до 3 баллов</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="info">
                                        <div class="dropdown">
                                            <button class="dropbtn">Тест №3</button>
                                            <div class="dropdown-content">
                                                <a>От 1.8 до 3 баллов</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="info">
                                        <div class="dropdown">
                                            <button class="dropbtn">Тест №3 (письменная часть)</button>
                                            <div class="dropdown-content">
                                                <a>От 1.8 до 3 баллов</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="info">
                                        <div class="dropdown">
                                            <button class="dropbtn">Итог за 3 раздел</button>
                                            <div class="dropdown-content">
                                                <a>От 10 до 16 баллов</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                            @if (($progress['control3'] == 0) and ($plan['control3'] == 1))
                                            class="danger"
                                            @endif
                                            @if ($progress['control3'] == 1)
                                            class="success"
                                            @endif
                                            >
                                        {{ $controls['control3'] }}
                                    </td>
                                    <td
                                            @if (($progress['control3quiz'] == 0) and ($plan['control3quiz'] == 1))
                                            class="danger"
                                            @endif
                                            @if ($progress['control3quiz'] == 1)
                                            class="success"
                                            @endif
                                            >
                                        {{ $controls['control3quiz'] }}
                                    </td>
                                    <td
                                            @if (($progress['test3'] == 0) and ($plan['test3'] == 1))
                                            class="danger"
                                            @endif
                                            @if ($progress['test3'] == 1)
                                            class="success"
                                            @endif
                                    >
                                        @if ( isset($test3))
                                            <div class="dropdown">
                                                <button class="dropbtn">{{ $controls['test3'] }}</button>
                                                <div class="dropdown-content">
                                                    <a href="{{ route('test_results')}}">Название: {{ $test3['test_name'] }}</a>
                                                    <a>Дата: {{ $test3['result_date'] }}</a>
                                                    <a>Балл: {{ $test3['result'] }}</a>
                                                    <a>Оценка: {{ $test3['mark_eu'] }}</a>
                                                </div>
                                            </div>
                                        @else
                                            <div class="dropdown">
                                                <button class="dropbtn">{{ $controls['test3'] }}</button>
                                                <div class="dropdown-content">
                                                    <a>Результатов нет</a>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td
                                            @if (($progress['test3quiz'] == 0) and ($plan['test3quiz'] == 1))
                                            class="danger"
                                            @endif
                                            @if ($progress['test3quiz'] == 1)
                                            class="success"
                                            @endif
                                            >
                                        {{ $controls['test3quiz'] }}
                                    </td>
                                    <td
                                            @if (($progress['section3'] == 0) and ($plan['section3'] == 1))
                                            class="danger"
                                            @endif
                                            @if ($progress['section3'] == 1)
                                            class="success"
                                            @endif
                                            >
                                        {{ $results['section3'] }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>


                        <div class="col-md-12 col-sm-12 style-gray">
                            <h3 class="text-default-bright">Раздел 4</h3>
                        </div>
                        <div class="col-md-12 col-sm-12 card test-list">
                            <table class="table table-condensed table-bordered">
                                <tr>
                                    <td class="info">Лекция 16</td>
                                    <td class="info">Семинар 16</td>
                                    <td class="info">Работа на семинаре 16</td>
                                    <td class="info">
                                        <div class="dropdown">
                                            <button class="dropbtn">Опрос</button>
                                            <div class="dropdown-content">
                                                <a>От 4.8 до 8 баллов</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="info">
                                        <div class="dropdown">
                                            <button class="dropbtn">Итог за 3 раздел</button>
                                            <div class="dropdown-content">
                                                <a>От 6 до 10 баллов</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tbody>
                                <tr>
                                    <td>
                                        <div class='checkbox checkbox-inline checkbox-styled'>
                                            <label>
                                                @if( $lectures['col16'] == 1 )
                                                    <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                @else
                                                    <i class="md md-remove"></i>
                                                @endif
                                                <span></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class='checkbox checkbox-inline checkbox-styled'>
                                            <label>
                                                @if( $seminars['col16'] == 1 )
                                                    <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                                @else
                                                    <i class="md md-remove"></i>
                                                @endif
                                                <span></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $classwork['col6'] }}
                                    </td>
                                    <td
                                            @if (($progress['lastquiz'] == 0) and ($plan['lastquiz'] == 1))
                                            class="danger"
                                            @endif
                                            @if ($progress['lastquiz'] == 1)
                                            class="success"
                                            @endif
                                            >
                                        {{ $controls['lastquiz'] }}
                                    </td>
                                    <td
                                            @if (($progress['section4'] == 0) and ($plan['section4'] == 1))
                                            class="danger"
                                            @endif
                                            @if ($progress['section4'] == 1)
                                            class="success"
                                            @endif
                                            >
                                        {{ $results['section4'] }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>


                    <div class="col-md-12 col-sm-12 style-gray">
                        <h3 class="text-default-bright">Итоги</h3>
                    </div>
                    <div class="col-md-12 col-sm-12 card test-list">
                    <div class="col-lg-offset-1 col-md-10 col-sm-10 ">
                        <br>
                        <div class="card">
                        <div class="col-md-1 col-sm-1">
                            Раздел 1
                        </div>
                        <div class="col-md-11 col-sm-11">
                            <div id="myProgress">
                                <div id="myBar1">
                                    <div id="label">{{ round($results['section1']/22*100, 2) }}%</div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="card">
                        <div class="col-md-1 col-sm-1">
                            Раздел 2
                        </div>
                        <div class="col-md-11 col-sm-11 ">
                            <div id="myProgress">
                                <div id="myBar2">
                                    <div id="label">{{ round($results['section2']/12*100, 2) }}%</div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="card">
                        <div class="col-md-1 col-sm-1">
                            Раздел 3
                        </div>
                        <div class="col-md-11 col-sm-11 ">
                            <div id="myProgress">
                                <div id="myBar3">
                                    <div id="label">{{ round($results['section3']/16*100, 2) }}%</div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="card">
                        <div class="col-md-1 col-sm-1">
                            Раздел 4
                        </div>
                        <div class="col-md-11 col-sm-11 ">
                            <div id="myProgress">
                                <div id="myBar4">
                                    <div id="label">{{ round($results['section4']/10*100, 2) }}%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>

    </div>


                    <style>
                        #myBar1 {
                            position: absolute;
                            width: {{ $results['section1']/22*100 }}%;
                            height: 100%;
                            background-color: {{ $progress['section1'] >= 1 ? '#4CAF50' : '#ee9999' }};
                        }
                        #myBar2 {
                            position: absolute;
                            width: {{ $results['section2']/12*100 }}%;
                            height: 100%;
                            background-color: {{ $progress['section2'] >= 1 ? '#4CAF50' : '#ee9999' }};
                        }
                        #myBar3 {
                            position: absolute;
                            width: {{ $results['section3']/16*100 }}%;
                            height: 100%;
                            background-color: {{ $progress['section3'] >= 1 ? '#4CAF50' : '#ee9999' }};
                        }
                        #myBar4 {
                            position: absolute;
                            width: {{ $results['section4']/10*100 }}%;
                            height: 100%;
                            background-color: {{ $progress['section4'] >= 1 ? '#4CAF50' : '#ee9999' }};
                        }
                    </style>

@stop