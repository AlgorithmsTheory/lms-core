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
                        <td class="info">Номер группы</td>
                        <td class="info">Факультет</td>
                        <td class="info">Кафедра</td>
                        <td class="info">Удалить</td>
                    </tr>
                    @foreach( $groups as $group)
                        <tr id="{{ $group['number'] }}">
                            <td>
                                {{ $group['number'] }}
                            </td>
                            <td>
                                {{ $group['faculty'] }}
                            </td>
                            <td>
                                {{ $group['department'] }}
                            </td>
                            <td>
                                <button type="button" class="delete btn btn-danger" name="{{ $group['number'] }}">
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
                            <input type="number" name="number" data-minlength="3" max="999" id="number" class="form-control">
                            <label for="group">Номер группы (только три последние цифры, например 221)</label>
                        </div>

                        <div class="form-group">
                            <textarea name="faculty" id="faculty" class="form-control" rows="1" placeholder=""></textarea>
                            <label for="faculty">Факультет</label>
                        </div>

                        <div class="form-group">
                            <textarea name="department" id="department" class="form-control" rows="1" placeholder=""></textarea>
                            <label for="department">Кафедра</label>
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