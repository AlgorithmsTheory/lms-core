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
                    <h3 class="text-center">{{ Auth::user()['first_name'] }} {{ Auth::user()['last_name'] }} <b>{{ Auth::user()['email'] }}</b></h3>
                        <a href="{{ route('test_results')}}" class="btn btn-warning col-md-offset-3 col-md-6 ">Перейти на страницу результатов системы тестирования</a>
        <a href="{{ route('student_сabinet')}}" class="btn btn-warning col-md-offset-3 col-md-6 " style="margin-top: 0.5%">Перейти на страницу "Заказы книг" </a>


        @foreach($course_plan->section_plans as $ind => $section_plan)
            <div class="col-md-12 col-sm-12 style-gray">
                <h3 class="text-default-bright">Раздел {{$section_plan->section_num}}</h3>
            </div>
            <div class="col-md-12 col-sm-12 card test-list">
                <table class="table table-condensed table-bordered">
                    <tbody>
                    <tr>
                        <td class="warning">Посещение лекций</td>
                        @foreach($statement_lecture['lecture_passes'][$section_plan->section_num] as $lecture_pass)
                        <td>
                            №{{$lecture_pass->lecture_plan_num}}
                            <div class='checkbox checkbox-inline checkbox-styled'>
                                <label>
                                    @if( $lecture_pass->presence == 1 )
                                        <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                    @else
                                        <i class="md md-remove"></i>
                                    @endif
                                    <span></span>
                                </label>
                            </div>
                        </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="warning">Посещение семинаров</td>
                        @foreach($statement_seminar['seminar_passes_sections'][$section_plan->section_num] as $seminar_pass)
                        <td>
                            №{{$seminar_pass->seminar_plan_num}}
                            <div class='checkbox checkbox-inline checkbox-styled'>
                                <label>
                                    @if( $seminar_pass->presence == 1 )
                                        <input type='checkbox' checked onclick="this.checked=!this.checked;">
                                    @else
                                        <i class="md md-remove"></i>
                                    @endif
                                    <span></span>
                                </label>
                            </div>
                        </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="warning">Работа на семинарах</td>
                        @foreach($statement_seminar['seminar_passes_sections'][$section_plan->section_num] as $seminar_pass)
                        <td>
                            {{'№' . $seminar_pass->seminar_plan_num . ' кол.баллов: ' . $seminar_pass->work_points}}
                        </td>
                        @endforeach
                    </tr>
                    </tbody>
                </table>
                <table class="table table-condensed table-bordered">
                    <tbody>
                    <tr>
                        @foreach($section_plan->control_work_plans as $control_work_plan)
                        <td class="info">
                            <div class="dropdown">
                                <button class="dropbtn">{{$control_work_plan->control_work_plan_name}}</button>
                                <div class="dropdown-content">
                                    <a>{{'Макс: ' . $control_work_plan->max_points}}</a>
                                </div>
                            </div>
                        </td>
                        @endforeach
                        <td class="info">
                            <div class="dropdown">
                                <button class="dropbtn">ПЛ</button>
                                <div class="dropdown-content">
                                    <a>{{'Макс: ' . $section_plan->max_lecture_pass_point}}</a>
                                </div>
                            </div>
                        </td>
                        <td class="info">
                            <div class="dropdown">
                                <button class="dropbtn">ПС</button>
                                <div class="dropdown-content">
                                    <a>{{'Макс: ' . $section_plan->max_seminar_pass_point}}</a>
                                </div>
                            </div>
                        </td>
                        <td class="info">
                            <div class="dropdown">
                                <button class="dropbtn">РС</button>
                                <div class="dropdown-content">
                                    <a>{{'Макс: ' . $section_plan->max_seminar_work_point}}</a>
                                </div>
                            </div>
                        </td>
                        <td class="info">
                            <div class="dropdown">
                                <button class="dropbtn">{{'Итог за ' . $section_plan->section_num . ' раздел'}}</button>
                                <div class="dropdown-content">
                                    <a>{{'Макс: ' . $section_plan->getOverallMaxPoints()}}</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        @foreach($statement_result['sections'][$ind]['controls'] as $control_ind => $control)
                        <td
                                @if (($control['points'] < $section_plan->control_work_plans[$control_ind]->max_points * 0.6))
                                class="danger"
                                @else
                                class="success"
                                @endif
                        >
                            {{ $control['points'] }}
                        </td>
                        @endforeach
                        {{-- ПЛ --}}
                        <td>{{$statement_result['sections'][$ind]['lecture']}}</td>
                        {{-- ПС --}}
                        <td>{{$statement_result['sections'][$ind]['seminar']['presence_points']}}</td>
                        {{-- РС --}}
                        <td>{{$statement_result['sections'][$ind]['seminar']['work_points']}}</td>
                        {{--Итог за раздел--}}
                        <td data-result-section_num="{{$section_plan->section_num}}"
                            class="{{$statement_result['sections'][$ind]['total_ok'] ? 'success' : 'danger'}}"
                            data-section-max_points="{{$section_plan->max_points}}">
                            {{$statement_result['sections'][$ind]['total']}}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            @endforeach

        <div class="col-md-12 col-sm-12 style-gray">
            <h3 class="text-default-bright">Итоги</h3>
        </div>
        <div class="col-md-12 col-sm-12 card test-list">
            <table class="table table-condensed table-bordered">
                <tr>
                    <td class="info">
                        <div class="dropdown">
                            <button class="dropbtn">Итог за разделы</button>
                            <div class="dropdown-content">
                                <a>{{'Макс: ' . $course_plan->max_semester}}</a>
                            </div>
                        </div>
                    </td>
                    <td class="info">
                        <div class="dropdown">
                            <button class="dropbtn">Экзамен</button>
                            <div class="dropdown-content">
                                <a>{{'Макс: ' . $course_plan->max_exam}}</a>
                            </div>
                        </div>
                    </td>
                    <td class="info">
                        <div class="dropdown">
                            <button class="dropbtn">Суммарный итог</button>
                            <div class="dropdown-content">
                                <a>Макс: {{$course_plan->max_semester + $course_plan->max_exam}} баллов</a>
                            </div>
                        </div>
                    </td>
                    <td class="info">
                        <div class="dropdown">
                            <button class="dropbtn">Оценка</button>
                            <div class="dropdown-content">
                                <a>От E до A баллов</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <tbody>
                    <tr>
                        <td class="{{$statement_result['sections_total_ok'] ? 'success' : 'danger'}}">
                            {{$statement_result['sections_total']}}
                        </td>
                        <td class="{{$statement_result['exams_total_ok'] ? 'success' : 'danger'}}">
                            {{$statement_result['exams_total']}}
                        </td>
                        <td class="{{$statement_result['summary_total_ok'] ? 'success' : 'danger'}}">
                            {{$statement_result['summary_total']}}
                        </td>
                        <td class="{{$statement_result['summary_total_ok'] ? 'success' : 'danger'}}">
                            {{$statement_result['mark_bologna']}}
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
    <div class="section-screenshots">
        <h2>Скриншоты сданных контрольных</h2>
        @foreach($screenshots as $shot)
            <a href="{{ $shot }}" target="_blank">{{ basename($shot) }}</a>
        @endforeach
    </div>
@stop

@section('js-down')
@stop
