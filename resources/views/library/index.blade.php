@extends('templates.base')
@section('head')
    <title>Библиотека</title>
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
    <section>
        <div class="section-header">
            <ol class="breadcrumb">
                <li class="active">Библиотека</li>
            </ol>
        </div><!--end .section-header -->
    </section>


<div class="card"> <center>
        <div class="card-body">
            <div class="row">
                <div class="btn-group">
                    <button type="button" class="btn ink-reaction btn-flat dropdown-toggle" data-toggle="dropdown">
                        лекции <i class="fa fa-caret-down text-default-light"></i>
                    </button>
                    <ul class="dropdown-menu animation-expand" >
                        <li>{!! HTML::link('download/saveall/part1.rar', '1 раздел') !!}</li>
                        <li>{!! HTML::link('download/saveall/part2.rar', '2 раздел') !!}</li>
                        <li>{!! HTML::link('download/saveall/part3.rar', '3 раздел') !!}</li>
                        <li>{!! HTML::link('download/saveall/part4.rar', '4 раздел') !!}</li>
                        <li class="divider"></li>
                        <li>{!! HTML::link('download/saveall/TeoriaAlgoritmov.rar', 'Скачать всё') !!}</li>
                    </ul>
                </div>
                <a>&nbsp;&nbsp;&nbsp;</a>
                <div class="btn-group">
                    <button type="button" class="btn ink-reaction btn-flat dropdown-toggle" data-toggle="dropdown">
                        Книги по ТА <i class="fa fa-caret-down text-default-light"></i>
                    </button>
                    <ul class="dropdown-menu animation-expand" >
                        <li>{!! HTML::link('download/book/TeorMnozh.pdf', 'Н.К.Верещагин, А.Шень "Начала теории множеств') !!}</li>
                        <li>{!! HTML::link('download/book/MSU.pdf', 'В.Н. Пильщиков, В.Г. Абрамов и др. "Машина Тьюринга и алгоритмы Маркова.Решение задач') !!}</li>
                        <li class="divider"></li>
                        <li>{!! HTML::link('download/book/TA_books.rar', 'Скачать все книги') !!}</li>
                    </ul>
                </div>
                <a>&nbsp;&nbsp;&nbsp;</a>
                <div class="btn-group">
                    <button type="button" class="btn ink-reaction btn-flat dropdown-toggle" data-toggle="dropdown">
                        Определения и теоремы<i class="fa fa-caret-down text-default-light"></i>
                    </button>
                    <ul class="dropdown-menu animation-expand" >
                        <li>{!! HTML::linkRoute('library_definitions', 'Определения') !!}</li>
                        <li>{!! HTML::linkRoute('library_theorems', 'Теоремы') !!}</li>
                        <li class="divider"></li>
                        <li>{!! HTML::link('download/SpisokOT.rar', 'Скачать всё') !!}</li>
                    </ul>
                </div>


                <a>&nbsp;&nbsp;&nbsp;</a>

                <div class="btn-group">
                    <button type="button" class="btn ink-reaction btn-flat dropdown-toggle" data-toggle="dropdown">
                        К экзамену <i class="fa fa-caret-down text-default-light"></i>
                    </button>
                    <ul class="dropdown-menu animation-expand" >

                        <li>{!! HTML::link('download/material_exam/exam_2014.pdf', 'Пробный вариант') !!}</li>
                        <li>{!! HTML::link('download/material_exam/Questions_for_exam.docx', 'Допвопросы для подготовки к экзамену') !!}</li>
                        <li>{!! HTML::link('download/material_exam/rules.doc', 'Правила проведения экзамена') !!}</li>
                        <li class="divider"></li>
                        <li>{!! HTML::link('download/material_exam/material_exam.rar', 'Скачать всё') !!}</li>
                    </ul>
                </div>


                <a>&nbsp;&nbsp;&nbsp;</a>
                <div class="btn-group">
                    <button type="button" class="btn ink-reaction btn-flat dropdown-toggle" data-toggle="dropdown">
                        Задачи<i class="fa fa-caret-down text-default-light"></i>
                    </button>
                    <ul class="dropdown-menu animation-expand" >
                        <li>{!! HTML::link('download/AM_MT/zadachi_AM.doc', 'Алгоритмы Маркова') !!}</li>
                        <li>{!! HTML::link('download/AM_MT/zadachi_MT.doc', 'Машины Тьюринга') !!}</li>
                        <li>{!! HTML::link('download/AM_MT/recurs.doc', 'Рекурсии') !!}</li>
                        <li class="divider"></li>
                        <li>{!! HTML::link('download/AM_MT/AM_MT.rar', 'Скачать всё') !!}</li>
                    </ul>
                </div>
                <a>&nbsp;&nbsp;&nbsp;</a>
                <div class="btn-group">
                    <button type="button" class="btn ink-reaction btn-flat dropdown-toggle" >
                        {!! HTML::linkRoute('library_persons', 'Персоналии') !!}
                    </button>

                </div>

                <a>&nbsp;&nbsp;&nbsp;</a>
                <div class="btn-group">
                    <button type="button" class="btn ink-reaction btn-flat dropdown-toggle" >
                        {!! HTML::linkRoute('library_extra', 'Дополнительно') !!}
                    </button>
                </div>





            </div>

        </div></center>

