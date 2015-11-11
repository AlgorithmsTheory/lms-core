<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>Список тестов</title>
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/full.css') !!}
    {!! HTML::style('css/tests_list.css') !!}
    {!! HTML::style('css/font-awesome.min.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/material-design-iconic-font.min.css') !!}
    {!! HTML::style('css/materialadmin_demo.css') !!}
    {!! HTML::style('css/nestable.css') !!}
    {!! HTML::style('css/jquery-ui-theme.css') !!}
    {!! HTML::style('css/createTest.css') !!}
    {!! HTML::script('js/jquery.js') !!}
</head>
<body class="full-tests">
<section>
    <div class="col-md-12 col-sm-6 card style-primary text-center">
        <h1 class="text-default-bright">Выберите тест</h1>
    </div>
    <div class="section-body">
        <div class="col-lg-offset-1 col-md-10 col-sm-10 card style-gray">
            <h2 class="text-default-bright">Контрольные тесты</h2>
        </div>
        <div class="col-lg-offset-1 col-md-10 col-sm-10 ">
            <div class="card style-default-light">
                <div class="card-body">
                    @if ($ctr_amount == 0)
                        <h3 class="none-tests">На данный момент не доступен ни один контрольный тест</h3>
                    @else
                    <ul class="list">
                        @for ($i=0; $i<$ctr_amount; $i++)
                        <div class="col-md-12 col-sm-12 card test-list">
                            <a href="{{ route('question_showtest', $ctr_tests[$i]) }}"><div class="tile-text">{{$ctr_names[$i]}}</div></a>
                        </div>
                        @endfor
                    </ul>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-offset-1 col-md-10 col-sm-10 card style-gray">
            <h2 class="text-default-bright">Тренировочные тесты</h2>
        </div>
            <div class="col-lg-offset-1 col-md-10 col-sm-10">
                <div class="card style-default-light">
                    <div class="card-body">
                        @if ($tr_amount == 0)
                            <h3 class="none-tests">На данный момент не доступен ни один тренировочный тест</h3>
                        @else
                            @for ($i=0; $i<$tr_amount; $i++)
                            <div class="col-md-12 col-sm-12 card test-list">
                                <a href="{{ route('question_showtest', $tr_tests[$i]) }}"><div class="tile-text">{{$tr_names[$i]}}</div></a>
                            </div>
                            @endfor
                        @endif
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>
{!! HTML::script('js/libs/jquery/jquery-1.11.2.min.js') !!}
{!! HTML::script('js/libs/jquery/jquery-migrate-1.2.1.min.js') !!}
{!! HTML::script('js/libs/bootstrap/bootstrap.min.js') !!}
{!! HTML::script('js/libs/spin.js/spin.min.js') !!}
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
</body>
</html>