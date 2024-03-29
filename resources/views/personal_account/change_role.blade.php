@extends('templates.base')
@section('head')
    <title>Смена роли</title>
{{--    {!! HTML::style('css/bootstrap.css') !!}--}}
{{--    {!! HTML::style('css/materialadmin.css') !!}--}}
{{--    {!! HTML::style('css/full.css') !!}--}}
{{--    {!! HTML::script('js/jquery.js') !!}--}}
    {!! HTML::style('css/loading_blur.css') !!}
    <meta name="csrf_token" content="{{ csrf_token() }}" />
@stop

@section('background')
    full
@stop




@section('content')
    <div id="main_container">
    <div class="col-lg-offset-0 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                {{--Вывод ошибок Проверки учебного плана--}}
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
                <h2 class="text-center">Редактировать роль, фамилию и имя пользователей.</h2>
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
                    {{--<div class="table-responsive">--}}
                    <table class="table table-condensed table-bordered">
                        <tr class="info">
                            <td>Группа</td>
                            <td>Фамилия</td>
                            <td>Имя</td>
                            <td>email</td>
                            <td>Роль</td>
                            <td>Студент</td>
                            <td>Админ</td>
                            <td>Обычный</td>
                            <td>Преподаватель</td>
                            <td>Удалить!</td>
                        </tr>
                        <tbody id="target">
                        @foreach($query as $user)
                            <tr id="{{ $user['id'] }}">
                                <td>
                                    <select name="group-select" class="form-control" size="1" onchange="changeGroup(this, {{ $user['id'] }})">
                                        @foreach($groups as $group)
                                            <option value="{{ $group['group_id'] }}" {{ $user->group === $group['group_id'] ? 'selected' : '' }}>{{ $group['group_name'] }}</option>/td>
                                        @endforeach
                                    </select>
{{--                                    <script> console.log(JSON.parse('{!! json_encode($user) !!}')); </script>--}}
{{--                                    {{ $user['group_name'] }}--}}
                                </td>
                                <td>
                                    <input type="text" value="{{ $user['last_name'] }}" name="{{ $user['id'] }}" class="l_name_change">
{{--                                    {{ $user['last_name'] }}--}}
                                </td>
                                <td>
                                    <input type="text" value="{{ $user['first_name'] }}" name="{{ $user['id'] }}" class="f_name_change">
                                    {{--{{ $user['first_name'] }}--}}
                                </td>
                                <td>
                                    {{ $user['email'] }}
                                </td>
                                <td>
                                    {{ $user['role'] }}
                                </td>
                                <td>
                                    <button type="button" class="student btn btn-primary" name="{{ $user['id'] }}">Студент</button>
                                </td>
                                <td>
                                    <button type="button" class="admin btn btn-danger" name="{{ $user['id'] }}">Админ</button>
                                </td>
                                <td>
                                    <button type="button" class="average btn" name="{{ $user['id'] }}">Обычный</button>
                                </td>
                                <td>
                                    <button type="button" class="tutor btn btn-accent-bright" name="{{ $user['id'] }}">Преподаватель</button>
                                </td>
                                <td>
                                    <button type="button" class="remove-the-user btn btn-danger" name="{{ $user['id'] }}">Удалить!</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{--</div>--}}
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
    {!! HTML::script('js/personal_account/change_user_role.js') !!}
    {!! HTML::script('js/personal_account/person_filter.js') !!}
@stop