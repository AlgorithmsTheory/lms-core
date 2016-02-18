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
    {!! HTML::style('css/theme-default/bootstrap.css?1422792965') !!}
    {!! HTML::style('css/theme-default/materialadmin.css?1425466319') !!}
    {!! HTML::style('css/theme-default/font-awesome.min.css?1422529194') !!}
    {!! HTML::style('css/theme-default/material-design-iconic-font.min.css?1421434286') !!}
    {!! HTML::style('css/theme-default/libs/select2/select2.css?1424887856') !!}
    {!! HTML::style('css/theme-default/libs/multi-select/multi-select.css?1424887857') !!}
    {!! HTML::style('css/theme-default/libs/bootstrap-datepicker/datepicker3.css?1424887858') !!}
    {!! HTML::style('css/theme-default/libs/jquery-ui/jquery-ui-theme.css?1423393666') !!}
    {!! HTML::style('css/theme-default/libs/bootstrap-colorpicker/bootstrap-colorpicker.css?1424887860') !!}
    {!! HTML::style('css/theme-default/libs/bootstrap-tagsinput/bootstrap-tagsinput.css?1424887862') !!}
    {!! HTML::style('css/theme-default/libs/typeahead/typeahead.css?1424887863') !!}
    {!! HTML::style('css/theme-default/libs/dropzone/dropzone-theme.css?1424887864') !!}
            <!-- END STYLESHEETS -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    {!! HTML::script('js/libs/utils/html5shiv.js') !!}
    {!! HTML::script('js/libs/utils/respond.min.js') !!}
    <![endif]-->
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
<!-- BEGIN JAVASCRIPT -->
    {!! HTML::script('js/libs/jquery/jquery-1.11.2.min.js') !!}
    {!! HTML::script('js/libs/jquery/jquery-migrate-1.2.1.min.js') !!}
    {!! HTML::script('js/libs/jquery-ui/jquery-ui.min.js') !!}
    {!! HTML::script('js/libs/bootstrap/bootstrap.min.js') !!}
    {!! HTML::script('js/libs/spin.js/spin.min.js') !!}
    {!! HTML::script('js/libs/autosize/jquery.autosize.min.js') !!}
    {!! HTML::script('js/libs/select2/select2.min.js') !!}
    {!! HTML::script('js/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js') !!}
    {!! HTML::script('js/libs/multi-select/jquery.multi-select.js') !!}
    {!! HTML::script('js/libs/inputmask/jquery.inputmask.bundle.min.js') !!}
    {!! HTML::script('js/libs/moment/moment.min.js') !!}
    {!! HTML::script('js/libs/bootstrap-datepicker/bootstrap-datepicker.js') !!}
    {!! HTML::script('js/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js') !!}
    {!! HTML::script('js/libs/typeahead/typeahead.bundle.min.js') !!}
    {!! HTML::script('js/libs/dropzone/dropzone.min.js') !!}
    {!! HTML::script('js/libs/nanoscroller/jquery.nanoscroller.min.js') !!}
    {!! HTML::script('js/core/source/App.js') !!}
    {!! HTML::script('js/core/source/AppNavigation.js') !!}
    {!! HTML::script('js/core/source/AppOffcanvas.js') !!}
    {!! HTML::script('js/core/source/AppCard.js') !!}
    {!! HTML::script('js/core/source/AppForm.js') !!}
    {!! HTML::script('js/core/source/AppNavSearch.js') !!}
    {!! HTML::script('js/core/source/AppVendor.js') !!}
    {!! HTML::script('js/core/demo/Demo.js') !!}
    {!! HTML::script('js/core/demo/DemoFormComponents.js') !!}
<!-- END JAVASCRIPT -->
@stop
