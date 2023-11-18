@extends('templates.base')
@section('head')
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <title>Назначить группы</title>
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/full.css') !!}
@stop

@section('background')
    full
@stop

@section('content')
    <div style="border: 2px solid blue">
        @foreach ($groups as $g)
            <div class="card">
                <div>
                    {{ $g['id'] }}
                    {{ $g['name'] }}
                </div>
                @foreach ($g['teachers'] as $t)
                    <div>
                        {{ $t->id }}
                        {{ $t->last_name }}
                        {{ $t->first_name }}
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@stop

@section('js-down')
    
@stop