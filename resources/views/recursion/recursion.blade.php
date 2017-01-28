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
    <div class="card style-default-light">
        <h2 class="text-center">Рекурсивные функции</h2>
        <div class="col-md-12 col-sm-12 style-gray">
            <h2 class="text-default-bright">Эмуляторы ПРФ:</h2>
        </div>
        <div class="card col-md-10 col-sm-10 col-md-offset-1">
            <div class="card-body no-padding">
                <ul class="list divider-full-bleed">
                    <li class="tile">
                        <a href="{{ route('recursion_one')}}" class="tile-content ink-reaction">
                            <div class="tile-text">
                                Эмулятор ПРФ одной переменной
                            </div>
                        </a>
                    </li>
                    <li class="tile">
                        <a href="{{ route('recursion_two')}}" class="tile-content ink-reaction">
                            <div class="tile-text">
                                Эмулятор ПРФ двух переменных
                            </div>
                        </a>
                    </li>
                    <li class="tile">
                        <a href="{{ route('recursion_three')}}" class="tile-content ink-reaction">
                            <div class="tile-text">
                                Эмулятор ПРФ трёх переменных
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

@stop
