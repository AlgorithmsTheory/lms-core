@extends('templates.base')
@section('head')
<meta name="csrf_token" content="{{ csrf_token() }}" />
<title>Создание теста</title>
{!! HTML::style('css/createTest.css') !!}
{!! HTML::style('css/loading_blur.css') !!}
@stop

@section('content')
    <div class="section-body" id="page">
        <div class="col-md-12 col-sm-6 card style-primary text-center">
            <h1 class="">Создать тест</h1>
        </div>

        <!-- модуль задания основных настроек теста -->
        <div class="col-lg-offset-1 col-md-10 col-sm-10 card style-gray">
            <h2 class="text-default-bright">Настройка теста</h2>
        </div>
        <form action="{{URL::route('test_finish_first_creation_step')}}" method="POST" class="form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" id="num-rows" name="num-rows" value="1">
            <div class="col-lg-offset-1 col-md-5 col-sm-5">
                <div class="card">
                    <div class="card-body">
                        <!-- название теста -->
                        <div class="form-group dropdown-label">
                            <textarea  name="test-name" class="form-control textarea1" rows="1" placeholder=""  required></textarea>
                            <label for="textarea1">Название теста</label>
                        </div>
                        <!-- тренировочный тест -->
                        <div class="checkbox checkbox-styled">
                            <label>
                                <input type="checkbox" name="training" id="training">
                                <span>Тренировочный тест</span>
                            </label>
                        </div>
                        <!-- адаптивный тест -->
                        <div class="checkbox checkbox-styled">
                            <label>
                                <input type="checkbox" name="adaptive" id="adaptive" disabled>
                                <span>Адаптивный тест</span>
                            </label>
                        </div>
                        <!-- Видимость теста -->
                        <div class="checkbox checkbox-styled">
                            <label>
                                <input type="checkbox" name="visibility" id="visibility" checked>
                                <span>Видимость</span>
                            </label>
                        </div>
                        <!-- Доступен на английском языке -->
                        <div class="checkbox checkbox-styled">
                            <label>
                                <input type="checkbox" name="multilanguage" id="multilanguage">
                                <span>Доступен на английском языке</span>
                            </label>
                        </div>
                        <!-- Только для печатной версии -->
                        <div class="checkbox checkbox-styled">
                            <label>
                                <input type="checkbox" name="only-for-print" id="only-for-print">
                                <span>Только для печатной версии</span>
                            </label>
                        </div>
                        <!-- Максимум баллов за тест -->
                        <div class="form-group dropdown-label">
                            <input type="number" min="1" step="0.5" name="total" id="total" class="form-control" required>
                            <label for="total">Максимум баллов за тест</label>
                        </div>
                        <!-- Время на прохождение теста -->
                        <div class="form-group dropdown-label">
                            <input type="number" min="1" name="test-time" id="test-time" class="form-control" required>
                            <label for="test-time">Время на прохождение теста в минутах для традиционного режима</label>
                        </div>
                        <!-- Максимальное число вопросов в адаптивном тесте -->
                        <div class="form-group dropdown-label">
                            <input type="number" min="1" max="100" name="max_questions" id="max_questions" class="form-control" required disabled>
                            <label for="max_questions">Максимальное число вопросов в адаптивном тесте</label>
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
                           @foreach ($groups as $group)
                                <input type="hidden" name="id-group[]" value="{{ $group['group_id'] }}">
                                <tr>
                                    <td>{{ $group['group_name'] }}</td>
                                    <td>
                                        <div class="checkbox checkbox-styled">
                                            <label>
                                                <input type="checkbox" name="availability[]" value="{{ $group['group_id'] }}">
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

            <div class="col-lg-offset-9 col-md-6 col-sm-6" id="add-test">
                <button class="btn btn-primary btn-raised submit-test" type="submit">Перейти к следующему шагу</button>
                <br><br>
            </div>
        </form>
    </div>
    <div id="overlay" class="none">
        <div class="loading-pulse"></div>
    </div>
@stop

@section('js-down')
    {!! HTML::script('js/testCreate.js') !!}
@stop


