@extends('templates.MTbase')
@section('head')
    <title>Эмулятор машины Тьюринга</title>

    <!-- BEGIN META -->
    <meta name="csrf_token" content="{{ csrf_token() }}" />
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
        <form method="" action="" class="form" id="forma">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="section-header">
                <ol class="breadcrumb">
                    <li class="active">Эмуляторы</li>
                </ol>
            </div>
            <div class="section-body contain-lg">

                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="text-primary">Эмулятор машины Тьюринга</h1>
                    </div><!--end .col -->
                    <div class="col-lg-8">
                        <article class="margin-bottom-xxl">
                            <p class="lead">
                                Данный эмулятор предназначен для получения навыков написания алгоритмов, а также для проверки решения задач. Здесь вы можете отладить алгоритм, а также отследить его работу. Вперед)
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
                                                <div class="card-body height-6 scroll style-default-bright" style="height: auto;">

                                                    <ul id="p_scents" class="list" data-sortable="true">
                                                        <li id="p_scnt" class="tile">
                                                            <div class="input-group">
                                                                <div class="input-group-content">
                                                                    <input type="text"  onchange="superScript(this);" id="text"  class="form-control" name="start" value="S₀.∂">
                                                                </div>
                                                                <span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
                                                                <div class="input-group-content">
                                                                    <input type="text" onchange="superScript(this);" id="text"  class="form-control" name="end" value="∂.S₀.R">
                                                                </div>
                                                            </div>
                                                            <a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt">
                                                                <i class="fa fa-trash"></i>

                                                            </a>
                                                        </li>
                                                        <li id="p_scnt_2" class="tile">
                                                            <div class="input-group">
                                                                <div class="input-group-content">
                                                                    <input type="text" id="text" class="form-control" name="start">
                                                                </div>
                                                                <span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
                                                                <div class="input-group-content">
                                                                    <input type="text" id="text" class="form-control" name="end">
                                                                </div>
                                                            </div>
                                                            <a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt">
                                                                <i class="fa fa-trash"></i>

                                                            </a>
                                                        </li>


                                                        <li id="p_scnt_3" class="tile">
                                                            <div class="input-group">
                                                                <div class="input-group-content">
                                                                    <input type="text" id="text" class="form-control" name="start">
                                                                </div>
                                                                <span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
                                                                <div class="input-group-content">
                                                                    <input type="text" id="text" class="form-control" name="end">
                                                                </div>
                                                            </div>
                                                            <a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt">
                                                                <i class="fa fa-trash"></i>

                                                            </a>
                                                        </li>


                                                        <li id="p_scnt_4" class="tile">
                                                            <div class="input-group">
                                                                <div class="input-group-content">
                                                                    <input type="text" id="text" class="form-control" name="start">
                                                                </div>
                                                                <span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
                                                                <div class="input-group-content">
                                                                    <input type="text" id="text" class="form-control" name="end">
                                                                </div>
                                                            </div>
                                                            <a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt">
                                                                <i class="fa fa-trash"></i>

                                                            </a>
                                                        </li>


                                                        <li id="p_scnt_5" class="tile">
                                                            <div class="input-group">
                                                                <div class="input-group-content">
                                                                    <input type="text" id="text" class="form-control" name="start">
                                                                </div>
                                                                <span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
                                                                <div class="input-group-content">
                                                                    <input type="text" id="text" class="form-control" name="end">
                                                                </div>
                                                            </div>
                                                            <a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt">
                                                                <i class="fa fa-trash"></i>

                                                            </a>
                                                        </li>


                                                        <li id="p_scnt_6" class="tile">
                                                            <div class="input-group">
                                                                <div class="input-group-content">
                                                                    <input type="text" id="text" class="form-control" name="start">
                                                                </div>
                                                                <span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
                                                                <div class="input-group-content">
                                                                    <input type="text" id="text" class="form-control" name="end">
                                                                </div>
                                                            </div>
                                                            <a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt">
                                                                <i class="fa fa-trash"></i>

                                                            </a>
                                                        </li>


                                                        <li id="p_scnt_7" class="tile">
                                                            <div class="input-group">
                                                                <div class="input-group-content">
                                                                    <input type="text" id="text" class="form-control" name="start">
                                                                </div>
                                                                <span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
                                                                <div class="input-group-content">
                                                                    <input type="text" id="text" class="form-control" name="end">
                                                                </div>
                                                            </div>
                                                            <a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
                                                                <i class="fa fa-trash"></i>

                                                            </a>
                                                        </li>


                                                        <li id="p_scnt_8" class="tile">
                                                            <div class="input-group">
                                                                <div class="input-group-content">
                                                                    <input type="text"  id="text" class="form-control" name="start">
                                                                </div>
                                                                <span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
                                                                <div class="input-group-content">
                                                                    <input type="text" id="text" class="form-control" name="end">
                                                                </div>
                                                            </div>
                                                            <a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
                                                                <i class="fa fa-trash"></i>

                                                            </a>
                                                        </li>

                                                    </ul>
                                                    <!--вставить новую строку -->
                                                </div>
                                            </div>
                                        </div><!--end .card -->
                                    </div><!--end .card-body -->
                                </div><!--end .card -->

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card-body text-center height-3">
                                            <button type="button" class="btn ink-reaction btn-primary" href="#" id="addScnt"><i class ="fa fa-plus" ></i></button>
                                            <br/>
                                        </div><!--end .card-body -->
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card-body text-center height-3">
                                            <button type="button" class="btn ink-reaction btn-primary" style="right:30px" href="#" id="reset">Очистить</button>
                                            <br/>
                                        </div><!--end .card-body -->
                                    </div>
                                    <!--<div class="col-lg-2">
                                        <div class="card-body text-center height-3">
                                            <button type="button" class="btn ink-reaction btn-primary" style="left:35px"><i class="md md-file-download"></i></button>
                                            <br/>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="card-body text-center height-3">
                                            <button type="button" class="btn ink-reaction btn-primary"><i class="md md-file-upload"></i></button>
                                            <br/>
                                        </div>
                                    </div>-->
                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="card-body">
                                    <div class="col-lg-2" style="left:400px">
                                        <a class="btn btn-raised ink-reaction btn-default-bright pull-right" href="#offcanvas-demo-right" data-toggle="offcanvas">
                                            <i class="md md-help"></i>
                                        </a>
                                    </div>
                                    <div class="col-lg-12">
                                        <form class="form" role="form">
                                            <div class="form-group floating-label">
                                                <textarea name="textarea2" id="textarea2" class="form-control" rows="3" placeholder=""></textarea>
                                                <label for="textarea2" style="top:-15px">Условие задачи: </label>
                                            </div>

                                        </form>
                                    </div><!--end .card-body -->
                                </div>
                                <div class="col-sm-6">
                                    <div class="card-body">
                                        <form class="form" role="form">
                                            <div class="form-group floating-label">
                                                <textarea name="textarea_src" id="textarea2" class="form-control" rows="1" placeholder=""></textarea>
                                                <label for="textarea2" style="top:-15px">Входное слово:</label>

                                            </div>

                                        </form>
                                    </div><!--end .card-body -->
                                    <div class="card">
                                        <div class="card-head card-head-xs">
                                            <header></header>
                                        </div>
                                        <div class="card-body">
                                            <div class="btn-group">
                                                <button type="button" class="btn ink-reaction btn-default-bright" id="right">R</button>
                                                <button type="button" class="btn ink-reaction btn-default-bright" id="left">L</button>
                                                <button type="button" class="btn ink-reaction btn-default-bright" id="here">H</button>
                                                <button type="button" class="btn ink-reaction btn-default-bright" id="zero">S<sub>0</sub></button>
                                                <br>
                                                <button type="button" class="btn ink-reaction btn-default-bright" id="part">&part;</button>
                                                <button type="button" class="btn ink-reaction btn-default-bright" id="omega">&Omega;</button>
                                                <button type="button" class="btn ink-reaction btn-default-bright" id="lambda">&#955;</button>
                                                <button type="button" class="btn ink-reaction btn-default-bright" id="one">S<sub>1</sub></button>

                                            </div>
                                        </div><!--end .card-body -->
                                    </div>

                                </div>




                                <div class="col-sm-6">
                                    <div class="card-body">
                                        <form class="form" role="form">
                                            <div class="form-group floating-label">
                                                <input type="text" class="form-control" id="disabled6" disabled>
                                                <label for="disabled6" style="top:-15px">Результат: </label>
                                            </div>

                                        </form>
                                    </div><!--end .card-body -->
                                    <div class="card">

                                        <div class="card-body">
                                            <form class="form" role="form">
                                                <div class="form-group floating-label">
                                                    <textarea name="textarea2" id="textarea2" class="form-control" rows="1" placeholder="a; b; c"></textarea>
                                                    <label for="textarea2" style="top:-15px">Исходный алфавит: </label>
                                                </div>

                                            </form>
                                            <div class="col-sm-6">
                                                <button type="button" class="btn ink-reaction btn-primary" onClick="run_all_turing()">Запуск</button>
                                            </div>
                                            <div class="col-sm-6">
                                                <button type="button" class="btn ink-reaction btn-primary" >Шаг <i class="md md-fast-forward"></i></button>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="offcanvas">


                    <div id="offcanvas-demo-right" class="offcanvas-pane width-6">
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
                                        <li>Введите в соответствующие поля входное слово, исходный алфавит, а также сам текст программы(правую и левую части).</li>
                                        <li>Для перемещения строк нужно, удерживая курсором нужный элемент списка за стрелку, перетащить его на желаемую позицию.</li>
                                        <li>Для добавления строки нажмите кнопку "+".</li>
                                        <li>Для добавления нижнего индекса нужно набрать в поле ввода конструкцию вида _{цифры}. Пример: S_{00} преобразуется в S<sub>00</sub>. </li>
                                        <li>Очитстить все строки можно с помощью соответствующей кнопки. </li>
                                        <li>Специальный символ можно добавить, кликнув на него, находясь на нужной позиции поля ввода. </li>

                                    </ul>
                                </div></div><div class="nano-pane"><div class="nano-slider" style="height: 199px; transform: translate(0px, 0px);"></div></div></div>
                    </div>
                </div>
        </form>
    </section>


    <!--end #content-->
    @stop

            <!--end #base-->
    <!-- END BASE -->
    @section('js-down')
            <!-- BEGIN JAVASCRIPT -->
    {!! HTML::script('js/algorithms/jquery-1.4.3.min.js') !!}
    {!! HTML::script('js/algorithms/jquery-1.10.2.js') !!}
    {!! HTML::script('js/algorithms/symbols.js') !!}
    {!! HTML::script('js/algorithms/adding.js') !!}
    {!! HTML::script('js/algorithms/superScript.js') !!}
    {!! HTML::script('js/algorithms/send.js') !!}
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
    {!! HTML::script('js/core/demo/DemoUIMessages.js') !!}
    {!! HTML::script('js/libs/toastr/toastr.js') !!}
            <!-- END JAVASCRIPT -->
@stop
