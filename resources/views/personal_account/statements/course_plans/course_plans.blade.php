@extends('templates.base')
@section('head')
    <title>Учебные планы</title>

    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="your,keywords">
    <meta name="description" content="Short explanation about this website">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- END META -->

    <!-- BEGIN STYLESHEETS -->
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/font-awesome.min.css') !!}
    {!! HTML::style('css/material-design-iconic-font.min.css') !!}
    <!-- END STYLESHEETS -->
@stop
@section('content')
    <!-- BEGIN BLANK SECTION -->
    <div class ="row section-header">
        <div class="col-sm-9" >
        </div>
        <div class="col-sm-3" >
                {!! HTML::link('course_plans/create','Создать учебный план',array('class' => 'btn ink-reaction btn-primary','role' => 'button')) !!}
        </div>
    </div>

    <div class="card card-tiles style-default-light" style="margin-left:2%; margin-right:2%">
        <article class="style-default-bright">
            <div class="card-body">
                <article style="margin-left:5%; margin-right:5%">
                    @foreach ($course_plans as $course_plan)


                    <div class="card card-bordered style-gray course_plan" id="course_plan{{$course_plan['course_plan']->id_course_plan}}">
                        <div class="card-head">
                            <header>{{"Учебный план: ".$course_plan['course_plan']->course_plan_name}}</header>

                            @if($course_plan['exist_statements'] == false)
                            <div class="tools">
                                <div class="btn-group">
                                    <a class="btn btn-icon-toggle activate_edit_course_plan"><i class="glyphicon glyphicon-edit"></i></a>
                                </div>
                                <div class="btn-group ">
                                    <form action = "{{route('course_plan_delete')}}" method="post">
                                        {{method_field('DELETE')}}
                                        {{ csrf_field() }}
                                        <input type="hidden"  name="id_course_plan" value="{{$course_plan['course_plan']->id_course_plan}}" />
                                            <button type="submit" class="btn  btn-icon-toggle delete_couse_plan" ><i class="md md-close"></i></button>

                                    </form>
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
                                        {!! Form::text('course_plan_name',$course_plan['course_plan']->course_plan_name,['class' => 'form-control','placeholder' => 'Введите название учебного плана',
                                        'required' => 'required', $read_only ? 'readonly' : '' ]) !!}</h5>

                                    {!! Form::label('groups' , 'Назначение групп:') !!}
                                    {!! Form::text('groups',$course_plan['course_plan']->groups,['class' => 'form-control','placeholder' => 'Введите группы через пробел'
                                    , $read_only ? 'readonly' : '' ]) !!}

                                </div>
                                <div class="col-lg-6">
                                    {!! Form::label('course_plan_desc' , 'Описание учебного плана:') !!}
                                    {!! Form::textarea('course_plan_desc',$course_plan['course_plan']->course_plan_desc,['class' => 'form-control', 'rows'=>'5', 'cols' => '5'
                                    , 'placeholder' => 'Введите описание учебного плана',
                                    'required' => 'required', $read_only ? 'readonly' : '' ]) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    {!! Form::label('max_controls' , 'Макс балл за раздел "Контрольные мероприятия в семестре":') !!}
                                    {!! Form::text('max_controls',$course_plan['course_plan']->max_controls,['class' => 'form-control',
                                     $read_only ? 'readonly' : '' ]) !!}

                                    {!! Form::label('max_seminars' , 'Макс балл за раздел "Посещение семинаров":') !!}
                                    {!! Form::text('max_seminars',$course_plan['course_plan']->max_seminars,['class' => 'form-control',
                                     $read_only ? 'readonly' : '' ]) !!}

                                    {!! Form::label('max_seminars_work' , 'Макс балл за раздел "Работа на семинарах":') !!}
                                    {!! Form::text('max_seminars_work',$course_plan['course_plan']->max_seminars_work,['class' => 'form-control',
                                    $read_only ? 'readonly' : '' ]) !!}
                                </div>
                                <div class="col-lg-6">
                                    {!! Form::label('max_lecrures' , 'Макс балл за раздел "Посещение лекций":') !!}
                                    {!! Form::text('max_lecrures',$course_plan['course_plan']->max_lecrures,['class' => 'form-control',
                                     $read_only ? 'readonly' : '' ]) !!}

                                    {!! Form::label('max_exam' , 'Макс балл за раздел "Зачет (экзамен)":') !!}
                                    {!! Form::text('max_exam',$course_plan['course_plan']->max_exam,['class' => 'form-control',
                                     $read_only ? 'readonly' : '' ]) !!}
                                    <input type="hidden"  name="id_course_plan" value="{{$course_plan['course_plan']->id_course_plan}}" />
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

                            <div class="row">
                                <div class="col-lg-2">
                            {!! HTML::link('course_plan/'.$course_plan['course_plan']->id_course_plan,'Подробнее',
                            array('class' => 'ink-reaction btn btn-primary','role' => 'button')) !!}
                                </div>

                            <div class="col-lg-2">
                                <form action = "{{route('course_plan_copy')}}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden"  name="id_course_plan" value="{{$course_plan['course_plan']->id_course_plan}}" />
                                    <div class="form-group">
                                        <button type="submit" class=" btn ink-reaction btn-primary " >Скопировать</button>
                                    </div>
                                </form>
                            </div>

                            </div>
                        </div>
                    </div>

                    @endforeach


                </article>
            </div>
        </article>
    </div>

@stop

@section('js-down')
    {!! HTML::script('js/core/source/App.js') !!}
    {!! HTML::script('js/core/source/AppNavigation.js') !!}
    {!! HTML::script('js/core/source/AppOffcanvas.js') !!}
    {!! HTML::script('js/core/source/AppCard.js') !!}
    {!! HTML::script('js/core/source/AppForm.js') !!}
    {!! HTML::script('js/core/source/AppNavSearch.js') !!}
    {!! HTML::script('js/core/source/AppVendor.js') !!}
    {!! HTML::script('js/core/demo/Demo.js') !!}
    {!! HTML::script('js/statements/course_plans/course_plan.js') !!}
    <!-- END JAVASCRIPT -->
@stop

