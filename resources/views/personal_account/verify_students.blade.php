@extends('templates.base')
@section('head')
    <title>Отметить студенитов</title>
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/full.css') !!}
    {!! HTML::script('js/jquery.js') !!}
    <meta name="csrf_token" content="{{ csrf_token() }}" />
@stop

@section('background')
    full
@stop




@section('content')
<div class="col-lg-offset-1 col-md-10 col-sm-6">
    <div class="card">
        <div class="card-body">
            <br>
            <br>
            <div class="form">
                <div class="form-group">
                    <textarea  class="form-control textarea3" id="regexp" rows="1" placeholder="Номер группы" required></textarea>
                    <label for="textarea3">Группа</label>
                </div>
            </div>
            <br>
            <br>
            <form method="" action="" class="form" id="forma">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <table class="table table-condensed">
                    <tr>
                        <td>Группа</td>
                        <td>Фамилия</td>
                        <td>Имя</td>
                        <td>email</td>
                        <td>Студент</td>
                        <td>Админ</td>
                        <td>Обычный пользователь</td>
                    </tr>
                    <tbody id="target">
                    @foreach($query as $user)
                    <tr id="{{ $user['id'] }}">
                        <td>
                            {{ $user['group'] }}
                        </td>
                        <td>
                            {{ $user['first_name'] }}
                        </td>
                        <td>
                            {{ $user['last_name'] }}
                        </td>
                        <td>
                            {{ $user['email'] }}
                        </td>
                        <td>
                            <button type="button" class="student btn btn-primary" name="{{ $user['id'] }}">Студент</button>
                        </td>
                        <td>
                            <button type="button" class="admin btn btn-danger" name="{{ $user['id'] }}">Преподаватель</button>
                        </td>
                        <td>
                            <button type="button" class="average btn" name="{{ $user['id'] }}">Обычный пользователь</button>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

{!! HTML::script('js/personal_account/add_student.js') !!}
{!! HTML::script('js/personal_account/teacherAccount.js') !!}

@stop
