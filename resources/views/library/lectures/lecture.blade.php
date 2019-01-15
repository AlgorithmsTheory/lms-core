@extends('templates.base')
@section('head')
    <title>Лекция {{$number}}</title>

    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="your,keywords">
    <meta name="description" content="Short explanation about this website">
    <!-- END META -->

    <!-- BEGIN STYLESHEETS -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
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
    <div class ="row">
        <div class="col-sm-9" >
            <section>
                <div class="section-header">
                    <ol class="breadcrumb">
                        <li>{!! HTML::linkRoute('home', 'Главная') !!}</li>
                        <li>{!! HTML::linkRoute('library_index', 'Библиотека') !!}</li>
                        <li class="active">Лекция {{$lecture->lecture_number}}. {{$lecture->lecture_name}}</li>
                    </ol>
                </div><!--end .section-header -->
                <div class="section-body">
                </div><!--end .section-body -->
            </section>
        </div>
        <div class="col-sm-3" >
            @if($role == 'Админ')
            {!! HTML::link('library/lecture/'.$lecture->id_lecture.'/edit','Редактировать лекцию',array('class' => 'btn ink-reaction btn-primary','role' => 'button')) !!}
                @endif
        </div>
    </div>
    <div class="card card-tiles style-default-light" style="margin-left:2%; margin-right:2%">
        <article class="style-default-bright">
            <div class="card-body">
                <article style="margin-left:10%; margin-right:10%; text-align: justify">

                    {!! $lecture->lecture_text !!}

                </article>
            </div>
        </article>
    </div>
@stop
@section('js-down')
    <!-- BEGIN JAVASCRIPT -->
    {!! HTML::script('js/libs/jquery/jquery-1.11.2.min.js') !!}
    {!! HTML::script('js/libs/jquery/jquery-migrate-1.2.1.min.js') !!}
    {!! HTML::script('js/libs/bootstrap/bootstrap.min.js') !!}
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
    <!-- END JAVASCRIPT -->

@stop
