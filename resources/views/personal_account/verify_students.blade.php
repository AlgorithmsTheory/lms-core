@extends('templates.base')
@section('head')
    <title>Отметить студенитов</title>
    {!! HTML::style('css/full.css') !!}
    {!! HTML::style('css/loading_blur.css') !!}
    <meta name="csrf_token" content="{{ csrf_token() }}" />
@stop

@section('background')
    full
@stop

@section('content')
    <div id="main_container">
<div class="col-md-12 col-sm-12" >
    <div class="card">
        <div class="card-body">
            {{--Вывод ошибок валидации--}}
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
            <h2 class="text-center">Отметить студентов</h2>
            <div class="form">
                <div class="form-group col-md-4">
                    <select name="group" id="groupInput" class="form-control" size="1" onchange="groupFilter()">
                        <option value="">Все</option>
                        @foreach($groups as $group)
                            <option value="{{ $group['group_id'] }}">{{ $group['group_name'] }}</option>/td>
                        @endforeach
                    </select>
                    <label for="groupInput">Группа</label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" id="emailInput" class="form-control" onkeyup="emailFilter()" placeholder="Введите email">
                    <label for="emailInput">Email</label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" id="nameInput" class="form-control" onkeyup="nameFilter()" placeholder="Введите фамилию">
                    <label for="emailInput">Фамилия</label>
                </div>
            </div>
            <br>
            <br>
            <form method="" action="" class="form" id="forma">
                <table class="table table-condensed">
                    <tr class="info">
                        <td>Группа</td>
                        <td>Фамилия</td>
                        <td>Имя</td>
                        <td>email</td>
                        <td>Студент</td>
                        @if(Auth::user()['role'] == 'Админ')
                        <td>Админ</td>
                        @endif
                        <td>Обычный</td>
                        @if(Auth::user()['role'] == 'Админ')
                        <td>Преподаватель</td>
                        @endif
                    </tr>
                    <tbody id="target">
                    @foreach($query as $user)
                    <tr id="{{ $user['id'] }}">
                        <td>
                           {{ $user['group_name'] }}
                        </td>
                        <td>
                            {{ $user['last_name'] }}
                        </td>
                        <td>
                            {{ $user['first_name'] }}
                        </td>
                        <td>
                            {{ $user['email'] }}
                        </td>
                        <td>
                            <button type="button" class="student btn btn-primary" name="{{ $user['id'] }}">Студент</button>
                        </td>
                        @if(Auth::user()['role'] == 'Админ')
                        <td>
                            <button type="button" class="admin btn btn-danger" name="{{ $user['id'] }}">Админ</button>
                        </td>
                        @endif
                        <td>
                            <button type="button" class="average btn" name="{{ $user['id'] }}">Обычный</button>
                        </td>
                        @if(Auth::user()['role'] == 'Админ')
                        <td>
                            <button type="button" class="tutor btn btn-accent-bright" name="{{ $user['id'] }}">Преподаватель</button>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
    </div>
    <div id="overlay" class="none">
        <div class="loading-pulse"></div>
    </div>
@stop

@section('js-down')
    {!! HTML::script('js/personal_account/add_student.js') !!}
    {!! HTML::script('js/personal_account/person_filter.js') !!}
@stop
