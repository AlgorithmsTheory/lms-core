@extends('templates.base')
@section('head')
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <title>Параметры адаптивной модели</title>
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/dropzone-theme.css') !!}
    {!! HTML::style('css/full.css') !!}
@stop

@section('content')
    <div class="col-md-12 col-sm-6 card style-primary text-center">
        <h1 class="">Пересчитать параметры адаптивной модели</h1>
    </div>
    <div class="col-lg-offset-1 col-md-10 col-sm-6">
        <form action="{{URL::route('eval_params')}}" method="POST">
            <div class="card">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="card-body">
                    <div class="checkbox checkbox-styled text-lg">
                        <label>
                            <input type="checkbox" name="param[]" id="difficulty" value="difficulty">
                            <span>Сложность</span>
                        </label>
                    </div>
                    <div class="checkbox checkbox-styled text-lg">
                        <label>
                            <input type="checkbox" name="param[]" id="discriminant" value="discriminant">
                            <span>Дискриминант</span>
                        </label>
                    </div>
                    <div class="checkbox checkbox-styled text-lg">
                        <label>
                            <input type="checkbox" name="param[]" id="guess" value="guess">
                            <span>Параметр угадывания</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-lg-offset-10 col-md-10 col-sm-6">
                <button class="btn btn-primary btn-raised" type="submit" id="eval-level">Пересчитать</button>
            </div>
        </form>
    </div>
@stop
