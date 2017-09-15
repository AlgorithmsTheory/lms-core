@extends('templates.base')
@section('head')
<meta name="csrf_token" content="{{ csrf_token() }}" />
<title>Редактирование теста "{{ $test['test_name'] }}"</title>}
{!! HTML::style('css/createTest.css') !!}
{!! HTML::style('css/loading_blur.css') !!}
@stop

@section('content')
<div class="section-body" id="page">
    <div class="col-md-12 col-sm-6 card style-primary text-center">
        <h1 class="">Редактировать тест "{{ $test['test_name'] }}"</h1>
    </div>

    @if ($test['test_type'] == 'Контрольный' && $test['is_resolved'] == 1)
        <div class="col-lg-offset-1 col-md-10 col-sm-10 card style-warning">
            <p class="text-default-bright text-lg">
                <br>
                <b>Внимание!</b> Данный контрольный тест уже <b>был пройден</b>. Вы не можете менять структуру данного теста. <br>
            </p>
        </div>
    @endif
        <!-- модуль задания основных настроек теста -->
        <div class="col-lg-offset-1 col-md-10 col-sm-10 card style-gray">
            <h2 class="text-default-bright">Настройка теста</h2>
        </div>
        <form action="{{URL::route('test_update')}}" method="POST" class="form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" id="num-rows" name="num-rows" value="{{ count($structures) }}">
            <input type="hidden" id="id-test" name="id-test" value="{{ $test['id_test'] }}">
            <input type="hidden" id="test-type" name="test-type" value="{{ $test['test_type'] }}">
            <input type="hidden" id="test-resolved" name="test-resolved" value="{{ $test['is_resolved'] }}">
            <input type="hidden" id="go-to-edit-structure" name="go-to-edit-structure" value="0">
            <div class="col-lg-offset-1 col-md-5 col-sm-5">
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
                                    <input type="checkbox" name="training" id="training" checked disabled>
                                @else
                                    <input type="checkbox" name="training" id="training" disabled>
                                @endif
                                <span>Тренировочный тест</span>
                            </label>
                        </div>
                        <!-- Видимый или невидимый тест -->
                        <div class="checkbox checkbox-styled">
                            <label>
                                @if ($test['visibility'] == 1)
                                <input type="checkbox" name="visibility" id="visibility" checked>
                                @else
                                <input type="checkbox" name="visibility" id="visibility">
                                @endif
                                <span>Видимость</span>
                            </label>
                        </div>
                        <!-- Доступен на английском языке -->
                        <div class="checkbox checkbox-styled">
                            <label>
                                @if ($test['multilanguage'] == 1)
                                <input type="checkbox" name="multilanguage" id="multilanguage" checked>
                                @else
                                <input type="checkbox" name="multilanguage" id="multilanguage">
                                @endif
                                <span>Доступен на английском языке</span>
                            </label>
                        </div>
                        <!-- Только для печатной версии -->
                        <div class="checkbox checkbox-styled">
                            <label>
                                @if ($test['only_for_print'] == 1)
                                <input type="checkbox" name="only-for-print" id="only-for-print" checked>
                                @else
                                <input type="checkbox" name="only-for-print" id="only-for-print">
                                @endif
                                <span>Только для печатной версии</span>
                            </label>
                        </div>
                        <!-- Максимум баллов за тест -->
                        <div class="form-group">
                            <input type="number" min="1" step="0.5" name="total" id="total" class="form-control" value="{{ $test['total'] }}" required>
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

            <div class="col-md-5 col-sm-5">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-condensed" id="test-dates-table">
                            <tr>
                                <td>Группа</td>
                                <td>Доступность</td>
                            </tr>
                            @foreach ($test_for_groups as $group)
                                <input type="hidden" name="id-group[]" value="{{ $group['id_group'] }}">
                                <tr>
                                    <td>{{ $group['group_name'] }}</td>
                                    <td>
                                        <div class="checkbox checkbox-styled">
                                            <label>
                                                <input type="checkbox" name="availability[]" value="{{ $group['id_group'] }}"
                                                   @if ($group['availability'] == 1)
                                                       checked
                                                    @endif
                                                >
                                                <span></span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-3" id="edit-test">
                <button class="btn btn-primary btn-raised submit-test" type="submit">Применить изменения</button>
                <br><br>
            </div>
            @if ($test['test_type'] == 'Тренировочный' || $test['is_resolved'] == 0)
                <div class="col-md-3 col-sm-3">
                    <button class="btn btn-primary btn-raised submit-test" type="button" id="edit-test-structure">Изменить структуру</button>
                    <br><br>
                </div>
            @endif
        </form>
    </div>
    <div id="overlay" class="none">
        <div class="loading-pulse"></div>
    </div>
@stop
@section ('js-down')
{!! HTML::script('js/testEdit.js') !!}
@stop