</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-3">
                <div class="btn-group">
                    <h3 class="text-light" title="Формальные описания алгоритмов">1 раздел</h3>
                    <button type="button" class="btn ink-reaction btn-default-light">{!! HTML::linkRoute('lecture', 'Лекция 1', array(1)) !!}</button>
                    <button type="button" class="btn ink-reaction btn-primary dropdown-toggle" data-toggle="dropdown" >
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <ul class="dropdown-menu animation-expand" >
                        <li>{!! HTML::link('download/ppt/TA_lec1.ppt', 'ppt') !!}</li>
                        <li>{!! HTML::link('download/doc/TA_lec1.doc', 'doc') !!}</li>
                    </ul>

                </div><!--end .btn-group -->
            </div><!--end .col -->
            <div class="col-sm-3">
                <div class="btn-group">
                    <h3 class="text-light" title="Числовые множества и арифметические вычисления">2 раздел</h3>
                    <button type="button" class="btn ink-reaction btn-default-light">{!! HTML::linkRoute('lecture', 'Лекция 6', array(6)) !!}</a></button>
                    <button type="button" class="btn ink-reaction btn-primary dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-caret-down"></i></button>
                    <ul class="dropdown-menu animation-expand" >
                        <li>{!! HTML::link('download/ppt/TA_lec6.ppt', 'ppt') !!}</li>
                        <li>{!! HTML::link('download/doc/TA_lec1.doc', 'doc') !!}</li>
                    </ul>

                </div><!--end .btn-group -->
            </div><!--end .col -->
            <div class="col-sm-3">
                <div class="btn-group">
                    <h3 class="text-light" title="Рекурсивные функции">3 раздел</h3>
                    <button type="button" class="btn ink-reaction btn-default-light">{!! HTML::linkRoute('lecture', 'Лекция 12', array(12)) !!}</button>
                    <button type="button" class="btn ink-reaction btn-primary dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-caret-down"></i></button>
                    <ul class="dropdown-menu animation-expand" >
                        <li>{!! HTML::link('download/ppt/TA_lec12.ppt', 'ppt') !!}</li>
                        <li>{!! HTML::link('download/doc/TA_lec12.doc', 'doc') !!}</li>
                    </ul>

                </div><!--end .btn-group -->
            </div><!--end .col -->
            <div class="col-sm-3">
                <div class="btn-group">

                    <h3 class="text-light" title="Сложность вычислений">4 раздел </h3>

                    <button type="button" class="btn ink-reaction btn-default-light">{!! HTML::linkRoute('lecture', 'Лекция 16', array(16)) !!}</button>
                    <button type="button" class="btn ink-reaction btn-primary dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-caret-down"></i></button>
                    <ul class="dropdown-menu animation-expand" >
                        <li>{!! HTML::link('download/ppt/TA_lec16.ppt', 'ppt') !!}</li>
                        <li>{!! HTML::link('download/doc/TA_lec16.doc', 'doc') !!}</li>
                    </ul>

                </div><!--end .btn-group -->

            </div><!--end .col -->

        </div><!--end .row -->
    </div><!--end .card-body -->



