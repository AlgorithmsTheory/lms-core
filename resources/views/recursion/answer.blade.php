@extends('templates.Rbase')
@section('head')
    <title>Контрольная работа по рекурсивным функциям</title>

    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="your,keywords">
    <meta name="description" content="Short explanation about this website">
    <!-- END META -->

    <!-- BEGIN STYLESHEETS -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
    {!! HTML::style('css/bootstrap.css?1422792965') !!}
    {!! HTML::style('css/materialadmin.css?1425466319') !!}
    {!! HTML::style('css/font-awesome.min.css?1422529194') !!}
    {!! HTML::style('css/material-design-iconic-font.min.css?1421434286') !!}
    {!! HTML::style('css/libs/jquery-ui/jquery-ui-theme.css?1423393666') !!}
    {!! HTML::style('css/libs/nestable/nestable.css?1423393667') !!}
            <!-- END STYLESHEETS -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/laravel/resources/assets/js/libs/utils/html5shiv.js?1403934957"></script>
    <script type="text/javascript" src="/laravel/resources/assets/js/libs/utils/respond.min.js?1403934956"></script>
    <![endif]-->
    @stop

    @section('content')

            <!-- BEGIN LIST SAMPLES -->
    <section>

        <div class="section-body contain-lg">

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="text-primary">Контрольная работа по теме "Задание примитивно-рекурсивных функций"</h1>
                </div><!--end .col -->
                    <h1>Ваш балл <?php //echo $mark ?></h1>

            </div>
            <!-- BEGIN NESTABLE LISTS -->
            </div>
    </section>


    <!--end #content-->
    @stop
            <!--end #base-->
    <!-- END BASE -->
@section('js-down')
    <script>
        //function disableFunction() {
        //  document.getElementById("onerun").disabled = 'true';
        }
    </script>

    <!-- BEGIN JAVASCRIPT -->

    {!! HTML::script('js/recursion/kontrScript.js')!!}
    {!! HTML::script('js/recursion/duperscript.js') !!}
    {!! HTML::script('js/recursion/button_onclick.js') !!}
    {!! HTML::script('js/libs/jquery/jquery-1.11.2.min.js') !!}
    {!! HTML::script('js/libs/jquery/jquery-migrate-1.2.1.min.js') !!}
    {!! HTML::script('js/libs/jquery-ui/jquery-ui.min.js') !!}
    {!! HTML::script('js/libs/bootstrap/bootstrap.min.js') !!}
    {!! HTML::script('js/libs/spin.js/spin.min.js') !!}
    {!! HTML::script('js/libs/jquery-validation/dist/jquery.validate.min.js') !!}
    {!! HTML::script('js/libs/jquery-validation/dist/additional-methods.min.js') !!}
    {!! HTML::script('js/libs/autosize/jquery.autosize.min.js') !!}
    {!! HTML::script('js/libs/nestable/jquery.nestable.js') !!}
    {!! HTML::script('js/libs/nanoscroller/jquery.nanoscroller.min.js') !!}
    {!! HTML::script('js/core/source/App.js') !!}
    {!! HTML::script('js/core/source/AppNavigation.js') !!}
    {!! HTML::script('js/core/source/AppOffcanvas.js') !!}
    {!! HTML::script('js/core/source/AppCard.js') !!}
    {!! HTML::script('js/core/source/AppForm.js') !!}
    {!! HTML::script('js/core/source/AppNavSearch.js') !!}
    {!! HTML::script('js/core/source/AppVendor.js') !!}
    {!! HTML::script('js/core/demo/Demo.js') !!}
    {!! HTML::script('js/core/demo/DemoUILists.js') !!}
            <!--  {!! HTML::script('js/libs/utils/send.js') !!}-->
    {!! HTML::script('js/core/demo/DemoUIMessages.js') !!}
    {!! HTML::script('js/libs/toastr/toastr.js') !!}
            <!-- END JAVASCRIPT -->
@stop


