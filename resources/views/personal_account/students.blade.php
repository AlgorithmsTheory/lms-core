@extends('templates.base')
@section('head')
    <meta charset="utf-8">
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <title>Личные кабинеты студентов</title>
    {!! HTML::style('css/personal_account/students.css') !!}
@stop

@section('background')
    full
@stop

@section('content')
</style>
    <div class="card style-default-light">
        <h2 class="text-center">Личные кабинеты студентов</h2>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="" method="" class="form" id="forma">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <select name="group" id="group_num" class="form-control textarea3" size="1" required>
                        <option value="" selected disabled hidden>Выберите...</option>
                        @foreach($groups as $g)
                            <option value="{{ $g['group_id'] }}">{{ $g['group_name'] }}</option>
                        @endforeach
                    </select>
                    <label for="group_num">Выберите группу</label>
                </div>
            </form>
            <div class="students">
            </div>
        </div>
    </div>
@stop

@section('js-down')
    {!! HTML::script('js/personal_account/students.js') !!}
@stop