<!-- <div class="card"> -->
    <div class="card-body">
    <div class="row">
        <div class="col-sm-3">
            <div class="btn-group">
                <button type="button" class="btn ink-reaction btn-default-light">{!! HTML::linkRoute('lecture', 'Лекция 2', array(2)) !!}</button>
                <button type="button" class="btn ink-reaction btn-primary dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-caret-down"></i></button>
                <ul class="dropdown-menu animation-expand" >
                    <li>{!! HTML::link('download/ppt/TA_lec2.ppt', 'ppt') !!}</li>
                    <li>{!! HTML::link('download/doc/TA_lec2.doc', 'doc') !!}</li>
                </ul>

            </div><!--end .btn-group -->
        </div><!--end .col -->
        <div class="col-sm-3">
            <div class="btn-group">
                <button type="button" class="btn ink-reaction btn-default-light">{!! HTML::linkRoute('lecture', 'Лекция 7', array(7)) !!}</button>

                <button type="button" class="btn ink-reaction btn-primary dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-caret-down"></i></button>
                <ul class="dropdown-menu animation-expand" >
                    <li>{!! HTML::link('download/ppt/TA_lec7.ppt', 'ppt') !!}</li>
                    <li>{!! HTML::link('download/doc/TA_lec7.doc', 'doc') !!}</li>
                </ul>

            </div><!--end .btn-group -->
        </div><!--end .col -->
        <div class="col-sm-3">
            <div class="btn-group">
                <button type="button" class="btn ink-reaction btn-default-light">{!! HTML::linkRoute('lecture', 'Лекция 13', array(13)) !!}</button>
                <button type="button" class="btn ink-reaction btn-primary dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-caret-down"></i></button>
                <ul class="dropdown-menu animation-expand" >
                    <li>{!! HTML::link('download/ppt/TA_lec13.ppt', 'ppt') !!}</li>
                    <li>{!! HTML::link('download/doc/TA_lec13.doc', 'doc') !!}</li>
                </ul>

            </div><!--end .btn-group -->
        </div><!--end .col -->
        <div class="col-sm-3">

        </div><!--end .col -->
    </div><!--end .row -->
</div><!--end .card-body -->


<!--	<div class="card"> -->
    <div class="card-body">
    <div class="row">
        <div class="col-sm-3">
            <div class="btn-group">
                <button type="button" class="btn ink-reaction btn-default-light">{!! HTML::linkRoute('lecture', 'Лекция 3', array(3)) !!}</button>
                <button type="button" class="btn ink-reaction btn-primary dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-caret-down"></i></button>
                <ul class="dropdown-menu animation-expand" >
                    <li>{!! HTML::link('download/ppt/TA_lec3.ppt', 'ppt') !!}</li>
                    <li>{!! HTML::link('download/doc/TA_lec3.doc', 'doc') !!}</li>
                </ul>

            </div><!--end .btn-group -->
        </div><!--end .col -->
        <div class="col-sm-3">
            <div class="btn-group">
                <button type="button" class="btn ink-reaction btn-default-light">{!! HTML::linkRoute('lecture', 'Лекция 8', array(8)) !!}</button>
                <button type="button" class="btn ink-reaction btn-primary dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-caret-down"></i></button>
                <ul class="dropdown-menu animation-expand" >
                    <li>{!! HTML::link('download/ppt/TA_lec8.ppt', 'ppt') !!}</li>
                    <li>{!! HTML::link('download/doc/TA_lec8.doc', 'doc') !!}</li>
                </ul>

            </div><!--end .btn-group -->
        </div><!--end .col -->
        <div class="col-sm-3">
            <div class="btn-group">
                <button type="button" class="btn ink-reaction btn-default-light">{!! HTML::linkRoute('lecture', 'Лекция 14', array(14)) !!}</button>
                <button type="button" class="btn ink-reaction btn-primary dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-caret-down"></i></button>
                <ul class="dropdown-menu animation-expand" >
                    <li>{!! HTML::link('download/ppt/TA_lec14.ppt', 'ppt') !!}</li>
                    <li>{!! HTML::link('download/doc/TA_lec14.doc', 'doc') !!}</li>
                </ul>

            </div><!--end .btn-group -->
        </div><!--end .col -->
        <div class="col-sm-3">

        </div><!--end .col -->
    </div><!--end .row -->
</div><!--end .card-body -->


