@extends('templates.base')
@section('head')
<meta name="csrf_token" content="{{ csrf_token() }}" />
<title>Переписывание тестов</title>
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
            <nav class="navbar col-md-4 col-md-offset-4 style-primary">
                <h3 class="text-center">Переписывание тестов</h3>
            </nav>
            <br>
            <br>
            <br>
            <form action="{{URL::route('retest_change')}}" method="POST" id="retest-form" class="form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form">
                <div class="form-group col-md-6">
                    <select name="type" id="selected-test" class="form-control" size="1">
                        <option value="">Все</option>
                        @for ($i=0; $i < count($all_tests); $i++)
                            <option value="{{ $all_tests[$i] }}">{{ $all_tests[$i] }}</option>
                        @endfor
                    </select>
                    <label for="selected-test">Тесты</label>
                </div>
                <div class="form-group col-md-6">
                    <select name="type" id="selected-group" class="form-control" size="1">
                        <option value="">Все</option>
                        @foreach ($distinct_groups as $group)
                            <option value="{{ $group['group'] }}">{{ $group['group'] }}</option>
                        @endforeach
                    </select>
                    <label for="selected-test">Группа</label>
                </div>
                <div class="form-group col-md-6">
                    <select name="type" id="selected-student" class="form-control" size="1">
                        <option value="">Все</option>
                        @foreach ($users as $user)
                            <option value="{{ $user['last_name'] }} {{ $user['first_name'] }}">{{ $user['last_name'] }} {{$user['first_name'] }}</option>
                        @endforeach
                    </select>
                    <label for="selected-test">Студент</label>
                </div>
            </div>
            <br>
            <br>
            <table class="table table-condensed" id="retest-table">
                <tr>
                    <td>ФИО</td>
                    <td>Группа</td>
                    <td>Название теста</td>
                    <td>Возможность прохождения</td>
                    <td>Штраф</td>
                </tr>
                <tbody id="target">
                @for ($i=0; $i < count($accesses); $i++)
                <input type="hidden" name="id[]" value="{{$id[$i]}}">
                <tr>
                    <td>{{ $student_names[$i] }}</td>
                    <td>{{ $groups[$i] }}</td>
                    <td>{{ $test_names[$i] }}</td>
                    <td>
                        <div class="checkbox checkbox-styled">
                            <label>
                                <input type="checkbox" class="flag"  @if ($accesses[$i] == 1) checked @endif>
                                <input class="support-checkbox" name="fines[]" type="hidden" @if ($accesses[$i] == 1) value="1"
                                @else value="0"
                                @endif
                                >
                                <span></span>
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="number" min="70" max="{{$fines[$i]}}" step="5" name="fine-levels[]" class="form-control fine-level" value="{{$fines[$i]}}">
                        </div>
                    </td>
                </tr>
                @endfor
                </tbody>
            </table>
            <div class="col-lg-offset-9"  id="change">
                <button class="btn btn-primary btn-raised submit-test" type="submit">Применить изменения</button>
            </div>
            </form>
        </div>
    </div>

</div>
{!! HTML::script('js/retest.js') !!}

@stop