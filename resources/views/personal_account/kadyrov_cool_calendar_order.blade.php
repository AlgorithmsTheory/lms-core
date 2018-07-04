@extends('templates.base')
@section('head')
    <title>Бронирование печатных изданий</title>
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

    <style>
        .fc-day-grid-event {
            pointer-events: none;
        }
    </style>
    <!-- END STYLESHEETS -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    {!! HTML::script('js/libs/utils/html5shiv.js') !!}
    {!! HTML::script('js/libs/utils/respond.min.js') !!}
    <![endif]-->


@stop

@section('content')

    <!-- BEGIN BLANK SECTION -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <section>
                    <div class="section-header">
                        <ol class="breadcrumb">
                            <!--Надо будет изменить HTML::linkRoute('library_index', 'Библиотека')-->
                            <li>{!! HTML::linkRoute('library_index', 'Библиотека') !!}</li>
                            <li>{!! HTML::linkRoute('Kadyrov_books', 'Бронирование печатных изданий') !!}</li>
                            <li class="active">Бронирование книги</li>
                        </ol>
                    </div><!--end .section-header -->
                    <div class="section-body">
                    </div><!--end .section-body -->
                </section>
            </div>
            <div class="col-lg-4">

                {!! HTML::link('Kadyrov/library/books/create','Личный кабинет без ссылки',array('class' => 'btn ink-reaction btn-primary','role' => 'button')) !!}


            </div>
        </div>
    </div>

    <div class="card card-tiles style-default-light">
        <article style="margin-left:10%; margin-right:13%; text-align: justify">


            {!! $calendar->calendar() !!}




        </article>

    </div>
    </div><!--end #content-->

    <div class="offcanvas">

    </div><!--end .offcanvas-->

    </div><!--end #base-->




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


    {{--Календарь--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
    <!-- Scripts -->

    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>

    <script src="{{ url('/js/calendar/jquery-ui.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>



    {!! $calendar->script() !!}

    <!-- END JAVASCRIPT -->
@stop
