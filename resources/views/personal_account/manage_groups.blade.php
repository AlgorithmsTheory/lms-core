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
    <div class="col-lg-offset-1 col-md-10 col-sm-6">
        <div class="card">
            <div class="card-body">
                <h2 class="text-center">Назначить группы преподавателям</h2>
                <table class="table table-condensed table-bordered">
                    <tr>
                        <td class="info">Номер группы</td>
                        <td class="info">Фамилия преподавателя</td>
                        <td class="info">Имя преподавателя</td>
                        <td class="info">Удалить</td>
                    </tr>
                    @foreach( $groups as $group)
                        <tr id="{{ $group['id'] }}">
                            <td>
                                {{ $group['group'] }}
                            </td>
                            <td>
                                {{ $group['last_name'] }}
                            </td>
                            <td>
                                {{ $group['first_name'] }}
                            </td>
                            <td>
                                <button type="button" class="delete btn btn-danger" name="{{ $group['id'] }}">
                                    <i class="md md-delete"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </table>
                <hr>

                <form action="{{URL::route('add_group')}}" method="POST" class="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form">
                    <div class="form-group">
                        <select name="group" id="group" class="form-control" size="1">
                            @foreach($group_set as $g)
                                <option value="{{ $g['number'] }}">{{ $g['number'] }}</option>/td>
                            @endforeach
                        </select>
                        <label for="select-type">Выберите группу</label>
                    </div>
                    <div class="form-group">
                        <select name="teacher" id="select-teacher" class="form-control" size="1">
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher['id'] }}">{{ $teacher['last_name']." ".$teacher['first_name'] }}</option>/td>
                            @endforeach
                        </select>
                        <label for="select-type">Выберите преподавателя</label>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-raised submit-question" type="submit">Добавить группу</button>
                    </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    {!! HTML::script('js/personal_account/manage_groups.js') !!}

@stop