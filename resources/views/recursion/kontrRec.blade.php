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


            </div>
            <!-- BEGIN NESTABLE LISTS -->
            <div class="col-lg-12">
                <div class="card tabs-left style-default-light">
                    <ul class="card-head nav nav-tabs" data-toggle="tabs">
                        <li <?php if ($selectedTask == 0)echo 'class="active"'?>><a href="#first5">Легкая задача</a></li>
                        <li <?php if ($solved and $selectedTask == 1)echo 'class="active"'?>><a href="#second5">Сложная задача</a></li>
                    </ul>
                    <div class="card-body tab-content style-default-bright">
                        <div class="tab-pane <?php if ($selectedTask == 0)echo 'active'?>" id="first5">
                            <div class="card-head">
                                <div class="col-lg-8"><header>Легкая задача (2 балла)</header></div>
                                <div class="col-lg-3" style="left:72px">
                                    <a class="btn btn-raised ink-reaction btn-default-bright pull-right" href="#offcanvas-demo-right" data-toggle="offcanvas">
                                        <i class="md md-help"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                </br>
                                <div class="card card-bordered style-primary">

                                    <div class="card-body">
                                        <div class="card">
                                            <div class="card-body no-padding">
                                                <div class="card-body height-6 scroll style-default-bright" style="height: 300 px;">

                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                        <div class="form-group floating-label">
                                                           <br> <input style="resize: none" name="func" id="textarea3" class="form-control" rows="3" placeholder="" disabled value="<?php print $result["task"]; ?>"></input>
                                                            <label for="textarea2" style="top:-15px" >Условие задачи: </label>
                                                        </div><br>
                                                        <div class="form-group floating-label">
                                                            <form id="easyform" method="post", action="{{URL::route('kontrRecSolving')}}">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                                <input type="hidden" name="selected" value="0" />
                                                                <input type="hidden" name="mark" id="mark1" value="0" />
                                                                <input type="hidden" name="user_id" value="<?php echo $userId ?>" />
                                                                <input type="hidden" name="test_id" value="<?php echo $testId ?>" />
                                                            <input style="resize: none" id="rec_func" onchange="superScript(this,this); puperScript(this);" name="rec_func"  class="form-control" rows="3" <?php if ($solved) echo "disabled"?> placeholder="" value="<?php if ($solved and $selectedTask==0) echo $answer?>"></input>
                                                            <label for="textarea2" style="top:-15px" >Ответ:</label>
                                                                </form>
                                                        </div>

                                                    <!--вставить новую строку -->
                                                </div>
                                            </div>
                                        </div><!--end .card -->
                                    </div><!--end .card-body -->
                                </div>

                            </div>

                            <div class="col-md-6">
                            <br>
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

                                            <button type="button" <?php if ($solved) echo "disabled"?> class="btn ink-reaction btn-primary" id="onerun" onclick="run_test();" >Отправить</button>
                                        </div>
                                    <div class="form-group floating-label">
                                        <br><input type="text" class="form-control" id="disabled6" name="disabled6" disabled style="text-align: center; font-size: 200%" value="<?php if ($solved and $selectedTask==0) echo $mark?>">
                                        <label for="disabled6" style="top:-15px">Ваш результат: </label>
                                    </div>
                                </center>
                                <!--end .card-body -->






                            </div>
                        </div>


                        <div class="tab-pane <?php if ($solved and $selectedTask == 1)echo 'active'?>" id="second5">
                            <div class="card-head">
                                <div class="col-lg-8"><header>Сложная задача (3 балла)</header></div>
                                <div class="col-lg-3" style="left:72px">
                                    <a class="btn btn-raised ink-reaction btn-default-bright pull-right" href="#offcanvas-demo-right" data-toggle="offcanvas">
                                        <i class="md md-help"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                </br>
                                <div class="card card-bordered style-primary">

                                    <div class="card-body">
                                        <div class="card">
                                            <div class="card-body no-padding">
                                                <div class="card-body height-6 scroll style-default-bright" style="height: 300 px;">



                                                        <div class="form-group floating-label">
                                                            <br><input style="resize: none" name="func2" id="func2" class="form-control" rows="3" placeholder="" disabled value="<?php print $result2["task"]; ?>"></input>
                                                            <label for="textarea2" style="top:-15px" >Условие задачи: </label>
                                                        </div><br>
                                                        <div class="form-group floating-label">
                                                            <form id="hardform" method="post", action="{{URL::route('kontrRecSolving')}}">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                                <input type="hidden" name="selected" value="1" />
                                                                <input type="hidden" name="mark" id="mark2" value="0" />
                                                                <input type="hidden" name="user_id" value="<?php echo $userId ?>" />
                                                                <input type="hidden" name="test_id" value="<?php echo $testId ?>" />
                                                                <input style="resize: none" id="rec_func2" onchange="superScript(this,this); puperScript(this);" name="rec_func"  class="form-control" rows="3" placeholder="" <?php if ($solved) echo "disabled"?> value="<?php if ($solved and $selectedTask==1) echo $answer?>"></input>
                                                                <label for="textarea2" style="top:-15px" >Ответ:</label>
                                                            </form>
                                                        </div>


                                                    <!--вставить новую строку -->
                                                </div>
                                            </div>
                                        </div><!--end .card -->
                                    </div><!--end .card-body -->
                                </div><!--end .card -->

                            </div>

                            <div class="col-md-6">
                                <br>
                                <center>
                                    <div class="btn-group">
                                        <label>Спецсимволы:</label><br>
                                        <button type="button" class="btn ink-reaction btn-default-bright" id="R2">R<sub>0</sub></button>
                                        <button type="button" class="btn ink-reaction btn-default-bright" id="sigma2">&Sigma;</button>
                                        <button type="button" class="btn ink-reaction btn-default-bright" id="P2">П</button>
                                        <button type="button" class="btn ink-reaction btn-default-bright" id="constant2">C<sub>0</sub><sup>0</sup></button>
                                        <button type="button" class="btn ink-reaction btn-default-bright" id="S2">S<sub>0</sub><sup>0</sup></button>
                                        <button type="button" class="btn ink-reaction btn-default-bright" id="U2">U<sub>0</sub><sup>0</sup></button>
                                    </div>

                                    <div class="card-body">

                                            <button type="button" <?php if ($solved) echo "disabled"?> class="btn ink-reaction btn-primary" id="onerun2" onclick="run_test2(); " >Отправить</button>
                                        </div>
                                    <div class="form-group floating-label">
                                        <br><input type="text" class="form-control" id="disabled1" name="disabled1" disabled style="text-align: center; font-size: 200%" value="<?php if ($solved and $selectedTask==1) echo $mark?>">
                                        <label for="disabled1" style="top:-15px">Ваш результат: </label>
                                    </div>
                                </center>
                                <!--end .card-body -->




                            </div>

                        </div>
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
                                <li>В поле "Условие задачи" представлено задание вашей контрольной работы</li>
                                <li>В поле "Ответ" введите соответствующую рекурсивную функцию.</li>
                                <li>Для добавления нижнего индекса нужно набрать в поле ввода конструкцию вида _число. Пример: для задания R<sub>0</sub> нужно ввести R_0. Также для осуществления этой операции можно воспользоваться соответствующим спецсимволом на вспомогательной панели справа.</li>
                                <li>Для добавления нижнего и верхнего индекса нужно набрать в поле ввода конструкцию вида _число1^число2. Пример: для задания U<sub>0</sub><sup>0</sup> нужно ввести U_0^0. Также для осуществления этой операции можно воспользоваться соответствующими спецсимволами на вспомогательной панели справа.</li>
                                <li>Для того, чтобы узнать свою оценку нажмите "Отправить".</li>

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
<script>
    //function disableFunction() {
      //  document.getElementById("onerun").disabled = 'true';
   // }
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


