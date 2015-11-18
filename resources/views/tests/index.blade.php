@extends('templates.base')
@section('head')
<title>Список тестов</title>
{!! HTML::style('css/tests_list.css') !!}
@stop
@section('background')
full-tests
@stop

@section('content')
    <div class="section-body">
        <div class="col-lg-offset-1 col-md-10 col-sm-10 card style-gray">
            <h2 class="text-default-bright">Контрольные тесты</h2>
        </div>
        <div class="col-lg-offset-1 col-md-10 col-sm-10 ">
            <div class="card style-default-light">
                <div class="card-body test-list">
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
                    <div class="card-body test-list">
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

@stop