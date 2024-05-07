@extends('templates.base')
@section('head')
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <title>Подготовка</title>
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/dropzone-theme.css') !!}
    {!! HTML::style('css/full.css') !!}
@stop

@section('content')
    <div class="col-md-12 col-sm-6 card style-primary text-center">
        <h1 class="">Оцените свой уровень знаний</h1>
    </div>
    <div class="col-md-12 col-sm-12 card">
        <div class="card-body">
            <p>
                Адаптивный режим тестирования подстраивается под ваш уровень знаний,<br>
                выбирая вопросы на основе предыдущих ответов для оптимальной оценки ваших знаний.
            </p>
        </div>
    </div>
    <div class="col-lg-offset-1 col-md-10 col-sm-6">
        <form action="{{URL::route('init_adaptive_test', $id_test)}}" method="POST">
            <div class="card">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="card-body">
                    @foreach ($marks as $mark)
                        <div class="radio radio-styled text-lg">
                            <label>
                                <input type="radio" name="expected-mark[]" id="expected-mark-{{ $mark }}" value="{{ $mark }}">
                                <span class="radio-span">{{ $mark }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-offset-10 col-md-10 col-sm-6">
                <button class="btn btn-primary btn-raised" type="submit" id="init">Начать тест</button>
            </div>
        </form>
        <br><br>
    </div>
    <style>
        .radio-span::before, .radio-span::after {
            top: 50% !important;
            transform: translateY(-50%);
        }
    </style>
@stop
