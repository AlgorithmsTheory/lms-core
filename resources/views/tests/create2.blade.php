@extends('templates.base')
@section('head')
<meta name="csrf_token" content="{{ csrf_token() }}" />
<title>Создание теста - шаг 2</title>
{!! HTML::style('css/createTest2.css') !!}
{!! HTML::style('css/loading_blur.css') !!}
@stop

@section('content')
<div class="section-body" id="page">
    <div class="col-md-12 col-sm-6 card style-primary text-center">
        <h1 class="">Создание теста - шаг 2</h1>
    </div>
    <form action="{{URL::route('test_add')}}" method="POST" class="form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="num-rows" name="num-rows" value="1">

        <!-- структурный блок -->
        <div class="col-md-12">
            <div class="card card-bordered style-primary card-collapsed">
                <div class="card-head">
                    <header>
                        Структура №1
                    </header>
                </div>
                <div class="card-body style-default-bright">
                    <div class="form-group dropdown-label col-md-4 col-sm-4">
                        <input type="number" min="1" step="1" name="number_of_questions[]" id="number_of_questions-1" class="form-control" required>
                        <label for="number_of_questions-1">Число вопросов</label>
                    </div>
                    <div class="form-group dropdown-label col-md-4 col-sm-4">
                        <input type="number" min="1" step="1" name="number_of_access_questions[]" id="number_of_access_questions-1" class="form-control" disabled>
                        <label for="number_of_access_questions-1">Доступно вопросов данной структуры</label>
                    </div>
                </div>

                <div class="card-body style-default-bright col-md-12 col-sm-12" id="sections_and_themes">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>Выберите разделы:</th>
                                <th>Выберите темы:</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="checkbox checkbox-styled">
                                        <label>
                                            <input type="checkbox" name="sections[]" id="section-1">
                                            <span>Формальные описания алгоритмов</span>
                                        </label>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td rowspan="8">
                                    <div class="checkbox checkbox-styled">
                                        <label>
                                            <input type="checkbox" name="sections[]" id="section-1">
                                            <span>Числовые множества и арифметические вычисления</span>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="checkbox checkbox-styled">
                                        <label>
                                            <input type="checkbox" name="themes[]" id="theme-1">
                                            <span>Мощность множеств</span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                
                                <td>
                                    <div class="checkbox checkbox-styled">
                                        <label>
                                            <input type="checkbox" name="themes[]" id="theme-1">
                                            <span>Счетные множества</span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                
                                <td>
                                    <div class="checkbox checkbox-styled">
                                        <label>
                                            <input type="checkbox" name="themes[]" id="theme-1">
                                            <span>Несчетные множества</span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                
                                <td>
                                    <div class="checkbox checkbox-styled">
                                        <label>
                                            <input type="checkbox" name="themes[]" id="theme-1">
                                            <span>Кантор и парадоксы</span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                
                                <td>
                                    <div class="checkbox checkbox-styled">
                                        <label>
                                            <input type="checkbox" name="themes[]" id="theme-1">
                                            <span>Вычислимость чисел</span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                
                                <td>
                                    <div class="checkbox checkbox-styled">
                                        <label>
                                            <input type="checkbox" name="themes[]" id="theme-1">
                                            <span>Арифметические функции</span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                
                                <td>
                                    <div class="checkbox checkbox-styled">
                                        <label>
                                            <input type="checkbox" name="themes[]" id="theme-1">
                                            <span>Частичные арифметические функции</span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                
                                <td>
                                    <div class="checkbox checkbox-styled">
                                        <label>
                                            <input type="checkbox" name="themes[]" id="theme-1">
                                            <span>Распознавание и сравнение функций</span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox checkbox-styled">
                                        <label>
                                            <input type="checkbox" name="sections[]" id="section-1">
                                            <span>Рекурсивные функции и сложность вычислений</span>
                                        </label>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox checkbox-styled">
                                        <label>
                                            <input type="checkbox" name="sections[]" id="section-1">
                                            <span>Сложность вычислений</span>
                                        </label>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-offset-10 col-md-2 col-sm-6" id="add-del-buttons">
            <button type="button" class="btn ink-reaction btn-floating-action btn-success" id="add-row"><b>+</b>   </button>
            <button type="button" class="btn ink-reaction btn-floating-action btn-danger" id="del-row"><b>-</b></button>
        </div>
        <div class="col-lg-offset-1 col-md-2 col-sm-6" id="add-test">
            <button class="btn btn-primary btn-raised submit-test" type="submit">Добавить тест</button>
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
{!! HTML::script('js/testCreateAndEdit.js') !!}
@stop