<!--		<div class="card"> -->
    <div class="card-body">
    <div class="row">
        <div class="col-sm-3">
            <div class="btn-group">
                <button type="button" class="btn ink-reaction btn-default-light">{!! HTML::linkRoute('lecture', 'Лекция 4', array(4)) !!}</button>
                <button type="button" class="btn ink-reaction btn-primary dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-caret-down"></i></button>
                <ul class="dropdown-menu animation-expand" >
                    <li>{!! HTML::link('download/ppt/TA_lec4.ppt', 'ppt') !!}</li>
                    <li>{!! HTML::link('download/doc/TA_lec4.doc', 'doc') !!}</li>
                </ul>

            </div><!--end .btn-group -->
        </div><!--end .col -->
        <div class="col-sm-3">
            <div class="btn-group">
                <button type="button" class="btn ink-reaction btn-default-light">{!! HTML::linkRoute('lecture', 'Лекция 9', array(9)) !!}</button>
                <button type="button" class="btn ink-reaction btn-primary dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-caret-down"></i></button>
                <ul class="dropdown-menu animation-expand" >
                    <li>{!! HTML::link('download/ppt/TA_lec9.ppt', 'ppt') !!}</li>
                    <li>{!! HTML::link('download/doc/TA_lec9.doc', 'doc') !!}</li>
                </ul>

            </div><!--end .btn-group -->
        </div><!--end .col -->
        <div class="col-sm-3">
            <div class="btn-group">
                <button type="button" class="btn ink-reaction btn-default-light">{!! HTML::linkRoute('lecture', 'Лекция 15', array(15)) !!}</button>
                <button type="button" class="btn ink-reaction btn-primary dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-caret-down"></i></button>
                <ul class="dropdown-menu animation-expand" >
                    <li>{!! HTML::link('download/ppt/TA_lec15.ppt', 'ppt') !!}</li>
                    <li>{!! HTML::link('download/doc/TA_lec15.doc', 'doc') !!}</li>
                </ul>

            </div><!--end .btn-group -->
        </div><!--end .col -->
        <div class="col-sm-3">

        </div><!--end .col -->
    </div><!--end .row -->
</div><!--end .card-body -->

<!--	<div class="card"> -->
    <div class="card-body">
    <div class="row">
        <div class="col-sm-3">
            <div class="btn-group">
                <button type="button" class="btn ink-reaction btn-default-light">{!! HTML::linkRoute('lecture', 'Лекция 5', array(5)) !!}</button>
                <button type="button" class="btn ink-reaction btn-primary dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-caret-down"></i></button>
                <ul class="dropdown-menu animation-expand" >
                    <li>{!! HTML::link('download/ppt/TA_lec5.ppt', 'ppt') !!}</li>
                    <li>{!! HTML::link('download/doc/TA_lec5.doc', 'doc') !!}</li>
                </ul>

            </div><!--end .btn-group -->
        </div><!--end .col -->
        <div class="col-sm-3">
            <div class="btn-group">
                <button type="button" class="btn ink-reaction btn-default-light">{!! HTML::linkRoute('lecture', 'Лекция 10', array(10)) !!}</button>
                <button type="button" class="btn ink-reaction btn-primary dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-caret-down"></i></button>
                <ul class="dropdown-menu animation-expand" >
                    <li>{!! HTML::link('download/ppt/TA_lec10.ppt', 'ppt') !!}</li>
                    <li>{!! HTML::link('download/doc/TA_lec10.doc', 'doc') !!}</li>
                </ul>

            </div><!--end .btn-group -->
        </div><!--end .col -->
        <div class="col-sm-3">

        </div><!--end .col -->
        <div class="col-sm-3">

        </div><!--end .col -->
    </div><!--end .row -->
</div><!--end .card-body -->

<!--	<div class="card"> -->
    <div class="card-body">
    <div class="row">
        <div class="col-sm-3">
        </div><!--end .col -->
        <div class="col-sm-3">
            <div class="btn-group dropup">
                <button type="button" class="btn ink-reaction btn-default-light">{!! HTML::linkRoute('lecture', 'Лекция 11', array(11)) !!}</button>
                <button type="button" class="btn ink-reaction btn-primary dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-caret-down"></i></button>

                <ul class="dropdown-menu animation-expand" >
                    <li>{!! HTML::link('download/ppt/TA_lec11.ppt', 'ppt') !!}</li>
                    <li>{!! HTML::link('download/doc/TA_lec11.doc', 'doc') !!}</li>
                </ul>
            </div>
        </div><!--end .btn-group -->
        <!--end .col -->
    </div><!--end .row -->
</div><!--end .card-body -->

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
<!-- END JAVASCRIPT -->
@stop
