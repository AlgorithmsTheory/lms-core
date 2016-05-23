@extends('templates.Rbase')
@section('head')
    <title>Эмулятор рекурсивных функций</title>

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
     <![endif]-->
    @stop

    @section('content')

            <!-- BEGIN LIST SAMPLES -->
    <section>
        <div class="section-header">
            <ol class="breadcrumb">
                <li class="active">Эмуляторы</li>
            </ol>
        </div>
        <div class="section-body contain-lg">

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="text-primary">Эмулятор проверки правильности задания рекурсивных функций</h1>
                </div><!--end .col -->
                <div class="col-lg-8">
                    <article class="margin-bottom-xxl">
                        <p class="lead">
                            Данный эмулятор предназначен для получения навыков вычисления рекурсивных функций в базисе Клини.
                        </p>
                    </article>
                </div><!--end .col -->

            </div>
            <!-- BEGIN NESTABLE LISTS -->
            <div class="col-lg-12">
                <div class="card style-default-bright">
                    <div class="card-head">
                        <div class="col-md-6">
                            </br>
                            <div class="card card-bordered style-primary">

                                <div class="card-body">
                                    <div class="card">
                                        <div class="card-body no-padding">
                                            <div class="card-body height-6 scroll style-default-bright" style="height: 300 px;">

                                                <form class="form" role="form">
                                                    <div class="form-group floating-label">
                                                        <input style="resize: none" name="func" id="textarea2" class="form-control" rows="3" placeholder=""></input>
                                                        <label for="textarea2" style="top:-15px">Условие задачи: </label>
                                                    </div><br>
                                                    <div class="form-group floating-label">
                                                        <input style="resize: none" id="text" onchange="superScript(this,this); puperScript(this);" name="rec_func"  class="form-control" rows="3" placeholder="" ></input>
                                                        <label for="textarea2" style="top:-15px" >Ответ:</label>
                                                    </div>
                                                </form>
                                                <!--вставить новую строку -->
                                            </div>
                                        </div>
                                    </div><!--end .card -->
                                </div><!--end .card-body -->
                            </div><!--end .card -->



                        </div>
                        <div class="col-lg-2" style="left:500px">
                            <a class="btn btn-raised ink-reaction btn-primary" href="#offcanvas-demo-right" data-toggle="offcanvas">
                                <i class="md md-help"></i>
                            </a>
                        </div>
                        <div class="col-md-6">

                               <center>
                                            <div class="btn-group">
                                                <label>Спецсимволы:</label><br>
                                                <button type="button" class="btn ink-reaction btn-default-bright" id="R">R<sub>0</sub></button>
                                                <button type="button" class="btn ink-reaction btn-default-bright" id="sigma">&Sigma;</button>
                                                <button type="button" class="btn ink-reaction btn-default-bright" id="P">П</button>
                                                <button type="button" class="btn ink-reaction btn-default-bright" id="constant">C<sub>0</sub><sup>0</sup></button>
                                                <button type="button" class="btn ink-reaction btn-default-bright" id="S">S<sub>0</sub><sup>0</sup></button>
                                                <button type="button" class="btn ink-reaction btn-default-bright" id="U">U<sub>0</sub><sup>0</sup></button>
                                            </div>

                                            <div class="card-body">
                                            <form class="form" role="form">
                                                    <button type="button" class="btn ink-reaction btn-primary" onclick="run_test();" >Запуск <i class="md md-fast-forward"></i></button>
                                            </form> </div>
                                    <div class="form-group floating-label">
                                        <input type="text" class="form-control" id="disabled6" disabled>
                                        <input type="text" class="form-control" id="disabled5" disabled>
                                        <input type="text" class="form-control" id="disabled4" disabled>
                                        <label for="disabled6" style="top:-15px">Результат: </label>
                                    </div>
                                         </center>
                                <!--end .card-body -->







                        </div>
                    </div>
                </div>
            </div>

            <div class="offcanvas">


                <div id="offcanvas-demo-right" class="offcanvas-pane width-10" style="">
                    <div class="offcanvas-head">
                        <header>Как работать с эмулятором</header>
                        <div class="offcanvas-tools">
                            <a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
                                <i class="md md-close"></i>
                            </a>
                        </div>
                    </div>
                    <div class="nano has-scrollbar" style="height: 318px;"><div class="nano-content" tabindex="0" style="right: -17px;"><div class="offcanvas-body">


                                <ul class="list-divided">
                                    <li>Введите в поле "Условие задачи" функцию от переменной x.</li>
                                    <li>Для задания функции следует использовать только знаки +* . Например, функция 3x<sup>2</sup>+5x+1 должна быть введена в виде 3*x*x+5*x+1.</li>
                                    <li>В поле "Ответ" введите соответствующую рекурсивную функцию.</li>
                                    <li>Для добавления нижнего индексов нужно набрать в поле ввода конструкцию вида _число. Пример: для задания R<sub>0</sub> нужно ввести R_0. Также для осуществления этой операции можно воспользоваться соответствующим спецсимволом на вспомогательной панели справа.</li>
                                    <li>Для добавления нижнего и верхнего индекса нужно набрать в поле ввода конструкцию вида _число1^число2. Пример: для задания U<sub>0</sub><sup>0</sup> нужно ввести U_0^0. Также для осуществления этой операции можно воспользоваться соответствующими спецсимволами на вспомогательной панели справа.</li>
                                    <li>Для того, чтобы проврить тождественность введенных функций нажмите "Запуск <i class="md md-fast-forward"></i>".</li>

                                </ul>
                            </div></div><div class="nano-pane"><div class="nano-slider" style="height: 199px; transform: translate(0px, 0px);"></div></div></div>
                </div>
            </div>
    </section>


    <!--end #content-->
    @stop

            <!--end #base-->
    <!-- END BASE -->
    @section('js-down')

    <!-- BEGIN JAVASCRIPT -->
    {!! HTML::script('js/recursion/mainScript.js') !!}
    {!! HTML::script('js/recursion/duperscript.js') !!}
    {!! HTML::script('js/recursion/button_onclick.js') !!}
