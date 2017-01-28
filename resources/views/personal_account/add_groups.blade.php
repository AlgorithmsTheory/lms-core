@extends('templates.base')
@section('head')
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <title>Редактировать группы</title>
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
                <h2 class="text-center">Добавить или удалить группу</h2>
                <table class="table table-condensed table-bordered">
                    <tr>
                        <td class="info">Группа</td>
                        <td class="info">Описание</td>
                        <td class="info">Удалить</td>
                    </tr>
                    @foreach( $groups as $group)
                        <tr id="{{ $group['group_id'] }}">
                            <td>
                                {{ $group['group_name'] }}
                            </td>
                            <td>
                                {{ $group['description'] }}
                            </td>
                            <td>
                                <button type="button" class="delete btn btn-danger" name="{{ $group['group_id'] }}">
                                    <i class="md md-delete"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </table>
                <hr>
                <form action="{{URL::route('add_group_to_set')}}" method="POST" class="form" role="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form">

                        <div class="form-group">
                            <input type="text" name="name" id="name" class="form-control">
                            <label for="group">Группа (например Б15-501)</label>
                        </div>

                        <div class="form-group">
                            <textarea name="description" id="description" class="form-control" rows="1" placeholder=""></textarea>
                            <label for="faculty">Описание (необязательно)</label>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-raised submit-question" type="submit">Добавить группу</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    {!! HTML::script('js/personal_account/delete_group.js') !!}

@stop