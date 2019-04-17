@extends('templates.base')
@section('head')
    <title>Рекурсия</title>
    {!! HTML::style('css/loading_blur.css') !!}
    <meta name="csrf_token" content="{{ csrf_token() }}" />
@stop

@section('background')
    full-recursion
@stop

@section('content')
    <section>
        <div id="main_container">
            <div class="card col-lg-12 col-md-12 col-sm-12">
                <div class="card-body">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <a class="btn btn-raised ink-reaction btn-warning" href="#offcanvas-demo-right" data-toggle="offcanvas">
                            <i class="md md-help"></i>
                        </a>
                    </div>
                    <h1 class="text-center">Эмулятор ПРФ трёх переменных</h1>
                    <hr>
                    <br>
                    <form class="form" role="form">
                        <div class="row">
                            <div class="col-lg-1 col-md-1 col-sm-1">
                                <h1 align="right"><b>R<sup>2</sup></b></h1>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1">
                                <h1 align="left"><b>(</b></h1>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <input type="text" id="first" class="form-control" required>
                                    <label for="first_name" class="text-danger">Инициализирующее выражение</label>
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1">
                                <h1 align="left"><b>,</b></h1>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <input type="text" id="second" class="form-control" required>
                                    <label for="first_name" class="text-danger">Выражение рекурсии</label>
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1">
                                <h1 align="left"><b>)</b></h1>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-sm-2">
                                <h1 align="right"><b>f(x, y, z)=</b></h1>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-5">
                                <div class="form-group">
                                    <input type="text" id="function" class="form-control" required>
                                    <label for="first_name" class="text-danger">Аналитический вид</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-4 col-md-4 col-sm-4">
                                <input type="submit" tabindex="4" class="btn btn-primary btn-raised submit-question" id="calculate" value="Сравнить">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-10 col-md-10 col-sm-10">
                                <h1 id="result"></h1>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div id="overlay" class="none">
            <div class="loading-pulse"></div>
        </div>

        <div class="offcanvas">
            <div id="offcanvas-demo-right" class="offcanvas-pane width-10" style="">
                <div class="offcanvas-head">
                    <header>Полезная информация</header>
                    <div class="offcanvas-tools">
                        <a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
                            <i class="md md-close"></i>
                        </a>
                    </div>
                </div>
                <div class="nano has-scrollbar" style="height: 318px;">
                    <div class="nano-content" tabindex="0" style="right: -17px;">
                        <div class="offcanvas-body">
                            <p>Данный эмулятор примитивно-рекурсивных функций трёх параметров позволяет сравнивать ПРФ с функцией в аналитическом виде.</p>
                            <h4><b>Даннае правила помогут Вам правильно написать выражение для ПРФ:</b></h4>
                            <ul class="list-divided">
                                <li> Общий вид ПРФ: <b>R<sup>2</sup>(<i>инициализирующее выражение, выражение рекурсии</i>)</b></li>
                                <li> <b>выражения</b> состоят из функций и операторов <b>базиса Клини</b></li>
                                <li> функция <b>U<sup>a</sup><sub>b</sub></b> записыватеся в виде <b>Ua.b</b> (сперва значение верхнего индекса, затем ".", затем значение нижнего индекса)</li>
                                <li> функция <b>C<sup>a</sup><sub>b</sub></b> записыватеся в виде <b>Ca.b</b> (сперва значение верхнего индекса, затем ".", затем значение нижнего индекса)</li>
                                <li> функция <b>S</b> (функция следования) не меняет свой вид</li>
                                <li> вспомогателные функция <b>&#8721;, &#8719;, ^</b> будут иметь вид <b>SUM, MUL, ^</b> соответственно</li>
                                <li> оператор подстановки <b>S<sup>a</sup><sub>b</sub></b> записыватеся в виде <b>Sa.b</b> (сперва значение верхнего индекса, затем ".", затем значение нижнего индекса)</li>
                                <li> регистр <b>не имеет значения</b></li>
                                <li> аргументы пишутся <b>скобках, через запятую</b></li>
                                <li> <b>Аналитический вид</b> имеет стандартный вид относительно переменных <b>x, y, z</b>, псевдоразность обозначается обычным минусом (<b>-</b>), факториал обозначается: <b>fac(x)</b>. <b>Пример: 10+2*x</b></li>
                                <li> <b>Пример:</b> выражение <b>S<sup>2</sup><sub>2</sub>(&#8721;, U<sup>2</sup><sub>1</sub>, C<sup>2</sup><sub>2</sub>)</b> будет иметь вид <b>S2.2(SUM, U2.1, C2.2)</b></li>
                            </ul>
                        </div>
                    </div>
                    <div class="nano-pane">
                        <div class="nano-slider" style="height: 199px; transform: translate(0px, 0px);">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('js-down')
    {!! HTML::script('js/recursion/recursion_three.js') !!}

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
@stop