<!--    {!! HTML::script('js/libs/jquery/jquery-1.11.2.min.js') !!}-->
<!--    {!! HTML::script('js/libs/jquery/jquery-migrate-1.2.1.min.js') !!}-->
<!--    {!! HTML::script('js/libs/jquery-ui/jquery-ui.min.js') !!}-->
<!--    {!! HTML::script('js/libs/bootstrap/bootstrap.min.js') !!}-->
<!--    {!! HTML::script('js/libs/spin.js/spin.min.js') !!}-->
<!--    {!! HTML::script('js/libs/jquery-validation/dist/jquery.validate.min.js') !!}-->
<!--    {!! HTML::script('js/libs/jquery-validation/dist/additional-methods.min.js') !!}-->
<!--    {!! HTML::script('js/libs/autosize/jquery.autosize.min.js') !!}-->
<!--    {!! HTML::script('js/libs/nestable/jquery.nestable.js') !!}-->
<!--    {!! HTML::script('js/libs/nanoscroller/jquery.nanoscroller.min.js') !!}-->
<!--    {!! HTML::script('js/core/source/App.js') !!}-->
<!--    {!! HTML::script('js/core/source/AppNavigation.js') !!}-->
<!--    {!! HTML::script('js/core/source/AppOffcanvas.js') !!}-->
<!--    {!! HTML::script('js/core/source/AppCard.js') !!}-->
<!--    {!! HTML::script('js/core/source/AppForm.js') !!}-->
<!--    {!! HTML::script('js/core/source/AppNavSearch.js') !!}-->
<!--    {!! HTML::script('js/core/source/AppVendor.js') !!}-->
<!--    {!! HTML::script('js/core/demo/Demo.js') !!}-->
<!--    {!! HTML::script('js/core/demo/DemoUILists.js') !!}-->
 <!--  {!! HTML::script('js/libs/utils/send.js') !!}-->
    {!! HTML::script('js/core/demo/DemoUIMessages.js') !!}
    {!! HTML::script('js/libs/toastr/toastr.js') !!}
            <!-- END JAVASCRIPT -->
@stop



