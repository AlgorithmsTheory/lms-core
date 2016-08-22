@extends('templates.base')
@section('head')
    <title>Редактирование задания</title>

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
        <div class="section-header">
            <ol class="breadcrumb">

                <li>{!! HTML::linkRoute('alltasksrec', 'Контрольные материалы по рекурсиям') !!}</li>

                <li class="active">Редактирование задания</li>
            </ol>

        </div>
        <div class="section-body contain-lg">

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="text-primary">Работа с контрольным материалом по теме "Примитивно-рекурсивные функции"</h1>
                </div><!--end .col -->
                <div class="col-lg-8">
                    <article class="margin-bottom-xxl">

                    </article>
                </div><!--end .col -->

            </div>
            <!-- BEGIN NESTABLE LISTS -->
            <div class="col-lg-12">
                <h4>Редактирование задания</h4>
            </div>
            <div class="col-lg-3 col-md-4">
                <article class="margin-bottom-xxl">
                    <ul class="list-divided">
                        <li>
                            Измените текст задачи, а также дополнительные параметры.
                        </li>
                        <li>
                            Для задания функции следует использовать только знаки + и * . Например, функция 3x<sup>2</sup>+5x+1 должна быть введена в виде 3*x*x+5*x+1
                        </li>

                    </ul>
                </article>
            </div>

            <div class="col-lg-offset-1 col-md-6 col-sm-6">

                <div class="card">
                    <form class="form form-validate floating-label" novalidate="novalidate" method="post" action="{{URL::route('editTaskrec', array('id'=> $id))}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />


                            <div class="card-head style-primary">
                                <header>Изменить задание</header>
                            </div>
                            <div class="card-body">

                                <div class="form-group">
                                    <input name="task" id="task" class="form-control" rows="3" required="" aria-required="true" value="<?php echo $result['task']; ?>"></input>
                                    <label for="task">Условие</label>
                                </div>
                                <div class="form-group">
                                    <select id="mark" name="mark" class="form-control" required="" aria-required="true" value="<?php echo $result['mark']; ?>>
                                        <option value="">&nbsp;</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                    <label for="mark">Максимальный балл</label>
                                </div>
                                <div class="form-group">
                                    <select id="level" name="level" class="form-control" required="" aria-required="true" value="<?php echo $result['level']; ?>>
                                        <option value="">&nbsp;</option>
                                        <option value="0">0</option>
                                        <option value="1">1</option>

                                    </select>
                                    <label for="level">Уровень сложности</label>
                                    <p class="help-block">0 - легкий, 1 - сложный</p>
                                </div>

                            </div><!--end .card-body -->
                            <div class="card-actionbar">
                                <div class="card-actionbar-row">
                                    <button  class="btn btn-flat btn-primary ink-reaction" >Изменить</button>
                                </div>
                            </div>
                        <!--end .card -->

                    </form>
                    <!--<form class="form-horizontal" ><?php //method="post" action="{{URL::route('editTask', array('id'=> $id))}}"?>
                        <div class="modal-body">
                            <div class="input-group">
                                <div class="input-group-content">
                                    <input type="text" id="input_word6" class="form-control" placeholder="Входное слово" name="input_word6"  value="<?php //echo $result['input_word']; ?>" />
                                </div>
                                <span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
                                <div class="input-group-content">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <input type="text" id="output_word6" class="form-control" placeholder="Верное преобразование" name="output_word6" value="<?php //echo $result['output_word']; ?>" / >
                                </div>
                            </div>

                        </div>

                        <button style="left:450px"class="btn ink-reaction btn-raised btn-primary" type="submit" name="submit"> Изменить</button>

                    </form>
                    </br>
                </div>
-->
            </div>

        </div>
    </section>
    <!--end #content-->
    @stop

            <!--end #base-->
    <!-- END BASE -->
    @section('js-down')
            <!-- BEGIN JAVASCRIPT -->
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
    {!! HTML::script('js/libs/utils/send.js') !!}
    {!! HTML::script('js/core/demo/DemoUIMessages.js') !!}
    {!! HTML::script('js/libs/toastr/toastr.js') !!}
            <!-- END JAVASCRIPT -->
@stop


