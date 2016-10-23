@extends('templates.base')
@section('head')
<meta name="csrf_token" content="{{ csrf_token() }}" />
<title>Выбор группы</title>
{!! HTML::style('css/createTest.css') !!}
@stop

@section('content')
<div class="col-md-12 col-sm-6 card style-primary text-center">
    <h1 class="">Выбор группы</h1>
</div>
<div class="col-lg-offset-1 col-md-10 col-sm-10">
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered text-lg" id="groups">
                <tr>
                    <th>№ п/п</th>
                    <th>Группа</th>
                    <th>Перейти к списку тестов</th>
                </tr>
                @for ($i = 1; $i <= count($groups); $i++)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $groups[$i-1]['group_name'] }}</td>
                        <td>
                            <a href="{{URL::route('tests_list', $groups[$i-1]['group_id'])}}" class="btn btn-primary" role="button">
                                <span class="demo-icon-hover">
                                    <i class="md md-forward"></i>
                                </span>
                            </a>
                        </td>
                    </tr>
                @endfor
            </table>
        </div>
    </div>
</div>
@stop