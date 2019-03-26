@extends('templates.base')
@section('head')
    <title>Учебные планы</title>

    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="your,keywords">
    <meta name="description" content="Short explanation about this website">
    <!-- END META -->

    <!-- BEGIN STYLESHEETS -->
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/font-awesome.min.css') !!}
    {!! HTML::style('css/material-design-iconic-font.min.css') !!}
    <!-- END STYLESHEETS -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    {!! HTML::script('js/libs/utils/html5shiv.js') !!}
    {!! HTML::script('js/libs/utils/respond.min.js') !!}
    <![endif]-->
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
                    @foreach ($coursePlans as $coursePlan)


                    <div class="card card-bordered style-gray ">
                        <div class="card-head">
                            <header>{{"Учебный план: ".$coursePlan->course_plan_name}}</header>
                            <div class="tools">
                                <div class="btn-group ">
                                    <form action = "{{route('course_plan_delete')}}" method="post">
                                        {{method_field('DELETE')}}
                                        {{ csrf_field() }}
                                        <input type="hidden"  name="id_course_plan" value="{{$coursePlan->id_course_plan}}" />
                                        <div class="form-group">
                                            <button type="submit" class="btn  btn-icon-toggle delete_couse_plan" ><i class="md md-close"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body style-default-bright">
                            <p class="card-text">
                                {{$coursePlan->course_plan_desc}}
                            </p>
                            <ul>
                                <li>{{ 'Макс балл за раздел "Контрольные мероприятия в семестре":'.$coursePlan->max_controls }}</li>
                                <li>{{ 'Макс балл за раздел "Посещение семинаров":'.$coursePlan->max_seminars }}</li>
                                <li>{{ 'Макс балл за раздел "Работа на семинарах":'.$coursePlan->max_seminars_work }}</li>
                                <li>{{ 'Макс балл за раздел "Посещение лекций":'.$coursePlan->max_lecrures }}</li>
                                <li>{{ 'Макс балл за раздел "Зачет (экзамен)":'.$coursePlan->max_exam }}</li>
                            </ul>
                            {!! HTML::link('course_plan/'.$coursePlan->id_course_plan,'Подробнее',
                            array('class' => 'ink-reaction btn btn-primary','role' => 'button')) !!}
                        </div>
                    </div>

                    @endforeach


                </article>
            </div>
        </article>
    </div>

@stop

@section('js-down')
    <!-- BEGIN JAVASCRIPT -->
    {!! HTML::script('js/libs/spin.js/spin.min.js') !!}
    {!! HTML::script('js/libs/autosize/jquery.autosize.min.js') !!}
    {!! HTML::script('js/libs/nanoscroller/jquery.nanoscroller.min.js') !!}
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

