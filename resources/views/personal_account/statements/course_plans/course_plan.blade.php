@extends('templates.base')
@section('head')
    <title>Учебный план</title>
    <!-- BEGIN META -->
    <meta charset="utf-8">

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- END META -->

    <!-- BEGIN STYLESHEETS -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/font-awesome.min.css') !!}
    {!! HTML::style('css/material-design-iconic-font.min.css') !!}
    <!-- END STYLESHEETS -->
@stop
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5">
                <section>
                    <div class="section-header">
                        <ol class="breadcrumb">
                            <li>{!! HTML::linkRoute('course_plans', 'Все учебные планы') !!}</li>
                            <li class="active">Учебный план</li>
                        </ol>
                    </div><!--end .section-header -->
                </section>
            </div>
            <div class="col-lg-7">

                <div class="row">
                    {{--Проверка, что существования ведомостей по данному учебному плану--}}
                    @if($exist_statements == false)
                    <div class="col-lg-3">
                    <button type="button" class="ink-reaction btn btn-primary check_points_course_plan"
                            data-id-course-plan="{{$course_plan->id_course_plan}}">
                        Проверить баллы</button>
                    </div>
                    <div class="col-lg-5 ">
                <form action = "{{route('course_plan_delete')}}" method="post">
                    {{method_field('DELETE')}}
                    {{ csrf_field() }}
                    <input type="hidden"  name="id_course_plan" value="{{$course_plan->id_course_plan}}" />
                    <div class="form-group">
                        <button type="submit" class=" btn ink-reaction btn-danger delete_couse_plan" >Удалить учебный план</button>
                    </div>
                </form>
                    </div>
                        @else
                        <div class="col-lg-8">
                        </div>
                    @endif
                    <div class="col-lg-3">
                        <form action = "{{route('course_plan_copy')}}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden"  name="id_course_plan" value="{{$course_plan->id_course_plan}}" />
                            <div class="form-group">
                                <button type="submit" class=" btn ink-reaction btn-primary " >Скопировать</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class ="container-fluid">
            {{--Вывод ошибок Проверки баллов учебного плана--}}
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
            <div class="card card-bordered style-gray course_plan" id="course_plan{{ $course_plan->id_course_plan }}">
                <div class="card-head">
                    <header>Учебный план: {{$course_plan->course_plan_name}}</header>
                    @if($exist_statements == false)
                    <div class="tools ">
                        <div class="btn-group">
                            <a class="btn btn-icon-toggle activate_edit_course_plan"><i class="glyphicon glyphicon-edit"></i></a>
                        </div>
                    </div>
                        @endif
                </div>
                <div class="card-body style-default-bright">
                     {!! Form::open(array('method' => 'PATCH' , ' style' => 'margin-bottom: 2%', 'class' => 'course_plan_form')) !!}
                        {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-6">
                        <h5 class="card-title">{!! Form::label('course_plan_name' , 'Учебный план:') !!}
                            {!! Form::text('course_plan_name',$course_plan->course_plan_name,['class' => 'form-control','placeholder' => 'Введите название учебного плана',
                            'required' => 'required', $read_only ? 'readonly' : '' ]) !!}</h5>

                            {!! Form::label('groups' , 'Назначение групп:') !!}
                            {!! Form::text('groups',$course_plan->groups,['class' => 'form-control','placeholder' => 'Введите группы через пробел'
                            , $read_only ? 'readonly' : '' ]) !!}

                        </div>
                        <div class="col-lg-6">
                    {!! Form::label('course_plan_desc' , 'Описание учебного плана:') !!}
                    {!! Form::textarea('course_plan_desc',$course_plan->course_plan_desc,['class' => 'form-control', 'rows'=>'5', 'cols' => '5'
                    , 'placeholder' => 'Введите описание учебного плана',
                    'required' => 'required', $read_only ? 'readonly' : '' ]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                        {!! Form::label('max_controls' , 'Макс балл за раздел "Контрольные мероприятия в семестре":') !!}
                            {!! Form::text('max_controls',$course_plan->max_controls,['class' => 'form-control',
                             $read_only ? 'readonly' : '' ]) !!}

                    {!! Form::label('max_seminars' , 'Макс балл за раздел "Посещение семинаров":') !!}
                    {!! Form::text('max_seminars',$course_plan->max_seminars,['class' => 'form-control',
                     $read_only ? 'readonly' : '' ]) !!}

                    {!! Form::label('max_seminars_work' , 'Макс балл за раздел "Работа на семинарах":') !!}
                    {!! Form::text('max_seminars_work',$course_plan->max_seminars_work,['class' => 'form-control',
                    $read_only ? 'readonly' : '' ]) !!}
                        </div>
                        <div class="col-lg-6">
                    {!! Form::label('max_lecrures' , 'Макс балл за раздел "Посещение лекций":') !!}
                    {!! Form::text('max_lecrures',$course_plan->max_lecrures,['class' => 'form-control',
                     $read_only ? 'readonly' : '' ]) !!}

                    {!! Form::label('max_exam' , 'Макс балл за раздел "Зачет (экзамен)":') !!}
                    {!! Form::text('max_exam',$course_plan->max_exam,['class' => 'form-control',
                     $read_only ? 'readonly' : '' ]) !!}
                    <input type="hidden"  name="id_course_plan" value="{{$course_plan->id_course_plan}}" />
                        </div>
                    </div>

                        {{--Вывод ошибок валидации--}}
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>

                    {{--Появляется при редактировании учебного плана--}}
                    <div class="update_button_course_plan" style="margin-bottom: 10px">

                    </div>
                    {!! Form::close() !!}


                    <div id="sections">

                        @foreach($course_plan->section_plans as $section_plan)

                        @include('personal_account.statements.course_plans.sections.view_or_update_section',array('section_plan' => $section_plan, 'read_only' => true,
                         'exist_statements' => $exist_statements , 'tests_control_work' => $tests_control_work))
                        @endforeach
                            {{--Здесь добавляются разделы учебного плана--}}

                            @foreach($course_plan->exam_plans as $section_plan)

                                @include('personal_account.statements.course_plans.sections.view_or_update_section',array('section_plan' => $section_plan, 'read_only' => true,
                                 'exist_statements' => $exist_statements , 'tests_control_work' => $tests_control_work))
                            @endforeach
                            {{--Здесь добавляются разделы учебного плана типа Экзамен(Зачёт)--}}

                    </div>
                    @if($exist_statements == false)
                    <button type="button" class="ink-reaction btn btn-success" id="addSection">Добавить раздел</button>
                        @endif
                </div>




        </div>

    </div>
@stop
@section('js-down')
    <!-- BEGIN JAVASCRIPT -->
    {!! HTML::script('js/core/source/App.js') !!}
    {!! HTML::script('js/core/source/AppNavigation.js') !!}
    {!! HTML::script('js/core/source/AppOffcanvas.js') !!}
    {!! HTML::script('js/core/source/AppCard.js') !!}
    {!! HTML::script('js/core/source/AppForm.js') !!}
    {!! HTML::script('js/core/source/AppNavSearch.js') !!}
    {!! HTML::script('js/core/source/AppVendor.js') !!}
    {!! HTML::script('js/core/demo/Demo.js') !!}
    {!! HTML::script('js/statements/course_plans/course_plan.js') !!}
    {!! HTML::script('js/statements/section_course_plans/sections.js') !!}
    {!! HTML::script('js/statements/section_course_plans/lectures_or_seminars_or_controlWork.js') !!}
    <!-- END JAVASCRIPT -->

@stop