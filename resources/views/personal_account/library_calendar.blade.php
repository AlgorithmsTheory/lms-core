@extends('templates.base')
@section('head')
    <title>Календарь лекций</title>
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
@stop

@section('content')
<!-- BEGIN HEADER-->
<div id="base">

    <section>
        <div class="section-header">
            <ol class="breadcrumb">
                <li class="active">Календарь лекций</li>
            </ol>
        </div>
    </section>

            <div class="section-body contain-lg">

                <div class="row">

                    <div class="col-lg-offset-1 col-md-8">
                    </div><!--end .col -->


                    <div class="col-lg-3 col-md-4">

                    </div><!--end .col -->

                    <div class="card">
                        <div class="card-body">
                            <center>
                                <?php
                                if ($success){
                                    echo '<h3 >Даты лекций заданы</h3>';
                                    echo '<br>';
                                }
                                ?>
                                <form class="form" action="{{URL::route('library_date_create')}}" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <div class="form-group control-width-normal">
                                        <div class="input-group date" id="demo-date">
                                            <div class="input-group-content">

                                                <input type="text" id="autocomplete1" required class="form-control" name="data_picker" data-source="/laravel/resources/html/forms/data/countries.json.html" placeholder="Выберите дату лекции">


                                            </div>
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div><!--end .form-group -->

                       <!--end .card-body -->
                        <center><p><input type="submit" class="btn ink-reaction btn-primary" id="sendRequest"></p></center>


                        </form>

                        </div><!--end .card -->
                    </div><!--end .col -->

                </div><!--end .row -->
            </div><!--end .section-body -->


    <!--end #content-->


</div><!--end .offcanvas-->

    </div><!--end #base-->
<!-- END BASE -->
@stop
@section('js-down')

@stop
