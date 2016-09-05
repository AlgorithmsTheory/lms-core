@extends('templates.base')
@section('head')
<meta name="csrf_token" content="{{ csrf_token() }}" />
<title>Редактирование теста "{{ $test['test_name'] }}"</title>}
{!! HTML::style('css/createTest.css') !!}
@stop

@section('content')
<div class="section-body" id="page">
    <div class="col-md-12 col-sm-6 card style-primary text-center">
        <h1 class="">Редактировать тест "{{ $test['test_name'] }}"</h1>
    </div>

        <!-- модуль задания основных настроек теста -->
        <div class="col-lg-offset-1 col-md-10 col-sm-10 card style-gray">
            <h2 class="text-default-bright">Настройка теста</h2>
        </div>
        <form action="{{URL::route('test_update')}}" method="POST" class="form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" id="num-rows" name="num-rows" value="{{ count($structures) }}">
            <input type="hidden" id="id-test" name="id-test" value="{{ $test['id_test'] }}">
            <input type="hidden" id="test-type" name="test-type" value="{{ $test['test_type'] }}">
            <input type="hidden" id="test-time-zone" name="test-time-zone" value="{{ $test['time_zone'] }}">
            <input type="hidden" id="test-resolved" name="test-resolved" value="{{ $test['is_resolved'] }}">
            <div class="col-lg-offset-1 col-md-10 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <!-- название теста -->
                        <div class="form-group">
                            <textarea  name="test-name" class="form-control textarea1" rows="1" placeholder=""  required>{{ $test['test_name'] }}</textarea>
                            <label for="textarea1">Название теста</label>
                        </div>
                        <!-- тренировочный тест -->
                        <div class="checkbox checkbox-styled">
                            <label>
                                @if ($test['test_type'] == 'Тренировочный')
                                    <input type="checkbox" name="training" id="training" checked>
                                @else
                                <input type="checkbox" name="training" id="training">
                                @endif
                                <span>Тренировочный тест</span>
                            </label>
                        </div>
                        <!-- Максимум баллов за тест -->
                        <div class="form-group">
                            <input type="number" min="1" name="total" id="total" class="form-control" value="{{ $test['total'] }}" required>
                            <label for="total">Максимум баллов за тест</label>
                        </div>
                        <!-- Время на прохождение теста -->
                        <div class="form-group">
                            <input type="number" min="1" name="test-time" id="test-time" class="form-control" value="{{ $test['test_time'] }}" required>
                            <label for="test-time">Время на прохождение теста в минутах</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-offset-1 col-md-5 col-sm-10">
                <div class="card">
                    <div class="card-body">
                        <!-- дата открытия теста -->
                        <label>
                            <input type="date" name="start-date" id="start-date" value="{{ substr($test['start'], 0, 10) }}">
                            <span>&nbsp Дата открытия теста</span>
                        </label>
                    </div>
                    <div class="card-body">
                        <!-- дата закрытия теста -->
                        <label>
                            <input type="date" name="end-date" id="end-date" value="{{ substr($test['end'], 0, 10) }}">
                            <input type="hidden" name="old-end-date" id="old-end-date" value="{{ substr($test['end'], 0, 10) }}">
                            <span>&nbsp Дата закрытия теста</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-sm-1">
                <div class="card">
                    <div class="card-body">
                        <!-- время открытия теста -->
                        <label>
                            <input type="time" name="start-time" id="start-time" value="{{ substr($test['start'], 11, 16) }}">
                            <span>&nbsp Время открытия теста</span>
                        </label>
                    </div>
                    <div class="card-body">
                        <!-- время закрытия теста -->
                        <label>
                            <input type="time" name="end-time" id="end-time" value="{{ substr($test['end'], 11, 16) }}">
                            <input type="hidden" name="old-end-time" id="old-end-time" value="{{ substr($test['end'], 11, 16) }}">
                            <span>&nbsp Время закрытия теста</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- модуль создания структуры теста -->
            <div class="col-lg-offset-1 col-md-10 col-sm-10 card style-gray" id="test-structure">
                <h2 class="text-default-bright">Состав теста</h2>
            </div>
            <div class="col-lg-offset-1 col-md-10 col-sm-1">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped no-margin table-bordered" id="question-table">
                            <thead>
                            <tr>
                                <th class="num-field">Количество вопросов</th>
                                <th class="select-field">Раздел</th>
                                <th class="select-field">Тема</th>
                                <th class="select-field">Тип</th>
                                <th class="db-amount">Всего вопрососв такого типа</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1 ?>
                            @foreach ($structures as $structure)
                                <tr id="row-{{ $i }}">
                                    <td><input type="number" min="1" name="num[]" id="num-{{ $i }}" value="{{ $structure['amount'] }}" size="1" class="form-control num"></td>
                                    <td> <select name="section[]" id="select-section-1" class="form-control select-section" size="1" required="">
                                            <option value="Любой">Любой</option>
                                            @foreach ($sections as $section)
                                                @if ($section['section_name'] == $structure['section'])
                                                    <option value="{{$section['section_name']}}" selected>{{$section['section_name']}}</option>
                                                @else
                                                    <option value="{{$section['section_name']}}">{{$section['section_name']}}</option>
                                                @endif
                                            @endforeach
                                        </select></td>
                                    <td>
                                        <div class="form-group" id="container-{{ $i }}">
                                            <select name="theme[]" id="select-theme" class="form-control select-theme" size="1" required="">
                                                <option value="Любая">Любая</option>
                                                @foreach ($structure['themes'] as $theme)
                                                    @if ($theme['theme_name'] == $structure['theme'])
                                                        <option value="{{$theme['theme_name']}}" selected>{{$theme['theme_name']}}</option>
                                                    @else
                                                        <option value="{{$theme['theme_name']}}">{{$theme['theme_name']}}</option>
                                                    @endif
                                                @endforeach
                                                <!-- контейнер для ajax -->
                                        </div>
                                    </td>
                                    <td> <select name="type[]" id="select-type" class="form-control select-type" size="1" required="">
                                            <option value="Любой">Любой</option>
                                            @foreach ($types as $type)
                                                @if ($type['type_name'] == $structure['type'])
                                                    <option value="{{$type['type_name']}}" selected>{{$type['type_name']}}</option>
                                                @else
                                                    <option value="{{$type['type_name']}}">{{$type['type_name']}}</option>
                                                @endif
                                            @endforeach
                                        </select></td>
                                    <td id="amount-container-{{ $i }}">{{ $structure['db-amount'] }}</td>
                                </tr>
                            <?php $i++ ?>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-offset-10 col-md-2 col-sm-6" id="add-del-buttons">
                <button type="button" class="btn ink-reaction btn-floating-action btn-success" id="add-row"><b>+</b>   </button>
                <button type="button" class="btn ink-reaction btn-floating-action btn-danger" id="del-row"><b>-</b></button>
            </div>
            <div class="col-lg-offset-1 col-md-2 col-sm-6" id="edit-test">
                <button class="btn btn-primary btn-raised submit-test" type="submit">Применить изменения</button>
                <br><br>
            </div>
        </form>
    </div>
@stop
@section ('js-down')
{!! HTML::script('js/testCreate.js') !!}
{!! HTML::script('js/testEdit.js') !!}
@stop


