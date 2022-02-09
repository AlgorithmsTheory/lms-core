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


        @foreach($course_plan->section_plans as $section_plan)
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
                        @foreach($statement_result['control_work_groupBy_sections'][$section_plan->section_num] as $control_work_pass)
                        <td class="info">
                            <div class="dropdown">
                                <button class="dropbtn">{{$control_work_pass->control_work_plan_name}}</button>
                                <div class="dropdown-content">
                                    <a>{{'Макс: ' . $control_work_pass->max_points}}</a>
                                </div>
                            </div>
                        </td>
                        @endforeach
                        <td class="info">
                            ПЛ
                        </td>
                        <td class="info">
                            ПС
                        </td>
                        <td class="info">
                            РС
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
                        @foreach($statement_result['control_work_groupBy_sections'][$section_plan->section_num] as $control_work_pass)
                        <td
                                @if (($control_work_pass->points < $control_work_pass->max_points * 0.6))
                                class="danger"
                                @else
                                class="success"
                                @endif
                        >
                            {{ round($control_work_pass->points, 1) }}
                        </td>
                        @endforeach
                        {{-- ПЛ --}}
                        <td>{{$statement_result['ball_lection_passes'][$loop->index]}}</td>
                        {{-- ПС --}}
                        <td>{{$statement_result['ballsBySectionsPass'][$loop->index]}}</td>
                        {{-- РС --}}
                        <td>{{$statement_result['ballsBySectionsWorks'][$loop->index]}}</td>
                        {{--Итог за раздел--}}
                        <td data-result-section_num="{{$section_plan->section_num}}"
                            class="{{$statement_result['sec_ok'][$loop->index] == 0 ? 'danger' : 'success'}}"
                            data-section-max_points="{{$section_plan->max_points}}">
                            {{round($statement_result['sec_sum'][$loop->index], 0)}}
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
                        <td class="{{$statement_result['all_ok'] == 0 ? 'danger' : 'success'}}">
                            {{round($statement_result['fullsum'], 0)}}
                        </td>
                        <td class="{{$statement_result['exam_result'] ? 'success' : 'danger'}}">
                            {{round($statement_result['sum_result_section_exam_work'], 0)}}
                        </td>
                        <td class="{{$statement_result['course_result'] ? 'success' : 'danger'}}">
                            {{round($statement_result['absolutefullsum'], 0)}}
                        </td>
                        <td class="{{$statement_result['course_result'] ? 'success' : 'danger'}}">
                            {{$statement_result['markBologna']}}
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>

@stop
